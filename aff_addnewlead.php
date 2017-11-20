<?php
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';

$agent_no = $_SESSION['agent_no'];
if($_SESSION['agent_no']=="")
{
	header("location:index.php");
}

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
<script language=javascript src="js/functions.js"></script>
<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
	toggle(element);
}

function CheckInputs(){
	//return false;
	var fname = $('fname').value;
	var lname = $('lname').value;
	var email = $('email').value;
	
	if(!fname){
		alert("Please enter leads first name");
		return false;
	}
	
	if(!lname){
		alert("Please enter leads last name");
		return false;
	}
	
	if(!email){
		alert("Please enter leads email address");
		return false;
	}
	
}
-->
</script>
	
</head>
<!-- background:#E7F0F5; -->
<body  style="background: #F7F9FD; " text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="aff_addnewleadphp.php" accept-charset = "utf-8" onSubmit="return CheckInputs()">
<table width="1000px;" align="center" style="background:#FFFFFF; margin-top:10px; border:#E7F0F5 ridge 1px;">
<tr><td><div><img src="images/remotestafflogo.jpg"></div></td></tr>
<tr><td valign="top">
<? include 'aff_header_menu.php';?>
</td></tr>
<tr>
<td height="54" valign="top">
<!-- Contents Here -->
<h3 class="h3_style">Affiliate System</h3>
<div class="welcome">
Welcome <?=$name;?></div>
<div class="logout"><a href="logout.php">Logout</a></div>
<div style="clear:both"></div>
<table width="99%">
<tr>
<td width="230px" valign="top"><? include 'aff_leftnav.php';?></td>
<td width="81%" valign="top">
<?php
if($mess==1){
	echo "<p align='center'><b>New Lead Register Successfuly !</b></p>";
}

if($mess==2){
	echo "<p align='center'><b>Please specify an email address</b></p>";
}

if($mess==3){
	echo "<p align='center'><b>Invalid Email Address</b></p>";
}
if($mess==4){
	echo "<p align='center'><b>Email Already Exist!</b></p>";
}

?>

<div class="box_blue" >Add New Lead</div>
<div class="box_blue_content" >
<table width="" cellspacing="0" style="border:#666666 solid 1px; margin-top:0px;">
<td width="50%" valign="top"><table width="100%"  cellspacing="0" cellpadding="3">
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>First Name </td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="fname" name="fname" class="select" /></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Last Name </td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="lname" name="lname" class="select" /></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Email </td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="email" name="email" class="select" /></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Name</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="companyname" name="companyname" class="select"  /></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Position</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="companyposition" name="companyposition" class="select" /></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Address</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="companyaddress" name="companyaddress" class="select"  /></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Office Number</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="officenumber" name="officenumber"  class="select" /></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Mobile No. </td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="mobile" name="mobile"  class="select" /></td>
  </tr>
 
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>No. of Employees</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="noofemployee" name="noofemployee" class="select"  /></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Website</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="website" name="website" class="select" value="<? echo $website;?>"  /></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Description</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><textarea cols="25" rows="5" name="companydesc" id="companydesc" class="select" ></textarea></td>
  </tr>
</table></td>
<td width="50%" valign="top">
<table width="100%"  cellspacing="0" cellpadding="3">
<tr>
<td width='44%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#FFFFFF solid 1px;'>RemoteStaff Responsibilities</td>
<td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
<td width='53%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><textarea cols="25" rows="5" class="select" name="jobresponsibilities"  id="jobresponsibilities" ></textarea></td>
</tr>
<tr>
<td width='44%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#FFFFFF solid 1px;'>No. of RemoteStaff needed</td>
<td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
<td width='53%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="rsnumber" name="rsnumber" class="select" /></td>
</tr>
<tr>
<td width='44%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#FFFFFF solid 1px;'>When will you need remote staff? </td>
<td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
<td width='53%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><select name="needrs" class="select">
<option value="">-</option>
<option value="Within 1 month">Within 1 month</option>
<option value="Over the next few Months" >Over the next few Months</option>
<option value="ASAP">ASAP</option>
<option value="Within 2 weeks">Within 2 weeks</option>
<option value="Within 1 month">Within 1 month</option>
<option value="Over the next few Months" >Over the next few Months</option>
</select></td>
</tr>

<tr>
<td width='44%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#FFFFFF solid 1px;'>RemoteStaff working from a home </td>
<td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
<td width='53%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><select name="rsinhome" class="select">
<option value="">-</option>
<option value="Yes">Yes</option>
<option value="No">No</option>
</select></td>
</tr>

<tr>
<td width='44%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#FFFFFF solid 1px;'>or from one of our Philippines office </td>
<td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
<td width='53%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><select name="rsinoffice" class="select">
<option value="">-</option>
<option value="Yes">Yes</option>
<option value="No">No</option>
</select></td>
</tr>

<tr>
<td width='44%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#FFFFFF solid 1px;'>Questions/Concerns</td>
<td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
<td width='53%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><textarea name="questions" cols="25" rows="5" class="select" ></textarea></td>
</tr>

<tr>
<td width='44%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#FFFFFF solid 1px;'>Have you use any outsourcing staff in the past?.</td>
<td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
<td width='53%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="radio" id="used_rs" name="used_rs"  value="Yes" onClick="showhide(this.value);" />Yes&nbsp;<input type="radio" id="used_rs" name="used_rs" value="No" onClick="showhide(this.value);" />No</td>
</tr>
<tr>
<td colspan="3" valign='top' align="center" style='border-left:#666666 solid 1px; border-bottom:#FFFFFF solid 1px;'><div id="txtHint">&nbsp;</div></td>
</tr>


<tr>
<td width='44%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Turnover</td>
<td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
<td width='53%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><select name="companyturnover" class="select">
  <option value="">-</option>
  <option value="$0 to $300,000">$0 to $300,000</option>
  <option value="$300,000 to $700,000">$300,000 to $700,000</option>
  <option value="$700,000 to $1.2m" >$700,000 to $1.2m</option>
  <option value="$1.2m to $2m" >$1.2m to $2m</option>
  <option value="$2m to $3m" >$2m to $3m</option>
  <option value="$3 to $5m" >$3 to $5m</option>
  <option value="Above $5m" >Above $5m</option>
</select></td>
</tr>
</table></td>
</tr>
<tr>
<td colspan="3" style="border-top:#666666 solid 1px;">&nbsp;</td>
</tr>
<tr bgcolor="#FFFFFF">
<td colspan="3" valign="middle"  height="30" style="border-bottom:#666666 solid 1px;" align="center"><input type="submit" value="Submit Form" class="button" /></td></tr>
</table>

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
