<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';

$smarty = new Smarty;

if (!isset($_SESSION["status"])){
	header("location:/portal/index.php");
}


if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL" && $_SESSION['status'] <> "COMPLIANCE"){ 
	echo "This page is for HR usage only.";
	exit;
}


header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty->display("guide_for_pay_rates.tpl");