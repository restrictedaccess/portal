<?
include 'config.php';
$mess="";
$mess=$_REQUEST['mess'];




?>

<html>
<head>
<title>SubPage</title>
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
  <li ><a href="advertise_positions.php"><b>Applications</b></a></li>
  <li><a href="#"><b>Advertisements</b></a></li>
  <li ><a href="newleads.php"><b>New Leads</b></a></li>
  <li ><a href="contactedleads.php"><b>Contacted Leads</b></a></li>
  <li ><a href="client_listings.php"><b>Clients</b></a></li>
</ul>
<span class="class1">
<a href="home.php">YAHOO</a>

<a href="login.php">GOOGLE</a>
</span>

</body>
</html>
