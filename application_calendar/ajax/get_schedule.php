<?php
require_once("../../conf/connect.php");
//session_start();
$db=connsql();
$id_selected = @$_GET["id"];
$field = @$_GET["field"];
$c = mysql_query("SELECT * FROM tb_app_appointment WHERE id='$id_selected' LIMIT 1");
$temp = 0;
switch($field)
{
	case "update_subject_id":
		$temp = 1;	
		$output = @mysql_result($c,0,"subject");
		break;
	case "update_location_id":
		$temp = 1;	
		$output = @mysql_result($c,0,"location");
		break;
	case "update_description_id":
		$temp = 1;	
		$output = @mysql_result($c,0,"description");
		break;
	case "update_start_month_id":
		$temp = 1;	
		$output = @mysql_result($c,0,"start_month");
		break;
	case "update_start_day_id":
		$temp = 1;	
		$output = @mysql_result($c,0,"start_day");
		break;					
	case "update_start_year_id":
		$temp = 1;	
		$output = @mysql_result($c,0,"start_year");
		break;						
	case "update_end_month_id":
		$temp = 1;	
		$output = @mysql_result($c,0,"end_month");
		break;
	case "update_end_day_id":
		$temp = 1;	
		$output = @mysql_result($c,0,"end_day");
		break;
	case "update_end_year_id":
		$temp = 1;	
		$output = @mysql_result($c,0,"end_year");
		break;			
	case "update_end_hour_id":
		$temp = 1;	
		$output = @mysql_result($c,0,"end_hour");
		break;
	case "update_end_minute_id":
		$temp = 1;	
		$output = @mysql_result($c,0,"end_minute");
		break;			
	case "update_start_hour_id":
		$temp = 1;	
		$output = @mysql_result($c,0,"start_hour");
		break;
	case "update_start_minute_id":
		$temp = 1;	
		$output = @mysql_result($c,0,"start_minute");
		break;	
	case "update_all_day_id":
		$temp = 1;	
		$output = @mysql_result($c,0,"is_allday");
		break;					
	case "update_any_id":
		$temp = 1;	
		$output = @mysql_result($c,0,"is_any");
		break;			
	case "update_type_id":
		$temp = 1;	
		$output = @mysql_result($c,0,"appointment_type");
		break;							
	case "update_leads_id":
		$output = mysql_result($c,0,"leads_id");
		if(isset($output))
		{
			$temp = 1;	
			$l = mysql_query("SELECT fname, lname FROM personal WHERE userid='$output' LIMIT 1");		
			@$output = mysql_result($l,0,"fname")." ".mysql_result($l,0,"lname");
		}
		break;
	case "update_client_id":
		$output = mysql_result($c,0,"client_id");
		if(isset($output))
		{
			$temp = 1;	
			$l = mysql_query("SELECT fname, lname FROM leads WHERE id='$output' LIMIT 1");		
			@$output = mysql_result($l,0,"fname")." ".mysql_result($l,0,"lname");
		}
		break;
}

	if(@!isset($output) || $output == "" || $output == NULL || $output == " ")
		echo "-none-";
	else
		echo $output;		

dieSql($db);	
?>