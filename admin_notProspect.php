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


$status = 'Inactive';
$data = array('status' => $status , 'inactive_since' => $ATZ);

//add leads history
addLeadsInfoHistoryChanges($data , $id , $admin_id , 'admin');

$where = "id = ".$id;	
$db->update('leads' ,  $data , $where);
header("location:admininactiveList.php");
?>
