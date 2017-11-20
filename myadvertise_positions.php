<?
include 'config.php';
include 'conf.php';
include 'time.php';

$client_id = $_SESSION['client_id'];
/*
admin_id, admin_fname, admin_lname, admin_email, admin_password, admin_created_on, status
*/


?>

<html>
<head>
<title>Client - Advertise Positions</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<script type="text/javascript">
<!--
function checkFields()
{
	if (confirm("Are you sure"))
	{
		return true;
	}
	else return false;		
	//alert (document.frmSkills.skill.value);
	
	//missinginfo = "";
	//if (missinginfo != "")
	//{
	//	missinginfo =" " + "You failed to correctly fill in the required information:\n" +
	//	missinginfo + "\n\n";
	//	alert(missinginfo);
	//	return false;
	//}
	//else return true;

	
}
-->
</script>	
	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" action="adminadvertise_positions.php" >

<script language=javascript src="js/functions.js"></script>
<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
  <li ><a href="clientHome.php"><b>Home</b></a></li>
  <li class="current"><a href="myadvertise_positions.php"><b>Applications</b></a></li>
  <li><a href="myadvertisement.php"><b>Advertisements</b></a></li>
  <li><a href="myscm.php"><b>Sub-Contractor Management</b></a></li>
</ul>
<table width="100%">
<TR><TD colspan="3">
<!-- TAB -->
</TD></TR>
</table>

<!-- ADVANCED SEARCH FOR APPLICANTS ENDS HERE -->
<table width=100% cellspacing=0 cellpadding=0 align=center>
<tr><td><br><b>Advertise Positions</b><br><br></td></tr>
<tr><td>&nbsp;
</td></tr>
<tr><td>

<table width=100% class="tablecontent" cellspacing=01 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr bgcolor="#666666" >
<td colspan="5" align=center><b><font color="#FFFFFF" size='1'>CLIENTS</font></b></td>
<td width="41%" colspan="0" align=center><b><font color="#FFFFFF" size='1'>JOB ADVERTISEMENTS</font></b></td>
<td width="50%" colspan="4" align=center><b><font color="#FFFFFF" size='1'>APPLICANTS</font></b></td>
</tr>
<?
$counter = 0;

$query="SELECT DISTINCT l.id , l.fname,l.lname
		FROM posting p JOIN applicants a ON a.posting_id =p.id JOIN leads l ON l.id =p.lead_id
		WHERE l.id = $client_id
		GROUP BY p.id ORDER BY l.fname ASC;";
		
//echo $query;		
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);

$bgcolor="#FFFFFF";
while(list($lead_id,$fname,$lname) = mysql_fetch_array($result))
{
	$counter=$counter+1;
	
?>
<tr bgcolor=<? echo $bgcolor;?>>
<td colspan="5" align=center valign="middle" style="border-bottom:#666666 solid 1px;"><b>
<? echo $fname." ".$lname;?></b></td>
<td colspan="5" align=left valign="top" style="border-bottom:#666666 solid 1px;">
<!-- -->
<table width=100% class="tablecontent" cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr >
<td width='2%' height="20" align=left>#</td>
<td width='10%' align=left><b><font size='1'>Posting Date</font></b></td>
<td width='15%' align=left><b><font size='1'>Company</font></b></td>
<td width='16%' align=left><b><font size='1'>Position</font></b></td>
<td width='15%' align=center><b><font size='1'>Unprocessed Applications</font></b></td>
<td width='10%' align=center><b><font size='1'>Prescreened </font></b></td>
<td width='9%' align=center><b><font size='1'>Short Listed</font></b></td>
<td width='6%' align=center><b><font size='1'>Hired</font></b></td>
<td width='11%' align=center><b><font size='1'>Kept for Reference</font></b></td>
<td width='6%' align=center><b><font size='1'>Rejected</font></b></td>
</tr>
<?
$counter = 0;

$query2="SELECT p.id,DATE_FORMAT(p.date_created,'%D %b %Y '), p.companyname, jobposition 
		FROM posting p  WHERE  p.lead_id=$lead_id AND p.status='ACTIVE' GROUP BY p.id ORDER BY p.date_created DESC;";
		
//echo $query2;		
$result2=mysql_query($query2);
//$ctr=@mysql_num_rows($result);
?>
<?
	$bgcolor="#FFFFFF";
	while(list($pid,$date,$company,$job) = mysql_fetch_array($result2))
	{
		$counter=$counter+1;
	
?>
	<tr bgcolor=<? echo $bgcolor;?>>
	<td width='2%' height="20" align=left><? echo $counter;?></td>
	<td width='10%' align=left><font size='1'><? echo $date;?></font></td>
	<td width='15%' align=left><font size='1'><? echo $company;?></font></td>
	<td width='19%' align=left><font size='1'>
	<a href='#'  onClick= "javascript:popup_win('./ads2.php?id=<? echo $pid;?>',800,500);">
	<? echo $job;?>	</a>
	</font></td>
	<?
	//////////
	$sql="SELECT COUNT(status)AS numrow FROM applicants a WHERE a.posting_id = $pid AND a.status ='Unprocessed';";
	$res1 = mysql_query ($sql) or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
	//$row = mysql_fetch_array($res1);
	list($unprocessed) = mysql_fetch_array($res1);
	//////////
	$sql2="SELECT COUNT(status)AS numrow FROM applicants a WHERE a.posting_id = $pid AND a.status ='Prescreened';";
	$res2 = mysql_query ($sql2) or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
	list($prescreened) = mysql_fetch_array($res2);
	
	//////////
	$sql3="SELECT COUNT(status)AS numrow FROM applicants a WHERE a.posting_id = $pid AND a.status ='Hired';";
	$res3 = mysql_query ($sql3) or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
	list($hired) = mysql_fetch_array($res3);
	//////////
	$sql4="SELECT COUNT(status)AS numrow FROM applicants a WHERE a.posting_id = $pid AND a.status ='Kept for Reference';";
	$res4 = mysql_query ($sql4) or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
	list($kept_for_reference) = mysql_fetch_array($res4);
	//////////
	$sql5="SELECT COUNT(status)AS numrow FROM applicants a WHERE a.posting_id = $pid AND a.status ='Shortlisted';";
	$res5 = mysql_query ($sql5) or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
	list($short_listed) = mysql_fetch_array($res5);
	//////////
	$sql6="SELECT COUNT(status)AS numrow FROM applicants a WHERE a.posting_id = $pid AND a.status ='Rejected';";
	$res6 = mysql_query ($sql6) or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
	list($rejected) = mysql_fetch_array($res6);
	?>
	<td width='13%' align=center><font size='1'><? echo $unprocessed;?></a></font></td>
	<td width='9%' align=center><font size='1'><? echo $prescreened;?></a></font></td>
	<td width='9%' align=center><font size='1'><? echo $short_listed;?></a></font></td>
	<td width='6%' align=center><font size='1'><? echo $hired;?></a></font></td>
	<td width='11%' align=center><font size='1'><? echo $kept_for_reference;?></a></font></td>
	<td width='6%' align=center><font size='1'><? echo $rejected;?></a></font></td>
	</tr>
 <?
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
<!-- -->
</td>
</tr>

<? }?>



</table>
</td></tr>
<tr><td bgcolor=#333366 height=1>
<img src='images/space.gif' height=1 width=1></td></tr></table>
<script language=javascript>
<!--
	function go(id,name) 
	{
			//if (confirm("You selected " + name + " ?")) {
				location.href = "resume2.php?userid="+id;
				//alert(id);
			//}
		
	}
	
	
//-->
</script>

<? include 'footer.php';?>	
</form>
</body>
</html>
