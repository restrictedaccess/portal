<?php
//2012-01-20
include('conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
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
	$smarty->assign('agent_section',True);
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	$smarty->assign('admin_section',True);
	
}else{
	header("location:index.php");
	exit;
}

$leads_id=$_REQUEST['id'];
if($leads_id == "" or $leads_id == NULL){
	echo  "Leads Profile cannot be shown. Leads ID is Missing";
	exit;
}


$lead_status = $_REQUEST['lead_status'];
if($lead_status == "") $lead_status = 'New Leads';
$site = $_SERVER['HTTP_HOST'];
$page_type = $_REQUEST['page_type'];
if(!$page_type){
	$page_type = "TRUE";
}
$sql = $db->select()
	->from('leads')
	->where('id =?' ,$leads_id);
$leads_info = $db->fetchRow($sql);
 //echo $leads_info['acct_dept_name1'];
//id, leads_id, address_to, default_email_field, cc_emails, date_added, last_update


$smarty->assign('cc',$cc);
$smarty->assign('invoice_setting', $invoice_setting);
$smarty->assign('admin_status',$admin_status);
$smarty->assign('page_type',$page_type);
$smarty->assign('lead_status' , $lead_status);
$smarty->assign('leads_info', $leads_info);	
$smarty->assign('leads_id' , $leads_id);
$smarty->display('leads_cases.tpl');
?>