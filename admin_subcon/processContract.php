<?php
include '../conf/zend_smarty_conf.php';
require('../tools/CouchDBMailbox.php');
include 'mq_producer_schedule_prepaid_contract.php';
include '../time.php';
include './admin_subcon_function.php';
include '../lib/validEmail.php';

$smarty = new Smarty();
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


if($_SESSION['admin_id']=="")
{
	die("Admin id is missing");
}


//Check if inactive client
$sql = "SELECT COUNT(id)AS no_of_active_contracts FROM subcontractors s WHERE status IN('ACTIVE', 'suspended') AND leads_id=".$_REQUEST['leads_id'];
$no_of_active_contracts = $db->fetchOne($sql);
if($no_of_active_contracts == 0){
	//get the latest staff contract
	$sql = "SELECT DATE(end_date) FROM subcontractors s WHERE status IN('terminated', 'resigned') AND leads_id=".$_REQUEST['leads_id']." ORDER BY end_date DESC LIMIT 1;";
	$latest_end_date = $db->fetchOne($sql);
	$two_months = check_if_two_months_inactive($latest_end_date);
	
	if($two_months > 1){
		set_client_days_before_suspension($_REQUEST['leads_id']);
	}
}

$site = $_SERVER['HTTP_HOST'];
$admin_id = $_SESSION['admin_id'];
$userid = $_REQUEST['userid'];
$leads_id = $_REQUEST['leads_id'];
$posting_id = $_REQUEST['posting_id'];
$work_status = $_REQUEST['work_status'];
$staff_monthly = $_REQUEST['staff_monthly']; // staff monthly

$client_timezone = $_REQUEST['client_timezone'];
$client_start_work_hour = $_REQUEST['client_start_work_hour'];
$client_finish_work_hour = $_REQUEST['client_finish_work_hour'];
$starting_date = $_REQUEST['starting_date'];

$work_days = $_REQUEST['work_days'];
$days = $_REQUEST['days'];
$total_weekly_hrs = $_REQUEST['total_weekly_hrs'];
$total_lunch_hrs = $_REQUEST['total_lunch_hrs'];


$currency = $_REQUEST['currency'];
$client_price = $_REQUEST['client_price']; //client price monthly
$fix_currency_rate = $_REQUEST['fix_currency_rate'];
$current_rate = $_REQUEST['current_rate'];
$with_tax = $_REQUEST['with_tax'];
$total_charge_out_rate =$_REQUEST['total_charge_out_rate'];
$with_bp_comm = $_REQUEST['with_bp_comm'];
$with_aff_comm = $_REQUEST['with_aff_comm'];




//weekdays : mon,tue,wed,thu,fri,sat,sun
//_start , _finish ,_number_hrs , _start_lunch , _finish_lunch _lunch_number_hrs
$mon_start = configureTime($_REQUEST['mon_start']);
$mon_finish = configureTime($_REQUEST['mon_finish']);
$mon_number_hrs = $_REQUEST['mon_number_hrs'];
$mon_start_lunch = configureTime($_REQUEST['mon_start_lunch']);
$mon_finish_lunch = configureTime($_REQUEST['mon_finish_lunch']);
$mon_lunch_number_hrs = $_REQUEST['mon_lunch_number_hrs'];

$tue_start = configureTime($_REQUEST['tue_start']);
$tue_finish = configureTime($_REQUEST['tue_finish']);
$tue_number_hrs = $_REQUEST['tue_number_hrs'];
$tue_start_lunch = configureTime($_REQUEST['tue_start_lunch']);
$tue_finish_lunch =configureTime($_REQUEST['tue_finish_lunch']);
$tue_lunch_number_hrs = $_REQUEST['tue_lunch_number_hrs'];

$wed_start = configureTime($_REQUEST['wed_start']);
$wed_finish = configureTime($_REQUEST['wed_finish']);
$wed_number_hrs = $_REQUEST['wed_number_hrs'];
$wed_start_lunch = configureTime($_REQUEST['wed_start_lunch']);
$wed_finish_lunch = configureTime($_REQUEST['wed_finish_lunch']);
$wed_lunch_number_hrs = $_REQUEST['wed_lunch_number_hrs'];

