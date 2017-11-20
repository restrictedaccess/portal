<?php
require_once("../libraries/connect.php");
session_start();
$db=connsql();
$id_selected = @$_GET["id"];
$field = @$_GET["field"];
$c = mysql_query("SELECT * FROM tb_appointment WHERE id='$id_selected' LIMIT 1");
switch($field)
{
	case "update_subject_id":
		$output = @mysql_result($c,0,"subject");
		break;
	case "update_location_id":
		$output = @mysql_result($c,0,"location");
		break;
	case "update_description_id":
		$output = @mysql_result($c,0,"description");
		break;
	case "update_start_month_id":
		$output = @mysql_result($c,0,"start_month");
		break;
	case "update_start_day_id":
		$output = @mysql_result($c,0,"start_day");
		break;					
	case "update_start_year_id":
		$output = @mysql_result($c,0,"start_year");
		break;						
	case "update_end_month_id":
		$output = @mysql_result($c,0,"end_month");
		break;
	case "update_end_day_id":
		$output = @mysql_result($c,0,"end_day");
		break;
	case "update_end_year_id":
		$output = @mysql_result($c,0,"end_year");
		break;			
	case "update_end_hour_id":
		$output = @mysql_result($c,0,"end_hour");
		break;
	case "update_end_minute_id":
		$output = @mysql_result($c,0,"end_minute");
		break;			
	case "update_start_hour_id":
		$output = @mysql_result($c,0,"start_hour");
		break;
	case "update_start_minute_id":
		$output = @mysql_result($c,0,"start_minute");
		break;	
	case "update_all_day_id":
		$output = @mysql_result($c,0,"is_allday");
		break;					
	case "update_type_id":
		$output = @mysql_result($c,0,"appointment_type");
		break;																													
}
if(@!isset($output) || $output == "" || $output == NULL || $output == " ")
	echo "-none-";
else
	echo $output;
dieSql($db);	
?>