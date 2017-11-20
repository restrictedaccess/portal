<?php
include '../conf/zend_smarty_conf.php';
include 'quote_functions.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

$timezone_identifiers = DateTimeZone::listIdentifiers();

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

$quote_id=$_REQUEST['quote_id'];
$quote_detail_id = $_REQUEST['quote_detail_id'];

//echo $quote_id;
if($quote_id == ""){
    echo "Quote.id is missing";
	exit;
}

//quote info
$sql = "SELECT q.id, q.quote_no, date_quoted,l.fname,l.lname, l.email,l.company_name, q.created_by, q.created_by_type , q.date_posted , l.company_address , q.status , ran, q.leads_id FROM quote q LEFT JOIN leads l ON l.id = q.leads_id WHERE q.id = $quote_id;";
$quote = $db->fetchRow($sql);
$quote['quoted_by'] = getCreator($quote['created_by'] , $quote['created_by_type']);	

//quote details 
$quote_detail['no_of_staff'] = 1;
$quote_detail['salary'] = 0;
$quote_detail['staff_country'] = 'Philippines';
$quote_detail['staff_currency'] = 'PHP';
$quote_detail['staff_timezone'] = 'Asia/Manila';
if($quote_detail['client_timezone'] == "") $quote_detail['client_timezone'] = "Australia/Sydney";
$quote_detail['client_start_work_hour'] = '10';
$quote_detail['days'] = 5;
$quote_detail['quoted_price'] = 0;


if($quote_detail_id != ""){
//id, quote_id, work_position, salary, client_timezone, client_start_work_hour, client_finish_work_hour, lunch_start, lunch_out, lunch_hour, work_start, work_finish, working_hours, days, quoted_price, work_status, currency, work_description, notes, currency_fee, currency_rate, gst, no_of_staff, quoted_quote_range, staff_country, staff_timezone, staff_currency

	$sql = $db->select()
	    ->from('quote_details')
		->where('quote_id =?', $quote_id)
		->where('id =?', $quote_detail_id);
    $quote_detail = $db->fetchRow($sql);
	
	if($quote_detail['staff_timezone'] == "") $quote_detail['staff_timezone'] = 'Asia/Manila';
	if($quote_detail['staff_country'] == "") $quote_detail['staff_country'] = 'Philippines';
	if($quote_detail['staff_currency'] == "") $quote_detail['staff_currency'] = 'PHP';
	if($quote_detail['client_timezone'] == "" or $quote_detail['client_timezone'] == "localtime") $quote_detail['client_timezone'] = "Australia/Sydney";
	
	$quote_detail['staff_start_work_hour_str'] = ConvertTime($quote_detail['staff_timezone'], $quote_detail['staff_timezone'] , $quote_detail['work_start']);
	$quote_detail['staff_finish_work_hour_str'] = ConvertTime($quote_detail['staff_timezone'], $quote_detail['staff_timezone'] , $quote_detail['work_finish']);
	
	
}

//work status
$work_statusArray = array("Full-Time","Part-Time");
$work_statusLongDescArray = array("Full-Time 9hrs w/ 1hr break","Part-Time 4hrs no break");
for($i=0;$i<count($work_statusArray);$i++){
	if($quote_detail['work_status'] == $work_statusArray[$i]){
		$work_status_Options.="<option selected value= ".$work_statusArray[$i].">".$work_statusLongDescArray[$i]."</option>";
	}else{
		$work_status_Options.="<option value= ".$work_statusArray[$i].">".$work_statusLongDescArray[$i]."</option>";
	}
}

//WEEKDAYS TIME
$timeNum = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","00");
$timeArray = array("1:00 am","2:00 am","3:00 am","4:00 am","5:00 am","6:00 am","7:00 am","8:00 am","9:00 am","10:00 am","11:00 am","12:00 noon","1:00 pm","2:00 pm","3:00 pm","4:00 pm","5:00 pm","6:00 pm","7:00 pm","8:00 pm","9:00 pm","10:00 pm","11:00 pm","12:00 am");

$time_display=array();
for($i=0; $i<count($timeNum); $i++)
{
	if($quote_detail['client_start_work_hour'] == $timeNum[$i]){
		$client_start_work_hour_start_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}else{
		$client_start_work_hour_start_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}
	
	if($quote_detail['client_finish_work_hour'] == $timeNum[$i]){
		$quote_detail['client_finish_work_hour_str'] =$timeArray[$i];
	}
	
	$data = array(
	    'time' => $timeNum[$i],
		'time_str' => $timeArray[$i]
	);
	
	array_push($time_display, $data);
}






$smarty->assign('applicants', leads_endorsed_interviewed_candidates($quote['leads_id']));
$smarty->assign('time_display', $time_display);
$smarty->assign('quote_detail_id',$quote_detail_id);
$smarty->assign('staff_timezone', $STAFF_TIMEZONE);
$smarty->assign('staff_country', $STAFF_COUNTRY);
$smarty->assign('staff_currency',$STAFF_CURRENCY);
$smarty->assign('client_currency',$CLIENT_CURRENCY);
$smarty->assign('client_start_work_hour_start_hours_Options',$client_start_work_hour_start_hours_Options);
$smarty->assign('work_status_Options', $work_status_Options);
$smarty->assign('quote_detail', $quote_detail);
$smarty->assign('quote', $quote);
$smarty->assign('timezone_identifiers', $timezone_identifiers);
$smarty->display('quote_details_form.tpl');
?>