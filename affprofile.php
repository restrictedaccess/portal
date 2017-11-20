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


$mess="";
$mess=$_REQUEST['mess'];
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

<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
	toggle(element);
}
-->
</script>
	
</head>
<!-- background:#E7F0F5; -->
<body  style="background: #F7F9FD; " text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="affprofilephp.php">
<table width="1000px;" align="center" style="background:#FFFFFF; margin-top:10px; border:#E7F0F5 ridge 1px;">
<tr><td><div><img src="images/remotestafflogo.jpg"></div></td></tr>
<tr><td valign="top"><? include 'aff_header_menu.php';?>
</td></tr>
<tr>
<td height="54" valign="top">
<!-- Contents Here -->
<h3 class="h3_style">Affiliate System</h3>
<div class="welcome">
Welcome <?=$name;?></div>
<div class="logout"><a href="logout.php">Logout</a></div>
<div style="clear:both"></div>
<table width="90%">
<tr>
<td width="216" valign="top"><? include 'aff_leftnav.php';?></td>
<td width="665" valign="top">

<div class="box_blue" >Profile</div>
<div class="box_blue_content" >
<? if ($mess==1) {
echo "<p><b>Updated Successfuly!</b></p>";
}else {
?>
<div id="form_info">
<p><label>Email :</label><INPUT  type="text" style='width:270px' class="text"  name="email" value="<?=$row['email'];?>"></p>
<p><label>Password :</label><INPUT type="password"  style='width:270px' class="text"  name="password" value="<?=$row['agent_password'];?>"></p>
<p><label>First Name :</label><INPUT type="text" style='width:270px' class="text"  name="fname" value="<?=$row['fname'];?>"></p>
<p><label>Last Name :</label><INPUT type="text" style='width:270px' class="text"  name="lname" value="<?=$row['lname'];?>"></p>
<p><label>Address :</label><textarea name="address" cols="30" rows="3" class="text"><?=$row['agent_address'];?></textarea></p>
<p><label>Contact # :</label><INPUT type="text" style='width:270px' class="text"  name="phone" value="<?=$row['agent_contact'];?>"></p>

<hr style="width:90%;">

<p><label><b>Bank Account Details</b></label><textarea name="bank_account" id="bank_account" class="text" cols="40" rows="5"><?=$row['agent_bank_account'];?></textarea></p>
<hr style="width:90%;">
<p><label>&nbsp;</label><INPUT type="submit" value="Update" name="update"  id="update"class="button" style="width:120px"></p>
</div>
<? }?>
</div>
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
