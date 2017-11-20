<?php
include('../conf/zend_smarty_conf.php');
include 'comments_function.php';
include '../time.php';
$smarty = new Smarty();


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] !=NULL){
	$reply_by_id = $_SESSION['agent_no'];
	$reply_by_type = 'agent';
}else if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$reply_by_id = $_SESSION['admin_id'];
	$reply_by_type = 'admin';
}else if($_SESSION['client_id'] != "" || $_SESSION['client_id']!=NULL){
	$reply_by_id = $_SESSION['client_id'];
	$reply_by_type = 'leads';
}else{
	die("Session Expired. Please re-login");
}

$id = $_REQUEST['id'];
$message = $_REQUEST['message'];

if($id == ""){
	echo "Reply Id is missing.";
	exit;
}


$data = array('reply' => $message);
$where = "id = ".$id;	
$db->update('system_comments_reply', $data , $where);

echo "Reply has been updated";

?>