<?php
include('../conf/zend_smarty_conf.php');
if (isset($_GET["id"])){	
	$skill = $db->fetchRow($db->select()->from("defined_skills")->where("id = ?", $_GET["id"]));
	if ($skill){
		$skill["other_terms"] = $db->fetchAll($db->select()->from("defined_skill_other_terms")->where("defined_skill_id = ?", $skill["id"]));
		echo json_encode($skill);
	}else{
		echo json_encode(array());
	}
}else{
	echo json_encode(array());
}
