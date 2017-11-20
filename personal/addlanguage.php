<?php
include('../conf/zend_smarty_conf.php') ;
if (!empty($_POST)){
	$userid = $_SESSION["userid"];
	$languages = $db->fetchAll($db->select()->from("language")->where("userid = ?", $userid));
	foreach($languages as $language){
		if ($language["language"]==$_POST["language"]){
			echo json_encode(array("success"=>false, "error"=>"Language has already been selected"));
			exit;
		}
	}
	$db->insert("language", $_POST);
	$id = $db->lastInsertId();
	$language = $db->fetchRow($db->select()->from("language")->where("language.id = ?", $id));
	echo json_encode(array("success"=>true, "newlanguage"=>$language));
}else{
	echo json_encode(array("success"=>false));
}