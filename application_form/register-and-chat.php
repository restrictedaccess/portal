<?php
include '../time.php';
include '../conf/zend_smarty_conf.php';
if (isset($_GET["userid"])&&(isset($_GET["email"]))){
	$_SESSION["userid"] = $_GET["userid"];
	$sql = $db->select()->from("personal", array("email"))->where("userid = ?", $_GET["userid"]);
	$info = $db->fetchRow($sql);
	$_SESSION["emailaddr"] = $info["email"];
	$_SESSION["launch_chat"] = true;
	header("Location:/portal/applicantHome.php");
}else{
	header("Location:/portal/application_form/registernow-step8-uploadphoto.php");
}