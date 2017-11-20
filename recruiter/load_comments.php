<?php
include('../conf/zend_smarty_conf.php') ;
if (!isset($_REQUEST["tracking_code"])){
	echo "Invalid request";
	die;
}
$tracking_code =  $_REQUEST["tracking_code"];
$comments = $db->fetchAll($db->select()->from(array("joc"=>"job_order_comments"))
							->joinInner(array("a"=>"admin"), "a.admin_id = joc.admin_id", array("a.admin_fname", "a.admin_lname"))

							->where("tracking_code = ?",$tracking_code)
							->where("deleted = 0")->order("date_created DESC")
							);
if (isset($_SESSION["agent_no"])){
	$hm = false;
}else{
	$hm = true;	
}
$smarty = new Smarty();
$smarty->assign("comments", $comments);
$smarty->assign("hm", $hm);
$smarty->assign("tracking_code", $tracking_code);
if (isset($_REQUEST["bootstrap"])){
	$smarty->display("load_comments_bootstrap.tpl");
	
}else{
	$smarty->display("load_comments.tpl");
	
}
