<?php
include('../conf/zend_smarty_conf.php') ;
include('../time.php');
if (!isset($_SESSION["admin_id"])){
	die;
}
$result = array();
if ($_POST){
	$data = $_POST;
	if (isset($data["contract_sent"])&&$data["contract_sent"]=="on"){
		$data["contract_sent"] = 1;
	}else{
		$data["contract_sent"] = 0;
		$data["contract_sent_date"] = null;
	}
	if (isset($data["client_contract_sent"])&&$data["client_contract_sent"]=="on"){
		$data["client_contract_sent"] = 1;
	}else{
		$data["client_contract_sent"] = 0;
		$data["client_contract_sent_date"] = null;
	}
	
	$row = $db->fetchRow($db->select()->from("request_for_interview_notes", array("id"))->where("request_for_interview_id = ?", $_POST["request_for_interview_id"]));
	$leads_id = $data["leads_id"];
	$gst = $data["gst"];
	if ($row){
		unset($data["id"]);
		unset($data["gst"]);
		unset($data["leads_id"]);
		$data["date_updated"] = date("Y-m-d H:i:s");
		$db->update("request_for_interview_notes", $data, $db->quoteInto("request_for_interview_id = ?", $_POST["request_for_interview_id"]));
	}else{
		$data["date_created"] = date("Y-m-d H:i:s");
		unset($data["gst"]);
		unset($data["leads_id"]);
		$db->insert("request_for_interview_notes", $data);
	}
	
	$db->update("tb_request_for_interview", array("date_updated"=>date("Y-m-d H:i:s")), $db->quoteInto("id = ?", $data["request_for_interview_id"]));
	
	
	$data["currency"] = $db->fetchOne($db->select()->from("currency_lookup", "code")->where("id = ?", $data["currency"]));
	if ($data["contract_sent_date"]=="0000-00-00"){
		$data["contract_sent_date"] = "";
	}
	$db->update("leads", array("apply_gst"=>$gst), $db->quoteInto("id = ?", $leads_id));
	$result["success"] = true;
	$data["leads_id"] = $leads_id;
	if ($gst=="yes"){
		$data["gst"] = "Yes";		
	}else{
		$data["gst"] = "No";
	}

	$result["saveData"] = $data;
}else{
	$result["success"] = false;
}
echo json_encode($result);