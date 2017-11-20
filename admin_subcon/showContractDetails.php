<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();
$timezone_identifiers = DateTimeZone::listIdentifiers();
if($_SESSION['admin_id']=="")
{
	die("Admin id is missing");
}
$admin_id = $_SESSION['admin_id'];
$id = $_REQUEST['id'];
$mode = $_REQUEST['mode'];

$sql = $db->select()
    ->from('admin')
	->where('admin_id =?', $_SESSION['admin_id']);
$admin = $db->fetchRow($sql);
$view_inhouse_confidential = $admin['view_inhouse_confidential'];
$delete_staff_contracts = $admin['delete_staff_contracts'];
$activate_suspended_staff_contracts = $admin['activate_suspended_staff_contracts'];
$activate_inactive_staff_contracts = $admin['activate_inactive_staff_contracts'];

//echo $view_inhouse_confidential;
// $mode : new , updated , cancel
//echo sprintf('id => %s <br> mode => %s', $id, $mode);
if($mode == "new"){
	$table = " subcontractors_temp ";
	$approve_control = "true";
	
	$sql = "SELECT COUNT(d.id)AS counter FROM subcontractors_invoice_setup_details d JOIN subcontractors_invoice_setup s ON s.id = d.subcontractors_invoice_setup_id WHERE d.subcontractors_id =".$id." GROUP BY d.subcontractors_id";
	$counter = $db->fetchOne($sql);
	$counter_str ='lock';
	
	
}else if($mode == "edit"){
	$table = " subcontractors";
	$approve_control = "true";
	$counter=0;
	
	$sql = $db->select()
        ->from('subcontractors')
	    ->where('id=?', $id);
    //echo $sql;exit;	
	$subcon = $db->fetchRow($sql);
    $orig_client_price = $subcon['client_price'];
	$orig_client_price_effective_date = $subcon['client_price_effective_date'];
    $subcontractors_id = $id;
	
}else if($mode == "updated"){
	$table = " subcontractors_temp ";
	$approve_control = "true";
	$sql = "SELECT COUNT(d.id)AS counter FROM subcontractors_invoice_setup_details d JOIN subcontractors_invoice_setup s ON s.id = d.subcontractors_invoice_setup_id WHERE d.subcontractors_id =".$id." GROUP BY d.subcontractors_id";
	//$counter = $db->fetchOne($sql);
	
	$sql= $db->select()
	   ->from('subcontractors_temp', 'subcontractors_id')
	   ->where('id=?', $id);
	$subcontractors_id = $db->fetchOne($sql); 
	
	$sql = $db->select()
        ->from('subcontractors')
	    ->where('id=?', $subcontractors_id);
    //echo $sql;exit;	
	$subcon = $db->fetchRow($sql);
    $orig_client_price = $subcon['client_price'];
	$orig_client_price_effective_date = $subcon['client_price_effective_date'];  
	
}else if($mode == "cancel"){
	$table = " subcontractors_temp ";
	$approve_control = "true";
	$sql = "SELECT COUNT(d.id)AS counter FROM subcontractors_invoice_setup_details d JOIN subcontractors_invoice_setup s ON s.id = d.subcontractors_invoice_setup_id WHERE d.subcontractors_id =".$id." GROUP BY d.subcontractors_id";
	$counter = $db->fetchOne($sql);
	$counter_str ='lock';
	
	$sql= $db->select()
	   ->from('subcontractors_temp', 'subcontractors_id')
	   ->where('id=?', $id);
	$subcontractors_id = $db->fetchOne($sql); 
	
	$sql = $db->select()
        ->from('subcontractors')
	    ->where('id=?', $subcontractors_id);
    //echo $sql;exit;	
	$subcon = $db->fetchRow($sql);
    $orig_client_price = $subcon['client_price'];
	$orig_client_price_effective_date = $subcon['client_price_effective_date'];
	
}else{
	$table = " subcontractors ";
	$approve_control = "update";
	$counter=0;
	
	$sql = $db->select()
        ->from('subcontractors')
	    ->where('id=?', $id);
    //echo $sql;exit;	
	$subcon = $db->fetchRow($sql);
    $orig_client_price = $subcon['client_price'];
	$orig_client_price_effective_date = $subcon['client_price_effective_date'];
	$subcontractors_id = $id;
}

function formatTime($time){
	$sPattern = '/:00/';
	$sReplace = '';
	$time = preg_replace( $sPattern, $sReplace, $time );
	return $time;
}
//echo $mode;exit;
global $table;
$sql = "SELECT * FROM $table s WHERE id = $id;";
//echo $sql;exit;

