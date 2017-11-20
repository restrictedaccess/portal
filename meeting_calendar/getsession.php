<?php
include "../conf/zend_smarty_conf.php";
if (isset($_SESSION["admin_id"])){
	$result["success"] = true;
	$result["admin_id"] = $_SESSION["admin_id"];
	$row = $db->fetchRow($db->select()->from(array("a"=>"admin"), array("view_admin_calendar", "admin_fname", "admin_lname"))->where("admin_id = ?", $_SESSION["admin_id"]));
	$result["view_other_calendar"] = $row["view_admin_calendar"];
	$result["name"] = $row["admin_fname"]." ".$row["admin_lname"];
}else{
	$result["success"] = false;
}
echo json_encode($result);
