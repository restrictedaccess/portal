<?php 
include '../conf/zend_smarty_conf.php';
include '../time.php'; 
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
$message = $_REQUEST['message'];


if($_SESSION['agent_no']!="")
{
	$user_id = $_SESSION['agent_no'];
	$user_type = "agent";
}


//id, users_id, users_type, date_created, message, status, confirmed_by, confirmed_by_type, confirmed_date
$data = array(
	'users_id' => $user_id, 
	'users_type' => $user_type, 
	'date_created' => $ATZ, 
	'message' => $message
	);
$db->insert('sticky_notes', $data );
echo "new message saved";


?>