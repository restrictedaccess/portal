<?php
include 'config.php';
include 'conf.php';
$mess="";
$mess=$_REQUEST['mess'];

if($_SESSION['agent_no']=="")
{
	//header("location:logout.php");
	//echo "Agent : " .$agent_no;
	header("location:index.php");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Sub-Contractor Management</title>
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
	
}
-->
</script>	
	
    <script type="text/javascript" src="js/MochiKit.js"></script>
    <style type="text/css">@import url(scm_tab/scm_tab.css);</style>
    <script type="text/javascript" src="scm_tab/scm_tab.js"></script>

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
  <li ><a href="advertise_positions.php"><b>Applications</b></a></li>
  <li ><a href="newleads.php"><b>New Leads</b></a></li>
  <li ><a href="follow_up_leads.php"><b>Follow Up</b></a></li>
  <li><a href="keep_in_touch_leads.php"><b>Keep in Touch</b></a></li>
  <li ><a href="client_listings.php"><b>Clients</b></a></li>
  <li class="current"><a href="scm.php"><b>Sub-Contractor Management</b></a></li>
</ul>

    <div id="div_scm_tab">
    </div>
		
<div class="clear"></div>
<? include 'footer.php';?>
</body>
</html>
