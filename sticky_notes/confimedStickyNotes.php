<?php 
include '../conf/zend_smarty_conf.php';
include '../time.php'; 
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
$id = $_REQUEST['id'];

if($_SESSION['agent_no']!="")
{
	$user_id = $_SESSION['agent_no'];
	$user_type = "agent";
}

$data = array(
	'status' => 'confirmed', 
	'confirmed_by' => $user_id, 
	'confirmed_by_type' => $user_type, 
	'confirmed_date' => $ATZ
	);
$where = "id = ".$id;	
$db->update('sticky_notes', $data , $where);
echo "confirmed and removed from the list";


?>