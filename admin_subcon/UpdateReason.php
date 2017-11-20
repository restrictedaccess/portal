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

$sql=$db->select()
    ->from('subcontractors')
	->where('id=?', $_REQUEST['id']);
$subcon = $db->fetchRow($sql);	

$data = array(
    'reason' => $_REQUEST['reason'],
	'reason_type' => $_REQUEST['reason_type'],
	'replacement_request' => $_REQUEST['replacement_request'],
    'service_type' => $_REQUEST['service_type'],
	'status' => $_REQUEST['contract_status'],
);


if($subcon['status'] == 'terminated'){
	$end_date_contract = $subcon['date_terminated'];
}
	
if($subcon['status'] == 'resigned'){
	$end_date_contract = $subcon['resignation_date'];
}

//history changes
$history_changes = compareData($data , "subcontractors" , $_REQUEST['id']);

if($_REQUEST['contract_status'] == 'terminated'){
	$data['date_terminated'] = $end_date_contract;
}
	
if($_REQUEST['contract_status'] == 'resigned'){
	$data['resignation_date'] = $end_date_contract;
}

$data['end_date'] = $end_date_contract;

//update
$where = "id = ".$_REQUEST['id'];
$db->update('subcontractors', $data , $where);

//HISTORY
//INSERT NEW RECORD TO THE subcontractors_history
$changes = "Updated Reason.<br>";
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