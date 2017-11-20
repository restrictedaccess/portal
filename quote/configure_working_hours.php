<?php
include '../conf/zend_smarty_conf.php';
include 'quote_functions.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


$staff_timezone = $_REQUEST['staff_timezone'];
$work_status = $_REQUEST['work_status'];
$client_timezone = $_REQUEST['client_timezone'];
$client_start_work_hour = $_REQUEST['client_start_work_hour'];


if($work_status == "Full-Time"){
	$time_added = 9;
}

if($work_status == "Part-Time"){
	$time_added = 4;
}

$sPattern = '/:30/';
$sReplace = '.5';
$start_time = preg_replace( $sPattern, $sReplace, $client_start_work_hour );
$total_hour =  $start_time + $time_added;
//echo $start_time."<br>";
if ($total_hour > 24){
	$finish_hour = $total_hour - 24;
}else{
	$finish_hour = $total_hour;
}
if($finish_hour == "24") $finish_hour = "00";

//client display
$client_finish_work_hour = str_replace(".5",":30",$finish_hour);
$client_finish_work_hour_str = ConvertTime($client_timezone,  $client_timezone , $client_finish_work_hour);


//staff display
$work_start = ConvertTime2($client_timezone,  $staff_timezone , $client_start_work_hour);
$staff_start_work_hour_str = ConvertTime($client_timezone,  $staff_timezone , $client_start_work_hour);
$work_finish = ConvertTime2($client_timezone,  $staff_timezone , $client_finish_work_hour);
$staff_finish_work_hour_str = ConvertTime($client_timezone,  $staff_timezone , $client_finish_work_hour);



//echo sprintf('Client side => %s %s<br>', $client_finish_work_hour, $client_finish_work_hour_str);
//echo sprintf('Staff side => %s %s %s %s<br>', $work_start, $staff_start_work_hour_str, $work_finish, $staff_finish_work_hour_str);

$smarty->assign('client_finish_work_hour',$client_finish_work_hour);
$smarty->assign('client_finish_work_hour_str',$client_finish_work_hour_str);
$smarty->assign('work_start',$work_start);
$smarty->assign('staff_start_work_hour_str',$staff_start_work_hour_str);
$smarty->assign('work_finish',$work_finish);
$smarty->assign('staff_finish_work_hour_str',$staff_finish_work_hour_str);
$smarty->display('configure_working_hours.tpl');
?>