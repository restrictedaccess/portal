<?php
include '../conf/zend_smarty_conf.php';

if($_SESSION['admin_id']==""){
	echo "Page cannot be viewed.";
	exit;
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$hiring_coordinator_id = $_REQUEST['hiring_coordinator_id'];
$new_hiring_coordinator_id = $_REQUEST['new_hiring_coordinator_id'];


$sql = $db->select()
    ->from('admin', Array('admin_id', 'admin_fname', 'admin_lname'))
	->where('admin_id =?', $hiring_coordinator_id);
$hiring_manager = $db->fetchRow($sql);	

$sql = $db->select()
    ->from('admin', Array('admin_id', 'admin_fname', 'admin_lname'))
	->where('admin_id =?', $new_hiring_coordinator_id);
$new_hiring_manager = $db->fetchRow($sql);	


$sql = $db->select()
    ->from('leads', Array('id', 'fname', 'lname', 'email'))
	->where('hiring_coordinator_id =?' , $hiring_coordinator_id);
$leads = $db->fetchAll($sql);

echo "<ol>";
foreach($leads as $lead){
	
	//update
	$data = array('hiring_coordinator_id' => $new_hiring_coordinator_id);
	$db->update('leads', $data, 'id='.$lead['id']);
	
	//history
	$changes = array(
				 'leads_id' => $lead['id'],
				 'date_change' => $ATZ, 
				 'changes' => sprintf('Change Hiring Manager [hiring_coordinator_id] from [%s] %s %s to [%s] %s %s. As per Rica request.', $hiring_manager['admin_id'], $hiring_manager['admin_fname'], $hiring_manager['admin_lname'], $new_hiring_manager['admin_id'], $new_hiring_manager['admin_fname'], $new_hiring_manager['admin_lname']), 
				 'change_by_id' => $_SESSION['admin_id'], 
				 'change_by_type' => 'admin'
	);
	$db->insert('leads_info_history', $changes);
	echo sprintf('<li>[%s] %s %s</li>', $lead['id'], $lead['fname'], $lead['lname']);
}
echo "</ol>";
echo "updated";
?>