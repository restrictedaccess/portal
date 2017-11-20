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


$status = 'Inactive';
$data = array('status' => $status , 'inactive_since' => $ATZ);

//add leads history
addLeadsInfoHistoryChanges($data , $id , $agent_no , 'bp');

$where = "id = ".$id;	
$db->update('leads' ,  $data , $where);
header("location:inactiveList.php");
?>
