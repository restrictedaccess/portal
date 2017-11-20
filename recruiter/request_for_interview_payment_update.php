<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';
include '../time.php';

$status = @$_REQUEST["status"];
$id = @$_REQUEST["id"];

//START: validate session
$admin_id = $_SESSION['admin_id'];
$agent_no = $_SESSION['agent_no'];
if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL"){ 
	echo "This page is for HR usage only.";
	exit;
}
//ENDED: validate session

//START: recruitment status update
if(isset($status))
{
	$date_updated = date("Y-m-d h:i:s");	
	mysql_query("UPDATE tb_request_for_interview SET payment_status='$status', date_updated='$date_updated' WHERE id='$id'");
	if ($status=="PENDING"){
		echo "Not Paid Payment Pending";
	}else{
		echo "Paid";		
	}
	

}
//ENDED: recruitment status update
?>