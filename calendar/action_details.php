<?php
require_once("../conf/connect.php") ;

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
		$description = @mysql_result($c,0,"description");
		
		$l = mysql_query("SELECT fname, lname FROM leads WHERE id='$l_id' LIMIT 1");		
		@$lname = mysql_result($l,0,"fname")." ".mysql_result($l,0,"lname");

	dieSql($db);	
?>
<html>
<head>
	<title>Schedule</title>
	<link rel=stylesheet type=text/css href="css/font.css">
	<link rel=stylesheet type=text/css href="css/style.css">
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
    <td><?php echo $start_hour; ?>-<?php echo $start_minute; ?><?php if($start_hour < 13) echo "AM"; else echo "PM"; ?></td>
    <td width="100%"></td>
  </tr>
  <tr>
    <td><strong>End&nbsp;Time:</strong></td>
    <td><?php echo $end_day; ?>-<?php echo $end_month; ?>-<?php echo $end_year; ?>&nbsp;&nbsp;</td>
    <td><?php echo $end_hour; ?>-<?php echo $end_minute; ?><?php if($end_hour < 13) echo "AM"; else echo "PM"; ?></td>
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