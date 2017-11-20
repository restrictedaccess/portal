<?php
include '../conf/zend_smarty_conf.php';
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
$site = $_SERVER['HTTP_HOST'];

$id = $_REQUEST['id'];
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
$mon_number_hrs = formatNum($_REQUEST['mon_number_hrs']);
$mon_start_lunch = configureTime($_REQUEST['mon_start_lunch']);
$mon_finish_lunch = configureTime($_REQUEST['mon_finish_lunch']);
$mon_lunch_number_hrs = formatNum($_REQUEST['mon_lunch_number_hrs']);

$tue_start = configureTime($_REQUEST['tue_start']);
$tue_finish = configureTime($_REQUEST['tue_finish']);
$tue_number_hrs = formatNum($_REQUEST['tue_number_hrs']);
$tue_start_lunch = configureTime($_REQUEST['tue_start_lunch']);
$tue_finish_lunch =configureTime($_REQUEST['tue_finish_lunch']);
$tue_lunch_number_hrs = formatNum($_REQUEST['tue_lunch_number_hrs']);

$wed_start = configureTime($_REQUEST['wed_start']);
$wed_finish = configureTime($_REQUEST['wed_finish']);
$wed_number_hrs = formatNum($_REQUEST['wed_number_hrs']);
$wed_start_lunch = configureTime($_REQUEST['wed_start_lunch']);
$wed_finish_lunch = configureTime($_REQUEST['wed_finish_lunch']);
$wed_lunch_number_hrs = formatNum($_REQUEST['wed_lunch_number_hrs']);

$thu_start = configureTime($_REQUEST['thu_start']);
$thu_finish = configureTime($_REQUEST['thu_finish']);
$thu_number_hrs = formatNum($_REQUEST['thu_number_hrs']);
$thu_start_lunch = configureTime($_REQUEST['thu_start_lunch']);
$thu_finish_lunch = configureTime($_REQUEST['thu_finish_lunch']);
$thu_lunch_number_hrs = formatNum($_REQUEST['thu_lunch_number_hrs']);

$fri_start = configureTime($_REQUEST['fri_start']);
$fri_finish = configureTime($_REQUEST['fri_finish']);
$fri_number_hrs = formatNum($_REQUEST['fri_number_hrs']);
$fri_start_lunch = configureTime($_REQUEST['fri_start_lunch']);
$fri_finish_lunch = configureTime($_REQUEST['fri_finish_lunch']);
$fri_lunch_number_hrs = formatNum($_REQUEST['fri_lunch_number_hrs']);

$sat_start = configureTime($_REQUEST['sat_start']);
$sat_finish = configureTime($_REQUEST['sat_finish']);
$sat_number_hrs = formatNum($_REQUEST['sat_number_hrs']);
$sat_start_lunch = configureTime($_REQUEST['sat_start_lunch']);
$sat_finish_lunch = configureTime($_REQUEST['sat_finish_lunch']);
$sat_lunch_number_hrs = formatNum($_REQUEST['sat_lunch_number_hrs']);

$sun_start = configureTime($_REQUEST['sun_start']);
$sun_finish = configureTime($_REQUEST['sun_finish']);
$sun_number_hrs = formatNum($_REQUEST['sun_number_hrs']);
$sun_start_lunch = configureTime($_REQUEST['sun_start_lunch']);
$sun_finish_lunch = configureTime($_REQUEST['sun_finish_lunch']);
$sun_lunch_number_hrs = formatNum($_REQUEST['sun_lunch_number_hrs']);

$admin_notes = $_REQUEST['admin_notes'];

$email = trim($_REQUEST['email']);
$job_designation = $_REQUEST['job_designation'];

$initial_email_password = $_REQUEST['initial_email_password'];
$initial_skype_password = $_REQUEST['initial_skype_password'];

$staff_currency_id = $_REQUEST['staff_currency_id'];
$staff_timezone = $_REQUEST['staff_timezone'];
$flexi = $_REQUEST['flexi'];

$staff_registered_email = trim($_REQUEST['staff_registered_email']);
$skype = $_REQUEST['skype'];

$payment_type = $_REQUEST['payment_type'];
$overtime = $_REQUEST['overtime'];
$overtime_monthly_limit = $_REQUEST['overtime_monthly_limit'];

$prepaid_start_date = $_REQUEST['prepaid_start_date'];

$staff_other_client_email = $_REQUEST['staff_other_client_email'];
$staff_other_client_email_password = $_REQUEST['staff_other_client_email_password'];


