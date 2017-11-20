<?php
include('../conf/zend_smarty_conf.php') ;
if (isset($_POST["id"])){
	$userid = $_SESSION["userid"];
	$db->delete("language", "id = ".$_POST["id"]);
	$languages = $db->fetchAll($db->select()->from("language")->where("userid = ?", $userid));
	echo json_encode(array("success"=>true, "languages"=>$languages));
}else{
	echo json_encode(array("false"=>true));
}