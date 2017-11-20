<?php
include('conf/zend_smarty_conf_root.php');
include 'config.php';
include 'function.php';
include 'conf.php';
$agent_no = $_SESSION['agent_no'];
if($_SESSION['agent_no']==NULL)
{
	header("location:index.php");
}

$leads_id=$_REQUEST['leads_id'];
header("location:/portal/django/service_agreement/lead/$leads_id");
exit;

$url=$_REQUEST['url'];

$tab = $_REQUEST['tab'];

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
	$remote_staff_one_home =$row['$remote_staff_one_home'];
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
	$your_questions=str_replace("\n","<br>",$your_questions);
	$outsourcing_experience_description=str_replace("\n","<br>",$outsourcing_experience_description);
	$company_description=str_replace("\n","<br>",$company_description);
	$rate =$row['rating'];
	$personal_id =$row['personal_id'];
	// Newly added
	$leads_country = $row['leads_country'];
	$leads_ip = $row['leads_ip'];
	if($rate=="1")
	{
		$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
	}
	if($rate=="2")
	{
		$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
	}
	if($rate=="3")
	{
		$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
	}
	if($rate=="4")
	{
		$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
	}
	if($rate=="5")
	{
		$rate="<img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.png' align='top' alt='$rate&nbsp;&nbsp;star'>";
	}
}

?>
<html>
<head>
<title>Business Partner Service Agreement</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="service_agreements/quote.css">
<script language=javascript src="js/functions.js"></script>
<script type="text/javascript" src="service_agreements/quote.js"></script>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data"  onsubmit="return checkFields();">
<input type="hidden" name="leads_id" id="leads_id" value="<?php echo $leads_id;?>">
<input type="hidden" name="agent_no" value="<?php echo $agent_no;?>">
<!-- HEADER -->
<?php include 'header.php';?>
<?php include 'BP_header.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr><td width="173" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<?php include 'agentleftnav.php';?>
</td>
<td valign=top align=left>
<table width="100%">
<tr>
<td width="32%" valign="top" >
<div style="padding:5px;">
<?php if ($url!="") {?>
	<input type="button" class="btn" value="Back" onClick="self.location='<?php echo $url;?>&lead_status=<?php echo $_GET['lead_status'];?>'"/>
<?php } ?>
</div>
<div id="quote_list">Loading</div>
</td>
<td width="68%" valign="top">
<div style="font:12px Arial;">

<div style="padding:5PX; background:#E1E4F0; border:#E1E4F0 ridge 2px; color:#333333; text-align:center;"><B>SERVICE AGREEMENT &amp; CONTRACT FORM</B></div>
<div id="right_panel" style="border:#E1E4F0 ridge 2px;">
<div style="padding:5PX;  margin-top:5px; ">
	<div style="text-align:center;">
		<p><b style="color:#FF0000;">SCHEDULE 1</b></p>
		<p><b>PRO FORMA REQUEST FOR SERVICE</b></p>
	</div>
</div>
<div  style="margin-top:15px; padding:10px;">
		<p><label>Dated:</label>&nbsp;</p>
		<p><label>From:</label>&nbsp;</p>
		<p><label>Company:</label>&nbsp;</p>
		<p><label>ACN:</label>&nbsp;</p>
		<p><label>ABN:</label>&nbsp;</p>
		<p><label>Address:</label>&nbsp;</p>
		<p><label>Telephone:</label>&nbsp;</p>
		<p><label>Facsimile:</label>&nbsp;</p>
		<p><label>Email:</label>&nbsp;</p>
		<div style="margin-top:20px;">
			<p><b><label>TO:</label> Think Innovations- Remote Staff</b></p>
			<p>&nbsp;</p>
			<p><label>ABN:</label> 37-094-364-511</p>
			<p><label>Telephone:</label> (AUS) 1300 733 430 , +61 2 8090 3458 (UK) +44 208 816 7802 (USA) +1 415 376 1472</p>
			<p><label>Facsimile: </label>+61 2 8088 7247</p>
			<p><label>Email:</label> contracts@remotestaff.com.au</p>
			<p>&nbsp;</p>
			<p><b>SERVICES:</b></p>
			<p>Recruitment and compliance management of the following staff:</p>
		</div>
	</div>


</div>
</div>
</td>
</tr>
</table>
</td>
</tr>
</table>
<?php include 'footer.php';?>
<script type="text/javascript">
<!--
showLeadQuotes();
-->
</script>
</form>
</body>
</html>