if($overtime == 'NO'){
    $overtime_monthly_limit='0';
}

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
$client_email = $result['email'];
$company_name = $result['company_name'];
$csro_id = $result['csro_id'];
$registered_domain = $result['registered_domain'];

//know if the lead is in prepaid payment method
$sql = $db->select()
    ->from('clients', 'prepaid')
	->where('leads_id =?', $leads_id);
$prepaid = $db->fetchOne($sql);


$sql="SELECT * FROM personal WHERE userid = $userid;";
$result = $db->fetchRow($sql);
$staff_name = $result['fname']." ".$result['lname'];
$staff_email = trim($result['email']); 
$registered_email = $result['registered_email']; 
$staff_skype = $result['skype_id'];
$staff_email_password = $result['initial_email_password'];
$staff_skype_password = $result['initial_skype_password'];

if($csro_id){
	$sql = $db->select()
		->from('admin')
		->where('admin_id =?' , $csro_id);
	$csro=$db->fetchRow($sql);
	$csro_name = $csro['admin_fname']." ".$csro['admin_lname'];
	$csro_email = $csro['admin_email'];
}

//staff salary per hour
if($total_weekly_hrs == 0){
	$total_weekly_hrs = 40; //5 DAYS X 8 HRS
}
$daily_hour = 8;
if($work_status == "Part-Time"){
	$daily_hour = 4;
}else{
	$daily_hour = 8;
}

$php_hourly = ((($staff_monthly * 12)/52)/5/$daily_hour);
$php_hourly = number_format($php_hourly ,2 ,'.' ,',');
$total_charge_out_rate = number_format($total_charge_out_rate ,2 ,'.' ,'');


//echo $staff_email." <br>".$email;
//Check the email address if existing
if($staff_email != $email){
	if (!validEmail($email)){ 
		echo "ERROR : <br>Invalid Email Address. Please try to enter a valid email address.";
		exit;
	}
	
	$sql = $db->select()
		->from('personal')
		->where('email =?' , $email);
	$result	= $db->fetchAll($sql);
	if(count($result) >0){
		echo "ERROR : <br>Staff email [ ".$email." ] already exist.<br>Please try to enter a different email address.";
		exit;
	}
}


//Process to approve
// 1. check if the data are changed or updated
// 2. update the subcontractor_temp 
// 3. insert a record to the subcontract_history
// 4. save data in the subcontractors table

//SUBMITTED DATA
$data = array (
		
		'leads_id' => $leads_id, 
		'agent_id' => $agent_id, 
		'userid' => $userid, 
		'posting_id' => $posting_id, 
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
		'sun_lunch_number_hrs' => $sun_lunch_number_hrs,
		'job_designation' => $job_designation,
		'staff_currency_id' => $staff_currency_id,
		'staff_working_timezone' => $staff_timezone,
		'flexi' => $flexi,
		'overtime' => $overtime , 
		'overtime_monthly_limit' => $overtime_monthly_limit,
		'prepaid' => $prepaid,
		'staff_other_client_email' => $staff_other_client_email,
		'staff_other_client_email_password' => $staff_other_client_email_password,
		'service_type' => $service_type
		
);

if($prepaid == 'yes'){
    $data['prepaid_start_date'] = $prepaid_start_date;
}


//echo "<pre>";
//print_r($data);
//echo "</pre>";exit;
//COMPARE AND GET THE CHANGES
$history_changes = compareData($data , "subcontractors_temp" , $id);
$email_history_changes = compareStaffEmail($staff_email , $email , $userid);
$skype_history_changes = compareStaffSkype($staff_skype , $skype , $userid);
$email_pass_history_changes = compareStaffEmailPass($staff_email_password , $initial_email_password , $userid);
$registered_email_history_changes = compareStaffRegisteredEmail($registered_email , $staff_registered_email , $userid);
$skype_pass_history_changes = compareStaffSkypePass($staff_skype_password , $initial_skype_password , $userid);



//INSERT NEW RECORD 
$data = array (
		'status' => 'ACTIVE',
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
		'sun_lunch_number_hrs' => $sun_lunch_number_hrs,
		'job_designation' => $job_designation,
		'staff_currency_id' => $staff_currency_id,
		'staff_working_timezone' => $staff_timezone,
		'contract_updated' => 'y',
		'flexi' => $flexi,
		'overtime' => $overtime , 
		'overtime_monthly_limit' => $overtime_monthly_limit,
		'prepaid' => $prepaid,
		'client_price_effective_date' => $starting_date,
		'staff_other_client_email' => $staff_other_client_email,
		'staff_other_client_email_password' => $staff_other_client_email_password,
		'service_type' => $service_type
);
if($prepaid == 'yes'){
    $data['prepaid_start_date'] = $prepaid_start_date;
}

