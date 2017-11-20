<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';
include '../time.php';
if(!$_SESSION['admin_id']){
	echo json_encode(array("success"=>false));
	die;
}
if (!empty($_POST)){
	$row = $db->fetchRow($db->select()->from("job_category")->where("category_id = ?", $_POST["category_id"]));
	if (!$row){
		$db->insert("job_category", $_POST);
	}else{
		$row = $db->fetchRow($db->select()->from("job_category")->where("category_id = ?", $_POST["category_id"]));
		if ($row&&!is_null($row["url"])){
			$row2 = $db->fetchRow($db->select()->from("job_category_url_change_logs")->where("url = ?", $row["url"]));
			if (!$row2){
				$db->insert("job_category_url_change_logs", array("category_id"=>$_POST["category_id"], "url"=>$row["url"], "date_created"=>date("Y-m-d H:i:s")));		
			}
			
		}
		$db->update("job_category", $_POST, $db->quoteInto("category_id = ?", $_POST["category_id"]));
	}
	echo json_encode(array("success"=>true));
}else{
	echo json_encode(array("success"=>false));
}
