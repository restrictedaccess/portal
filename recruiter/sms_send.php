<?php
include('../conf/zend_smarty_conf.php');
if (!isset($_SESSION["admin_id"])){
	echo json_encode(array("success"=>false, "error"=>"Authentication failed"));
	die;
}
if (!empty($_POST)){
	$data = $_POST;
	if (trim($data["mobile_number"])!=""){
		$mobile_number = $data["mobile_number"];
		if ($mobile_number{0}=="9"){
			$data["mobile_number"] = "0".$mobile_number;
		}
		
		if (strlen($data["mobile_number"])!=11){
			echo json_encode(array("success"=>false, "error"=>"Mobile Number is in Invalid Format."));
			die;			
		}
		
		if (($data["mobile_number"]{0}!="0")){
			echo json_encode(array("success"=>false, "error"=>"Mobile Number is in Invalid Format"));
			die;
		}
		if (($data["mobile_number"]{1}!="9")){
			echo json_encode(array("success"=>false, "error"=>"Mobile Number is in Invalid Format"));
			die;
		}
		
		
	}else{
		echo json_encode(array("success"=>false, "error"=>"Mobile Number is missing"));
		die;
	}
	
	if (trim($data["message"])==""){
		echo json_encode(array("success"=>false, "error"=>"Message is empty"));
		die;
	}
	
	//try to save a copy on prod database
	$data["gsm_stk"] = "gsm01";
	$data["date_created"] = date("Y-m-d H:i:s");
	$data["sent"]  = 1;
	$data["admin_id"] = $_SESSION["admin_id"];
	$db->insert("staff_admin_sms_out_messages", $data);
	$id = $db->lastInsertId("staff_admin_sms_out_messages");
	
	
	//get sender type
	$admin = $db->fetchRow($db->select()->from("admin", array("status", "csro"))->where("admin_id = ?", $_SESSION["admin_id"])->where("status <> 'REMOVED'"));
	$status = $admin["status"];
	
	$sender_type = "";
	if ($status=="COMPLIANCE"){
		$sender_type = "compliance";
	}else if ($status=="HR"){
		$sender_type = "recruitment";
	}else if ($status=="FULL-CONTROL"){
		$sender_type = "fullcontrol";
	}
	
	if ($admin["csro"]=="Y"){
		$sender_type = "csro";
	}
	
	$date_sent = date("Y-m-d H:i:s");
	$sentMessage = array("mode"=>"send", "date_sent"=>$date_sent, "sent_by"=>$_SESSION["admin_id"], "mobile_number"=>$data["mobile_number"], "message"=>$data["message"]);
	$db->insert("sms_messages", $sentMessage);
	
	//try to publish
	
	$host = "127.0.0.1";
	$queue = "sms";
	$exchange = 'portal';	
	
	$conn = new AMQPConnection($host,5672,"sms","sms","portal" );
	$ch = $conn->channel();

	$ch->queue_declare($queue, true, true, true, true);
	$ch->exchange_declare($exchange, 'direct', false, true, false);
	$ch->queue_bind($queue, $exchange);
	
	//additional fields to be queried
	$skype = $db->fetchRow($db->select()->from(array("a"=>"admin"), array("a.skype_id AS skype_id"))->where("a.admin_id = ?", $_SESSION["admin_id"]));
	$publishData = array("cp_num"=>$data["mobile_number"], "message"=>$data["message"], "sms_id"=>$id, "mode"=>"sms", "sender_type"=>$sender_type, "date_sent"=>$date_sent);
	if ($skype){
		$publishData["skype_id"] = $skype["skype_id"];
	}
	$msg_body =json_encode($publishData);
	
	$msg = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery-mode' => 2));
	$ch->basic_publish($msg, $exchange);
	$ch->close();
	$conn->close();	
	echo json_encode(array("success"=>true));
}


