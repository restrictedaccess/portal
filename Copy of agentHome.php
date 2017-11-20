<?
include 'config.php';
include 'conf.php';
include 'function.php';

$agent_no = $_SESSION['agent_no'];
$action=$_REQUEST['action'];
$month=$_REQUEST['month'];
$week=$_REQUEST['week'];

$last_week=$_REQUEST['last_week'];
$this_week=$_REQUEST['this_week'];

$yesterday=$_REQUEST['yesterday'];
$this_day=$_REQUEST['this_day'];
$day=$_REQUEST['day'];
//echo $month;

switch($month)
	{
		case '01':
		$bmonth= "January";
		break;
		case '02':
		$bmonth= "February";
		break;
		case '03':
		$bmonth= "March";
		break;
		case '04':
		$bmonth= "April";
		break;
		case '05':
		$bmonth= "May";
		break;
		case '06':
		$bmonth= "June";
		break;
		case '07':
		$bmonth= "July";
		break;
		case '08':
		$bmonth= "August";
		break;
		case '09':
		$bmonth= "September";
		break;
		case '10':
		$bmonth= "October";
		break;
		case '11':
		$bmonth= "November";
		break;
		case '12':
		$bmonth= "December";
		break;
		
	}

//echo $bmonth;
if($week=="")
{
	$week=1;
}
else
{	
	$week=($week+1);
}
if($day=="")
{
	$day=1;
}
else
{	
	
	$day=($day+1);
}
if($month=="")
{
	$month=date("m");
}

/*
agent_no, lname, fname, email, agent_password, date_registered
*/
$query="SELECT * FROM agent WHERE agent_no =$agent_no;";

$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result, MYSQL_NUM); 
	$name = $row[2]." ".$row[1];
	
}


$monthArray=array("01","02","03","04","05","06","07","08","09","10","11","12");
$monthName=array("January","February","March","April","May","June","July","August","September","October","November","December");
 for ($i = 0; $i < count($monthArray); $i++)
  {
      if($month == $monthArray[$i])
      {
	 $monthoptions .= "<option selected value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
      }
      else
      {
	$monthoptions .= "<option value=\"$monthArray[$i]\">$monthName[$i]</option>\n";
      }
   }


?>
<html>
<head>
<title>Agent-Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">

<script type="text/javascript">
<!--
-->
</script>	
<style type="text/css">
<!--
div.scroll {
	height: 100%;
	width: 100%;
	overflow: auto;
	padding: 8px;
	
}
.tableContent tr:hover
{
	background:#FFFFCC;
	
}

.tablecontent tbody tr:hover {
  background: #FFFFCC;
  }
-->
</style>
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="agentHome.php?action=<? echo $action;?>" >

<script language=javascript src="js/functions.js"></script>
<script language=javascript src="js/cookie.js"></script>
<script language=javascript src="js/js2/functions.js"></script>
<script language=javascript src="js/js2/png.js"></script>

<!-- HEADER -->
<? include 'header.php';?>

<ul class="glossymenu">
  <li class="current"><a href="agentHome.php"><b>Home</b></a></li>
  <li><a href="advertise_positions.php"><b>Applications</b></a></li>
  <li><a href="#"><b>Advertisements</b></a></li>
  <li><a href="newleads.php"><b>New Leads</b></a></li>
  <li><a href="contactedleads.php"><b>Contacted Leads</b></a></li>
  <li><a href="client_listings.php"><b>Clients</b></a></li>
   <li><a href="scm.php"><b>Sub-Contractor Management</b></a></li>
</ul>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="100%" bgcolor="#ffffff" align="center">
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center><tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
  <td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='images/space.gif' width=1 height=10>
<br clear=all>
<? include 'agentleftnav.php';?>
<br></td>
<td width=100% valign=top align=right>
<img src=images/space.gif width=1 height=10>
<br clear=all>
<table width=100% height="396" border=0 cellpadding=10 cellspacing=0>
<tr><td width="100%" height="365" valign="top">


<table width=100%  cellspacing=2 cellpadding=2 border=0 align=left >
<tr><td bgcolor=#DEE5EB colspan=3><b>Agent Home</b></td>
</tr>
<tr ><td colspan=3 valign="top" ><b><? echo $name;?></b></td></tr>
<tr><td width="26%" height="135" align="right">
<table width="87%" height="100%" style="margin-right:10px;">
<tr><td align=right width=30%  ><a href="newleads.php" class="link12b" >New Leads</a></td>
</tr>
<tr>
<td align=right width=30%>&nbsp;&nbsp;   <a href="contactedleads.php" class="link12b" >Contacted Leads</a></td>
</tr>
<tr><td align=right width=30% ><a href="client_listings.php" class="link12b" >Clients</a>  </td>
</tr>
<tr><td align="right" width="30%" ><a href="logout.php" class="link12b"  >Logout</a></td>

</tr>


