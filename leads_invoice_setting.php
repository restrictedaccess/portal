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
$sql = $db->select()
    ->from('leads_send_invoice_setting')
	->where('leads_id =?', $leads_id);
$invoice_setting = $db->fetchRow($sql);
$cc = explode(',',$invoice_setting['cc_emails']);
$asl_cc = explode(',',$invoice_setting['asl_cc_emails']);
	
if(!$invoice_setting['id']){
    $invoice_setting['address_to'] = 'main_acct_holder';
	
	if($leads_info['acct_dept_email2']){
	    $invoice_setting['default_email_field'] = 'acct_dept_email2';
		$cc =array();
		array_push($cc,'email');
	}
	if($leads_info['acct_dept_email1']){
	    //echo $leads_info['acct_dept_email1'];
		$invoice_setting['default_email_field'] = 'acct_dept_email1';
		$cc =array();
		array_push($cc,'email');
		$invoice_setting['cc_emails'] = "email";
		if($leads_info['acct_dept_email2']){
		    //$invoice_setting['cc_emails'] .= ",acct_dept_email2'";
			array_push($cc,'acct_dept_email2');
		}
	}
	
	if($invoice_setting['default_email_field'] == ''){
	    $invoice_setting['default_email_field'] = 'email';
		$cc =array();
	}
	
	
	if($invoice_setting['asl_default_email'] == ''){
	    $invoice_setting['asl_default_email'] = 'email';
		$asl_cc =array();
	}
	
	
	
	//$invoice_setting['cc_emails'] .= "email";
}
//$invoice_setting['default_email_field'] = 'acct_dept_name1';
//$invoice_setting['cc_emails'] = 'email,acct_dept_email1,acct_dept_email2 ';
//echo "<pre>";
//print_r($invoice_setting);
//echo "</pre>";	
//exit;

//$cc =array();
//foreach($ccs as $c){
//     array_push($cc,$c);
//}

//echo "<pre>";
//print_r($asl_cc);
//echo "</pre>";	

$smarty->assign('cc',$cc);
$smarty->assign('asl_cc',$asl_cc);
$smarty->assign('invoice_setting', $invoice_setting);
$smarty->assign('admin_status',$admin_status);
$smarty->assign('page_type',$page_type);
$smarty->assign('lead_status' , $lead_status);
$smarty->assign('leads_info', $leads_info);	
$smarty->assign('leads_id' , $leads_id);
$smarty->display('leads_invoice_setting.tpl');
?>