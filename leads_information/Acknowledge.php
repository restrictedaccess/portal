<?php
//2011-02-14 Normaneil Macutay <normanm@remotestaff.com.au>
include '../conf/zend_smarty_conf.php';
include '../time.php';
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
$leads_new_info_id = $_REQUEST['leads_new_info_id'];

$sql = "SELECT fname , lname , email , status FROM leads WHERE id = ".$leads_id;
$leads_info = $db->fetchRow($sql);

$sql = "SELECT * FROM leads_new_info WHERE id = ".$leads_new_info_id;
$leads_new_info = $db->fetchRow($sql);

//remove the flag
$data = array('marked' => 'no' ,'contacted_since' => $ATZ);
$where = "id = ".$leads_id;
$db->update('leads', $data , $where);

//DELETE the RECORD
$where = "id = ".$leads_new_info_id;	
$db->delete('leads_new_info' , $where);

$where = "leads_id = ".$leads_id. " AND leads_new_info_id = ".$leads_new_info_id;
$db->delete('leads_transactions', $where);


$history_changes = "Leads profile Information 2 [ ".$leads_new_info['fname']." ".$leads_new_info['lname']." ] was acknowledged , viewed and discarded<br>";
foreach(array_keys($leads_new_info) as $array_key){
	if($leads_new_info[$array_key]){
		$history_changes .= sprintf("%s => %s  <br>", $array_key, $leads_new_info[$array_key] );
	}
}

$changes = array(
	 'leads_id' => $leads_id ,
	 'date_change' => $ATZ, 
	 'changes' => $history_changes, 
	 'change_by_id' => $comment_by_id, 
	 'change_by_type' => $comment_by_type
);
$db->insert('leads_info_history', $changes);

echo 'acknowledged';
exit;
?>