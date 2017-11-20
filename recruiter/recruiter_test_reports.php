<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', TRUE);
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$smarty = new Smarty;

//START: validate user
if(!$_SESSION['admin_id']){
	header("location:index.php");
}

if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL" && $_SESSION['status'] <> "COMPLIANCE"){ 
	echo "This page is for HR usage only.";
	exit;
}

$admin_id = $_SESSION['admin_id'];
$sql=$db->select()
	->from('admin')
	->where('admin_id = ?' ,$admin_id);
$admin = $db->fetchRow($sql);
//ENDED: validate user

$recruiter_full_name = $admin['admin_fname']." ".$admin['admin_lname'];

$smarty->display('recruiter_test_reports.tpl');
?>
