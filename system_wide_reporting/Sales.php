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


$current_date = date("Y-m-d");
$smarty->assign('current_date',$current_date);
$smarty->display('Sales.tpl');
?>