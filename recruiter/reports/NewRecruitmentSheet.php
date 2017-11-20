<?php
require_once dirname(__FILE__)."/../../lib/Portal.php";
class NewRecruitmentSheet extends Portal{
	
	protected function authCheck(){
	
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
		$this->authCheck();
		$db = $this->db;
		$smarty = $this->smarty;
		$this->setAdmin();
		$recruiters = $this->getRecruiters();
		//individual filter types
		
		require_once dirname(__FILE__)."/../../lib/JobOrderManager.php";
		$assigning_statuses = array();
		$assigning_statuses[] = array("value"=>JobOrderManager::OPEN, "label"=>"Open");
		$assigning_statuses[] = array("value"=>JobOrderManager::SC_ASSIGNED, "label"=>"Staffing Consultant Assigned");
		$assigning_statuses[] = array("value"=>JobOrderManager::REC_ASSIGNED, "label"=>"Recruiter Assigned");
		$assigning_statuses[] = array("value"=>JobOrderManager::AD_UP, "label"=>"Ad Up");
		
		$hiring_statuses = array();
		$hiring_statuses[] = array("value"=>JobOrderManager::NEW_SHORTLIST, "label"=>"New Shortlists");
		$hiring_statuses[] = array("value"=>JobOrderManager::NEED_MORE_CANDIDATE, "label"=>"Need More Candidate");
		$hiring_statuses[] = array("value"=>JobOrderManager::SC_REVIEWING_SHORTLIST, "label"=>"SC Reviewing Shortlist");
		$hiring_statuses[] = array("value"=>JobOrderManager::SKILL_TEST, "label"=>"Skill Test");
		$hiring_statuses[] = array("value"=>JobOrderManager::POST_ENDORSEMENT, "label"=>"Post Endorsement");
		$hiring_statuses[] = array("value"=>JobOrderManager::CLIENT_INTERVIEWING, "label"=>"Client Interviewing");
		$hiring_statuses[] = array("value"=>JobOrderManager::POST_INTERVIEW, "label"=>"Post Interview");
		$hiring_statuses[] = array("value"=>JobOrderManager::SC_REVIEWING_ORDER, "label"=>"SC REviewing Order");
		
		$decision_statuses = array();
		$decision_statuses[] = array("value"=>JobOrderManager::CLOSED_DID_NOT_PUSH_THROUGH, "label"=>"Closed: Did not Push Through");
		$decision_statuses[] = array("value"=>JobOrderManager::CLOSED_HIRED, "label"=>"Closed: Hired");
		$decision_statuses[] = array("value"=>JobOrderManager::CLOSED_HOLD, "label"=>"Closed: On Hold");
		$decision_statuses[] = array("value"=>JobOrderManager::CLOSED_TRIAL, "label"=>"Closed: On Trial");
		
		
		
		$filter_types = array("-", "Job Title", "Work Status", "Date Ordered", "Budget", "Work Timezone", "Date When Staff is Required", "Order Age in Days", "Last Contact Date");
		$retain = array(0, 1, 3);
		
		$filter_types_options = "";
		$i = 0;
		foreach($filter_types as $filter_type){
			if (in_array($i, $retain)){
				$filter_types_options.="<option value='{$i}'>{$filter_type}</option>";				
			}
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
		
		$hiring_coordinator_options .= "<option value='nohm'>No Staffing Consultant</option>";
		
		
		$smarty->assign("assigning_statuses", $assigning_statuses);
		$smarty->assign("hiring_statuses", $hiring_statuses);
		$smarty->assign("decision_statuses", $decision_statuses);
		
		
		$smarty->assign("role", $_SESSION["status"]);
		$smarty->assign("hiring_coordinator_options", $hiring_coordinator_options);
		$smarty->assign("filter_types_options", $filter_types_options);
		$smarty->assign("recruiter_options", $recruiter_options);
		$smarty->assign("status", $_SESSION["status"]);
		
		$smarty->assign("before_today", date("Y-m-d", strtotime("-3 DAYS")));
		$smarty->assign("today_date", date("Y-m-d"));
		$smarty->display("new_recruitment_sheet.tpl");
		
		
		
			
	}
	
	public function getHiringCoordinators(){
		$db = $this->db;
		$select = "SELECT admin_id,admin_fname,admin_lname FROM `admin` WHERE hiring_coordinator='Y' AND status <> 'REMOVED' ORDER by admin_fname";
		return $db->fetchAll($select);
		
	}
}