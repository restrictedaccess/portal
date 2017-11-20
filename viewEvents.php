<?
include 'config.php';
include 'conf.php';
include 'function.php';


$id=$_REQUEST['id'];

$i=$_REQUEST['i'];
$mode=$_REQUEST['mode'];
$agent_no = $_SESSION['agent_no'];
//$hour = date("h");

if($mode=="DELETE")
{
	$query="DELETE FROM calendar WHERE id =$id;";
	$result=mysql_query($query);
	echo "<script language=javascript>window.close();</script>";
}

//id, agent_no, cmonth, cday, cyear, title, details, date_created
if (isset($_POST['update'])) // Check if the form has been submitted.
{
	
	$mode=$_REQUEST['mode'];  // updatting
	$agent_no=$_REQUEST['agent_no'];
	$id=$_REQUEST['id'];
	
	$event_date =$_REQUEST['event_date'];
	$title=$_REQUEST['title'];
	$desc=$_REQUEST['desc'];
	$title = filterfield($title);
	$desc = filterfield($desc);
	$time=$_REQUEST['time'];
	
	if ($mode=="UPDATE")
	{
		$query="UPDATE calendar SET event_date = '$event_date', title='$title', details='$desc',ctime='$time' WHERE id=$id;";
		//echo $query;
		mysql_query($query)or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
		echo("<html><head><script>function update(){top.location='viewEvents.php?id=$id';}var refresh=setInterval('update()',1500);
	</script></head><body onload=refresh><body></html>");
	}
	
	
	
}


//id, agent_no, title, details, date_created, ctime, event_date
$query="SELECT * FROM calendar WHERE id = $id;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array($result);
	$event_date = $row['event_date'];
	$title2 = $row['title'];
	$details2 =$row['details'];
	$hour =$row['ctime'];

}	

// id, agent_no, month, day, year, title, desc, date_created

$sql ="SELECT MONTH(event_date), DAY(event_date), YEAR(event_date), title, details,DATE_FORMAT(date_created,'%D %M %Y'),lead_id, lead_name FROM calendar WHERE id=$id AND agent_no=$agent_no;";
//echo $sql;
$result=mysql_query($sql);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$counter=0;
	while(list($month, $day, $year, $title, $details,$date, $lead_id, $lead_name) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		$details=str_replace("\n","<br>",$details);
		switch($month)
		{
		case 1:
		$month= "Jan";
		break;
		case 2:
		$month= "Feb";
		break;
		case 3:
		$month= "Mar";
		break;
		case 4:
		$month= "Apr";
		break;
		case 5:
		$month= "May";
		break;
		case 6:
		$month= "Jun";
		break;
		case 7:
		$month= "Jul";
		break;
		case 8:
		$month= "Aug";
		break;
		case 9:
		$month= "Sep";
		break;
		case 10:
		$month= "Oct";
		break;
		case 11:
		$month= "Nov";
		break;
		case 12:
		$month= "Dec";
		break;
		default:
		break;
		}
		if($lead_id!="")
		{
			$details=$details."<br><br>"."<b>Client : <img src='images/arrow_next.gif' align=absmiddle>".$lead_name."</b>";
		}
		
		if($month=="0" || $day =="0" || $year=="0")
		{
		$txt.="<p><font color='#999999'><b>Title :&nbsp;<u>".$title."</u><br></font></b><ul><font color='#999999'>".$details."</font></ul></p><p align='right'><font color='#CCCCCC'>Date Created :".$date."&nbsp;&nbsp;</font></p>";
		}
		else
		{
		$txt.="<p><font color='#999999'><b>Event Date :".$month." ".$day." ".$year."<br><br>Title :&nbsp;<u>".$title."</u><br></font></b><ul><font color='#999999'>".$details."</font></ul></p><p align='right'><font color='#CCCCCC'>Date Created :".$date."&nbsp;&nbsp;</font></p>";
		}


	}
}

$monthnamesArray=array("-","JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC");
for ($i = 0; $i < count($monthnamesArray); $i++)
{
 if($month2 == $i)
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
 if($day2 == $i)
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
 if($year2 == $yearArray[$i])
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

?>

<html>
<head>
<title>ThinkInnovations.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
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
		missinginfo += "\n     -  Please enter a title .";
	}
	
	if (document.form.desc.value=="")
	{
		missinginfo += "\n     -  Please enter a details .";
	}
	//if (document.form.month.selectedIndex==0)
	//{
	//	missinginfo += "\n     -  Please choose a Month .";
	//}

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
<body bgcolor="#ffffff" topmargin="10" leftmargin="10" marginheight="10" marginwidth="10">


<script language=javascript src="js/functions.js"></script>

<table width="100%" cellpadding="0" cellspacing="0" border="0" >
<tr><td><img src="images/banner/remoteStaff-logo.jpg" alt="think" width="416" height="108"></td>
	<td align="right" style="color:#FFFFFF;" valign="baseline">
	  
	  <a href="javascript:window.close();" style="FONT: bold 8pt verdana; color:#000000;">Close</a>&#160;&#160;
	</td>
</tr>
</table>
<img src="images/space.gif" height=8 width=1><br clear=all>


	<table width=100% cellspacing=0 cellpadding=1 align=center border=0 bgcolor=#CCCCCC>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td>&nbsp;&nbsp;<font style='font: bold 10pt verdana;'>Event : <? echo $title2;?></font></td></tr>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td>
		<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#ffffff>
		<tr><td>
		<br>

<?
echo "<div id='leads'><p align='right' style='margin-right:20px;'><a href='viewEvents.php?id=$id&mode=UPDATE'> Edit </a>| <a href='#' onclick ='go($id); return false;'>Delete</a></p>". $txt ."</div>";
?>
<script language=javascript>
<!--
	function go(id) 
	{
		
			if (confirm("Are you sure you want to delete this Event?")) {
				location.href = "deleteevent.php?id="+id;
				location.href = "viewEvents.php?mode=DELETE&id="+id;
				//alert(id);
				//window.close();
			}
	}
	
//-->
</script>

</td></tr>
<?
if($mode=="UPDATE")
{

?>
<tr>
<td>
<form name="form" method="POST" action="#" onSubmit="return checkFields();">
<input type="hidden" name="agent_no" value="<? echo $agent_no;?>">
<input type="hidden" name="id" value="<? echo $id;?>">
<input type="hidden" name="mode" value="<? echo $mode;?>">
<table border="0" width="100%" style="border:#CCCCCC solid 1px; margin-top:65px;" >
  <tr bgcolor="#CCCCCC">
    <td colspan="4"><font color="#FFFFFF"><b>Add Event</b></font></td>
  </tr>
  <tr>
    <td width="23%"  align="right">Subject </td>
    <td width="4%">:</td>
    <td width="73%" colspan="2"><input type="text" name="title" size="25" class="text" style=" width:100%;" value="<? echo $title2;?>" ></td>
  </tr>
  <tr>
    <td  align="right">Event Date </td>
    <td v>:</td>
    <td colspan="2"><input type="text" name="event_date" size="25" class="text" style=" width:60%;" value="<? echo $event_date;?>" >
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
    <td width="73%" colspan="2"><textarea name="desc" cols="20" rows="4" style="width:90%;" ><? echo $details2;?></textarea></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><input type="submit" name="update" value="Update" class="button"></td>
  </tr>
</table>
</form>
</td>
</tr>
</table>
</td></tr>
<?
}
?>


	</table>

	</body>
	</html>

