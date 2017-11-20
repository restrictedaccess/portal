 <?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';

if($_SESSION['agent_no']=="")
{
	header("location:index.php");
}
$agent_no = $_SESSION['agent_no'];

/*
agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn*/
$query="SELECT * FROM agent WHERE agent_no =$agent_no;";

$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name = $row['fname']." ".$row['lname'];
	$agent_code = $row['agent_code'];
	$agent_email = $row['email'];
	$length=strlen($agent_code);
	
}



?>
<html>
<head>
<title>Affiliate</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="css/affiliate.css">
<script language=javascript src="js/functions.js"></script>
	
</head>
<!-- background:#E7F0F5; -->
<body style="background: #F7F9FD; " text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="affHome.php">
<table width="1000px;" align="center" style="background:#FFFFFF; margin-top:10px; border:#E7F0F5 ridge 1px;">
<tr><td><div><img src="images/remote-staff-logo.jpg" alt="think" width="484" height="89"></div></td></tr>
<tr><td valign="top">
<? include 'aff_header_menu.php';?>
</td></tr>
<tr>
<td height="54" valign="top">
<!-- Contents Here -->
<h3 class="h3_style">
<script language="JavaScript1.2">

/*
Neon Lights Text
By JavaScript Kit (http://javascriptkit.com)
For this script, TOS, and 100s more DHTML scripts,
Visit http://www.dynamicdrive.com
*/

var message="Affiliate System"
var neonbasecolor="black"
var neontextcolor="red"
var flashspeed=100  //in milliseconds

///No need to edit below this line/////

var n=0
if (document.all||document.getElementById){
document.write('<font color="'+neonbasecolor+'">')
for (m=0;m<message.length;m++)
document.write('<span id="neonlight'+m+'">'+message.charAt(m)+'</span>')
document.write('</font>')
}
else
document.write(message)

function crossref(number){
var crossobj=document.all? eval("document.all.neonlight"+number) : document.getElementById("neonlight"+number)
return crossobj
}

function neon(){

//Change all letters to base color
if (n==0){
for (m=0;m<message.length;m++)
//eval("document.all.neonlight"+m).style.color=neonbasecolor
crossref(m).style.color=neonbasecolor
}

//cycle through and change individual letters to neon color
crossref(n).style.color=neontextcolor

if (n<message.length-1)
n++
else{
n=0
clearInterval(flashing)
setTimeout("beginneon()",1500)
return
}
}

function beginneon(){
if (document.all||document.getElementById)
flashing=setInterval("neon()",flashspeed)
}
beginneon()
</script>
</h3>
<div class="welcome">
Welcome <?=$name;?></div>
<div class="logout"><a href="logout.php">Logout</a></div>
<div style="clear:both"></div>
<table width="99%">
<tr>
<td width="25%" valign="top"><? include 'aff_leftnav.php';?></td>
<td width="29%" valign="top">
<div class="box_blue" >
Leads Status</div>
<div class="box_blue_content" >

<?
$queryClienCount="SELECT COUNT(id)AS client_count FROM leads WHERE status ='Client' AND agent_id = $agent_no;";
$result_sql3=mysql_query($queryClienCount);
$row3=mysql_fetch_array($result_sql3);
echo "<p style='margin-bottom:2px; margin-top:2px;'>Client : &nbsp;".$row3['client_count']."</p>";

$queryContactleadsCount="SELECT COUNT(id)AS contact_lead_count FROM leads WHERE status ='Contacted Lead' AND agent_id = $agent_no;";
$result_sql2=mysql_query($queryContactleadsCount);
$row2=mysql_fetch_array($result_sql2);
echo "<p style='margin-bottom:2px; margin-top:2px;'>Contacted Lead : &nbsp;".$row2['contact_lead_count']."</p>";

$queryNewleadsCount="SELECT COUNT(id)AS new_lead_count FROM leads WHERE status ='New Leads' AND agent_id = $agent_no;";
$result_sql=mysql_query($queryNewleadsCount);
$row=mysql_fetch_array($result_sql);
echo "<p style='margin-bottom:2px; margin-top:2px;'>New Leads : &nbsp;".$row['new_lead_count']."</p>";

?>
</div>
<p style="margin-top:20px; margin-left:10px;">Your promotional code is : <font color="#999999"><b><? echo $agent_code;?></b></font></p>

</td>
<td width="46%" valign="top">
<div class="box_yellow">Login Details</div>
<div class="box_yellow_content">
<ul>
<li>Email : <?=$agent_email;?></li>
<li>Password : <a href="affprofile.php">Change Password</a></li>
</ul>
</div>

</td>
</tr>
</table>


<!-- Contents Here -->
</td>
</tr>
<tr><td><? include 'footer.php';?></td></tr>
</table>
</form>	
</body>
</html>
