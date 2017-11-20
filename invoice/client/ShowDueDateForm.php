<?php
include('../../conf/zend_smarty_conf.php');
$smarty = new Smarty();

if($_SESSION['admin_id']==""){
	die("Invalid Id for Admin");
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$id=$_REQUEST['id'];

if($id ==""){
    die("Client Invoice id is missing.");
}


$sql = $db->select()
    ->from('client_invoice', 'invoice_payment_due_date')
	->where('id =?', $id);
$invoice_payment_due_date = $db->fetchOne($sql);

$smarty->assign('id',$id);
$smarty->assign('invoice_payment_due_date', $invoice_payment_due_date);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty->display('ShowDueDateForm.tpl');
?>