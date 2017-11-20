<?php
/**
 * 
 * Class responsible for updating working history
 *
 * @version 0.1 - Initial commit on Staff Information
 * 
 * 02-18-2015 - Added Solr Candidates Syncer Functionality - Marlon Peralta
 * 
 */
require_once dirname(__FILE__)."/AbstractProcess.php";
require_once dirname(__FILE__)."/../../lib/htmlpurifier-4.5.0-standalone/HTMLPurifier.standalone.php";

class UpdateCurrentJobProcess extends AbstractProcess{
	private $errors;
	private $success = false;
	
	public function __construct($db){
		$this->db = $db;
		$this->smarty = new Smarty();
		$this->errors = array();
		$this->authCheck();
	}
	
	
	protected function authCheck(){
	
		session_start();
		if (!isset($_SESSION["admin_id"])){
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				die;
			}else{
				header("location:/portal/index.php");
			}
		}
	}	
	
	
	public function process(){
		$db = $this->db;
		$userid = $_REQUEST['userid'];
		//load user from db
		$data = $_POST;
		global $base_api_url;
			
		global $curl;
		//remove character reference fields
		unset($data["name"]);
		unset($data["contact_details"]);
		unset($data["contact_number"]);
		unset($data["email_address"]);
		
		$config = HTMLPurifier_Config::createDefault();
		$config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
		$config->set('HTML.TidyLevel', 'heavy'); 
		$config->set('HTML.TidyRemove', 'br@clear');
		$purifier = new HTMLPurifier($config);
		$data["duties"] =  $purifier->purify($data["duties"]);
		
		for($i=2;$i<=10;$i++){
			$data["duties".$i] =  $purifier->purify($data["duties".$i]);			
		}
		
		//salary grades update
		$db->delete("previous_job_salary_grades", $db->quoteInto("userid = ?", $userid));
		$db->delete("previous_job_industries", $db->quoteInto("userid = ?", $userid));
		
		for($i=1;$i<=10;$i++){
			$salary_grade = array(
							"userid"=>$userid,
							"starting_grade"=>$_REQUEST["starting_salary_grade_".$i],
							"ending_grade"=>$_REQUEST["ending_salary_grade_".$i],
							"benefits"=>$_REQUEST["benefits_".$i],
							"date_updated"=>date("Y-m-d H:i:s"),
							"date_created"=>date("Y-m-d H:i:s"),
							"index"=>$i
						);
						
			$db->insert("previous_job_salary_grades", $salary_grade);
			
			$item = array(
							"userid"=>$userid,
							"work_setup_type"=>$_REQUEST["work_setup_type_".$i],
							"industry_id"=>$_REQUEST["industry_id_".$i],
							"campaign"=>$_REQUEST["campaign_".$i],
							"date_created"=>date("Y-m-d H:i:s"),
							"index"=>$i
						);
								
			
			$db->insert("previous_job_industries", $item);
			
			unset($data["work_setup_type_".$i]);
			unset($data["industry_id_".$i]);
			unset($data["campaign_".$i]);
			unset($data["starting_salary_grade_".$i]);
			unset($data["ending_salary_grade_".$i]);
			unset($data["benefits_".$i]);	
		}
		
		
		//check if user has current job
		$old = $db->fetchRow($db->select()->from("currentjob")->where("userid = ?", $userid));
		if (!$old){
			$db->insert("currentjob", $data);
			//$curl->get($base_api_url . "/mongo-index/sync-all-candidates/", array("userid" => $userid, "sync_from_old_data" => true));
		}else{
			unset($data["id"]);
			$db->update("currentjob", $data, $db->quoteInto("userid = ?", $userid));
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
			
			
			$curl->get($base_api_url . "/solr-index/sync-candidates/");
			//$curl->get($base_api_url . "/mongo-index/sync-all-candidates/", array("userid" => $userid, "sync_from_old_data" => true));
			/*
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
							}
			 * 
			 */
			$new = $db->fetchRow($db->select()->from("currentjob")->where("userid = ?", $userid));
			
			$difference = array_diff_assoc($old,$new);
			
			$history_changes = "";
			if( count($difference) > 0){
				foreach(array_keys($difference) as $array_key){
					$history_changes .= "[{$array_key}] from {$old[$array_key]} to {$new[$array_key]},\n";
				}
				include_once "../time.php";
				
				$changeByType = $_SESSION["status"];
				if ($changeByType=="FULL-CONTROL"){
					$changeByType = "ADMIN";
				}
				
				$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
				
			
			
			}
			
		}
		
		$cj = $db->fetchRow($db->select()->from("currentjob")->where("userid = ?", $userid));
		$counter = 0;
		for($i=1;$i<=10;$i++){
			$suffix = $i;
			if ($i==1){
				$suffix = "";
			}
			if (!(trim($cj["companyname".$suffix])==""||trim($cj["position".$suffix])==""||trim($cj["duties".$suffix])=="")){
				$counter++;
			}
		}
		if ($counter<=5&&$counter>0){
			$this->subtractRemoteReadyScore($userid, 4);	
//			$db->delete("remote_ready_criteria_entries", "remote_ready_criteria_id = 4 AND userid = ".$userid);
		
			$counter = 0;
			for($i=1;$i<=10;$i++){
				$suffix = $i;
				if ($i==1){
					$suffix = "";
				}
				if (!(trim($cj["companyname".$suffix])==""||trim($cj["position".$suffix])==""||trim($cj["duties".$suffix])=="")){
					if ($counter!=5){
						$data = array();
						$data["userid"] = $userid;
						$data["remote_ready_criteria_id"] = 4;
						$data["date_created"] = date("Y-m-d H:i:s");
//						$db->insert("remote_ready_criteria_entries", $data);
						$counter++;
					}
				}
			}
		}
		//character reference save
		$names = $_POST["name"];
		$contact_details = $_POST["contact_details"];
		$contact_numbers = $_POST["contact_number"];
		$email_addresses = $_POST["email_address"];
		if (!empty($names)){
			$ids = $_POST["id"];
			$db->delete("character_references", $db->quoteInto("userid = ?", $userid));
		
			foreach($names as $key=>$name){
				if ($name){
					$data = array();
					$data["name"] = $name;
					if ($contact_details[$key]){
						$data["contact_details"] = $contact_details[$key];
					}
					if ($email_addresses[$key]){
						$data["email_address"] = $email_addresses[$key];
	 				}
					if ($contact_numbers[$key]){
						$data["contact_number"] = $contact_numbers[$key];
					}
					$data["userid"] = $_REQUEST["userid"];
					
					if ($ids[$key]){
						$row = $db->fetchRow($db->select()->from(array("cr"=>"character_references"), array("id"))->where("cr.id = ?", $ids[$key]));	
						if ($row){
							$data["date_updated"] = date("Y-m-d H:i:s");
							$db->update("character_references", $data, $db->quoteInto("id = ?", $ids[$key]));
							$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
							$curl->get($base_api_url . "/solr-index/sync-candidates/");
							/*
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
							}*/				
						}else{
							$data["date_created"] = date("Y-m-d H:i:s");
							$db->insert("character_references", $data);	
						}
					}else{
						$data["date_created"] = date("Y-m-d H:i:s");
						$db->insert("character_references", $data);
					}
							
				}
			}
		}
		$currentjob = $db->fetchRow($db->select()->from(array("c"=>"currentjob"))->where("c.userid = ?", $userid));
		if ($currentjob){
			$db->delete("personal_categorization_entries", $db->quoteInto("userid = ?", $userid));
			if ($currentjob["position_first_choice"]){
				$row = $db->fetchRow($db->select()->from(array("pce"=>"personal_categorization_entries"), array("id"))->where("pce.sub_category_id = ?", $currentjob["position_first_choice"])->where("pce.userid = ?", $currentjob["userid"]));
				if (!$row){
					$category = $db->fetchRow($db->select()->from("job_sub_category")->where("sub_category_id = ?", $currentjob["position_first_choice"]));
					$db->insert("personal_categorization_entries", array("userid"=>$userid, "sub_category_id"=>$currentjob["position_first_choice"], "category_id"=>$category["category_id"]));
				}
			}
			if ($currentjob["position_second_choice"]){
				$row = $db->fetchRow($db->select()->from(array("pce"=>"personal_categorization_entries"), array("id"))->where("pce.sub_category_id = ?", $currentjob["position_second_choice"])->where("pce.userid = ?", $currentjob["userid"]));
				if (!$row){
					$category = $db->fetchRow($db->select()->from("job_sub_category")->where("sub_category_id = ?", $currentjob["position_second_choice"]));
					$db->insert("personal_categorization_entries", array("userid"=>$userid, "sub_category_id"=>$currentjob["position_second_choice"], "category_id"=>$category["category_id"]));
				}
			}
			if ($currentjob["position_third_choice"]){
				$row = $db->fetchRow($db->select()->from(array("pce"=>"personal_categorization_entries"), array("id"))->where("pce.sub_category_id = ?", $currentjob["position_third_choice"])->where("pce.userid = ?", $currentjob["userid"]));
				if (!$row){
					$category = $db->fetchRow($db->select()->from("job_sub_category")->where("sub_category_id = ?", $currentjob["position_third_choice"]));
					$db->insert("personal_categorization_entries", array("userid"=>$userid, "sub_category_id"=>$currentjob["position_third_choice"], "category_id"=>$category["category_id"]));
				}
			}	
		}
		
		$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));
		$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
		$curl->get($base_api_url . "/solr-index/sync-candidates/");
		/*
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-candidates/");
							}
		 * 
		 */	
		echo "<script>alert('Profile has been updated');window.opener.location.reload();window.close();</script>";
		
	}
	
	private function getSubCategories($category_id){

		$db = $this->db;
		$select = "SELECT sub_category_id, sub_category_name
				FROM job_sub_category 
				WHERE category_id='".$category_id."' 
				ORDER BY sub_category_name";
		$rows = $db->fetchAll($select);

		$subcategories = array();
		foreach($rows as $row){
			$subcategories[$row['sub_category_id']]['category_name'] = $row['sub_category_name'];
		}
		return $subcategories;
	}

	private function getCategories($category = null){

		$db = $this->db;

		$category_filter = '';
		if($category != null){
			$category_filter = 'and  category_id = '.$category;
		}

		$select="SELECT category_id, category_name FROM job_category
			WHERE status='posted' ".$category_filter." 
			ORDER BY category_name";
		$rows = $db->fetchAll($select);

		$categories = array();
		foreach($rows as $row){
			$category = array();
			$category['category']['id'] = $row['category_id'];
			$category['category']['name'] = $row['category_name'];
			$categories[] = $category;
		}
		return $categories;
	}
	
	
	
	
	public function render(){
		$smarty = $this->smarty;
		$db = $this->db;
		$userid = $_REQUEST["userid"];
		$currentjob = $db->fetchRow($db->select()->from("currentjob")->where("userid = ?", $userid));
		$salary_grades = $db->fetchAll($db->select()->from("previous_job_salary_grades")->where("userid = ?", $userid));
		$previous_job_industries = $db->fetchAll($db->select()->from("previous_job_industries")->where("userid = ?", $userid));
		$defined_industries = $db->fetchAll($db->select()->from("defined_industries"));
		
		$month_array = Array('', 'Present', 'JAN', 'FEB', 'MAR', 'APR',
		    'MAY', 'JUN', 'JUL', 'AUG', 'SEP',
		    'OCT', 'NOV', 'DEC');
		$currency_array = Array("Australian Dollar","Bangladeshi Taka",
		    "British Pound","Chinese RenMinBi","Euro","HongKong Dollar",
		    "Indian Rupees","Indonesian Rupiah","Japanese Yen",
		    "Malaysian Ringgit","New Zealand Dollar","Philippine Peso",
		    "Singapore Dollar","Thai Baht","US Dollars","Vietnam Dong");  
			
		$work_types = array("Office Based", "Home Based", "Office and Home Based", "Outside the Philippines");
			
		$categories = $this->getCategories();
		$position_first_choice_options = "<option value=''>Select Position</option>";
		$position_second_choice_options = "<option value=''>Select Position</option>";
		$position_third_choice_options = "<option value=''>Select Position</option>";

		foreach($categories as $key=>$category){

			$categories[$key]['subcategories'] = $this->getSubCategories($category['category']['id']);
			$position_first_choice_options .= "<optgroup label='".$category['category']['name']."'>";;
			$position_second_choice_options .= "<optgroup label='".$category['category']['name']."'>";;
			$position_third_choice_options .= "<optgroup label='".$category['category']['name']."'>";;
			foreach($categories[$key]['subcategories'] as $key2=>$subcategory){

				//create sub-categories option
				$selected = "";
				
				if($subcategory['category_name'] != ''){
					if ($key2==$currentjob["position_first_choice"]){
						$position_first_choice_options .= "<option value='".$key2."' selected>".$subcategory['category_name']."</option>";
					}else{
						$position_first_choice_options .= "<option value='".$key2."'>".$subcategory['category_name']."</option>";
					}
					if ($key2==$currentjob["position_second_choice"]){
						$position_second_choice_options .= "<option value='".$key2."' selected>".$subcategory['category_name']."</option>";
					}else{
						$position_second_choice_options .= "<option value='".$key2."'>".$subcategory['category_name']."</option>";
						
					}
					if ($key2==$currentjob["position_third_choice"]){
						$position_third_choice_options .= "<option value='".$key2."' selected>".$subcategory['category_name']."</option>";	
					}else{
						$position_third_choice_options .= "<option value='".$key2."'>".$subcategory['category_name']."</option>";	
					}
				}
					
			}
			$position_first_choice_options .= "</optgroup>";
			$position_second_choice_options .= "</optgroup>";
			$position_third_choice_options .= "</optgroup>";
		}
		$smarty->assign("currentjob", $currentjob);
		$smarty->assign("salary_grades", $salary_grades);
		$smarty->assign("previous_job_industries", $previous_job_industries);
		$smarty->assign("defined_industries", $defined_industries);
		$smarty->assign("work_types", $work_types);
		
		$smarty->assign("currency_array", $currency_array);
		$smarty->assign('month_array', $month_array);
		$smarty->assign("position_first_choice_options", $position_first_choice_options);
		$smarty->assign("position_second_choice_options", $position_second_choice_options);
		$smarty->assign("position_third_choice_options", $position_third_choice_options);
		$position_first_choice_exp_options = $this->generatePositionExperienceOptions($currentjob["position_first_choice_exp"],"position_first_choice_exp");
		$position_second_choice_exp_options = $this->generatePositionExperienceOptions($currentjob["position_second_choice_exp"],"position_second_choice_exp");
		$position_third_choice_exp_options = $this->generatePositionExperienceOptions($currentjob["position_third_choice_exp"],"position_third_choice_exp");
		$smarty->assign('position_first_choice_exp_options',$position_first_choice_exp_options);
		$smarty->assign('position_second_choice_exp_options',$position_second_choice_exp_options);
		$smarty->assign('position_third_choice_exp_options',$position_third_choice_exp_options);
		$now = new DateTime();
		$current_year = $now->format('Y') + 1;
		$smarty->assign('current_year', $current_year);
		$smarty->assign("userid", $userid);
		$character_references = $db->fetchAll($db->select()->from(array("cr"=>"character_references"))->where("userid = ?",$userid));
		$smarty->assign("character_references", $character_references);
		$smarty->display("updatecurrentjob.tpl");
	}
	
	
	private function generatePositionExperienceOptions($position_exp,$name){
		if($position_exp=="Yes"){
			$is_yes_checked="checked='checked'";
			$is_no_checked="";
		}
		else{
			$is_yes_checked="";
			$is_no_checked="checked='checked'";
		}
		return '<input type="radio" name="'.$name.'"  id="'.$name.'" value="Yes" '.$is_yes_checked.' /> yes
		<input type="radio" name="'.$name.'"  id="'.$name.'" value="No" '.$is_no_checked.' /> no ';
	}
	
}