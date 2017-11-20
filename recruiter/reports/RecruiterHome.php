<?php
require_once dirname(__FILE__)."/../../lib/Portal.php";

class RecruiterHome extends Portal{

	public function render(){
		$db = $this->db;
		$smarty = $this->smarty;
		$this->setAdmin();
		$recruiters = $this->getRecruiters();
		foreach($recruiters as $recruiter){
			if ($recruiter["admin_id"]==$_SESSION["admin_id"]){
				$smarty->assign("recruiter_id", $_SESSION["admin_id"]);
				break;
			}
		}
		$smarty->assign("recruiters", $recruiters);
		$smarty->assign("date_from", date("Y-m-")."01");
		$smarty->assign("date_to", date("Y-m-d"));
		
		$smarty->display("recruiter_home.tpl");
	}

	
}
