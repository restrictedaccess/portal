<?
include 'config.php';
include 'conf.php';
include 'time.php';
$agent_no = $_SESSION['agent_no'];
$mess="";
$mess=$_REQUEST['mess'];




?>

<html>
<head>
<title>Business Partner Advertise Positions</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
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


<script language=javascript src="js/functions.js"></script>
<script language=javascript src="js/cookie.js"></script>
<script language=javascript src="js/js2/functions.js"></script>
<script language=javascript src="js/js2/png.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
  <li ><a href="agentHome.php"><b>Home</b></a></li>
  <li class="current"><a href="advertise_positions.php"><b>Applications</b></a></li>
  <li ><a href="newleads.php"><b>New Leads</b></a></li>
  <li ><a href="follow_up_leads.php"><b>Follow Up</b></a></li>
  <li><a href="keep_in_touch_leads.php"><b>Keep in Touch</b></a></li>
  <li ><a href="client_listings.php"><b>Clients</b></a></li>
  <li><a href="scm.php"><b>Sub-Contractor Management</b></a></li>
</ul>

<?
$counter = 0;

$query="SELECT DISTINCT l.id , l.fname,l.lname
		FROM posting p JOIN applicants a ON a.posting_id =p.id JOIN leads l ON l.id =p.lead_id WHERE p.agent_id = $agent_no GROUP BY p.id";
		
//echo $query;		
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
?>
<table width=100% cellspacing=0 cellpadding=0 align=center>
<tr><td><br><b>Advertise Positions</b><br><br></td></tr>
<tr><td>
<table width=100% class="tablecontent" cellspacing=01 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr bgcolor="#666666" >
<td colspan="5" align=center><b><font color="#FFFFFF" size='1'>CLIENTS</font></b></td>
<td width="41%" colspan="0" align=center><b><font color="#FFFFFF" size='1'>JOB ADVERTISEMENTS</font></b></td>
<td width="50%" colspan="4" align=center><b><font color="#FFFFFF" size='1'>APPLICANTS</font></b></td>
</tr>
<?
	$bgcolor="#FFFFFF";
	while(list($lead_id,$fname,$lname) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
	
?>
<tr bgcolor=<? echo $bgcolor;?>>
<td colspan="5" align=center valign="middle" style="border-bottom:#666666 solid 1px;"><b><a href="recruitment_1.php?id=<? echo $lead_id;?>"><? echo $fname." ".$lname;?></a></b></td>
<td width='88%' colspan="5" align=left valign="top" style="border-bottom:#666666 solid 1px;">
<!-- -->
<table width=100% class="tablecontent" cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr >
<td width='3%' height="20" align=left>#</td>
<td width='10%' align=left><b><font size='1'>Posting Date</font></b></td>
<td width='29%' align=left><b><font size='1'>Position</font></b></td>
<td width='14%' align=center><b><font size='1'>Unprocessed Applications</font></b></td>
<td width='9%' align=center><b><font size='1'>Prescreened </font></b></td>
<td width='8%' align=center><b><font size='1'>Short Listed</font></b></td>
<td width='5%' align=center><b><font size='1'>Hired</font></b></td>
<td width='10%' align=center><b><font size='1'>Kept for Reference</font></b></td>
<td width='12%' align=center><b><font size='1'>Rejected</font></b></td>
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
	<td width='3%' height="20" align=left><? echo $counter;?>)</td>
	<td width='10%' align=left><font size='1'><? echo $date;?></font></td>

	<td width='29%' align=left><font size='1'>
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
	$sql8="SELECT COUNT(status)AS numrow FROM applicants a WHERE a.posting_id = $pid AND a.status ='Shortlisted' AND show_agent ='SHOW';";
	$res8 = mysql_query ($sql8);
	//echo $sql8;	
	list($short_listed2) = mysql_fetch_array($res8);
	////////////
	$sql9="SELECT COUNT(status)AS numrow FROM applicants a WHERE a.posting_id = $pid AND a.status ='Shortlisted' AND show_agent ='FULL DETAILS';";
	$res9 = mysql_query ($sql9);
	//echo $sql9;	
	list($short_listed3) = mysql_fetch_array($res9);
	////////////
	//////////
	$sql6="SELECT COUNT(status)AS numrow FROM applicants a WHERE a.posting_id = $pid AND a.status ='Rejected';";
	$res6 = mysql_query ($sql6) or trigger_error("Query: $query\n<br />MySQL Error: " . mysql_error());	
	list($rejected) = mysql_fetch_array($res6);
	?>
	<td width='14%' align=center><font size='1'>
    <? echo $unprocessed;?></font></td>
	<td width='9%' align=center><font size='1'>
	 <? echo $prescreened;?></font></td>
	<td width='8%' align=center><font size='1'>
	<? echo $short_listed;?></font></td>
	<td width='5%' align=center><font size='1'>
		<? echo $hired;?></font></td>
	<td width='10%' align=center><font size='1'>
	<? echo $kept_for_reference;?></font></td>
	<td width='12%' align=center><font size='1'>
	<? echo $rejected;?></font></td>
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

	
<?	
}else{ echo "<font class='text1'>No Records to be shown.</font>"; }
?>

	
<? include 'footer.php';?>	
</body>
</html>
