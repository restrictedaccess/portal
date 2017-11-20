<?php
include '../conf/zend_smarty_conf.php';
if (isset($_REQUEST["mobile_number"])){
	$_SESSION["mobile_number"] = $_REQUEST["mobile_number"];
}
if (isset($_REQUEST["email"])){
	$_SESSION["email"] = $_REQUEST["email"];
}
header("Location:/portal/application_form/fb_capture.php");