<tr><td align="right" width="30%" ><a href="inactiveList.php" class="link12b"  >No Longer a Prospects List</a> <img src="images/folder_clip.gif" border="0"></td>

</tr>


</table>
</td>
<td width="46%" valign="top">
<?
$sql="SELECT COUNT(actions),DATE_FORMAT(MAX(date_created),'%D %M %Y') FROM history h WHERE actions='EMAIL' AND agent_no =$agent_no  GROUP BY actions;";
//echo $sql;
$res = mysql_query ($sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysql_error());	
list($email,$date) = mysql_fetch_array($res);
///////
$sql2="SELECT COUNT(actions),DATE_FORMAT(MAX(date_created),'%D %M %Y') FROM history h WHERE actions='CALL' AND agent_no =$agent_no  GROUP BY actions;";
$res2 = mysql_query ($sql2) or trigger_error("Query: $sql2\n<br />MySQL Error: " . mysql_error());	
list($phone,$date2) = mysql_fetch_array($res2);
////
$sql3="SELECT COUNT(actions),DATE_FORMAT(MAX(date_created),'%D %M %Y') FROM history h WHERE actions='MAIL' AND agent_no =$agent_no  GROUP BY actions;";
$res3 = mysql_query ($sql3) or trigger_error("Query: $sql3\n<br />MySQL Error: " . mysql_error());	
list($mail,$date3) = mysql_fetch_array($res3);
////
$sql4="SELECT COUNT(actions),DATE_FORMAT(MAX(date_created),'%D %M %Y') FROM history h WHERE actions='MEETING FACE TO FACE' AND agent_no =$agent_no  GROUP BY actions;";
$res4 = mysql_query ($sql4) or trigger_error("Query: $sql4\n<br />MySQL Error: " . mysql_error());	
list($meeting,$date4) = mysql_fetch_array($res4);

?>


<table width="100%" height="34%" style="border:#CCCCCC solid 1px;">
<tr>
<td height="20" colspan="2" valign="middle" bgcolor=#DEE5EB><b>&nbsp;&nbsp;Agent Summary Action Reports</b></td>
</tr>
<tr style="border:#CCCCCC solid 1px;">
<td width="149" height="25" bordercolor="#CCCCCC" ><b><a href="agentHome.php?action=EMAIL&month=<? echo $month;?>" class="link18">Email:</a></b></td>
<td width="309"><font color="#0000FF"><b><? echo $email;?></b></font><i>&nbsp;&nbsp;&nbsp; sent emails  as of <? echo $date;?></i></td>
</tr>
<tr >
<td width="149" height="25"  ><b><a href="agentHome.php?action=CALL&month=<? echo $month;?>" class="link18">Phone</a></b></td>
<td><font color="#0000FF"><b><? echo $phone;?></b></font><i>&nbsp;&nbsp;&nbsp;phone calls made as of <? echo $date2;?></i></td>
</tr>
<tr>
<td width="149" height="25"  ><b><a href="agentHome.php?action=MAIL&month=<? echo $month;?>" class="link18">Mail</a></b></td>
<td><font color="#0000FF"><b><? echo $mail;?></b></font><i>&nbsp;&nbsp;&nbsp;sent mails made as of <? echo $date3;?></i></td>
</tr>
<tr>
<td width="149" height="25"  ><b><a href="agentHome.php?action=MEETING FACE TO FACE&month=<? echo $month;?>" class="link18">Meeting Face to Face</a></b></td>
<td><font color="#0000FF"><b><? echo $meeting;?></b></font><i>&nbsp;&nbsp;&nbsp;face to face meeting made as of <? echo $date4;?></i></td>
</tr>
</table>
</td>
<td width="28%" valign="top">&nbsp;</td>
</tr>
</table>
<!-- skills list -->
<br clear=all>
<!-- --->
<?
if($action!="")
{
?>
<table width="100%" style="border:#CCCCCC solid 1px;">
<tr><td height="10" valign="middle" colspan="5"><b><? echo $action?></b></td><td height="10" valign="middle" align="right"><b>Month of :&nbsp;&nbsp;<? echo $bmonth;?></b>&nbsp;&nbsp;&nbsp;</td>

<tr><td height="1" colspan="6" bgcolor="#666666" valign="top"></td></tr>

<tr><td width="10%" height="25"><b>Month View</b></td>
<td width="16%"><select name="month" class="text"  onChange="javascript: document.form.submit();">
 <? echo $monthoptions;?>
 </select>&nbsp;&nbsp;</td>

<td width="9%" height="25"><b>Week View</b></td>
<td width="22%"><a href="agentHome.php?action=<? echo $action;?>&week=<? echo $week;?>&last_week=TRUE" class="link10">Last Week </a>| <a href="agentHome.php?action=<? echo $action;?>&this_week=TRUE" class="link10">Current Week</a></td>
<td width="10%" height="25"><b>Day View</b></td>
<td width="33%">
 <a href="agentHome.php?action=<? echo $action;?>&this_day=TRUE" class="link10">Current Day</a> |
<a href="agentHome.php?action=<? echo $action;?>&day=<? echo $day;?>&yesterday=TRUE" class="link10">Previous Day </a></td>
</tr>
</table>
<?
if($month!=""  && $last_week=="" && $this_week=="" && $yesterday=="" && $this_day=="" )
{
	$querySearch="SELECT h.id,h.leads_id,l.fname,l.lname,h.actions,h.history,DATE_FORMAT(h.date_created,'%D %M %Y'),DATE_FORMAT(h.date_created,'%r')
				  FROM history h JOIN leads l ON l.id = h.leads_id
				  WHERE actions='$action' AND DATE_FORMAT(h.date_created,'%m')='$month' AND h.agent_no =$agent_no ORDER BY date_created DESC;";
				  //echo $querySearch;
	$resultSearch=mysql_query($querySearch);
	$counter=0;
	echo "<table width='100%' class='tablecontent'>
<tr bgcolor='#666666'>
<td width='3%' align=left></td>
<td width='15%' align=left><b><font size='1' color='#FFFFFF'>Date</font></b></td>
<td width='10%' align=left><b><font size='1'color='#FFFFFF'>Time</font></b></td>
<td width='20%' align=left><b><font size='1'color='#FFFFFF'>Name</font></b></td>
<td width='44%' colspan='2' align=left><b><font size='1'color='#FFFFFF'>Full Details</font></b></td>
</tr>";
	while(list($h_id,$leads_id,$fname,$lname,$actions,$history,$date,$time) = mysql_fetch_array($resultSearch))
	{ $counter=$counter+1;
		
echo "<tr bgcolor=".$bgcolor.">
	<td>".$counter.")&nbsp;</td>
	<td>".$date."</td>
	<td>".$time."</td>
	<td><a href='#' onClick=javascript:popup_win('./viewLead.php?id=$leads_id',600,600);>".$fname." ".$lname."</a></td>
	<td colspan='2'>".$history."</td>
	</tr>";
   

			  if($bgcolor=="#f5f5f5")
			  {
			  	$bgcolor="#FFFFFF";
			  }
			  else
			  {
			  	$bgcolor="#f5f5f5";
			  }
 
  }?>
  
<? echo "</table> "; }?> 
<? }?>

