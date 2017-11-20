<?php
class RecruiterASLDashboard{
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
		$recruiters = $this->getRecruiters();
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
		$smarty->assign("before_today", date("Y-m")."-01");
		$smarty->assign("today_date", date("Y-m-d"));
		$smarty->assign("recruiters", $recruiters);
		$smarty->display("recruiter_asl_reporting.tpl");
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
		OR admin_id='81')   AND admin_id <> 161  
		AND status <> 'REMOVED'  AND status <> 'REMOVED' ORDER by admin_fname";
		return $db->fetchAll($select); 
	}
	
}