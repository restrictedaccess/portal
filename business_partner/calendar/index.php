<?php
		function get_string_day($day)
		{
			switch($day)
			{
				case "01":
					$r = "Jan";
					break;
				case "02":					
					$r = "Feb";
					break;
				case "03":					
					$r = "Mar";
					break;
				case "04":										
					$r = "Apr";
					break;
				case "05":										
					$r = "May";
					break;
				case "06":
					$r = "Jun";
					break;
				case "07":										
					$r = "Jul";
					break;
				case "08":										
					$r = "Aug";
					break;
				case "09":										
					$r = "Sep";
					break;
				case "10":										
					$r = "Oct";
					break;
				case "11":										
					$r = "Nov";
					break;
				case "12":										
					$r = "Dec";
					break;
				default:
					$r = "Month";	
					break;
			}
			return $r;
		}
		
		
require_once("libraries/connect.php");
include("style/button_style.php");
include("style/text_style.php");
session_start();
$db=connsql();

$yearID = @$_GET["yearID"];
$monthID = @$_GET["monthID"];
$dayID = @$_GET["dayID"];
$calendar_type = @$_GET["calendar_type"];

$_SESSION["user_id"] = 1;
$_SESSION["leads_id"] = 2;
if(@isset($yearID)) $_SESSION['yearID'] = $yearID;
if(@isset($monthID)) $_SESSION['monthID'] = $monthID;
if(@isset($dayID)) $_SESSION['dayID'] = $dayID;
$date_selected = $yearID."-".$monthID."-".$dayID;
if(@isset($calendar_type)) $_SESSION['calendar_type'] = $calendar_type;
if(isset($_SESSION['yearID'])) $title = "Date Selected: ".$dayID."-".$monthID."-".$yearID;
else
{
	$a = date("Ymd");
	$b = date("Ymd",time() + (1 * 24 * 60 * 60));
	$title = "Today (".date("M d, Y").")";
}





//NEW APPOINTMENT
if(@isset($_POST["new"]))
{
	$user_id = $_SESSION["user_id"];
	$leads_id = $_SESSION["leads_id"];
	$start_month = $_POST["start_month"];
	$start_day = $_POST["start_day"];
	$start_year = $_POST["start_year"];
	$end_month = $_POST["end_month"];
	$end_day = $_POST["end_day"];
	$end_year = $_POST["end_year"];	
	$date_start = $start_year."-".$start_month."-".$start_day;
	$date_end = $end_year."-".$end_month."-".$end_day;
	$status = "active";	
	$date_added = date("Ymd");
	$subject = $_POST["subject"];
	$location = $_POST["location"];
	$type_option = @$_POST["type_option"];
	$all_day = @$_POST["all_day"];
	
	if(@isset($type_option)) $type = $_POST["type"];
	else $type = "";
	
	if(@isset($all_day)) 
	{
		$all_day = "yes";
		$start_minute = 0;
		$start_hour = 1;
		$end_hour = 24;
		$end_minute = 0;
	}
	else
	{
		$all_day = "no";
		$start_minute = $_POST["start_minute"];
		$start_hour = $_POST["start_hour"];
		$end_hour = $_POST["end_hour"];
		$end_minute = $_POST["end_minute"];		
	}
	
	$description = $_POST["description"];
	mysql_query("INSERT INTO tb_appointment(user_id, leads_id, date_start, date_end, start_month, end_month, start_day, end_day, start_year, end_year, start_hour, start_minute, end_hour, end_minute, subject, location, description, appointment_type, is_allday, status, date_added) VALUES('$user_id', '$leads_id', '$date_start', '$date_end', '$start_month', '$end_month', '$start_day', '$end_day', '$start_year', '$end_year', '$start_hour', '$start_minute', '$end_hour', '$end_minute', '$subject', '$location', '$description', '$type', '$all_day', '$status', '$date_added')");			
	$yearID = @$_GET["yearID"];
	$monthID = @$_GET["monthID"];
	$dayID = @$_GET["dayID"];	
	header("location: index.php?yearID=".$yearID."&monthID=".$monthID."&dayID=".$dayID);
}
//NEW APPOINTMENT