<?
if($last_week!="" && $last_week=="TRUE")
{
$week=$week-1;
$sqlWeekDay="SELECT DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $week WEEK),'%D %M %Y'),DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $week-1 WEEK),'%D %M %Y')";
//echo $sqlWeekDay;
$res=mysql_query($sqlWeekDay);
list($datefrom,$dateto)=mysql_fetch_array($res);
$sqlActions="SELECT COUNT(actions)FROM history h WHERE actions='EMAIL' AND agent_no =$agent_no AND date_format(date_created,'%X %U') = date_format(current_date()-interval $week week,'%X %U') GROUP BY actions;";

$resA = mysql_query ($sqlActions);	
list($emailA) = mysql_fetch_array($resA);

$sqlActions2="SELECT COUNT(actions)FROM history h WHERE actions='CALL' AND agent_no =$agent_no AND date_format(date_created,'%X %U') = date_format(current_date()-interval $week week,'%X %U') GROUP BY actions;";
//echo $sqlActions2;
$resB = mysql_query ($sqlActions2);	
list($callB) = mysql_fetch_array($resB);

$sqlActions3="SELECT COUNT(actions)FROM history h WHERE actions='MAIL' AND agent_no =$agent_no AND date_format(date_created,'%X %U') = date_format(current_date()-interval $week week,'%X %U') GROUP BY actions;";

$resC = mysql_query ($sqlActions3);	
list($mailC) = mysql_fetch_array($resC);

$sqlActions4="SELECT COUNT(actions)FROM history h WHERE actions='MEETING FACE TO FACE' AND agent_no =$agent_no AND date_format(date_created,'%X %U') = date_format(current_date()-interval $week week,'%X %U') GROUP BY actions;";

$resD = mysql_query ($sqlActions4);	
list($meetD) = mysql_fetch_array($resD);
echo "<p><b>".$datefrom." ".$dateto."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email&nbsp;&nbsp;($emailA)&nbsp;&nbsp;Phone&nbsp;&nbsp;($callB)&nbsp;&nbsp;Mail&nbsp;&nbsp;($mailC)&nbsp;&nbsp;Meetings&nbsp;&nbsp;($meetD)</b>&nbsp;&nbsp;</p>";

?>

<table width='100%' class='tablecontent'>
<tr bgcolor='#666666'>
<td width='3%' align=left></td>
<td width='10%' align=left><b><font size='1' color='#FFFFFF'>Monday</font></b></td>
<td width='10%' align=left><b><font size='1'color='#FFFFFF'>Tuesday</font></b></td>
<td width='10%' align=left><b><font size='1'color='#FFFFFF'>Wednesday</font></b></td>
<td width='10%' align=left><b><font size='1'color='#FFFFFF'>Thursday</font></b></td>
<td width='10%' align=left><b><font size='1'color='#FFFFFF'>Friday</font></b></td>
<td width='10%' align=left><b><font size='1'color='#FFFFFF'>Saturday</font></b></td>
<td width='10%' align=left><b><font size='1'color='#FFFFFF'>Sunday</font></b></td>
</tr>

<tr>
<td width='3%' align=left></td>
<td width='10%' align=left valign="top">
<!-- MONDAY -->
<table width="100%">
<?
$sqlMon="SELECT DISTINCT h.leads_id,l.fname,l.lname,h.actions,DATE_FORMAT(h.date_created,'%r'),DATE_FORMAT(date_created,'%D %M %Y ') FROM history h JOIN leads l ON l.id = h.leads_id WHERE date_format(date_created,'%X %U') = date_format(current_date()-interval $week week,'%X %U') AND DAYOFWEEK(date_created)=2 AND h.agent_no =$agent_no ORDER BY date_created DESC;";

//echo $sqlMon;
$search=mysql_query($sqlMon);
while(list($leads_id,$fname,$lname,$actions,$time,$date) = mysql_fetch_array($search))
{
	echo "<tr><td><a href='#' onClick=javascript:popup_win('./viewLead.php?id=$leads_id',600,600);>".$fname." ".$lname."</a><br>".$actions."<br>".$time."<br>".$date."</td></tr>";
}

?>
</table>
<!-- --->
</td>
<td width='10%' align=left valign="top">
<!-- TUESDAY -->
<table width="100%">
<?
$sqlTue="SELECT DISTINCT h.leads_id,l.fname,l.lname,h.actions,DATE_FORMAT(h.date_created,'%r'),DATE_FORMAT(date_created,'%D %M %Y ') FROM history h JOIN leads l ON l.id = h.leads_id WHERE date_format(date_created,'%X %U') = date_format(current_date()-interval $week week,'%X %U') AND DAYOFWEEK(date_created)=3 AND h.agent_no =$agent_no ORDER BY date_created DESC;";
$search2=mysql_query($sqlTue);
while(list($leads_id,$fname,$lname,$actions,$time,$date) = mysql_fetch_array($search2))
{
	echo "<tr><td><a href='#' onClick=javascript:popup_win('./viewLead.php?id=$leads_id',600,600);>".$fname." ".$lname."</a><br>".$actions."<br>".$time."<br>".$date."</td></tr>";
}
//echo $sqlTue;
?>
</table>
<!-- --->
</td>
<td width='10%' align=left valign="top">
<!-- WEDNESDAY -->
<table width="100%">
<?
$sqlWed="SELECT DISTINCT h.leads_id,l.fname,l.lname,h.actions,DATE_FORMAT(h.date_created,'%r'),DATE_FORMAT(date_created,'%D %M %Y ') FROM history h JOIN leads l ON l.id = h.leads_id WHERE date_format(date_created,'%X %U') = date_format(current_date()-interval $week week,'%X %U') AND DAYOFWEEK(date_created)=4 AND h.agent_no =$agent_no ORDER BY date_created DESC;";
$search3=mysql_query($sqlWed);
while(list($leads_id,$fname,$lname,$actions,$time,$date) = mysql_fetch_array($search3))
{
	echo "<tr><td><a href='#' onClick=javascript:popup_win('./viewLead.php?id=$leads_id',600,600);>".$fname." ".$lname."</a><br>".$actions."<br>".$time."<br>".$date."</td></tr>";
}

?>
</table>
<!-- --->

</td>
<td width='10%' align=left valign="top">
<!-- THURSDAY -->
<table width="100%">
<?
$sqlThu="SELECT DISTINCT h.leads_id,l.fname,l.lname,h.actions,DATE_FORMAT(h.date_created,'%r'),DATE_FORMAT(date_created,'%D %M %Y ') FROM history h JOIN leads l ON l.id = h.leads_id WHERE date_format(date_created,'%X %U') = date_format(current_date()-interval $week week,'%X %U') AND DAYOFWEEK(date_created)=5 AND h.agent_no =$agent_no ORDER BY date_created DESC;";
$search4=mysql_query($sqlThu);
while(list($leads_id,$fname,$lname,$actions,$time,$date) = mysql_fetch_array($search4))
{
	echo "<tr><td><a href='#' onClick=javascript:popup_win('./viewLead.php?id=$leads_id',600,600);>".$fname." ".$lname."</a><br>".$actions."<br>".$time."<br>".$date."</td></tr>";
}

?>
</table>
<!-- --->

</td>
<td width='10%' align=left valign="top">
<!-- FRIDAY -->
<table width="100%">
<?
$sqlFri="SELECT DISTINCT h.leads_id,l.fname,l.lname,h.actions,DATE_FORMAT(h.date_created,'%r'),DATE_FORMAT(date_created,'%D %M %Y ') FROM history h JOIN leads l ON l.id = h.leads_id WHERE date_format(date_created,'%X %U') = date_format(current_date()-interval $week week,'%X %U') AND DAYOFWEEK(date_created)=6 AND h.agent_no =$agent_no ORDER BY date_created DESC;";
$search5=mysql_query($sqlFri);
while(list($leads_id,$fname,$lname,$actions,$time,$date) = mysql_fetch_array($search5))
{
	echo "<tr><td><a href='#' onClick=javascript:popup_win('./viewLead.php?id=$leads_id',600,600);>".$fname." ".$lname."</a><br>".$actions."<br>".$time."<br>".$date."</td></tr>";
}

?>
</table>
<!-- --->

</td>
<td width='10%' align=left valign="top">
<!-- SATURDAY -->
<table width="100%">
<?
$sqlSat="SELECT DISTINCT h.leads_id,l.fname,l.lname,h.actions,DATE_FORMAT(h.date_created,'%r'),DATE_FORMAT(date_created,'%D %M %Y ') FROM history h JOIN leads l ON l.id = h.leads_id WHERE date_format(date_created,'%X %U') = date_format(current_date()-interval $week week,'%X %U') AND DAYOFWEEK(date_created)=7 AND h.agent_no =$agent_no ORDER BY date_created DESC;";
//echo $sqlSat;
$search6=mysql_query($sqlSat);
while(list($leads_id,$fname,$lname,$actions,$time,$date) = mysql_fetch_array($search6))
{
	echo "<tr><td><a href='#' onClick=javascript:popup_win('./viewLead.php?id=$leads_id',600,600);>".$fname." ".$lname."</a><br>".$actions."<br>".$time."<br>".$date."</td></tr>";
}

?>
</table>
<!-- --->

</td>
<td width='10%' align=left valign="top">
<!-- SUNDAY -->
<table width="100%">
<?
$sqlSun="SELECT DISTINCT h.leads_id,l.fname,l.lname,h.actions,DATE_FORMAT(h.date_created,'%r'),DATE_FORMAT(date_created,'%D %M %Y ') FROM history h JOIN leads l ON l.id = h.leads_id WHERE date_format(date_created,'%X %U') = date_format(current_date()-interval $week week,'%X %U') AND DAYOFWEEK(date_created)=1 AND h.agent_no =$agent_no ORDER BY date_created DESC;";
$search7=mysql_query($sqlSun);
while(list($leads_id,$fname,$lname,$actions,$time,$date) = mysql_fetch_array($search7))
{
	echo "<tr><td><a href='#' onClick=javascript:popup_win('./viewLead.php?id=$leads_id',600,600);>".$fname." ".$lname."</a><br>".$actions."<br>".$time."<br>".$date."</td></tr>";
}

?>
</table>
<!-- --->


</td>
</tr>
</table>
<?
}
?>
<!-- CURRRENT WEEK--->
<?
if($this_week!="" && $this_week=="TRUE")
{
$week=$week-1;
$sqlWeekDay="SELECT DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $week WEEK),'%D %M %Y'),DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $week-1 WEEK),'%D %M %Y')";
//echo $sqlWeekDay;
$res=mysql_query($sqlWeekDay);
list($datefrom,$dateto)=mysql_fetch_array($res);
$sqlActions="SELECT COUNT(actions)FROM history h WHERE actions='EMAIL' AND agent_no =$agent_no AND YEARWEEK(date_created) = YEARWEEK(CURRENT_TIMESTAMP) GROUP BY actions;";

$resA = mysql_query ($sqlActions);	
list($emailA) = mysql_fetch_array($resA);

$sqlActions2="SELECT COUNT(actions)FROM history h WHERE actions='CALL' AND agent_no =$agent_no AND YEARWEEK(date_created) = YEARWEEK(CURRENT_TIMESTAMP) GROUP BY actions;";
//echo $sqlActions2;
$resB = mysql_query ($sqlActions2);	
list($callB) = mysql_fetch_array($resB);

$sqlActions3="SELECT COUNT(actions)FROM history h WHERE actions='MAIL' AND agent_no =$agent_no AND YEARWEEK(date_created) = YEARWEEK(CURRENT_TIMESTAMP) GROUP BY actions;";

$resC = mysql_query ($sqlActions3);	
list($mailC) = mysql_fetch_array($resC);

$sqlActions4="SELECT COUNT(actions)FROM history h WHERE actions='MEETING FACE TO FACE' AND agent_no =$agent_no AND YEARWEEK(date_created) = YEARWEEK(CURRENT_TIMESTAMP) GROUP BY actions;";

$resD = mysql_query ($sqlActions4);	
list($meetD) = mysql_fetch_array($resD);

echo "<p><b>".$datefrom." ".$dateto."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email&nbsp;&nbsp;($emailA)&nbsp;&nbsp;Phone&nbsp;&nbsp;($callB)&nbsp;&nbsp;Mail&nbsp;&nbsp;($mailC)&nbsp;&nbsp;Meetings&nbsp;&nbsp;($meetD)</b>&nbsp;&nbsp;</p>";

?>

<table width='100%' class='tablecontent'>
<tr bgcolor='#666666'>
<td width='3%' align=left></td>
<td width='10%' align=left><b><font size='1' color='#FFFFFF'>Monday</font></b></td>
<td width='10%' align=left><b><font size='1'color='#FFFFFF'>Tuesday</font></b></td>
<td width='10%' align=left><b><font size='1'color='#FFFFFF'>Wednesday</font></b></td>
<td width='10%' align=left><b><font size='1'color='#FFFFFF'>Thursday</font></b></td>
<td width='10%' align=left><b><font size='1'color='#FFFFFF'>Friday</font></b></td>
<td width='10%' align=left><b><font size='1'color='#FFFFFF'>Saturday</font></b></td>
<td width='10%' align=left><b><font size='1'color='#FFFFFF'>Sunday</font></b></td>
</tr>

<tr>
<td width='3%' align=left></td>
<td width='10%' align=left valign="top">
<!-- MONDAY -->
<table width="100%">
<?
$sqlMon="SELECT DISTINCT h.leads_id,l.fname,l.lname,h.actions,DATE_FORMAT(h.date_created,'%r'),DATE_FORMAT(date_created,'%D %M %Y ') FROM history h JOIN leads l ON l.id = h.leads_id WHERE YEARWEEK(date_created) = YEARWEEK(CURRENT_TIMESTAMP) AND DAYOFWEEK(date_created)=2 AND h.agent_no =$agent_no ORDER BY date_created DESC;";

//echo $sqlMon;
$search=mysql_query($sqlMon);
while(list($leads_id,$fname,$lname,$actions,$time,$date) = mysql_fetch_array($search))
{
	echo "<tr><td><a href='#' onClick=javascript:popup_win('./viewLead.php?id=$leads_id',600,600);>".$fname." ".$lname."</a><br>".$actions."<br>".$time."<br>".$date."</td></tr>";
}

?>
</table>
<!-- --->
</td>
<td width='10%' align=left valign="top">
<!-- TUESDAY -->
<table width="100%">
<?
$sqlTue="SELECT DISTINCT h.leads_id,l.fname,l.lname,h.actions,DATE_FORMAT(h.date_created,'%r'),DATE_FORMAT(date_created,'%D %M %Y ') FROM history h JOIN leads l ON l.id = h.leads_id WHERE YEARWEEK(date_created) = YEARWEEK(CURRENT_TIMESTAMP) AND DAYOFWEEK(date_created)=3 AND h.agent_no =$agent_no ORDER BY date_created DESC;";
$search2=mysql_query($sqlTue);
while(list($leads_id,$fname,$lname,$actions,$time,$date) = mysql_fetch_array($search2))
{
	echo "<tr><td><a href='#' onClick=javascript:popup_win('./viewLead.php?id=$leads_id',600,600);>".$fname." ".$lname."</a><br>".$actions."<br>".$time."<br>".$date."</td></tr>";
}
//echo $sqlTue;
?>
</table>
<!-- --->
</td>
<td width='10%' align=left valign="top">
<!-- WEDNESDAY -->
<table width="100%">
<?
$sqlWed="SELECT DISTINCT h.leads_id,l.fname,l.lname,h.actions,DATE_FORMAT(h.date_created,'%r'),DATE_FORMAT(date_created,'%D %M %Y ') FROM history h JOIN leads l ON l.id = h.leads_id WHERE YEARWEEK(date_created) = YEARWEEK(CURRENT_TIMESTAMP) AND DAYOFWEEK(date_created)=4 AND h.agent_no =$agent_no ORDER BY date_created DESC;";
$search3=mysql_query($sqlWed);
while(list($leads_id,$fname,$lname,$actions,$time,$date) = mysql_fetch_array($search3))
{
	echo "<tr><td><a href='#' onClick=javascript:popup_win('./viewLead.php?id=$leads_id',600,600);>".$fname." ".$lname."</a><br>".$actions."<br>".$time."<br>".$date."</td></tr>";
}

?>
</table>
<!-- --->

</td>
<td width='10%' align=left valign="top">
<!-- THURSDAY -->
<table width="100%">
<?
$sqlThu="SELECT DISTINCT h.leads_id,l.fname,l.lname,h.actions,DATE_FORMAT(h.date_created,'%r'),DATE_FORMAT(date_created,'%D %M %Y ') FROM history h JOIN leads l ON l.id = h.leads_id WHERE YEARWEEK(date_created) = YEARWEEK(CURRENT_TIMESTAMP) AND DAYOFWEEK(date_created)=5 AND h.agent_no =$agent_no ORDER BY date_created DESC;";
$search4=mysql_query($sqlThu);
while(list($leads_id,$fname,$lname,$actions,$time,$date) = mysql_fetch_array($search4))
{
	echo "<tr><td><a href='#' onClick=javascript:popup_win('./viewLead.php?id=$leads_id',600,600);>".$fname." ".$lname."</a><br>".$actions."<br>".$time."<br>".$date."</td></tr>";
}

?>
</table>
<!-- --->

</td>
<td width='10%' align=left valign="top">
<!-- FRIDAY -->
<table width="100%">
<?
$sqlFri="SELECT DISTINCT h.leads_id,l.fname,l.lname,h.actions,DATE_FORMAT(h.date_created,'%r'),DATE_FORMAT(date_created,'%D %M %Y ') FROM history h JOIN leads l ON l.id = h.leads_id WHERE YEARWEEK(date_created) = YEARWEEK(CURRENT_TIMESTAMP) AND DAYOFWEEK(date_created)=6 AND h.agent_no =$agent_no ORDER BY date_created DESC;";
$search5=mysql_query($sqlFri);
while(list($leads_id,$fname,$lname,$actions,$time,$date) = mysql_fetch_array($search5))
{
	echo "<tr><td><a href='#' onClick=javascript:popup_win('./viewLead.php?id=$leads_id',600,600);>".$fname." ".$lname."</a><br>".$actions."<br>".$time."<br>".$date."</td></tr>";
}

?>
</table>
<!-- --->

</td>
<td width='10%' align=left valign="top">
<!-- SATURDAY -->
<table width="100%">
<?
$sqlSat="SELECT DISTINCT h.leads_id,l.fname,l.lname,h.actions,DATE_FORMAT(h.date_created,'%r'),DATE_FORMAT(date_created,'%D %M %Y ') FROM history h JOIN leads l ON l.id = h.leads_id WHERE YEARWEEK(date_created) = YEARWEEK(CURRENT_TIMESTAMP) AND DAYOFWEEK(date_created)=7 AND h.agent_no =$agent_no ORDER BY date_created DESC;";
//echo $sqlSat;
$search6=mysql_query($sqlSat);
while(list($leads_id,$fname,$lname,$actions,$time,$date) = mysql_fetch_array($search6))
{
	echo "<tr><td><a href='#' onClick=javascript:popup_win('./viewLead.php?id=$leads_id',600,600);>".$fname." ".$lname."</a><br>".$actions."<br>".$time."<br>".$date."</td></tr>";
}

?>
</table>
<!-- --->

</td>
<td width='10%' align=left valign="top">
<!-- SUNDAY -->
<table width="100%">
<?
$sqlSun="SELECT DISTINCT h.leads_id,l.fname,l.lname,h.actions,DATE_FORMAT(h.date_created,'%r'),DATE_FORMAT(date_created,'%D %M %Y ') FROM history h JOIN leads l ON l.id = h.leads_id WHERE YEARWEEK(date_created) = YEARWEEK(CURRENT_TIMESTAMP) AND DAYOFWEEK(date_created)=1 AND h.agent_no =$agent_no ORDER BY date_created DESC;";
$search7=mysql_query($sqlSun);
while(list($leads_id,$fname,$lname,$actions,$time,$date) = mysql_fetch_array($search7))
{
	echo "<tr><td><a href='#' onClick=javascript:popup_win('./viewLead.php?id=$leads_id',600,600);>".$fname." ".$lname."</a><br>".$actions."<br>".$time."<br>".$date."</td></tr>";
}

?>
</table>
<!-- --->


</td>
</tr>
</table>
<?
}
?>
<!-- YESTERDAY -->
<?
echo "<br>";
if($yesterday!="" && $yesterday=="TRUE")
{
$day=$day-1;
$sqlDay="SELECT DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $day DAY),'%W'),DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $day DAY),'%e'),
DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL $day DAY),'%D %M %Y')";
//echo "<p>".$sqlDay."</p>";
$result=mysql_query($sqlDay);
list($dayname,$date,$date2)=mysql_fetch_array($result);
?>

