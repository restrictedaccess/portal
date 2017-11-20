<?
$client_start_work_hour = $_REQUEST['client_start_work_hour'];
$client_finish_work_hour = $_REQUEST['client_finish_work_hour'];
$client_timezone = $_REQUEST['client_timezone'];
$lunch_hour = $_REQUEST['lunch_hour'];
/*
AU = Phil time is late  3 hours
US-SF = Phil time is advance 16 hours
US=NY = Phil time is advance 13 hours
UK = Phil time is advance 8 hours
*/

if($client_timezone == "AU")
{
	$start_work_hour = $client_start_work_hour - 3;
	$finish_work_hour = (($client_finish_work_hour - 3) + $lunch_hour);
}
if($client_timezone == "US-SF")
{
	$start_work_hour = $client_start_work_hour + 16;
	$finish_work_hour = (($client_finish_work_hour + 16) + $lunch_hour);
}
if($client_timezone == "US-NY")
{
	$start_work_hour = $client_start_work_hour + 13;
	$finish_work_hour = (($client_finish_work_hour + 13) + $lunch_hour);
}
if($client_timezone == "UK")
{
	$start_work_hour = $client_start_work_hour + 8;
	$finish_work_hour = (($client_finish_work_hour + 8) + $lunch_hour);
}


//echo $start_work_hour."<br>";
//echo $finish_work_hour."<br>";


$timeNum = array("-3","-2","-1","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59","60","61","62","63","64","65","66","67","68","69","70","71","72");
$timeArray = array("9:00 pm","10:00 pm","11:00 am","1:00 am","2:00 am","3:00 am","4:00 am","5:00 am","6:00 am","7:00 am","8:00 am","9:00 am","10:00 am","11:00 am","12:00 noon","1:00 pm","2:00 pm","3:00 pm","4:00 pm","5:00 pm","6:00 pm","7:00 pm","8:00 pm","9:00 pm","10:00 pm","11:00 pm","12:00 am","1:00 am","2:00 am","3:00 am","4:00 am","5:00 am","6:00 am","7:00 am","8:00 am","9:00 am","10:00 am","11:00 am","12:00 noon","1:00 pm","2:00 pm","3:00 pm","4:00 pm","5:00 pm","6:00 pm","7:00 pm","8:00 pm","9:00 pm","10:00 pm","11:00 pm","12:00 am","1:00 am","2:00 am","3:00 am","4:00 am","5:00 am","6:00 am","7:00 am","8:00 am","9:00 am","10:00 am","11:00 am","12:00 noon","1:00 pm","2:00 pm","3:00 pm","4:00 pm","5:00 pm","6:00 pm","7:00 pm","8:00 pm","9:00 pm","10:00 pm","11:00 pm","12:00 am");
for($i=0; $i<count($timeNum); $i++)
{
	// Start Work Phil TZ
	if($start_work_hour == $timeNum[$i])
	{
		$star_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}//else{
	//	$star_hours_Options .="<option  value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	//}
	if($finish_work_hour == $timeNum[$i])
	{
		$finish_hours_Options .="<option selected value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	}//else{
	//	$finish_hours_Options .="<option value= ".$timeNum[$i].">".$timeArray[$i]."</option>";
	//}
	
}



?>
<div style=" background:#CCCCCC; border:#999999 outset 1px; padding:5px; font-weight:bold;">Hours per Day from Staff Phil. Timezone:</div>
<div style=" border:#999999 solid 1px; padding:5px;">
<p style="color:#FF0000; "><b>Working Hours</b></p>

		<p>&nbsp;<b>Start :</b>
		  <select name="start" id="start"  onChange="setWorkHour(document.form.salary.value);" class="text">
			
			<?=$star_hours_Options;?>
		  </select>
		 <b>Finish :</b> <select name="out" id="out" class="text" onChange="setWorkHour(document.form.salary.value);" >
		
		  <?=$finish_hours_Options;?>
		</select>
</p>
