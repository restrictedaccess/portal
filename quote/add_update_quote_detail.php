<?php
include '../conf/zend_smarty_conf.php';
include 'quote_functions.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


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


$quote_id = $_REQUEST['quote_id'];
$mode = $_REQUEST['mode'];
$quote_detail_id = $_REQUEST['quote_detail_id'];


$work_position = $_REQUEST['work_position'];
$staff_country = $_REQUEST['staff_country'];
$staff_timezone = $_REQUEST['staff_timezone'];
$work_start = $_REQUEST['work_start'];
$work_finish = $_REQUEST['work_finish'];
$working_hours = $_REQUEST['working_hours'];
$days = $_REQUEST['days'];
$work_status = $_REQUEST['work_status'];
$staff_currency = $_REQUEST['staff_currency'];
$salary = $_REQUEST['salary'];
$no_of_staff = $_REQUEST['no_of_staff'];
$work_description = $_REQUEST['work_description'];
$client_timezone = $_REQUEST['client_timezone'];
$client_start_work_hour = $_REQUEST['client_start_work_hour'];
$client_finish_work_hour = $_REQUEST['client_finish_work_hour'];
$currency = $_REQUEST['currency'];
$quoted_price = $_REQUEST['quoted_price'];
$quoted_quote_range = $_REQUEST['quoted_quote_range'];
$userid = $_REQUEST['userid'];

$gst = $_REQUEST['gst'];
if($gst == 'yes'){
    $gst_value = (($quoted_price * $no_of_staff) * .10);
}else{
    $gst_value =0;
}

if($userid == "") $userid = NULL;
$data = array(
    'quote_id' => $quote_id,
	'work_position' => $work_position,
	'staff_country' => $staff_country,
	'staff_timezone' => $staff_timezone,
	'work_start' => $work_start,
	'work_finish' => $work_finish,
	'working_hours' => $working_hours,
	'days' => $days,
	'work_status' => $work_status,
	'staff_currency' => $staff_currency,
	'salary' => $salary,
	'no_of_staff' => $no_of_staff,
	'work_description' => $work_description,
	'client_timezone' => $client_timezone,
	'client_start_work_hour' => $client_start_work_hour,
	'client_finish_work_hour' => $client_finish_work_hour,
	'currency' => $currency,
	'quoted_price' => $quoted_price,
	'quoted_quote_range' => $quoted_quote_range,
	'gst' => $gst_value,
	'userid' => $userid
);

if($mode == 'update'){
    unset($data['quote_id']);
	$where = "id = ".$quote_detail_id;
	$db->update('quote_details', $data, $where); 
}

if($mode == 'insert'){
    $db->insert('quote_details', $data);
}


/*
echo "<pre>";
print_r($data);
echo "</pre>";
*/

echo $quote_id;
exit;
?>