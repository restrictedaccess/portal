<?php
include('../../conf/zend_smarty_conf.php');
$smarty = new Smarty();

if($_SESSION['admin_id']==""){
	die("Invalid Id for Admin");
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$status = 'paid';

$id=$_REQUEST['id'];
$paid_date = $_REQUEST['paid_date'];
if($id ==""){
    die("Client Invoice id is missing.");
}

$sql = $db->select()
    ->from('client_invoice')
	->where('id =?', $id);
$invoice = $db->fetchRow($sql);


$data = array('status' => $status, 'paid_date' => $paid_date." 00:00:00" );
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
	'changes' => 'UPDATED INVOICE :'.$history_changes, 
	'changed_by_id' => $_SESSION['admin_id'], 
	'date_changed' => $ATZ 
);
$db->insert('client_invoice_history', $data);
echo $id;exit;
?>