$result = $db->fetchRow($sql);
$userid = $result['userid'];
$leads_id = $result['leads_id'];
$agent_id = $result['agent_id'];
$posting_id = $result['posting_id'];
$client_timezone = $result['client_timezone'];
$work_status = $result['work_status'];
$currency = $result['currency'];
//echo $currency;
$with_tax = $result['with_tax'];
$with_bp_comm = $result['with_bp_comm'];
$with_aff_comm = $result['with_aff_comm'];

$reg_work_days = $result['work_days'];
$work_days = explode(",",$result['work_days']);
$staff_working_days =  $result['work_days'];
$staff_monthly = $result['php_monthly'];
$client_start_work_hour = $result['client_start_work_hour'];
$client_finish_work_hour = $result['client_finish_work_hour'];
$starting_date = $result['starting_date'];

$client_price = $result['client_price'];
$current_rate =$result['current_rate'];
$total_charge_out_rate = $result['total_charge_out_rate'];

//$subcontractors_id = $result['subcontractors_id'];
$payment_type = $result['payment_type'];
$job_designation = $result['job_designation'];

$staff_status = $result['status'];

$resignation_date = $result['resignation_date'];
$date_terminated = $result['date_terminated'];
$reason = $result['reason'];
$reason_type = $result['reason_type'];
$service_type = $result['service_type'];
$replacement_request = $result['replacement_request'];

//echo $reason_type." ".$service_type;exit;

$staff_currency_id = $result['staff_currency_id'];
$staff_hourly_rate = $result['staff_hourly_rate'];
$staff_working_timezone = $result['staff_working_timezone'];

$flexi_schedule = $result['flexi'];
$staff_email = $result['staff_email'];


$overtime = $result['overtime'];
$overtime_monthly_limit = $result['overtime_monthly_limit'];
$prepaid = $result['prepaid'];
$client_price_effective_date=$result['client_price_effective_date'];

$staff_other_client_email = $result['staff_other_client_email'];
$staff_other_client_email_password = $result['staff_other_client_email_password'];


$prepaid_start_date = $result['prepaid_start_date'];

if($client_price_effective_date == ''){
    $client_price_effective_date = $starting_date;
}

if($orig_client_price_effective_date == ''){
    $orig_client_price_effective_date = $starting_date;
}

if($orig_client_price == ""){
    $orig_client_price = $client_price;
}
	
function getSelectBoxOptions($weekday, $column , $id){
	global $db;
	global $table;
	
	global $client_start_work_hour;
	global $client_finish_work_hour;
	
	//_start ,_finish
	
	$weekday = $weekday.$column;
	
	
	$sql = "SELECT ($weekday)AS time_str FROM $table s WHERE id = $id;";
	$result = $db->fetchRow($sql);
	
	
	$time_str = formatTime($result['time_str']);
	
	if($time_str == ""){
		if($column == "_start"){
			$time_str=$client_start_work_hour;
		}else{
			$time_str=$client_finish_work_hour;
		}
	}
	
	$timeNum = array("06","06:30","07","07:30","08","08:30","09","09:30","10","10:30","11","11:30","12","12:30","13","13:30","14","14:30","15","15:30","16","16:30","17","17:30","18","18:30","19","19:30","20","20:30","21","21:30","22","22:30","23","23:30","00","00:30","01","01:30","02","02:30","03","03:30","04","04:30","05","05:30");
$timeArray = array("6:00 am","6:30 am","7:00 am","7:30 am","8:00 am","8:30 am","9:00 am","9:30 am","10:00 am","10:30 am","11:00 am","11:30 am","12:00 noon","12:30 pm","1:00 pm","1:30 pm","2:00 pm","2:30 pm","3:00 pm","3:30 pm","4:00 pm","4:30 pm","5:00 pm","5:30 pm","6:00 pm","6:30 pm","7:00 pm","7:30 pm","8:00 pm","8:30 pm","9:00 pm","9:30 pm","10:00 pm","10:30 pm","11:00 pm","11:30 pm","12:00 am","12:30 am","1:00 am","1:30 am","2:00 am","2:30 am","3:00 am","3:30 am","4:00 am","4:30 am","5:00 am","5:30 am");

	for($i=0; $i<count($timeNum); $i++)
	{	if($time_str == $timeNum[$i]){
			$hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
		}else{
			$hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
		}	
	}

	return $hours_Options;
}