//UPDATE APPOINTMENT
if(@$_POST["a"] == "Save")
{
	$user_id = @$_SESSION["user_id"];
	$start_month = @$_POST["start_month"];
	$start_day = @$_POST["start_day"];
	$start_year = @$_POST["start_year"];
	$end_month = @$_POST["end_month"];
	$end_day = @$_POST["end_day"];
	$end_year = @$_POST["end_year"];	
	$date_start = $start_year."-".$start_month."-".$start_day;
	$date_end = $end_year."-".$end_month."-".$end_day;
	$status = "active";	
	$date_added = date("Ymd");
	$subject = @$_POST["subject"];
	$location = @$_POST["location"];
	$type_option = @$_POST["type_option"];
	$all_day = @$_POST["all_day"];
	$selected_record = @$_POST["selected_record"];
	if(@isset($type_option)) $type = @$_POST["type"];
	else $type = "";
	
	if(@isset($all_day)) 
	{
		$all_day = "yes";
		$start_minute = 0;
		$start_hour = 1;
		$end_hour = 24;
		$end_minute = 0;
	}
	else
	{
		$all_day = "no";
		$start_minute = @$_POST["start_minute"];
		$start_hour = @$_POST["start_hour"];
		$end_hour = @$_POST["end_hour"];
		$end_minute = @$_POST["end_minute"];		
	}
	$description = $_POST["description"];
	mysql_query("UPDATE tb_appointment SET date_start='$date_start', date_end='$date_end', start_hour='$start_hour', start_minute='$start_minute', end_hour='$end_hour', end_minute='$end_minute', subject='$subject', location='$location', description='$description', appointment_type='$type', is_allday='$all_day' WHERE id='$selected_record'");			
	$yearID = @$_GET["yearID"];
	$monthID = @$_GET["monthID"];
	$dayID = @$_GET["dayID"];	
	header("location: index.php?yearID=".$yearID."&monthID=".$monthID."&dayID=".$dayID);
}
//UPDATE APPOINTMENT


?>


<HTML>
<HEAD>
<TITLE>Calendar</TITLE>
<link rel=stylesheet type=text/css href="css/font.css">
</HEAD>

<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="ajax/get_schedule.js"></script>

<script type="text/javascript"></script>

<BODY BGCOLOR=#EEECEC LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<center>
<table width="100%" border="0" bgcolor="#3E97CF" cellpadding="10" cellspacing="0">
	<tr>
		<td width="24%" align="left" valign="top" bgcolor="#3E97CF" colspan="3"> <font color="#ffffff"><strong><?php echo $title; ?></strong></font></td>
	</tr>
	<tr>
		<td width="100%" align="left" valign="top" bgcolor="#FFFFFF" rowspan="2">

		
			<table width="100%" border="0" bgcolor="#666666" cellpadding="10" cellspacing="1">
				<tr>
					<td width="5%" align="left" valign="top" bgcolor="#3E97CF"><strong><font color="#ffffff">Time</font></strong></td>
					<td width="24%" align="left" valign="top" bgcolor="#3E97CF"><strong><font color="#ffffff">Description</font></strong></td>
				</tr>
				<tr>
					<td width="5%" align="left" valign="top" bgcolor="#FFFFFF"><strong><font color="#000000">All Day</font></strong></td>
					<td width="24%" align="left" valign="top" bgcolor="#ffffff">
						<table width="100%" border="0" bgcolor="#CCCCCC" cellpadding="5" cellspacing="1">

				
