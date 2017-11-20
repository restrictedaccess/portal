<?php
class RecruitmentSheetDashboard extends RecruitmentSheet{

	
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
	
	
	public function render(){
		$smarty = $this->smarty;
		
		$months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$i=1;
		$monthsAssoc["0"] = "";
		foreach($months as $month){
			$monthsAssoc["".$i] = $month;
			$i++;
		}

		$hiringCoordinators = $this->getHiringCoordinators();
		$hiringCoordinators[] = array("admin_id"=>0, "admin_fname"=>"No", "admin_lname"=>"Hiring Manager");
		
		
		$smarty->assign("months", $monthsAssoc);
		$smarty->assign("hiringCoordinators", $hiringCoordinators);
		$smarty->assign("dateTo", date("Y-m-d"));
		$smarty->assign("dateFrom", date("Y-m-d", strtotime(date('m').'/01/'.date('Y').' 00:00:00')));
		$smarty->display("recruitment_sheet_dashboard.tpl");
	}
	
	public function renderEnhanced(){
		$smarty = $this->smarty;
		
		$months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$i=1;
		$monthsAssoc["0"] = "";
		foreach($months as $month){
			$monthsAssoc["".$i] = $month;
			$i++;
		}

		$hiringCoordinators = $this->getHiringCoordinators();
		$hiringCoordinators[] = array("admin_id"=>0, "admin_fname"=>"No", "admin_lname"=>"Hiring Manager");
		
		$recruiters = $this->getRecruiters();
		$recruiters[] = array("admin_id"=>0, "admin_fname"=>"No", "admin_lname"=>"Recruiter Assigned");
		
		
		$smarty->assign("months", $monthsAssoc);
		$smarty->assign("hiringCoordinators", $hiringCoordinators);
		$smarty->assign("recruiters", $recruiters);
		$smarty->assign("dateTo", date("Y-m-d"));
		$smarty->assign("dateFrom", date("Y-m-d", strtotime(date('m').'/01/'.date('Y').' 00:00:00')));
		$smarty->display("recruitment_sheet_dashboard_enhanced.tpl");
	}
	
}