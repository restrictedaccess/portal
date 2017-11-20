<?php
if (!isset($included)){
	include_once '../conf/zend_smarty_conf.php';
	include_once '../config.php';
	include_once '../conf.php';
}
session_start();
$endorsedStaffs = $_SESSION["TO_BE_ENDORSED"];
$staffs = array();
if (!empty($endorsedStaffs)){

	foreach($endorsedStaffs as $userid){
		$query="SELECT * FROM personal p  WHERE p.userid=$userid";
		$staff = $db->fetchRow($query);
		$query="SELECT id, skill, experience, proficiency FROM skills WHERE userid=$userid;";
		$skills = $db->fetchAll($query);
		$staffs[] = array("userid"=>$staff["userid"], "firstName"=>$staff["fname"], "skills"=>$skills);
	}
}
echo json_encode($staffs);