<?php
include('../conf/zend_smarty_conf.php') ;
$feedback = $db->fetchOne($db->select()->from("tb_shortlist_history", array("feedback"))->where("id = ?", $_REQUEST["id"]));
$smarty = new Smarty();
$smarty->assign("feedback", $feedback);
$smarty->display("shortlist_feedback.tpl");