$db->insert('subcontractors', $data);
$subcontractors_id = $db->lastInsertId();

//save the client price
//save_client_price('new', $subcontractors_id, NULL);

//Save client rate
$data = array(
    'subcontractors_id' => $subcontractors_id, 
    'start_date' => $starting_date, 
    'rate' => $client_price,
	'work_status' => $work_status
);
$db->insert('subcontractors_client_rate', $data);
			
			
//Save Staff Rate
$data=array(
    'subcontractors_id' =>$subcontractors_id, 
    'start_date' => $starting_date, 
    'rate' => $staff_monthly, 
    'work_status' => $work_status	
    );
$db->insert('subcontractors_staff_rate', $data);


//HISTORY
//INSERT NEW RECORD TO THE subcontractors_history
$changes = "<b>Changes made : </b>.".$email_history_changes.$skype_history_changes.$email_pass_history_changes.$registered_email_history_changes.$skype_pass_history_changes."<br>".$history_changes;
$data = array (
		'subcontractors_id' => $id, 
		'date_change' => $ATZ, 
		'changes' => $changes, 
		'change_by_id' => $admin_id ,
		'changes_status' => 'approved',
		'note' => $admin_notes
		);
$db->insert('subcontractors_temp_history', $data);


//update the temp table
$data = array('temp_status' => 'deleted', 'subcontractors_id' => $subcontractors_id);
$where = "id = ".$id;	
$db->update('subcontractors_temp', $data , $where);



//$data = array('subcontractors_id' => $subcontractors_id);
//$where = "subcontractors_id = ".$id;	
//$db->update('subcontractors_history', $data , $where);

//id, subcontractors_id, date_change, changes, change_by_id, changes_status, note
//transfer histories
$sql = $db->select()
    ->from('subcontractors_temp_history')
	->where('subcontractors_id =?', $id);
$histories = $db->fetchAll($sql);
foreach($histories as $h){
    unset($h['id']);
	$h['subcontractors_id'] = $subcontractors_id;
	$db->insert('subcontractors_history', $h);
}	
//delete temp histories
//$where = "subcontractors_id = ".$id;	
//$db->delete('subcontractors_temp_history', $where);


//if($registered_email == "") {
$where = "userid = ".$userid;
$data = array('registered_email' => $staff_email , 'email' => $email);
$db->update('personal', $data , $where);





$details =  "<h3>APPROVED STAFF CONTRACT </h3>
			<p>Staff : ".$staff_name."</p>
			<p>Job Designation : ".$job_designation."</p>
			<p>Working : ".$work_status."</p>
			<p>Client : ".$client_name."</p>
			<p>Approved by : ".$admin_name."</p>";




$mail = new Zend_Mail();
$mail->setBodyHtml($details);
$mail->setFrom($admin_email, $admin_name);

//SEND MAIL
if(! TEST){
	$mail->setSubject(" STAFF ".$staff_name." CONTRACT HAS BEEN APPROVED");
}else{
	$mail->setSubject("TEST STAFF ".$staff_name." CONTRACT HAS BEEN APPROVED");
}
$mail->addTo('devs@remotestaff.com.au', 'Devs');
$mail->send($transport);


//autoresponder to staff

$sql="SELECT * FROM personal WHERE userid = $userid;";
$result = $db->fetchRow($sql);
$staff_name = $result['fname']." ".$result['lname'];
$staff_email = $result['email'];
$registered_email = $result['registered_email'];
$skype = $result['skype_id'];
$staff_email_password = $result['initial_email_password'];
$skype_password = $result['initial_skype_password'];

$date=date('l jS \of F Y h:i:s A');
$main_pass="<i>(Your specified password on your jobseeker account)</i>";
$smarty->assign('date',$date);
$smarty->assign('staff_name', $staff_name);
$smarty->assign('staff_email', $staff_email);
$smarty->assign('main_pass', $main_pass);
$smarty->assign('site', $site);
$smarty->assign('skype', $skype);
$smarty->assign('skype_password', $skype_password);
$smarty->assign('staff_email_password', $staff_email_password);
$smarty->assign('client_name', $client_name);
$smarty->assign('company_name', $company_name);
$smarty->assign('admin_name', $csro_name);
$smarty->assign('admin_email', $csro_email);
$body = $smarty->fetch('staff_autoresponder.tpl');	