<?php
					//data
					$total_appointments = 0;
					$sub_total_appointment = 1;
					$get_time = mysql_query("SELECT id, start_hour, end_hour, subject FROM tb_appointment WHERE is_allday='yes' OR date_start=='$date_selected' ORDER BY start_hour ASC");
					while ($row = @mysql_fetch_assoc($get_time)) 
					{
						
?>				
							<tr>
								<td width="100%" align="left" valign="top" bgcolor="#ffffff" onClick="javascript: document.getElementById('update_selected_record_id').value=<?php echo $row["id"]; ?>; showSubMenu('used_time'); field='update_subject_id'; id_selected='<?php echo $row["id"]; ?>'; mouse_state='off'; "><?php echo $row["subject"]; ?></td>
							</tr>
<?php
				}
				//data	
?>				
						</table>
					</td>
				</tr>					
						
						
						
						
						
<?php
					//data
					$total_appointments = 0;
					$sub_total_appointment = 1;
					$get_time = mysql_query("SELECT id, start_hour, end_hour, start_minute, end_minute, subject FROM tb_appointment WHERE date_start='$date_selected' ORDER BY start_hour ASC");
					while ($row = @mysql_fetch_assoc($get_time)) 
					{
						$total_appointments++;
						$id[$total_appointments] = $row["id"];
						//$date_start[$total_appointments] = $row["date_start"];
						//$date_end[$total_appointments] = $row["date_end"];
						//$userid[$total_appointments] = $row["user_id"];
						$start_hour[$total_appointments] = $row["start_hour"];
						$start_minute[$total_appointments] = $row["start_minute"];
						$end_hour[$total_appointments] = $row["end_hour"];
						$end_minute[$total_appointments] = $row["end_minute"];
						$subject[$total_appointments] = $row["subject"];
						//$description[$total_appointments] = $row["description"];
						//$appointment_type[$total_appointments] = $row["appointment_type"];
						//$status[$total_appointments] = $row["status"];
					}
					//data					
					
					
					
					$rows = 0; //compare
					$rows_def = 1; //compare
					$time_start = 0;
					$time_end = 0;	
					$tota_hrs = 0;
					$counter = 0;					
					$type = "AM";
					for($hrs = 1; $hrs <= 24; $hrs++)
					{
						$counter++;
						
						
						//execute data
						if($hrs == @$start_hour[$sub_total_appointment])
						{
							if($rows == 0 || $rows < 0)
							{
								$total_hrs = ($end_hour[$sub_total_appointment] - $start_hour[$sub_total_appointment]) * 2;
								
								if($start_minute[$sub_total_appointment] > 29)
								{
									$start_hour[$sub_total_appointment] = $start_hour[$sub_total_appointment];
								}
								else
								{
									$start_hour[$sub_total_appointment] = $start_hour[$sub_total_appointment];
								}
									
								if($end_minute[$sub_total_appointment] > 29) 
								{
									$total_hrs = $total_hrs + 1;
									$rows = $total_hrs;
									$rows_def = $total_hrs;
								}
								else
								{
									$total_hrs = $total_hrs;
									$rows = $total_hrs;
									$rows_def = $total_hrs;
								}	
								
								if($sub_total_appointment <= $total_appointments)
									$sub_total_appointment++;						

							}

						}
						//execute data
						
						
						
						//table setup
						if($hrs == 13)
						{
							$counter = 1;
							$type = "PM";
						}
						if($hrs > 7 && $hrs < 17)
						{
							$bgcolor="#FDFDB3";
						}
						else
						{
							$bgcolor="#D9D902";
						}
						//table setup
						
						
?>
				
							<tr>
								<td width="5%" valign="middle" align="center" bgcolor="#FFFFFF" rowspan="2">
									<table width="100%">
										<tr>
											<td rowspan="2">
												<strong><font size="4">
													<?php echo $counter; ?>
												</font></strong>
											</td>
											<td align="center" valign="top">00&nbsp;<font size="1"><?php echo $type; ?></font></td>
										</tr>
										<tr>
											<td align="center">&nbsp;</td>
										</tr>
									</table>
								</td>
<?php	
						if ($hrs % 2 == 0 )
							$selected_time = 0;
						else
							$selected_time = 30;
						if($rows == $rows_def)
						{ 
								$bgcolor = "#FFFFFF";
?>
								<td width="100%" align="left" valign="top" bgcolor="<?php echo $bgcolor; ?>" rowspan="<?php echo $rows; ?>" onClick="javascript: document.getElementById('update_selected_record_id').value=<?php echo $id[$sub_total_appointment - 1]; ?>; showSubMenu('used_time'); field='update_subject_id'; id_selected='<?php echo $id[$sub_total_appointment - 1]; ?>'; document.getElementById('end_minute_id').value=id_selected; date_selected='<?php echo $date_selected; ?>'; m_selected=<?php echo $selected_time; ?>; hr_selected=<?php echo $hrs; ?>; mouse_state='off'; "><?php echo $subject[$sub_total_appointment - 1]; ?></td>
<?php 
						} 
						if($rows < 1)
						{
?>
								<td width="100%" align="left" valign="top" bgcolor="<?php echo $bgcolor; ?>" onClick="javascript: get_mouse_pointer_coordinates; showSubMenu('available_time'); date_selected='<?php echo $date_selected; ?>'; m_selected=<?php echo $selected_time; ?>; hr_selected=<?php echo $hrs; ?>; mouse_state='off';" onmouseover="javascript:this.style.background='#FFFFFF';" onmouseout="javascript:this.style.background='<?php echo $bgcolor; ?>';">&nbsp;</td>
<?php 
						}
?>
						</tr>
						<tr>
<?php
						if($rows == 1)
						{
?>
							<td width="100%" align="left" valign="top" bgcolor="<?php echo $bgcolor; ?>" onClick="javascript: get_mouse_pointer_coordinates; showSubMenu('available_time'); date_selected='<?php echo $date_selected; ?>'; m_selected=<?php echo $selected_time; ?>; hr_selected=<?php echo $hrs; ?>; mouse_state='off';" onmouseover="javascript:this.style.background='#FFFFFF';" onmouseout="javascript:this.style.background='<?php echo $bgcolor; ?>';">&nbsp;</td>
<?php 
						} 
						if($rows < 1)
						{ 
?>
							<td width="100%" align="left" valign="top" bgcolor="<?php echo $bgcolor; ?>" onClick="javascript: get_mouse_pointer_coordinates; showSubMenu('available_time'); date_selected='<?php echo $date_selected; ?>'; m_selected=<?php echo $selected_time; ?>; hr_selected=<?php echo $hrs; ?>; mouse_state='off';" onmouseover="javascript:this.style.background='#FFFFFF';" onmouseout="javascript:this.style.background='<?php echo $bgcolor; ?>';">&nbsp;</td>
<?php 
						} 
?>
						</tr>
<?php 
						if($rows > 0) $rows = $rows - 2;
					} 
					dieSql($db);	
