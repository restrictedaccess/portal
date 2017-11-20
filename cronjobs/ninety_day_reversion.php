<?php
include('../conf/zend_smarty_conf.php');
if (isset($_GET["userid"])){
    $staff_history = $db->fetchAll("SELECT userid FROM staff_history WHERE changes LIKE '%INACTIVE - NOT INTERESTED</span> since%' AND date_change >= DATE('2015-01-01') AND userid = '{$_GET["userid"]}'");
}else{
    $staff_history = $db->fetchAll("SELECT userid FROM staff_history WHERE changes LIKE '%INACTIVE - NOT INTERESTED</span> since%' AND (date_change >= DATE('2014-06-01') AND date_change <= DATE('2014-12-31'))");    
}
foreach($staff_history as $staff_history_item){
	$userid = $staff_history_item["userid"];
	echo "{$staff_history_item["userid"]}<br/>";
	$responder = $db->fetchRow($db->select()->from("personal_auto_sent_autoresponders")->where("userid = ?", $userid));
	if ($responder){
		$db->update("personal_auto_sent_autoresponders", array("responded"=>1, "mass_responder_code"=>"", "response_value"=>"still available"), $db->quoteInto("userid = ?", $userid));
		$db->insert("staff_resume_up_to_date", array("userid"=>$userid, "admin_id"=>159, "date"=>date("Y-m-d H:i:s")));
		$db->update("personal", array("dateupdated"=>date("Y-m-d H:i:s")), $db->quoteInto("userid = ?", $userid));
		$history_changes = "Candidate responded <span style='color:#ff0000'>STILL AVAILABLE</span> on email Are you still available for a homebased job at Remote Staff?";	
		$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>"ADMIN", "change_by_id"=>159));
		//traverse all categorized entries for recategorization
		$inactive_entries = $db->fetchAll($db->select()->from(array("in"=>"inactive_staff"))->where("in.type = ?", "NOT INTERESTED")->where("userid = ?", $userid));
		if (!empty($inactive_entries)){
			foreach($inactive_entries as $inactive_entry){
				$db->delete("inactive_staff", $db->quoteInto("id = ?", $inactive_entry["id"]));		
			}
			$history_changes = "<span style='color:#ff0000'>REMOVED</span> from <span style='color:#ff0000'>INACTIVE - NOT INTERESTED</span>";			
			if ($_SESSION["admin_id"]){
				$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>"ADMIN", "change_by_id"=>$_SESSION["admin_id"]));
			}else{
				$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>"ADMIN", "change_by_id"=>159));
			}
		}
		
		//revert categorization display
		$pac = $db->fetchAll($db->select()->from("personal_autohide_categorization")->where("userid = ?", $userid));
		if (!empty($pac)){
			foreach($pac as $item){
				$sql = $db->select()->from(array("jsca"=>"job_sub_category_applicants"), array("jsca.id"))->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jsca.sub_category_id", array("jsc.sub_category_name"))->where("jsca.id = ?", $item["jsca_id"]);
				$jsca = $db->fetchRow($sql);
				$history_changes = "<span style='color:#ff0000'>Displayed back</span> in the ASL List under <span style='color:#ff0000'>".$jsca["sub_category_name"]."</span> since responded as still available";
				if ($_SESSION["admin_id"]){
					$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>"ADMIN", "change_by_id"=>$_SESSION["admin_id"]));
				}else{
					$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$userid, "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>"ADMIN", "change_by_id"=>159));
				}
				$db->update("job_sub_category_applicants", array("ratings"=>0), $db->quoteInto("id = ?", $item["jsca_id"]));
			}
			$db->delete("personal_autohide_categorization", $db->quoteInto("userid = ?", $userid));		
		}

		$jscas = $db->fetchAll($db->select()->from(array("jsca"=>"job_sub_category_applicants"), array("jsca.sub_category_applicants_date_created", "jsca.id"))->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jsca.sub_category_id", array("jsc.sub_category_name"))->where("userid = ?", $userid));
		foreach($jscas as $jsca){
			$db->update("job_sub_category_applicants", array("recategorized_date"=>date("Y-m-d H:i:s")), $db->quoteInto("id = ?", $jsca["id"]));
		}
	}
}
