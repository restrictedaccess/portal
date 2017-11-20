<?php
include('../conf/zend_smarty_conf.php');
if (isset($_GET["category_id"])){
	echo json_encode(array("success"=>true, category=>$db->fetchRow($db->select()->from(array("jc"=>"job_category"))->where("jc.category_id = ?", $_GET["category_id"]))));
}else{
	echo json_encode(array("success"=>true));
}
