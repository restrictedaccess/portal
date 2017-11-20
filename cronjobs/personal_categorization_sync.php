<?php
ini_set("max_execution_time", 300);
require_once('../conf/zend_smarty_conf.php');
$unprocessedStaffs = $db->fetchAll($db->select()->from(array("us"=>"unprocessed_staff")));
$db->query("TRUNCATE personal_categorization_entries");
foreach($unprocessedStaffs as $unprocessedStaff){
	$currentjob = $db->fetchRow($db->select()->from(array("c"=>"currentjob"))->where("c.userid = ?", $unprocessedStaff["userid"]));
	if ($currentjob["position_first_choice"]){
		$row = $db->fetchRow($db->select()->from(array("pce"=>"personal_categorization_entries"), array("id"))->where("pce.sub_category_id = ?", $currentjob["position_first_choice"])->where("pce.userid = ?", $currentjob["userid"]));
		if (!$row){
			$category = $db->fetchRow($db->select()->from("job_sub_category")->where("sub_category_id = ?", $currentjob["position_first_choice"]));
			$db->insert("personal_categorization_entries", array("userid"=>$unprocessedStaff["userid"], "sub_category_id"=>$currentjob["position_first_choice"], "category_id"=>$category["category_id"]));
		}
	}
	if ($currentjob["position_second_choice"]){
		$row = $db->fetchRow($db->select()->from(array("pce"=>"personal_categorization_entries"), array("id"))->where("pce.sub_category_id = ?", $currentjob["position_second_choice"])->where("pce.userid = ?", $currentjob["userid"]));
		if (!$row){
			$category = $db->fetchRow($db->select()->from("job_sub_category")->where("sub_category_id = ?", $currentjob["position_second_choice"]));
			$db->insert("personal_categorization_entries", array("userid"=>$unprocessedStaff["userid"], "sub_category_id"=>$currentjob["position_second_choice"], "category_id"=>$category["category_id"]));
		}
	}
	if ($currentjob["position_third_choice"]){
		$row = $db->fetchRow($db->select()->from(array("pce"=>"personal_categorization_entries"), array("id"))->where("pce.sub_category_id = ?", $currentjob["position_third_choice"])->where("pce.userid = ?", $currentjob["userid"]));
		if (!$row){
			$category = $db->fetchRow($db->select()->from("job_sub_category")->where("sub_category_id = ?", $currentjob["position_third_choice"]));
			$db->insert("personal_categorization_entries", array("userid"=>$unprocessedStaff["userid"], "sub_category_id"=>$currentjob["position_third_choice"], "category_id"=>$category["category_id"]));
		}
	}
}