?>
			</table>		

		
		</td>
		<td width="24%" align="left" valign="top" bgcolor="#F1F1F3"><font color="#000000"><strong>Calendar</strong></font>&nbsp;(view <a href="?calendar_type=m"><u>month</u></a>,&nbsp;<a href="?calendar_type=y"><u>year</u></a>)</td>
	</tr>
	<tr>
		<td width="24%" align="left" valign="top" bgcolor="#F1F1F3">
		<font color="#000000">
		<?php 
			if(@$_SESSION['calendar_type'] == "y")
				require_once("yearview.php"); 
			else
				require_once("monthview.php"); 
		?>
		</font>
		</td>
	</tr>
	<tr>
		<td width="24%" align="left" valign="top" bgcolor="#F1F1F3" colspan="4"><font color="#000000"><strong>Total Showing: <?php echo @$counter; ?> </strong></font></td>
	</tr>						
</table>



<DIV ID='available_time' STYLE='POSITION: Absolute; LEFT: 336px; TOP: 24px; width: 150px; VISIBILITY: HIDDEN'> 
<table bgcolor=#000000 border=0 cellpadding=0 cellspacing=1 width="100%">
	<tr>
		<td>
			<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#fefefe>
				<tr>
					<td bgcolor=#FFFFFF onmouseover="javascript:this.style.background='#3E97CF';" onmouseout="javascript:this.style.background='#FFFFFF'; ">
						<a href="javascript: appointment_new();">Add New Appointment</a>
					</td>
				</tr>
				<tr>
					<td bgcolor=#FFFFFF onmouseover="javascript:this.style.background='#3E97CF';" onmouseout="javascript:this.style.background='#FFFFFF'; ">
						<a href="#">Other Seetings</a>
					</td>
				</tr>	
				<tr>
					<td bgcolor=#FFFFFF>&nbsp;</td>
				</tr>							
				<tr>
					<td bgcolor=#FFFFFF align="right"><a href="javascript: hideSubMenu();"><font size="1">Close</font></a></td>
				</tr>				
			</table>
		</td>
	</tr>
