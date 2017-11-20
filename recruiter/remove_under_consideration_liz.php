<?php
ini_set("memory_limit", -1);
include('../conf/zend_smarty_conf.php') ;
$admin_id = 159;
$applicants = $db->fetchAll("SELECT a.applicant_id, (SELECT COUNT(*) FROM `tb_request_for_interview` WHERE DATE(date_interview) <= DATE('2014-05-31') AND status IN (\"NEW\", \"ACTIVE\", \"ON-HOLD\", \"CONFIRMED\", \"YET TO CONFIRM\", \"DONE\", \"RE-SCHEDULED\", \"ON TRIAL\") AND applicant_id = a.applicant_id) AS count_interviews   FROM `tb_request_for_interview` AS a WHERE DATE(date_interview) <= DATE('2014-05-31') AND status IN (\"NEW\", \"ACTIVE\", \"ON-HOLD\", \"CONFIRMED\", \"YET TO CONFIRM\", \"DONE\", \"RE-SCHEDULED\", \"ON TRIAL\") AND applicant_id IN (SELECT userid FROM job_sub_category_applicants) GROUP BY applicant_id HAVING count_interviews >= 2 AND applicant_id <> ''");
foreach($applicants as $applicant){
	$userid = $applicant["applicant_id"];
	$interviews = $db->fetchAll("SELECT id,leads_id FROM `tb_request_for_interview` WHERE DATE(date_interview) <= DATE('2014-05-31') AND status IN (\"NEW\", \"ACTIVE\", \"ON-HOLD\", \"CONFIRMED\", \"YET TO CONFIRM\", \"DONE\", \"RE-SCHEDULED\", \"ON TRIAL\") AND applicant_id = ".$userid);
	foreach($interviews as $interview){
		$lead = $db->fetchRow($db->select()->from("leads", array("fname", "lname"))->where("id = ?", $interview["leads_id"]));
		$history = array(
			"userid"=>$userid,
			"change_by_id"=>$admin_id,
			"change_by_type"=>"ADMIN",
			"changes"=>"Interview with lead <span style='color:#ff0000'>".$lead["fname"]." ".$lead["lname"]."</span> has been set to <span style='color:#ff0000'>ARCHIVED</span> as per requested.",
			"date_change"=>date("Y-m-d H:i:s")
		);
		
		$db->insert("staff_history", $history);
		$db->update("tb_request_for_interview", array("status"=>"ARCHIVED"), $db->quoteInto("id = ?", $interview["id"]));
	}
	
}
