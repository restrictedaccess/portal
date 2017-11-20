<?php
include('../conf/zend_smarty_conf.php') ;
if (isset($_POST["id"])){
	$userid = $_SESSION["userid"];
	$type = $_POST["type"];
	$db->delete("skills", "id = ".$_POST["id"]);
	if ($type=="other"){
		$skills = $db->fetchAll($db->select()->from("skills")->where("userid = ?", $userid)->where("skill_type IS NULL"));	
	}else{
		$skills = $db->fetchAll($db->select()->from("skills")->where("userid = ?", $userid)->where("skill_type = ?", $type));	
	}
	echo json_encode(array("success"=>true, "skills"=>$skills));
}else{
	echo json_encode(array("false"=>true));
}