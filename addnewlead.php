<?php
header("location:AddUpdateLeads.php");
exit;


include './conf/zend_smarty_conf_root.php';
include 'config.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['agent_no']=="")
{
	header("location:index.php");
}

$agent_no = $_SESSION['agent_no'];
$mess="";
$mess=$_REQUEST['mess'];

$sql="SELECT * FROM agent WHERE agent_no = $agent_no;";
$result = $db->fetchRow($sql);
$agent_code = $result['agent_code'];
$agent_fname = $result['fname'];
$agent_lname = $result['lname'];



$query="SELECT DISTINCT(a.agent_no),CONCAT(a.fname,' ',a.lname)AS fullname ,f.business_partner_id
FROM agent a
LEFT JOIN agent_affiliates f ON f.affiliate_id = a.agent_no
WHERE a.status='ACTIVE'
AND a.work_status = 'AFF'
ORDER BY fname ASC;;";

//echo $query;
$result = $db->fetchAll($query);
foreach($result as $row){
	if($row['business_partner_id'] == $agent_no){
		$agentAffiliatesOptions.="<option value=".$row['agent_no'].">".$row['fullname']."</option>";
	}else{
		$AllAffiliatesOptions.="<option value=".$row['agent_no'].">".$row['fullname']."</option>";
	}
}


//insert the business partner default promo codes  , outboundcall , inboundcall
$promocodes_Array =  array($agent_code , $agent_code.'OUTBOUNDCALL' , $agent_code.'INBOUNDCALL');
for($i=0;$i<count($promocodes_Array);$i++){
	$sql = "SELECT * FROM tracking t WHERE tracking_no = '".$promocodes_Array[$i]."' AND tracking_createdby = $agent_no;";
	$result =  $db->fetchAll($sql);
	if(count($result) == 0){
		$data = array(
			'tracking_no' => $promocodes_Array[$i], 
			'tracking_desc' => $promocodes_Array[$i], 
			'tracking_created' => $ATZ, 
			'tracking_createdby' => $agent_no, 
			'status' => 'NEW'
				);
		$db->insert('tracking', $data);	
	}
}







$query = "SELECT * FROM tracking t WHERE tracking_createdby = $agent_no AND status!='ARCHIVE';";
$result = $db->fetchAll($query);
foreach($result as $row){
	if($agent_code == $row['tracking_no']){
		$promocodesOptions.="<option selected value=".$row['tracking_no'].">".$row['tracking_no']."</option>";
	}else{
		$promocodesOptions.="<option value=".$row['tracking_no'].">".$row['tracking_no']."</option>";
	}
	
}


?>

<html>
<head>
<title>Business Partner Adding of Leads [ Enquire Form ]</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<script type="text/javascript" src="js/functions.js"></script>

</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form action="addnewleadphp.php" id="form" name="form" method="post" enctype="multipart/form-data" >
<!-- HEADER -->
<? include 'header.php';?>
<? include 'BP_header.php';?>
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
<img src='images/space.gif' width=1 height=10>
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
<tr><td><b style="color:#0000FF;">Business Partner </b></td><td>:</td><td><b style="color:#FF0000"><?php echo $agent_fname." ".$agent_lname;?></b></td></tr>
<tr bgcolor="#CCCCCC";><td colspan="3"><b>Allocate to Affiliates</b></td></tr>
<tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Your Affiliates :</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>
	<select name="affiliate_id" id="affiliate_id" class="select" onChange="setDefault('other_affiliate_id')">
<option value="" selected="selected" >- Select -</option>
<?=$agentAffiliatesOptions;?>
</select></td>
  </tr>
 <tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>All Affiliates :</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><select name="other_affiliate_id" id="other_affiliate_id" class="select" onChange="setDefault('affiliate_id')">
<option value="" selected="selected">- Select -</option>
<?=$AllAffiliatesOptions;?>
</select></td>
  </tr> 
  <tr><td colspan="3"><hr></td></tr>
 <tr>
    <td width='41%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Promotional Code :</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><select name="tracking_no" id="tracking_no" class="select">
	
	<?=$promocodesOptions;?>
	</select>
	</td>
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
<td width='53%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="radio" id="used_rs" name="used_rs"  value="Yes" onClick="" />Yes&nbsp;<input type="radio" id="used_rs" name="used_rs" value="No" onClick="" />No</td>
</tr>
<tr>
<td width='44%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#FFFFFF solid 1px;'>If ("Yes"), Please Describe</td>
<td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
<td width='53%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><textarea name="usedoutsourcingstaff" cols="25" rows="5" class="select" ></textarea></td>
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
