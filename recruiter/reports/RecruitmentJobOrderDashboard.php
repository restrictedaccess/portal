<?php
class RecruitmentJobOrderDashboard{
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
	
	public function render($template="recruitment_team_shortlists.tpl"){
		$smarty = $this->smarty;
		//load recruiter list
		$recruiters = $this->getRecruiters();
		$recruiter_options = "<option value=''>Please Select</option>";
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
		//order status
		$orderStatus = array("Open", "Closed", "Did not push through", "On Hold", "On Trial");
		$order_status_options = "<option value=''>All</option>";
		foreach($orderStatus as $status){
			$order_status_options.="<option value='{$status}'>$status</option>";
		}
		
		$serviceTypes = array("CUSTOM", "ASL", "REPLACEMENT", "BACK ORDER", "INHOUSE");
		$service_type_options = "<option value=''>All</option>";
		foreach($serviceTypes as $serviceType){
			$service_type_options.="<option value='{$serviceType}'>$serviceType</option>";
		}
		
		$shortlist_type_options = "<option value=''>All</option>";
		$shortlist_types = array("Assigned", "Unassigned");
		foreach($shortlist_types as $shortlist_type){
			$shortlist_type_options.="<option value='{$shortlist_type}'>$shortlist_type</option>";
		}
		$exclude = array("Ma. Angela", "Remote Recruiters");
		
		foreach($recruiters as $key=>$recruiter){
			if ($recruiter["admin_fname"]=="Remote"){
				$recruiters[$key]["admin_fname"] = "Remote Recruiters";			
			}
			$fname = explode(" ", $recruiter["admin_fname"]);
			if (!in_array($recruiter["admin_fname"], $exclude)){
				$recruiters[$key]["admin_fname"] = $fname[0];			
			}
		}
		
		
		$smarty->assign("hiring_coordinator_options", $hiring_coordinator_options);
		$smarty->assign("recruiter_options", $recruiter_options);
		$smarty->assign("recruiters", $recruiters);
		$smarty->assign("order_status_options", $order_status_options);
		$smarty->assign("service_type_options", $service_type_options);
		$smarty->assign("shortlist_type_options", $shortlist_type_options);
		
		$smarty->display($template);
	}


	
	public function getHiringCoordinators(){
		$db = $this->db;
		$select = "SELECT admin_id,admin_fname,admin_lname FROM `admin` WHERE hiring_coordinator='Y' AND status <> 'REMOVED' ORDER by admin_fname";
		return $db->fetchAll($select);
		
	}
	
	public function getRecruiters(){
		$db = $this->db;
		$select = "SELECT admin_id,admin_fname,admin_lname 	 
			FROM `admin`
			where (status='HR' OR admin_id IN (167,242,236,239))  
		AND status <> 'REMOVED'  AND admin_id <> 161   AND status <> 'REMOVED' ORDER by admin_fname";
		return $db->fetchAll($select); 
	}
}
