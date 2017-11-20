<?php
include('../conf/zend_smarty_conf.php');
$feedback = $db->fetchRow($db->select()->from(array("rfis"=>"request_for_interview_feedbacks"), 
								array("rfis.id AS id", "rfis.feedback AS feedback", "rfis.date_created AS date_created"))
								->joinInner(array("tbr"=>"tb_request_for_interview"), "tbr.id = rfis.request_for_interview_id", array())
								->joinInner(array("p"=>"personal"), "p.userid = tbr.applicant_id", array(new Zend_Db_Expr("CONCAT(p.fname, ' ', p.lname) AS staff")))
								->joinInner(array("l"=>"leads"), "l.id = tbr.leads_id", array(new Zend_Db_Expr("CONCAT(l.fname, ' ',l.lname) AS client")))
								->joinInner(array("a"=>"admin"), "a.admin_id = rfis.admin_id", array("admin_fname", "admin_lname"))
								->where("rfis.id = ?", $_REQUEST["id"]));
								
$smarty = new Smarty;
$feedback["feedback"] = nl2br($feedback["feedback"]);
$feedback["date_created"] = date("Y-m-d", strtotime($feedback["date_created"]));
$smarty->assign("feedback",$feedback);
$smarty->display("interview_feedback.tpl");
