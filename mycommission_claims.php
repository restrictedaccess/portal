<?php
include 'config.php';
include 'conf.php';
include 'time.php';

if($_SESSION['userid']=="")
{
	header("location:index.php");
}
$userid = $_SESSION['userid'];
$query="SELECT * FROM personal WHERE userid=$userid";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$name =$row['fname']."  ".$row['lname'];
}



?>
<html>
<head>
<title>Sub-Contractor Testimonials</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="commission/commission.css">
<script language=javascript src="js/functions.js"></script>
<script type="text/javascript" src="commission/commission.js"></script>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post">
<input type="hidden" name="userid" id="userid" value="<?=$userid;?>">
<!-- HEADER -->
<? include 'header.php';?>
<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome  <? echo $name;?></b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>
<table width="100%" height="502" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="170" height="502" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
   <? include 'subconleftnav.php';?></td>
<td width="1064" valign="top" >
<div>
<div style="background:#333333; color:#FFFFFF; padding:5px;">Commission Claim</div>
<div id="staff_result" >Loading...</div>		



</td>
</tr>
</table>
<script type="text/javascript">
<!--
showStaffForm(1);
-->
</script>
<? include 'footer.php';?>
</form>
</body>
</html>
