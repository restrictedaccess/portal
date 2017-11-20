<?php
ini_set("max_execution_time", 300);
include('../conf/zend_smarty_conf.php');
$exchange = '/';
$queue = 'receive_recruitment_query';
$consumer_tag = 'consumer';
if (TEST){
	$conn = new AMQPConnection(MQ_HOST, MQ_PORT,MQ_USER,MQ_PASS, MQ_VHOST);
}else{
	$conn = new AMQPConnection(MQ_RECRUITMENT_QUERY_HOST, MQ_RECRUITMENT_QUERY_PORT,MQ_RECRUITMENT_QUERY_USER,MQ_RECRUITMENT_QUERY_PASS, MQ_RECRUITMENT_QUERY_VHOST);	
}
$ch = $conn->channel();
$ch->queue_declare($queue, false, true, false, false);
$ch->exchange_declare($exchange, 'direct', false, true, false);
$ch->queue_bind($queue, $exchange);

$msg_body =json_encode(array("script"=>"/portal/cronjobs/checking_missing_job_order.php","action"=>"check_sync_job_order"));
$msg = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery-mode' => 2));
$ch->basic_publish($msg, $exchange);
$ch->close();
$conn->close();		