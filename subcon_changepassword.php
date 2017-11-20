<?
include 'config.php';
include 'conf.php';
$userid=$_SESSION['userid'];

if(isset($_POST['update']))
{

$old_password=sha1($_REQUEST['old_password']);
//$old_password=$_REQUEST['old_password'];
$new_password=sha1($_REQUEST['new_password']);


$query="SELECT * FROM personal WHERE userid=$userid AND pass = '$old_password';";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$password=$row['pass'];
	//echo $new_password;
	$sqlUpdate="UPDATE personal SET pass = '$new_password' WHERE userid=$userid ;";
	$result2=mysql_query($sqlUpdate);
	if($result2)
	{
	$error="<tr bgcolor='#FFFFCC' ><td style='border:#660000 solid 1px;' height='29' colspan='3' align='center'><b style='color:#660000'>Password Change Successfully!</b></td></tr>";	
	}
	else
	{
		$error="<tr bgcolor='#CCCCCC' ><td style='border:#660000 solid 1px;' height='29' colspan='3' align='center'><b style='color:#660000'>Error in Script Please try again !</b></td></tr>";
	}
	
}
else
{
	$error="<tr bgcolor='#CCCCCC' ><td style='border:#660000 solid 1px;' height='29' colspan='3' align='center'><b style='color:#660000'>Error : Your Password does not match!</b></td></tr>";
}

}
?>
<html>
<head>
<title>Sub-Contractor Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<script language="javascript" type="text/javascript">
<!--
function checkFields()
{
	if(document.form.old_password.value=="")
	{
		alert("Please enter your Old Password !");
		return false;
	}
	
	if(document.form.new_password.value=="")
	{
		alert("Please enter your New Password !");
		return false;
	}
	
	if(document.form.re_password.value=="")
	{
		alert("Please re-enter your New Password !");
		return false;
	}
	
	if(document.form.new_password.value!=document.form.re_password.value)
	{
		alert("New Password and Re-entered Password seems Incorrect !");
		return false;
	}
	return true;
}
//-->
</script>   
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<!-- header -->
<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="background-color:#FFFFFF; background-repeat: repeat-x;">
<tr><td width="100%" style="width: 220px; height: 60px;"><img src="images/remotestafflogo.jpg" alt="think" width="416" height="108"></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width: 100%; background: URL('images/bg1.gif'); background-repeat: repeat-x">
<tr><td style="border-bottom: 2px #0d509e solid; " >&nbsp;</td>
</tr>
<tr><td bgcolor="#FFFFFF" width=566>
 <form action="subcon_changepassword.php" name="form" method="post" onSubmit="return checkFields();" >
<table width=566 cellpadding=1 cellspacing=0 border=0>
<?=$error;?>
<tr>
<td width="219" align="right">Enter Old Password</td>
<td width="15">:</td>
<td width="326"><input type="password" name="old_password" id="old_password" value=""></td>
</tr>
<td align="right">Enter New Password</td>
<td>:</td>
<td><input type="password" name="new_password" id="new_password" value=""></td>
</tr>

<td align="right">Re-Enter New Password</td>
<td>:</td>
<td><input type="password" name="re_password" id="re_password" value=""></td>
</tr>

<td colspan="3" align="center"><input type="submit" name="update" value="Change Password"></td>
</tr>

</table>
</form>

</td></tr>
</table><br>

</body>
</html>
