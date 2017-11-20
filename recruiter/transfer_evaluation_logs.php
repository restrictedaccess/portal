<?php
include('../conf/zend_smarty_conf.php');
ini_set("memory_limit",-1);
$evaluations = $db->fetchAll($db->select()->from("evaluation_comments", array("userid", "comment_by", "comment_date")));
foreach($evaluations as $evaluation){
	$sql = $db->select()->from("resume_evaluation_history")
		->where("userid = ?", $evaluation["userid"])
		->where("admin_id = ?", $evaluation["comment_by"])
		->where("DATE(date_created) = DATE(?)", $evaluation["comment_date"]);
		
	$found = $db->fetchRow($sql);
	if (!$found){
		$db->insert("resume_evaluation_history", array("userid"=>$evaluation["userid"],"admin_id"=>$evaluation["comment_by"],"date_created"=>$evaluation["comment_date"]));
	}
}
