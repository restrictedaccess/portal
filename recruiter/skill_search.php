<?php
include_once '../conf/zend_smarty_conf.php';
if (isset($_GET["name"])){
	$skill = $_GET["name"];
	$skill = addslashes($skill);
	$skills = $db->fetchAll($db->select()->from(array("s"=>"defined_skills"))
					->where("MATCH(skill_name) AGAINST ('".$skill."' IN BOOLEAN MODE)")
					->orWhere("skill_name LIKE '%".$skill."%'")->limit(10));
	echo json_encode($skills);
}else{
	echo json_encode(array());
}
