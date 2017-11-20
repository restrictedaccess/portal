<?php
require_once dirname(__FILE__)."/../../lib/Portal.php";
class SMSLogPortal extends Portal{
	public function render(){
		$db = $this->db;	
		$this->setAdmin();
		$smarty = $this->smarty;
		//load all csro
		$csros = $this->getCSRO();
		$recruiters = $this->getRecruiters();
		
		foreach($csros as $csro){
			if ($csro["admin_id"]==$_SESSION["admin_id"]){
				$smarty->assign("csro_id", $_SESSION["admin_id"]);
				break;
			}
		}
		
		foreach($recruiters as $recruiter){
			if ($recruiter["admin_id"]==$_SESSION["admin_id"]){
				$smarty->assign("recruiter_id", $_SESSION["admin_id"]);
				break;
			}
		}
		
		$smarty->assign("admin_status", $_SESSION["status"]);
		$smarty->assign("admin_id", $_SESSION["admin_id"]);
		$smarty->assign("csros", $csros);
		$smarty->assign("recruiters", $recruiters);
		$smarty->assign("date", date("Y-m-d"));
		if (TEST){
			$smarty->assign("base_url", "ws://test.remotestaff.com.au:8000/");
		}else{
			$smarty->assign("base_url", "ws://remotestaff.com.au:8000/");
		}
		$smarty->display("index.tpl");
	}
	
	private function getCSRO(){
		$db = $this->db;	
		$csro = $db->fetchAll($db->select()->from("admin", array("admin_id", "admin_fname", "admin_lname"))->where("csro = ?", "Y")->where("status <> 'REMOVED'"));
		return $csro;
	}
	
	public function getRecruiters(){
		$db = $this->db;
		$select = "SELECT admin_id,admin_fname,admin_lname 	 
			FROM `admin`
			where (status='HR' 
		OR admin_id='41'
		OR admin_id='67'
		OR admin_id='71'
		OR admin_id='78'
		OR admin_id='81')  
		AND status <> 'REMOVED'  AND status <> 'REMOVED' ORDER by admin_fname";
		return $db->fetchAll($select); 
	}
}
