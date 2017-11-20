<?
include 'config.php';
include 'conf.php';
$userid=$_SESSION['userid'];
//$userid=$_REQUEST['userid'];
//echo $userid;
$mess="";
$mess=$_REQUEST['mess'];


$query="SELECT image FROM personal WHERE userid=$userid";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result, MYSQL_NUM); 
	$src=$row[0];
	$image= "<img border=0 src='$src' width=110 height=150>";
}

?>
<html>
<head>
<title>MyProfile &copy;ThinkInnovations.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">


<script language=javascript src="js/functions.js"></script>
<script language=javascript src="js/cookie.js"></script>
<script language=javascript src="js/js2/functions.js"></script>
<script language=javascript src="js/js2/png.js"></script>

<!-- header -->
<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="background-color:#FFFFFF; background-repeat: repeat-x;">
<tr><td width="546" style="width: 220px; height: 60px;"><img src="images/remotestafflogo.jpg" alt="think" width="416" height="108"></td>
<td width="474">&nbsp;</td>
<td width="211" align="right" valign="bottom"></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width: 100%; background: URL('images/bg1.gif'); background-repeat: repeat-x">
<tr><td style="border-bottom: 2px #0d509e solid; " >&nbsp;</td>
</tr>
</table>
<!-- header -->
<!-- HEADER -->
<!-- /HEADER -->
<script language="JavaScript">
<!-- 
function ConfirmRemovePhoto(url, msg) {
  var confirm_remove = window.confirm (msg);
  if (confirm_remove) {
    parent.location= url;}
}
//-->
</script>


		<!-- SUBHEADER --><!-- /SUBHEADER -->
		
			<!-- WELCOME MESSAGE -->
            <!-- /WELCOME MESSAGE -->
            <!-- CONTENT -->
<table cellpadding="0" cellspacing="0" border="0" width="744">
		<tr><td width="736" bgcolor="#ffffff" align="center">
			<table width="736" cellpadding="0" cellspacing="0" border="0" align="center">
				<tr><td>
<table width=736 cellpadding=0 cellspacing=0 border=0 align=center><tr><td colspan=2 style='height: 1px;'>&nbsp;</td></tr><tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>


</td><td width=566 valign=top align=right><img src=images/space.gif width=1 height=10><br clear=all><table width=566 cellpadding=10 cellspacing=0 border=0><tr><td><table width=100% cellspacing=8 cellpadding=8 border=0 align=left ><tr><td width=100% bgcolor=#DEE5EB>
<b>
<p>Registration successful! </p>

<p>You are now ready to apply and take the first step to having a rewarding career from home. </p>

<p>To get your resume on top of the applicant priority list, please make sure that your resume is detailed and that a 2-minute sample voice recording introducing yourself and a summary of work experiences is attached. </p>


</b>


<form action="myresume.php" method="post">
<input type="hidden" name="userid" value="<? echo $userid;?>">
<input type="submit" class="button" style='width:100%px' name="btnNext" value="View your online resume" >
</form>
<br />

</td></tr>
<tr><td align=center>
</td></tr>
</table>
<br clear=all></td></tr></table></td></tr></table>
				</td></tr>
			</table>
		</td></tr>
</table>
	
</body>
</html>
