<?php
include('../conf/zend_smarty_conf.php') ;
if ($_POST){
	$data = $_POST;
	
	if (trim($data["feedback"])==""){
		echo json_encode(array("success"=>false, "error"=>"Feedback field is required"));
		die;
	}
	$data["admin_id"] = $_SESSION["admin_id"];
	$data["date_created"] = date("Y-m-d H:i:s");
	
	$db->insert("request_for_interview_feedbacks", $data);
	
	
	$db->update("tb_request_for_interview", array("date_updated"=>date("Y-m-d H:i:s")), $db->quoteInto("id = ?", $data["request_for_interview_id"]));
	
	echo json_encode(array("success"=>true));
}else{
	echo json_encode(array("success"=>false, "error"=>"Request is invalid"));
}
