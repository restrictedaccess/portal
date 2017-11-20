<?php
include '../conf/zend_smarty_conf.php';
include 'quote_functions.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	

}else{

	die("Session Expires. Please re-login.");
}

$id=$_REQUEST['quote_id'];

$sql = "SELECT q.id, q.quote_no, date_quoted,l.fname,l.lname, l.email,l.company_name,l.mobile, l.officenumber, l.company_address, q.created_by, q.created_by_type , q.date_posted , l.company_address , q.status , ran, q.leads_id FROM quote q LEFT JOIN leads l ON l.id = q.leads_id WHERE q.id = $id;";
$quote = $db->fetchRow($sql);
$quote['quoted_by'] = getCreator($quote['created_by'] , $quote['created_by_type']);
$quote['quoted_by_email'] = getCreatorEmail($quote['created_by'] , $quote['created_by_type']);
//print_r($quote);	

$sql = "SELECT * FROM quote_details WHERE detail_status='displayed' AND quote_id = $id;";
$quote_details = $db->fetchAll($sql);
$details = array();

foreach($quote_details as $d){
    if($d['client_timezone'] == "" or $d['client_timezone'] == "localtime") $d['client_timezone'] = "Australia/Sydney";


    $d['client_working_hours'] = setConvertTimezones($d['client_timezone'], $d['client_timezone'] , $d['client_start_work_hour'], $d['client_finish_work_hour']);
	$d['staff_working_hours'] = setConvertTimezones($d['staff_timezone'], $d['staff_timezone'] , $d['work_start'], $d['work_finish']);
	
	/*
	if($d['no_of_staff'] == "") $d['no_of_staff']=0;
	$d['sub_total'] = $d['quoted_price'] * $d['no_of_staff'];
	$d['total'] = $d['sub_total'] + $d['gst'];
	
	if($d['quoted_price'] > 0){
	    $d['yearly'] = $d['quoted_price'] * 12;
	    $d['weekly'] = $d['yearly'] / 52;
	    $d['daily'] = $d['weekly'] / $d['days'] ;
	    $d['hourly'] = (((($d['quoted_price'] * 12) / 52) / $d['days']) / $d['working_hours']);
	}
	*/
	
	$d['str'] = sprintf('');
	if($d['currency'] == 'POUND') $d['currency'] = 'GBP';
	
	$sql = $db->select()
	    ->from('currency_lookup')
	    ->where('code =?', $d['currency']);
	$d['currency_lookup'] = $db->fetchRow($sql);		
	array_push($details, $d);
}

//print_r($details);
//echo $show_control_buttons;
$smarty->assign('details', $details);
$smarty->assign('quote', $quote);
$smarty->assign('date_today', $ATZ);
$smarty->display('show_lead_quote.tpl');	
?>