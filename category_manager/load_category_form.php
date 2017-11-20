<?php
include '../conf/zend_smarty_conf.php';
$type = $_REQUEST["type"];
$id = $_REQUEST["id"];

if ($type=="category"){
	$desc = $db->fetchRow($db->select()->from(array("jc"=>"job_category"))->where("category_id = ?", $id));
}else{
	$desc = $db->fetchRow($db->select()->from(array("jc"=>"job_sub_category"))->where("sub_category_id = ?", $id));
}
$smarty = new Smarty();
$smarty->assign("desc", $desc);
$smarty->assign("type", $type);
$smarty->display("description.tpl");
