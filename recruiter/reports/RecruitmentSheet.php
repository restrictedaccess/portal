<?php
class RecruitmentSheet{
	
	protected $smarty;
	protected $db;
	
	public function __construct($db){
		$this->smarty = new Smarty();
		$this->db = $db;
		$this->authCheck();
	}
	
	private function authCheck(){
	
		session_start();
		if(!isset($_SESSION['agent_no'])){
			if (!isset($_SESSION["admin_id"])){
				header("location:/portal/index.php");
			}
		}else{
			$_SESSION['status'] = "BusinessDeveloper";
		}
		if (!isset($_SESSION["agent_no"])){
			if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL"){ 
				echo "This page is for HR usage only.";
				exit;
			}	
		}
		
		$_SESSION["started"] = true;
	}
	
	public function render(){
		$smarty = $this->smarty;
		
		//individual filter types
		
		$filter_types = array("-", "Job Title", "Work Status", "Date Ordered", "Budget", "Work Timezone", "Date When Staff is Required", "Order Age in Days", "Last Contact Date");
		$filter_types_options = "";
		$i = 0;
		foreach($filter_types as $filter_type){
			$filter_types_options.="<option value='{$i}'>{$filter_type}</option>";
			$i++;	
		}
		
		//load recruiter list
		$recruiters = $this->getRecruiters();
		$recruiter_options = "<option value=''>Please Select</option>";
		$recruiter_options .= "<option value='any_rec'>Any Recruiter</option>";
		$recruiter_options .= "<option value='no_rec'>No Assigned Recruiter</option>";
		
		
		foreach($recruiters as $recruiter){
			$fullname = $recruiter['admin_fname']." ".$recruiter['admin_lname'];
			$recruiter_options.="<option value='{$recruiter['admin_id']}'>{$fullname}</option>";
		}
		
		
		//get hiring coordinators
		$coordinators = $this->getHiringCoordinators();
		$hiring_coordinator_options = "<option value=''>View All</option>";
		foreach($coordinators as $coordinator){
			$fullname = $coordinator['admin_fname']." ".$coordinator['admin_lname'];
			$hiring_coordinator_options.="<option value='{$coordinator['admin_id']}'>{$fullname}</option>";
		}
		
		$hiring_coordinator_options .= "<option value='nohm'>No Hiring Manager</option>";
		$smarty->assign("role", $_SESSION["status"]);
		$smarty->assign("hiring_coordinator_options", $hiring_coordinator_options);
		$smarty->assign("filter_types_options", $filter_types_options);
		$smarty->assign("recruiter_options", $recruiter_options);
		$smarty->assign("status", $_SESSION["status"]);
		
		$smarty->assign("before_today", date("Y-m-d", strtotime("-3 DAYS")));
		$smarty->assign("today_date", date("Y-m-d"));
		$smarty->display("recruitment_sheet.tpl");
		
		
		
			
	}
	
	public function getHiringCoordinators(){
		$db = $this->db;
		$select = "SELECT admin_id,admin_fname,admin_lname FROM `admin` WHERE hiring_coordinator='Y' AND status <> 'REMOVED' ORDER by admin_fname";
		return $db->fetchAll($select);
		
	}
	
	protected function getRecruiters(){
		$db = $this->db;
		$select = "SELECT admin_id,admin_fname,admin_lname FROM `admin` where (status='HR' OR admin_id IN (236, 239, 228, 225, 227, 167, 242, 226,169))   AND status <> 'REMOVED' AND admin_id <> 161 ORDER by admin_fname";
		
		return $db->fetchAll($select); 
	}
}