<?php
include('../conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

if(!$_SESSION['admin_id']){
	die("Session Expires. Please re-login");
}


$date = new DateTime();
$start_date_ref = $date->format('Y-m-01');
$end_date_ref = $date->format('Y-m-t');

//echo $start_date_ref." - ".$end_date_ref;
$smarty->assign('start_date_ref',$start_date_ref);
$smarty->assign('end_date_ref',$end_date_ref);
$smarty->display('Recruitment.tpl');
?>