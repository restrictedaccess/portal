<?php
include('../conf/zend_smarty_conf.php') ;
if (!empty($_POST)){

	$userid = $_SESSION["userid"];
	$skills = $db->fetchAll($db->select()->from("skills", array("skill"))->where("userid = ?", $userid));
	foreach($skills as $skill){
		if (strtolower($skill["skill"])==strtolower($_POST["skill"])){
			echo json_encode(array("success"=>false, "error"=>"You already listed that skill. Please try again."));
			exit;
		}	
	}
	$db->insert("skills", $_POST);
	$id = $db->lastInsertId("skills");
	$skill = $db->fetchRow($db->select()->from("skills")->where("id = ?", $id));
	echo json_encode(array("success"=>true, "newskill"=>$skill));
}else{
	echo json_encode(array("success"=>false));
}