<table width='100%' class='tablecontent'>
<tr bgcolor='#666666'>
<td width='10%' align=left colspan="8"><b><font size='1' color='#FFFFFF'><? echo $dayname." ".$date2;?></font></b></td>
</tr>
<?
$timeNames=array("-","1:00AM","2:00AM","3:00AM","4:00AM","5:00AM","6:00AM","7:00AM","8:00AM","9:00AM","10:00AM","11:00AM","12:00PM","1:00PM","2:00PM","3:00PM","4:00PM","5:00PM","6:00PM","7:00PM","8:00PM","9:00PM","10:00PM","11:00PM");


$timeArray=array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24");

for ($i=1; $i<count($timeArray);$i++)
{
			//echo $i."<br>";
			//str.="";
	echo "<tr bgcolor=".$bgcolor."><td colspan='8' valign='top'>Time :".$timeNames[$i];
	//echo "<table width='80%' style='margin-top:0px;margin-left:100px;' >";
	
	$sql="SELECT DISTINCT h.leads_id,l.fname,l.lname,h.actions,DATE_FORMAT(date_created,'%D %M %Y'),h.history
		FROM history h JOIN leads l ON l.id = h.leads_id
		WHERE DATE_FORMAT(date_created,'%D %M %Y') = '$date2'
		AND
		HOUR(date_created)= $i 
		AND
		h.agent_no =1 ORDER BY date_created DESC;";
	$result=mysql_query($sql);
	$ctr=@mysql_num_rows($result);
	if ($ctr >0 )
	{
	echo "<table width='80%' style='margin-top:0px;margin-left:100px;' >";
	echo "<tr ><td width='3%' align=left></td>
		  <td width='20%' align=left><b>Name</b></td>
		  <td width='20%' align=left><b>Actions</b></td>
		  <td width='44%' colspan='2' align=left><b>Full Details</b></td></tr>";
	$counter=0;
	while(list($leads_id,$fname,$lname,$act,$d,$history) = mysql_fetch_array($result))	
	{	$counter=$counter+1;
	
	   echo "<tr>
			 <td>".$counter.")&nbsp;</td>
			 <td align='left'><a href='#' onClick=javascript:popup_win('./viewLead.php?id=$leads_id',600,600);>".$fname." ".$lname."</a></td>
			 <td align='left'>".$act."</td>
			 <td colspan='3' align='left'>".$history."</td>
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
<?
}
?>




<?
if($this_day!="" && $this_day=="TRUE")
{

$sqlDay="SELECT DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL 0 DAY),'%W'),DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL 0 DAY),'%e'),
DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL 0 DAY),'%D %M %Y')";
//echo "<p>".$sqlDay."</p>";
$result=mysql_query($sqlDay);
list($dayname,$date,$date2)=mysql_fetch_array($result);

