<?php

putenv("TZ=Australia/Sydney");

session_start();

$l_id = @$_GET["id"];

if(!isset($l_id))
{
	$l_id = $_SESSION['l_id']; 
	if(!isset($l_id))
	{
		$l_id = $_SESSION['admin_id'];
	}
}

if(@$_GET["back_link"] == 2)

{

	$_SESSION['back_link'] = "../apply_action2.php?id=".$_SESSION['l_id'];

}

if(@$_GET["back_link"] == 1)

{

	$_SESSION['back_link'] = "../apply_action.php?id=".$_SESSION['l_id'];

}

if(!isset($_SESSION['back_link']))

{

	$_SESSION['back_link'] = "../apply_action.php?id=".$_SESSION['l_id'];

}









if(($_SESSION['agent_no'] == "" || $_SESSION['agent_no'] == NULL) || ($_SESSION['admin_id'] == "" || $_SESSION['admin_id'] == NULL))
{

?>

	<script language="javascript">

		alert("Your session is expired.");

		window.location="../index.php";

	</script>

<?php	

}



require_once("../conf/connect.php");

include("style/button_style.php");

include("style/text_style.php");

//session_start();

$db=connsql();



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



$yearID = @$_GET["yearID"];

$monthID = @$_GET["monthID"];

$dayID = @$_GET["dayID"];

$calendar_type = @$_GET["calendar_type"];

$user_id = $_SESSION['agent_no'];



if(@isset($yearID)) $_SESSION['yearID'] = $yearID;

if(@isset($monthID)) $_SESSION['monthID'] = $monthID;

if(@isset($dayID)) $_SESSION['dayID'] = $dayID;

$date_selected = $yearID."-".$monthID."-".$dayID;

if(@isset($calendar_type)) $_SESSION['calendar_type'] = $calendar_type;



if(@$_GET["action"] == "logout")

{

	session_unset();

	session_destroy();

	header("location:index.php");

}



if(!isset($dayID) && !isset($monthID) && isset($yearID)) 

{

	$monthID = date("m",time());

	$dayID = date("d",time());

	echo '

			<script language="javascript">

				window.location="?id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'";

			</script>

		';

}



if(!isset($dayID) && isset($yearID)) 

{

	$dayID = date("d",time());

	echo '

			<script language="javascript">

				window.location="?id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'";

			</script>

		';

}



if(!isset($monthID) && isset($yearID)) 

{

	$monthID = date("m",time());

	echo '

			<script language="javascript">

				window.location="?id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'";

			</script>

		';

}



if(!isset($dayID) && !isset($yearID)) 

{

	$yearID = date("Y",time());

	$monthID = date("m",time());

	$dayID = date("d",time());

	echo '

			<script language="javascript">

				window.location="?id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'";

			</script>

		';

}



//NEW APPOINTMENT

if(@isset($_POST["new"]))

