<?php
include './conf/zend_smarty_conf_root.php';
include './lib/addLeadsInfoHistoryChanges.php';


if($_SESSION['agent_no']=="")
{
	header("location:./index.php");
}
$agent_no = $_SESSION['agent_no'];
$id=$_REQUEST['id'];

$status = 'REMOVED';
$data = array('status' => $status);
//add history
addLeadsInfoHistoryChanges($data , $id , $agent_no , 'bp');

$where = "id = ".$id;	
$db->update('leads' ,  $data , $where);
header("location:newleads.php");

?>
