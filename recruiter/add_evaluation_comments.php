<?php
include_once '../conf/zend_smarty_conf.php';
include_once '../config.php';
include_once '../conf.php';
if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL" && $_SESSION['status'] <> "COMPLIANCE"){ 
	echo "This page is for HR usage only.";
	exit;
}

if(!isset($_GET["userid"])){
	echo "This page is for HR usage only.";
	exit;
}


$name = $db->fetchRow($db->select()->from("personal", array("fname"))->where("userid = ?", $_GET["userid"]));
$smarty = new Smarty();
$smarty->assign("fname", $name["fname"]);
$smarty->assign("userid", $_GET["userid"]);
$smarty->display("add_evaluation_comments.tpl");