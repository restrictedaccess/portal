<?php
include('../conf/zend_smarty_conf.php') ;
require_once "reports/RecruiterHomeLister.php";
$rec = new RecruiterHomeLister($db_query_only);

$type = $_REQUEST["type"];
$recruiter_id  = $_REQUEST["admin_id"];
$recruiter_name = "";
if ($recruiter_id&&$recruiter_id!="all"){
	$recruiter_name = $db->fetchOne($db->select()->from("admin", array(new Zend_Db_Expr("CONCAT(admin_fname, ' ', admin_lname)")))->where("admin_id = ?", $recruiter_id));
}else{
	$recruiter_name = "ALL";
}

$smarty = new Smarty();
if ($type=="tnc"){
	$candidates = $rec->getCandidates($recruiter_id);
	$smarty->assign("candidates", $candidates);
	$smarty->assign("recruiter_name", $recruiter_name);
	$smarty->display("recruiter_home_tnc.tpl");
}else if ($type=="unprocessed"){
	$candidates = $rec->getUnprocessedCandidates($recruiter_id);
	$smarty->assign("candidates", $candidates);
	$smarty->assign("recruiter_name", $recruiter_name);
	$smarty->display("recruiter_home_unprocessed.tpl");
}else if ($type=="prescreened"){
	$candidates = $rec->getPrescreenedCandidates($recruiter_id);
	$smarty->assign("candidates", $candidates);
	$smarty->assign("recruiter_name", $recruiter_name);
	$smarty->display("recruiter_home_prescreened.tpl");
}else if ($type=="inactive"){
	$candidates = $rec->getInactiveCandidates($recruiter_id);
	$smarty->assign("candidates", $candidates);
	$smarty->assign("recruiter_name", $recruiter_name);
	$smarty->display("recruiter_home_inactive.tpl");
}else if ($type=="shortlisted"){
	$candidates = $rec->getShortlistedCandidates($recruiter_id);
	$smarty->assign("candidates", $candidates);
	$smarty->assign("recruiter_name", $recruiter_name);
	$smarty->display("recruiter_home_shortlisted.tpl");
}else if ($type=="endorsed"){
	$candidates = $rec->getEndorsedCandidates($recruiter_id);
	$smarty->assign("candidates", $candidates);
	$smarty->assign("recruiter_name", $recruiter_name);
	$smarty->display("recruiter_home_endorsed.tpl");
}else if ($type=="categorized"){
	$candidates = $rec->getCategorizedCandidates($recruiter_id);
	$smarty->assign("candidates", $candidates);
	$smarty->assign("recruiter_name", $recruiter_name);
	$smarty->display("recruiter_home_categorized.tpl");
}else if ($type=="interview_asl"){
	$candidates = $rec->getASLBookedCandidates($recruiter_id);
	$smarty->assign("candidates", $candidates);
	$smarty->assign("recruiter_name", $recruiter_name);
	$smarty->display("recruiter_home_asl.tpl");
}else if ($type=="interview_custom"){
	$candidates = $rec->getCustomBookedCandidates($recruiter_id);
	$smarty->assign("candidates", $candidates);
	$smarty->assign("recruiter_name", $recruiter_name);
	$smarty->display("recruiter_home_custom.tpl");
}
