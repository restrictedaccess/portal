<?php
include('../conf/zend_smarty_conf.php') ;
if (isset($_SESSION["admin_id"])){
	$hiringCoordinator = $db->fetchOne($db->select()->from("admin", array("hiring_coordinator"))->where("admin_id = ?", $_SESSION["admin_id"]));
	$assign_recruiters = $db->fetchOne($db->select()->from("admin", array("assign_recruiters"))->where("admin_id = ?", $_SESSION["admin_id"]));
	
	echo json_encode(array("admin_id"=>$_SESSION["admin_id"], "status"=>$_SESSION["status"], "hiringCoordinator"=>$hiringCoordinator, "assign_recruiters"=>$assign_recruiters));
}else{
	echo json_encode(array("admin_id"=>$_SESSION['agent_no'], "status"=>$_SESSION["status"], "hiringCoordinator"=>"N", "assign_recruiters"=>$assign_recruiters));
}
