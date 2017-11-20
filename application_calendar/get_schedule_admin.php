<?php
		include '../config.php';
		include '../conf.php';
		include('../conf/zend_smarty_conf.php');

		$id_selected = @$_GET["id"];

		$c = mysql_query("SELECT * FROM tb_app_appointment WHERE id='$id_selected' LIMIT 1");
		$l_id = @mysql_result($c,0,"leads_id");
		$client_id = @mysql_result($c,0,"client_id");
		$subject = @mysql_result($c,0,"subject");
		$location = @mysql_result($c,0,"location");
		$description = @mysql_result($c,0,"description");
		$description = nl2br($description);
		
		if (!$location){
			$location = "online meeting via skype/rssc";
		}
		
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
		$initial_interview = @mysql_result($c,0, "initial_interview");
		$new_hire_orientation = @mysql_result($c,0, "new_hire_orientation");
		$meeting = @mysql_result($c,0, "meeting");
		$contract_signing = @mysql_result($c,0, "contract_signing");
		
		$description_applicant = @mysql_result($c,0, "description_applicant");
		$description_applicant = nl2br($description_applicant);
		if($start_minute == 0) $start_minute = "00";
		if ($end_minute == 0) $end_minute = "00";
		
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
		
		if ($meeting=="N"){
		
			$l = mysql_query("SELECT fname, lname FROM personal WHERE userid='$l_id' LIMIT 1");		
			@$lname = mysql_result($l,0,"fname")." ".mysql_result($l,0,"lname");	
		}

		$get_per = mysql_query("SELECT lname, fname, email FROM leads WHERE id='$client_id' LIMIT 1");
		while ($r = @mysql_fetch_assoc($get_per)) 
		{
			@$client_full_name = $r['fname']." ".$r['lname'];
		}
		
?>


<html>
<head>
	<title>Schedule</title>
	<link rel=stylesheet type=text/css href="../calendar/css/font.css">
</head>
</html>
<body>
<table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td colspan="4"><strong>CALENDAR SCHEDULE</strong></td>
  </tr>  
  <?php 
  if ($meeting=="N"){
  	?>
	  <tr>
	    <td colspan="4"><strong>Applicant: </strong><?php echo $lname; ?></td>
	  </tr>	
  	<?php
  }?>
  
  <tr>
  	<?php if ($client_full_name){?>
    	<td colspan="4"><strong>Client: </strong><?php echo $client_full_name; ?></td>
    <?php }else{?>
    	<?php if ($initial_interview=="Y"){?>
	    	<td colspan="4"><strong style="color:#ff0000">* Initial Interview</strong></td>
	    <?php }else if ($meeting=="Y"){?>
	    	<td colspan="4"><strong style="color:#ff0000">* Meeting</strong></td>
	    <?php }else if ($new_hire_orientation=="Y"){?>
		    <td colspan="4"><strong style="color:#ff0000">* New Hire Orientation</strong></td>
	    <?php }else if ($contract_signing=="Y"){?>
		    <td colspan="4"><strong style="color:#ff0000">* Contract Signing</strong></td>
	    <?php }else{?>
		    <td colspan="4"><strong style="color:#ff0000">* Initial Interview</strong></td>
	    <?php }?>
    <?php }?>
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
    <td colspan="4"><strong>Time Zone: </strong>
    <?php 
    if ($time_zone){
	    echo $time_zone;
    }else{
    	echo "Asia/Manila";
    } ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>  
  <tr>
    <td colspan="4"><strong>Start&nbsp;Time:</strong> <?php echo $start_day; ?>-<?php echo $start_month; ?>-<?php echo $start_year; ?>&nbsp;&nbsp;<?php echo $start_hour; ?>:<?php echo $start_minute; ?><?php if($start_hour < 13) echo "AM"; else echo "PM"; ?></td>
  </tr>
  <tr>
    <td colspan="4"><strong>End&nbsp;Time:</strong> <?php echo $end_day; ?>-<?php echo $end_month; ?>-<?php echo $end_year; ?>&nbsp;&nbsp;<?php echo $end_hour; ?>:<?php echo $end_minute; ?><?php if($end_hour < 13) echo "AM"; else echo "PM"; ?></td>
  </tr>

  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>  
  <tr>
    <td colspan="4">
    	<?php 
    	if ($initial_interview=="Y"||$meeting=="Y"||$contract_signing=="Y"||$new_hire_orientation=="Y"){
    		echo $description_applicant;
    	}else{
    		echo $description;
    	}?>
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