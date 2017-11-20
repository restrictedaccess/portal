<?php
function subconlist_reporting_adj_hours($doc_id){
	require('../conf/zend_smarty_conf.php');

	$exchange = 'subconlist_reporting';
	$queue = 'subconlist_reporting';
		
	$conn = new AMQPConnection(MQ_HOST, MQ_PORT, MQ_USER, MQ_PASS, MQ_VHOST);
	$ch = $conn->channel();
	$ch->queue_declare($queue, false, true, false, false);
	$ch->exchange_declare($exchange, 'direct', false, true, false);
	$ch->queue_bind($queue, $exchange);
	
	$msg_body = $doc_id;
	
	$msg = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery-mode' => 2));
	$ch->basic_publish($msg, $exchange);
	$ch->close();
	$conn->close();
}
?>