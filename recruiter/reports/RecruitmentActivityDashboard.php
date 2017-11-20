<?php
require_once dirname(__FILE__)."/../../lib/Portal.php";

class RecruitmentActivityDashboard extends Portal{
	
	protected function authCheck(){
	
		session_start();
		
		if (!isset($_SESSION["admin_id"])){
			header("location:/portal/index.php");
		}
	
		if($_SESSION['status'] <> "FULL-CONTROL"){ 
			echo "This page is for HR usage only.";
			exit;
		}		
		
		$_SESSION["started"] = true;
	}

	
	protected function getRecSupport(){
			
		//return array();	
		return $this->db->fetchAll("SELECT admin_id, admin_fname, admin_lname FROM admin WHERE admin_id IN (236, 239, 227, 228, 225, 167, 242, 226,169) AND status <> 'REMOVED' AND admin_id <> 161");
	}
	
	
	public function render(){
		$smarty = $this->smarty;
		
		$months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$i=1;
		$monthsAssoc["0"] = "";
		foreach($months as $month){
			$monthsAssoc["".$i] = $month;
			$i++;
		}

		$recruiters = $this->getRecruiters();
		$recruitment_support = $this->getRecSupport();
		$smarty->assign("months", $monthsAssoc);
		$smarty->assign("recruiters", $recruiters);
		$smarty->assign("recruitment_support", $recruitment_support);
		
		
		$smarty->assign("dateTo", date("Y-m-d"));
		$smarty->assign("dateFrom", date("Y-m-d", strtotime(date('m').'/01/'.date('Y').' 00:00:00')));
		$smarty->display("recruitment_activity_dashboard.tpl");
	}
	
}