?>
<table width='100%' class='tablecontent'>
<tr bgcolor='#666666'>
<td width='10%' align=left colspan="8"><b><font size='1' color='#FFFFFF'><? echo $dayname." ".$date2;?></font></b></td>
</tr>
<?
$timeNames=array("-","1:00AM","2:00AM","3:00AM","4:00AM","5:00AM","6:00AM","7:00AM","8:00AM","9:00AM","10:00AM","11:00AM","12:00PM","1:00PM","2:00PM","3:00PM","4:00PM","5:00PM","6:00PM","7:00PM","8:00PM","9:00PM","10:00PM","11:00PM");


$timeArray=array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24");

for ($i=1; $i<count($timeArray);$i++)
{
			//echo $i."<br>";
			//str.="";
	echo "<tr bgcolor=".$bgcolor."><td colspan='8' valign='top'>Time :".$timeNames[$i];
	

	$sql="SELECT DISTINCT h.leads_id,l.fname,l.lname,h.actions,DATE_FORMAT(date_created,'%D %M %Y'),h.history
		FROM history h JOIN leads l ON l.id = h.leads_id
		WHERE DATE_FORMAT(date_created,'%D %M %Y') = '$date2'
		AND
		HOUR(date_created)= $i 
		AND
		h.agent_no =1 ORDER BY date_created DESC;";
	$result=mysql_query($sql);
	$ctr=@mysql_num_rows($result);
	if ($ctr >0 )
	{
	echo "<table width='80%' style='margin-top:0px;margin-left:100px;' >";
	echo "<tr ><td width='3%' align=left></td>
		  <td width='20%' align=left><b>Name</b></td>
		  <td width='20%' align=left><b>Actions</b></td>
		  <td width='44%' colspan='2' align=left><b>Full Details</b></td></tr>";
	$counter=0;
	while(list($leads_id,$fname,$lname,$act,$d,$history) = mysql_fetch_array($result))	
	{	$counter=$counter+1;
	
	   echo "<tr>
			 <td>".$counter.")&nbsp;</td>
			 <td align='left' width='20%'><a href='#' onClick=javascript:popup_win('./viewLead.php?id=$leads_id',600,600);>".$fname." ".$lname."</a></td>
			 <td align='left' width='20%'>".$act."</td>
			 <td align='left' width='50%'>".$history."</td>
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

	
<?	
}
?>
<br>

</td></tr>


</table></td></tr></table>
				</td></tr>
		</table>
		</td>
		<td valign="top">&nbsp;</td>
	</tr>
</table>
	<!-- /CONTENT -->
	<br>
	
</form>	
</body>
</html>
