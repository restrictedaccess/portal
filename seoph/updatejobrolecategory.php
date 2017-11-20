<?php
include('../conf/zend_smarty_conf.php');

if(!$_SESSION['admin_id']){
	echo json_encode(array("success"=>false));
	die;
}
if (!empty($_POST)){
	unset($_POST["cat_name"]);
	$row = $db->fetchRow($db->select()->from("job_role_category")->where("jr_cat_id = ?", $_POST["jr_cat_id"]));
	if (!$row){
		$db->insert("job_role_category", $_POST);
	}else{
		$db->update("job_role_category", $_POST, $db->quoteInto("jr_cat_id = ?", $_POST["jr_cat_id"]));
	}
	echo json_encode(array("success"=>true));
}else{
	echo json_encode(array("success"=>false));
}
