<?php
include '../conf/zend_smarty_conf.php';
include './admin_subcon_function.php';

$smarty = new Smarty();
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['admin_id']=="")
{
	die("Admin id is missing");
}

$id = $_REQUEST['id'];
$reason = trim($_REQUEST['reason']);

$data = array('reason' => $reason);
$history_changes = compareData($data , "subcontractors" , $id);

$where = "id = ".$id;	
$db->update('subcontractors', $data , $where);

//HISTORY
//INSERT NEW RECORD TO THE subcontractors_history
$changes = "Updated Reason.<br>";
$changes .= "<b>Changes made : </b>.".$history_changes;
$data = array (
		'subcontractors_id' => $id, 
		'date_change' => $ATZ, 
		'changes' => $changes, 
		'change_by_id' => $_SESSION['admin_id'] ,
		'changes_status' => 'updated'
		);
$db->insert('subcontractors_history', $data);
echo "ok";
?>