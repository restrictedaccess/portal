<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';
include '../time.php';
if(!$_SESSION['admin_id']){
	echo json_encode(array("success"=>false, "error"=>"Please login to delete redirects"));
	die;
}
if ($_REQUEST["id"]){
	$db->delete("url_redirects", $db->quoteInto("id = ?", $_REQUEST["id"]));
	echo json_encode(array("success"=>true));
}else{
	echo json_encode(array("success"=>false, "error"=>"Invalid Request"));
	die;
}
