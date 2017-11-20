<?php
/**
 * Class responsible for updating personal information
 *
 * @version 0.1 - Initial commit on New jobseeker portal
 * 
 * 02-18-2015 - Added Solr Candidates Syncer Functionality - Marlon Peralta
 * 
 */
require_once dirname(__FILE__)."/AbstractProcess.php";
require_once dirname(__FILE__)."/EditProcess.php";
require_once dirname(__FILE__)."/../forms/UpdateCandidateForm.php";
require_once dirname(__FILE__)."/../../conf/zend_smarty_conf.php";
class PersonalInformationProcess extends EditProcess{
	/**
	 * Renders content of page
	 */
	public function render(){
		$smarty = $this->smarty;
		$db = $this->db;
		$userid = $_SESSION["userid"];		
		$form = new UpdateCandidateProfileForm();
		$personal = $db->fetchRow($db->select()->from("personal")->where("userid = ?", $userid));
		
		foreach($personal as $key=>$value){
			try{
				if ($form->getElement($key)){
					$form->getElement($key)->setValue($value);						
				}
			}catch(Exception $e){
				
			}	
		}
		
		
		$sources = array("Jobstreet", "JobsDB", "Monster.com", "Employee Referral", "Job Fair", "Best Jobs", "Great Jobs", "Hiring Venue", "IT Pinoy", "Jobs Pen", "Jobspot PH", "Job Isaland", "Job Openings PH", "Job Philippines", "Locanto", "OLX", "Philippines JOB PH", "Pinoy Adster", "Resume Promo", "Sulit.com", "The Jobs Daily", "Web Geek PH", "Woop Ads", "Yello", "Facebook", "Linkein", "Tumblr", "Titter", "Skillspages", "Ayosdito", "Pinoy Exchange");
		if ($personal["external_source"]){
			if (!in_array($personal["external_source"], $sources)){
				$form->getElement("external_source")->setValue("Others");
				$form->getElement("external_source_others")->setValue($personal["external_source"]);
			}else{
				$form->getElement("external_source_others")->setValue("");
			}			
		}

		
		$this->syncUserInfo();
		$work_from_home_before = $user['work_from_home_before'];
			$start_worked_from_home=$user['start_worked_from_home'];
			$date=explode("and",$start_worked_from_home);
			$start_worked_from_home_year = trim(str_replace('years','',$date[0]));
			$start_worked_from_home_month = trim(str_replace('months','',$date[1]));
		
		
		//query all contracts
		$subcontractorsCount = $db->fetchRow($db->select()->from(array("s"=>"subcontractors"), array("COUNT(s.id) AS count"))
											->where("userid = ?",$userid)
											->where("status IN ('ACTIVE', 'suspended','resigned', 'terminated')"));
				
		if ($subcontractorsCount&&$subcontractorsCount["count"]>=1){
			if ($form->getElement("email")->getValue()==""||$form->getElement("email")->getValue()==null){
				
			}else{
			    $form->getElement("fname")->readonly = "readonly";
                $form->getElement("lname")->readonly = "readonly";
				$form->getElement("email")->readonly = "readonly";
			}
			
		}
	
		$smarty->assign_by_ref("form", $form);
		$this->setActive("personal_active");
		$this->setActive("resume_active");
		
		$smarty->display("personal_information.tpl");
		
	}

	/**
	 * Update the personal record of staff
	 */
	public function update(){
		$form = new UpdateCandidateProfileForm();
		$db = $this->db;
		$form->removeElement("state");
		
		//format data of skypes
		$data = array();
		if ($form->isValid($_POST)){
			$data =  $form->getValues();
			$data["state"] = $_POST["state"];
			
			
			//check if has unfinished email validation
			if ($_REQUEST["email"]){
				$emailPersonal = $db->fetchRow($db->select()->from("personal")->where("email = ?", $_REQUEST["email"])->where("userid <> ?", $_REQUEST["userid"]));
				if ($emailPersonal){
					if (trim($emailPersonal["fname"])!=""&&trim($emailPersonal["lname"])!=""){
						return array("error"=>"The email is already existing.", "success"=>false);
					}else if (trim($emailPersonal["fname"])==""&&trim($emailPersonal["lname"])==""){
						//ensure no currentjob education skills and others are involved before deletion
						$currentjob = $db->fetchRow($db->select()->from(array("c"=>"currentjob"))->where("userid = ?", $emailPersonal["userid"]));
						$education = $db->fetchRow($db->select()->from(array("e"=>"education"))->where("userid = ?", $emailPersonal["userid"]));
						$skills = $db->fetchRow($db->select()->from(array("s"=>"skills"))->where("userid = ?", $emailPersonal["userid"]));
						$language = $db->fetchRow($db->select()->from(array("l"=>"language"))->where("userid = ?", $emailPersonal["userid"]));
						if ($currentjob||$education||$skills||$language){
							return array("error"=>"Something went wrong.", "success"=>false);
						}else{
							$db->delete("personal", $db->quoteInto("userid = ?", $emailPersonal["userid"]));
							
						}
					}
				}
				
			}
			if ($data["external_source"]=="Others"&&trim($data["external_source_others"])!=""){
				$data["external_source"] = $data["external_source_others"];
			}
			unset($data["external_source_others"]);
			
			$datetime = date("Y-m-d")." ".date("H:i:s");
			$userid = $_REQUEST["userid"];
			//before
			$old = $db->fetchRow($db->select()->from(array("p"=>"personal"))->where("userid = ?", $_REQUEST["userid"]));
			unset($old["dateupdated"]);
			
			$data["dateupdated"] = $datetime;
			$db->update("personal", $data, $db->quoteInto("userid = ?", $_REQUEST["userid"]));
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$REQUEST["userid"]));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://api.remotestaff.com.au/solr-index/sync-candidates/");
							}
			
			$new = $db->fetchRow($db->select()->from(array("p"=>"personal"))->where("userid = ?", $_REQUEST["userid"]));
			unset($new["dateupdated"]);
			
			$difference = array_diff_assoc($old,$new);
			
			$history_changes = "";
			if( count($difference) > 0){
				foreach(array_keys($difference) as $array_key){
					$history_changes .= sprintf("[%s] from %s to %s,\n", $array_key, $old[$array_key] , $new[$array_key]);
				}
				include_once "../time.php";
				
				$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s")));
				
			}
			$this->success = true;
			$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
			
			global $base_api_url;
			
			file_get_contents($base_api_url . "/solr-index/sync-candidates/");
			
			file_get_contents($base_api_url . "/mongo-index/sync-candidates-files/?userid=" . $userid);
			
			file_get_contents($base_api_url . "/mongo-index/sync-all-candidates?userid=" . $userid);
			
			if(isset($_REQUEST["email"])){
				file_get_contents($base_api_url . "/mongo-index/sync-login-credentials?email=" . $_REQUEST["email"]);
			}
			
			return array("success"=>true);
		}else{
			$this->errors = $form->getErrors();
			return array("errors"=>$this->errors, "success"=>false);
		}
	}
	
}
