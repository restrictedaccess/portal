<?php
include ('../conf/zend_smarty_conf.php');
require_once "classes/RegisterStep2.php";
if (isset($_REQUEST["category_id"])){
	$category_id = $_REQUEST["category_id"];
	$step = new RegisterStep2($db);
	$subcategories = $step->getSubCategories($category_id);
	echo json_encode(array("success"=>true, "subcategories"=>$subcategories));
}else{
	echo json_encode(array("success"=>false, "error"=>"Missing category id"));
}