$thu_start = configureTime($_REQUEST['thu_start']);
$thu_finish = configureTime($_REQUEST['thu_finish']);
$thu_number_hrs = $_REQUEST['thu_number_hrs'];
$thu_start_lunch = configureTime($_REQUEST['thu_start_lunch']);
$thu_finish_lunch = configureTime($_REQUEST['thu_finish_lunch']);
$thu_lunch_number_hrs = $_REQUEST['thu_lunch_number_hrs'];

$fri_start = configureTime($_REQUEST['fri_start']);
$fri_finish = configureTime($_REQUEST['fri_finish']);
$fri_number_hrs = $_REQUEST['fri_number_hrs'];
$fri_start_lunch = configureTime($_REQUEST['fri_start_lunch']);
$fri_finish_lunch = configureTime($_REQUEST['fri_finish_lunch']);
$fri_lunch_number_hrs = $_REQUEST['fri_lunch_number_hrs'];

$sat_start = configureTime($_REQUEST['sat_start']);
$sat_finish = configureTime($_REQUEST['sat_finish']);
$sat_number_hrs = $_REQUEST['sat_number_hrs'];
$sat_start_lunch = configureTime($_REQUEST['sat_start_lunch']);
$sat_finish_lunch = configureTime($_REQUEST['sat_finish_lunch']);
$sat_lunch_number_hrs = $_REQUEST['sat_lunch_number_hrs'];

$sun_start = configureTime($_REQUEST['sun_start']);
$sun_finish = configureTime($_REQUEST['sun_finish']);
$sun_number_hrs = $_REQUEST['sun_number_hrs'];
$sun_start_lunch = configureTime($_REQUEST['sun_start_lunch']);
$sun_finish_lunch = configureTime($_REQUEST['sun_finish_lunch']);
$sun_lunch_number_hrs = $_REQUEST['sun_lunch_number_hrs'];

$admin_notes = $_REQUEST['admin_notes'];

$email = $_REQUEST['email'];
$skype = $_REQUEST['skype'];

$payment_type = $_REQUEST['payment_type'];
$job_designation = $_REQUEST['job_designation'];

$initial_email_password = $_REQUEST['initial_email_password'];
$initial_skype_password = $_REQUEST['initial_skype_password'];

$staff_currency_id = $_REQUEST['staff_currency_id'];
$staff_timezone = $_REQUEST['staff_timezone'];
$flexi = $_REQUEST['flexi'];

$overtime = $_REQUEST['overtime'];
$overtime_monthly_limit = $_REQUEST['overtime_monthly_limit'];

if($overtime == 'NO'){
    $overtime_monthly_limit='0';
}

$staff_other_client_email = $_REQUEST['staff_other_client_email'];
$staff_other_client_email_password = $_REQUEST['staff_other_client_email_password'];
$service_type = $_REQUEST['service_type'];

///
$sql="SELECT * FROM admin WHERE admin_id = $admin_id;";
$result = $db->fetchRow($sql);
$admin_name = $result['admin_fname']." ".$result['admin_lname'];
$admin_email=$result['admin_email'];

//Get the agent_id of the leads
$sql = "SELECT * FROM leads WHERE id = $leads_id;";
$result = $db->fetchRow($sql);
$agent_id = $result['agent_id'];
$client_name = $result['fname']." ".$result['lname'];

//know if the lead is in prepaid payment method
$sql = $db->select()
    ->from('clients', 'prepaid')
	->where('leads_id =?', $leads_id);
$prepaid = $db->fetchOne($sql);


$sql="SELECT * FROM personal WHERE userid = $userid;";
$result = $db->fetchRow($sql);
$staff_name = $result['fname']." ".$result['lname'];
$staff_email = trim($result['email']);  
$staff_skype = $result['skype_id'];

$staff_email_password = $result['initial_email_password'];
$staff_skype_password = $result['initial_skype_password'];


//staff salary per hour
//$php_hourly = ((($staff_monthly * 12)/52)/$total_weekly_hrs);
if($_REQUEST['work_status'] == 'Part-Time'){
    $php_hourly = (((($staff_monthly * 12)/52)/5)/4); //constant formula
}else{
	$php_hourly = (((($staff_monthly * 12)/52)/5)/8); //constant formula
}

