<?
include '../config.php';
include '../function.php';
include '../conf.php';

$agent_no = $_SESSION['agent_no'];
$leads_id = $_REQUEST['id'];

if($_SESSION['agent_no']=="")
{
	header("location:../index.php");
}

$queryLeads ="SELECT * FROM leads WHERE id = $leads_id;";
$resultLeads=mysql_query($queryLeads);
$rows = mysql_fetch_array($resultLeads);
$lname =$rows['lname'];
$fname =$rows['fname'];
?>

<html>
<head>
<title>Client Management</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../css/style.css">
<link rel=stylesheet type=text/css href="../menu.css">
<link rel="stylesheet" href="../css/light.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="tab/tabcontent.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript" src="tab/tabcontent.js"></script>
<script type="text/javascript" src="script/apply_action.js"></script>
<script type="text/javascript" src="../js/calendar.js"></script> 
<script type="text/javascript" src="../lang/calendar-en.js"></script> 
<script type="text/javascript" src="../js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-blue.css" title="win2k-1" />
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onLoad="showLeadInfo();">
<form method="POST" name="form" enctype="multipart/form-data"  onsubmit="return checkFields();">
<input type="hidden" name="id" id="id" value="<? echo $leads_id;?>">
<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
  <li ><a href="agentHome.php"><b>Home</b></a></li>
  <li><a href="advertise_positions.php"><b>Applications</b></a></li>
  <li ><a href="newleads.php"><b>New Leads</b></a></li>
  <li><a href="follow_up_leads.php"><b>Follow Up</b></a></li>
  <li><a href="keep_in_touch_leads.php"><b>Keep in Touch</b></a></li>
  <li><a href="client_listings.php"><b>Clients</b></a></li>
  <li><a href="scm.php"><b>Sub-Contractor Management</b></a></li>
</ul>
<table width=100% cellpadding=0 cellspacing=0 border=0 >
</tr>
<tr><td width="178" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='../images/space.gif' width=1 height=10>
<br clear=all>
<? include 'agentleftnav.php';?>
<br></td>
<td width=722 valign=top  align="left">

<div id="pettabs" class="indentmenu" style="margin-left:10px; margin-top:10px;">
<ul>
<li><a href="#" rel="lead" class="selected" >Client : <span id="lead_name"><?=$fname." ".$lname;?></span></a></li>
<li><a href="#" rel="steps_taken">Steps Taken</a></li>
<li><a href="#" rel="action_records">Action Records</a></li>
<li><a href="#" rel="todo_reminders" >To Do's &amp; Reminders</a></li>
<li><a href="#" rel="client_account" >Client Account</a></li>
<li><a href="#" rel="recruitment_preparation" >Preparation</a></li>
<li><a href="#" rel="recruitment_by_hr" >Recruiting</a></li>
</ul>
<br style="clear: left" />
</div>
<div style="border:1px solid gray; width:1000px; height: auto; padding: 5px; margin-bottom:1em; margin-left:10px;">
	<div id="lead" class="tabcontent">
		<!-- Lead Description -->
		<img src="../images/ajax-loader.gif"> Loading...
	</div>
	<div id="steps_taken" class="tabcontent">
	   <img src="../images/ajax-loader.gif"> Loading...
	</div>
	<div id="action_records" class="tabcontent">
		<!-- Action Records -->
		<img src="../images/ajax-loader.gif"> Loading...
	</div>
	<div id="todo_reminders" class="tabcontent">
	<!-- to do form -->
	<p></p>
	<!-- ---->
	</div>
	<div id="client_account" class="tabcontent">
		<!-- Clients Details ends here -->
here
	</div>
	<div id="recruitment_preparation" class="tabcontent">
		<!-- recruitment_preparation -->
		<img src="../images/ajax-loader.gif"> Loading...
	</div>
	<div id="recruitment_by_hr" class="tabcontent">
		<!-- Client Account -->
		<img src="../images/ajax-loader.gif"> Loading...
	</div>

</div>


<script type="text/javascript">

var mypets=new ddtabcontent("pettabs")
mypets.setpersist(true)
mypets.setselectedClassTarget("link")
mypets.init(0)

</script>
</td>
</tr></table>
<? include 'footer.php';?>
</form>
</body>
</html>
