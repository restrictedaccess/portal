<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();

if (isset($_SESSION["mobile_number"])){
	$smarty->assign("mobile_number", $_SESSION["mobile_number"]);
}
if (isset($_SESSION["email"])){
	$smarty->assign("email", $_SESSION["email"]);
}
$smarty->assign("TEST", TEST);
$smarty->display("fb_capture.tpl");
