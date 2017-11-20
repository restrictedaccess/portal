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


$id = $_REQUEST['id'];
$message = $_REQUEST['message'];

if($id == "" or $id == NULL){
	echo "ID is Missing";
	exit;
}
//id, leads_invoice_id, comment_by_id, comment_by_type, comment_date, message
$data = array(
		'staff_resume_email_sent_id' => $id, 
		'comment_by_id' => $comment_by_id, 
		'comment_by_type' => $comment_by_type, 
		'comment_date' => $ATZ, 
		'message' => $message
		);
$db->insert('staff_resume_email_sent_comments' , $data);

echo "Successfully Added";		
?>

