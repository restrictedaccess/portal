<?php
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php') ;
if (isset($_REQUEST["id"])&&$_REQUEST["id"]){
	$remote_order_item = $db->fetchRow($db->select()->from(array("rroi"=>"remote_ready_order_items"), array("userid"))->where("rroi.id = ?", $_REQUEST["id"]));
	if ($remote_order_item){
		$db->update("remote_ready_order_items", array("availability_status"=>$_REQUEST["availability_status"]), $db->quoteInto("userid = ?", $remote_order_item["userid"]));
		if ($_REQUEST["availability_status"]=="Available to Interview"){
			$db->delete("inactive_staff", "userid = ".$remote_order_item["userid"]." AND type='NOT READY'");
		}else if ($_REQUEST["availability_status"]=="No Longer Available"){
			$inactive_staff = $db->fetchRow($db->select()->from("inactive_staff")->where("userid = ?", $remote_order_item["userid"])->where("type = ?", "NOT READY"));
			if (!$inactive_staff){
				$db->insert("inactive_staff", array("userid"=>$remote_order_item["userid"], "type"=>"NOT READY", "admin_id"=>$_SESSION["admin_id"]));				
			}

		}
	}
	echo json_encode(array("success"=>true));
}else{
	echo json_encode(array("success"=>false));
}
