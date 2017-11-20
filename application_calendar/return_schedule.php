<?php
session_start();
include '../config.php';
include '../conf.php';
include('../conf/zend_smarty_conf.php');


//get admin timezone
	$r = mysql_query("SELECT timezone_id FROM admin WHERE admin_id='".$_SESSION['admin_id']."' LIMIT 1");
	$admin_timezone_id = mysql_result($r,0,"timezone_id");	
	
	$r = mysql_query("SELECT timezone FROM timezone_lookup WHERE id='$admin_timezone_id' LIMIT 1");
	$admin_timezone = mysql_result($r,0,"timezone");
	
	if($admin_timezone == "" || $admin_timezone == NULL) 
	{
		$admin_timezone = "Asia/Manila";
		$admin_timezone_display = "Asia/Manila";
	}		
	
	date_default_timezone_set($admin_timezone); //apply timezone
	
	switch($admin_timezone)
	{
		case "PST8PDT":
			$admin_timezone_display = "America/San Francisco";
			break;
		case "NZ":
			$admin_timezone_display = "New Zealand/Wellington";
			break;
		case "NZ-CHAT":
			$admin_timezone_display = "New Zealand/Chatham_Islands";
			break;
		default:
			$admin_timezone_display = $admin_timezone;
			break;			
	}
//ended	

$time_offset ="0"; // Change this to your time zone
$time_a = ($time_offset * 120);
$h = date("H",time() + $time_a);
$m = date("i",time() + $time_a);
$d = date("Y-m-d" ,time());
$type = date("a",time() + $time_a);

//generate ADMIN calendar schedule
$ref_date = $d." ".$h.":".$m.":00"; //date("g:i a", strtotime("13:30:30")); 
$date = new Zend_Date($ref_date, 'YYYY-MM-dd HH:mm:ss');
date_default_timezone_set($admin_timezone);
$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');

$destination_date = clone $date;
$destination_date->setTimezone($admin_timezone);
$admin_current_date_time = $destination_date;
//ended	


$user_id = $_SESSION['admin_id'];
$id = @$_GET["id"];
$method = @$_GET["method"];



//update appointment: cancel / finish
if(($id <> "" || $id <> NULL) && ($method == "cancel" || $method == "finish" || $method == "stop-showing"))
{
	mysql_query("UPDATE tb_app_appointment SET status='not active' WHERE id='$id'");
	$a = mysql_query("SELECT request_for_interview_id FROM tb_app_appointment WHERE id='$id' LIMIT 1");
	$request_for_interview_id = mysql_result($s,0,"request_for_interview_id");	
	if($method == "finish")
	{
		mysql_query("UPDATE tb_request_for_interview SET status='DONE' WHERE id='$request_for_interview_id'");
	}
	elseif($method == "cancel")
	{
		mysql_query("UPDATE tb_request_for_interview SET status='CANCELLED' WHERE id='$request_for_interview_id'");
	}
}
//ended



$table_header='<tr>
			<td align="right" valign="top">
				<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#CCCCCC>
					<tr>
						<td bgcolor=#CCCCCC colspan=2 align="right"><a href="#" onclick="javascript: document.getElementById(\'alarm\').style.visibility=\'hidden\'; document.getElementById(\'support_sound_alert\').innerHTML=\'\';"><font color=#000000><strong>Close</strong></font></a></td>
					</tr>
				</table>				
			</td>
		</tr>';
		
		
$return = "";			
$counter = 0;	
$c = mysql_query("SELECT * FROM tb_app_appointment WHERE user_id='$user_id' AND status='active'");	
while ($row = @mysql_fetch_assoc($c)) 
{
	
	//generate ASL calendar schedule
	$ref_date = $row['date_start']." ".$row['start_hour'].":".$row['start_minute'].":00";
	$date = new Zend_Date($ref_date, 'YYYY-MM-dd HH:mm:ss');
	date_default_timezone_set($row['time_zone']);
	$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
	$current_client_schedule = $date;

	$date = new Zend_date($ref_date, 'YYYY-MM-dd HH:mm:ss');
	$destination_date = clone $date;
	$destination_date->setTimezone($admin_timezone);
	$asl_converted_schedule = $destination_date;
	//ended	
	
	if($asl_converted_schedule <= $admin_current_date_time)
	{
		$return = $return.'
			<tr>
				<td>
					<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#fefefe>
						<tr>
							<td bgcolor=#FFFFFF valign="top" align="left"><strong>Admin Schedule: </strong></td>
							<td bgcolor=#FFFFFF valign="top">'.$asl_converted_schedule.'<br />'.$admin_timezone.'</td>
						</tr>
						<tr>
							<td bgcolor=#FFFFFF valign="top" align="left"><strong>Client Schedule: </strong></td>
							<td bgcolor=#FFFFFF valign="top">'.$current_client_schedule.'<br />'.$row['time_zone'].'</td>
						</tr>
						<tr>
							<td bgcolor=#FFFFFF valign="top" align="left"><strong>Subject: </strong></td>
							<td bgcolor=#FFFFFF valign="top">'.$row["subject"].'</td>
						</tr>		
						<tr>
							<td bgcolor=#FFFFFF valign="top" align="left"><strong>Online Meeting Using: </strong></td>
							<td bgcolor=#FFFFFF valign="top">'.$row["appointment_type"].'</td>
						</tr>
						<tr>
							<td bgcolor=#FFFFFF valign="top" align="left"><strong>Client: </strong></td>
							<td bgcolor=#FFFFFF valign="top">';
							
								$r = mysql_query("SELECT fname, lname FROM leads WHERE id='".$row["client_id"]."' LIMIT 1");
								$return = $return.mysql_result($r,0,"fname")." ".mysql_result($r,0,"lname");

		$return = $return.'
							</td>
						</tr>
						
						<tr>
							<td bgcolor=#FFFFFF valign="top" align="left"><strong>Candidate: </strong></td>
							<td bgcolor=#FFFFFF valign="top">';
							
								$r = mysql_query("SELECT fname, lname FROM personal WHERE userid='".$row["leads_id"]."' LIMIT 1");
								$return = $return.mysql_result($r,0,"fname")." ".mysql_result($r,0,"lname");

		$return = $return.'
							</td>
						</tr>						
						
						<tr>
							<td bgcolor=#FFFFFF align="left" colspan=2><br /><a href="javascript: APP_CALENDAR_hideAlarm('.$row['id'].',\'finish\'); "><font size="1">Finish</font></a> | <a href="javascript: APP_CALENDAR_hideAlarm('.$row['id'].',\'cancel\'); "><font size="1">Cancel</font></a> | <a href="javascript: APP_CALENDAR_hideAlarm('.$row['id'].',\'stop-showing\'); "><font size="1">Remove to Calendar</font></a></td>
						</tr>											
					</table>
				</td>
			</tr>
		';
		$counter = 1;
	}
}	

$return = $return."<EMBED SRC='/portal/media/alert.wav' hidden=true autostart=true loop=1>";
if($counter == 1) 
	echo '<table bgcolor=#CCCCCC border=0 cellpadding=0 cellspacing=1 width="100%">'.$table_header.$return.'</table>';
else
	echo "";	
?>


