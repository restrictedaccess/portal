<?php
//schedule_prepaid_contract(1);
function schedule_prepaid_contract($subcontractors_temp_id){
	//require_once('../lib/php-amqplib/amqp.inc');
	require('mq_config.php');
	global $db;
	global $transport;
	
	if($subcontractors_temp_id == ""){
		die('subcontractors_temp.id is missing');
	}
	
	//echo $argv[1];
	//exit;
	$exchange = '/';
	$queue = 'schedule_prepaid_contract';
	
	
	
	$conn = new AMQPConnection(HOST, PORT, USER, PASS, VHOST);
	$ch = $conn->channel();
	$ch->queue_declare($queue, false, true, false, false);
	$ch->exchange_declare($exchange, 'direct', false, true, false);
	$ch->queue_bind($queue, $exchange);
	
	$msg_body = $subcontractors_temp_id;
	
	$msg = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery-mode' => 2));
	$ch->basic_publish($msg, $exchange);
	$ch->close();
	$conn->close();
	
	if(!TEST){
	    $output = $_SESSION['admin_id']." scheduled prepaid contract ";
	}else{
	    $output = "TEST ".$_SESSION['admin_id']." scheduled prepaid contract ";
	}
	$mail = new Zend_Mail();
	$mail->setBodyText($output)
		->setFrom('noreply@remotestaff.com.au', 'No Reply')
		->addTo('devs@remotestaff.com.au', 'Devs')
		->setSubject($output);
	$mail->send($transport);
}


function set_client_days_before_suspension($leads_id){
	require('mq_config.php');
	global $db;
	global $transport;
	
	if($leads_id == ""){
		die('leads id is missing');
	}
	
	//echo $argv[1];
	//exit;
	$exchange = 'set_client_days_b4_suspension';
	$queue = 'set_client_days_b4_suspension';
	
	
	
	$conn = new AMQPConnection(HOST, PORT, 'set_client_days_b4_suspension', 'set_client_days_b4_suspension', 'set_client_days_b4_suspension');
	$ch = $conn->channel();
	$ch->queue_declare($queue, false, true, false, false);
	$ch->exchange_declare($exchange, 'direct', false, true, false);
	$ch->queue_bind($queue, $exchange);
	
    	
	$msg_body = json_encode(array("leads_id"=>$leads_id));
	
	$msg = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery-mode' => 2));
	$ch->basic_publish($msg, $exchange);
	$ch->close();
	$conn->close();
	
	$output = sprintf("%s set client days before suspension", $leads_id);
	if(TEST){
	    $output = sprintf('TEST %s', $output);
	}
	$mail = new Zend_Mail();
	$mail->setBodyText($output)
		->setFrom('noreply@remotestaff.com.au', 'No Reply')
		->addTo('devs@remotestaff.com.au', 'Devs')
		->setSubject($output);
	$mail->send($transport);
}
?>