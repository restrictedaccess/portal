<?php

include '../conf/zend_smarty_conf.php';
include 'admin_subcon_function.php';
$smarty = new Smarty();



$start_time = $_REQUEST['start_time'];

$client_timezone = $_REQUEST['client_timezone'];

$work_status = $_REQUEST['work_status'];





if($work_status == "Full-Time"){

	$time_added = 9;

	$time_note = "9 Total working hours with 1 hour break";

}

if($work_status == "Part-Time"){

	$time_added = 4;

	$time_note = "4 Working hours no break time";

}





$sPattern = '/:30/';

$sReplace = '.5';

$start_time = preg_replace( $sPattern, $sReplace, $start_time );

$total_hour =  $start_time + $time_added;

//echo $start_time."<br>";

if ($total_hour > 24){

	$finish_hour = $total_hour - 24;

}else{

	$finish_hour = $total_hour;

}



if($finish_hour == "24") $finish_hour = "00";

//echo $finish_hour."<br>";



$client_finish_work_hour = str_replace(".5",":30",$finish_hour);



//echo $client_finish_work_hour;

$date = new DateTime(date('Y-m-d')." ".configureTime($client_finish_work_hour));
/*
echo "<br>".$date->format("h:i a");
		
exit;


$timeNum = array("06" => "6:00 am" ,"06:30" => "6:30 am","07","07:30","08","08:30","09","09:30","10","10:30","11","11:30","12","12:30","13","13:30","14","14:30","15","15:30","16","16:30","17","17:30","18","18:30","19","19:30","20","20:30","21","21:30","22","22:30","23","23:30","00","0:30","1","1:30","2","2:30","3","3:30","4","4:30","5","5:30");



$timeArray = array("6:00 am","6:30 am","7:00 am","7:30 am","8:00 am","8:30 am","9:00 am","9:30 am","10:00 am","10:30 am","11:00 am","11:30 am","12:00 pm","12:30 pm","1:00 pm","1:30 pm","2:00 pm","2:30 pm","3:00 pm","3:30 pm","4:00 pm","4:30 pm","5:00 pm","5:30 pm","6:00 pm","6:30 pm","7:00 pm","7:30 pm","8:00 pm","8:30 pm","9:00 pm","9:30 pm","10:00 pm","10:30 pm","11:00 pm","11:30 pm","12:00 am","12:30 am","1:00 am","1:30 am","2:00 am","2:30 am","3:00 am","3:30 am","4:00 am","4:30 am","5:00 am","5:30 am");

for($j=0; $j<count($timeNum); $j++)

{

	

	if($client_finish_work_hour == $timeNum[$j])

	{

		$timeNum = $timeNum[$j];

		$timeArray =$timeArray[$j];

		break;

	}

	

}
echo $timeNum;
exit;
*/

$smarty->assign('timeNum',$date->format("H:i"));

$smarty->assign('timeArray',$date->format("h:i a"));

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past

header('Content-type: text/html; charset=utf-8');

$smarty->display('autoPopulate.tpl');





?>