{

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

	$leads_option = @$_POST["leads_option"];

	$all_day = @$_POST["all_day"];

	$any = @$_POST["any"];

	$description = $_POST["description"];

	$start_minute = $_POST["start_minute"];

	$start_hour = $_POST["start_hour"];

	$end_hour = $_POST["end_hour"];

	$end_minute = $_POST["end_minute"];		

			

	if(@isset($type_option)) $type = $_POST["type"];

	else $type = "";

	

	//if(@isset($leads_option)) $leads_id = $_POST["leads"];

	//else $leads_id = "";

	$leads_id = $_GET["id"];

	

	if(@isset($any)) 

	{

		$any = "yes";

	}

	else

	{

		$any = "no";

	}

		

	if(@isset($all_day)) 

	{

		$all_day = "yes";

	}

	else

	{

		$all_day = "no";

	}

	

	$counter = 0;

	$error_message = "";

	$c = mysql_query("SELECT id FROM tb_appointment WHERE user_id='$user_id' AND date_start='$date_start' AND start_hour = '$start_hour' AND start_minute >= '$start_minute' AND is_allday = 'no' LIMIT 1");		

	$num_result = mysql_num_rows($c);

	if($num_result > 0) $counter = 1;

	if($start_month == $monthID && $start_day == $dayID && $start_year == $yearID)

	{

		$c = mysql_query("SELECT id FROM tb_appointment WHERE user_id='$user_id' AND date_start='$date_start' AND start_hour = '$start_hour' AND end_hour >= '$start_hour' AND end_minute >= '$start_minute' AND is_allday = 'no' AND is_any = 'no' LIMIT 1");

		if($num_result > 0) $counter = 1;

	}	

	

	if($counter == "")

	{

		$error_message = "";

		mysql_query("INSERT INTO tb_appointment(user_id, leads_id, date_start, date_end, start_month, end_month, start_day, end_day, start_year, end_year, start_hour, start_minute, end_hour, end_minute, subject, location, description, appointment_type, is_allday, is_any, status, date_added) VALUES('$user_id', '$leads_id', '$date_start', '$date_end', '$start_month', '$end_month', '$start_day', '$end_day', '$start_year', '$end_year', '$start_hour', '$start_minute', '$end_hour', '$end_minute', '$subject', '$location', '$description', '$type', '$all_day', '$any', '$status', '$date_added')");					
		$c = mysql_query("SELECT id FROM tb_appointment WHERE user_id='$user_id' AND leads_id='$leads_id' AND date_start='$date_start' AND start_hour='$start_hour' AND start_minute='$start_minute' AND date_added='$date_added' LIMIT 1");		
		$appointment_id = @mysql_result($c,0,"id");
		$angent_id = $_SESSION['agent_no'];
		$type = "New Schedule Added";
		$status = "Active";
		$date_added = date("Ymd");
		mysql_query("INSERT INTO tb_calendar_actions(appointment_id, angent_id, type, status, date_added) VALUES('$appointment_id', '$angent_id', '$type', '$status', '$date_added')");					

	}

	else

	{

		$error_message = 'exist';

	}

	

	$yearID = @$_GET["yearID"];

	$monthID = @$_GET["monthID"];

	$dayID = @$_GET["dayID"];	

	if($error_message == "")

	{

		echo '

				<script language="javascript">

					window.location="?id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'";

				</script>

			';

	}	

	else

	{

		echo '

				<script language="javascript">

					window.location="?id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'";

				</script>

			';

	}	

}

//NEW APPOINTMENT











//CANCEL APPOINTMENT

if(@isset($_GET["delete_confirmed"]))

{

	$id = $_GET["appointment_cancel"];

	mysql_query("DELETE FROM tb_appointment WHERE id='$id'");
		$appointment_id = $id;
		$angent_id = $_SESSION['agent_no'];
		$type = "This schedule has been cancelled";
		$status = "Active";
		$date_added = date("Ymd");
		mysql_query("INSERT INTO tb_calendar_actions(appointment_id, angent_id, type, status, date_added) VALUES('$appointment_id', '$angent_id', '$type', '$status', '$date_added')");					

		echo '

				<script language="javascript">

					window.location="?id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'";

				</script>

			';

}

//CANCEL APPOINTMENT











//UPDATE APPOINTMENT

if(@isset($_POST["a"]))

{

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

	$leads_option = @$_POST["leads_option"];	

	$all_day = @$_POST["all_day"];

	$any = @$_POST["any"];

	$selected_record = @$_POST["selected_record"];

	$start_minute = @$_POST["start_minute"];

	$start_hour = @$_POST["start_hour"];

	$end_hour = @$_POST["end_hour"];

	$end_minute = @$_POST["end_minute"];			

	

	if(@isset($any)) 

	{

		$any = "yes";

	}

	else

	{

		$any = "no";

	}

		

	if(@isset($type_option)) $type = @$_POST["type"];

	else $type = "";

	

	if(@isset($leads_option)) 

	$leads_id = $_POST["leads"];

	else $leads_id = "";

		

	if(@isset($all_day)) 

	{

		$all_day = "yes";

	}

	else

	{

		$all_day = "no";

	}

	$description = $_POST["description"];

	mysql_query("UPDATE tb_appointment SET date_start='$date_start', date_end='$date_end', start_hour='$start_hour', start_minute='$start_minute', end_hour='$end_hour', end_minute='$end_minute', subject='$subject', location='$location', description='$description', appointment_type='$type', is_allday='$all_day', is_any='$any' WHERE id='$selected_record'");			

		$appointment_id = $selected_record;
		$angent_id = $_SESSION['agent_no'];
		$type = "This schedule has been changed";
		$status = "Active";
		$date_added = date("Ymd");
		mysql_query("INSERT INTO tb_calendar_actions(appointment_id, angent_id, type, status, date_added) VALUES('$appointment_id', '$angent_id', '$type', '$status', '$date_added')");					



	$yearID = @$_GET["yearID"];

	$monthID = @$_GET["monthID"];

	$dayID = @$_GET["dayID"];	

	echo '

			<script language="javascript">

				window.location="?id='.$l_id.'&calendar_type='.$calendar_type.'&yearID='.$yearID.'&monthID='.$monthID.'&dayID='.$dayID.'";

			</script>

		';

}

