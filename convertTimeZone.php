<?php
//  2009-12-28  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Disabled Updating of working hours




$client_start_hour = $_REQUEST['client_start_work_hour'];
$client_finsh_hour = $_REQUEST['client_finish_work_hour'];
$timezone = $_REQUEST['client_timezone'];



if(strlen($client_start_hour) < 3){
	$client_start_hour = $client_start_hour.":00";
}

if(strlen($client_finsh_hour) < 3){
	$client_finsh_hour = $client_finsh_hour.":00";
}
/*
if(strlen($client_start_hour) < 3){
	$client_start_hour = $client_start_hour.":00";
}else{
	$client_start_hour = str_replace(".5",":30",$client_start_hour);
}

if(strlen($client_finsh_hour) < 3){
	$client_finsh_hour = $client_finsh_hour.":00";
}else{
	$client_finsh_hour = str_replace(".5",":30",$client_finsh_hour);
}
*/
/* TESTING
echo "<br>ORIGINAL<br>";
echo $timezone."<br>";
echo $client_start_hour."<br>".$client_finsh_hour;
echo "<hr>";
*/

$client_timezone = new DateTimeZone($timezone);
$client_start_work_hour = new DateTime("$client_start_hour", $client_timezone);
$client_finish_work_hour = new DateTime("$client_finsh_hour", $client_timezone);



$philippine_timezone = new DateTimeZone("Asia/Manila");
$client_start_work_hour->setTimeZone($philippine_timezone);
$client_finish_work_hour->setTimeZone($philippine_timezone);



$staff_hour_start = $client_start_work_hour->format('H:i');
$staff_hour_finish = $client_finish_work_hour->format('H:i');

/*
$staff_hour_start =  str_replace(":30",".5",$staff_hour_start);
$staff_hour_finish =  str_replace(":30",".5",$staff_hour_finish);

//echo $staff_hour_start;
//echo "<br>";
//echo $staff_hour_finish;

//echo "<hr>";
if (preg_match("/\b:30\b/i", $staff_hour_start)) {
   $staff_hour_start =  str_replace(":30",".5",$staff_hour_start);
}else{
   $staff_hour_start =  str_replace(":00","",$staff_hour_start);
} 

if (preg_match("/\b:30\b/i", $staff_hour_finish)) {
   $staff_hour_finish =  str_replace(":30",".5",$staff_hour_finish);
}else{
	$staff_hour_finish =  str_replace(":00","",$staff_hour_finish);
} 

//echo $staff_hour_start;
//echo "<br>";
//echo $staff_hour_finish;
/* TEST OUTPUT
echo "Converted<br>";
echo "Asia/Manila<br>";
echo $client_start_work_hour->format('h:i a');
echo " ==== ";
echo $client_start_work_hour->format('H:i');
echo "<br>";
echo $client_finish_work_hour->format('h:i a');
echo " ==== ";
echo $client_finish_work_hour->format('H:i');
*/
/*
$client_timezone = new DateTimeZone("Australia/Sydney");
$client_start_work_hour = new DateTime("18:00", $client_timezone);


$philippine_timezone = new DateTimeZone("Asia/Manila");
$client_start_work_hour->setTimeZone($philippine_timezone);



//echo $client_start_work_hour->format('h:i a');
echo $client_start_work_hour->format('H:i');
*/
if (preg_match("/\b:30\b/i", $staff_hour_start)) {
   //$staff_hour_start =  str_replace(":30",".5",$staff_hour_start);
}else{
   $staff_hour_start =  str_replace(":00","",$staff_hour_start);
} 

if (preg_match("/\b:30\b/i", $staff_hour_finish)) {
   //$staff_hour_finish =  str_replace(":30",".5",$staff_hour_finish);
}else{
	$staff_hour_finish =  str_replace(":00","",$staff_hour_finish);
} 

/*
$timeNumber = array("06","06:30","07","07:30","08","08:30","09","09:30","10","10:30","11","11:30","12","12:30","13","13:30","14","14:30","15","15:30","16","16:30","17","17:30","18","18:30","19","19:30","20","20:30","21","21:30","22","22:30","23","23:30","00","00:30","1","1:30","2","2:30","3","3:30","4","4:30","5","5:30");
*/
$timeNumber = array("06","06:30","07","07:30","08","08:30","09","09:30","10","10:30","11","11:30","12","12:30","13","13:30","14","14:30","15","15:30","16","16:30","17","17:30","18","18:30","19","19:30","20","20:30","21","21:30","22","22:30","23","23:30","00","00:30","01","01:30","02","02:30","03","03:30","04","04:30","05","05:30");


$timeStrArray = array("06:00 am","06:30 am","07:00 am","07:30 am","08:00 am","08:30 am","09:00 am","09:30 am","10:00 am","10:30 am","11:00 am","11:30 am","12:00 pm","12:30 noon","01:00 pm","01:30 pm","02:00 pm","02:30 pm","03:00 pm","03:30 pm","04:00 pm","04:30 pm","05:00 pm","05:30 pm","06:00 pm","06:30 pm","07:00 pm","07:30 pm","08:00 pm","08:30 pm","09:00 pm","09:30 pm","10:00 pm","10:30 pm","11:00 pm","11:30 pm","12:00 am","12:30 am","1:00 am","1:30 am","2:00 am","2:30 am","3:00 am","3:30 am","4:00 am","4:30 am","5:00 am","5:30 am");

//echo $staff_hour_start;
for($i=0; $i<count($timeNumber); $i++)
{
	
	if($staff_hour_start == $timeNumber[$i]){
		$staff_start_work_hours_Options.="<option selected value= ".$timeNumber[$i].">".$timeStrArray[$i]."</option>";
	}
	else{
		$staff_start_work_hours_Options.="<option value= ".$timeNumber[$i].">".$timeStrArray[$i]."</option>";
	}
	
	if($staff_hour_finish == $timeNumber[$i]){
		$staff_finish_work_hours_Options.="<option selected value= ".$timeNumber[$i].">".$timeStrArray[$i]."</option>";
	}
	else{
		$staff_finish_work_hours_Options.="<option value= ".$timeNumber[$i].">".$timeStrArray[$i]."</option>";
	}
		
}

?>

<p><b>Start :</b>
		  <select  name="start" id="start"  onChange="setWorkHour();setTimeZoneHourForClient();setLunchHour()" class="text">
			<?=$staff_start_work_hours_Options;?>
		  </select>
		 <b>Finish :</b> <select name="out" id="out" class="text" onChange="setWorkHour();setTimeZoneHourForClient();setLunchHour()" >
			  <?=$staff_finish_work_hours_Options;?>
		</select>
		
</p>