$php_hourly = number_format($php_hourly ,2 ,'.' ,',');
$total_charge_out_rate = number_format($total_charge_out_rate ,2 ,'.' ,'');


//echo $staff_email." <br>".$email;
//Check the email address if existing
if($staff_email != $email){
	
	if (!validEmailv2($email)){
		echo "ERROR : Invalid Email Address.\nPlease try to enter a valid email address.";
		exit;
	}
	
	$sql = $db->select()
		->from('personal')
		->where('email =?' , $email);
	$result	= $db->fetchAll($sql);
	if(count($result) >0){
		echo "ERROR : Staff email [ ".$staff_email." ] already exist.\nPlease try to enter a different email address.";
		exit;
	}
}
//exit;
//Process to save
// 1. save it first to the subcontractors_temp table
// 2. create a history or track in the subcontractors_history
// 3. Notify Rica or Admin that a new contract has been created and it is subject for admin approval.

//save it to temporary table "subcontractors_temp"
$data = array (
		'leads_id' => $leads_id, 
		'agent_id' => $agent_id, 
		'userid' => $userid, 
		'posting_id' => $posting_id, 
		'date_contracted' => $ATZ, 
		'client_price' => $client_price,
		'payment_type' => $payment_type,
		'working_hours' => $total_weekly_hrs, 
		'working_days' => $days, 
		'php_monthly' => $staff_monthly, 
		'php_hourly' => $php_hourly, 
		'work_status' => $work_status, 
		'work_days' => $work_days, 
		'starting_date' => $starting_date, 
		'lunch_hour' => $total_lunch_hrs, 
		'current_rate' => $current_rate,
		'total_charge_out_rate' => $total_charge_out_rate, 
		'client_timezone' => $client_timezone, 
		'client_start_work_hour' => $client_start_work_hour, 
		'client_finish_work_hour' => $client_finish_work_hour, 
		'currency' => $currency, 
		'with_tax' => $with_tax, 
		'with_bp_comm' => $with_bp_comm, 
		'with_aff_comm' => $with_aff_comm, 
		'mon_start' => $mon_start, 
		'mon_finish' => $mon_finish, 
		'mon_number_hrs' => $mon_number_hrs, 
		'mon_start_lunch' => $mon_start_lunch, 
		'mon_finish_lunch' => $mon_finish_lunch, 
		'mon_lunch_number_hrs' => $mon_lunch_number_hrs, 
		'tue_start' => $tue_start, 
		'tue_finish' => $tue_finish, 
		'tue_number_hrs' => $tue_number_hrs, 
		'tue_start_lunch' => $tue_start_lunch, 
		'tue_finish_lunch' => $tue_finish_lunch, 
		'tue_lunch_number_hrs' => $tue_lunch_number_hrs, 
		'wed_start' => $wed_start, 
		'wed_finish' => $wed_finish, 
		'wed_number_hrs' => $wed_number_hrs, 
		'wed_start_lunch' => $wed_start_lunch, 
		'wed_finish_lunch' => $wed_finish_lunch, 
		'wed_lunch_number_hrs' => $wed_lunch_number_hrs, 
		'thu_start' => $thu_start, 
		'thu_finish' => $thu_finish, 
		'thu_number_hrs' => $thu_number_hrs, 
		'thu_start_lunch' => $thu_start_lunch, 
		'thu_finish_lunch' => $thu_finish_lunch, 
		'thu_lunch_number_hrs' => $thu_lunch_number_hrs, 
		'fri_start' => $fri_start, 
		'fri_finish' => $fri_finish, 
		'fri_number_hrs' => $fri_number_hrs, 
		'fri_start_lunch' => $fri_start_lunch, 
		'fri_finish_lunch' => $fri_finish_lunch, 
		'fri_lunch_number_hrs' => $fri_lunch_number_hrs, 
		'sat_start' => $sat_start, 
		'sat_finish' => $sat_finish, 
		'sat_number_hrs' => $sat_number_hrs, 
		'sat_start_lunch' => $sat_start_lunch, 
		'sat_finish_lunch' => $sat_finish_lunch, 
		'sat_lunch_number_hrs' => $sat_lunch_number_hrs, 
		'sun_start' => $sun_start, 
		'sun_finish' => $sun_finish, 
		'sun_number_hrs' => $sun_number_hrs, 
		'sun_start_lunch' => $sun_start_lunch, 
		'sun_finish_lunch' => $sun_finish_lunch, 
		'sun_lunch_number_hrs' => $sun_lunch_number_hrs ,
		'job_designation' => $job_designation,
		'flexi' => $flexi,
		'staff_currency_id' => $staff_currency_id,
		'staff_working_timezone' => $staff_timezone,
    	'overtime' => $overtime , 
		'overtime_monthly_limit' => $overtime_monthly_limit,
        'prepaid' => $prepaid,
		'staff_email' => $email,
        'initial_email_password' => $initial_email_password,		
		'staff_other_client_email' => $staff_other_client_email,
		'staff_other_client_email_password' => $staff_other_client_email_password,
		'service_type' => $service_type
		);
