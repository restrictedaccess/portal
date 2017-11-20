<?php
include('../conf/zend_smarty_conf_root.php');

$userid = $_GET["userid"]; 
$admin_id = $_SESSION['admin_id'];

$data = array(
	'status' => 'DELETED'
	);
$db->update('personal', $data, "userid = '".$userid."'");

//START: insert staff history
include('../lib/staff_history.php');
staff_history($db, $userid, $admin_id, 'ADMIN', 'STAFF ACCOUNT', 'DELETE', '');	
//ENDED: insert staff history
?> 