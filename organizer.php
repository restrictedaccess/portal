<?
include 'config.php';
include 'function.php';
include 'conf.php';
include 'time.php';
include("activecalendar.php");

$mess="";
$mess=$_REQUEST['mess'];

$i=$_REQUEST['i'];
$mode=$_REQUEST['mode'];
$agent_no = $_SESSION['agent_no'];
$leads_id=$_REQUEST['leads_id'];
$url=$_REQUEST['url'];

$monthview=$_REQUEST['monthview'];
$weekview=$_REQUEST['weekview'];

//$eventmonth = date("m");
//$eventmonth2 = date("M");
//$eventday = date("d");
//$eventyear = date("Y");
//$hour = date("h");


//id, agent_no, cmonth, cday, cyear, title, details, date_created
$query="SELECT * FROM calendar WHERE id = $i;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array($result);
	$month = $row['cmonth'];
	$day = $row['cday'];
	$year = $row['cyear'];
	$title2 = $row['title'];
	$details =$row['details'];
	$hour =$row['ctime'];

}	



$monthnamesArray=array("-","JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC");
for ($i = 0; $i < count($monthnamesArray); $i++)
{
 if($month == $i)
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
 if($day == $i)
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
 if($year == $yearArray[$i])
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
// for Week view configuration

$myurl=$_SERVER['PHP_SELF']; // the links url is this page
$yearID=false; // init false to display current year
$monthID=false; // init false to display current month
$dayID=false; // init false to display current day
extract($_GET); // get the new values (if any) of $yearID,$monthID,$dayID
$arrowBack="<img src=\"images/back.png\" border=\"0\" alt=\"&lt;&lt;\" />"; // use png arrow back
$arrowForw="<img src=\"images/forward.png\" border=\"0\" alt=\"&gt;&gt;\" />"; // use png arrow forward
$cal = new activeCalendar($yearID,$monthID,$dayID);
$cal->enableMonthNav($myurl,$arrowBack,$arrowForw); // enables navigation controls
$cal->enableDatePicker(2000,2010,$myurl); // enables date picker (year range 2000-2010)



?>

<html>
<head>
<title>Organizer</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel="stylesheet" type="text/css" href="css/antique_wide.css" />
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="menu.css">

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<script type="text/javascript">
<!--
function checkFields()
{
		missinginfo = "";
	if (document.form.title.value=="")
	{
		missinginfo += "\n     -  Please enter a subject title .";
	}
	if (document.form.event_date.value=="")
	{
		missinginfo += "\n     -  Please enter a date.";
	}
	if (document.form.time.selectedIndex==0)
	{
		missinginfo += "\n     -  Please enter event time .";
	}
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


<!-- HEADER -->
<? include 'header.php';?>
<? include 'BP_header.php';?>

<table width="100%" >
<tr>
<td width="24%" valign="top" align="center">
<!-- controls here -->

<?
/*
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
		{	$desc=substr($desc,0,30);
			echo "<p style='margin-top:5px; margin-bottom:5px; margin-left:10px;'><b>".$counter.")</b>&nbsp;<img src='images/arrow_next.gif' align=top><a href='#' onClick=javascript:popup_win('./viewEvents.php?id=$id',600,600);>".$desc."</a><br>
			<font color='#CCCCCC'  style='margin-left:20px;'>$date</font></p>";
		}
	}
	echo "</td>
</tr>
</table>";
}
*/
?>

<form name="form" method="POST" action="organizerphp.php" onSubmit="return checkFields();">
<input type="hidden" name="agent_no" value="<? echo $agent_no;?>">
<input type="hidden" name="i" value="<? echo $i;?>">
<input type="hidden" name="mode" value="<? echo $mode;?>">
<input type="hidden" name="leads_id" value="<? echo $leads_id;?>">
<input type="hidden" name="url" value="<? echo $url;?>">
<table border="0" width="100%" style="border:#CCCCCC solid 1px; margin-top:20px;" >
<tr bgcolor="#CCCCCC"><td colspan="4"><font color="#FFFFFF"><b>Add Event</b></font></td></tr>
<tr><td width="23%"  align="right">Subject </td>
<td width="4%">:</td>
<td width="73%" colspan="2"><input type="text" name="title" size="25" class="text" style=" width:100%;" ></td></tr>
<tr><td  align="right">Event Date </td><td v>:</td><td colspan="2"><input type="text" name="event_date" id="event_date" size="25" class="text" style=" width:60%;" > <img align="top" src="images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
        <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "event_date",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "bd",          // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
		                showsTime	   :    false, 
                        singleClick    :    true
                    });                     
                  </script></td></tr>
<tr><td width="23%"  align="right">Event Time</td>
<td>:</td>
<td width="73%" colspan="2"><select name="time" style="font-size: 12px; width:60%;">
<option value="-">-</option>
<? echo $houroptions;?></select></td></tr>
<tr><td width="23%"  align="right" valign="top">Details</td>
<td valign="top">:</td>
<td width="73%" colspan="2"><textarea name="desc" cols="20" rows="4" style="width:90%;" ></textarea></td></tr>
<tr><td colspan="4" align="center"><input type="submit" name="Add" value="Save" class="button">
<?
if($url=="NewLead") {
?>
	<input type="button" name="Back" class="button" value="Back" onClick="self.location='apply_action.php?id=<? echo $leads_id;?>'"/>
<?
}
?>

<?
if($url=="Contacted") {
?>
	<input type="button" name="Back" class="button" value="Back" onClick="self.location='apply_action2.php?id=<? echo $leads_id;?>'"/>
<?
}
?>

<?
if($url=="Client") {
?>
	<input type="button" name="Back" class="button" value="Back" onClick="self.location='client_workflow.php?id=<? echo $leads_id;?>'"/>
<?
}
?>

</td></tr>
</table>
</form>
<p style="margin-top:5px; margin-bottom:5px;"><a href="organizer.php" class="link12b">Month View</a></p>

<p style="margin-top:5px; margin-bottom:5px;"><a href="dayviewOrganizer.php?this_day=TRUE" class="link12b">Day View</a></p>

<!-- --->
</td>
<td width="76%" height="100%" valign="top" align="left">
<!-- calendar here-->
<?php
$cal->enableMonthNav($suiteurl);
//id, agent_no, lead_id, lead_name, title, details, date_created, ctime, event_date
$query ="SELECT id, MONTH(event_date), DAY(event_date), YEAR(event_date),title, details,DATE_FORMAT(date_created,'%M %e %Y'),lead_id, lead_name FROM calendar WHERE agent_no=$agent_no;";
//echo $query;
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	//$counter=0;
	while(list($id, $month, $day, $year, $title, $desc,$date, $lead_id, $lead_name) = mysql_fetch_array($result))
	{	
	
		if($lead_id!="")
		{
			$title=$title."\n"."Client : ".$lead_name;
		}
	
		$cal->setEventContent($year,$month,$day,"<a href='#' onClick=javascript:popup_win('./viewEvents.php?id=$id',600,600);><img src='images/action_check.gif' title='$title' border='0' align='top'></a>");
	}
}
print $cal->showMonth();
?>

<!-- calendar ends here --></td>
</tr>
</table>
<? include 'footer.php';?>	
	
</body>
</html>
