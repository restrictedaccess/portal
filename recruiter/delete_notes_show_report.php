<?php
include('../conf/zend_smarty_conf.php');

$userid = $_REQUEST["userid"];
$notes_type = $_REQUEST["notes_type"];
$notes_id = $_REQUEST["notes_id"];

if($notes_type == "communications")
{
	$where = "id = ".$notes_id;	
	$db->delete('applicant_history' , $where);	
}
if($notes_type == "evaluation")
{
	$where = "id = ".$notes_id;	
	$db->delete('evaluation_comments' , $where);
}

//START: insert staff history
include('../lib/staff_history.php');
staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'COMMUNICATIONS', 'DELETE', $notes_type);
//ENDED: insert staff history
?>