</table>
</DIV>


<DIV ID='used_time' STYLE='POSITION: Absolute; LEFT: 336px; TOP: 24px; width: 150px; VISIBILITY: HIDDEN'> 
<table bgcolor=#000000 border=0 cellpadding=0 cellspacing=1 width="100%">
	<tr>
		<td>
			<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#fefefe>
				<tr>
					<td bgcolor=#FFFFFF onmouseover="javascript:this.style.background='#3E97CF';" onmouseout="javascript:this.style.background='#FFFFFF'; ">
						<a href="javascript: appointment_update(); ">Open</a>
					</td>
				</tr>
				<tr>
					<td bgcolor=#FFFFFF onmouseover="javascript:this.style.background='#3E97CF';" onmouseout="javascript:this.style.background='#FFFFFF'; ">
						<a href="#">Cancel Appointment</a>
					</td>
				</tr>	
				<tr>
					<td bgcolor=#FFFFFF>&nbsp;</td>
				</tr>							
				<tr>
					<td bgcolor=#FFFFFF align="right"><a href="javascript: hideSubMenu();"><font size="1">Close</font></a></td>
				</tr>				
			</table>
		</td>
	</tr>
</table>
</DIV>









<DIV onClick="javascript: mouse_state='off';" ID='new_appointment' STYLE='POSITION: Absolute; LEFT: 10px; TOP: 24px; width: 150px; VISIBILITY: HIDDEN'> 
<?php include("new_appointment.php"); ?>
</DIV>

<DIV ID='update_appointment' onClick="javascript: mouse_state='off';" STYLE='POSITION: Absolute; LEFT: 10px; TOP: 24px; width: 150px; VISIBILITY: HIDDEN'> 
<?php include("update_appointment.php"); ?>
</DIV>











</center>

<script type="text/javascript">
	function get_mouse_pointer_coordinates(e) 
	{
		var posx = 0;
		var posy = 0;
		if (!e) var e = window.event;
		
		if (e.pageX || e.pageY)  
		{
			posx = e.pageX;
			posy = e.pageY;
		}
		
		else if (e.clientX || e.clientY)  
		{
			posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
			posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
		}
		
		if(mouse_state == 'on')
		{
			document.getElementById('available_time').style.left=posx;
			document.getElementById('available_time').style.top=posy;
			document.getElementById('used_time').style.left=posx;
			document.getElementById('used_time').style.top=posy;
			
			document.getElementById('new_appointment').style.left=posx-20;
			document.getElementById('new_appointment').style.top=posy-20;		
			
			document.getElementById('update_appointment').style.left=posx-20;
			document.getElementById('update_appointment').style.top=posy-20;			
		}	
	}
	
	if(mouse_state == 'on')
	{
		document.body.onmousemove = get_mouse_pointer_coordinates;
	}
</script>
</BODY>
</HTML>