if($prepaid == 'yes'){
    $data['prepaid_start_date'] = $starting_date;
}

//print_r($data);exit;		
$db->insert('subcontractors_temp', $data);
$subcontractors_temp_id = $db->lastInsertId();


/*
if($staff_email != $email){
	$data =  array('staff_email' => $email);
	$where = "id = ".$subcontractors_temp_id;
	$db->update('subcontractors_temp', $data , $where);
}
*/


//create a history
//compare and get all the changes
//$email_history_changes = compareStaffEmail($staff_email , $email , $userid);
$skype_history_changes = compareStaffSkype($staff_skype , $skype , $userid);

$email_pass_history_changes = compareStaffEmailPass($staff_email_password , $initial_email_password , $userid);
$skype_pass_history_changes = compareStaffSkypePass($staff_skype_password , $initial_skype_password , $userid);


$changes = "New staff contract created.<br>";
$changes .="<b>Changes made : </b>.".$email_history_changes.$skype_history_changes.$email_pass_history_changes.$skype_pass_history_changes;
$data = array (
		'subcontractors_id' => $subcontractors_temp_id, 
		'date_change' => $ATZ, 
		'changes' => $changes, 
		'change_by_id' => $admin_id ,
		'changes_status' => 'new',
		'note' => $admin_notes
		);

//print_r($data);		
$db->insert('subcontractors_temp_history', $data);
//successfully added
//Send email to Admin

$staff_name = utf8_encode($staff_name);
$staff_name = utf8_decode($staff_name);
			
$details =  "<h3>NEW STAFF CONTRACT DETAILS CREATED</h3>
			<p>Staff : ".$staff_name."</p>
			<p>Job Designation : ".$job_designation."</p>
			<p>Working : ".$work_status."</p>
			<p>Client : ".$client_name."</p>
			<p>Created by : ".$admin_name."</p>";

$details_str =  "NEW STAFF CONTRACT DETAILS CREATED\n
			Staff : ".$staff_name."\n
			Job Designation : ".$job_designation."\n
			Working : ".$work_status."\n
			Client : ".$client_name."\n
			Created by : ".$admin_name;

/*
$mail = new Zend_Mail();
$mail->setBodyHtml($details);

//SEND MAIL
if(TEST){
	$mail->setSubject("TEST NEW STAFF ".$staff_name." CONTRACT DETAILS CREATED");
	$mail->setFrom($admin_email, $admin_name);
    $mail->addTo('devs@remotestaff.com.au', 'devs');
    $mail->send($transport);
}
*/

$attachments_array =NULL;
$bcc_array=NULL;
$cc_array = NULL;
$from = sprintf('%s<%s>', $admin_name, $admin_email);
$html = $details;
$subject = sprintf('NEW STAFF CONTRACT CREATED FOR %s', $staff_name);
$text = NULL;
$to_array = array('devs@remotestaff.com.au');
SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);


//if($prepaid == 'yes'){
    //schedule the contract
    schedule_prepaid_contract($subcontractors_temp_id);
//}

$smarty->assign('details',$details);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty->display('processContract.tpl');
?>