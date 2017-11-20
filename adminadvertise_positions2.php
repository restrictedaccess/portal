<?
include 'config.php';
include 'conf.php';
include 'time.php';
$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
/*
admin_id, admin_fname, admin_lname, admin_email, admin_password, admin_created_on, status
*/
$sql="SELECT * FROM admin WHERE admin_id=$admin_id;";

$resulta=mysql_query($sql);
$ctr=@mysql_num_rows($resulta);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($resulta); 
	$name = $row['admin_lname'].",  ".$row['admin_fname'];
	
}


$monthArray=array("","1","2","3","4","5","6","7","8","9","10","11","12");
$monthName=array("-","January","February","March","April","May","June","July","August","September","October","November","December");
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
<title>Administrator - Advertise Positions</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">

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
<? if ($admin_status=="FULL-CONTROL") {?>
<ul class="glossymenu">
 <li ><a href="adminHome.php"><b>Home</b></a></li>
  <li class="current"><a href="adminadvertise_positions.php"><b>Applications</b></a></li>
  <li><a href="admin_advertise_list.php"><b>Advertisements</b></a></li>
  <li ><a href="adminnewleads.php"><b>New Leads</b></a></li>
  <li><a href="admincontactedleads.php"><b>Contacted Leads</b></a></li>
  <li><a href="adminclient_listings.php"><b>Clients</b></a></li>
  <li><a href="adminscm.php"><b>Sub-Contractor Management</b></a></li>
  <li ><a href='subconlist.php'><b>List of Sub-Contractors</b></a></li>
</ul>
<? } else { 
echo "<ul class='glossymenu'>
 <li ><a href='adminHome.php'><b>Home</b></a></li>
  <li class='current'><a href='adminadvertise_positions.php'><b>Applications</b></a></li>
  <li><a href='admin_advertise_list.php'><b>Advertisements</b></a></li>
  <li><a href='adminclient_listings.php'><b>Clients</b></a></li>
  <li><a href='adminscm.php'><b>Sub-Contractor Management</b></a></li>
  <li ><a href='subconlist.php'><b>List of Sub-Contractors</b></a></li>
</ul>";
}
?>
<!-- ADVANCED SEARCH FOR APPLICANTS -->
<table width="100%">
<TR><TD colspan="3">
<div class="animatedtabs">
<ul>
<li ><a href="adminadvertise_positions.php" title="Registered Applicants Search"><span>Registered Applicants Search</span></a></li>
<li class="selected"><a href="adminadvertise_positions2.php" title="Recruitment Process"><span>Recruitment Process</span></a></li>
</ul>
</div>

</TD></TR>
</table>

<!-- ADVANCED SEARCH FOR APPLICANTS ENDS HERE -->
<table width=100% cellspacing=0 cellpadding=0 align=center>
<tr><td><br><b>Advertise Positions</b><br><br></td></tr>
<tr><td><br>
Click on a Applicants below to process  applications.<br>
<br>
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

