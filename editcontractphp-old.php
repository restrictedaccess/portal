<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$userid=$_REQUEST['userid'];
$sid=$_REQUEST['sid'];

//////// $AUSD //////////////////
$salary_month=$_REQUEST['salary_month'];
$salary_week=$_REQUEST['salary_week'];
$salary_day=$_REQUEST['salary_day'];
$salary_hour=$_REQUEST['salary_hour'];

$hour=$_REQUEST['hour'];
$days=$_REQUEST['days'];
$details=$_REQUEST['details'];

///Converted to Phil Pesos
$salary_month2=$_REQUEST['salary_month2'];
$salary_week2=$_REQUEST['salary_week2'];
$salary_day2=$_REQUEST['salary_day2'];
$salary_hour2=$_REQUEST['salary_hour2'];
	
$details=filterfield($details);

/////////////////////////////////
$agent_commission=$_REQUEST['agent_commission'];
$think_commission=$_REQUEST['think_commission'];
$client_price=$_REQUEST['client_price'];
$tax=$_REQUEST['tax'];

$overtime=$_REQUEST['overtime'];
$day_off=$_REQUEST['day_off'];

$work_status=$_REQUEST['work_status'];
$start=$_REQUEST['start'];
$end=$_REQUEST['end'];
$starting_date=$_REQUEST['starting_date'];
$end_date=$_REQUEST['end_date'];

$lunch_start=$_REQUEST['lunch_start'];
$lunch_end=$_REQUEST['lunch_end'];	
$lunch_hour=$_REQUEST['lunch_hour'];	
	/*
	echo "APPLICANT ID :".$userid."<br>".
		"CLIENT ID :" .$leads_id."<br>".
		"POSTING ID :" .$posting_id."<br>".
		"AGENT ID :" .$agent_no."<br>".
		"AUD MONTHLY :" .$salary_month."<br>".
		"AUD WEEKLY :" .$salary_week."<br>".
		"AUD DAILY :" .$salary_day."<br>".
		"AUD HOURLY :" .$salary_hour."<br>".
		"WORKING HOURS :" .$hour."<br>".
		"WORKING DAYS :" .$days."<br>".
		"PHP MONHTLY :" .$salary_month2."<br>".
		"PHP WEEKLY :" .$salary_week2."<br>".
		"PHP DAILY :" .$salary_day2."<br>".
		"PHP HOURLY :" .$salary_hour2."<br>".
		"DETAILS :" .$details."<br><br><br>".
		"AGENT COMMISSION :" .$agent_commission."<br>".
		"COMPANY COMMISSION :" .$think_commission."<br>".
		"CLIENT PRICE :" .$client_price."<br>".
		"TAX :" .$tax."<br>".
		"OVERTIME :" .$overtime."<br>".
		"WORK STATUS :" .$work_status."<br>".
		"STARTING HOURS :" .$start."<br>".
		"ENDING HOURS :" .$end."<br>".
		"STARTING DATE :" .$starting_date."<br>".
		"END DATE :" .$end_date."<br><br />
<br />
";
	*/
		
	//id, leads_id, agent_id, userid, posting_id, date_contracted, client_price, aud_monthly, aud_weekly, aud_daily, aud_hourly, working_hours, working_days, php_monthly, php_weekly, php_daily, php_hourly, details, agent_commission, think_commission, overtime, company_contract_monthly, company_contract_weekly, company_contract_daily, company_contract_hourly, work_status, others, tax, starting_hours, ending_hours, starting_date, end_date
	
	$query="UPDATE subcontractors SET aud_monthly ='$salary_month', aud_weekly = '$salary_week', aud_daily = '$salary_day', aud_hourly = '$salary_hour',
	 working_hours = '$hour', working_days = '$days',
	 php_monthly = '$salary_month2', php_weekly = '$salary_week2', php_daily = '$salary_day2', php_hourly = '$salary_hour2',
	 details = '$details', agent_commission = '$agent_commission', think_commission = '$think_commission' ,
	 client_price = '$client_price',tax = '$tax' ,work_status = '$work_status' ,
	 starting_hours = '$start', ending_hours = '$end', starting_date ='$starting_date', end_date = '$end_date',overtime ='$overtime',day_off = '$day_off',
	 lunch_start= '$lunch_start', lunch_end='$lunch_end' ,lunch_hour = '$lunch_hour'
	 WHERE id = $sid;";
	//echo $query;
	mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());
	header("location:subconlist.php");

?>