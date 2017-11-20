<?php
ini_set("max_execution_time", 300);
require_once('../conf/zend_smarty_conf.php');
$voices = $db->fetchAll($db->select()->from("personal", array("userid"))->where("personal.voice_path IS NOT NULL"));
if (!empty($voices)){
	$i = 0;
	
	foreach($voices as $voice){
		$userid = $voice["userid"];
		if (TEST){
			file_put_contents(dirname(__FILE__) . "/../uploads/voice/" . $userid . ".mp3", fopen("https://remotestaff.com.au/portal/uploads/voice/".$voice["userid"].".mp3", 'r'));
		}
		
		if (!file_exists(dirname(__FILE__)."/../uploads/voice/".$voice["userid"].".ogg")){
			$exchange = '/';
			$queue = 'mp3_conversion';
			$consumer_tag = 'consumer';
			
			$conn = new AMQPConnection(MP3_AMQP_HOST, MP3_AMQP_PORT,MP3_AMQP_USERNAME, MP3_AMQP_PASSWORD, MP3_AMQP_VHOST);
			$ch = $conn->channel();
			$ch->queue_declare($queue, false, true, false, false);
			$ch->exchange_declare($exchange, 'direct', false, true, false);
			$ch->queue_bind($queue, $exchange);
			
			$msg_body =json_encode(array("published_by"=>"/portal/cronjobs/ogg_sync.php", "userid"=>$voice["userid"], "scale"=>1));
			
			$msg = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery-mode' => 2));
			$ch->basic_publish($msg, $exchange);
			$ch->close();
			$conn->close();	
		}
	}
}
