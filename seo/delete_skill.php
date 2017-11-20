<?php
include('../conf/zend_smarty_conf.php');
$id = $_GET["id"];
if(!$_SESSION['admin_id']){
	echo json_encode(array("success"=>false));
	die;
}
if (isset($_GET["id"])){
	$db->delete("defined_skills", $db->quoteInto("id = ?", $id));
	$db->delete("defined_skill_other_terms", $db->quoteInto("defined_skill_id = ?", $id));
	echo json_encode(array("success"=>true));
}else{
	echo json_encode(array("success"=>false));
}