function getNumberHrs($weekday, $column , $id){
	
	global $db;
	global $table;
	
	global $client_start_work_hour;
	global $client_finish_work_hour;
	
	$weekday = $weekday.$column;
	$sql = "SELECT ($weekday)AS time_str FROM $table s WHERE id = $id;";
	$result = $db->fetchRow($sql);
	$time_str = $result['time_str'];
	return intval($time_str);
	//if($time_str == ""){
	//	$client_start_hour = preg_replace( '/:30/', '.5', $client_start_work_hour );
	//	$client_finish_hour = preg_replace( '/:30/', '.5', $client_finish_work_hour );
	//	$time_str = ($client_finish_hour - $client_start_hour);
	//}
	//return $sql;
	
	//return 1;
}


$sql = "SELECT reason_type FROM reason_type;";
$REASON_TYPE = $db->fetchAll($sql);	
foreach($REASON_TYPE as $type){
	if($reason_type == $type['reason_type']){
		$type_Options .="<option value='".$type['reason_type']."' selected>".$type['reason_type']."</option>";
	}else{
		$type_Options .="<option value='".$type['reason_type']."'>".$type['reason_type']."</option>";
	}
}


$sql = "SELECT service_type FROM service_type;";
$SERVICE_TYPE = $db->fetchAll($sql);
foreach($SERVICE_TYPE as $type){
	if($service_type == $type['service_type']){
		$service_type_Options .="<option value='".$type['service_type']."' selected>".$type['service_type']."</option>";
	}else{
		$service_type_Options .="<option value='".$type['service_type']."'>".$type['service_type']."</option>";
	}
}

$yesNoArray= array("no","yes");
for($i=0;$i<count($yesNoArray);$i++){
	
	if($replacement_request == $yesNoArray[$i]){
		
		$replacement_Options .="<option value='".$yesNoArray[$i]."' selected>".$yesNoArray[$i]."</option>";
	}else{
		$replacement_Options .="<option value='".$yesNoArray[$i]."'>".$yesNoArray[$i]."</option>";
	}
}


//WEEKDAYS TIME
$timeNum = array("06","06:30","07","07:30","08","08:30","09","09:30","10","10:30","11","11:30","12","12:30","13","13:30","14","14:30","15","15:30","16","16:30","17","17:30","18","18:30","19","19:30","20","20:30","21","21:30","22","22:30","23","23:30","00","00:30","01","01:30","02","02:30","03","03:30","04","04:30","05","05:30");
$timeArray = array("6:00 am","6:30 am","7:00 am","7:30 am","8:00 am","8:30 am","9:00 am","9:30 am","10:00 am","10:30 am","11:00 am","11:30 am","12:00 noon","12:30 pm","1:00 pm","1:30 pm","2:00 pm","2:30 pm","3:00 pm","3:30 pm","4:00 pm","4:30 pm","5:00 pm","5:30 pm","6:00 pm","6:30 pm","7:00 pm","7:30 pm","8:00 pm","8:30 pm","9:00 pm","9:30 pm","10:00 pm","10:30 pm","11:00 pm","11:30 pm","12:00 am","12:30 am","1:00 am","1:30 am","2:00 am","2:30 am","3:00 am","3:30 am","4:00 am","4:30 am","5:00 am","5:30 am");

for($i=0; $i<count($timeNum); $i++)
{
	$start_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	$finish_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	
	if($client_start_work_hour == $timeNum[$i]){
		$client_start_work_hour_start_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}else{
		$client_start_work_hour_start_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}
}	

//echo "mon_start : ".$mon_start;

