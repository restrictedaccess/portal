<?php
/**
 * Class responsible for updating current job
 *
 * @version 0.1 - Initial commit on New jobseeker portal
 * 
 * 02-18-2015 - Added Solr Candidates Syncer Functionality - Marlon Peralta
 * 
 */
require_once dirname(__FILE__)."/AbstractProcess.php";
require_once dirname(__FILE__)."/EditProcess.php";
require_once dirname(__FILE__)."/../../lib/htmlpurifier-4.5.0-standalone/HTMLPurifier.standalone.php";
require_once dirname(__FILE__)."/../../conf/zend_smarty_conf.php";
class CurrentJobProcess extends EditProcess{
	
	
	public function process(){
		global $base_api_url;
		
		global $curl;
		
		global $transport;
		$db = $this->db;
		$userid = $_SESSION['userid'];
		//load user from db
		$data = $_POST;
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
		
		for($i=1;$i<=10;$i++){
			if ($db_column_suffix>10){
				continue;
			}
			if($i==1){
				$db_column_suffix = "";
				
			}else{
				$db_column_suffix = $i;
			}
			if ($data["monthto".$db_column_suffix]=="Present"&&$data["yearto".$db_column_suffix]=="Present"){
				if (!$happened){
					$smarty = new Smarty();
					//get the candidate fullname
					
					$pers = $db->fetchRow($db->select()->from(array("p"=>"personal"), array("fname", "lname", "email"))->where("userid = ?", $userid));
					if ($pers){
						if (!isset($_SESSION["sent_email"])){
							if ($pers["fname"]==""&&$pers["lname"]==""){
								$smarty->assign("candidate_fullname", "Applicant");
							}else{
								$smarty->assign("candidate_fullname", $pers["fname"]." ".$pers["lname"]);
							}
							$output = $smarty->fetch("currently_employed.tpl");
							$mail = new Zend_Mail();
							if (TEST){
								$mail->setSubject("TEST - Updates on your Application at Remotestaff");
							}else{
								$mail->setSubject("Updates on your Application at Remotestaff");			
							}
							$mail->setFrom("recruitment@remotestaff.com.au","recruitment@remotestaff.com.au");
							$mail->setBodyHtml($output);
							if (TEST){
								$mail->addTo("devs@remotestaff.com.au");
							}else{
								$mail->addTo($pers["email"]);
							}
							$mail->send($transport);
							$happened = true;			
							$_SESSION["sent_email"] = true;	
						}
						
					}
		
				}
			}
			
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
		}else{
			unset($data["id"]);
			$db->update("currentjob", $data, $db->quoteInto("userid = ?", $userid));
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
			
			$curl->get($base_api_url . "/solr-index/sync-candidates/");
			
			$new = $db->fetchRow($db->select()->from("currentjob")->where("userid = ?", $userid));
			
			$difference = array_diff_assoc($old,$new);
			
			$history_changes = "";
			if( count($difference) > 0){
				foreach(array_keys($difference) as $array_key){
					$history_changes .= sprintf("[%s] from %s to %s,\n", $array_key, $old[$array_key] , $new[$array_key]);
				}
				include_once "../time.php";
				
				$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s")));
				
			
			
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
							
							file_get_contents($base_api_url . "/solr-index/sync-candidates/");
							
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
		
		$curl->get($base_api_url . "/mongo-index/sync-all-candidates", array("userid" => $_SESSION["userid"], "sync_from_old_data" => true));
		
		


		$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));
		$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
		
		$curl->get($base_api_url . "/solr-index/sync-candidates/");
		
		
		
		
		//$this->save_to_new_database($_POST);
		
		header("Location:/portal/jobseeker/work_experience.php?success=1");
		
	}
	
	
	private function save_to_new_database($post_data){
		$db = $this->db;
		
		//echo "<pre>";print_r($post_data);die;
		
		$work_preferences_data = array(
			"latest_job_title" => $post_data["latest_job_title"]
		);
		
		if(isset($post_data["freshgrad"])){
			if($post_data["freshgrad"] == 1){
				//I am a fresh graduate seeking my first job
				$work_preferences_data["freshgrad"] = 1;
				$work_preferences_data["intern_status"] = 0;
				$work_preferences_data["years_worked"] = 0;
				$work_preferences_data["months_worked"] = 0;
			}
			
			if($post_data["freshgrad"] == 0){
				//I have been working for    year(s) and   month(s)
				$work_preferences_data["freshgrad"] = 0;
				$work_preferences_data["intern_status"] = 0;
				$work_preferences_data["years_worked"] = $post_data["years_worked"];
				$work_preferences_data["months_worked"] = $post_data["years_worked"];
			}
			
			if($post_data["freshgrad"] == 2){
				//I am still pursuing my studies and seeking internship or part-time jobs
				$work_preferences_data["freshgrad"] = 0;
				$work_preferences_data["intern_status"] = 1;
				$work_preferences_data["years_worked"] = 0;
				$work_preferences_data["months_worked"] = 0;
			}
		}
		
		
		
		if(isset($post_data["available_status"])){
			if($post_data["available_status"] == 'a'){
				//I can start work after   week(s) of notice period
				//START_WORK_AFTER_NOTICE_PERIOD
				$work_preferences_data["work_availability_status"] = "START_WORK_AFTER_NOTICE_PERIOD";
				$work_preferences_data["notice_period"] = $post_data["available_notice"];
				$work_preferences_data["available_date"] = "";
			}
			
			if($post_data["available_status"] == 'b'){
				//I can start work after 
				$work_preferences_data["work_availability_status"] = "START_WORK_AFTER_DATE";
				
				$available_date = $post_data["ayear"] . "-" . $post_data["amonth"] . "-" . $post_data["aday"];
				
				$available_date = date("Y-m-d", strtotime($available_date));
				
				$work_preferences_data["available_date"] = $available_date;
				
				$work_preferences_data["notice_period"] = "";
			}
			
			if($post_data["available_status"] == 'p'){
				//I am not actively looking for a job now
				$work_preferences_data["work_availability_status"] = "NOT_ACTIVELY_LOOKING";
				$work_preferences_data["available_date"] = "";
				$work_preferences_data["notice_period"] = "";
			}
			
			if($post_data["available_status"] == 'Work Immediately'){
				//Work Immediately
				$work_preferences_data["work_availability_status"] = "WORK_IMMEDIATELY";
				$work_preferences_data["available_date"] = "";
				$work_preferences_data["notice_period"] = "";
			}
			
			
		}
		
		
		if(isset($post_data["expected_salary_neg"])){
			if($post_data["expected_salary_neg"] == "Yes"){
				$work_preferences_data["negotiable"] = 1;
			} else{
				$work_preferences_data["negotiable"] = 0;
			}
		}
		
		if(isset($post_data["expected_salary"])){
			$work_preferences_data["expected_salary"] = $post_data["expected_salary"];
		}
		
		
		if(isset($post_data["salary_currency"])){
			$work_preferences_data["salary_currency"] = $post_data["salary_currency"];
		}
		
		
		
		
		//START POSITION CHOICES
		$position_choices_data = array();
		
		$position_choices_data["candidate_id"] = $_SESSION["userid"];
		
		
		
		if(isset($post_data["position_first_choice"])){
			
			//Save first choice
			$position_choices_data["choice_number"] = 0;
			$position_choices_data["position_id"] = $post_data["position_first_choice"];
			
			$exprienced = 0;
			
			
			
			if(isset($post_data["position_first_choice_exp"])){
				if($post_data["position_first_choice_exp"] == "Yes"){
					$exprienced = 1;
				}
			}
			
			$position_choices_data["experienced"] = $exprienced;
			$first_choice_record = $db->fetchRow(
				$db->select()
				->from("candidate_position_choices", array("id"))
				->where("candidate_id = ?", $_SESSION["userid"])
				->where("position_id = ?", $post_data["position_first_choice"])
			);
			
			if(!empty($first_choice_record)){
				$db->update("candidate_position_choices", $position_choices_data, array("id = ?" => $first_choice_record["id"]));
			} else{
				$db->insert("candidate_position_choices", $position_choices_data);
			}
		}
		
		
		
		
		
		if(isset($post_data["position_second_choice"])){
			//Save second choice
			$position_choices_data["choice_number"] = 1;
			$position_choices_data["position_id"] = $post_data["position_second_choice"];
			
			$exprienced = 0;
			
			if(isset($post_data["position_second_choice_exp"])){
				if($post_data["position_second_choice_exp"] == "Yes"){
					$exprienced = 1;
				}
			}
			
			$position_choices_data["experienced"] = $exprienced;
			
			$second_choice_record = $db->fetchRow(
				$db->select()
				->from("candidate_position_choices", array("id"))
				->where("candidate_id = ?", $_SESSION["userid"])
				->where("position_id = ?", $post_data["position_second_choice"])
			);
			
			if(!empty($second_choice_record)){
				$db->update("candidate_position_choices", $position_choices_data, array("id = ?" => $second_choice_record["id"]));
			} else{
				$db->insert("candidate_position_choices", $position_choices_data);
			}
		}
		
		
		
		
		if(isset($post_data["position_third_choice"])){
			//Save third choice
			$position_choices_data["choice_number"] = 2;
			$position_choices_data["position_id"] = $post_data["position_third_choice"];
			
			$exprienced = 0;
			
			if(isset($post_data["position_third_choice_exp"])){
				if($post_data["position_third_choice_exp"] == "Yes"){
					$exprienced = 1;
				}
			}
			
			$position_choices_data["experienced"] = $exprienced;
			
			$third_choice_record = $db->fetchRow(
				$db->select()
				->from("candidate_position_choices", array("id"))
				->where("candidate_id = ?", $_SESSION["userid"])
				->where("position_id = ?", $post_data["position_third_choice"])
			);
			
			if(!empty($third_choice_record)){
				$db->update("candidate_position_choices", $position_choices_data, array("id = ?" => $third_choice_record["id"]));
			} else{
				$db->insert("candidate_position_choices", $position_choices_data);
			}
		}
		//END POSITION CHOICES
		
		
		
		
		
		
		$old_employment_history = $db->fetchAll(
			$db->select()
			->from("candidate_employment_history", array("id"))
			->where("candidate_id = ?", $_SESSION["userid"])
		);
		
		
		//START EMPLOYMENT HISTORY
		for ($index=1; $index <= 10; $index++) {
			$employment_history_data = array();
			
		 	$employment_history_data["candidate_id"] = $_SESSION["userid"];
		 	$employment_history_data["ordering"] = $index;
			$employment_history_data["column_index"] = $index;
			
			
			$is_deleted = false;
			
			if($index == 1){
				
				$employment_history_data["company_name"] = $post_data["companyname"];
				$employment_history_data["position"] = $post_data["position"];
				$employment_history_data["month_from"] = $post_data["monthfrom"];
				$employment_history_data["year_from"] = $post_data["yearfrom"];
				$employment_history_data["month_to"] = $post_data["monthto"];
				$employment_history_data["year_to"] = $post_data["yearto"];
				$employment_history_data["description"] = $post_data["duties"];
			} else{
				$employment_history_data["company_name"] = $post_data["companyname" . $index];
				$employment_history_data["position"] = $post_data["position" . $index];
				$employment_history_data["month_from"] = $post_data["monthfrom" . $index];
				$employment_history_data["year_from"] = $post_data["yearfrom" . $index];
				$employment_history_data["month_to"] = $post_data["monthto" . $index];
				$employment_history_data["year_to"] = $post_data["yearto" . $index];
				$employment_history_data["description"] = $post_data["duties" . $index];
			}
			
			$employment_history_data["work_setup"] = $post_data["work_setup_type_" . $index];
			$employment_history_data["industry_id"] = $post_data["industry_id_" . $index];
			$employment_history_data["starting_grade"] = $post_data["starting_salary_grade_" . $index];
			$employment_history_data["ending_grade"] = $post_data["ending_salary_grade_" . $index];
			$employment_history_data["benefits"] = $post_data["benefits_" . $index];
			$employment_history_data["is_deleted"] = 0;
			
			if(!empty($old_employment_history)){
				if($index == 1){
					if(empty($post_data["companyname"])){
						//$employment_history_data = array();
						$employment_history_data["is_deleted"] = 1;
					}
				} else{
					if(empty($post_data["companyname" . $index])){
						//$employment_history_data = array();
						$employment_history_data["is_deleted"] = 1;
					}
				}
				
				$db->update(
					"candidate_employment_history", 
					$employment_history_data, 
					array(
						$db->quoteInto("candidate_id = ?", $_SESSION["userid"]), 
						$db->quoteInto("column_index = ?", $index)
					)
				);
			} else{
				$db->insert("candidate_employment_history", $employment_history_data);
			}
			
		}
		
		//END EMPLOYMENT HISTORY
		
		
		$old_record = $db->fetchRow(
			$db->select()
			->from("candidate_work_preferences", array("id"))
			->where("candidate_id = ?", $_SESSION['userid'])
		);
		
		$rows_affected = 0;
		
		if(!empty($old_record)){
			//update
			$rows_affected = $db->update("candidate_work_preferences", $work_preferences_data, array("candidate_id = ?" => $_SESSION["userid"]));
		} else{
			$rows_affected = $db->insert("candidate_work_preferences", $work_preferences_data);
		}
		
	}


