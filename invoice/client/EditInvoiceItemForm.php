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
$item_id = $_REQUEST['item_id'];

if($id ==""){
    die("Client Invoice id is missing.");
}
if($item_id ==""){
    die("Client Invoice Details ID is missing");
}

$sql = $db->select()
    ->from('client_invoice_details')
	->where('id =?', $item_id);
$invoice_item = $db->fetchRow($sql);	

$smarty->assign('id',$id);
$smarty->assign('invoice_item',$invoice_item);
$smarty->assign('method', 'edit');

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty->display('AddInvoiceItemForm.tpl');
?>