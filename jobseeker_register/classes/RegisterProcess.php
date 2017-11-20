<?php
require_once dirname(__FILE__)."/../../application/classes/SkillTestEmail.php";
require_once dirname(__FILE__)."/../../lib/Curl.php";
class RegisterProcess{
	private $db;
	
	public function __construct($db){
		$this->db = $db;
		$this->smarty = new Smarty();
	}
        
	
	public function generateValidationEmail(){
		$db = $this->db;
		
		$email = $_REQUEST["email"];
		
		if (!$this->alreadyRegistered($email)){
			$expiration_date = date("Y-m-d H:i:s");
			$hashcode = $this->getHashCode();
			$data = array(
				"email"=>$email,
				"hashcode"=>$hashcode,
				"expiration_date"=>date("Y-m-d H:i:s", strtotime($expiration_date." +1 day")),
				"date_created"=>date("Y-m-d H:i:s"),
				"validated"=>0
			);
			
			$db->insert("jobseeker_email_validations", $data);		
			
			$emailTemplate = new Smarty();
			$emailTemplate->assign("hash", $hashcode);
			if (TEST){
				$emailTemplate->assign("base_url", "http://devs.remotestaff.com.ph");
			}else{
				if ($_SERVER["SERVER_NAME"]=="staging.remotestaff.com.au" || STAGING){
					$emailTemplate->assign("base_url", "http://staging.remotestaff.com.ph");									
				}else{
					$emailTemplate->assign("base_url", "http://remotestaff.com.ph");									
				}
			}
			$body = $emailTemplate->fetch("email_validation.tpl");
			
			
			$subject = "Remote Staff Applicant's Registration Code";
			$attachments_array = NULL;
			$bcc_array = array();
			$cc_array = array();
			$sender =  "Remote Staff Recruitment<recruitment@remotestaff.com.au>";
			$reply =  "Remote Staff Recruitment<recruitment@remotestaff.com.au>";
			
			$from = "Remote Staff Recruitment<recruiters@remotestaff.com.ph>";
			$html = $body;
			$text = NULL;
			if (TEST || STAGING){
				$to_array = array("devs@remotestaff.com.au");
			}else{
				$to_array = array($email);			
			}

			SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array, $sender,$reply );

			return array("success"=>true, "result" => $to_array);
		}else{		
			return array("success"=>false, "error"=>"Email has already registered");
		}
		
	}

	public function registerCandidate(){
		
		$db = $this->db;
                
           
		if (!$_REQUEST["first_name"]){
			return array("success"=>false, "error"=>"First Name is required.");
		}
		
		if (!$_REQUEST["last_name"]){
			return array("success"=>false, "error"=>"Last Name is required.");
		}
		
		/*if (!$_REQUEST["middle_name"]){
			return array("success"=>false, "error"=>"Middle Name is required.");
		}*/
		
		if (!$_REQUEST["mobile"]){
			return array("success"=>false, "error"=>"Mobile Number is required.");
		}
		
		if (!$_REQUEST["current_job_title"]){
		    return array("success"=>false, "error"=>"Current Job Title is required.");
		}
		if (!$_REQUEST["email"]){
			return array("success"=>false, "error"=>"Email Address is required.");
		}else{
			$personal = $db->fetchRow($db->select()->from("personal")->where("email = ?", $_REQUEST["email"]));
			if ($personal){
				return array("success"=>false, "error"=>"Email is already registered. Enter another email to continue.");
			}
		}
		
		if ($_REQUEST["hashcode"]){
			$validation = $db->fetchRow($db->select()->from("jobseeker_email_validations")->where("email = ?", $_REQUEST["email"])->where("hashcode = ?", $_REQUEST["hashcode"]));
			if (!$validation){
				return array("success"=>false, "error"=>"Email is not validated. Please reload the page and try again.");
			}
		}
		
		if (!$_REQUEST["handphone_country_code"]){
			$_REQUEST["handphone_country_code"] = 63;
		}
		
		if ($_REQUEST["external_source"]=="Others"&&trim($_REQUEST["external_source_others"])!=""){
			$_REQUEST["external_source"] = $_REQUEST["external_source_others"];
		}
		
		$data = array(
			"fname"=>$_REQUEST["first_name"],
			"lname"=>$_REQUEST["last_name"],
			"middle_name"=>$_REQUEST["middle_name"],
			"byear"=>$_REQUEST["birth_year"],
			"bmonth"=>$_REQUEST["birth_month"],
			"bday"=>$_REQUEST["birth_day"],
			"gender"=>$_REQUEST["gender"],
			"nationality"=>$_REQUEST["nationality"],
			"pass"=>sha1($_REQUEST["password"]),
			"handphone_no"=>$_REQUEST["mobile"],
			"handphone_country_code"=>$_REQUEST["handphone_country_code"],
			"tel_no"=>$_REQUEST["tel_no"],
			"tel_area_code"=>$_REQUEST["tel_area_code"],
			"skype_id"=>$_REQUEST["skype_id"],
			"icq_id"=>$_REQUEST["facebook"],
			"facebook_id"=>$_REQUEST["facebook"],
			"email"=>$_REQUEST["email"],
			"referred_by"=>$_REQUEST["referred"],
			"linked_in"=>$_REQUEST["linked_in"],
			"speed_test"=>$_REQUEST["speed_test"],
			"computer_hardware"=>$_REQUEST["computer_hardware"],
			"promotional_code"=>$_REQUEST["pc"],
			"datecreated"=>date("Y-m-d H:i:s"),
			"dateupdated"=>date("Y-m-d H:i:s"),
			"external_source"=>$_REQUEST["external_source"],
			"status"=>"New"
		);
		
                
               
			   
		
		$db->insert("personal", $data);
		$userid = $db->lastInsertId("personal");
		
		
		global $curl;

		global $base_api_url;
		
		
		//$curl->get($base_api_url . "/mongo-index/sync-candidates-files/?userid=" . $userid);
		
		$curl->get($base_api_url . "/mongo-index/sync-all-candidates?userid=" . $userid);
		
		$curl->get($base_api_url . "/solr-index/sync-candidates?userid=" . $userid);
		
		$curl->get($base_api_url . "/mongo-index/sync-login-credentials?tracking_code=personal_" .$validation["email"] . "&email=" . $validation["email"]);


		
		
		$_SESSION["userid"] = $userid;
		$_SESSION['emailaddr'] = $validation["email"];
		
		
		//save position choices
		$current_job = $db->fetchRow($db->select()->from(array("c"=>"currentjob"), array("id"))->where("userid = ?", $userid));
		$cj_data = array("latest_job_title"=>$_REQUEST["current_job_title"],
		                 "position_first_choice"=>$_REQUEST["position_first_choice"], 
		                 "position_first_choice_exp_num"=>$_REQUEST["position_first_choice_exp_num"],
//						"position_first_choice_exp"=>$_REQUEST["position_first_choice_exp"],
						 "position_second_choice"=>$_REQUEST["position_second_choice"],
						 "position_second_choice_exp_num"=>$_REQUEST["position_second_choice_exp_num"],
//						 "position_second_choice_exp"=>$_REQUEST["position_second_choice_exp"],
						 "position_third_choice"=>$_REQUEST["position_third_choice"],
						 "position_third_choice_exp_num"=>$_REQUEST["position_third_choice_exp_num"],
//						 "position_third_choice_exp"=>$_REQUEST["position_third_choice_exp"],
						 "userid"=>$userid);
		
		if ($current_job){
			$db->update("currentjob", $cj_data, $db->quoteInto("id = ?", $current_job["id"]));		
		}else{
			$db->insert("currentjob", $cj_data);
			
		}
		
		
		foreach($_REQUEST["skill"] as $key=>$skill){
			if (!$skill){
				continue;
			}
			$skill_item = array(
				"skill"=>$skill,
				"experience"=>$_REQUEST["experience"][$key],
				"proficiency"=>$_REQUEST["proficiency"][$key],
				"userid"=>$userid
			);
			
			$db->insert("skills", $skill_item);
		}
		
		
		$db->delete("personal_task_preferences", $db->quoteInto("userid = ?", $userid));
		if (!empty($_REQUEST["task"])){
			foreach($_REQUEST["task"] as $key=>$task){
				if (!$task){
					continue;
				}
				$task_item = array(
					"userid"=>$userid,
					"task_id"=>$_REQUEST["task"][$key],
					"ratings"=>$_REQUEST["ratings"][$key],
					"date_created"=>date("Y-m-d H:i:s")
				);
				$db->insert("personal_task_preferences", $task_item);
			}	
		}
		
		
		$db->delete("personal_industries", $db->quoteInto("userid = ?", $userid));
		$relevant_industries = $db->fetchAll($db->select()->from("tb_relevant_industry_experience")->where("userid = ?", $userid));
		$db->delete("tb_relevant_industry_experience", $db->quoteInto("userid = ?", $userid));		
		foreach($relevant_industries as $relevant_industry){
			$db->insert("tb_relevant_industry_experience", array("name"=>$relevant_industry["name"], "userid"=>$relevant_industry["userid"]));
		}
		if (!empty($_REQUEST["industry_id"])){
			foreach($_REQUEST["industry_id"] as $key=>$industry_id){
				if (!$industry_id){
					continue;
				}
				
				$db->insert("personal_industries", array("industry_id"=>$industry_id, "userid"=>$userid, "date_created"=>date("Y-m-d H:i:s")));
				$value = $db->fetchOne($db->select()->from("defined_industries", "value")->where("id = ?", $industry_id));
				//insert also on tb_relevant_industry
				$db->insert("tb_relevant_industry_experience", array("name"=>$value, "userid"=>$userid));
			}	
		}
        
        
        $db -> insert("unprocessed_staff", array("userid"=>$userid, "admin_id"=> 0, "date" => date("Y-m-d H:i:s")));
		
		$session = array("userid"=>$userid, "emailaddr"=>$_REQUEST["email"]);
		$code = $this->getSessionHashCode();
		$db->insert("jobseeker_session_transfer", array("session_data"=>json_encode($session), "hashcode"=>$code, "date_created"=>date("Y-m-d H:i:s")));



        try{
            global $nodejs_api;

            $curl->get($nodejs_api . '/jobseeker/sync-solr?userid='.$userid);

        } catch(Exception $e){

        }
 
		return array("success"=>true, "code"=>$code, "userid"=>$userid);

	}	
	
	public function finalizeStep2(){
		$db = $this->db;
		
		
		
	if(!$_POST['on_ph'])
	{
		
			
		if(basename($_FILES['resume']['name']) != NULL || basename($_FILES['resume']['name']) != ""){
			$userid = $_REQUEST["userid"];	
			$AusTime = date("h:i:s"); 
			$AusDate = date("Y")."-".date("m")."-".date("d");
			$ATZ = $AusDate." ".$AusTime;
			$date = $ATZ;
	        
	        $date_created = $AusDate;
	        $name = $userid."_".basename($_FILES['resume']['name']);
	        
	        $name = str_replace(" ", "_", $name);
	        $name = str_replace("'", "", $name);
	        $name = str_replace("-", "_", $name);
	        $name = str_replace("php", "php.txt", $name);
			if (preg_match("/^.*\.(jpg|jpeg|png|gif|pdf|doc|docx|php|ppt|pptx|xls|xlsx|txt|php|html|rb|py|)$/i", $name)){
	        	$filesize = filesize($_FILES['resume']['tmp_name']);
	        	$file_mb = round(($filesize / 1048576), 2);
				
	        	if ($file_mb<=10){
	        		$data = array(
						"userid"=>$userid,
						"file_description"=>"RESUME",
						"name"=>$name,
						"permission"=>"ALL",
						"date_created"=>date("Y-m-d H:i:s")
					);
					$db->insert("tb_applicant_files", $data);
					$file = dirname(__FILE__)."/../../applicants_files/".$userid."_".basename($_FILES['resume']['name']);
					$file = str_replace(" ", "_", $file);
			        $file = str_replace("'", "", $file);
			        $file = str_replace("-", "_", $file); 
			        $file = str_replace("py", "py.txt", $file);       
			        $file = str_replace("php", "php.txt", $file);	 
					if (move_uploaded_file($_FILES['resume']['tmp_name'],$file)){
						chmod($file, 0777);
					}     
				}
			}
				
			
			
		}
                else{
                        return array("success"=>false, "error"=>"Uploading a Resume is required");
		    
		}
		
		if ($_REQUEST["userid"]){
			$personal = $db->fetchRow($db->select()->from(array("p"=>"personal"))->where("userid = ?", $_REQUEST["userid"]));
			$emailSmarty = new Smarty();
			$emailSmarty->assign("fname", $personal["fname"]);
			$emailSmarty->assign("email", $personal["email"]);
			
			$template = $emailSmarty->fetch("complete_resume.tpl");
			$subject = "Remote Staff Application - Complete Your Resume";			
			SaveToCouchDBMailbox(null, null, null, 'Remote Staff HR<recruitment@remotestaff.com.au>', $template, $subject, '',array($personal["email"]));
			$emailSmarty = new Smarty();
			$emailSmarty->assign("fname", $personal["fname"]);
			$emailSmarty->assign("lname", $personal["lname"]);
			
			$template = $emailSmarty->fetch("welcome.tpl");
			$subject = "WELCOME TO REMOTE STAFF";			
			SaveToCouchDBMailbox(null, null, null, 'Remote Staff HR<recruitment@remotestaff.com.au>', $template, $subject,'', array($personal["email"]));
			
			$test = new SkillTestEmail($db);
			$test->sendEmail("recruitment@remotestaff.com.au", $personal["email"]);			
		}
                
                $this->sendRecruiterNotificationEmail($_REQUEST["userid"]);
				
	}
	else
	{
			if ($_POST["userid"]){
						
				$userid = $_POST["userid"];
				if(basename($_FILES['resume']['name']) != NULL || basename($_FILES['resume']['name']) != ""){
					$userid = $_REQUEST["userid"];	
					$AusTime = date("h:i:s"); 
					$AusDate = date("Y")."-".date("m")."-".date("d");
					$ATZ = $AusDate." ".$AusTime;
					$date = $ATZ;
			        
			        $date_created = $AusDate;
			        $name = $userid."_".basename($_FILES['resume']['name']);
			        
			        $name = str_replace(" ", "_", $name);
			        $name = str_replace("'", "", $name);
			        $name = str_replace("-", "_", $name);
			        $name = str_replace("php", "php.txt", $name);
					if (preg_match("/^.*\.(jpg|jpeg|png|gif|pdf|doc|docx|php|ppt|pptx|xls|xlsx|txt|php|html|rb|py|)$/i", $name)){
			        	$filesize = filesize($_FILES['resume']['tmp_name']);
			        	$file_mb = round(($filesize / 1048576), 2);
						
			        	if ($file_mb<=10){
			        		$data = array(
								"userid"=>$userid,
								"file_description"=>"RESUME",
								"name"=>$name,
								"permission"=>"ALL",
								"date_created"=>date("Y-m-d H:i:s")
							);
							if($db->insert("tb_applicant_files", $data))
							{
								$p_data =  array("dateupdated"=>date('Y-m-d H:i:s'));
								
								$db->update("personal", $p_data, $db->quoteInto("userid = ?", $userid));	
							}
							$file = dirname(__FILE__)."/../../applicants_files/".$userid."_".basename($_FILES['resume']['name']);
							$file = str_replace(" ", "_", $file);
					        $file = str_replace("'", "", $file);
					        $file = str_replace("-", "_", $file); 
					        $file = str_replace("py", "py.txt", $file);       
					        $file = str_replace("php", "php.txt", $file);	 
							if (move_uploaded_file($_FILES['resume']['tmp_name'],$file)){
								chmod($file, 0777);
							}     
						}
					}
	
			}			
			if($_POST['on_ph']!="on_ph2")
			{	
			$personal = $db->fetchRow($db->select()->from(array("p"=>"personal"))->where("userid = ?", $_POST["userid"]));
			$emailSmarty = new Smarty();
			$emailSmarty->assign("fname", $personal["fname"]);
			$emailSmarty->assign("email", $personal["email"]);
			
			$template = $emailSmarty->fetch("complete_resume.tpl");
			$subject = "Remote Staff Application - Complete Your Resume";			
			SaveToCouchDBMailbox(null, null, null, 'Remote Staff HR<recruitment@remotestaff.com.au>', $template, $subject, '',array($personal["email"]));
			$emailSmarty = new Smarty();
			$emailSmarty->assign("fname", $personal["fname"]);
			$emailSmarty->assign("lname", $personal["lname"]);
			
			$template = $emailSmarty->fetch("welcome.tpl");
			$subject = "WELCOME TO REMOTE STAFF";			
			SaveToCouchDBMailbox(null, null, null, 'Remote Staff HR<recruitment@remotestaff.com.au>', $template, $subject,'', array($personal["email"]));
			
			$test = new SkillTestEmail($db);
			$test->sendEmail("recruitment@remotestaff.com.au", $personal["email"]);		
			}	
		}
	}

	}
	
	
	public function savePreferredSchedule(){
		$db = $this->db;
		$userid = $_REQUEST["userid"];
		
		if (!$_REQUEST["month"]){
			return array("success"=>false, "error"=>"Select month of interview.");
		}
		if (!$_REQUEST["day"]){
			return array("success"=>false, "error"=>"Select day of interview.");
		}
		if (!$_REQUEST["time"]){
			return array("success"=>false, "error"=>"Select time of interview.");
		}
		
		
		if (!empty($_REQUEST["interview_type"])){
			$db->delete("jobseeker_preferred_interview_schedules", $db->quoteInto("userid = ?", $userid));
			$selectedSchedule = date("Y")."-".$_REQUEST["month"]."-".$_REQUEST["day"];
			foreach($_REQUEST["interview_type"] as $interview_type){
				$data = array("userid"=>$userid, "interview_type"=>$interview_type, "date_interview"=>$selectedSchedule, "time_interview"=>$_REQUEST["time"], "date_created"=>date("Y-m-d H:i:s"));
				$db->insert("jobseeker_preferred_interview_schedules", $data);
			}
			return array("success"=>true);
		}else{
			return array("success"=>false, "error"=>"Please select where to conduct the interview.");
		}
		
		
	}
	
	public function alreadyRegistered($email){
		$db = $this->db;
		$personal = $db->fetchRow($db->select()->from("personal", array("email"))->where("email = ?", $email));
		if (!$personal){
			return false;
		}else{
			return true;
		}
	}
	
	public function getHashCode(){
		$db = $this->db;
		$code = "";
		while(true){
			$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
			$rand_pw = '';    
			for ($p = 0; $p < 10; $p++) {
				$rand_pw .= $characters[mt_rand(0, strlen($characters))];
			}
			$code = sha1($rand_pw);
			$validation = $db->fetchRow($db->select()->from("jobseeker_email_validations")->where("hashcode = ?", $code));
			if (!$validation){					
				break;
			}
		}
		return $code;
	}
	
	
	public function getSessionHashCode(){
		$db = $this->db;
		$code = "";
		while(true){
			$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
			$rand_pw = '';    
			for ($p = 0; $p < 10; $p++) {
				$rand_pw .= $characters[mt_rand(0, strlen($characters))];
			}
			$code = sha1($rand_pw);
			$validation = $db->fetchRow($db->select()->from("jobseeker_session_transfer")->where("hashcode = ?", $code));
			if (!$validation){					
				break;
			}
		}
		return $code;
	}
	
	
	private function sendRecruiterNotificationEmail($userid=0){
		
		//CHECK
		if($userid){
			
			//GET DB INSTANCE
			$db = $this->db;
			
			//FETCH PERSONAL
			$personal_sql = $db->select()
							   ->from('personal',array('fname','lname','datecreated'))
							   ->where('userid=?',$userid);
			$personal = $db->fetchRow($personal_sql);
			
			//FETCH CURRENT JOB
			$current_job_latest_job_title_sql = $db->select()
												   ->from('currentjob','latest_job_title')
												   ->where('userid=?',$userid);
			$current_job_latest_job_title = $db->fetchOne($current_job_latest_job_title_sql);
			
			//FETCH SKILLS
			$skills_sql = $db->select()
							 ->from('skills')
							 ->where('userid=?',$userid);
			$skills = $db->fetchAll($skills_sql);
			
                        
//                       
                        
//			FETCH APPLICANT FILE
			$resume_sql = $db->select()
							 ->from('tb_applicant_files','name')
							 ->where('userid=? AND file_description="RESUME" AND is_deleted IS NULL',$userid)
							 ->orWhere('userid=? AND file_description="RESUME" AND is_deleted = 0',$userid)
							 ->order('date_created DESC'); //GET UPDATED RESUME
			$resume = $db->fetchOne($resume_sql);
			
                        
                        
			//CONSTRUCT DATA
			$candidate_fullname = ucwords($personal['fname'].' '.$personal['lname']);
			$latest_job_title = ucwords($current_job_latest_job_title);
			$date_register = date('F j, Y',strtotime($personal['datecreated']));
			
			//CREATE NEW FILE
			$new_file = array();
			$new_file['filename'] = $resume;
			$new_file['type'] = mime_content_type(dirname(__FILE__)."/../../applicants_files/{$resume}");
			$new_file['tmpfname'] = dirname(__FILE__)."/../../applicants_files/{$resume}"; //WE ASSUME THAT ALL APPLICANT HAVE RESUME - THEREFORE IT CANNOT BE NULL OR EMPTY
			$skills = $skills;
			
			//CREATE NEW SMARTY INSTANCE
			$smarty = new Smarty();
			$smarty->assign('candidate_fullname',$candidate_fullname);
			$smarty->assign('latest_job_title',$latest_job_title);
			$smarty->assign('date_register',$date_register);
			$smarty->assign('skills',$skills);
			$body = $smarty->fetch("recruiter_new_applicant_notification_template.tpl");
			
			//CONSTRUCT COUCHMAIL PARAMETERS
			$subject = "Remotestaff Candidate New Application :: {$candidate_fullname} - {$latest_job_title}";
			$sender =  "Remotestaff System";
			$reply =  "This is automated email please do not reply!";
			$from = "noreply@remotestaff.com.au";
			$text = NULL;
			$html = $body;
			
			$attachments_array = array($new_file);
			$bcc_array = array('devs@remotestaff.com.au');
			
                        $cc_array = array();
			if(TEST){
				$to_array = array("devs@remotestaff.com.au");
			}else{
				$to_array = array("recruiters@remotestaff.com.ph","resume@remotestaff.com.ph");
			}
                        
			//SEND MAIL	
			SaveToCouchDBMailbox($attachments_array,$bcc_array,$cc_array,$from,$html,$subject,$text,$to_array,$sender,$reply);
			header("Location:/portal/jobseeker_register/session_transfer.php?c=".$_REQUEST["session_code"]);
		}   
	}

}