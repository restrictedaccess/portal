<?php
include('../../conf/zend_smarty_conf.php');
$smarty = new Smarty();

if($_SESSION['admin_id']==""){
	die("Invalid Id for Admin");
}
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$leads_id=$_REQUEST['leads_id'];
$description=$_REQUEST['description'];
$currency=$_REQUEST['currency'];
$invoice_month =$_REQUEST['invoice_month'];
$invoice_year=$_REQUEST['invoice_year'];


$date = $invoice_year."-".$invoice_month."-".date("d");
$det = new DateTime($date);
$invoice_date = $det->format("Y-m-d");
$det->modify("+5 day");
$invoice_payment_due_date = $det->format("Y-m-d");


// Create invoice number
$sql = "SELECT MAX(invoice_number)AS invoice_number FROM client_invoice;";
//echo $sql;exit;
$invoice_number = $db->fetchOne($sql);
if($invoice_number == ""){
	$invoice_number = 1000;
}else{
	$invoice_number = $invoice_number + 1;
}	


//id, leads_id, description, payment_details, drafted_by, drafted_by_type, updated_by, updated_by_type, status, start_date, end_date, invoice_date, draft_date, post_date, last_update_date, sub_total, gst, total_amount, invoice_month, invoice_year, paid_date, invoice_number, currency, fix_currency_rate, current_rate, invoice_payment_due_date, card_type, card_transaction_date

$data = array(
    'leads_id' => $leads_id,
	'description' => $description,
	'drafted_by' => $_SESSION['admin_id'] ,
	'drafted_by_type' => 'admin',
	'status' => 'draft' ,
	'invoice_date' => $invoice_date,
	'draft_date' => $AusDate,
	'invoice_month' => $invoice_month,
	'invoice_year' => $invoice_year,
	'currency' => $currency,
	'invoice_number' => $invoice_number,
	'invoice_payment_due_date' => $invoice_payment_due_date 
);
$db->insert('client_invoice', $data);
$id = $db->lastInsertId();
//print_r($data);exit;	


//add history
foreach(array_keys($data) as $array_key){
	$history_changes .= sprintf("%s => %s,", $array_key, $data[$array_key]);
}
$history_changes=substr($history_changes,0,(strlen($history_changes)-1));
$data = array(
    'client_invoice_id' => $id, 
	'changes' => 'ADDED BLANK INVOICE :'.$history_changes, 
	'changed_by_id' => $_SESSION['admin_id'], 
	'date_changed' => $ATZ 
);
$db->insert('client_invoice_history', $data);

echo $id;exit;		
?>