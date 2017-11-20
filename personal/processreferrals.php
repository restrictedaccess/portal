<?php
include('../conf/zend_smarty_conf.php') ;
if (isset($_POST["id"])&&(isset($_POST["action"]))){
	$action = $_POST["action"];
	$id = $_POST["id"];
	if ($action=="delete"){
		$db->update("referrals", array("status"=>"DELETED"), $db->quoteInto("id = ?", $id));
	}
}