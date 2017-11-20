<?php
session_start();
require_once("conf/connect.php");
putenv("TZ=Australia/Sydney");

$time_offset ="0"; // Change this to your time zone
$time_a = ($time_offset * 120);
$h = date("h",time() + $time_a);
$m = date("i",time() + $time_a);
$d = date("Y-m-d" ,time());
$type = date("a",time() + $time_a);

$user_id = $_SESSION['agent_no'];
$db=connsql();
$id = @$_GET["id"];
if($id == "" || $id == NULL)
{
	//do nothing
}
else
{
	mysql_query("UPDATE tb_appointment SET status='not active' WHERE id='$id'");
}



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
$c = mysql_query("SELECT id, subject, location, start_minute, start_hour, description FROM tb_appointment WHERE user_id='$user_id' AND date_start='$d' AND start_hour < '$h' AND status='active'");	
while ($row = @mysql_fetch_assoc($c)) 
{
					if($row["start_hour"] < 13)
					{
						$temp = "AM";
					}
					else
					{
						$temp = "PM";
					}			
					if($row["start_hour"] == 12 && $row["start_minute"] < 30)
					{
						$temp = "AM";
					}
					
					$temp_h = $row["start_hour"];			
					switch($row["start_hour"])
					{
						case 13:
							$temp_h = 1;
							break;
						case 14:
							$temp_h = 2;
							break;
						case 15:
							$temp_h = 3;
							break;
						case 16:
							$temp_h = 4;
							break;
						case 17:
							$temp_h = 5;
							break;
						case 18:
							$temp_h = 6;
							break;
						case 19:
							$temp_h = 7;
							break;
						case 20:
							$temp_h = 8;
							break;
						case 21:
							$temp_h = 9;
							break;
						case 22:
							$temp_h = 10;
							break;
						case 23:
							$temp_h = 11;
							break;
						case 24:
							$temp_h = 12;
							break;
					}							
					
	$return = $return.'
		<tr>
			<td>
				<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#fefefe>
					<tr>
						<td bgcolor=#FFFFFF valign="top" align="left"><strong>Time: </strong></td>
						<td bgcolor=#FFFFFF valign="top">'.$temp_h.':'.$row["start_minute"].$temp.'</td>
					</tr>
					<tr>
						<td bgcolor=#FFFFFF valign="top" align="left"><strong>Subject: </strong></td>
						<td bgcolor=#FFFFFF valign="top">'.$row["subject"].'</td>
					</tr>		
					<tr>
						<td bgcolor=#FFFFFF valign="top" align="left"><strong>Location: </strong></td>
						<td bgcolor=#FFFFFF valign="top">'.$row["location"].'</td>
					</tr>		
					<tr>
						<td bgcolor=#FFFFFF valign="top" align="left"><strong>Description: </strong></td>
						<td bgcolor=#FFFFFF valign="top">'.$row["description"].'</td>
					</tr>		
					<tr>
						<td bgcolor=#FFFFFF align="left" colspan=2><br /><a href="javascript: hideAlarm('.$row['id'].'); "><font size="1">Stop showing this Appointment</font></a></td>
					</tr>											
				</table>
			</td>
		</tr>
	';
	$counter = 1;
}	



	

$c = mysql_query("SELECT id, subject, location, start_minute, start_hour, description FROM tb_appointment WHERE user_id='$user_id' AND date_start='$d' AND start_minute<='$m' AND start_hour='$h' AND status='active'");	
while ($row = @mysql_fetch_assoc($c)) 
{
					if($row["start_hour"] < 13)
					{
						$temp = "AM";
					}
					else
					{
						$temp = "PM";
					}			
					if($row["start_hour"] == 12 && $row["start_minute"] < 30)
					{
						$temp = "AM";
					}
					
					
					$temp_h = $row["start_hour"];					
					switch($row["start_hour"])
					{
						case 13:
							$temp_h = 1;
							break;
						case 14:
							$temp_h = 2;
							break;
						case 15:
							$temp_h = 3;
							break;
						case 16:
							$temp_h = 4;
							break;
						case 17:
							$temp_h = 5;
							break;
						case 18:
							$temp_h = 6;
							break;
						case 19:
							$temp_h = 7;
							break;
						case 20:
							$temp_h = 8;
							break;
						case 21:
							$temp_h = 9;
							break;
						case 22:
							$temp_h = 10;
							break;
						case 23:
							$temp_h = 11;
							break;
						case 24:
							$temp_h = 12;
							break;
					}						
				
					
	$return = $return.'
		<tr>
			<td>
				<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#fefefe>
					<tr>
						<td bgcolor=#FFFFFF valign="top" align="left"><strong>Time: </strong></td>
						<td bgcolor=#FFFFFF valign="top">'.$temp_h.':'.$row["start_minute"].$temp.'</td>
					</tr>
					<tr>
						<td bgcolor=#FFFFFF valign="top" align="left"><strong>Subject: </strong></td>
						<td bgcolor=#FFFFFF valign="top">'.$row["subject"].'</td>
					</tr>		
					<tr>
						<td bgcolor=#FFFFFF valign="top" align="left"><strong>Location: </strong></td>
						<td bgcolor=#FFFFFF valign="top">'.$row["location"].'</td>
					</tr>		
					<tr>
						<td bgcolor=#FFFFFF valign="top" align="left"><strong>Description: </strong></td>
						<td bgcolor=#FFFFFF valign="top">'.$row["description"].'</td>
					</tr>		
					<tr>
						<td bgcolor=#FFFFFF align="left" colspan=2><br /><a href="javascript: hideAlarm('.$row['id'].'); "><font size="1">Stop showing this Appointment</font></a></td>
					</tr>											
				</table>
			</td>
		</tr>
		
	';
	$counter = 1;
}		


dieSql($db);	
//$return = $return."<EMBED SRC='/portal/media/alert.wav' hidden=true autostart=true loop=1>";
if($counter == 1) 
	echo '<table bgcolor=#CCCCCC border=0 cellpadding=0 cellspacing=1 width="100%">'.$table_header.$return.'</table>';
else
	echo "";	
?>