$calendar_days = array('mon','tue','wed','thu','fri','sat','sun');
//print_r( $work_days);exit;
for($i=0;$i<count($calendar_days);$i++)
{
	//$key = array_search( $calendar_days[$i], $work_days ); // Find key of given value
	//if ($key != NULL || $key !== FALSE) {
	if(in_array($calendar_days[$i], $work_days)==true){	
		//echo $calendar_days[$i];
		
		$working_days.="<tr>
		<td class=\"rate_td3\"><input type=\"checkbox\" checked name=\"weekdays\" value='".$calendar_days[$i]."' onclick=\"check_val()\" />".strtoupper($calendar_days[$i])."</td>
		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_start' id='".$calendar_days[$i]."_start' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false)  ><option value=\"0\">-</option>".getSelectBoxOptions($calendar_days[$i],'_start' , $id)."</select></span></td>
		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_finish' id='".$calendar_days[$i]."_finish' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option>".getSelectBoxOptions($calendar_days[$i],'_finish' , $id)."</select></span></td>
		<td class=\"rate_td\"><input type=\"text\" readonly id ='".$calendar_days[$i]."_number_hrs' name ='".$calendar_days[$i]."_number_hrs' class=\"select_small\" value=".getNumberHrs($calendar_days[$i],'_number_hrs' , $id)."  /></td>
		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_start_lunch' id='".$calendar_days[$i]."_start_lunch' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option>".getSelectBoxOptions($calendar_days[$i],'_start_lunch' , $id)."</select></span></td>
		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_finish_lunch' id='".$calendar_days[$i]."_finish_lunch' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option>".getSelectBoxOptions($calendar_days[$i],'_finish_lunch' , $id)."</select></span></td>
		<td class=\"rate_td\"><input type=\"text\" readonly id ='".$calendar_days[$i]."_lunch_number_hrs'  name ='".$calendar_days[$i]."_lunch_number_hrs' class=\"select_small\" value=".getNumberHrs($calendar_days[$i],'_lunch_number_hrs' , $id)." /></td>
		</tr>";
	}else{
		$working_days.="<tr>
		<td class=\"rate_td3\"><input type=\"checkbox\" name=\"weekdays\" value='".$calendar_days[$i]."' onclick=\"check_val()\" />".strtoupper($calendar_days[$i])."</td>
		<td class=\"rate_td\"><span><select disabled name='".$calendar_days[$i]."_start' id='".$calendar_days[$i]."_start' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false)  ><option value=\"0\">-</option>".$start_hours_Options."</select></span></td>
		<td class=\"rate_td\"><span><select disabled name='".$calendar_days[$i]."_finish' id='".$calendar_days[$i]."_finish' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option>".$start_hours_Options."</select></span></td>
		<td class=\"rate_td\"><input type=\"text\" readonly id ='".$calendar_days[$i]."_number_hrs' name ='".$calendar_days[$i]."_number_hrs' class=\"select_small\" /></td>
		<td class=\"rate_td\"><span><select disabled name='".$calendar_days[$i]."_start_lunch' id='".$calendar_days[$i]."_start_lunch' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option>".$start_hours_Options."</select></span></td>
		<td class=\"rate_td\"><span><select disabled name='".$calendar_days[$i]."_finish_lunch' id='".$calendar_days[$i]."_finish_lunch' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option>".$start_hours_Options."</select></span></td>
		<td class=\"rate_td\"><input type=\"text\" readonly id ='".$calendar_days[$i]."_lunch_number_hrs'  name ='".$calendar_days[$i]."_lunch_number_hrs' class=\"select_small\" /></td>
		</tr>";
	}
}



//STAFF
$query="SELECT * FROM personal p WHERE p.userid= $userid;";
$result = $db->fetchRow($query);

$image= "lib/thumbnail_staff_pic.php?file_name=".$result['image'];

$name = $result['fname']." ".$result['lname'];
$email =$result['email'];
$registered_email =$result['registered_email'];

$skype = $result['skype_id'];
$tel=$result['tel_area_code']." - ".$result['tel_no'];
$cell =$result['handphone_country_code']."+".$result['handphone_no'];
$gender =$result['gender'];
$dateapplied =$result['datecreated'];
$dateupdated =$result['dateupdated'];
$address=$result['address1']." ".$result['city']." ".$result['postcode']." ".$result['state']." ".$result['country_id'];
$nationality =$result['nationality'];
$initial_email_password = $result['initial_email_password'];
$initial_skype_password = $result['initial_skype_password'];




