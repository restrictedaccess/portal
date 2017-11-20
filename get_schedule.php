<?php
require_once("conf/connect.php");

	$db=connsql();

		$id_selected = @$_GET["id"];

		$c = mysql_query("SELECT * FROM tb_appointment WHERE id='$id_selected' LIMIT 1");
		$l_id = @mysql_result($c,0,"leads_id");
		$subject = @mysql_result($c,0,"subject");
		$location = @mysql_result($c,0,"location");
		$description = @mysql_result($c,0,"description");
		$start_month = @mysql_result($c,0,"start_month");
		$start_day = @mysql_result($c,0,"start_day");
		$start_year = @mysql_result($c,0,"start_year");
		$end_month = @mysql_result($c,0,"end_month");
		$end_day = @mysql_result($c,0,"end_day");
		$end_year = @mysql_result($c,0,"end_year");
		$end_hour = @mysql_result($c,0,"end_hour");
		$end_minute = @mysql_result($c,0,"end_minute");
		$start_hour = @mysql_result($c,0,"start_hour");
		$start_minute = @mysql_result($c,0,"start_minute");
		$is_allday = @mysql_result($c,0,"is_allday");
		$is_any = @mysql_result($c,0,"is_any");
		$appointment_type = @mysql_result($c,0,"appointment_type");
		
		$l = mysql_query("SELECT fname, lname FROM leads WHERE id='$l_id' LIMIT 1");		
		@$lname = mysql_result($l,0,"fname")." ".mysql_result($l,0,"lname");



													if($start_hour < 13)
													{
														$start_temp = "AM";
													}
													else
													{
														$start_temp = "PM";
																	switch($start_hour)
																	{
																		case 13:
																			$start_hour = 1;
																			break;
																		case 14:
																			$h = 2;
																			break;
																		case 15:
																			$start_hour = 3;
																			break;
																		case 16:
																			$start_hour = 4;
																			break;
																		case 17:
																			$start_hour = 5;
																			break;
																		case 18:
																			$start_hour = 6;
																			break;
																		case 19:
																			$start_hour = 7;
																			break;
																		case 20:
																			$start_hour = 8;
																			break;
																		case 21:
																			$start_hour = 9;
																			break;
																		case 22:
																			$start_hour = 10;
																			break;
																		case 23:
																			$start_hour = 11;
																			break;
																		case 24:
																			$start_hour = 12;
																			break;
																	}								
													}			
								
													if($start_hour == 12 && $start_minute < 30)
													{
														$start_temp = "AM";
													}	
													
													
													
													
													
													
													
													
													if($end_hour < 13)
													{
														$end_temp = "AM";
													}
													else
													{
														$end_temp = "PM";
																	switch($end_hour)
																	{
																		case 13:
																			$end_hour = 1;
																			break;
																		case 14:
																			$end_hour = 2;
																			break;
																		case 15:
																			$end_hour = 3;
																			break;
																		case 16:
																			$end_hour = 4;
																			break;
																		case 17:
																			$end_hour = 5;
																			break;
																		case 18:
																			$end_hour = 6;
																			break;
																		case 19:
																			$end_hour = 7;
																			break;
																		case 20:
																			$end_hour = 8;
																			break;
																		case 21:
																			$end_hour = 9;
																			break;
																		case 22:
																			$end_hour = 10;
																			break;
																		case 23:
																			$end_hour = 11;
																			break;
																		case 24:
																			$end_hour = 12;
																			break;
																	}								
													}			
								
													if($end_hour == 12 && $end_minute < 30)
													{
														$end_temp = "AM";
													}														



	dieSql($db);	
?>
<html>
<head>
	<title>Schedule</title>
	<link rel=stylesheet type=text/css href="calendar/css/font.css">
</head>
</html>
<body>
<table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td colspan="4"><strong>Lead: </strong><?php echo $lname; ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>  
  <tr>
    <td colspan="4"><strong>Subject: </strong><?php echo $subject; ?></td>
  </tr>
  <tr>
    <td colspan="4"><strong>Location: </strong><?php echo $location; ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>  
  <tr>
    <td><strong>Start&nbsp;Time:</strong></td>
    <td><?php echo $start_day; ?>-<?php echo $start_month; ?>-<?php echo $start_year; ?>&nbsp;&nbsp;</td>
    <td><?php echo $start_hour; ?>-<?php echo $start_minute; ?><?php echo $start_temp; ?></td>
    <td width="100%"></td>
  </tr>
  <tr>
    <td><strong>End&nbsp;Time:</strong></td>
    <td><?php echo $end_day; ?>-<?php echo $end_month; ?>-<?php echo $end_year; ?>&nbsp;&nbsp;</td>
    <td><?php echo $end_hour; ?>-<?php echo $end_minute; ?><?php echo $end_temp; ?></td>
    <td width="100%"></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>  
  <tr>
    <td colspan="4">
		<strong>Description:</strong> 
		<?php echo $description; ?>
	</td>
  </tr>
</table>
</body>