//UPDATE APPOINTMENT





$title = "Date Selected: ".$dayID."-".$monthID."-".$yearID;





?>





<HTML>

<HEAD>

<TITLE>Calendar</TITLE>

<link rel=stylesheet type=text/css href="css/font.css">

<link rel=stylesheet type=text/css href="../menu.css">

</HEAD>



<script type="text/javascript" src="js/functions.js"></script>

<script type="text/javascript" src="ajax/get_schedule.js"></script>

<script type="text/javascript" src="ajax/get_time.js"></script>

<script type="text/javascript"></script>





<BODY BGCOLOR=#EEECEC LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>

<? include 'header.php';?>
<? include 'admin_header_menu.php';?>

<center>















<table width="100%" border="0" bgcolor="#3E97CF" cellpadding="10" cellspacing="0">

	<tr>

		<td width="24%" align="left" valign="top" bgcolor="#3E97CF" colspan="3"> <font color="#FFFFFF"><strong>

		

		

		<div id="timer">

		<?php 

			putenv("TZ=Australia/Sydney");

			$time_offset ="0"; // Change this to your time zone

			$time_a = ($time_offset * 120);

			$time = date("h:i:s",time() + $time_a);

			echo 'Current date/time: '.date("l, F d, Y" ,time()).' / '.$time;		

		?></div>

		

		

		</strong></font></td>

	</tr>

	<tr>

		<td width="100%" align="left" valign="top" bgcolor="#FFFFFF" rowspan="2">



		

			<table width="100%" border="0" bgcolor="#666666" cellpadding="10" cellspacing="1">

				<tr>

					<td width="5%" align="left" valign="top" bgcolor="#3E97CF"><strong><font color="#ffffff">Time</font></strong></td>

					<td width="24%" align="left" valign="top" bgcolor="#3E97CF"><table width="100%"><tr><td><strong><font color="#ffffff">Appointment/Event Details</font></strong></td><td align="right"><strong><font color="#ffffff"><strong><?php echo $title; ?></strong></font></strong></td></tr></table></td>

				</tr>

				

				<?php				

					if(@$_GET["error_message"] == "exist")

					{					

				?>				



				<tr>

					<td width="24%" align="left" valign="top" bgcolor="#ffffff" colspan="2">

						<table width="100%" border="0" bgcolor="#ffffff" cellpadding="5" cellspacing="1">

							<tr>

								<td><img src="iconss/warning.gif"></td>

								<td width="100%"><font color="#FF0000"><strong>

									<strong><font color='#FF0000'>Conflicts with another appointment on your Calendar</font></strong>

								</strong></font></td>

							</tr>					

						</table>	

					</td>

				</tr>	

				<?php } ?>				

				

				

				<?php				

					if(@isset($_GET["appointment_cancel"]))

					{

						$id = $_GET["appointment_cancel"];

				?>				

				<tr>

					<td width="24%" align="left" valign="top" bgcolor="#ffffff" colspan="2">

						<table width="100%" border="0" bgcolor="#ffffff" cellpadding="5" cellspacing="1">

							<tr>

								<td><img src="iconss/warning.gif"></td>

								<td><font color="#FF0000"><strong>Click&nbsp;yes&nbsp;to&nbsp;confirm&nbsp;deletion.</strong></font></td>

								<td width="100%">

									<input type="button" value="Yes" name="delete" <?php echo $button_style; ?> onClick="javascript: window.location='index.php?<?php echo "appointment_cancel=".$id."&delete_confirmed=yes&yearID=".$yearID."&monthID=".$monthID."&dayID=".$dayID; ?>'">

									<input type="button" value="Cancel" name="cancel" <?php echo $button_style; ?> onClick="javascript: window.location='index.php?<?php echo "yearID=".$yearID."&monthID=".$monthID."&dayID=".$dayID; ?>'">

								</td>

							</tr>					

						</table>	

					</td>

				</tr>	

				<?php } ?>

				
				
				
				
				
				
				
				<tr>

					<td width="5%" align="left" valign="top" bgcolor="#FFFFFF"><strong><font color="#000000">Actions</font></strong></td>

					<td width="24%" align="left" valign="top" bgcolor="#D9D902">

										<?php
											$a_id = $_SESSION['agent_no'];	
											$c = mysql_query("SELECT id FROM tb_calendar_actions WHERE angent_id='$a_id'");	
			
											$num_result = @mysql_num_rows($c);
			
										?>
			
										<table width="100%">							
						
											<?php if($num_result > 0) { ?>
			
											<tr >
			
												<td colspan=3 valign="top" >
			
														<iframe id="frame" name="frame" width="100%" height="100" src="actions_list.php" frameborder="0">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
			
												</td>	
			
											</tr>
											<?php } ?>
										</table>

					</td>

				</tr>				
				
				
				
				
				
				
				
				

								

				<tr>

					<td width="5%" align="left" valign="top" bgcolor="#FFFFFF"><strong><font color="#000000">All Day</font></strong></td>

					<td width="24%" align="left" valign="top" bgcolor="#D9D902">

						<table width="100%" border="0" bgcolor="#CCCCCC" cellpadding="5" cellspacing="1">



				

