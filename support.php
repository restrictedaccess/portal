<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';


include('class.php');

$passGen = new passGen(5);
$mess = $_REQUEST['mess'];

$agent_no = $_SESSION['agent_no'];
$userid = $_SESSION['userid'];
$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
$client_id = $_SESSION['client_id'];

$css="menu.css";
//echo "AGENTNO : ".$agent_no."<br>".
//	"APPLICANT : ".$userid."<BR>".  
//	"ADMIN : ".$admin_id;

if($agent_no=="" && $userid=="" && $admin_id=="" && $client_id=="")
{
	$menu="<ul class='glossymenu'>
  		   <li ><a href='index.php'><b>Home</b></a></li>
		   </ul>";

}
if($agent_no!=""){
	$menu ="<ul class='glossymenu'>
		  <li ><a href='agentHome.php'><b>Home</b></a></li>
		  <li><a href='advertise_positions.php'><b>Applications</b></a></li>
		  <li ><a href='advertisement.php'><b>Advertisements</b></a></li>
		  <li><a href='newleads.php'><b>New Leads</b></a></li>
		  <li><a href='contactedleads.php'><b>Contacted Leads</b></a></li>
		  <li><a href='client_listings.php'><b>Clients</b></a></li>
		  <li><a href='scm.php'><b>Sub-Contractor Management</b></a></li>
		  </ul>";
}
if($userid!="")
{
	$menu="<ul class='glossymenu'>
 <li><a href='applicantHome.php'><b>Home</b></a></li>
  <li><a href='myresume.php'><b>MyResume</b></a></li>
  <li><a href='#'><b>Applications</b></a></li>
  <li><a href='#'><b>Account Info</b></a></li>
  <li><a href='#'><b>Search Jobs</b></a></li>
</ul>";
}

if($client_id!="")
{
	$menu="<ul class='glossymenu'>
  <li class='current'><a href='clientHome.php'><b>Home</b></a></li>
  <li><a href='myadvertise_positions.php'><b>Applications</b></a></li>
  <li><a href='myadvertisement.php'><b>Advertisements</b></a></li>
  <li><a href='myscm.php'><b>Sub-Contractor Management</b></a></li>
</ul>
";
}

if($admin_id!="")
{	

	if ($admin_status=="FULL-CONTROL")
	{
		$menu ="<ul class='glossymenu'>
			 <li ><a href='adminHome.php'><b>Home</b></a></li>
			  <li><a href='adminadvertise_positions.php'><b>Applications</b></a></li>
			  <li><a href='admin_advertise_list.php'><b>Advertisements</b></a></li>
			  <li ><a href='adminnewleads.php'><b>New Leads</b></a></li>
			  <li><a href='admincontactedleads.php'><b>Contacted Leads</b></a></li>
			  <li><a href='adminclient_listings.php'><b>Clients</b></a></li>
			  <li><a href='adminscm.php'><b>Sub-Contractor Management</b></a></li>
			</ul>";
 	}
	
	if ($admin_status=="HR")
	{  
	 	$menu="<ul class='glossymenu'>
			 <li ><a href='adminHome.php'><b>Home</b></a></li>
			  <li><a href='adminadvertise_positions.php'><b>Applications</b></a></li>
			  <li><a href='admin_advertise_list.php'><b>Advertisements</b></a></li>
			  <li><a href='adminclient_listings.php'><b>Clients</b></a></li>
			  <li><a href='adminscm.php'><b>Sub-Contractor Management</b></a></li>
			</ul>";
	}

$css="adminmenu.css";
//echo $admin_status;
}



?>
<html>
<head>
<title>IT-Support Help Desk</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="<?=$css;?>">

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

<script type="text/javascript">
<!--
function checkFields()
{
	if(document.form.subject.value=="")
	{
		alert("Please enter a Topic!");
		document.form.subject.focus();
		return false;
	}
	if(document.form.message.value=="")
	{
		alert("Please enter a message!");
		document.form.message.focus();
		return false;
	}

	if(document.form.pass.value=="")
	{
		alert("Please enter validation code. See image");
		document.form.pass.focus();
		return false;
	}
	return true;	
}

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


<script language=javascript src="js/functions.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<?=$menu;?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>

<tr>
<td width="32%" valign="top" style="border-right: #006699 2px solid;">
<form method="POST" name="form" action="supportphp.php" onSubmit="return checkFields();">

<br>
<font color='#999999'>
Please state your Questions or Enquiries in the message box below.
</font><br>
<br>

<b>Topic :</b> <font color='#999999'>(Required)</font>
<p align='center' style='margin-bottom:10px; margin-top:10px;'><input type="text" name="subject" style="width:90%"></p>
<b>Message :</b> <font color='#999999'>(Required)</font>
<p align='center' style='margin-bottom:3px; margin-top:3px;'>
<textarea name='message' cols='50' rows='5' wrap='physical' class='text'  style='width:90%'></textarea>
</p>
<p>
<div align="center">
                       	     <input type="text" value="<?php if (!empty($pass)) { echo $pass; }?>" name="pass"  size="5" maxlength="5">
                       	     <?php  $rv = $passGen->password(0, 1); ?>
                       	     <input type="hidden" value="<?php  echo $rv ?>" name="rv">
                       	     <?php  echo $passGen->images('font', 'gif', 'f_', '20', '20'); ?><br />
                     	     <font color='#999999'>For validation, please type the numbers that you see</font><br />
							 <? if ($mess==2){echo "<font color='#FF0000'><b>Validation Code is Incorrect! Please type the correct Code.</b></font>";}?>
							 
</div>
</p>
<p align="center">
&nbsp;
<input type="submit" name="send" value="Send Message">
</p>
</form>	
</td>
<td width=68% valign=top >
<p><b>IT-Support Help Desk</b></p>
<? if($mess==3) {echo "<p><b>Your Message Has Been Sent to our IT Staff. Please wait for further reply.</b></p>";}?>
 </td>
</tr>
</table>
<!-- LIST HERE --><!-- LIST HERE -->
<? include 'footer.php';?>

</body>
</html>
