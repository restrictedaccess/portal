<?php
include('../conf/zend_smarty_conf.php');
if (isset($_REQUEST["userid"])){
	$userid = $_REQUEST["userid"];
}else{
	die("Invalid userid");
}
if (!isset($_SESSION["admin_id"])){
	header("Location:/portal/");
	die;
}
$pers = $db->fetchRow($db->select()->from("personal")->where("userid = ?", $userid));

$userid = $_REQUEST["userid"];
$sql = $db->select()->from(array("s"=>"staff_admin_sms_out_messages"), 
			array("s.message AS message",
				"s.mobile_number AS mobile_number",
				"s.date_created AS date_created",
				new Zend_Db_Expr("CONCAT('admin') AS message_type")))
			->joinInner(array("adm"=>"admin"), "adm.admin_id=s.admin_id", array(new Zend_Db_Expr("CONCAT(adm.admin_fname, ' ',adm.admin_lname) AS sender")))
			->where("s.userid = ?", $userid);
$sql2 = $db->select()->from(array("s"=>"staff_admin_sms_in_messages"), 
			array("s.message AS message",
				"s.mobile_number AS mobile_number",
				"s.date_created AS date_created",
				new Zend_Db_Expr("CONCAT('staff') AS message_type")))
				->joinInner(array("p"=>"personal"), "p.userid = s.userid", array(new Zend_Db_Expr("CONCAT(p.fname, ' ', p.lname) AS sender")))
			->where("s.userid = ?", $userid);	
$sms = $db->fetchAll($db->select()->union(array($sql, $sql2))->order("date_created DESC"));
foreach($sms as $key=>$val){
	$sms[$key]["date_created"] = date("F d, Y h:i:s A", strtotime($val["date_created"]));
}
$smarty = new Smarty();
$smarty->assign("sms", $sms);
$smarty->assign("candidate", $pers);
$smarty->display("sms_log.tpl");
