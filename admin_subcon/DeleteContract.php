<?php
include '../conf/zend_smarty_conf.php';
include './admin_subcon_function.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['admin_id']=="")
{
	die("Admin id is missing");
}

$data = array('status' => 'deleted');
$history_changes = compareData($data , "subcontractors" , $_REQUEST['id']);

//change the status
$where = "id = ".$_REQUEST['id'];
$db->update('subcontractors', $data , $where);


//update if this contract is scheduled for termination
$sql = $db->select()
    ->from('subcontractors_scheduled_close_cotract')
	->where('subcontractors_id =?', $_REQUEST['id'])
	->where('status =?', 'waiting');
$schedule_close_contract = $db->fetchRow($sql);	
if($schedule_close_contract['id']){
	//change the status
	$data = array('status' => 'removed');
    $where = "id = ".$schedule_close_contract['id'];
    $db->update('subcontractors_scheduled_close_cotract', $data , $where);
}
	
	

//HISTORY
//INSERT NEW RECORD TO THE subcontractors_history
$changes = "Deleted Staff Contract.<br>";
$changes .= "<b>Changes made : </b>.".$history_changes;
$data = array (
		'subcontractors_id' => $_REQUEST['id'], 
		'date_change' => $ATZ, 
		'changes' => $changes, 
		'change_by_id' => $_SESSION['admin_id'] ,
		'changes_status' => 'updated'
		);
$db->insert('subcontractors_history', $data);
echo "ok";
?>