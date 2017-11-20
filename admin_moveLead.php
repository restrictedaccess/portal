<?php
include './conf/zend_smarty_conf_root.php';
include './lib/addLeadsInfoHistoryChanges.php';
include 'time.php';

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}
$admin_id = $_SESSION['admin_id'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$id=$_REQUEST['id'];
$status = $_REQUEST['status'];

if ($status == "Follow-Up"){
	$page = "followup";
}

if ($status == "Keep In-Touch"){
	$page = "keeptouch";
}

if ($status == "pending"){
	$page = "pending";
}

if ($status == "New Leads"){
	$page = "newleads";
}

if ($status == "Inactive"){
	$page = "newleads";
}



$data = array('status' => $status);

addLeadsInfoHistoryChanges($data , $id , $admin_id , 'admin');

$where = "id = ".$id;	
$db->update('leads' ,  $data , $where);
header("location:admin_apply_action.php?id=$id&page=$page");
?>