	/**
	 * Get All subcategory under the given category
	 */
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

	/**
	 * Get All Categories
	 */
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
		global $base_api_url;
		$smarty = $this->smarty;
		$db = $this->db;
		$userid = $_SESSION["userid"];
		$currentjob = $db->fetchRow($db->select()->from("currentjob")->where("userid = ?", $userid));
		$salary_grades = $db->fetchAll($db->select()->from("previous_job_salary_grades")->where("userid = ?", $userid));
		$previous_job_industries = $db->fetchAll($db->select()->from("previous_job_industries")->where("userid = ?", $userid));
		$defined_industries = $db->fetchAll($db->select()->from("defined_industries"));
		
		$json_employment_history = file_get_contents($base_api_url . "/candidates/get-candidates-profile?section=employment_history&candidate_id=" . $userid);
		
		$employment_history_decoded = json_decode($json_employment_history, true);
		
				
		
		
		if (isset($_GET["success"])){
			$smarty->assign("success", "true");
		}else{
			$smarty->assign("success", "false");
		}
		
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
		
		/*
		if($employment_history_decoded["success"]){
			
			$salary_grades = array();
			$previous_job_industries = array();
			
			$employment_histories = $employment_history_decoded["result"]["employment_history"]["details"]["employment_history"];
			
			//LOOP 10 times for each currentjob data
			for ($i=1; $i <= 10; $i++) { 
				if(isset($employment_histories[$i - 1])){
					$employment_history = $employment_histories[$i - 1];
					
					if(!$employment_history["is_deleted"]){
						//CREATE SALARY_GRADE ARRAY FROM MONGO
						$salary_grades[] = array(
							"starting_grade" => $employment_history["starting_grade"],
							"ending_grade" => $employment_history["ending_grade"],
							"benefits" => $employment_history["benefits"],
							"index" => $i
						);
						
						//CREATE PREVIOUS JO INDUSTRIES
						$previous_job_industries[] = array(
							"work_setup_type" => $employment_history["work_setup"],
							"industry_id" => $employment_history["industry_id"],
							"index" => $i
						);
					}
				}
			}
			
			
			
			/*
			echo "<pre>";
			print_r($employment_histories);
			
			exit;
		}
		*/
		$smarty->assign("salary_grades", $salary_grades);
		$smarty->assign("previous_job_industries", $previous_job_industries);
		$smarty->assign("defined_industries", $defined_industries);
		$smarty->assign("work_types", $work_types);
		
		$smarty->assign("currentjob", $currentjob);
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
		$this->syncUserInfo();
		$this->setActive("work_experience_active");
		$this->setActive("resume_active");
		$smarty->display("current_job.tpl");
	}
	
	
	/**
	 * Responsible for generating Position Experience
	 */
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
