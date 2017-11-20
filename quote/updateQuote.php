<?
include '../config.php';
include '../conf.php';
include '../function.php';

if($_SESSION['agent_no']==NULL and $_SESSION['admin_id']==NULL){
	die("ID is Missing.");
}

$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];
if($admin_id!=NULL){
	$created_by = $admin_id;
	$created_by_type = 'admin';
	
}

if($agent_no!=NULL){
	$created_by = $agent_no;
	$created_by_type = 'agent';
}

$quote_id = $_REQUEST['id'];
$salary = $_REQUEST['salary'];
$client_timezone = $_REQUEST['client_timezone'];
$client_start_work_hour = $_REQUEST['client_start_work_hour'];
$client_finish_work_hour = $_REQUEST['client_finish_work_hour'];
$lunch_start = $_REQUEST['lunch_start'];
$lunch_out = $_REQUEST['lunch_out'];
$lunch_hour = $_REQUEST['lunch_hour'];
$start = $_REQUEST['start'];
$out = $_REQUEST['out'];
$hour = $_REQUEST['hour'];
$days = $_REQUEST['days'];
$quoted_price = $_REQUEST['quoted_price'];

$currency = $_REQUEST['currency'];
$work_status = $_REQUEST['work_status'];

$quote_details_id =$_REQUEST['quote_details_id'];

$work_position = $_REQUEST['work_position'];

$work_description = filterfield($_REQUEST['work_description']);

$currency_rate = $_REQUEST['currency_rate'];
$gst = $_REQUEST['gst'];

$no_of_staff = $_REQUEST['no_of_staff'];

$quoted_quote_range = filterfield($_REQUEST['quoted_quote_range']);


if($gst == "with"){
	//"AUD","USD","POUND"
	if($currency == "AUD"){
		$gst = (($quoted_price * $no_of_staff) * .10);
	}
	if($currency == "POUND"){
		$gst = (($quoted_price * $no_of_staff) * .15);
	}
	if($currency == "USD"){
		$gst = (($quoted_price * $no_of_staff) * .0);
	}
}else{
	$gst =0;
}

if($currency_rate == NULL){
	$currency_rate = 0;
	$currency_fee = 0;
}else{
	$rate = ($quoted_price / 38);
	$today_rate = ($quoted_price / $currency_rate);
	$currency_fee = $today_rate - $rate;
}


if($salary==""){
	$salary=0;
}
if($quoted_price==""){
	$quoted_price =0;
}


/*
SELECT * FROM quote_details q;
id, quote_id, salary, client_timezone, client_start_work_hour, client_finish_work_hour, lunch_start, lunch_out, lunch_hour, work_start, work_finish, working_hours, days, quoted_price, work_status, currency
*/

$query = "UPDATE quote_details SET 
			salary = $salary, 
			client_timezone = '$client_timezone', 
			client_start_work_hour = '$client_start_work_hour', 
			client_finish_work_hour = '$client_finish_work_hour', 
			lunch_start = '$lunch_start', 
			lunch_out = '$lunch_out', 
			lunch_hour = '$lunch_hour', 
			work_start = '$start', 
			work_finish = '$out', 
			working_hours = '$hour', 
			days = '$days', 
			quoted_price = $quoted_price ,
			work_status = '$work_status', 
			currency = '$currency',
			work_position = '$work_position',
			work_description = '$work_description',
			currency_fee = $currency_fee ,
			currency_rate = $currency_rate,
			gst = $gst,
			no_of_staff = '$no_of_staff',
			quoted_quote_range = '$quoted_quote_range'
			WHERE quote_id = $quote_id AND 
			id = $quote_details_id;";
//echo $query;
$result = mysql_query($query);
if(!$result){
	die("ERROR IN SQL SCRIPT.<BR>".$query);
}
echo $quote_id;
?>
