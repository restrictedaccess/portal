<?php
include('../conf/zend_smarty_conf.php') ;
if (isset($_REQUEST["id"])){
	
	$db->update("job_order_comments", array("updated_admin_id"=>$_SESSION["admin_id"], "deleted"=>1), $db->quoteInto("id = ?", $_REQUEST["id"]));
	echo json_encode(array("success"=>true));
	
}else{
	echo json_encode(array("success"=>false));
	die;
}
