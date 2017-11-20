<?php
include './conf/zend_smarty_conf.php';
include 'function.php';

if($_SESSION['agent_no'] != "" or $_SESSION['agent_no'] != NULL){
		
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$_SESSION['agent_no']);
	$agent = $db->fetchRow($sql);
	
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'agent';
	
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';
	

}else{
	
	die("Session Expires. Please re-login");
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;





$leads_id = $_REQUEST['leads_id'];
$ran = get_rand_id();

$data = array(
	'leads_id' => $leads_id,
	'created_by_id' => $created_by_id,
	'created_by_type' => $created_by_type,
	'filled_up_by_id' => $created_by_id,
	'filled_up_by_type' => $created_by_type,
	'date_created' => $ATZ,
	'status' => 'new',
	'ran' => $ran
	
);
//echo "<pre>";
//print_r($data);
//echo "</pre>";	
//exit;
$db->insert('gs_job_role_selection', $data);
$custom_recruitment_id = $db->lastInsertId();

$_SESSION["gs_job_role_selection_id"] = $custom_recruitment_id;

header("Location:/portal/custom_get_started/create_from_leads_profile.php?leads_id=$leads_id");
exit;
$custom_recruitment_link = sprintf('../get_started/Custom-Recruitment-Link.php?ran=%s', $ran);	
//echo $custom_recruitment_link;
header("location: $custom_recruitment_link");
exit;
?>