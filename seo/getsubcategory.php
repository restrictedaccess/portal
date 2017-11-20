<?php
include('../conf/zend_smarty_conf.php');
if (isset($_GET["sub_category_id"])){
	echo json_encode(array("success"=>true, "subcategory"=>$db->fetchRow($db->select()->from(array("jsc"=>"job_sub_category"))->where("jsc.sub_category_id = ?", $_GET["sub_category_id"]))));
}else{
	echo json_encode(array("success"=>true));
}
