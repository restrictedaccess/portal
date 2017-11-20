<?php
/**
 * This class is for adding personal information on candidates profile.
 *
 * @main author Allanaire Tapion
 * @copyright Remote Staff Inc.
 *
 * @version 0.0.1
 *
 * 02-18-2015 - Added Solr Candidates Syncer Functionality - Marlon Peralta
 *
 **/
class AddCandidateProfileStep1{
	private $db;
	private $smarty;
	private $errors;
	private $success = false;
	public function __construct($db){
		$this->db = $db;
		$this->smarty = new Smarty();
		$this->errors = array();
		$this->authCheck();
	}
	private function authCheck(){
	
		session_start();
		if (!isset($_SESSION["admin_id"])){
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				die;
			}else{
				header("location:/portal/index.php");
			}
		}
		if (!empty($_POST)){
			foreach($_POST as $key=>$val){
				if (!is_array($val)){
					$_POST[$key] = strip_tags($val);				
				}
			}			
		}
	}
	public function create(){
		global $transport;
		$form = new AddCandidateProfileStep1Form();
		$db = $this->db;
		$form->removeElement("state");
		if ($form->isValid($_POST)){
			$data =  $form->getValues();
			$data["state"] = $_POST["state"];
			$datetime = date("Y-m-d")." ".date("H:i:s");
			$data["datecreated"] = $datetime;
			$referral_id = $data["referral_id"];
			
			if ($data["external_source"]=="Others"&&trim($data["external_source_others"])!=""){
				$data["external_source"] = $data["external_source_others"];
			}
			unset($data["external_source_others"]);
			unset($data["referral_id"]);
			
			$password = $this->rand_str(6);
			
			$possibleAccount = $db->fetchRow($db->select()->from("personal", array("userid"))->where("email = ?", $_REQUEST["email"]));	
			$id = 0;
			if ($possibleAccount){
				$data["pass"] = sha1($password);
				$db->update("personal", $data, $db->quoteInto("userid = ?", $possibleAccount["userid"]));
				$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$possibleAccount["userid"]));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://api.remotestaff.com.au/solr-index/sync-candidates/");
							}
				$id = $possibleAccount["userid"];
			}else{
				$data["pass"] = sha1($password);
				$db->insert("personal", $data);
				$id = $db->lastInsertId("personal");
			}
			
			
			
			if ($referral_id){
				$db->update("referrals", array("jobseeker_id"=>$id), $db->quoteInto("id = ?", $referral_id));
				$db -> delete("solr_candidates", $db -> quoteInto("userid=?", $_REQUEST["userid"]));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://api.remotestaff.com.au/solr-index/sync-candidates/");
							}
				$referral = $db->fetchRow($db->select()
											->from(array("r"=>"referrals"), array("r.firstname AS referral_fname", "r.lastname AS referral_lname"))
											->joinInner(array("p"=>"personal"), "p.userid = r.user_id", array("p.userid", "p.fname AS referee_fname", "p.lname AS referee_lname", "p.email AS referee_email"))
											->where("id = ?", $referral_id)
										);
				if ($referral){
					$emailSmarty = new Smarty();
					$emailSmarty->assign("referral_name", $referral["referral_fname"]." ".$referral["referral_lname"]);
					$emailSmarty->assign("referee_name", $referral["referee_fname"]." ".$referral["referee_lname"]);
					$emailTemplate = $emailSmarty->fetch("referral_created_jobseeker.tpl");			
					$mail = new Zend_Mail();
					$mail->setBodyHtml($emailTemplate);
					if (TEST){
						$mail->setSubject("TEST - Updates on your referral at Remotestaff");
					}else{
						$mail->setSubject("Updates on your referral at Remotestaff");
					}
					$mail->setFrom("recruitment@remotestaff.com.au");
					if (TEST){
						$mail->addTo("devs@remotestaff.com.au");
					}else{
						$mail->addTo($referral["referee_email"]);						
					}
					$mail->send($transport);
				}
			
			}
			
			
			$sql = $db->select()
				->from('unprocessed_staff')
				->where('userid =?' , $id);
			$result = $db->fetchRow($sql);
		
			
			
			if(isset($result['id'])){
				$data = array(
					'date' => $datetime
				);
				$where = "userid = ".$id;	
				$db->update('unprocessed_staff' , $data , $where);
				$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$id));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://api.remotestaff.com.au/solr-index/sync-candidates/");
							}
			}
			else{
				$data = array(
					'userid' => $id,
					'admin_id' => 54, 
					'date' => $datetime
				);
				$db->insert('unprocessed_staff', $data);
			}
			include_once "../time.php";
				
			$changeByType = $_SESSION["status"];
			if ($changeByType=="FULL-CONTROL"){
				$changeByType = "ADMIN";
			}
			
			$history_changes = "admin created resume for candidate";
			
			$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$id, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
			$db->insert("resume_creation_history", array("userid"=>$id, "date_created"=>date("Y-m-d H:i:s"), "admin_id"=>$_SESSION["admin_id"]));
			
			$found = false;
			$recruiters = $this->getRecruiters();
			foreach($recruiters as $recruiter){
				if ($_SESSION["admin_id"]==$recruiter["admin_id"]){
					$found = true;
					break;
				}
			}
			//query latest updated personal record then email
			$personal = $db->fetchRow($db->select()->from("personal")->where("userid = ?", $id));
			if ($personal){
				//get template of admin
				$admin = $db->fetchRow($db->select()->from("admin")->where("admin_id = ?", $_SESSION["admin_id"]));
				$signature_template;
				if ($admin){
					$signature_company = $admin['signature_company'];
					$signature_notes = $admin['signature_notes'];
					$signature_contact_nos = $admin['signature_contact_nos'];
					$signature_websites = $admin['signature_websites'];
					if($signature_notes!="")
					{
						$signature_notes = "<p><i>$signature_notes</i></p>";
					}
					else
					{
						$signature_notes = "";
					}
					if($signature_company!="")
					{
						$signature_company="<br>$signature_company";
					}
					else
					{
						$signature_company="<br>RemoteStaff";
					}
					if($signature_contact_nos!="")
					{
						$signature_contact_nos = "<br>$signature_contact_nos";
					}
					else
					{
						$signature_contact_nos = "";
					}
					if($signature_websites!="")
					{
						$signature_websites = "<br>Websites : $signature_websites";
					}
					else
					{
						$signature_websites = "";
					}
												
					$signature_template = $signature_notes;
					$signature_template .="<a href='http://$site/$agent_code'>
					<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>";
					$signature_template .= "<p><b>$name</b>$signature_company$signature_contact_nos<br>Email : $admin_email$signature_websites</p>";						   
					//ENDED: signature						  	
				}
				
				$emailSmarty = new Smarty();
				$emailSmarty->assign("jobseeker_name", $personal["fname"]." ".$personal["lname"]);
				$emailSmarty->assign("email", $personal["email"]);
				$emailSmarty->assign("pass", $password);
				$emailSmarty->assign("signature_template", $signature_template);
				$body = $emailSmarty->fetch("jobseeker_complete_resume.tpl");
				$mail = new Zend_Mail();
				$mail->setBodyHtml($body);
				if (TEST){
					$mail->setSubject("TEST - Please complete your Remotestaff resume");
					$mail->addTo("devs@remotestaff.com.au");
					$mail->setFrom("recruitment@remotestaff.com.au");
				}else{
					$mail->setSubject("Please complete your Remotestaff resume");
					$mail->addTo($personal["email"]);
					$mail->setFrom($admin["admin_email"]);
				
				}
				$mail->send($transport);
				
				
			}
			
			if ($found){
			
				//automatically tag created resume to 
				$db->insert("recruiter_staff", array("userid"=>$id, "admin_id"=>$_SESSION["admin_id"], "date"=>date("Y-m-d H:i:s"), "auto_assigned_from_admin"=>1));
			}
			$this->success = true;
			return array("success"=>true, "userid"=>$id);
		}else{
			$this->errors = $form->getErrors();
			return array("errors"=>$this->errors, "success"=>false);
		}	
		
		
	}
	
	public function update(){
		$form = new UpdateCandidateProfileForm();
		$db = $this->db;
		//form->removeElement("state");
                
   
		//format data of skypes
		$data = array();
		$subconids = $_POST["skypes_subcontractors_ids"];
		$userids = $_POST["skypes_userids"];
		$skype_items = $_POST["skypes_skype_ids"];
		$ids = $_POST["skypes_ids"];
		
		
		$skypes = array();
		foreach($skype_items as $key=>$skype){
			$item = array();
			if ($skype==""){
				continue;
			}
			$item["subcontractors_id"] = $subconids[$key];
			if ($userids[$key]==""){
				$item["userid"] = $_REQUEST["userid"];	
			}else{
				$item["userid"] = $userids[$key];
			}
			$item["skype_id"] = $skype;
			$item["id"] = $ids[$key];
			$skypes[] = $item;
		}
		
		unset($_POST["skypes_subcontractors_ids"]);
		unset($_POST["skypes_userids"]);
		unset($_POST["skypes_skype_ids"]);
		unset($_POST["skypes_ids"]);
		
		
		
		if ($form->isValid($_POST)){
			$data =  $form->getValues(); 
                        
			//check if has unfinished email validation
			$emailPersonal = $db->fetchRow($db->select()->from("personal")->where("email = ?", $_REQUEST["email"])->where("userid <> ?", $_REQUEST["userid"]));
			if ($emailPersonal){
				if (trim($emailPersonal["fname"])!=""&&trim($emailPersonal["lname"])!=""){
					return array("error"=>"The email is already existing.", "success"=>false);
				}else if (trim($emailPersonal["fname"])==""&&trim($emailPersonal["lname"])==""){
					$db->delete("personal", $db->quoteInto("userid = ?", $emailPersonal["userid"]));
				}
			}
			
			
			
			$datetime = date("Y-m-d")." ".date("H:i:s");
			$userid = $_REQUEST["userid"];
			//before
			$old = $db->fetchRow($db->select()->from(array("p"=>"personal"))->where("userid = ?", $_REQUEST["userid"]));
			unset($old["dateupdated"]);
			
			$data["dateupdated"] = $datetime;

			$db->update("personal", $data, $db->quoteInto("userid = ?", $_REQUEST["userid"]));
			$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$userid));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://api.remotestaff.com.au/solr-index/sync-candidates/");
							}
			foreach($skypes as $skype){
				if ($skype["id"]!=""){
					$skype["date_updated"] = date("Y-m-d H:i:s");
					$db->update("staff_skypes", $skype, $db->quoteInto("id = ?", $skype["id"]));
					$db -> delete("solr_candidates", $db -> quoteInto("userid=?",$_REQUEST["userid"]));
							if(TEST){
								file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-candidates/");
							}else{
								file_get_contents("http://api.remotestaff.com.au/solr-index/sync-candidates/");
							}
				}else{
					$skype["date_created"] = date("Y-m-d H:i:s");
					$skype["date_updated"] = date("Y-m-d H:i:s");
					$db->insert("staff_skypes", $skype);
				}
				
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
				
				$changeByType = $_SESSION["status"];
				if ($changeByType=="FULL-CONTROL"){
					$changeByType = "ADMIN";
				}
				
				$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
				
			
			
			}
			
			
			$this->success = true;
			return array("success"=>true);
		}else{
			$this->errors = $form->getErrors();
			return array("errors"=>$this->errors, "success"=>false);
		}
		
	}
	
	public function rand_str($length = 12, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') {
	    // Length of character list
	    $chars_length = strlen($chars);
	    // Start our string
	    $string = $chars{rand(0, $chars_length)};
	    // Generate random string
	    for ($i = 1; $i < $length; $i++) {
	        // Grab a random character from our list
	        $r = $chars{rand(0, $chars_length)};
	        $string = $string . $r;
	    }
	    // Return the string
	    return $string;
	}
	
	
	public function renderUpdate(){
		$db = $this->db;
		$smarty = $this->smarty;
		$form = new UpdateCandidateProfileForm();
		
	
		if (!empty($_POST)&&$this->success){
			$smarty->assign("success", true);
			header("Location:/portal/recruiter/recruiter_search.php");
			die;
		}else{
			$smarty->assign("success", false);
		}
		
		$userid = $_REQUEST["userid"];
		$personal = $db->fetchRow($db->select()->from("personal")->where("userid = ?", $_REQUEST["userid"]));
		foreach($personal as $key=>$value){
			try{
				if ($form->getElement($key)){
					$form->getElement($key)->setValue($value);						
				}
			}catch(Exception $e){
				
			}	
		}
		//VERIFY IF STAFF IS HAS ACTIVE CONTRACT
            $get_active_staffs_sql = $db -> select()
                                     -> from(array("s"=>"subcontractors"),array("status"))
                                     -> where('s.userid =?', $userid);
            $get_active_staffs = $db -> fetchAll($get_active_staffs_sql);
            
            foreach($get_active_staffs as $get_active_staff){
                if($get_active_staff["status"]=="ACTIVE"){
                    break;
                }
            }
		//check referral
		$referral = $db->fetchRow($db->select()->from(array("r"=>"referrals"), array())->joinInner(array("p"=>"personal"), "p.userid = r.user_id", array("p.fname AS referee_fname", "p.lname AS referee_lname", "p.userid AS referee_userid"))->where("r.jobseeker_id = ?", $userid));
	
		if ($referral){
			$referred_by = $referral["referee_fname"]." ".$referral["referee_lname"];
			$form->getElement("referred_by")->setValue($referred_by);
			$form->getElement("referred_by")->setAttrib("readonly", "readonly");			
		}
		
		
		//query all contracts
		$subcontractorsCount = $db->fetchRow($db->select()->from(array("s"=>"subcontractors"), array("COUNT(*) AS count"))
											->where("userid = ?", $_REQUEST["userid"])
											->where("status IN ('ACTIVE', 'suspended', 'resigned', 'terminated')"));
		
		if ($subcontractorsCount&&$subcontractorsCount["count"]>=1){
			if ($form->getElement("email")->getValue()==""||$form->getElement("email")->getValue()==null){
				
			}else{
                    $form->getElement("fname")->readonly = "readonly";
                    $form->getElement("lname")->readonly = "readonly";
				if ($_SESSION["status"]!="FULL-CONTROL"){
					$form->getElement("email")->readonly = "readonly";
				}
			}
			
		}
		
		$skypes = $db->fetchAll($db->select()->from(array("sky"=>"staff_skypes"))->where("sky.userid = ?", $_REQUEST["userid"]));
		$smarty->assign("skypes", $skypes);	
		$smarty->assign_by_ref("form", $form);
		$smarty->display("updatepersonal.tpl");		
	}
	
	public function render(){
		$db = $this->db;
		$smarty = $this->smarty;
		if (isset($_GET["type"])){
			if ($_GET["type"]=="popup"){
				$smarty->assign("popup", true);
			}else{
				$smarty->assign("popup", false);
			}	
		}else{
			$smarty->assign("popup", false);
		}
		$form = new AddCandidateProfileStep1Form();
		if (isset($_GET["referral_id"])){
			$referral_id = $_GET["referral_id"];
			//load referral details
			$referral = $db->fetchRow($db->select()->from("referrals")->where("id = ?", $referral_id));
			if ($referral){
				$personal = $db->fetchRow($db->select()->from("personal", array("userid"))->where("email = ?", $referral["email"]));	
				if ($personal){
					header("Location:/portal/recruiter/staff_information.php?userid=".$personal["userid"]."&page_type=popup");
					die;
				}	
					
				$form->getElement("fname")->setValue($referral["firstname"]);
				$form->getElement("lname")->setValue($referral["lastname"]);
				$form->getElement("email")->setValue($referral["email"]);
				$form->getElement("referral_id")->setValue($referral_id);
				//mobile number extraction
				$mobile_number = $referral["contactnumber"];
				if (substr($mobile_number, 0, 2)=="09"&&strlen($mobile_number)==11){
					$form->getElement("handphone_country_code")->setValue("63");
					$form->getElement("handphone_no")->setValue(substr($mobile_number, 1));
				}else if (substr($mobile_number, 0, 2)=="63"){
					$form->getElement("handphone_country_code")->setValue("63");
					$form->getElement("handphone_no")->setValue(substr($mobile_number, 2));
				}else if (substr($mobile_number, 0, 3)=="+63"){
					$form->getElement("handphone_country_code")->setValue("63");
					$form->getElement("handphone_no")->setValue(substr($mobile_number, 3));
				}else{
					$form->getElement("handphone_country_code")->setValue("63");
					$form->getElement("handphone_no")->setValue($mobile_number);
				}
				
			}	
		}
		
		
		if (!empty($_POST)&&$this->success){
			$smarty->assign("success", true);
			header("Location:/portal/recruiter/recruiter_search.php");
			die;
		}else{
			$smarty->assign("success", false);
		}
		$form->getElement("nationality")->setValue("Philippines");
		$form->getElement("permanent_residence")->setValue("PH");
		$form->getElement("country_id")->setValue("PH");
		$form->getElement("gender")->setValue("Male");
		
		$smarty->assign_by_ref("form", $form);
		$smarty->display("index.tpl");
	}
	
	private function getRecruiters(){
		$db = $this->db;
		$select = "SELECT admin_id,admin_fname,admin_lname 	 
			FROM `admin`
			where status='HR'
			OR admin_id='39' 
		OR admin_id='29' 
		OR admin_id='50'
		OR admin_id='81'
		OR admin_id='71'
		OR admin_id='78'
		OR admin_id = '67' 
		OR admin_id='41' AND status <> 'REMOVED'  AND admin_id <> 161   ORDER by admin_fname";
		return $db->fetchAll($select); 
	}
}
