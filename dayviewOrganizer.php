<?
include 'config.php';
include 'function.php';
include 'conf.php';
include 'time.php';

$timeZone = preg_replace('/([+-]\d{2})(\d{2})/','\'\1:\2\'', date('O'));
mysql_query('SET time_zone='.$timeZone);


$agent_no = $_SESSION['agent_no'];
$leads_id=$_REQUEST['leads_id'];

$yesterday=$_REQUEST['yesterday'];
$this_day=$_REQUEST['this_day'];
$tomorrow=$_REQUEST['tomorrow'];
$day=$_REQUEST['day'];

$search_date =$_REQUEST['search_date'];

if ($this_day=="TRUE")
{
	$this_day="TRUE";
	$day=0;
}

if($yesterday=="TRUE" && $this_day=="")
{
	$day=$day+1;
}

if($tomorrow=="TRUE" && $this_day=="")
{
	$day=$day-1;
}

//echo $this_day."<br>".$day;



/*
if($day=="")
{
	$day=1;
}
else
{	
	
	$day=($day+1);
}
*/

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
	
	if (document.form.desc.value=="")
	{
		missinginfo += "\n     -  Please enter a details .";
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
<td width="27%" valign="top" align="center">
<!-- controls here -->
<form name="form" method="POST" action="dayviewOrganizerphp.php" onSubmit="return checkFields();">
<input type="hidden" name="agent_no" value="<? echo $agent_no;?>">
<input type="hidden" name="i" value="<? echo $i;?>">
<input type="hidden" name="mode" value="<? echo $mode;?>">
<table border="0" width="100%" style="border:#CCCCCC solid 1px; margin-top:20px;" >
  <tr bgcolor="#CCCCCC">
    <td colspan="4"><font color="#FFFFFF"><b>Add Event</b></font></td>
  </tr>
  <tr>
    <td width="23%"  align="right">Subject </td>
    <td width="4%">:</td>
    <td width="73%" colspan="2"><input type="text" name="title" size="25" class="text" style=" width:100%;" ></td>
  </tr>
  <tr>
    <td  align="right">Event Date </td>
    <td v>:</td>
    <td colspan="2"><input type="text" name="event_date" id="event_date" size="25" class="text" style=" width:60%;" >
        <img align="top" src="images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
        <script type="text/javascript">
                    Calendar.setup({
                        inputField     :    "event_date",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "bd",          // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
		                showsTime	   :    false, 
                        singleClick    :    true
                    });                     
                  </script></td>
  </tr>
  <tr>
    <td width="23%"  align="right">Event Time</td>
    <td>:</td>
    <td width="73%" colspan="2"><select name="time" style="font-size: 12px; width:60%;">
      <option value="-">-</option>
      <? echo $houroptions;?>
    </select></td>
  </tr>
  <tr>
    <td width="23%"  align="right" valign="top">Details</td>
    <td valign="top">:</td>
    <td width="73%" colspan="2"><textarea name="desc" cols="20" rows="4" style="width:90%;" ></textarea></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><input type="submit" name="Add" value="Save" class="button"></td>
  </tr>
</table>
</form><br>
<p style="margin-top:5px; margin-bottom:5px;"><a href="organizer.php" class="link12b">Month View</a></p>
<p style="margin-top:5px; margin-bottom:5px;"><a href="dayviewOrganizer.php?this_day=TRUE" class="link12b">Day View</a></p>


<!-- ---></td>
<td width="77%" height="100%" valign="top">
<!-- calendar here--><br>

<p><b>Day View</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="dayviewOrganizer.php?day=<? echo $day;?>&yesterday=TRUE" class="link10"><img src="images/arrow_back.gif" alt="previous day" border="0" align="top"> Previous Day </a> | <a href="dayviewOrganizer.php?this_day=TRUE" class="link10">Current Day</a> | <a href="dayviewOrganizer.php?day=<? echo $day;?>&tomorrow=TRUE" class="link10">Next Day</a> <img src="images/arrow_next.gif" alt="previous day" border="0" align="texttop"><?

echo "<form name='form' method='POST' action='dayviewOrganizer.php'>
&nbsp;&nbsp;Date Search
<input type='text' name='search_date' id='search_date' class='text' style=' width:10%;' > 
<img align=absmiddle src=images/calendar_ico.png id=bd2 style='cursor: pointer;'  title='Date selector' />
<input type='image' align='absmiddle'  src='images/001_25.gif' title='go'>
        <script type='text/javascript'>
                    Calendar.setup({
                        inputField     :    'search_date',     // id of the input field
                        ifFormat       :    '%Y-%m-%d',      // format of the input field
                        button         :    'bd2',          // trigger for the calendar (button ID)
                        align          :    'Tl',           // alignment (defaults to 'Bl')
		                showsTime	   :    false, 
                        singleClick    :    true
                    });                     
                  </script></form>";
?>				  
</p>
<?
echo "<br>";
if ($search_date =="")
{
$sqlDay="SELECT DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $day DAY),'%W'),DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $day DAY),'%e'),
DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $day DAY),'%D %M %Y'),DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL 0 DAY),'%Y'),DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL 0 DAY),'%c'),DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $day DAY),'%e')";
//echo "<p>".$sqlDay."</p>";
}
if ($search_date !="")
{
	//$sqlDay="SELECT DATE_FORMAT('$searchDate','%W %D %M %Y'),DATE_FORMAT('$searchDate','%Y'),DATE_FORMAT('$searchDate','%c'),DATE_FORMAT('$searchDate','%e')";
	$sqlDay="SELECT DATE_FORMAT('$search_date','%W'),DATE_FORMAT('$search_date','%e'),DATE_FORMAT('$search_date','%D %M %Y'),DATE_FORMAT('$search_date','%Y'),DATE_FORMAT('$search_date','%c'),DATE_FORMAT('$search_date','%e')";
}
$result=mysql_query($sqlDay);
list($dayname,$date,$date2,$cyear,$cmonth,$cday)=mysql_fetch_array($result);
//echo $cyear."<br>".$cmonth."<br>".$cday;

