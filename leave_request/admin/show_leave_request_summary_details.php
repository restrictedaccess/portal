<?php
include '../../conf/zend_smarty_conf.php';
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;



if(!isset($_GET['summary_type'])){
	die("summary_type is missing");
}

if(!$_GET['summary_type']){
	die("summary_type cannot be null");	
}

$summary_type = $_GET['summary_type'];


if($summary_type == 'total per year'){
	if(!isset($_GET['year'])){
		die("Year is missing");
	}
	
	if(!$_GET['year']){
		die("Year cannot be null");
	}
	$smarty->assign('year' , $_GET['year']);
	
}

if($summary_type == 'today'){
	if(!isset($_GET['status'])){
		die("leave status is missing");
	}
	
	if(!$_GET['status']){
		die("leave status cannot be null");
	}
	$smarty->assign('status' , $_GET['status']);
	$smarty->assign('inhouse' , $_GET['inhouse']);
}

$smarty->assign('summary_type' , $_GET['summary_type']);
$smarty->display('show_leave_request_summary_details.tpl');
?>