<?php
include '../conf/zend_smarty_conf.php';
$admin_id = $_GET["admin_id"];
$result = $db->fetchRow($db->select()->from("sms_admin_notifications")->where("admin_id = ?", $admin_id));
if ($result){
	$db->delete("sms_admin_notifications", $db->quoteInto("admin_id = ?", $admin_id));
	echo json_encode(array("success"=>true, "hasMessage"=>true));
}else{
	echo json_encode(array("success"=>true, "hasMessage"=>false));	
}
