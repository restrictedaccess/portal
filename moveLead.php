<?php
include './conf/zend_smarty_conf_root.php';
include './lib/addLeadsInfoHistoryChanges.php';
include 'time.php';



if($_SESSION['agent_no']=="")
{
	header("location:./index.php");
}
$agent_no = $_SESSION['agent_no'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$id=$_REQUEST['id'];
$status = $_REQUEST['status'];

if($status == "Follow-Up"){
	$tab = "follow_up";
}
if($status == "Keep In-Touch"){
	$tab = "keep_in_touch";
}

if($status == "pending"){
	$tab = "pending";
}



$data = array('status' => $status , 'contacted_since' => $ATZ);
//add history
addLeadsInfoHistoryChanges($data , $id , $agent_no , 'bp');
$where = "id = ".$id;	
$db->update('leads' ,  $data , $where);

if($status == "New Leads"){
	header("location:apply_action.php?id=$id");
}
else{ 
	header("location:apply_action2.php?id=$id&tab=$tab");
}
?>