/*$query="SELECT DISTINCT l.id , l.fname,l.lname
		FROM posting p JOIN applicants a ON a.posting_id =p.id JOIN leads l ON l.id =p.lead_id  GROUP BY p.id ORDER BY l.fname ASC;";
*/
$query="SELECT DISTINCT (l.id) , l.fname,l.lname
FROM leads l
JOIN posting p ON l.id =p.lead_id
JOIN applicants a ON a.posting_id =p.id
WHERE p.status ='ACTIVE'
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
<td colspan="5" align=center valign="middle" style="border-bottom:#666666 solid 1px;"><b><a href="#" onClick="javascript:popup_win('./viewLead.php?id=<? echo $lead_id;?>',600,600);">
<? echo $fname." ".$lname;?></a></b></td>
<td colspan="5" align=left valign="top" style="border-bottom:#666666 solid 1px;">
<!-- -->
<table width=100% class="tablecontent" cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr >
<td width='4%' height="20" align=left>#</td>
<td width='8%' align=left><b><font size='1'>Posting Date</font></b></td>
<td width='25%' align=left><b><font size='1'>Position</font></b></td>
<td width='16%' align=center><b><font size='1'>Unprocessed Applications</font></b></td>
<td width='11%' align=center><b><font size='1'>Prescreened </font></b></td>
<td width='10%' align=center><b><font size='1'>Short Listed</font></b></td>
<td width='7%' align=center><b><font size='1'>Hired</font></b></td>
<td width='12%' align=center><b><font size='1'>Kept for Reference</font></b></td>
<td width='7%' align=center><b><font size='1'>Rejected</font></b></td>
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
	<td width='4%' height="20" align=left><? echo $counter;?>)</td>
	<td width='8%' align=left><font size='1'><? echo $date;?></font></td>
	<td width='25%' align=left><font size='1'>
	<a href='#'  onClick= "javascript:popup_win('./ads2.php?id=<? echo $pid;?>',800,500);">
	<? echo $job;?>	</a>
	</font></td>
	<?
	//////////
	$sql="SELECT * FROM applicants a JOIN personal u ON u.userid = a.userid WHERE a.posting_id = $pid AND a.status ='Unprocessed';";
	$res1 = mysql_query ($sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysql_error());	
	$unprocessed=@mysql_num_rows($res1);
	//////////
	$sql2="SELECT * FROM applicants a JOIN personal u ON u.userid = a.userid WHERE a.posting_id = $pid AND a.status ='Prescreened';";
	$res2 = mysql_query ($sql2) or trigger_error("Query: $sql2\n<br />MySQL Error: " . mysql_error());	
	$prescreened=@mysql_num_rows($res2);
	
	//////////
	$sql3="SELECT * FROM applicants a JOIN personal u ON u.userid = a.userid WHERE a.posting_id = $pid AND a.status ='Hired';";
	$res3 = mysql_query ($sql3) or trigger_error("Query: $sql3\n<br />MySQL Error: " . mysql_error());	
	$hired=@mysql_num_rows($res3);
	//////////
	$sql4="SELECT * FROM applicants a JOIN personal u ON u.userid = a.userid WHERE a.posting_id = $pid AND a.status ='Kept for Referenced';";
	$res4 = mysql_query ($sql4) or trigger_error("Query: $sql4\n<br />MySQL Error: " . mysql_error());	
	$kept_for_reference=@mysql_num_rows($res4);
	//////////
	$sql5="SELECT * FROM applicants a JOIN personal u ON u.userid = a.userid WHERE a.posting_id = $pid AND a.status ='Shortlisted';";
	$res5 = mysql_query ($sql5) or trigger_error("Query: $sql5\n<br />MySQL Error: " . mysql_error());	
	$short_listed=@mysql_num_rows($res5);
	//////////
	$sql6="SELECT * FROM applicants a JOIN personal u ON u.userid = a.userid WHERE a.posting_id = $pid AND a.status ='Rejected';";
	$res6 = mysql_query ($sql6) or trigger_error("Query: $sql6\n<br />MySQL Error: " . mysql_error());	
	$rejected=@mysql_num_rows($res6);
	?>
	<td width='16%' align=center><font size='1'>
    <a href="adminrecruitment.php?pid=<? echo $pid;?>&id=<? echo $lead_id;?>&stat=Unprocessed">
	<? echo $unprocessed;?></a></font></td>
	<td width='11%' align=center><font size='1'>
	 <a href="adminrecruitment.php?pid=<? echo $pid;?>&id=<? echo $lead_id;?>&stat=Prescreened">
	<? echo $prescreened;?></a></font></td>
	<td width='10%' align=center><font size='1'>
	<a href="adminrecruitment.php?pid=<? echo $pid;?>&id=<? echo $lead_id;?>&stat=Shortlisted">
	<? echo $short_listed;?></a></font></td>
	<td width='7%' align=center><font size='1'>
	<a href="adminrecruitment.php?pid=<? echo $pid;?>&id=<? echo $lead_id;?>&stat=Hired">
	<? echo $hired;?></a></font></td>
	<td width='12%' align=center><font size='1'>
	<a href="adminrecruitment.php?pid=<? echo $pid;?>&id=<? echo $lead_id;?>&stat=Kept for Referenced">
	<? echo $kept_for_reference;?></a></font></td>
	<td width='7%' align=center><font size='1'>
	<a href="adminrecruitment.php?pid=<? echo $pid;?>&id=<? echo $lead_id;?>&stat=Rejected">
	<? echo $rejected;?></a></font></td>
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
