<?
include '../config.php';
include '../function.php';
include '../conf.php';
include '../time.php';
$agent_no = $_SESSION['agent_no'];
$leads_id=$_REQUEST['id'];


/*
id, tracking_no, timestamp, status, weight, call_time_preference, remote_staff_competences, remote_staff_needed, remote_staff_needed_when, remote_staff_one_office, your_questions, lname, fname, company_position, company_name, company_address, email, website, officenumber, mobile, company_description, company_industry, company_size, outsourcing_experience, outsourcing_experience_description, company_turnover, referal_program
*/
$query ="SELECT * FROM leads WHERE id = $leads_id;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	//$row = mysql_fetch_array ($result, MYSQL_NUM); 
	$row = mysql_fetch_array($result);

	$tracking_no =$row['tracking_no'];
	$timestamp =$row['timestamp'];
	$status =$row['status'];
	$call_time_preference =$row['call_time_preference'];
	$remote_staff_competences =$row['remote_staff_competences'];
	$remote_staff_needed =$row['remote_staff_needed'];
	$remote_staff_needed_when =$row['remote_staff_needed_when'];
	$remote_staff_one_office =$row['remote_staff_one_office'];
	$your_questions =$row['your_questions'];
		
	$lname =$row['lname'];
	$fname =$row['fname'];
	$company_position =$row['company_position'];
	$company_name =$row['company_name'];
	$company_address =$row['company_address'];
	$email =$row['email'];
	$website =$row['website'];
	$officenumber =$row['officenumber'];
	$mobile =$row['mobile'];
	$company_description =$row['company_description'];
	$company_industry =$row['company_industry'];
	$company_size =$row['company_size'];
	$outsourcing_experience =$row['outsourcing_experience'];
	$outsourcing_experience_description =$row['outsourcing_experience_description'];
	$company_turnover =$row['company_turnover'];
	$referal_program =$row['referal_program'];
	
	$your_questions=str_replace("\n","<br>",$your_questions);
