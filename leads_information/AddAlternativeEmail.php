<?php
include '../conf/zend_smarty_conf.php';
include '../lib/validEmail.php';
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
$alternative_email = $_REQUEST['alternative_email'];

if (!validEmailv2($alternative_email)){
	echo "Invalid Email Address";
	exit;
}

//check the leads alternative email if existing
$sql = $db->select()
	->from('leads_alternate_emails' ,'id')
	->where('leads_id =?' , $leads_id)
	->where('email =?' , $alternative_email);
//echo $sql;exit;	
$id = $db->fetchOne($sql);	
if($id){
	echo "Alternative email address already exist.";
	exit;
}	

	
//id, leads_id, email, date_added, added_by_id, added_by_type, counter
$data = array('leads_id' => $leads_id , 'email' => $alternative_email , 'date_added' => $ATZ, 'added_by_id' => $comment_by_id, 'added_by_type' => $merged_by_type);
$db->insert('leads_alternate_emails' , $data);

$history_changes = "Added manually alternative email [ ".$alternative_email." ]";
$changes = array('leads_id' => $leads_id ,
			 'date_change' => $ATZ, 
			 'changes' => $history_changes, 
			 'change_by_id' => $comment_by_id, 
			 'change_by_type' => $comment_by_type);
$db->insert('leads_info_history', $changes);

$data = array('last_updated_date' => $ATZ);
$db->update('leads', $data, 'id='.$leads_id);
	
echo "save";
//echo $leads_id." \n ".$alternative_email;exit;
//$smarty->display('ShowAddAlternativeEmailsForm.tpl');
?>