<?
include '../config.php';
include '../conf.php';
$mess="";
$mess=$_REQUEST['mess'];

$query="SELECT agent_no,fname,lname,work_status FROM agent WHERE status='ACTIVE' AND work_status = 'AFF' ORDER BY fname ASC;";
$result=mysql_query($query);
while(list($agent_no,$fname,$lname,$work_status)=mysql_fetch_array($result))
{
	$agentOptions.="<option value='$agent_no'>$fname&nbsp;$lname&nbsp;</option>";
}


?>

<html>
<head>
<title>Online Inquiry Form</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">
<script type="text/javascript">
<!--
function showhide(str)
{

	if(str=="Yes")
	{
		newitem1="<p><label>Type it here</label><br>";
	 	newitem1+="<textarea name=\"usedoutsourcingstaff\" +";
		newitem1+="\" cols=\"25\" rows=\"5\" class=\"select\"></textarea></p><p></p>";
		document.getElementById("txtHint").innerHTML=newitem1;
	}
	if(str=="No")
	{
		document.getElementById("txtHint").innerHTML="&nbsp;";
	}
	
	
}

-->
</script>	
	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form action="addnewleadphp.php" id="form" name="form" method="post" >


<script language=javascript src="../js/functions.js"></script>
<script language=javascript src="../js/cookie.js"></script>
<script language=javascript src="../js/js2/functions.js"></script>
<script language=javascript src="../js/js2/png.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
  <li ><a href="agentHome.php"><b>Home</b></a></li>
  <li><a href="advertise_positions.php"><b>Applications</b></a></li>
  <li ><a href="newleads.php"><b>New Leads</b></a></li>
   <li><a href="follow_up_leads.php"><b>Follow Up</b></a></li>
  <li><a href="keep_in_touch_leads.php"><b>Keep in Touch</b></a></li>
  <li ><a href="client_listings.php"><b>Clients</b></a></li>
  <li ><a href="scm.php"><b>Sub-Contractor Management</b></a></li>
</ul>
<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr><td colspan=2 style='height: 1px;'>
<?
if($mess==1)
{
	echo "<p align='center'><b>New Lead Register Successfuly !</b></p>";
}
?>
</td>
</tr>
<tr><td width="194" style='border-right: #FFFFFF 2px solid; width: 170px; vertical-align:top; '>
<img src='../images/space.gif' width=1 height=10>
<br clear=all>
<? include 'agentleftnav.php';?>
<br></td>
<td width=100% valign=top >
<!-- -->


<table width="100%" cellspacing="0" style="border:#666666 solid 1px; margin-top:20px;">
<tr bgcolor="#CCCCCC">
<td colspan="2" valign="top" style="border-bottom:#666666 solid 1px;"><font color="#000000"><B>Online Inquiry Form</B></font></tr>
<tr>
<td width="50%" valign="top"><table width="100%"  cellspacing="0" cellpadding="3">
<tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>For Affiliate :</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><select name="agent" id="agent" class="select">
<option value="0">- Select -</option>
<?=$agentOptions;?>
</select></td>
  </tr>
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
<td width='53%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="radio" id="used_rs" name="used_rs"  value="Yes" />Yes&nbsp;<input type="radio" id="used_rs" name="used_rs" value="No"  />No</td>
</tr>
<tr>
<td width='44%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#FFFFFF solid 1px;'>If "Yes" Please describe your experience.</td>
<td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
<td  valign='top' style='border-left:#666666 solid 1px; border-bottom:#FFFFFF solid 1px;'><textarea name="usedoutsourcingstaff" cols="25" rows="5" class="select"></textarea></td>
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
<!-- -->
</td>
</tr></table>
</form>
<? include 'footer.php';?>

</body>
</html>
