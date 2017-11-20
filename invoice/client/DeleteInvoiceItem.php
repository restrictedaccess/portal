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
	

$sql = $db->select()
    ->from('timesheet_client_invoice_tracking')
	->where('client_invoice_details_id =?', $item_id);
$trackings = $db->fetchRow($sql);
$tracking_id = $trackings['id'];
if($tracking_id){
    foreach(array_keys($trackings) as $array_key){
        $tracking_changes .= sprintf("%s => %s,", $array_key, $trackings[$array_key]);
    }	
	//echo $tracking_changes;exit;
    $db->delete('timesheet_client_invoice_tracking', 'client_invoice_details_id='.$item_id);
	
	//add history
    $tracking_changes=substr($tracking_changes,0,(strlen($tracking_changes)-1));
    $data = array(
       'client_invoice_id' => $id, 
       'changes' => 'DELETED INVOICE ITEM TRACKING :'.$tracking_changes, 
       'changed_by_id' => $_SESSION['admin_id'], 
       'date_changed' => $ATZ 
    );
    $db->insert('client_invoice_history', $data);
}

$db->delete('client_invoice_details', 'id='.$item_id);

//add history
foreach(array_keys($invoice_item) as $array_key){
	$history_changes .= sprintf("%s => %s,", $array_key, $invoice_item[$array_key]);
}

$history_changes=substr($history_changes,0,(strlen($history_changes)-1));
$data = array(
    'client_invoice_id' => $id, 
	'changes' => 'DELETED ITEM :'.$history_changes, 
	'changed_by_id' => $_SESSION['admin_id'], 
	'date_changed' => $ATZ 
);
$db->insert('client_invoice_history', $data);


//update the client invoice
$sql="SELECT SUM(amount)AS sub_total FROM client_invoice_details WHERE  client_invoice_id = $id;";
//echo $sql;exit;
$sub_total = $db->fetchOne($sql);
$tax = 0;
if(!$sub_total) $sub_total=0;

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