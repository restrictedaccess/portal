<?php
include './conf/zend_smarty_conf_root.php';
include './admin_subcon/admin_subcon_function.php';
include 'time.php';

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

$admin_id = $_SESSION['admin_id'];


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



$weekdays=$_POST['weekdays'];
while (list ($key,$val) = @each ($weekdays)) { 
	 $str.="$val,";
} 
$work_days = substr($str,0,(strlen($str)-1)); // delete the last comma "," 
	



$userid=$_REQUEST['userid'];
$sid=$_REQUEST['sid'];
$leads_id=$_REQUEST['leads_id'];

//pesos
$salary =$_REQUEST['salary'];
$salary_weekly=$_REQUEST['salary_weekly'];
$salary_daily=$_REQUEST['salary_daily'];
$salary_hourly=$_REQUEST['salary_hourly'];

// dollar
$dollar_monthly_hidden =$_REQUEST['dollar_monthly_hidden'];
$dollar_salary_weekly =$_REQUEST['dollar_salary_weekly'];
$dollar_salary_daily = $_REQUEST['dollar_salary_daily'];
$dollar_salary_hourly = $_REQUEST['dollar_salary_hourly'];


//
$hour=$_REQUEST['hour'];
$days=$_REQUEST['days'];
$details=stripslashes($_REQUEST['details']);


// working hours
$start=$_REQUEST['start'];
$out=$_REQUEST['out'];

// lunch
$lunch_start=$_REQUEST['lunch_start'];
$lunch_out=$_REQUEST['lunch_out'];	
$lunch_hour=$_REQUEST['lunch_hour'];


// 
$overtime=$_REQUEST['overtime'];
$day_off=$_REQUEST['day_off'];
$work_status=$_REQUEST['work_status'];
$starting_date=$_REQUEST['starting_date'];
$end_date=$_REQUEST['end_date'];



//Client
$client_price=$_REQUEST['client_price']; // this is the fix price....
$current_rate=$_REQUEST['current_rate'];

// Client Plus Payments
$tax=$_REQUEST['tax'];
$difference=$_REQUEST['difference'];
// client total payments
$total_charge_out_rate = $_REQUEST['hiddenprice2'];

//total plus payment : added payment
$total_plus_payment = ($tax + $difference);

/***********************/
//Commissions

$activate_agent_commission=$_REQUEST['activate_agent_commission'];
$agent_commission=$_REQUEST['agent_commission'];
$think_commission=$_REQUEST['think_commission'];

if($activate_agent_commission =="NO"){
		$think_commission = $think_commission + $agent_commission;
		$agent_commission ="0.00";
}


// Other country converted Rates US | UK
// Rates per country
$us_rate = $_REQUEST['us_rate']; // US
$uk_rate = $_REQUEST['uk_rate']; // UK

// US
$us_dollar_monthly_hidden = $_REQUEST['us_dollar_monthly_hidden'];
$us_dollar_salary_weekly=$_REQUEST['us_dollar_salary_weekly'];
$us_dollar_salary_daily= $_REQUEST['us_dollar_salary_daily'];
$us_dollar_salary_hourly =$_REQUEST['us_dollar_salary_hourly'];

// UK
$uk_pounds_monthly_hidden = $_REQUEST['uk_pounds_monthly_hidden'];
$uk_pounds_salary_weekly =$_REQUEST['uk_pounds_salary_weekly'];
$uk_pounds_salary_daily = $_REQUEST['uk_pounds_salary_daily'];
$uk_pounds_salary_hourly = $_REQUEST['uk_pounds_salary_hourly'];
////


$client_timezone = $_REQUEST['client_timezone'];
$client_start_work_hour = $_REQUEST['client_start_work_hour'];
$client_finish_work_hour = $_REQUEST['client_finish_work_hour'];
$currency_rate = $_REQUEST['currency_rate'];
$gst = $_REQUEST['gst'];

$staff_currency_id = $_REQUEST['staff_currency_id'];