//CLIENT DROPDOWNBOX
//echo $leads_id;
$sql = "SELECT * FROM leads WHERE id = ". $leads_id;
$lead= $db->fetchRow($sql);
$lead_apply_gst = $lead['apply_gst'];
//echo $lead_apply_gst;
$leadsOptions ="<option selected value= ".$lead['id'].">".$lead['id']." ".$lead['fname']." ".$lead['lname']." "." [ ".$lead['email']." ] </option>";
/*
$sql = $db->select()
	->from(Array('c' => 'clients') , Array('leads_id'))
	->join(Array('l' => 'leads') , 'l.id = c.leads_id' , Array('id' , 'fname' , 'lname' , 'email'))
	->where('l.status =?' , 'Client')
	->where('l.id =?', $leads_id)
	->order('fname ASC');
//echo $sql;exit;	
$result3=$db->fetchAll($sql);
foreach($result3 as $row)
{
	//echo $row['id']."<br>";
	if($leads_id == $row['id']){
		$leadsOptions ="<option selected value= ".$row['id'].">".$row['fname']." ".$row['lname']." "." [ ".$row['email']." ] </option>";
	}//else{
		//$leadsOptions .="<option  value= ".$row['id'].">".$row['fname']." ".$row['lname']." "." [ ".$row['email']." ] </option>";
	//}
}
*/
//exit;
//timezones
if(!$staff_working_timezone){
	$staff_working_timezone = 'Asia/Manila';
}
for ($i=0; $i < count($timezone_identifiers); $i++) {
	if($timezone_identifiers[$i] == $client_timezone){
		$timezones_Options.="<option selected value= ".$timezone_identifiers[$i].">".$timezone_identifiers[$i]."</option>";
	}else{
		$timezones_Options.="<option value= ".$timezone_identifiers[$i].">".$timezone_identifiers[$i]."</option>";
	}
	
	if($timezone_identifiers[$i] == $staff_working_timezone){
		$staff_timezones_Options.="<option selected value= ".$timezone_identifiers[$i].">".$timezone_identifiers[$i]."</option>";
	}else{
		$staff_timezones_Options.="<option value= ".$timezone_identifiers[$i].">".$timezone_identifiers[$i]."</option>";
	}

}


//STAFF WORK STATUS
$work_statusArray = array("Full-Time","Part-Time");
$work_statusLongDescArray = array("Full-Time 9hrs w/ 1hr break","Part-Time 4hrs no break");
for($i=0;$i<count($work_statusArray);$i++){
	if($work_status == $work_statusArray[$i]){
		$work_status_Options.="<option selected value= ".$work_statusArray[$i].">".$work_statusLongDescArray[$i]."</option>";
	}else{
		$work_status_Options.="<option value= ".$work_statusArray[$i].">".$work_statusLongDescArray[$i]."</option>";
	}
}


$sql = $db->select()
	->from('currency_lookup');
$rateArrays = $db->fetchAll($sql);	
//id, code, sign, num, e, currency, location
foreach($rateArrays as $rateArray){

	if($currency == $rateArray['code'])
	{
		$rate_Options.="<option selected value= '".$rateArray['code']."'>(".$rateArray['sign'].") ".$rateArray['code']."-".$rateArray['currency']."</option>";
	}else{
		$rate_Options.="<option value= '".$rateArray['code']."'>(".$rateArray['sign'].") ".$rateArray['code']."-".$rateArray['currency']."</option>";
	}
	
	if($staff_currency_id == $rateArray['id']){
		$staff_currency_Options .= "<option selected value= '".$rateArray['id']."'>(".$rateArray['sign'].") ".$rateArray['code']."-".$rateArray['currency']."</option>";
		$staff_currency = $rateArray['code'];
	}else{
		$staff_currency_Options .= "<option value= '".$rateArray['id']."'>(".$rateArray['sign'].") ".$rateArray['code']."-".$rateArray['currency']."</option>";
	}

}



// WITH TAX , WITH BP COMMISSION , AFFILIATE COMMITSSION
$yesNoArray= array("No","Yes");
for($i=0;$i<count($yesNoArray);$i++)
{
	if($with_tax == strtoupper($yesNoArray[$i])){
		$gst_Options.="<option selected value= ".strtoupper($yesNoArray[$i]).">".strtoupper($yesNoArray[$i])."</option>";
	}else{
		$gst_Options.="<option  value= ".strtoupper($yesNoArray[$i]).">".strtoupper($yesNoArray[$i])."</option>";
	}
	
	if($with_bp_comm == strtoupper($yesNoArray[$i])){
		$with_bp_comm_Options.="<option selected value= ".strtoupper($yesNoArray[$i]).">".strtoupper($yesNoArray[$i])."</option>";
	}else{
		$with_bp_comm_Options.="<option  value= ".strtoupper($yesNoArray[$i]).">".strtoupper($yesNoArray[$i])."</option>";
	}
	
	if($with_aff_comm == strtoupper($yesNoArray[$i])){
		$with_aff_comm_Options.="<option selected value= ".strtoupper($yesNoArray[$i]).">".strtoupper($yesNoArray[$i])."</option>";
	}else{
		$with_aff_comm_Options.="<option  value= ".strtoupper($yesNoArray[$i]).">".strtoupper($yesNoArray[$i])."</option>";
	}
	
	if($overtime == strtoupper($yesNoArray[$i])){
	    $approve_all_overtimes_Options.="<option  selected value= ".strtoupper($yesNoArray[$i]).">".strtoupper($yesNoArray[$i])."</option>";
	}else{
	    $approve_all_overtimes_Options.="<option value= ".strtoupper($yesNoArray[$i]).">".strtoupper($yesNoArray[$i])."</option>";
	}
}


