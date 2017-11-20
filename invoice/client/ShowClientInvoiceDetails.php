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
    ->from(array('c' => 'client_invoice'))
	->join(array('l' => 'leads'), 'l.id = c.leads_id', Array('fname', 'lname', 'email', 'l.company_name', 'l.company_address'))
	->where('c.id =?', $id);
//echo $sql;	
$invoice = $db->fetchRow($sql);	
//print_r($invoice);

//CURRENCY
if($invoice['currency'] == 'POUND') $invoice['currency'] = 'GBP' ;
$sql = $db->select()
    ->from('currency_lookup')
	->where('code =?' , $invoice['currency']);
$currency = $db->fetchRow($sql);	


if($invoice['currency'] == 'AUD'){
    if($invoice['gst'] == 0 or  $invoice['gst'] == 0.00 or $invoice['gst'] == ""){
		$gst_str_btn = "Add GST";
		$gst_method = 'add';
	}else{
	    $gst_str_btn = "Remove GST";
		$gst_method = 'remove';
	}
}


//Invoice Items
//id, client_invoice_id, start_date, end_date, decription, total_days_work, rate, company_rate, qty, unit_price, amount, counter, sub_counter, subcon_id
$sql = $db->select()
    ->from('client_invoice_details')
	->where('client_invoice_id =?', $id);
$invoice_items = $db->fetchAll($sql);	


$smarty->assign('gst_str_btn',$gst_str_btn);
$smarty->assign('gst_method',$gst_method);

$smarty->assign('invoice',$invoice);
$smarty->assign('currency',$currency);
$smarty->assign('invoice_items',$invoice_items);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty->display('ShowClientInvoiceDetails.tpl');
?>