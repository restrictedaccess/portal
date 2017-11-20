<?php
		require_once("conf/connect.php");
		$db=connsql();

		$id_selected = @$_GET["id"];

		$c = mysql_query("SELECT * FROM tb_app_appointment WHERE id='$id_selected' LIMIT 1");
		$l_id = @mysql_result($c,0,"leads_id");
		$client_id = @mysql_result($c,0,"client_id");
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
		if($start_minute == 0) $start_minute = "00";
		
		$is_allday = @mysql_result($c,0,"is_allday");
		$is_any = @mysql_result($c,0,"is_any");
		$appointment_type = @mysql_result($c,0,"appointment_type");
		$time_zone = @mysql_result($c,0,"time_zone");
		$request_for_interview_id = @mysql_result($c,0,"request_for_interview_id");
		
		$s = mysql_query("SELECT date_interview, time, alt_date_interview, alt_time, time_zone FROM tb_request_for_interview WHERE id='$request_for_interview_id' LIMIT 1");
		$date_interview = mysql_result($s,0,"date_interview");		
		$time = mysql_result($s,0,"time");	
		$alt_date_interview = mysql_result($s,0,"alt_date_interview");	
		$alt_time = mysql_result($s,0,"alt_time");	
		$time_zone = mysql_result($s,0,"time_zone");		
		
		$l = mysql_query("SELECT fname, lname FROM personal WHERE userid='$l_id' LIMIT 1");		
		@$lname = mysql_result($l,0,"fname")." ".mysql_result($l,0,"lname");

		$get_per = mysql_query("SELECT lname, fname, email FROM leads WHERE id='$client_id' LIMIT 1");
		while ($r = @mysql_fetch_assoc($get_per)) 
		{
			@$client_full_name = $r['fname']." ".$r['lname'];
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
    <td colspan="4"><strong>CALENDAR SCHEDULE</strong></td>
  </tr>  
  <tr>
    <td colspan="4"><strong>Applicant: </strong><?php echo $lname; ?></td>
  </tr>
  <tr>
    <td colspan="4"><strong>Client: </strong><?php echo $client_full_name; ?></td>
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
    <td colspan="4"><strong>Time Zone: </strong><?php echo $time_zone; ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>  
  <tr>
    <td><strong>Start&nbsp;Time:</strong></td>
    <td><?php echo $start_day; ?>-<?php echo $start_month; ?>-<?php echo $start_year; ?>&nbsp;&nbsp;</td>
    <td><?php echo $start_hour; ?>-<?php echo $start_minute; ?><?php if($start_hour < 13) echo "AM"; else echo "PM"; ?></td>
    <td width="100%"></td>
  </tr>
  <!--
  <tr>
    <td><strong>End&nbsp;Time:</strong></td>
    <td><?php echo $end_day; ?>-<?php echo $end_month; ?>-<?php echo $end_year; ?>&nbsp;&nbsp;</td>
    <td><?php echo $end_hour; ?>-<?php echo $end_minute; ?><?php if($end_hour < 13) echo "AM"; else echo "PM"; ?></td>
    <td width="100%"></td>
  </tr>
  -->
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>  
  <tr>
    <td colspan="4">
		<?php echo $description; ?>
	</td>
  </tr>

  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>  
    
    
  <tr>
    <td colspan="4"><strong>ASL SCHEDULE</strong></td>
  </tr>     
  <tr>
    <td>Time Zone: </td>
    <td width="100%" colspan="3"><?php echo $time_zone; ?></td>
  </tr>
  <tr>
    <td>Date/Time:</td>
    <td width="100%" colspan="3"><?php echo $date_interview; ?>&nbsp;<?php echo $time; ?></td>
  </tr>   
  <tr>
    <td>Alt&nbsp;Date/Time:</td>
    <td width="100%" colspan="3"><?php echo $alt_date_interview; ?>&nbsp;<?php echo $alt_time; ?></td>
  </tr>   
          	  

</table>
</body>