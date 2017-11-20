<?php
include('../conf/zend_smarty_conf.php') ;
require_once "reports/JobOrderRecruitmentLoader.php";
$loader = new JobOrderRecruitmentLoader($db);

$posting_id = $_REQUEST["posting_id"];
$admin_id = $_REQUEST["admin_id"];
$tracking_code = $_REQUEST["tracking_code"];
$shortlist_type = $_REQUEST["shortlist_type"];

//get recruiter name
if ($admin_id){
	$admin = $db->fetchRow($db->select()->from("admin", array("admin_fname", "admin_lname", "admin_id"))->where("admin_id = ?", $admin_id));
	$admin_name = $admin["admin_fname"]." ".$admin["admin_lname"];
}else{
	$admin_name = "All Recruiters";
}
$retries = 0;
while(true){
	try{
		if (TEST){
			$mongo = new MongoClient(MONGODB_TEST);
			$database = $mongo->selectDB('prod');
		}else{
			$mongo = new MongoClient(MONGODB_SERVER);
			$database = $mongo->selectDB('prod');
		}
		break;
	} catch(Exception $e){
		++$retries;
		
		if($retries >= 100){
			break;
		}
	}
}
	
$job_orders_collection = $database -> selectCollection('job_orders');
$cursor = $job_orders_collection -> find(array("tracking_code"=>$tracking_code));

$shortlisted_staff = array();
$all_recruiters = $loader->getRecruiters();
while ($cursor -> hasNext()) {
	$result = $cursor -> getNext();
	$assigned_recruiters = array();
	foreach($result["recruiters"] as $rec){
		$assigned_recruiters[] = $rec["recruiters_id"];
	}
	$assigned_staff = array();
	$unassigned_staff = array();
	if ($admin_id){
		if (in_array($admin_id, $assigned_recruiters)){
			if ($_REQUEST["posting_id"]&&$_REQUEST["admin_id"]){
				$assigned_staff = $loader->getShortlistedStaffs($posting_id, $admin_id);
				$unassigned_staff = array();	
			}
		}else{
			if ($_REQUEST["posting_id"]&&$_REQUEST["admin_id"]){
				$unassigned_staff = $loader->getShortlistedStaffs($posting_id, $admin_id);
				$assigned_staff = array();	
			}
		}
		if ($shortlist_type=="Assigned"){
			$shortlisted_staff = $assigned_staff;
		}else if ($shortlist_type=="Unassigned"){
			$shortlisted_staff = $unassigned_staff;
		}else{
			$shortlisted_staff = array();
			if (!empty($assigned_staff)){
				foreach($assigned_staff as $staff){
					$shortlisted_staff[] = $staff;
				}
			}
			if (!empty($unassigned_staff)){
				foreach($unassigned_staff as $staff){
					$shortlisted_staff[] = $staff;
				}
			}
		}
	}else{
		$shortlisted_staff = array();
		if ($shortlist_type=="Assigned"){
			foreach($assigned_recruiters as $admin_id){
				$assigned_staff = $loader->getShortlistedStaffs($posting_id, $admin_id);
				if (!empty($assigned_staff)){
					foreach($assigned_staff as $staff){
						$shortlisted_staff[] = $staff;
					}
				}
			}
		}else if ($shortlist_type=="Unassigned"){
			//loop all recruiters	
			foreach($all_recruiters as $rec){
				if (!in_array($rec["admin_id"], $assigned_recruiters)){
					$unassigned_staff = $loader->getShortlistedStaffs($posting_id, $rec["admin_id"]);
					if (!empty($unassigned_staff)){
						foreach($unassigned_staff as $staff){
							$shortlisted_staff[] = $staff;
						}
					}
				}
			}
		}else{
			$shortlisted_staff = $loader->getShortlistedStaffsViaPosting($posting_id);
		}
	}
}
$smarty = new Smarty();
$smarty->assign("shortlisted_staff", $shortlisted_staff);
$smarty->assign("admin_name", $admin_name);
$smarty->assign("shortlist_type",$shortlist_type);
$smarty->display("shortlisted_jo.tpl");
