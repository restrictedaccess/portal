<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';
include '../time.php';
if(!$_SESSION['admin_id']){
	echo json_encode(array("success"=>false, "error"=>"Please login to add new redirect"));
	die;
}
if (!($_REQUEST["category_url"]||$_REQUEST["sub_category_url"])){
	echo json_encode(array("success"=>false, "error"=>"Category URL or Subcategory URL is required"));
	die;
}

if (!$_REQUEST["redirects"]){
	echo json_encode(array("success"=>false, "error"=>"Redirect is required"));
	die;
}

$data = $_POST;
$db->insert("url_redirects", $data);

echo json_encode(array("success"=>true));
