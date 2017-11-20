<?php
include '../conf/zend_smarty_conf.php';
$applicants = $db->fetchAll($db->select()->from(array("jsca"=>"job_sub_category_applicants"), array("id", "userid", "under_consideration"))->where("jsca.ratings = 0"));
foreach($applicants as $applicant){
	$db->update("job_sub_category_applicants", array("auto_underconsidered"=>0), $db->quoteInto("id = ?", $applicant["id"]));				
	$count1 = $db->fetchRow($db->select()->from(array("tbr"=>"tb_request_for_interview"), array("COUNT(*) AS count"))->where("applicant_id = ?", $applicant["userid"])->where("status IN ('NEW', 'ACTIVE', 'ON-HOLD', 'CONFIRMED', 'YET TO CONFIRM', 'DONE', 'RE-SCHEDULED', 'ON TRIAL')"));
	$count1 = $count1["count"];
	if ($count1>=2){
		$db->update("job_sub_category_applicants", array("auto_underconsidered"=>1), $db->quoteInto("id = ?", $applicant["id"]));
	}else{
		$count2 = $db->fetchRow($db->select()->from(array("tbr"=>"tb_request_for_interview"), array("COUNT(*) AS count"))->where("job_sub_category_applicants_id = ?", $applicant["id"])->where("status = 'ON TRIAL'"));
		$count2 = $count2["count"];
		if ($count2>=1){
			$db->update("job_sub_category_applicants", array("auto_underconsidered"=>1), $db->quoteInto("id = ?", $applicant["id"]));			
		}else if ($applicant["under_consideration"]==1){
			$db->update("job_sub_category_applicants", array("auto_underconsidered"=>1), $db->quoteInto("id = ?", $applicant["id"]));			
		}	
	}
	
}
