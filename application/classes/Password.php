<?php
require_once dirname(__FILE__)."/AbstractProcess.php";
require_once dirname(__FILE__)."/SkillTestEmail.php";

require_once dirname(__FILE__)."/../../tools/CouchDBMailbox.php";

class PasswordProcess extends AbstractProcess{
	
	private function authCheck(){
		if (!isset($_SESSION["userid"])){
			header("Location:/portal/application_form/registernow-step1-personal-details.php");
			die;
		}
	}
	public function render(){
		$this->authCheck();
		$smarty = $this->smarty;
		$db = $this->db;
		$personal = $db->fetchRow($db->select()->from(array("p"=>"personal"))->where("p.userid = ?", $_SESSION["userid"]));
		if ($personal){
			$smarty->assign("fname", $personal["fname"]);
		}
		if (TEST){
			$smarty->assign("site", "test.remotestaff.com.ph");
		}else{
			$smarty->assign("site", "remotestaff.com.ph");
		}
		$smarty->display("password.tpl");
	}
	
	
	public function setPassword(){
		$db = $this->db;
		if (isset($_POST["password"])&&isset($_POST["confirm_password"])&&strlen($_POST["password"])<6){
			echo json_encode(array("success"=>false, "error"=>"The password should be at least 6 characters long"));	
			die;
		}
		if (isset($_POST["password"])&&isset($_POST["confirm_password"])&&$_POST["password"]==$_POST["confirm_password"]){
			$this->db->update("personal", array("pass"=>sha1($_POST["password"])), $db->quoteInto("userid = ?", $_SESSION["userid"]));	
			$personal = $db->fetchRow($db->select()->from(array("p"=>"personal"))->where("userid = ?", $_SESSION["userid"]));
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
			
			
			
			if (isset($_SESSION["from"])){
				if ($_SESSION["from"]=="PH"){
					echo json_encode(array("success"=>true, "redirect"=>"/jobopeningsphp.php?job=".$_SESSION["job_id"]));
				}else{
					echo json_encode(array("success"=>true, "redirect"=>"/portal/jobseeker/"));	
				}
			}else{
				echo json_encode(array("success"=>true, "redirect"=>"/portal/jobseeker/"));					
			}
		
		}else{
			echo json_encode(array("success"=>false, "error"=>"The password did not match. Please try again"));
		}
	}

}