$paymentArray=array("CASH","BARTERCARD");
$paymentArray2=array("100% CASH","BARTERCARD");
for($i=0; $i<count($paymentArray);$i++)
{
	if($payment_type == $paymentArray[$i])
	{
		$payment_Options.="<option selected value= ".$paymentArray[$i].">".$paymentArray2[$i]."</option>";
	}else{
		$payment_Options.="<option value= ".$paymentArray[$i].">".$paymentArray2[$i]."</option>";
	}
}


//echo 'mode => '. $mode;
//echo "<br>";
//echo $subcontractors_id;
//echo "<br>";
if ($mode == 'new'){
    $sql = "SELECT s.id, DATE_FORMAT(s.date_change, '%D %b %Y %r')AS date_changes , s.changes , s.changes_status ,s.note, CONCAT(a.admin_fname,' ',a.admin_lname)AS admin_name FROM subcontractors_temp_history s LEFT JOIN admin a ON a.admin_id = s.change_by_id WHERE subcontractors_id = $id ;";
	$resulta = $db->fetchAll($sql);
}else{
    $sql = "SELECT s.id, DATE_FORMAT(s.date_change, '%D %b %Y %r')AS date_changes , s.changes , s.changes_status ,s.note, CONCAT(a.admin_fname,' ',a.admin_lname)AS admin_name FROM subcontractors_history s LEFT JOIN admin a ON a.admin_id = s.change_by_id WHERE subcontractors_id = $subcontractors_id;";
	$resulta = $db->fetchAll($sql);
    
}
//echo $sql;
$histories = array();
foreach($resulta as $result){
	//echo sprintf('%s<hr>', $result['changes']);
	$changes = explode('<br>', $result['changes']);
	$str = array();
	foreach($changes as $change){
		if($change != ""){
			//word salary
			if(stristr($change, 'salary')) {
				$string_array = explode(' ', $change);
				$display_string="";
				foreach($string_array as $word){
					if(is_numeric($word)){
						if($leads_id == '11' and $view_inhouse_confidential == 'N'){
						    $word = 'confidential';
						}
						$display_string .= $word.' ';
					}else{
						$display_string .= $word.' ';
					}
				}
				$str[] = $display_string;
			}else if(stristr($change, 'php_monthly')){
				$string_array = explode(' ', $change);
				$display_string="";
				foreach($string_array as $word){
					if(is_numeric($word)){
						if($leads_id == '11' and $view_inhouse_confidential == 'N'){
						    $word = 'confidential';
						}
						$display_string .= $word.' ';
					}else{
						$display_string .= $word.' ';
					}
				}
				$str[] = $display_string;
			}else if(stristr($change, 'php_hourly')){
				$string_array = explode(' ', $change);
				$display_string="";
				foreach($string_array as $word){
					if(is_numeric($word)){
						if($leads_id == '11' and $view_inhouse_confidential == 'N'){
						    $word = 'confidential';
						}
						$display_string .= $word.' ';
					}else{
						$display_string .= $word.' ';
					}
				}
				$str[] = $display_string;
				
			}else if(stristr($change, 'CLIENT QUOTED PRICE')){
				$string_array = explode(' ', $change);
				$display_string="";
				foreach($string_array as $word){
					if(is_numeric($word)){
						if($leads_id == '11' and $view_inhouse_confidential == 'N'){
						    $word = 'confidential';
						}
						$display_string .= $word.' ';
					}else{
						$display_string .= $word.' ';
					}
				}
				$str[] = $display_string;
				
			}else if(stristr($change, 'CLIENT HOURLY RATE')){
				$string_array = explode(' ', $change);
				$display_string="";
				foreach($string_array as $word){
					if(is_numeric($word)){
						if($leads_id == '11' and $view_inhouse_confidential == 'N'){
						    $word = 'confidential';
						}
						$display_string .= $word.' ';
					}else{
						$display_string .= $word.' ';
					}
				}
				$str[] = $display_string;	
				
			}else{
			    $str[] = $change;
			}
			
			
		}
	}
	//echo "<pre>";
	//print_r($changes);
	//echo "</pre>";
	
	$data =array(
	    'id' => $result['id'],		 
		'date_changes' => $result['date_changes'],
		'changes_status' => $result['changes_status'],
		'note' => $result['note'],
		'admin_name' => $result['admin_name'],
		'changes' => $str
	);
	
	array_push($histories, $data);
}