$rate =$row['rating'];
	$personal_id =$row['personal_id'];
	if($rate=="1")
		{
			$rate="<img src='../images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="2")
		{
			$rate="<img src='../images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="3")
		{
			$rate="<img src='../images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="4")
		{
			$rate="<img src='../images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="5")
		{
			$rate="<img src='../images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='../images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
	
	
}
?>

<html>
<head>
<title>Business Partner Job Advertisement Process</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../css/style.css">
<link rel=stylesheet type=text/css href="../menu.css">

<script type='text/javascript' language='JavaScript' src='../js/common_funcs.js'></script>
<script type='text/javascript' language='JavaScript' src='../js/form_utils.js'></script>

<script type="text/javascript">
<!--
function checkFields()
{
	
	missinginfo = "";
	if(document.form.outsourcing_model[0].checked==false && document.form.outsourcing_model[1].checked==false && document.form.outsourcing_model[2].checked==false)
	{
		missinginfo += "\n     -  Please choose ousourcing type.";
	}
	// companyname jobposition jobvacancy_no skill responsibility
	if(document.form.companyname.value=="")
	{
		missinginfo += "\n     -  Please enter company name.";
	}
	
	if(document.form.jobposition.value=="")
	{
		missinginfo += "\n     -  Please enter Job title / position.";
	}
	
	if(document.form.jobvacancy_no.value=="")
	{
		missinginfo += "\n     -  Please enter number of Job vacancy.";
	}
	
	if(document.form.skill.value=="")
	{
		missinginfo += "\n     -  Please enter skills or requirements.";
	}
	
	if(document.form.responsibility.value=="")
	{
		missinginfo += "\n     -  Please enter applicants responsibility.";
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

function set()
{
	
	//document.form.set.value="Add";	
	alert ("asd");		
	
}
-->
</script>	
<style type="text/css">
<!--
	div.scroll {
		height: 100px;
		width: 100%;
		overflow: auto;
		border: 1px solid #CCCCCC;
		padding: 8px;
		
	}
	.scroll p{
		margin-bottom: 10px;
		margin-top: 4px;
	}
	.spanner
	{
		float: right;
		text-align: right;
		padding:5px 0 5px 10px;
	
	
	}
	.spannel
	{
		float: left;
		text-align:left;
		padding:5px 0 5px 10px;
		border:#f2cb40 solid 1px;
		
	}	
	#l {
	float: left;
	width: 390px;
	text-align:left;
	padding:5px 0 5px 10px;
	
	
	}	

#r{
	float: right;
	width: 100px;
	text-align: right;
	padding:5px 0 5px 10px;
	
	
	}
-->
</style>	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="jobpostingsphp.php"  onsubmit="return checkFields();">
<input type="hidden" name="id" value="<? echo $leads_id;?>">
<input type="hidden" name="agent_no" value="<? echo $agent_no;?>">


<script language=javascript src="../js/functions.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
  <li ><a href="agentHome.php"><b>Home</b></a></li>
  <li><a href="advertise_positions.php"><b>Applications</b></a></li>
  <li ><a href="newleads.php"><b>New Leads</b></a></li>
  <li ><a href="contactedleads.php"><b>Contacted Leads</b></a></li>
  <li class="current"><a href="../client_listings.php"><b>Clients</b></a></li>
  <li><a href="scm.php"><b>Sub-Contractor Management</b></a></li>
</ul>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
  <tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr><td width="220" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='../images/space.gif' width=1 height=10>
<br clear=all>
<? include 'agentleftnav.php';?>
<br>
</td>
<td width=100% valign=top >
<table width=100%  border=0 align=left cellpadding=2 cellspacing=8 >
<tr>
<td valign="bottom">
<div class="animatedtabs">
<ul>
<li ><a href="../client_workflow.php?id=<? echo $leads_id;?>" title="Client <? echo $fname." ".$lname;?>"><span>Client</span></a></li>
<li ><a href="../client_account.php?id=<? echo $leads_id;?>" title="Client Account"><span>Client Account</span></a></li>
<li ><a href="../jobpostings.php?id=<? echo $leads_id;?>" title="Recruiting Preparation"><span>Recruitment Preparation</span></a></li>
<li class="selected"><a href="../recruitment_1.php?id=<? echo $leads_id;?>" title="Recruiting Process"><span>Recruitment Process Done by HR</span></a></li>
</ul>
</div></td>
</tr>



<tr>
  <td width=100% bgcolor=#DEE5EB colspan=2><b>Job Advertisement Process </b></td>
</tr>
<tr><td height="100%" colspan=2 valign="top" >
<!-- Clients Details starts here -->
<!-- Clients Details starts here -->
<table width="100%" style="margin-left:10px;" >
<tr>
<td colspan="3">
<? if ($rate!="") {echo "<h4>Client Rate :&nbsp;" .$rate."</h4>"; }?></p></td>
</tr>
<tr>
<td ><b>Client ID </b></td><td>:</td>
<td><? echo $personal_id;?></td>
</tr>
<tr>
<td width="14%" ><b>Client </b></td><td>:</td>

<td width="86%"><? echo $fname." ".$lname;?></td>
</tr>
<tr>
<td ><b>Date Registered	</b></td><td>:</td>
<td><? echo format_date($timestamp);?></td>
</tr>
<tr>
<td ><b>Email </b></td><td>:</td>
<td><? echo $email;?></td>
</tr>
<tr>
</table>
<!-- Clients Details ends here -->
<!-- Clients Details ends here -->

</td>
</tr>
<tr>
  <td width=100% bgcolor=#DEE5EB colspan=2><b>Client Applicants</b></td>
</tr>
<tr>
<td colspan="2">
<?
$counter = 0;

$query="SELECT p.id,DATE_FORMAT(p.date_created,'%D %b %Y '), p.companyname, jobposition
		FROM posting p JOIN applicants a ON a.posting_id =p.id WHERE p.agent_id = $agent_no AND p.lead_id =$leads_id AND p.status='ACTIVE' GROUP BY p.id";
		
//echo $query;		
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
//if ($ctr >0 )
//{
?>
<table width=100% cellspacing=0 cellpadding=0 align=center>
<tr><td><br>
<b>Advertise Positions</b><br><br>
</td></tr>


<tr><td bgcolor=#333366 height=5>
</td></tr>
<tr><td>
<table width=100% class="tablecontent" cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#DEE5EB>
<tr bgcolor='#666666'>
<td width='4%' height="20" align=left><font size='1' color="#FFFFFF"><b>#</b></font></td>
<td width='11%' align=left><b><font size='1' color="#FFFFFF">Posting Date</font></b></td>
<td width='18%' align=left><b><font size='1' color="#FFFFFF">Company</font></b></td>
<td width='19%' align=left><b><font size='1' color="#FFFFFF">Position</font></b></td>
<td width='8%' align=center><b><font size='1' color="#FFFFFF">Unprocessed Applications</font></b></td>
<td width='8%' align=center><b><font size='1' color="#FFFFFF">Invited for Interview</font></b></td>
<td width='7%' align=center><b><font size='1' color="#FFFFFF">Prescreened </font></b></td>
<td width='7%' align=center><b><font size='1' color="#FFFFFF">Short Listed</font></b></td>
<td width='6%' align=center><b><font size='1' color="#FFFFFF">Hired</font></b></td>
<td width='6%' align=center><b><font size='1' color="#FFFFFF">Kept for Reference</font></b></td>
<td width='6%' align=center><b><font size='1' color="#FFFFFF">Rejected</font></b></td>
</tr>
<?
	$bgcolor="#FFFFFF";
	while(list($pid,$date,$company,$job) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
	
?>
	<tr bgcolor=<? echo $bgcolor;?>>
	<td width='4%' height="20" align=left><? echo $counter;?>)</td>
	<td width='11%' align=left><font size='1'><? echo $date;?></font></td>
	<td width='18%' align=left><font size='1'><? echo $company;?></font></td>
	<td width='19%' align=left><font size='1'><a href='#' onClick= "javascript:popup_win('./ads2.php?id=<? echo $pid;?>',700,700);"><? echo $job;?></a></font></td>
	<?
	//////////
	$sql="SELECT COUNT(status)AS numrow FROM applicants a WHERE a.posting_id = $pid AND a.status ='Unprocessed';";
	$res1 = mysql_query ($sql);	
	//$row = mysql_fetch_array($res1);
	list($unprocessed) = mysql_fetch_array($res1);
	//////////
	$sql2="SELECT COUNT(status)AS numrow FROM applicants a WHERE a.posting_id = $pid AND a.status ='Prescreened';";
	$res2 = mysql_query ($sql2);	
	list($prescreened) = mysql_fetch_array($res2);
	
	//////////
	$sql3="SELECT COUNT(status)AS numrow FROM applicants a WHERE a.posting_id = $pid AND a.status ='Hired';";
	$res3 = mysql_query ($sql3);	
	list($hired) = mysql_fetch_array($res3);
	//////////
	$sql4="SELECT COUNT(status)AS numrow FROM applicants a WHERE a.posting_id = $pid AND a.status ='Kept for Referenced';";
	$res4 = mysql_query ($sql4);	
	list($kept_for_reference) = mysql_fetch_array($res4);
	//////////
	$sql5="SELECT COUNT(status)AS numrow FROM applicants a WHERE a.posting_id = $pid AND a.status ='Shortlisted';";
	$res5 = mysql_query ($sql5);	
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
	$sql6="SELECT COUNT(status)AS numrow FROM applicants a WHERE a.posting_id = $pid AND a.status ='Rejected';";
	$res6 = mysql_query ($sql6);	
	list($rejected) = mysql_fetch_array($res6);
	////// Invite to Interview
	$sql7="SELECT COUNT(status)AS numrow FROM applicants a WHERE a.posting_id = $pid AND a.status ='Invite to Interview';";
	$res7 = mysql_query ($sql7);	
	list($invite) = mysql_fetch_array($res7);
	?>
	<td width='8%' align=center><font size='1'><? echo $unprocessed;?></font></td>
	<td width='8%' align=center><font size='1'><? echo $invite;?></font></td>
	<td width='7%' align=center><font size='1'><? echo $prescreened;?></font></td>
	<td width='7%' align=center><font size='1'>
	<? 
	echo $short_listed."&nbsp;&nbsp;";
	$sum=$short_listed2+$short_listed3;
	if($sum > 0)
	{
	?>
	<a href='javascript: show_hide("reply_form<? echo $counter;?>");'><img src="../images/groupofusers16.png" alt="<? echo $sum;?> Viewable Applicants" align="absmiddle" border="0"></a>
	
	<?	
	}
		
	?>
	</font></td>
	<td width='6%' align=center><font size='1'><? echo $hired;?></font></td>
	<td width='6%' align=center><font size='1'><? echo $kept_for_reference;?></font></td>
	<td width='6%' align=center><font size='1'><? echo $rejected;?></font></td>
	</tr>
	<tr><td colspan="11"></td></tr>
	<tr><td colspan="11">
	<div id='reply_form<? echo $counter;?>' style='display:none;'><br>
	<?
	$queryApplicants="SELECT u.userid, u.fname, u.lname ,a.show_agent 
					  FROM personal u JOIN applicants a ON a.userid = u.userid
					  WHERE a.posting_id = $pid AND a.status ='Shortlisted';";
	//echo $queryApplicants;
	$resulta=mysql_query($queryApplicants);
	while(list($userid,$fname,$lname,$show) = mysql_fetch_array($resulta))
	{
		if ($show=="SHOW") {
		echo "<p><b><a href='#' class='link5' onClick="."javascript:popup_win('./resumeShow.php?userid=$userid',800,500);".">".$fname." ".$lname."</b></p>";
		}
		if ($show=="FULL DETAILS") {
		echo "<p><b><a href='#' class='link5' onClick="."javascript:popup_win('./resumeShowFull.php?userid=$userid',800,500);".">".$fname." ".$lname."</b></p>";
		}
	}

	?>
	</div></td></tr>

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
	</td></tr>
	<tr><td bgcolor=#333366 height=1>
<img src='../images/space.gif' height=1 width=1></td></tr></table>
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

</td>
</tr>
</table>
</td>
</tr>
</table>
	<!-- /CONTENT -->
<? include 'footer.php';?>
	
</form>	
</body>
</html>
