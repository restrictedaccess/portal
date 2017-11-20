<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$smarty = new Smarty;

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
$recruiter_full_name = $admin['admin_fname']." ".$admin['admin_lname'];
$recruiter_user_type = $admin['status'];


//START: email items report
	include("staff_search_items_functions.php");

	//start: loader
	$status = "WAITING";
	$p = 1 ;
	$maxp = 20 ;
	$found = search_items($db,$status,$p,$maxp,$max) ;
	$pages = search_items_linkpage($status,$p,$maxp,$found[0]['max']) ;
	include("staff_search_items_format.php");
	$waiting_items = $data_items;
	//ended: loader
	
	//start: loader
	$data_items = "";
	$status = "SENT";
	$p = 1 ;
	$maxp = 20 ;
	$found = search_items($db,$status,$p,$maxp,$max) ;
	$pages = search_items_linkpage($status,$p,$maxp,$found[0]['max']) ;
	include("staff_search_items_format.php");
	$sent_items = $data_items;
	//ended: loader	
//ENDED: email items report


$smarty->assign('sent_items', $sent_items);
$smarty->assign('waiting_items', $waiting_items);
$smarty->display('staff_mass_emailing.tpl');
?>