//echo "<pre>";
//print_r($histories);
//echo "</pre>";
//exit;

if($flexi_schedule == 'yes'){
	$flexi_str = "<input type='checkbox' id='flexi' name='flexi' checked='checked' value='yes' onClick='SetUpFlexi()' />";
}else{
	$flexi_str = "<input type='checkbox' id='flexi' name='flexi' value='no' onClick='SetUpFlexi()' />";
}


$sql = $db->select()
    ->from(array('s' => 'subcontractors_scheduled_close_cotract'))
	->join(array('a'=>'admin'), 'a.admin_id = s.added_by_id', Array('admin_fname'))
	->where('subcontractors_id =?', $id)
	->where('s.status =?', 'waiting');
//echo $sql;	
$schedule_close_contract = $db->fetchRow($sql);	
if($schedule_close_contract['id']){
    $date = new DateTime($schedule_close_contract['scheduled_date']);
	$end_date_str = $date->format("M. d, Y");
	
	$date = new DateTime($schedule_close_contract['date_created']);
	$date_created_str = $date->format("M. d, Y h:i a");
	
	if($schedule['subcontractors_status'] == 'terminated'){
	    $subcontractors_status = 'termination';
	}else{
	    $subcontractors_status = 'resignation';
	}
	//$label ="<p>This staff contract is already scheduled for ".$subcontractors_status." on ".$date->format("M d, Y"). "<br>Replace it with a new date ?</p>";
	$scheduled_label ="<p align='center'><b>This staff contract is already scheduled for ".$subcontractors_status." on ".$end_date_str. "</b></p>
	<p><strong>Scheduled By</strong> : ".$schedule_close_contract['admin_fname']."</p>
	<p><strong>Date Created</strong> : ".$date_created_str."</p>
	<p><strong>Service Type</strong> : <em>".$schedule_close_contract['service_type']."</em></p>
	<p><strong>Replacement Request</strong> : <em>".$schedule_close_contract['replacement_request']."</em></p>
	<p><strong>Reason Type</strong> : <em>".$schedule_close_contract['reason_type']."</em></p>
	<p><strong>Reason</strong> : <em>".$schedule_close_contract['reason']."</em></p>"; 
	
	//$smarty->assign('end_date_str',$end_date_str);
	$smarty->assign('scheduled_label',$scheduled_label);
	//$smarty->assign('schedule_close_contract',$schedule_close_contract);
}

//Check if Staff Contract has Scheduled Salary Update
$sql = $db->select()
    ->from('subcontractors_scheduled_subcon_rate')
	->where('status =?', 'waiting')
	->where('subcontractors_id =?', $id);
//echo $sql;	
$salary_updates	= $db->fetchAll($sql);
if($salary_updates){
	$smarty->assign('salary_updates',$salary_updates);
}

//Check if contract has Scheduled client price Update
$sql = $db->select()
    ->from('subcontractors_scheduled_client_rate')
	->where('status =?', 'waiting')
	->where('subcontractors_id =?', $id);
//echo $sql;	
$client_price_updates = $db->fetchAll($sql);
if($client_price_updates){
	$smarty->assign('client_price_updates',$client_price_updates);
}



if($staff_status == 'suspended'){
    //to make the overlay div visible
	$counter = 1;
	$counter_str = 'suspended';
}

//echo $table." ".$mode;
if ($mode == 'new'){
    if($staff_email != ""){
        $email = $staff_email;
	}	
	//echo $email;
}

if (in_array($_SESSION['admin_id'], $ADMIN_MANAGE_INHOUSE_CONFIDENTIAL_INFO) == true) {
	$smarty->assign('admin_manage_inhouse_confidentila_info',True);
}

if ($delete_staff_contracts == 'Y') {
	$smarty->assign('admin_delete_staff_contracts',True);
}

if($activate_inactive_staff_contracts == 'Y'){
	$smarty->assign('activate_inactive_staff_contracts',True);
}


