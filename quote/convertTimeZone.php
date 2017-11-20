<?php
include '../function.php';
$client_start_hour = $_REQUEST['client_start_work_hour'];
$client_finsh_hour = $_REQUEST['client_finish_work_hour'];
$timezone = $_REQUEST['client_timezone'];
//echo $timezone."<br>";
//$result =  setConvertTimezones($timezone, 'Asia/Manila' , $client_start_hour, $client_finsh_hour);


$staff_hour_start = ConvertTime($timezone, 'Asia/Manila' , $client_start_hour);
$staff_hour_finish = ConvertTime($timezone, 'Asia/Manila' , $client_finsh_hour);
//echo "<small>$staff_hour_start - $staff_hour_finish</small>";

$timeNumber = array("06","06:30","07","07:30","08","08:30","09","09:30","10","10:30","11","11:30","12","12:30","13","13:30","14","14:30","15","15:30","16","16:30","17","17:30","18","18:30","19","19:30","20","20:30","21","21:30","22","22:30","23","23:30","00","00:30","01","01:30","02","02:30","03","03:30","04","04:30","05","05:30");
$timeStrArray = array("06:00 am","06:30 am","07:00 am","07:30 am","08:00 am","08:30 am","09:00 am","09:30 am","10:00 am","10:30 am","11:00 am","11:30 am","12:00 noon","12:30 noon","01:00 pm","01:30 pm","02:00 pm","02:30 pm","03:00 pm","03:30 pm","04:00 pm","04:30 pm","05:00 pm","05:30 pm","06:00 pm","06:30 pm","07:00 pm","07:30 pm","08:00 pm","08:30 pm","09:00 pm","09:30 pm","10:00 pm","10:30 pm","11:00 pm","11:30 pm","12:00 am","12:30 am","01:00 am","01:30 am","02:00 am","02:30 am","03:00 am","03:30 am","04:00 am","04:30 am","05:00 am","05:30 am");


for($i=0; $i<count($timeNumber); $i++)
{
	
	if($staff_hour_start == $timeStrArray[$i]){
		$staff_start_work_hours_Options.="<option selected value= ".$timeNumber[$i].">".$timeStrArray[$i]."</option>";
	}
	else{
		$staff_start_work_hours_Options.="<option value= ".$timeNumber[$i].">".$timeStrArray[$i]."</option>";
	}
	
	
	
	if($staff_hour_finish == $timeStrArray[$i]){
		$staff_finish_work_hours_Options.="<option selected value= ".$timeNumber[$i].">".$timeStrArray[$i]."</option>";
	}
	else{
		$staff_finish_work_hours_Options.="<option value= ".$timeNumber[$i].">".$timeStrArray[$i]."</option>";
	}
		
}


?>

<p><label>Start :</label>
		  <select name="start" id="start"  onChange="setWorkHour();" class="select" style="width:100px;">
			<?php echo  $staff_start_work_hours_Options;?>
		  </select></p>
<p><label>Finish :</label> <select name="out" id="out" class="select" style="width:100px;" onChange="setWorkHour();" >
			  <?php echo $staff_finish_work_hours_Options;?>
		</select>
</p>