$mail = new Zend_Mail('utf-8');
$mail->setBodyHtml($body);
$mail->setFrom($admin_email, $admin_name);
$mail->addTo('staff.contract.approvals@remotestaff.com.au', 'staff.contract.approvals@remotestaff.com.au');	
//SEND MAIL to the STAFF
if(! TEST){
	
	$mail->addTo($staff_email, $staff_name);
	if($registered_email!=""){
		$mail->addTo($registered_email, $staff_name);
	}
	$mail->addCc($admin_email, $admin_name);
    
	if($csro_email !=""){
	    $mail->addTo($csro_email, 'CSRO');
	}
	$mail->addBcc('devs@remotestaff.com.au', 'devs');
	$mail->setSubject("WELCOME TO REMOTE STAFF ".$staff_name);

}else{

	$mail->addTo('devs@remotestaff.com.au', 'Remotestaff Developers');
	if($registered_email!=""){
		$mail->addTo('devs@remotestaff.com.au', sprintf('%s => %s' ,$staff_name, $registered_email));
	}
	$mail->setSubject(sprintf("TEST WELCOME TO REMOTE STAFF %s Recipients => [ devs@remotestaff.com.au, staffsupport@remotestaff.com.ph, %s, %s ]", $staff_name, $registered_email, $admin_email  ));
 
}
$mail->send($transport);




//SEND MAIL to the CLIENT
if($posting_id > 0){
	$query = "SELECT * FROM posting p WHERE id = $posting_id;";
	$resul=$db->fetchRow($query);
	$ads = $result['jobposition'];
}


function formatTime($time ){
	if($time!=""){
		if(strlen($time) > 2){
			$time_str = $time;
		}else{
			$time_str = $time.":00";
		}
		$time = new DateTime($time_str);
		return $time->format('h:i a');
	}
}

$client_start_work_hour = formatTime($client_start_work_hour);
$client_finish_work_hour  = formatTime($client_finish_work_hour);


$start_date_of_leave = explode('-',$starting_date);
$date = new DateTime();
$date->setDate($start_date_of_leave[0], $start_date_of_leave[1], $start_date_of_leave[2]);


$date->modify("+1 month");
$first_month = $date->format("Y-m-d");
$end_of_first_month = $date->format('Y-m-t');
$date->modify("+1 month");
$third_month = $date->format("Y-m-01");
$end_of_third_month = $date->format('Y-m-t');

$department_email = 'clientsupport@remotestaff.com.au';

$smarty->assign('department_email', $department_email);
$smarty->assign('first_month',$first_month);
$smarty->assign('end_of_first_month',$end_of_first_month);
$smarty->assign('third_month',$third_month);
$smarty->assign('end_of_third_month',$end_of_third_month);

$smarty->assign('job_designation',$job_designation);
$smarty->assign('staff_name',$staff_name);
$smarty->assign('staff_email',$staff_email);
$smarty->assign('starting_date',$starting_date);
$smarty->assign('client_start_work_hour',$client_start_work_hour);
$smarty->assign('client_finish_work_hour',$client_finish_work_hour);
$smarty->assign('skype',$skype);
$smarty->assign('client_name', $client_name);
$smarty->assign('client_email',$client_email);
$smarty->assign('csro', $csro);
$body = $smarty->fetch('client_autoresponder.tpl');		






$mail = new Zend_Mail('utf-8');
$mail->setBodyHtml($body);
if($csro){
   $mail->setFrom($csro['admin_email'], sprintf('%s %s', $csro['admin_fname'], $csro['admin_lname']));
}else{
   $mail->setFrom('CSRO@remotestaff.com.au', 'CSRO@remotestaff.com.au');
}
$mail->addTo('staff.contract.approvals@remotestaff.com.au', 'staff.contract.approvals@remotestaff.com.au');	

if(! TEST){

	$mail->setSubject("Confirming ".$staff_name." first day, Work contact details, Tools and others");
    $mail->addTo( $client_email, $client_name);
	if($csro_email !=""){
	    $mail->addCc($csro_email, 'CSRO');
	}
	
}else{
	
	$mail->setSubject("TEST Confirming ".$staff_name." first day, Work contact details, Tools and others");
	$mail->addTo( 'devs@remotestaff.com.au', "Remotestaff Developers");
	if($csro_email !=""){
	    $mail->addCc($csro_email, 'CSRO');
	}
}

$mail->send($transport);

//check if this contract is paid in subcontractors_invoice_setup_details table
//check if is paid
$sql = $db->select()
    ->from('subcontractors_invoice_setup_details')
	->where('subcontractors_id =?', $id);