$smarty->assign('activate_suspended_staff_contracts',$activate_suspended_staff_contracts);
$smarty->assign('histories',$histories);
$smarty->assign('staff_other_client_email', $staff_other_client_email);
$smarty->assign('staff_other_client_email_password', $staff_other_client_email_password);
$smarty->assign('prepaid_start_date', $prepaid_start_date);
$smarty->assign('orig_client_price_effective_date', $orig_client_price_effective_date);
$smarty->assign('orig_client_price', $orig_client_price);
$smarty->assign('client_price_effective_date',$client_price_effective_date);
$smarty->assign('lead_apply_gst', $lead_apply_gst);
$smarty->assign('counter',$counter);
$smarty->assign('counter_str', $counter_str);
$smarty->assign('prepaid',$prepaid);
$smarty->assign('overtime',$overtime);
$smarty->assign('approve_all_overtimes_Options',$approve_all_overtimes_Options);
$smarty->assign('overtime_monthly_limit',$overtime_monthly_limit);
$smarty->assign('flexi_str' , $flexi_str);
$smarty->assign('staff_email',$staff_email);
$smarty->assign('registered_email',$registered_email);

$smarty->assign('initial_email_password',$initial_email_password);
$smarty->assign('initial_skype_password',$initial_skype_password);

$smarty->assign('resignation_date',$resignation_date);
$smarty->assign('date_terminated',$date_terminated);

$smarty->assign('reason',$reason);
$smarty->assign('reason_type',$reason_type);
$smarty->assign('service_type',$service_type);
$smarty->assign('replacement_request',$replacement_request);
$smarty->assign('type_Options', $type_Options);
$smarty->assign('service_type_Options', $service_type_Options);
$smarty->assign('replacement_Options', $replacement_Options);
$smarty->assign('STATUS', Array('terminated', 'resigned'));

$smarty->assign('job_designation',$job_designation);
$smarty->assign('staff_status',$staff_status);
$smarty->assign('client_start_work_hour',$client_start_work_hour);
$smarty->assign('client_finish_work_hour',$client_finish_work_hour);


$smarty->assign('reg_work_days',$reg_work_days);
$smarty->assign('mode',$mode);
$smarty->assign('payment_Options',$payment_Options);
$smarty->assign('table',$table);
$smarty->assign('with_tax',$with_tax);

$smarty->assign('total_charge_out_rate',$total_charge_out_rate);
//$smarty->assign('resulta',$resulta);
$smarty->assign('id',$id);
$smarty->assign('userid',$userid);
$smarty->assign('leads_id',$leads_id);
$smarty->assign('view_inhouse_confidential',$view_inhouse_confidential);
$smarty->assign('latest_job_title',$latest_job_title);
$smarty->assign('image',$image);
$smarty->assign('name',$name);
$smarty->assign('email',$email);
$smarty->assign('skype',$skype);
$smarty->assign('dateapplied',$dateapplied);
$smarty->assign('address',$address);
$smarty->assign('leadsOptions',$leadsOptions);
$smarty->assign('timezones_Options',$timezones_Options);
$smarty->assign('staff_timezones_Options',$staff_timezones_Options);
$smarty->assign('staff_monthly',$staff_monthly);
$smarty->assign('client_start_work_hour_start_hours_Options',$client_start_work_hour_start_hours_Options);
$smarty->assign('client_finish_work_hour',$client_finish_work_hour);
$smarty->assign('starting_date',$starting_date);

$smarty->assign('work_status_Options',$work_status_Options);
$smarty->assign('rate_Options',$rate_Options);
$smarty->assign('staff_currency_Options',$staff_currency_Options);


$smarty->assign('client_price',$client_price);
$smarty->assign('current_rate',$current_rate);

$smarty->assign('gst_Options',$gst_Options);
$smarty->assign('with_bp_comm_Options',$with_bp_comm_Options);
$smarty->assign('with_aff_comm_Options',$with_aff_comm_Options);
$smarty->assign('work_days',$work_days);
$smarty->assign('working_days',$working_days);
$smarty->assign('staff_working_days',$staff_working_days);




header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
if($mode == 'new' and $prepaid == 'yes'){
    $smarty->assign('lead',$lead);
	$smarty->assign('currency',$currency);
	$smarty->assign('staff_currency',$staff_currency);
    $smarty->display('showSummaryApplicantDetailsTextOnly.tpl');
}else{
    $smarty->display('showApplicantDetails.tpl');
}	
?>