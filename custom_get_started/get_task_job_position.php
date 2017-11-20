<?php
include ('../conf/zend_smarty_conf.php');
$sub_category_id = $_REQUEST["sub_category_id"];
$response = array();
if ($sub_category_id){
	$job_sub_cat = $db->fetchRow($db->select()->from("job_sub_category", array("sub_category_name", "sub_category_id"))->where("sub_category_id = ?", $sub_category_id));
	
	if (!$job_sub_cat){
		$response["success"] = false;
		$response["error"] = "Sub Category Not Found";
		echo json_encode($response);
		die;
	}
	
	$response = array("success"=>true);
    $sql1 = $db->select()->from("job_position_skills_tasks", array("id", "value", "sub_category_id"))->where("sub_category_id = ?", $sub_category_id)->where("type = ?", "task")->where("display_website = ?", "YES");
    $sql2 = $db->select()->from("job_position_skills_tasks", array("id", "value", "sub_category_id"))->where("sub_category_id = ?", $sub_category_id)->where("type = ?", "task")->where("leads_id = ?", $_SESSION["leads_id"]);
    $sql = $db->select()->union(array($sql1, $sql2));    
	$response["result"] = $db->fetchAll($sql);
	$response["sub_category"] = $job_sub_cat;
	echo json_encode($response);
	die;
}else{
	$response["success"] = false;
	$response["error"] = "Sub Category ID is needed";
	echo json_encode($response);
	die;
}
