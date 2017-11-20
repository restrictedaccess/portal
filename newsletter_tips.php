<?
include 'config.php';
include 'conf.php';
include 'function.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
if($_SESSION['client_id']=="")
{
	header("location:index.php");
}

$client_id = $_SESSION['client_id'];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Client RemoteStaff</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel=stylesheet type=text/css href="menu.css">

	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
  <li ><a href="clientHome.php"><b>Home</b></a></li>
   <li ><a href="myscm.php"><b>Sub-Contractor Management</b></a></li>
     <li ><a href="work_with_remotestaff.php"><b>How To Work With RemoteStaff </b></a></li>
	 <li class="current"><a href="newsletter_tips.php"><b>Newsletter &amp; Tips</b></a></li>
	 <li ><a href="comments_suggestion.php"><b>Comments &amp; Suggestions</b></a></li>
</ul>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<td colspan="2"><img src='images/space.gif' width=1 height=10></td>
</tr>

<tr>
<td width="14%" height="176" bgcolor="#ffffff" valign="top"  style="border-right: #006699 2px solid; width: 170px; vertical-align:top;">
<img src='images/space.gif' width=1 height=10>
<br clear=all>
<? include 'clientleftnav.php';?>
<br>
</td>
<td width="100%" valign="top" bgcolor="#EFEFEF" >

<!-- contents here -->
<style>
<!--
.newsletter{float:left; margin-bottom:20px; margin-left:10px; margin-top:10px;  border: 1px solid #abccdd; width: 90%;  background-color:#FFFFFF;padding:10px 10px 10px 20px;}
-->
</style>
<?
// id, admin_id, topic, contents, date_created, status
$sql="SELECT id , contents, DATE_FORMAT(date_created,'%D %b %Y') FROM newsletter ORDER BY date_created DESC;";
$result=mysql_query($sql);
$counter=0;
while(list($id, $contents ,$date_created)=mysql_fetch_array($result))
{
	$counter++;
?>
<div  class="newsletter">
<div style="text-align:right; color:#333333"><?=$date_created;?></div>
<? echo $contents;;?>
</div>
<? }?>
<!-- ends here -->
</td>
</table>
<? include 'footer.php';?>

</body>
</html>
