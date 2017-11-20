<?
include 'config.php';
include 'function.php';
include 'conf.php';
//include("activecalendar.php");

//$eventmonth = date("m");
//$eventmonth2 = date("M");
//$eventday = date("d");
//$eventyear = date("Y");
//$hour = date("h");

//echo $eventmonth2."<br>".$eventday."<br>".$eventyear;

$mess="";
$mess=$_REQUEST['mess'];

$i=$_REQUEST['i'];
$mode=$_REQUEST['mode'];
$agent_no = $_SESSION['agent_no'];

$monthnamesArray=array("-","JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC");
for ($i = 0; $i < count($monthnamesArray); $i++)
{
 if($eventmonth == $i)
  {
 $monthnameoptions .= "<option selected value=\"$i\">$monthnamesArray[$i]</option>\n";
  }
  else
  {
 $monthnameoptions .= "<option value=\"$i\">$monthnamesArray[$i]</option>\n";
  }
}  

for ($i = 1; $i <=31; $i++)
{
 if($eventday == $i)
  {
 $numoptions .= "<option selected value=\"$i\">$i</option>\n";
  }
  else
  {
 $numoptions .= "<option value=\"$i\">$i</option>\n";
  }
}  

$yearArray=array("2008","2009","2010","2011","2012");
for ($i = 0; $i < count($yearArray); $i++)
{
 if($eventyear == $yearArray[$i])
  {
 $yearoptions .= "<option selected value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
  }
  else
  {
 $yearoptions .= "<option value=\"$yearArray[$i]\">$yearArray[$i]</option>\n";
  }
}  

$hourNames=array("1:00AM","2:00AM","3:00AM","4:00AM","5:00AM","6:00AM","7:00AM","8:00AM","9:00AM","10:00AM","11:00AM","12:00PM","1:00PM","2:00PM","3:00PM","4:00PM","5:00PM","6:00PM","7:00PM","8:00PM","9:00PM","10:00PM","11:00PM","12:00AM");
$hourArray=array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24");

for ($i = 0; $i < count($hourArray); $i++)
{
 if($hour == $hourArray[$i])
  {
 $houroptions .= "<option selected value=\"$hourArray[$i]\">$hourNames[$i]</option>\n";
  }
  else
  {
 $houroptions .= "<option value=\"$hourArray[$i]\">$hourNames[$i]</option>\n";
  }
}  



require_once("activecalendar.php");
require_once("activecalendarweek.php");
$cal = new activeCalendarWeek($eventyear,$eventmonth,$eventday);
$cal->enableWeekNum("Week");

//$cal->setEventContent("2008","06","2","Google","http://www.google.com");
//$cal->setEventContent("2008","06","11","<img src=\"img/pager.png\" border=\"0\" alt=\"\" /> meeting");
//$cal->setEventContent("2008","06","23","<img src=\"img/ok.png\" border=\"0\" alt=\"\" /> birthday");



?>

<html>
<head>
<title>Organizer</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel="stylesheet" type="text/css" href="css/antique_wide.css" />
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript">
<!--
function checkFields()
{
		missinginfo = "";
	
	if (document.form.desc.value=="")
	{
		missinginfo += "\n     -  Please enter event details .";
	}
	
	if (missinginfo != "")
	{
		missinginfo =" " + "You failed to correctly fill in the required information:\n" +
		missinginfo + "\n\n";
		alert(missinginfo);
		return false;
	}
	else return true;

	
}
-->
</script>	
	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">


<script language=javascript src="js/functions.js"></script>
<script language=javascript src="js/cookie.js"></script>
<script language=javascript src="js/js2/functions.js"></script>
<script language=javascript src="js/js2/png.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
  <li><a href="agentHome.php"><b>Home</b></a></li>
  <li><a href="advertise_positions.php"><b>Applications</b></a></li>
  <li><a href="#"><b>Advertisements</b></a></li>
  <li><a href="newleads.php"><b>New Leads</b></a></li>
  <li><a href="contactedleads.php"><b>Contacted Leads</b></a></li>
  <li><a href="client_listings.php"><b>Clients</b></a></li>
   <li><a href="scm.php"><b>Sub-Contractor Management</b></a></li>
</ul>

<table width="100%" >
<tr>
<td width="27%" valign="top" align="center">
<!-- controls here -->
<?

$sql ="SELECT id, cmonth, cday, cyear, title, details,DATE_FORMAT(date_created,'%D %M %Y')

FROM calendar

WHERE agent_no=$agent_no

AND cmonth ='0'

OR cday ='0'

OR cyear ='0'

OR ctime = '0'

