<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$smarty = new Smarty();


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] !=NULL){
	$comment_by_id = $_SESSION['agent_no'];
	$comment_by_type = 'bp';
	$merged_by_type = 'agent';
}else if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$comment_by_id = $_SESSION['admin_id'];
	$comment_by_type = 'admin';
	$merged_by_type = 'admin';
}else{
	die("Session Expired. Please re-login");
}

$leads_id = $_REQUEST['leads_id'];
$id = $_REQUEST['id'];


if(!$leads_id){
	echo "Leads id is missing.";
	exit;
}	
if(!$id){
	echo "Alternative email id is missing.";
	exit;
}	

$sql=$db->select()
	->from('leads_alternate_emails' , 'email')
	->where('id =?'  , $id);
$alternative_email = $db->fetchOne($sql);	

$where = "id =" .$id;
$db->delete('leads_alternate_emails' , $where);

$history_changes = "Deleted alternative email [ ".$alternative_email." ]";
$changes = array('leads_id' => $leads_id ,
			 'date_change' => $ATZ, 
			 'changes' => $history_changes, 
			 'change_by_id' => $comment_by_id, 
			 'change_by_type' => $comment_by_type);
$db->insert('leads_info_history', $changes);

$data = array('last_updated_date' => $ATZ);
$db->update('leads', $data, 'id='.$leads_id);
	
echo "delete";
?>