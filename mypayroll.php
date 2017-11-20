<?php
include('conf/zend_smarty_conf.php');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['client_id']=="")
{
	header("location:index.php");
}
$client_id = $_SESSION['client_id'];
//$sql = "SELECT * FROM leads WHERE id = ". $client_id;
//$lead= $db->fetchRow($sql);


//id, leads_id, description, payment_details, drafted_by, drafted_by_type, updated_by, updated_by_type, status, start_date, end_date, invoice_date, draft_date, post_date, last_update_date, sub_total, gst, total_amount, invoice_month, invoice_year, paid_date, invoice_number, currency, fix_currency_rate, current_rate, invoice_payment_due_date, card_type, card_transaction_date
$sql = "SELECT * FROM client_invoice WHERE status != 'draft' AND status != 'deleted' AND leads_id = $client_id;";
//echo $sql;
$invoices = $db->fetchAll($sql);
$details=array();
foreach($invoices as $invoice){
	
	if($invoice['currency'] == 'POUND') {
	    $invoice['currency'] = 'GBP';
	}
	$sql = $db->select()
	    ->from('currency_lookup', 'sign')
		->where('code =?', $invoice['currency']);
	$sign = $db->fetchOne($sql);	
	
    $data= array(
	    'id' => $invoice['id'],
		'invoice_number' => $invoice['invoice_number'],
		'invoice_payment_due_date' => $invoice['invoice_payment_due_date'],
		'description' => $invoice['description'],
		'currency' => $invoice['currency'],
		'total_amount' => $invoice['total_amount'],
		'draft_date' => $invoice['draft_date'],
		'post_date' => $invoice['post_date'],
		'invoice_payment_due_date' => $invoice['invoice_payment_due_date'],
		'paid_date' => $invoice['paid_date'],
		'sign' => $sign
	);
	
	if($invoice['status'] == 'paid'){
	    //$data['invoice_date'] = $invoice['paid_date'];
		$data['status'] = 'paid';
	}
	
	if($invoice['status'] == 'posted'){
	    //$data['invoice_date'] = $invoice['post_date'];
        if($invoice['invoice_payment_due_date'] <= $AusDate){
		    $data['status'] = 'overdue';
		}else{
		    $data['status'] = 'posted';
		}
	}
	
	array_push($details, $data);
}

//echo "<pre>";
//print_r($details);
//echo "</pre>";
//exit;


//PREPAID ORDERS
$CLIENT_ID = ((int)$_SESSION['client_id']);  //must be an integer
$client = new couchClient($couch_dsn, 'client_docs');

$client->endkey(Array($CLIENT_ID, "_"));
$client->startkey(Array($CLIENT_ID,"Z"));
$client->descending(True);

$response = $client->getView('orders', 'all_orders_except_cancelled');
//echo "<pre>";
//print_r($response->rows);
//echo "</pre>";
//echo "<hr>";
$prepaid_orders = array();
foreach($response->rows as $r){

    $sql = $db->select()
	    ->from('currency_lookup', 'sign')
		->where('code =?', $r->value->currency);
	$sign = $db->fetchOne($sql);
	
	$datearray = array('year' => $r->value->order_date[0],
                   'month' => $r->value->order_date[1],
                   'day' => $r->value->order_date[2],
                   'hour' => $r->value->order_date[3],
                   'minute' => $r->value->order_date[4],
                   'second' => $r->value->order_date[5]);
	$date = new Zend_Date($datearray);
	
	$data = array(
	    'order_id' => $r->key[1],
		'status' => $r->value->status,
		'description' => str_replace('/hr', '/hr<br>',$r->value->description),
		'date' => $date,
		'currency' => $r->value->currency,
		'total_amount' => $r->value->total_amount,
		'sign' => $sign
	);
	array_push($prepaid_orders, $data);
}
if(TEST){
	$site = "http://devs.remotestaff.com.au";
}else{
	$site = "https://remotestaff.com.au";
}
if (isset($_REQUEST["page_type"])){
	$smarty->assign("page_type", $_REQUEST["page_type"]);
}else{
	$smarty->assign("page_type", "");
}

$smarty->assign('site', $site);
$smarty->assign('prepaid_orders',$prepaid_orders);
$smarty->assign('invoices', $details);
$smarty->display('mypayroll.tpl');
exit;
?>