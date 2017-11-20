<?php
require_once dirname(__FILE__) . "/AbstractProcess.php";
require_once(dirname(__FILE__).'/../../tools/CouchDBMailbox.php');
class SkillTestEmail extends AbstractProcess{
	public function getEmailTemplate($userid=null){
		$db = $this->db;
		$smarty = new Smarty();
		$smarty->template_dir = dirname(__FILE__)."/../templates";
		$smarty->compile_dir = dirname(__FILE__)."/../templates_c";
		if (TEST){
			$smarty->assign("site","http://test.remotestaff.com.au");	
		}else{
			$smarty->assign("site","http://remotestaff.com.au");
		}
		if ($userid){
			$personal = $db->fetchRow($db->select()->from(array("p"=>"personal"), array("fname"))->where("userid = ?", $userid));
			if ($personal){
				$smarty->assign("fname", $personal["fname"]);
			}
		}
		
		return $smarty->fetch("skill_test.tpl");
	}
	
	
	public function sendEmail($from_email, $to_email){
		$db = $this->db;
		$personal = $db->fetchRow($db->select()->from(array("p"=>"personal"), array("userid"))->where("email = ?", $to_email));
		if ($personal){
			$html = $this->getEmailTemplate($personal["userid"]);	
		}else{
			$html = $this->getEmailTemplate();
		}
		
		$attachments_array = NULL;
		$bcc_array = array();
		$cc_array = array();
		$sender =  "Remote Staff Recruitment<recruitment@remotestaff.com.au>";
		$reply = $from_email;
		$from = "Remote Staff Recruitment<recruitment@remotestaff.com.au>";
		$subject = "Take a Skill's Test - Remote Staff";
		
		if (TEST || STAGING){
			$to_array = array("devs@remotestaff.com.au");
		}else{
			$to_array = array($to_email);			
		}
		$text = strip_tags($html);
		SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, '', $to_array, $sender,$reply );
		
	}
	
}
