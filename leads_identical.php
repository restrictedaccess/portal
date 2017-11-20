<?php
include('conf/zend_smarty_conf_root.php');

header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

$url = basename($_SERVER['SCRIPT_FILENAME'])."?".$_SERVER['QUERY_STRING'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	
	$session_name = $agent['fname']." ".$agent['lname'];
	$session_email = $agent['email'];
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'agent';
	$view_leads_setting = $agent['view_leads_setting'];
	$access_all_leads = $agent['access_all_leads'];
	
	$smarty->assign('agent_section',True);
	
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	
	$session_name = $admin['admin_fname']." ".$admin['admin_lname'];
	$session_email = $admin['admin_email'];
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';
	
	$smarty->assign('admin_section',True);	

}else{

	header("location:index.php");
}

include 'function.php';
$leads_id=$_REQUEST['id'];
if($leads_id == "" or $leads_id == NULL){
	echo  "Leads Profile cannot be shown. Leads ID is Missing";
	exit;
}


$lead_status = $_REQUEST['lead_status'];
if($lead_status == "") $lead_status = 'New Leads';
$site = $_SERVER['HTTP_HOST'];


//LEADS INFORMATION
$sql = $db->select()
	->from('leads')
	->where('id =?' ,$leads_id);
$leads_info = $db->fetchRow($sql);		
	
$queryIdentical = $db->select()
		->from(array('i' => 'leads_indentical') , array('i.id','existing_leads_id'))
		->join(array('l' => 'leads') , 'l.id = i.existing_leads_id' , array('fname' , 'lname' , 'email' , 'status' , 'officenumber' , 'mobile'))
		->where('i.leads_id =?' , $leads_id);
$identical_leads = $db->fetchAll($queryIdentical);

$smarty->assign('identical_leads_count',count($identical_leads));
$smarty->assign('identical_leads',$identical_leads);
$smarty->assign('leads_info' , $leads_info);
$smarty->assign('leads_id' , $leads_id);
$smarty->assign('lead_status' , $lead_status);
$smarty->display('leads_identical.tpl');
?>