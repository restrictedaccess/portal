<?php
include('../conf/zend_smarty_conf.php') ;
if (isset($_REQUEST["userid"])){
	$userid = $_REQUEST["userid"];
}else{
	die("Invalid userid");
}
if (!isset($_SESSION["admin_id"])){
	header("Location:/portal/");
	die;
}
$pers = $db->fetchRow($db->select()->from("personal")->where("userid = ?", $userid));

$smarty = new Smarty();
$smarty->assign("candidate", $pers);
$smarty->display("sms_sender.tpl");
