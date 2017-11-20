<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']!="" or $_SESSION['admin_id']!=NULL){
	//die('Invalid ID for Admin');
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = "admin";
}

if($_SESSION['agent_no'] != "" || $_SESSION['agent_no']!=NULL){
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = "bp";
}


$gs_job_role_selection_id = $_REQUEST['gs_job_role_selection_id'];
$invoice_id = $_REQUEST['invoice_id'];
$message = $_REQUEST['message'];

$data = array(
		'invoice_id' => $invoice_id, 
		'gs_job_role_selection_id' => $gs_job_role_selection_id , 
		'created_by_id' => $created_by_id,
		'created_by_type' => $created_by_type, 
		'notes' => $message, 
		'date_created' => $ATZ
		);
$db->insert('gs_admin_notes' , $data);		


?>
