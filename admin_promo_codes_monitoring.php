<?php
die("Page under maintenance.");
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
include 'time.php';
include 'time_recording/TimeRecording.php';

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$current_month=date("m");
$current_month_name=date("F");
$ATZ = $AusDate." ".$AusTime;
$date=date('jS \of F Y \[l\]');


$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
/*
admin_id, admin_fname, admin_lname, admin_email, admin_password, admin_created_on, status
*/
$query="SELECT * FROM admin WHERE admin_id=$admin_id;";

$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name = $row['admin_fname']." ".$row['admin_lname'];
	
}
	
?>
<html>
<head>
<title>Administrator-Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="css/affiliate.css">

<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
	toggle(element);
}
-->
</script>
<script language="JavaScript" type="text/javascript">
<!--
function highlight(obj) {
   obj.style.backgroundColor='yellow';
   //obj.style.cursor='pointer';
}
function unhighlight(obj) {
   obj.style.backgroundColor='';
   //obj.style.cursor='default';
}
//-->
</script>

<style type="text/css">
<!--
#box_tab
{
width:600px;
	
}
#box_tab ul{
padding: 3px 0;
margin-left: 0;
margin-top: 1px;
margin-bottom: 0;
font: bold 11px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif;
list-style-type: none;
text-align: left; /*set to left, center, or right to align the menu as desired*/
}
#box_tab li{
display: inline;
margin: 0;
}
#box_tab a
{

	text-decoration: none;
	padding: 3px 7px;
	margin-right: 3px;
	border: 1px solid #778;
	width:130px;
	color: #2d2b2b;
	background: white url(images/shade.gif) top left repeat-x;

}
#box_tab a:hover
{
	color: black;
}
#box_tab a:active
{
	color:#FF0000;
	border-bottom-color: white;
	background-image: url(images/shadeactive.gif);
}
#box_tab a:focus
{
	color:#FF0000;
	border-bottom-color: white;
	background-image: url(images/shadeactive.gif);
}

.thumbnail
{
float: left;
width: 70px;
border: 1px solid #999;
margin: 0 15px 15px 0;
padding: 5px;
}

.clearboth { clear: both; }

.text_td{
	font: 11px 'Lucida Grande', 'Trebuchet MS', Verdana, Helvetica, sans-serif; color: #2d2b2b;
	padding:3px;
	 
}
-->
</style>
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="adminHome.php">
<input type="hidden" name="summary" value="<? echo $summary;?>">

<script language=javascript src="js/functions.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>

<table width="100%">
<tr><td width="18%" height="265" valign="top" style="border-right: #006699 2px solid;">

<? include 'adminleftnav.php';?>
</td>
<td valign="top"  style="width:100%; background: #E7F0F5;">
<table width="90%">
<tr><td width="600" >
<table width="600" border="1" bgcolor="#FFFFFF" cellpadding="2">
<tr>
    <td width="38" align="center"><font face="Arial" size="2" color="#0000FF"><b>#</b></font></td>
    <td width="229" align="center"><font face="Arial" size="2" color="#0000FF"><b>Name</b></font></td>
	<td width="321" >
	<label style="float:left; display:block;"><font face="Arial" size="2" color="#0000FF"><b>Promocodes</b></font></label>
	<label style="float:left; display:block; margin-left:90px;"><font face="Arial" size="2" color="#0000FF"><b>Points</b></font></label>
	<label style="float:left; display:block; margin-left:39px;"><font face="Arial" size="2" color="#0000FF"><b>Hits</b></font></label>
	</td>
</tr>
<?
$sqlGetAllActiveAgents="SELECT agent_no,fname,lname,a.work_status
FROM agent a
WHERE a.status = 'ACTIVE'
ORDER BY fname ASC;";
$counter=0;
$bgcolor="#E7F0F5";
$result_query=mysql_query($sqlGetAllActiveAgents);
while(list($agent_no,$fname,$lname,$work_status)=mysql_fetch_array($result_query))
{	$counter++;
?>
	<tr>
	<td align="center" valign="top"><font face="Arial" size="2"><?=$counter;?></font></td>
	<td align="left" valign="top">
	<div style="font: bold 12px Arial; padding:5px; background:#E0E9F3;">
	<span style="float:left;"><?=$fname." ".$lname;?></span><span style="float:right;"><?=$work_status;?></span>
	<br style="clear:both;" />
	</div>
	</td>
	<td align="left" valign="top">
	<table width="100%" cellpadding="2" cellspacing="0"  >
	<?
	//$sqlGetAgentPromocodes="SELECT tracking_no, points FROM tracking t WHERE tracking_createdby = $agent_no;";
	$sqlGetAgentPromocodes="SELECT DISTINCT (tracking_no), points , SUM(p.hits)
FROM tracking t
LEFT OUTER JOIN promocodes_hits p ON p.tracking_id = t.id
WHERE tracking_createdby = $agent_no
GROUP BY t.id";
	$result_query2=mysql_query($sqlGetAgentPromocodes);	
	while(list($tracking_no, $points,$hits)=mysql_fetch_array($result_query2))
	{
		if($points=="")$points=0;
		if ($hits =="")$hits="&nbsp;";
		if ($tracking_no =="")$tracking_no="&nbsp;";
	?>
		<tr onmouseover='highlight(this)' onmouseout='unhighlight(this)'>
		<td width="47%" valign="top" style="border:#CCCCCC dashed 1px;"><font face="Arial" size="2"><?=$tracking_no;?></font></td>
		<td width="28%" valign="top" align="center"  style="border:#CCCCCC dashed 1px;"><font face="Arial" size="2"><?=$points;?></font></td>
		<td width="25%" valign="top" align="center"  style="border:#CCCCCC dashed 1px;"><font face="Arial" size="2"><?=$hits;?></font></td>
		</tr>	
	<?
	}
	?>
	</table>
	</td>
	</tr>
<? }?>	
</table>
</td><td width="320" valign="top">&nbsp;</td>
</tr>

</table>
</td>
</tr>
</table>

<? include 'footer.php';?>
</form>	
</body>
</html>

