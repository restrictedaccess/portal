<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();
$client_timezone = $_REQUEST['client_timezone'];
$staff_timezone = $_REQUEST['staff_timezone'];
$start_time = $_REQUEST['start_time'];
$finish_time = $_REQUEST['finish_time'];
$work_status = $_REQUEST['work_status'];
$timezone_identifiers = DateTimeZone::listIdentifiers();
//echo $start_time."<br>".$finish_time."<br>";

function setConvertTimezones($original_timezone, $converted_timezone , $time){
	if($original_timezone!=""){
		$converted_timezone = new DateTimeZone("$converted_timezone");
		$original_timezone = new DateTimeZone($original_timezone);
		$time_str = $time;
		if ($time_str == null) {
			$time_hour = "";
		}
		else {
			$time = new DateTime($time_str.":00", $original_timezone);
			$time->setTimeZone($converted_timezone);
			$time_hour = $time->format('h:i a');
			//$time_hour = $time->format('H:i');
		}
		return $time_hour;
	}

}

function setConvertTimezones2($original_timezone, $converted_timezone , $time){
	if($original_timezone!=""){
		$converted_timezone = new DateTimeZone("$converted_timezone");
		$original_timezone = new DateTimeZone($original_timezone);
		$time_str = $time;
		if ($time_str == null) {
			$time_hour = "";
		}
		else {
			$time = new DateTime($time_str.":00", $original_timezone);
			$time->setTimeZone($converted_timezone);
			//$time_hour = $time->format('h:i a');
			$time_hour = $time->format('H');
		}
		return $time_hour;
	}

}



// uncomment to convert it to staff timezone

$staff_start_time =  setConvertTimezones2($client_timezone, $staff_timezone , $start_time);

$start_time =  setConvertTimezones($client_timezone, $staff_timezone , $start_time);

$finish_time =  setConvertTimezones($client_timezone, $staff_timezone , $finish_time);

//echo $staff_start_time;exit;
//echo $start_time." ".$finish_time;exit;

$timeNum = array("06","06:30","07","07:30","08","08:30","09","09:30","10","10:30","11","11:30","12","12:30","13","13:30","14","14:30","15","15:30","16","16:30","17","17:30","18","18:30","19","19:30","20","20:30","21","21:30","22","22:30","23","23:30","00","00:30","01","01:30","02","02:30","03","03:30","04","04:30","05","05:30");

$timeArray = array("06:00 am","06:30 am","07:00 am","07:30 am","08:00 am","08:30 am","09:00 am","09:30 am","10:00 am","10:30 am","11:00 am","11:30 am","12:00 pm","12:30 pm","01:00 pm","01:30 pm","02:00 pm","02:30 pm","03:00 pm","03:30 pm","04:00 pm","04:30 pm","05:00 pm","05:30 pm","06:00 pm","06:30 pm","07:00 pm","07:30 pm","08:00 pm","08:30 pm","09:00 pm","09:30 pm","10:00 pm","10:30 pm","11:00 pm","11:30 pm","12:00 am","12:30 am","01:00 am","01:30 am","02:00 am","02:30 am","03:00 am","03:30 am","04:00 am","04:30 am","05:00 am","05:30 am");



for($i=0; $i<count($timeNum); $i++){

	// Start Work Chosen Country TZ
	//if($start_time == $timeArray[$i]) //use this if you want to convert it to staff timezone
	if($start_time == $timeArray[$i]){
		$start_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}else{
		$start_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}

	// Finish Work Chosen Country TZ
	//if($finish_time == $timeArray[$i]) //use this if you want to convert it to staff timezone
	if($finish_time == $timeArray[$i]){
		$finish_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}else{
		$finish_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}

	//LUNCH

	//Must have a default time if working status is "Full-time"
	if($work_status == "Full-Time"){
	
		if($timeNum[$i] == "11"){
			$start_lunch_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
		}
		if($timeNum[$i] == "12"){
			$finish_lunch_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
		}

		if($staff_start_time > 17){
			if($timeNum[$i] == "22"){
				$start_lunch_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
			}
			if($timeNum[$i] == "23"){
				$finish_lunch_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
			}
		}
		
		$start_lunch_hours_Options .="<option  value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
		$finish_lunch_hours_Options .="<option  value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}else{	
		$start_lunch_hours_Options .="<option  value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
		$finish_lunch_hours_Options .="<option  value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
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

		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_start' id='".$calendar_days[$i]."_start' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false)  ><option value=\"0\">-</option>".$start_hours_Options."</select></span></td>

		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_finish' id='".$calendar_days[$i]."_finish' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option>".$finish_hours_Options."</select></span></td>

		<td class=\"rate_td\"><input type=\"text\" readonly id ='".$calendar_days[$i]."_number_hrs' name ='".$calendar_days[$i]."_number_hrs' class=\"select_small\" /></td>

		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_start_lunch' id='".$calendar_days[$i]."_start_lunch' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option>".$start_lunch_hours_Options."</select></span></td>

		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_finish_lunch' id='".$calendar_days[$i]."_finish_lunch' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option>".$finish_lunch_hours_Options."</select></span></td>

		<td class=\"rate_td\"><input type=\"text\" readonly id ='".$calendar_days[$i]."_lunch_number_hrs'  name ='".$calendar_days[$i]."_lunch_number_hrs' class=\"select_small\" /></td>

		</tr>";

	}else{

		$working_days.="<tr>

		<td class=\"rate_td3\"><input type=\"checkbox\" name=\"weekdays\" value='".$calendar_days[$i]."' onclick=\"check_val()\" />".strtoupper($calendar_days[$i])."</td>

		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_start' id='".$calendar_days[$i]."_start' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option>".$start_hours_Options."</select></span></td>

		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_finish' id='".$calendar_days[$i]."_finish' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option>".$finish_hours_Options."</select></span></td>

		<td class=\"rate_td\"><input type=\"text\" readonly id ='".$calendar_days[$i]."_number_hrs' name ='".$calendar_days[$i]."_number_hrs' class=\"select_small\" /></td>



		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_start_lunch' id='".$calendar_days[$i]."_start_lunch' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option>".$start_lunch_hours_Options."</select></span></td>

		<td class=\"rate_td\"><span><select name='".$calendar_days[$i]."_finish_lunch' id='".$calendar_days[$i]."_finish_lunch' class=\"select_time\" onchange=setWeekDaysTime('$calendar_days[$i]',false) ><option value=\"0\">-</option>".$finish_lunch_hours_Options."</select></span></td>

		<td class=\"rate_td\"><input type=\"text\" readonly id ='".$calendar_days[$i]."_lunch_number_hrs'  name ='".$calendar_days[$i]."_lunch_number_hrs' class=\"select_small\" /></td>

		</tr>";

	}	

}



for ($i=0; $i < count($timezone_identifiers); $i++) {

	

	if($timezone_identifiers[$i] == "Asia/Manila"){

		$timezones_Options2.="<option selected value= ".$timezone_identifiers[$i].">".$timezone_identifiers[$i]."</option>";

	}else{

		$timezones_Options2.="<option value= ".$timezone_identifiers[$i].">".$timezone_identifiers[$i]."</option>";

	}

}





$smarty->assign('timezones_Options2',$timezones_Options2);

$smarty->assign('working_days',$working_days);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past

header('Content-type: text/html; charset=utf-8');

$smarty->display('staffWorkingDays.tpl');



?> 