<?php

					//data

					$total_appointments = 0;

					$sub_total_appointment = 1;

					$get_time = mysql_query("SELECT id, start_hour, end_hour, subject FROM tb_appointment WHERE user_id='$user_id' AND date_start='$date_selected' AND is_allday='yes' ORDER BY start_hour ASC");

					while ($row = @mysql_fetch_assoc($get_time)) 

					{

						

?>				

							<tr>

								<td width="100%" align="left" valign="top" bgcolor="#ffffff" onClick="javascript: document.getElementById('update_selected_record_id').value=<?php echo $row["id"]; ?>; showSubMenu('used_time'); field='update_subject_id'; id_selected='<?php echo $row["id"]; ?>'; mouse_state='off'; " onmouseover="javascript:this.style.background='#F4F2F2';" onmouseout="javascript:this.style.background='#FFFFFF';"><?php echo $row["subject"]; ?></td>

							</tr>

<?php

				}

				//data	

?>				

						</table>

					</td>

				</tr>					

						

						

						

<?php

					$type = "AM";

					$display_hr = 0;

					for($hrs = 1; $hrs <= 24; $hrs++)

					{

						$display_hr++;

						//table setup

						if($hrs == 13)

						{

							$display_hr = 1;

							$type = "PM";

						}

						if($hrs == 12)

						{

							$type = "PM";

						}						


						if($hrs == 24)

						{

							$type = "AM";

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

					<td width="5%" align="center" bgcolor="#FFFFFF" valign="top">

						<table width="100%">

							<tr>

								<td valign="top">

									<strong><font size="2">

										<?php echo $display_hr; ?>

									</font></strong>

								</td>

								<td align="center" valign="top">00&nbsp;<font size="1"><?php echo $type; ?></font></td>

							</tr>

						</table>

					</td>

<?php	

						$total_appointments = 0;

						$selected_time = 0;

						$sub_hrs = $hrs + 1;

						$get_time = mysql_query("SELECT id, start_hour, end_hour, start_minute, end_minute, subject, description FROM tb_appointment WHERE user_id='$user_id' AND date_start='$date_selected' AND is_allday='no' AND start_hour >= '$hrs' AND start_hour < '$sub_hrs' ORDER BY start_minute ASC");

						while ($row = @mysql_fetch_assoc($get_time)) 

						{

							$id = $row["id"];

							$start_hour = $row["start_hour"];

							$start_minute = $row["start_minute"];

							$end_hour = $row["end_hour"];

							$end_minute = $row["end_minute"];

							$subject = $row["subject"];
							
							$description = $row["description"];

							if($total_appointments < 1)

							{

?>

								<td width="100%" align="left" valign="top" bgcolor="<?php echo $bgcolor; ?>" onmouseover="javascript:this.style.background='#FFFFFF'; " onmouseout="javascript:this.style.background='<?php echo $bgcolor; ?>';">

									<table width="100%" border="0" bgcolor="#CCCCCC" cellpadding="5" cellspacing="1">	

<?php						

							} 

?>									

										<tr>

											<td width="100%" align="left" valign="top" bgcolor="#ffffff" onClick="javascript: mouse_state='on'; document.getElementById('update_selected_record_id').value=<?php echo $id; ?>; showSubMenu('used_time'); field='update_subject_id'; id_selected='<?php echo $id; ?>'; document.getElementById('end_minute_id').value=id_selected; date_selected='<?php echo $date_selected; ?>'; m_selected=<?php echo $selected_time; ?>; hr_selected=<?php echo $hrs; ?>; mouse_state='off'; " onmouseover="javascript:this.style.background='#F4F2F2'; showNotes('notes_<?php echo $id; ?>'); " onmouseout="javascript:this.style.background='#FFFFFF';"><font size="1"><strong><?php echo $display_hr.":".$row["start_minute"]; ?></strong><?php echo $type; ?></font>&nbsp;-&nbsp;<?php echo $subject; ?></td>										

										</tr>
										<tr>
											<td><div id="notes_<?php echo $id; ?>" STYLE='POSITION: Absolute; VISIBILITY: HIDDEN'><table bgcolor="#FFFFCC" width="300" cellpadding="5" cellspacing="5"><tr><td align="left"><font size="1"><strong>NOTES</strong></font></td><td align="right"><font size="1"><i>(<a href="javascript: hideNotes(); ">Close</a>)</i></font></td></tr><tr><td colspan="2"><font size="1"><?php echo $description; ?></font></td></tr></table></div></td>
										</tr>										

<?php

							$total_appointments++;

						}

						if($total_appointments >= 1) 

						{ 

?>										

									</table>	

									<br>

									&nbsp;<b><a href="#" onClick="javascript: mouse_state='on'; date_selected='<?php echo $date_selected; ?>'; m_selected=<?php echo $selected_time; ?>; hr_selected=<?php echo $hrs; ?>; showSubMenu('available_time');">Menu</a></b>

								</td>	

						

<?php						

						}

						if($total_appointments < 1)

						{

?>

								<td width="100%" align="left" valign="top" bgcolor="<?php echo $bgcolor; ?>" onClick="javascript: mouse_state='on'; date_selected='<?php echo $date_selected; ?>'; m_selected=<?php echo $selected_time; ?>; hr_selected=<?php echo $hrs; ?>; showSubMenu('available_time');" onmouseover="javascript:this.style.background='#FFFFFF';" onmouseout="javascript:this.style.background='<?php echo $bgcolor; ?>';">&nbsp;</td>

<?php 

						}

?>

						</tr>



<?php 

					} 

					dieSql($db);	

?>

				</tr>

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











<DIV ID='available_time' STYLE='POSITION: Absolute; LEFT: 336px; TOP: 24px; width: 150px; VISIBILITY: HIDDEN' onMouseOver="javascript: mouse_state='off';"> 

<table bgcolor=#000000 border=0 cellpadding=0 cellspacing=1 width="100%">

	<tr>

		<td>

			<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#fefefe>

				<tr>

					<td onClick="javascript: appointment_new();" bgcolor=#FFFFFF onmouseover="javascript:this.style.background='#3E97CF';" onmouseout="javascript:this.style.background='#FFFFFF'; ">

						<a href="#">Add New Appointment</a>

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





<DIV ID='used_time' STYLE='POSITION: Absolute; LEFT: 336px; TOP: 24px; width: 150px; VISIBILITY: HIDDEN' onMouseOver="javascript: mouse_state='off';"> 

<table bgcolor=#000000 border=0 cellpadding=0 cellspacing=1 width="100%">

	<tr>

		<td>

			<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#fefefe>

				<tr>

					<td onClick="javascript: timer_stat=0; appointment_update();" bgcolor=#FFFFFF onmouseover="javascript:this.style.background='#3E97CF';" onmouseout="javascript:this.style.background='#FFFFFF'; ">

						<a href="#">Open</a>

					</td>

				</tr>

				<tr>

					<td onClick="javascript: window.location='index.php?yearID=<?php echo $yearID; ?>&monthID=<?php echo $monthID; ?>&dayID=<?php echo $dayID; ?>&appointment_cancel='+id_selected;" bgcolor=#FFFFFF onmouseover="javascript:this.style.background='#3E97CF';" onmouseout="javascript:this.style.background='#FFFFFF'; ">

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







<!--<DIV onClick="javascript: mouse_state='off';" ID='new_appointment' STYLE='POSITION: Absolute; LEFT: 10px; TOP: 24px; width: 150px; VISIBILITY: HIDDEN'> -->

<DIV ID='new_appointment' STYLE='POSITION: Absolute; LEFT: 10px; TOP: 24px; width: 150px; VISIBILITY: HIDDEN'> 

<?php include("new_appointment.php"); ?>

</DIV>



<!--<DIV ID='update_appointment' onClick="javascript: mouse_state='off';" STYLE='POSITION: Absolute; LEFT: 10px; TOP: 24px; width: 150px; VISIBILITY: HIDDEN'> -->

<DIV ID='update_appointment' STYLE='POSITION: Absolute; LEFT: 10px; TOP: 24px; width: 150px; VISIBILITY: HIDDEN'>

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

		}	

	}

	document.body.onmousemove = get_mouse_pointer_coordinates;

</script>

</BODY>

<? include 'footer.php';?>

</HTML>