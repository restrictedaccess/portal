<?php
include('../conf/zend_smarty_conf.php');
require_once dirname(__FILE__)."/../lib/JobOrderManager.php";

if ($_POST["tracking_code"]&&$_POST["status"]){
	$manager = new JobOrderManager($db);
	$manager->hiringStatus($_POST["tracking_code"], $_POST["status"]);
	echo json_encode(array("success"=>true));
}else{
	echo json_encode(array("success"=>false));
}
