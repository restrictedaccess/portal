<?php
include('../lib/staff_history.php');
include('../conf/zend_smarty_conf_root.php');
$userid = $_REQUEST["userid"];
$stat = $_REQUEST["stat"];
$admin_id = $_SESSION['admin_id'];

if($stat == 1)
{
	$data= array('userid' => $userid);
	$db->insert('hot_staff', $data);	
	staff_history($db, $userid, $admin_id, 'ADMIN', 'HOT', 'INSERT', '');	
}
if($stat == 0)
{
	$where = "userid = ".$userid;	
	$db->delete('hot_staff', $where);	
	staff_history($db, $userid, $admin_id, 'ADMIN', 'HOT', 'DELETE', '');	
}
?>