$subcontractors_invoice_setup_details = $db->fetchRow($sql);
$subcontractors_invoice_setup_id = $subcontractors_invoice_setup_details['subcontractors_invoice_setup_id'];
if($subcontractors_invoice_setup_id){
	$sql = $db->select()
		->from('subcontractors_invoice_setup')
		->where('id=?', $subcontractors_invoice_setup_id);
	$subcontractors_invoice_setup = $db->fetchRow($sql);	
	$subcontractors_invoice_setup_status = $subcontractors_invoice_setup['status'];
	//$subcontractors_invoice_setup_details_id = $subcontractors_invoice_setup['id'];
	/*
	//save details in couchdb
	$couch_client = new couchClient($couch_dsn, 'subcontractors_temp');
	$doc = new stdClass();
	$doc->admin_id = $_SESSION['admin_id'];
	$doc->subcontractors_invoice_setup_id = $subcontractors_invoice_setup_id;
	$doc->subcontractors_invoice_setup_status= $subcontractors_invoice_setup_status;
	$doc->subcontractors_invoice_setup_details_id=$subcontractors_invoice_setup_details_id;
	$doc->contract = $subcontractors_temp;
	$doc->timestamp = $ATZ;
	
	//echo "Storing \$doc : \$client->storeDoc(\$doc)\n";
	try {
		$response = $couch_client->storeDoc($doc);
	} catch (Exception $e) {
	   echo "Something weird happened: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
	   exit(1);
	}
	*/
}		

//Accounts Autoreponder content
$body =  "<h3>NEW STAFF CONTRACT </h3>
		  <p>Dear Accounts,</p>
		  <p>There is a new contract set between ".$staff_name." and ".$client_name." .  Start day will be on ".$starting_date." Work Schedule is ".$client_start_work_hour." to ".$client_finish_work_hour." time. </p>";

if($csro_id){
	$body .="<p>The CSRO for this contract is ".$csro_name.".</p>";
}

if($subcontractors_invoice_setup_status == 'paid'){
    $body .="<p>First month invoice already been issued and paid.</p>";
}else if($subcontractors_invoice_setup_status == 'awaiting payment'){
    $body .="<p>First month invoice already been issued and waiting for payment.</p>";
}else{
    $body .="<p>Please issue first month invoice and collect payments before the first day of this contract. If not paid, contact CSRO to adjust the first day.</p>";
}
$body .="<p><strong>FYI</strong><br />Service Type : ".$service_type."</p>";

$mail = new Zend_Mail('utf-8');
$mail->setBodyHtml($body);
$mail->setFrom($admin_email, $admin_name);

if(! TEST){
	$to = 'accounts@remotestaff.com.au'; 
	$fullname = "Remotestaff Accounts";
	$mail->setSubject("NEW STAFF CONTRACT");
}else{
	$to = 'devs@remotestaff.com.au'; 
	$fullname = "Remotestaff Developers";
	$mail->setSubject("TEST NEW STAFF CONTRACT ");
}
$mail->addTo($to, $fullname);
$mail->send($transport);


//send email to recruiter staff
$sql = "SELECT r.id, r.userid, a.admin_fname, a.admin_email FROM recruiter_staff r JOIN admin a ON a.admin_id = r.admin_id WHERE r.userid=".$userid;
$recruiter_staff = $db->fetchRow($sql);
if($recruiter_staff['id']){
    $smarty->assign('recruiter_staff',$recruiter_staff);
	$smarty->assign('client_name', $client_name);
	$smarty->assign('staff_name', $staff_name);
	$smarty->assign('job_designation', $job_designation);
	$smarty->assign('starting_date', $starting_date);
    $body = $smarty->fetch('recruiter_staff_autoresponder.tpl');		
    $mail = new Zend_Mail('utf-8');
    $mail->setBodyHtml($body);
	$mail->setFrom('noreply@remotestaff.com.au', 'RS System');
	$subject = sprintf("Your candidate %s has been hired.", $staff_name);
    if(! TEST){
	    $to = $recruiter_staff['admin_email']; 
	    $fullname = $recruiter_staff['admin_fname'];
	    $mail->setSubject($subject);
		$mail->addBcc('devs@remotestaff.com.au', 'devs');
    }else{
	    $to = 'devs@remotestaff.com.au'; 
	    $fullname = "devs";
	    $mail->setSubject("TEST ".$subject);
    }
    $mail->addTo($to, $fullname);
    $mail->send($transport);	
}

$data = array('last_updated_date' => $ATZ);
$db->update('leads', $data, 'id='.$leads_id);			
			
$smarty->assign('details',$details);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty->display('processContract.tpl');
?>