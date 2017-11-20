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
$method = $_REQUEST['method'];
if($id ==""){
    die("Client Invoice id is missing.");
}

if($method ==""){
    die("GST Method is missing");
}

$sql = $db->select()
    ->from('client_invoice')
	->where('id =?', $id);
$invoice = $db->fetchRow($sql);
//CURRENCY
if($invoice['currency'] == 'POUND') $invoice['currency'] = 'GBP' ;
$sql = $db->select()
    ->from('currency_lookup')
	->where('code =?' , $invoice['currency']);
$currency = $db->fetchRow($sql);
	



//update the client invoice
$sql="SELECT SUM(amount)AS sub_total FROM client_invoice_details WHERE  client_invoice_id = $id;";
$sub_total = $db->fetchOne($sql);
$tax = 0;

if($method == 'add'){
    $tax = $sub_total * .10;
}
$total_amount = $sub_total + $tax;

$data = array(
    'sub_total' => $sub_total,
	'gst' => $tax,
	'total_amount' => $total_amount,
	'last_update_date' => $ATZ
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
	'changes' => 'UPDATED INVOICE GST :'.$history_changes, 
	'changed_by_id' => $_SESSION['admin_id'], 
	'date_changed' => $ATZ 
);
$db->insert('client_invoice_history', $data);

//print_r($data);
echo $id;exit;
?>