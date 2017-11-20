<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';
include '../time.php';
if(!$_SESSION['admin_id']){
	echo json_encode(array("success"=>false));
	die;
}
if (!empty($_POST)){
	unset($_POST["category_name"]);
	$row = $db->fetchRow($db->select()->from("ad_category_contents")->where("category_id = ?", $_POST["category_id"]));
	if (!$row){
		$db->insert("ad_category_contents", $_POST);
	}else{
		$db->update("ad_category_contents", $_POST, $db->quoteInto("category_id = ?", $_POST["category_id"]));
	}
	echo json_encode(array("success"=>true));
}else{
	echo json_encode(array("success"=>false));
}