/*

$query="UPDATE subcontractors SET
aud_monthly ='$dollar_monthly_hidden', aud_weekly = '$dollar_salary_weekly', aud_daily = '$dollar_salary_daily', aud_hourly = '$dollar_salary_hourly',
php_monthly = '$salary', php_weekly = '$salary_weekly', php_daily = '$salary_daily', php_hourly = '$salary_hourly',
working_hours = '$hour', working_days = '$days', details = '$details', 
agent_commission = '$agent_commission', think_commission = '$think_commission' ,
client_price = '$client_price',tax = '$tax' ,work_status = '$work_status' ,
starting_hours = '$start', ending_hours = '$out', starting_date ='$starting_date', end_date = '$end_date',overtime ='$overtime',day_off = '$day_off',
lunch_start= '$lunch_start', lunch_end='$lunch_out' ,lunch_hour = '$lunch_hour' , current_rate = '$current_rate' , difference = '$difference' ,
us_rate = '$us_rate', us_dollar_monthly_hidden = '$us_dollar_monthly_hidden', us_dollar_salary_weekly = '$us_dollar_salary_weekly', 
us_dollar_salary_daily = '$us_dollar_salary_daily', us_dollar_salary_hourly = '$us_dollar_salary_hourly', 
uk_rate = '$uk_rate', uk_pounds_monthly_hidden = '$uk_pounds_monthly_hidden', uk_pounds_salary_weekly = '$uk_pounds_salary_weekly', uk_pounds_salary_daily = '$uk_pounds_salary_daily', uk_pounds_salary_hourly = '$uk_pounds_salary_hourly' ,
total_charge_out_rate = '$total_charge_out_rate', total_plus_payment = '$total_plus_payment',
client_timezone = '$client_timezone',
client_start_work_hour = '$client_start_work_hour' ,
client_finish_work_hour = '$client_finish_work_hour',
currency_rate = '$currency_rate',
gst = '$gst' ,
work_days = '$work_days'
WHERE id = $sid;";
mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());
*/

	
$data = array(
		'aud_monthly' => $dollar_monthly_hidden, 
		'aud_weekly'  => $dollar_salary_weekly, 
		'aud_daily'   => $dollar_salary_daily, 
		'aud_hourly'  => $dollar_salary_hourly,
		'php_monthly' => $salary, 
		'php_weekly'  => $salary_weekly, 
		'php_daily'   => $salary_daily, 
		'php_hourly'  => $salary_hourly,
		'working_hours' => $hour, 
		'working_days' => $days, 
		'details' => $details, 
		'agent_commission' => $agent_commission, 
		'think_commission' => $think_commission ,
		'client_price' => $client_price,
		'tax' => $tax ,
		'work_status' => $work_status ,
		'starting_hours' => $start,
		'ending_hours' => $out, 
		'starting_date' => $starting_date, 
		'end_date' => $end_date,
		'overtime' => $overtime,
		'day_off' => $day_off,
		'lunch_start' => $lunch_start, 
		'lunch_end' => $lunch_out ,
		'lunch_hour' => $lunch_hour , 
		'current_rate' => $current_rate , 
		'difference' => $difference ,
		'us_rate' => $us_rate, 
		'us_dollar_monthly_hidden' => $us_dollar_monthly_hidden, 
		'us_dollar_salary_weekly' => $us_dollar_salary_weekly, 
		'us_dollar_salary_daily' => $us_dollar_salary_daily, 
		'us_dollar_salary_hourly' => $us_dollar_salary_hourly, 
		'uk_rate' => $uk_rate, 
		'uk_pounds_monthly_hidden' => $uk_pounds_monthly_hidden, 
		'uk_pounds_salary_weekly' => $uk_pounds_salary_weekly, 
		'uk_pounds_salary_daily' => $uk_pounds_salary_daily, 
		'uk_pounds_salary_hourly' => $uk_pounds_salary_hourly ,
		'total_charge_out_rate' => $total_charge_out_rate, 
		'total_plus_payment' => $total_plus_payment,
		'client_timezone' => $client_timezone,
		'client_start_work_hour' => $client_start_work_hour ,
		'client_finish_work_hour' => $client_finish_work_hour,
		'currency_rate' => $currency_rate,
		'gst' => $gst ,
		'work_days' => $work_days,
		'staff_currency_id' => $staff_currency_id
		);

$history_changes = compareData($data , "subcontractors" , $sid);
$where = "id = ".$sid;
$db->update('subcontractors', $data, $where);


/*
$query_string = "";
if ($_POST) {
  $kv = array();
  foreach ($_POST as $key => $value) {
    $kv[] = "$key => $value";
  }
  $query_string = join("<br>", $kv);
}
else {
  $query_string = $_SERVER['QUERY_STRING'];
}
//echo $query_string;exit;
*/
if($history_changes){
	$data = array (
			'subcontractors_id' => $sid, 
			'date_change' => $ATZ, 
			'changes' => $history_changes, 
			'change_by_id' => $admin_id ,
			'changes_status' => 'updated',
			'note' => 'Contract Updated'
			);
	//print_r($data);exit;		
	$db->insert('subcontractors_history', $data);
}
header("location:contractForm.php?userid=$userid&sid=$sid&lid=$leads_id");


?>