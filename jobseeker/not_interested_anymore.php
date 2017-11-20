<?php
include('../conf/zend_smarty_conf.php');
$userid = $_REQUEST["u"];
$mass_responder_code = $_REQUEST["c"];
$responder = $db->fetchRow($db->select()->from("personal_auto_sent_autoresponders")->where("mass_responder_code = ?", $mass_responder_code)->where("userid = ?", $userid));
if ($responder){
	$db->update("personal_auto_sent_autoresponders", array("responded"=>1, "mass_responder_code"=>"", "response_value"=>"not interested"), $db->quoteInto("userid = ?", $userid));
	$db->insert("staff_resume_up_to_date", array("userid"=>$userid, "admin_id"=>159, "date"=>date("Y-m-d H:i:s")));
	$db->insert("staff_resume_up_to_date", array("userid"=>$userid, "admin_id"=>159, "date"=>date("Y-m-d H:i:s")));
	$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));
	$db->insert("inactive_staff", array("userid"=>$userid, "admin_id"=>159, "type"=>"NOT INTERESTED", "date"=>date("Y-m-d H:i:s")));
	$lastInsert = $db->lastInsertId("inactive_staff");
	$db->insert("applicant_status", array("personal_id"=>$userid, "admin_id"=>159, "status"=>"NOT INTERESTED", "date"=>date("Y-m-d H:i:s"), "link_id"=>$lastInsert));
	
	$history_changes = "Candidate responded <span style='color:#ff0000'>NOT INTERESTED ANYMORE</span> on email Are you still available for a homebased job at Remote Staff?";	
	$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>"ADMIN", "change_by_id"=>159));
	
	$history_changes = "Set status to <span style='color:#ff0000'>INACTIVE - NOT INTERESTED</span>";
	$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>"ADMIN", "change_by_id"=>159));
	//traverse all categorized entries for hiding
	$jscas = $db->fetchAll($db->select()->from(array("jsca"=>"job_sub_category_applicants"), array("jsca.sub_category_applicants_date_created", "jsca.id"))->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jsca.sub_category_id", array("jsc.sub_category_name"))->where("userid = ?", $userid));
	foreach($jscas as $jsca){
		$history_changes = "Set <span style='color:#ff0000'>NO</span> on displaying in the ASL under <span style='color:#ff0000'>".$jsca["sub_category_name"]."</span>";
		$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>"ADMIN", "change_by_id"=>159));
		$db->update("job_sub_category_applicants", array("ratings"=>1), $db->quoteInto("id = ?", $jsca["id"]));
	}
	$smarty = new Smarty();
	$smarty->display("not_interested_anymore.tpl");	
}else{
	$smarty = new Smarty();
	$smarty->display("not_interested_anymore.tpl");
}
