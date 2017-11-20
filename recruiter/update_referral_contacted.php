<?php
include('../conf/zend_smarty_conf.php');
if (!isset($_SESSION["admin_id"])){
	die;
}
if (isset($_POST["contacted"])&&isset($_POST["id"])){
	$contacted = $_POST["contacted"];
	$id = $_POST["id"];
	$db->update("referrals", array("contacted"=>$contacted), "id = {$id}");
	echo json_encode(array("success"=>true));
}else{
	echo json_encode(array("success"=>false));
}