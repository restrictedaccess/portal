<?php
include "conf/zend_smarty_conf.php";

$rating = @$_GET["rating"];
$userid = @$_GET["userid"];
if ($rating==2){
	$rating = 0;
	$db->update("job_sub_category_applicants", array("ratings"=>$rating, "under_consideration"=>1), $db->quoteInto("id = ?", $userid));
	$jsca = $db->fetchRow($db->select()->from(array("jsca"=>"job_sub_category_applicants"), array("jsca.userid"))->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jsca.sub_category_id", array("sub_category_name"))->where("id = ?",$userid));
	$history_changes = "<span style='color:#ff0000'>Marked as Under Consideration</span> in the ASL List under <span style='color:#ff0000'>".$jsca["sub_category_name"]."</span>";
	$changeByType = $_SESSION["status"];
	if ($changeByType=="FULL-CONTROL"){
		$changeByType = "ADMIN";
	}
	
	
	$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$jsca["userid"], "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
	
}else{
	
	$db->update("job_sub_category_applicants", array("ratings"=>$rating, "under_consideration"=>0), $db->quoteInto("id = ?", $userid));
	
	
	$jsca = $db->fetchRow($db->select()->from(array("jsca"=>"job_sub_category_applicants"), array("jsca.userid"))->joinLeft(array("jsc"=>"job_sub_category"), "jsc.sub_category_id = jsca.sub_category_id", array("sub_category_name"))->where("id = ?",$userid));
	if ($rating=="0"){
		$history_changes = "<span style='color:#ff0000'>Displayed</span> in the ASL List under <span style='color:#ff0000'>".$jsca["sub_category_name"]."</span>";
	}else{
		$history_changes = "<span style='color:#ff0000'>Removed</span> in the ASL List under <span style='color:#ff0000'>".$jsca["sub_category_name"]."</span>";
	}		
	$changeByType = $_SESSION["status"];
	if ($changeByType=="FULL-CONTROL"){
		$changeByType = "ADMIN";
	}
	
	
	$db->insert("staff_history", array("changes"=>$history_changes, "userid"=>$jsca["userid"], "date_change"=>date("Y-m-d H:i:s"), "change_by_type"=>$changeByType, "change_by_id"=>$_SESSION["admin_id"]));
			
}
$userid = $jsca["userid"];
global $curl;
global $base_api_url;
if (TEST){
	$curl->get("http://test.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php", array("userid" => $userid));
	//file_get_contents("http://test.api.remotestaff.com.au/solr-index/sync-asl/?userid=".$userid);
	//file_get_contents("http://test.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);        
}else if(STAGING){
	//$curl->get("http://staging.api.remotestaff.com.au/solr-index/sync-asl/", array("userid" => $userid));
	$curl->get("http://staging.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php", array("userid" => $userid));
	//file_get_contents("http://staging.remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php?userid=".$userid);
	//file_get_contents("http://staging.api.remotestaff.com.au/solr-index/sync-asl/?userid=".$userid);
} else{
	//$curl->get("http://api.remotestaff.com.au/solr-index/sync-asl/", array("userid" => $userid));
	$curl->get("http://remotestaff.com.au/portal/cronjobs/sync_recruiter_home_to_mongo.php", array("userid" => $userid));
}


$curl->get($base_api_url. "/solr-index/sync-asl/", array("userid" => $userid));


?>
<script language="javascript">
	alert("Action has been successfully saved.");
	window.close();
</script>
