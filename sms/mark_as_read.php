<?php
include '../conf/zend_smarty_conf.php';
if (isset($_GET["sms_id"])){
	$db->update("sms_messages", array("read"=>1), $db->quoteInto("id = ?", $_GET["sms_id"]));
}
