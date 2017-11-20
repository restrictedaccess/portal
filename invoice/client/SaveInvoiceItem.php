<?php
include('../../conf/zend_smarty_conf.php');
$smarty = new Smarty();

if($_SESSION['admin_id']==""){
	die("Invalid Id for Admin");
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$start_date=$_REQUEST['start_date'];
$end_date=$_REQUEST['end_date'];
$description=$_REQUEST['description'];
$amount=$_REQUEST['amount'];

$id=$_REQUEST['id'];
if($id ==""){
    die("Client Invoice id is missing.");
}

$sql = $db->select()
    ->from('client_invoice')
	->where('id =?', $id);
$invoice = $db->fetchRow($sql);

//leads apply_gst set up
$sql = $db->select()
    ->from('leads', 'apply_gst')
	->where('id=?', $invoice['leads_id']);
$apply_gst = $db->fetchOne($sql);	


//CURRENCY
if($invoice['currency'] == 'POUND') $invoice['currency'] = 'GBP' ;
$sql = $db->select()
    ->from('currency_lookup')
	->where('code =?' , $invoice['currency']);
$currency = $db->fetchRow($sql);

	
$sql = "SELECT MAX(counter)AS counter FROM client_invoice_details WHERE client_invoice_id = $id ;";
$counter = $db->fetchOne($sql);
$counter++;

//insert new invoice item
$data = array(
    'client_invoice_id' => $id, 
	'start_date' => $start_date, 
	'end_date' => $end_date, 
	'decription' => $description,
	'amount' => $amount,
	'counter' => $counter ,
	'sub_counter' => $counter
);
$db->insert('client_invoice_details', $data);

//add history
foreach(array_keys($data) as $array_key){
	$history_changes .= sprintf("%s => %s,", $array_key, $data[$array_key]);
}
$history_changes=substr($history_changes,0,(strlen($history_changes)-1));
$data = array(
    'client_invoice_id' => $id, 
	'changes' => 'ADDED NEW ITEM :'.$history_changes, 
	'changed_by_id' => $_SESSION['admin_id'], 
	'date_changed' => $ATZ 
);
$db->insert('client_invoice_history', $data);


//update the client invoice
$sql="SELECT SUM(amount)AS sub_total FROM client_invoice_details WHERE  client_invoice_id = $id;";
$sub_total = $db->fetchOne($sql);
$tax = 0;

if($currency['code'] == 'AUD'){
    if($apply_gst == 'yes'){
        $tax = $sub_total * .10;
	}else{
	    $tax = 0;
	}	
}
$total_amount = $sub_total + $tax;

$data = array(
    'sub_total' => $sub_total,
	'gst' => $tax,
	'total_amount' => $total_amount,
	'last_update_date' => $ATZ
);
$db->update('client_invoice', $data, 'id='.$id);
//print_r($data);
echo $id;exit;
?>