<?
$staff_start_work_hour = $_REQUEST['staff_start_work_hour'];
$staff_finish_work_hour = $_REQUEST['staff_finish_work_hour'];
$timezone = $_REQUEST['client_timezone'];



//$staff_start_work_hour = $staff_start_work_hour.":00";
//$staff_finish_work_hour = $staff_finish_work_hour.":00";

if(strlen($staff_start_work_hour) < 3){
	$staff_start_work_hour = $staff_start_work_hour.":00";
}
//else{
//	$staff_start_work_hour = str_replace(".5",":30",$staff_start_work_hour);
//}

if(strlen($staff_finish_work_hour) < 3){
	$staff_finish_work_hour = $staff_finish_work_hour.":00";
}
//else{
//	$staff_finish_work_hour = str_replace(".5",":30",$staff_finish_work_hour);
//}




//Staff Timezone
$staff_timezone = new DateTimeZone("Asia/Manila");
$staff_start_work_hour = new DateTime("$staff_start_work_hour", $staff_timezone);
$staff_finish_work_hour = new DateTime("$staff_finish_work_hour", $staff_timezone);


//echo $staff_start_work_hour->format('h:i a');

//echo $staff_timezone;
//


$client_timezone = new DateTimeZone("$timezone");
//print_r($timezone);
$staff_start_work_hour->setTimeZone($client_timezone);
$staff_finish_work_hour->setTimeZone($client_timezone);

$client_hour_start = $staff_start_work_hour->format('H:i');
$client_hour_finish = $staff_finish_work_hour->format('H:i');



//$client_hour_start =  str_replace(":30",".5",$client_hour_start);
//$client_hour_finish =  str_replace(":30",".5",$client_hour_finish);

//echo $client_hour_start;
//echo "<br>";
//echo $client_hour_finish;

//echo "<hr>";
if (preg_match("/\b:30\b/i", $client_hour_start)) {
   //$client_hour_start =  str_replace(":30",".5",$client_hour_start);
}else{
   $client_hour_start =  str_replace(":00","",$client_hour_start);
} 

if (preg_match("/\b:30\b/i", $client_hour_finish)) {
   //$client_hour_finish =  str_replace(":30",".5",$client_hour_finish);
}else{
	$client_hour_finish =  str_replace(":00","",$client_hour_finish);
} 

$timeNumber = array("06","06:30","07","07:30","08","08:30","09","09:30","10","10:30","11","11:30","12","12:30","13","13:30","14","14:30","15","15:30","16","16:30","17","17:30","18","18:30","19","19:30","20","20:30","21","21:30","22","22:30","23","23:30","00","00:30","1","1:30","2","2:30","3","3:30","4","4:30","5","5:30");

$timeStrArray = array("6:00 am","6:30 am","7:00 am","7:30 am","8:00 am","8:30 am","9:00 am","9:30 am","10:00 am","10:30 am","11:00 am","11:30 am","12:00 noon","12:30 noon","1:00 pm","1:30 pm","2:00 pm","2:30 pm","3:00 pm","3:30 pm","4:00 pm","4:30 pm","5:00 pm","5:30 pm","6:00 pm","6:30 pm","7:00 pm","7:30 pm","8:00 pm","8:30 pm","9:00 pm","9:30 pm","10:00 pm","10:30 pm","11:00 pm","11:30 pm","12:00 am","12:30 am","1:00 am","1:30 am","2:00 am","2:30 am","3:00 am","3:30 am","4:00 am","4:30 am","5:00 am","5:30 am");

for($i=0; $i<count($timeNumber); $i++)
{
		
	if($client_hour_start == $timeNumber[$i]){
		$client_start_work_hours_Options.="<option selected value= ".$timeNumber[$i].">".$timeStrArray[$i]."</option>";
	}
	else{
		$client_start_work_hours_Options.="<option value= ".$timeNumber[$i].">".$timeStrArray[$i]."</option>";
	}
	
	if($client_hour_finish == $timeNumber[$i]){
		$client_finish_work_hours_Options.="<option selected value= ".$timeNumber[$i].">".$timeStrArray[$i]."</option>";
	}
	else{
		$client_finish_work_hours_Options.="<option value= ".$timeNumber[$i].">".$timeStrArray[$i]."</option>";
	}
		
}

?>
 <p ><b>Client Perspective</b></p>
		  <p><b>Start :</b>
		  <select name="client_start_work_hour" id="client_start_work_hour"  onChange="setWorkHour();setTimeZoneHour();" class="text" >
			<option value="">-</option>
			<?=$client_start_work_hours_Options;?>
		  </select>
		 <b>Finish :</b> <select name="client_finish_work_hour" id="client_finish_work_hour" class="text" onChange="setWorkHour();setTimeZoneHour();" >
		<option value="">-</option>
		  <?=$client_finish_work_hours_Options;?>
		</select> 
	</p>
 

