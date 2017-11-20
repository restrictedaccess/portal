<?php
include '../conf/zend_smarty_conf.php';
include ('./AdminBPActionHistoryToLeads.php');
include '../time.php';
$smarty = new Smarty();


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] !=NULL){
	$comment_by_id = $_SESSION['agent_no'];
	$comment_by_type = 'agent';
}else if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$comment_by_id = $_SESSION['admin_id'];
	$comment_by_type = 'admin';
}else if($_SESSION['client_id'] != "" || $_SESSION['client_id']!=NULL){
	$comment_by_id = $_SESSION['client_id'];
	$comment_by_type = 'leads';
}else{
	die("Session Expired. Please re-login");
}


$invoice_id = $_REQUEST['invoice_id'];
$message = $_REQUEST['message'];

if($invoice_id == "" or $invoice_id == NULL){
	echo "Invoice ID is Missing";
	exit;
}
//id, leads_invoice_id, comment_by_id, comment_by_type, comment_date, message
$data = array(
		'leads_invoice_id' => $invoice_id, 
		'comment_by_id' => $comment_by_id, 
		'comment_by_type' => $comment_by_type, 
		'comment_date' => $ATZ, 
		'message' => $message
		);
$db->insert('leads_invoice_comments' , $data);

echo "Successfully Added";		
?>