?>
<table width='100%' class='tablecontent'>
<tr bgcolor='#666666'>
<td width='10%' align=left colspan="8"><b><font size='2' color='#FFFFFF'><? echo $dayname." ".$date2;?></font></b></td>
</tr>
<?
$timeNames=array("-","1:00AM","2:00AM","3:00AM","4:00AM","5:00AM","6:00AM","7:00AM","8:00AM","9:00AM","10:00AM","11:00AM","12:00PM","1:00PM","2:00PM","3:00PM","4:00PM","5:00PM","6:00PM","7:00PM","8:00PM","9:00PM","10:00PM","11:00PM");


$timeArray=array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24");

for ($i=1; $i<count($timeArray);$i++)
{
			//echo $i."<br>";
			//str.="";
	echo "<tr bgcolor=".$bgcolor."><td colspan='8' valign='top'>Time :".$timeNames[$i];
	
	//id, agent_no, cmonth, cday, cyear, title, details, date_created
	$sql="SELECT DISTINCT id,title, details,lead_id, lead_name
		  FROM calendar
		  WHERE YEAR(event_date) = '$cyear' AND  MONTH(event_date) = '$cmonth' AND DAY(event_date) ='$cday'
		AND
		ctime= $i 
		AND
		agent_no =$agent_no ORDER BY date_created DESC;";
		
	//echo "<p>".$sql."</p>";	
	
	$result=mysql_query($sql);

	$ctr=@mysql_num_rows($result);
	if ($ctr >0 )
	{ 
	echo "<table width='80%' style='margin-top:0px;margin-left:100px;' >";
	echo "<tr ><td width='3%' align=left></td>
		  <td width='44%' colspan='2' align=left><b>Title</b></td></tr>";
	$counter=0;
	while(list($id,$title, $details, $lead_id, $lead_name) = mysql_fetch_array($result))	
	{	$counter=$counter+1;
	
		if($lead_id!="")
		{
			$details=$details."\n"."Client : ".$lead_name;
		}
		
	
	   echo "<tr>
			 <td>".$counter.")&nbsp;</td>
			 <td align='left' width='44%'><a href='#' onClick=javascript:popup_win('./viewEvents.php?id=$id',600,600); title='$details'>".$title."</a></td>
			 </tr>";

	}
	echo "</table>";
	echo "</td></tr>";
    }

  if($bgcolor=="#f5f5f5")
  {
	$bgcolor="#FFFFFF";
  }
  else
  {
	$bgcolor="#f5f5f5";
  }

}	

?>
</table>
<!-- Future Day -->
<!-- calendar ends here --></td>
</tr>
</table>
<? include 'footer.php';?>	
	
</body>
</html>
