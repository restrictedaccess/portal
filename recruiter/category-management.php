<?php 
include('../conf/zend_smarty_conf.php');

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$smarty = new Smarty;

if(!$_SESSION['admin_id']){
	header("location:index.php");
}

if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL"){ 
	echo "This page is for HR usage only.";
	exit;
}

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
$sql=$db->select()
	->from('admin')
	->where('admin_id = ?' ,$admin_id);
$admin = $db->fetchRow($sql);

$session_name = $admin['admin_fname']." ".$admin['admin_lname'];
$session_email = $admin['admin_email'];
$created_by_id = $_SESSION['admin_id'];
$created_by_type = 'admin';

$smarty->display('category-management.tpl');
?>