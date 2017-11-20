<?php
//exit;
include '../conf/zend_smarty_conf.php';
require_once('../lib/php-amqplib/amqp.inc');

$smarty = new Smarty();
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['admin_id']=="")
{
	die("Admin id is missing");
}

$leads_id = $_GET['leads_id'];

$sql="SELECT * FROM subcontractors_invoice_setup s WHERE (status = 'awaiting payment' OR status = 'invoiced') AND leads_id = $leads_id;";
$results = $db->fetchAll($sql);

foreach($results as $r){
    $subcontractors_invoice_setup_id = sprintf('resend %s', $r['id']);
	//echo $subcontractors_invoice_setup_id;
	include '../conf/invoice_rabbitmq_conf.php';
}
exit;
?>