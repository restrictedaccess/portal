<?php
include('../conf/zend_smarty_conf.php') ;
if (!isset($_SESSION["admin_id"])){
	echo json_encode(array("success"=>false));	
	die;
}
if (isset($_REQUEST["id"])){
	
	
	$db->update("applicants", array("expired"=>1), $db->quoteInto("id = ?", $_REQUEST["id"]));
	$applicant = $db->fetchRow($db->select()->from(array("a"=>"applicants"), array("userid"))->joinInner(array("p"=>"posting"), "p.id = a.posting_id", array("jobposition"))->where("a.id = ?", $_REQUEST["id"]));
	
	if ($applicant){
		
		
		$changeByType = $_SESSION["status"];
		if ($changeByType=="FULL-CONTROL"){
			$changeByType = "ADMIN";
		}
		$msg = "candidate withdraw application from the job posting <span style='color:#ff0000'>".$applicant["jobposition"]."</span>";
		$db->insert("staff_history", array("changes"=>$msg, "userid"=>$applicant["userid"], "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
	}
	
	global $curl;
	global $base_api_url;
	
	//$curl->get($base_api_url . '/mongo-index/sync-all-candidates', array("userid" => $applicant["userid"]));
	
	
	echo json_encode(array("success"=>true));
}else{
	echo json_encode(array("success"=>false));
}
