<?php
include('../conf/zend_smarty_conf_root.php');
$userid = $_REQUEST["userid"];
$stat = $_REQUEST["stat"];
if($stat == 1)
{
	$data= array('userid' => $userid);
	$db->insert('experienced_staff', $data);	
}
if($stat == 0)
{
	$where = "userid = ".$userid;	
	$db->delete('experienced_staff', $where);	
}
?>