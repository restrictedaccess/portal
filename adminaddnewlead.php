<?php
header("location:AddUpdateLeads.php");
exit;
include './conf/zend_smarty_conf_root.php';
if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}
$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
$mess=$_REQUEST['mess'];


$sql="SELECT * FROM agent WHERE status='ACTIVE' ORDER BY fname ASC;";
$result = $db->fetchAll($sql);
foreach ($result as $result) {
	if($result['work_status']=="BP"){
   		$BPOptions.="<option value=".$result['agent_no'].">".$result['fname']."&nbsp;".$result['lname']."</option>";
    }else{
		$AFFOptions.="<option value=".$result['agent_no'].">".$result['fname']."&nbsp;".$result['lname']."</option>";
	}
		
}




?>

<html>
<head>
<title>Online Inquiry Form</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/MochiKit.js"></script>
<script type="text/javascript" src="js/admin_add_lead.js"></script>

</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form action="adminaddnewleadphp.php" id="form" name="form" method="post" onSubmit="return checkFields();">
<input type="hidden" name="promocode" id="promocode" value="<?php echo $tracking_no;?>">
<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr><td width="194" style='border-right: #FFFFFF 2px solid; width: 170px; vertical-align:top; '>
<img src='images/space.gif' width=1 height=10>
<br clear=all>
<? include 'adminleftnav.php';?>
<br></td>
<td width=100% valign=top >
<?
if($mess==1)
{
	echo "<p align='center'><b>New Lead Added !</b></p>";
}

?>
<table width="100%" cellspacing="0" style="border:#666666 solid 1px; margin-top:20px;">
<tr bgcolor="#CCCCCC">
<td colspan="2" valign="top" style="border-bottom:#666666 solid 1px;"><font color="#000000"><B>Online Inquiry Form</B></font></tr>
<tr>
<td width="50%" valign="top"><table width="100%"  cellspacing="0" cellpadding="3">
<tr><td colspan="3"><b>Allocate this Lead</b></td></tr>
<tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Business Partner</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>
	<select name="agent" id="agent" class="select" onChange="getAgentsPromocodes(this.value);getBusinessPartnerAffiliates();">
	<option value="0">- Select -</option>
	<?php echo $BPOptions;?>
	</select>
</td>
 </tr>
 <tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Business Partner Affiliates</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>
	<div id="agent_affiliates">
	<select name="affiliate_id" id="affiliate_id" class="select" onChange="setDefault('other_affiliate_id')" disabled="disabled">
	<option value=""></option>
	</select>
	</div>
</td>
  </tr>
  <tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Promotional Code :</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>
	<div id="agent_promocodes">
	<select name="tracking_no" id="tracking_no" class="select" >
	<option value="0">-</option>
</select>
</div>
</td>
  </tr> 
   <tr><td colspan="3"><hr></td></tr>
 <tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>All Affiliates</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>
	<select name="other_affiliate_id" id="other_affiliate_id" class="select" onChange="getAgentsPromocodes(this.value);setDefault('affiliate_id');">
	<option value="">-</option>
	<?php echo $AFFOptions;?>
	</select>
</td>
  </tr>
 

 
  
   <tr><td colspan="3"><hr></td></tr>
  <tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>First Name </td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="fname" name="fname" class="select" /></td>
  </tr>
  <tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Last Name </td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="lname" name="lname" class="select" /></td>
  </tr>
  <tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Email </td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="email" name="email" class="select" /></td>
  </tr>
  <tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Name</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="companyname" name="companyname" class="select"  /></td>
  </tr>
  <tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Position</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="companyposition" name="companyposition" class="select" /></td>
  </tr>
  <tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Address</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="companyaddress" name="companyaddress" class="select"  /></td>
  </tr>
  <tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Office Number</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="officenumber" name="officenumber"  class="select" /></td>
  </tr>
  <tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Mobile No. </td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="mobile" name="mobile"  class="select" /></td>
  </tr>
 
  <tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>No. of Employees</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="noofemployee" name="noofemployee" class="select"  /></td>
  </tr>
  <tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Website</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="website" name="website" class="select" value="<? echo $website;?>"  /></td>
  </tr>
  <tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Description</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><textarea cols="25" rows="5" name="companydesc" id="companydesc" class="select" ></textarea></td>
  </tr>
  <tr><td colspan="3"><hr></td></tr>
<tr><td valign="top">Company Owner</td>
<td valign="top">:</td><td valign="top" ><input id="company_owner" name="company_owner" type="text" class="select" value="<? echo $company_owner;?>"></td></tr>
<tr><td colspan="3" >For Staff Reporting</td></tr>
<tr><td valign="top">Contacts</td>
<td valign="top">:</td><td valign="top" ><input id="contact" name="contact" type="text" class="select" value="<? echo $contact;?>"></td></tr>
<tr><td valign="top">Accounts</td>
<td valign="top">:</td><td valign="top" ><input id="others" name="others" type="text" class="select" value="<? echo $others;?>" ></td></tr>
<tr><td valign="top">Others</td>
<td valign="top">:</td><td valign="top" ><input id="accounts" name="accounts" type="text" class="select" value="<? echo $accounts;?>"></td></tr>

</table></td>
<td width="50%" valign="top">
<table width="100%" height="528" cellpadding="3"  cellspacing="0">

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
<td width='53%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="radio" id="used_rs" name="used_rs"  value="Yes" onClick="" />Yes&nbsp;<input type="radio" id="used_rs" name="used_rs" value="No" onClick="" />No</td>
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
<!-- -->
</td>
</tr></table>
</form>
<? include 'footer.php';?>

</body>
</html>
