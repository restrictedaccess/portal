<?php
include '../conf/zend_smarty_conf.php';
$type = $_REQUEST["type"];
$id = $_REQUEST["id"];
$description = $_REQUEST["description"];
if ($type=="subcategory"){
	$db->update("job_sub_category", array("description"=>$description), $db->quoteInto("sub_category_id = ?", $id));
}else{
	$db->update("job_category", array("description"=>$description), $db->quoteInto("category_id = ?", $id));	
}
echo json_encode(array("success"=>true, "description"=>$description));
