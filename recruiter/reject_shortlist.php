<?php
include('../conf/zend_smarty_conf.php') ;
if (!$_SESSION["admin_id"]){
	die;
}
if ($_REQUEST["id"]){
	$db->update("tb_shortlist_history", array("rejected"=>1, "feedback"=>$_REQUEST["feedback"], "rejected_by"=>$_SESSION["admin_id"], "date_rejected"=>date("Y-m-d H:i:s")), $db->quoteInto("id = ?", $_REQUEST["id"]));
	//get userid
	$shortlist = $db->fetchRow($db->select()->from(array("sh"=>"tb_shortlist_history"), array("userid"))->where("sh.id = ?", $_REQUEST["id"])
								->joinLeft(array("p"=>"posting"), "p.id = sh.position", array("p.lead_id", "p.jobposition", "p.id AS posting_id")));
	if ($shortlist){
		$userid = $shortlist["userid"];
		
		//personal record
		$personal = $db->fetchRow($db->select()->from(array("p"=>"personal"), array("fname", "lname"))->where("userid = ?", $userid));
		//lead
		$lead = $db->fetchRow($db->select()->from(array("l"=>"leads"), array("fname", "lname"))->where("l.id = ?", $shortlist["lead_id"]));
		
		$history_changes = "Candidate's shortlist to <a href='/portal/leads_information.php?id=".$shortlist["lead_id"]."&page_type=popup' target='_blank'>".$lead["fname"]." ".$lead["lname"]."</a> for the position <a href='/portal/Ad.php?id=".$shortlist["posting_id"]."' target='_blank'>{$shortlist["jobposition"]}</a> has been <span style='color:#ff0000'>rejected</span>.";
		$changeByType = "admin";
		$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));	
		echo json_encode(array("success"=>true));
	}else{
		echo json_encode(array("succes"=>false, "error"=>"Invalid request"));
	}
}else{
	echo json_encode(array("succes"=>false, "error"=>"Invalid request"));
}
