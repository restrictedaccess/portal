<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();
$timezone_identifiers = DateTimeZone::listIdentifiers();
if($_SESSION['admin_id']=="")
{
	die("Admin id is missing");
}
$admin_id = $_SESSION['admin_id'];
$userid = $_REQUEST['userid'];
$mode = $_REQUEST['mode'];
//echo $userid;



$query="SELECT * FROM personal p LEFT OUTER JOIN currentjob c ON c.userid = p.userid WHERE p.userid= $userid;";
$result = $db->fetchRow($query);

$latest_job_title=$result['latest_job_title'];
$image= "lib/thumbnail_staff_pic.php?file_name=".$result['image'];
$name = $result['fname']." ".$result['lname'];
$email =$result['email'];
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

$staff_working_days = 'mon,tue,wed,thu,fri';

//check the applicant if existing in the subcontractors table then get the latest staff_currency_id and staff_working_timezone
$sql = $db->select()
	->from('subcontractors')
	->where('userid =?' , $userid)
	->order('id DESC')
	->limit(1);
$existing_contract = $db->fetchRow($sql);
$staff_currency_id = $existing_contract['staff_currency_id'];
$staff_working_timezone = $existing_contract['staff_working_timezone'];;

if(!$staff_currency_id){
	$staff_currency_id = 6;
}

//$sql = "SELECT * FROM leads l WHERE status='Client' ORDER BY l.fname ASC;";
//$result=$db->fetchAll($sql);
//foreach($result as $row)
//{
//	$leadsOptions .="<option  value= ".$row['id'].">".$row['fname']." ".$row['lname']." "." [ ".$row['email']." ] ".$row['company_name']."</option>";
//}	


//CLIENT DROPDOWNBOX
//echo $leads_id;
$sql = $db->select()
	->from(Array('c' => 'clients') , Array('leads_id'))
	->join(Array('l' => 'leads') , 'l.id = c.leads_id' , Array('id' , 'fname' , 'lname' , 'email'))
	->where('l.status =?' , 'Client')
	->order('fname ASC');
//echo $sql;exit;	
$result3=$db->fetchAll($sql);
foreach($result3 as $row){
	
	$response=false;
	$CLIENT_ID = ((int)$row['id']);  //must be an integer
    $CLIENT = new couchClient($couch_dsn, 'client_docs');
    //client currency settings
    $CLIENT->startkey(Array($CLIENT_ID, Array(date('Y'),date('m'),date('d'),date('H'),date('i'),0,0)));
    $CLIENT->endkey(Array($CLIENT_ID, Array(2011,0,0,0,0,0,0)));
    $CLIENT->descending(True);
    $CLIENT->limit(1);
    $response = $CLIENT->getView('client', 'settings');
	//print_r($response)
	if($response->rows[0]->value[0]){
		$leadsOptions .="<option  value= ".$row['id'].">".$row['fname']." ".$row['lname']." "." [ ".$row['email']." ] "." (".$response->rows[0]->value[0].")</option>";
	}
}

