<?php
include '../conf/zend_smarty_conf.php';
$categories = $db->fetchAll($db->select()->from(array("c"=>"job_category"), array("category_id", "category_name"))->where("status = ?", "posted")->order("category_name"));
foreach($categories as $key=>$category){
	$subcategories = $db->fetchAll($db->select()->from(array("s"=>"job_sub_category"), array("sub_category_id", "sub_category_name"))->where("category_id = ?", $category["category_id"]));
	$categories[$key]["subcategories"] = $subcategories;
}

echo json_encode($categories);
