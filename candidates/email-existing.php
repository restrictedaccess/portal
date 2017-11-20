<?php
include_once '../conf/zend_smarty_conf.php';
if (isset($_REQUEST["email"])){
	//check if existing email
	if (isset($_REQUEST["userid"])){
		$row = $db->fetchRow($db->select()->from("personal", "email")->where("userid = ?", $_REQUEST["userid"]));	
		if ($row["email"]==$_REQUEST["email"]){
			echo json_encode(array("success"=>false));
			die;
		}
			
	}
	
	$row = $db->fetchRow($db->select()->from("personal")
								->where("email = ?", $_REQUEST["email"]));	
	if ($row){
		if ($row["fname"]==""&&$row["lname"]==""){
			echo json_encode(array("success"=>false));
		}else{
			echo json_encode(array("success"=>true));
			
		}
	}else{
		echo json_encode(array("success"=>false));
	}
}else{
	echo json_encode(array("success"=>false));
}