if(!$staff_working_timezone){
	$staff_working_timezone = 'Asia/Manila';
}
for ($i=0; $i < count($timezone_identifiers); $i++) {

	if($timezone_identifiers[$i] == "Australia/Sydney"){
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



$timeNum = array("06","06:30","07","07:30","08","08:30","09","09:30","10","10:30","11","11:30","12","12:30","13","13:30","14","14:30","15","15:30","16","16:30","17","17:30","18","18:30","19","19:30","20","20:30","21","21:30","22","22:30","23","23:30","00","00:30","01","01:30","02","02:30","03","03:30","04","04:30","05","05:30");

$timeArray = array("6:00 am","6:30 am","7:00 am","7:30 am","8:00 am","8:30 am","9:00 am","9:30 am","10:00 am","10:30 am","11:00 am","11:30 am","12:00 noon","12:30 pm","1:00 pm","1:30 pm","2:00 pm","2:30 pm","3:00 pm","3:30 pm","4:00 pm","4:30 pm","5:00 pm","5:30 pm","6:00 pm","6:30 pm","7:00 pm","7:30 pm","8:00 pm","8:30 pm","9:00 pm","9:30 pm","10:00 pm","10:30 pm","11:00 pm","11:30 pm","12:00 am","12:30 am","1:00 am","1:30 am","2:00 am","2:30 am","3:00 am","3:30 am","4:00 am","4:30 am","5:00 am","5:30 am");



for($i=0; $i<count($timeNum); $i++)

{

	$start_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";

	$finish_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";

	$client_start_work_hour_start_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";

}	







$work_statusArray = array("Full-Time","Part-Time");

$work_statusLongDescArray = array("Full-Time 9hrs w/ 1hr break","Part-Time 4hrs no break");

for($i=0;$i<count($work_statusArray);$i++){

	$work_status_Options.="<option value= ".$work_statusArray[$i].">".$work_statusLongDescArray[$i]."</option>";

}



$sql = $db->select()
	->from('currency_lookup');
$rateArrays = $db->fetchAll($sql);	
//id, code, sign, num, e, currency, location
foreach($rateArrays as $rateArray){

	if($currency_rate == $rateArray['code'])
	{
		$rate_Options.="<option selected value= '".$rateArray['code']."'>(".$rateArray['sign'].") ".$rateArray['code']."-".$rateArray['currency']."</option>";
	}else{
		$rate_Options.="<option value= '".$rateArray['code']."'>(".$rateArray['sign'].") ".$rateArray['code']."-".$rateArray['currency']."</option>";
	}
	
	if($staff_currency_id == $rateArray['id']){
		$staff_currency_Options .= "<option selected value= '".$rateArray['id']."'>(".$rateArray['sign'].") ".$rateArray['code']."-".$rateArray['currency']."</option>";
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







$calendar_days = array('mon','tue','wed','thu','fri','sat','sun');

$work_days = array('mon','tue','wed','thu','fri'); //legal working days set to deafult

for($i=0;$i<count($calendar_days);$i++)

{

	$key = array_search( $calendar_days[$i], $work_days ); // Find key of given value

	if ($key != NULL || $key !== FALSE) {

		$working_days.="<tr>

		<td class=\"rate_td3\"><input type=\"checkbox\" checked name=\"weekdays\" value='".$calendar_days[$i]."' onclick=\"check_val()\" />".strtoupper($calendar_days[$i])."</td>

		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_start' id='".$calendar_days[$i]."_start' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false)  ><option value=\"0\">-</option></select></span></td>

		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_finish' id='".$calendar_days[$i]."_finish' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option></select></span></td>

		<td class=\"rate_td\"><input type=\"text\" readonly id ='".$calendar_days[$i]."_number_hrs' name ='".$calendar_days[$i]."_number_hrs' class=\"select_small\" /></td>

		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_start_lunch' id='".$calendar_days[$i]."_start_lunch' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option></select></span></td>

		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_finish_lunch' id='".$calendar_days[$i]."_finish_lunch' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option></select></span></td>

		<td class=\"rate_td\"><input type=\"text\" readonly id ='".$calendar_days[$i]."_lunch_number_hrs'  name ='".$calendar_days[$i]."_lunch_number_hrs' class=\"select_small\" /></td>

		</tr>";

	}else{

		$working_days.="<tr>

		<td class=\"rate_td3\"><input type=\"checkbox\" name=\"weekdays\" value='".$calendar_days[$i]."' onclick=\"check_val()\" />".strtoupper($calendar_days[$i])."</td>

		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_start' id='".$calendar_days[$i]."_start' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option></select></span></td>

		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_finish' id='".$calendar_days[$i]."_finish' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option></select></span></td>

		<td class=\"rate_td\"><input type=\"text\" readonly id ='".$calendar_days[$i]."_number_hrs' name ='".$calendar_days[$i]."_number_hrs' class=\"select_small\" /></td>



		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_start_lunch' id='".$calendar_days[$i]."_start_lunch' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option></select></span></td>

		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_finish_lunch' id='".$calendar_days[$i]."_finish_lunch' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option></select></span></td>

		<td class=\"rate_td\"><input type=\"text\" readonly id ='".$calendar_days[$i]."_lunch_number_hrs'  name ='".$calendar_days[$i]."_lunch_number_hrs' class=\"select_small\" /></td>

		</tr>";

	}	

}





if($flexi_schedule == 'yes'){
	$flexi_str = "<input type='checkbox' id='flexi' name='flexi' checked='checked' value='yes' onClick='SetUpFlexi()' />";
}else{
	$flexi_str = "<input type='checkbox' id='flexi' name='flexi' value='no' onClick='SetUpFlexi()' />";
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

$smarty->assign('flexi_str' , $flexi_str);
$smarty->assign('service_type_Options', $service_type_Options);


$approve_controls = "false";

$smarty->assign('approve_all_overtimes_Options',$approve_all_overtimes_Options);
$smarty->assign('staff_working_days',$staff_working_days);
$smarty->assign('initial_email_password',$initial_email_password);
$smarty->assign('initial_skype_password',$initial_skype_password);
$smarty->assign('reg_work_days',$reg_work_days);
$smarty->assign('payment_Options',$payment_Options);
$smarty->assign('approve_control',$approve_controls);
$smarty->assign('working_days',$working_days);
$smarty->assign('gst_Options',$gst_Options);
$smarty->assign('with_bp_comm_Options',$with_bp_comm_Options);
$smarty->assign('with_aff_comm_Options',$with_aff_comm_Options);
$smarty->assign('rate_Options',$rate_Options);
$smarty->assign('staff_currency_Options',$staff_currency_Options);
$smarty->assign('work_status_Options',$work_status_Options);
$smarty->assign('start_hours_Options',$start_hours_Options);
$smarty->assign('finish_hours_Options',$finish_hours_Options);
$smarty->assign('client_start_work_hour_start_hours_Options',$client_start_work_hour_start_hours_Options);
$smarty->assign('latest_job_title',$latest_job_title);
$smarty->assign('mode',$mode);
$smarty->assign('userid',$userid);
$smarty->assign('image',$image);
$smarty->assign('name',$name);
$smarty->assign('email',$email);
$smarty->assign('skype',$skype);
$smarty->assign('tel',$tel);
$smarty->assign('cell',$cell);
$smarty->assign('gender',$gender);
$smarty->assign('dateapplied',$dateapplied);
$smarty->assign('dateupdated',$dateupdated);
$smarty->assign('address',$address);
$smarty->assign('nationality',$nationality);
$smarty->assign('timezones_Options',$timezones_Options);
$smarty->assign('staff_timezones_Options',$staff_timezones_Options);
$smarty->assign('leadsOptions',$leadsOptions);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty->display('showApplicantDetails.tpl');
?>