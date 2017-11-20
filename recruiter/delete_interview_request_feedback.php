<?php
include '../conf/zend_smarty_conf.php';
if ($_REQUEST["id"]){
	$db->delete("request_for_interview_feedbacks", $db->quoteInto("id = ?", $_REQUEST["id"]));	
	echo json_encode(array("success"=>true));
}else{
	echo json_encode(array("success"=>false));
}
