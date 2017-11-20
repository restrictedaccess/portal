<?php
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
include('../time.php') ;
include '../function.php';
require_once "reports/RecruiterStaffContractCounter.php";

$counter = new RecruiterStaffContractCounter($db);
$recruiter = $db->fetchRow($db->select()->from("admin")->where("admin_id = ?", $_GET["recruiter_id"]));
if (!$recruiter){
	if ($_GET["recruiter_id"]=="0"){
		$recruiter["admin_id"] = 0;	
		$recruiter["admin_fname"] = "No Recruiter Assigned";
	}else if ($_GET["recruiter_id"]=="Resigned"){
		$recruiter["admin_id"] = "Resigned";	
		$recruiter["admin_fname"] = "Resigned Recruiter";
	}else{
		$recruiter = "All";	
	}
	
}
$smarty = new Smarty();

if ($_GET["recruiter_id"] == "Resigned"){
	$smarty->assign("contracts", $counter->getList($_GET["service_type"], "Resigned", $_GET['inhouse_staff']));
}else{
	$smarty->assign("contracts", $counter->getList($_GET["service_type"], $recruiter, $_GET['inhouse_staff']));	
}
if ($recruiter=="All"){
	$smarty->assign("title", "All Recruiters - ".$_GET["service_type"]);	
}else{
	$smarty->assign("title", $recruiter["admin_fname"]." ".$recruiter["admin_lname"]." - ".$_GET["service_type"]);	
}
$smarty->display("recruitment_contract_list.tpl");
