<?php
include('../../conf/zend_smarty_conf.php');
$smarty = new Smarty();

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']==""){
	die("Invalid Id for Admin");
}



$id=$_REQUEST['id'];
if($id ==""){
    die("Client Invoice id is missing.");
}

$sql = $db->select()
    ->from('client_invoice')
	->where('id =?', $id);
$invoice = $db->fetchRow($sql);

//update invoice item
$data = array(
	'invoice_payment_due_date' => $_REQUEST['due_date']
);
$db->update('client_invoice', $data, 'id='.$id);

$difference = array_diff_assoc($data,$invoice);
if($difference > 0){
    foreach(array_keys($difference) as $array_key){
	    $history_changes .= sprintf("%s from %s to %s,", $array_key, $invoice[$array_key] , $difference[$array_key]);
	}
}
//add history
$history_changes=substr($history_changes,0,(strlen($history_changes)-1));
$data = array(
    'client_invoice_id' => $id, 
	'changes' => 'UPDATED ITEM :'.$history_changes, 
	'changed_by_id' => $_SESSION['admin_id'], 
	'date_changed' => $ATZ 
);
$db->insert('client_invoice_history', $data);

$sql = $db->select()
    ->from('client_invoice', 'invoice_payment_due_date')
	->where('id =?', $id);
$invoice_payment_due_date = $db->fetchOne($sql);


$smarty->assign('invoice_payment_due_date', $invoice_payment_due_date);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty->display('UpdateDueDate.tpl');
?>