GROUP BY date_created DESC;";
//echo $sql;
$res=mysql_query($sql);
$ctr=@mysql_num_rows($res);
//echo $ctr;
if ($ctr >0 )
{
	//$counter=0;
	echo "<table border='0' width='85%' style='border:#CCCCCC solid 1px; margin-top:20px;' >
<tr>
<td>";
	echo "<h5>Any day Events</h5>";
	$counter=0;
	while(list($id, $month, $day, $year, $title, $desc,$date) = mysql_fetch_array($res))
	{	$counter = $counter + 1;
		if($title!="")
		{
			$title=substr($title,0,30);
			$desc=substr($desc,0,30);
			echo "<p style='margin-top:5px; margin-bottom:5px; margin-left:10px;'><b>".$counter.")</b>&nbsp;".$title."<br><ul style='margin-top:2px; margin-bottom:2px; margin-left:30px;'><img src='images/arrow_next.gif' align=top><a href='#' onClick=javascript:popup_win('./viewEvents.php?id=$id',600,600);>".$desc."</a><br>
			<font color='#CCCCCC'>$date</font></ul></p>";
		}
		else
		{
			$desc=substr($desc,0,30);
			echo "<p style='margin-top:5px; margin-bottom:5px; margin-left:10px;'><b>".$counter.")</b>&nbsp;<img src='images/arrow_next.gif' align=top><a href='#' onClick=javascript:popup_win('./viewEvents.php?id=$id',600,600);>".$desc."</a><br>
			<font color='#CCCCCC'  style='margin-left:20px;'>$date</font></p>";
		}
	}
	echo "</td>
</tr>
</table>";
}

?>
<form name="form" method="POST" action="weekviewOrganizerphp.php" onSubmit="return checkFields();">
<input type="hidden" name="agent_no" value="<? echo $agent_no;?>">
<input type="hidden" name="i" value="<? echo $i;?>">
<input type="hidden" name="mode" value="<? echo $mode;?>">
<table border="0" width="85%" style="border:#CCCCCC solid 1px; margin-top:20px;" >
<tr><td colspan="2"><h5>Add Event </h5></td></tr>

<tr><td width="64" align="right"><b>Month :</b></td>
<td width="160"><select name="month"  style="font-size: 12px;width:70px;">
<? echo $monthnameoptions;?>
</select></td></tr>
<tr>
<td width="64" align="right"><b>Day :</b></td>
<td width="160" align="left"><select name="day" style="font-size: 12px;width:70px;">
<option value="0">-</option>
<? echo $numoptions;?>
</select></td></tr>
<tr>
<td width="64" align="right"><b>Year :</b></td>
<td width="160"><select name="year" style="font-size: 12px;width:70px;">
<option value="0">-</option>
<? echo $yearoptions;?>
</select></td>
</tr>
<tr>
<td width="64" align="right"><b>Time :</b></td>
<td width="160"><select name="time" style="font-size: 12px; width:70px;">
<option value="-">-</option>
<? echo $houroptions;?></select></td>
</tr>

<tr>
<td align="right"><b>Title :</b></td>
<td ><input type="text" name="title" size="25" class="text" ></td>
</tr>
<tr>
<td align="right" valign="top" ><b>Details :</b></td>
<td ><textarea name="desc" cols="20" rows="7" ></textarea></td>
</tr>
<tr><td colspan="2" align="center"><input type="submit" name="Add" value="Save"></td></tr>
</table>
</form><br>
<p style="margin-top:5px; margin-bottom:5px;"><a href="organizer.php" class="link12b">Month View</a></p>
<p style="margin-top:5px; margin-bottom:5px;"><a href="weekviewOrganizer.php" class="link12b">Week View</a></p>
<p style="margin-top:5px; margin-bottom:5px;"><a href="dayviewOrganizer.php?this_day=TRUE" class="link12b">Day View</a></p>


<!-- --->


</td>
<td width="77%" height="100%" valign="top" align="center">
<!-- calendar here-->
<?php
//$cal->enableMonthNav($suiteurl);
$query ="SELECT id, cmonth, cday, cyear, title, details,DATE_FORMAT(date_created,'%M %e %Y') FROM calendar WHERE agent_no=$agent_no;";
//echo $query;
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	//$counter=0;
	while(list($id, $month, $day, $year, $title, $desc,$date) = mysql_fetch_array($result))
	{	
		$cal->setEventContent($year,$month,$day,"<a href='#' onClick=javascript:popup_win('./viewEvents.php?id=$id',600,600);><img src='images/action_check.gif' title='$title' border='0' align='top'></a>");
	}
}


print $cal->showWeeks(3);
?>

<!-- calendar ends here --></td>
</tr>
</table>
<? include 'footer.php';?>	
	
</body>
</html>
