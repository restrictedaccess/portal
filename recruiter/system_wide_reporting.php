<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$smarty = new Smarty;

//START: validate user
if(!$_SESSION['admin_id']){
	header("location:index.php");
}

if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL"){ 
	echo "This page is for HR usage only.";
	exit;
}

$admin_id = $_SESSION['admin_id'];
$sql=$db->select()
	->from('admin')
	->where('admin_id = ?' ,$admin_id);
$admin = $db->fetchRow($sql);
//ENDED: validate user

include("RecruiterHome_inc.php");


$recruiter_full_name = $admin['admin_fname']." ".$admin['admin_lname'];

$smarty->assign('candidate_status_report', $candidate_status_report);
$smarty->assign('interview_request_report', $interview_request_report);
$smarty->assign('hired_staff_report', $hired_staff_report);
$smarty->assign('drop_outs_report', $drop_outs_report);

$smarty->assign('search_date1', $search_date1);
$smarty->assign('search_date2', $search_date2);
$smarty->assign('search_date_check', $search_date_check);

$smarty->assign('search_date_requested1', $search_date_requested1);
$smarty->assign('search_date_requested2', $search_date_requested2);

$smarty->assign('recruiter_full_name', $recruiter_full_name);
$smarty->display('system_wide_reporting.tpl');
?>
