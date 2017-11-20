<?
include './conf/zend_smarty_conf_root.php';
include 'function.php';

$id=$_REQUEST['id'];
$query ="SELECT * FROM leads WHERE id = $id;";
$row = $db->fetchRow($query);

	$tracking_no =$row['tracking_no'];
	$timestamp =$row['timestamp'];
	$status =$row['status'];
	$call_time_preference =$row['call_time_preference'];
	$remote_staff_competences =$row['remote_staff_competences'];
	$remote_staff_needed =$row['remote_staff_needed'];
	$remote_staff_needed_when =$row['remote_staff_needed_when'];
	$remote_staff_one_office =$row['remote_staff_one_office'];
	$remote_staff_one_home =$row['remote_staff_one_home'];
	$your_questions =$row['your_questions'];
		
	$lname =$row['lname'];
	$fname =$row['fname'];
	$company_position =$row['company_position'];
	$company_name =$row['company_name'];
	$company_address =$row['company_address'];
	$email =$row['email'];
	$website =$row['website'];
	$officenumber =$row['officenumber'];
	$mobile =$row['mobile'];
	$company_description =$row['company_description'];
	$company_industry =$row['company_industry'];
	$company_size =$row['company_size'];
	$outsourcing_experience =$row['outsourcing_experience'];
	$outsourcing_experience_description =$row['outsourcing_experience_description'];
	$company_turnover =$row['company_turnover'];
	$referal_program =$row['referal_program'];
	
	$your_questions=str_replace("\n","<br>",$your_questions);
	$outsourcing_experience_description=str_replace("\n","<br>",$outsourcing_experience_description);
	$company_description=str_replace("\n","<br>",$company_description);
	$rate =$row['rating'];
	
	$company_owner = $row['company_owner'];
	$contact = $row['contact'];
	$others = $row['others'];
	$accounts = $row['accounts'];
	
	if($rate=="1")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="2")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="3")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="4")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
		if($rate=="5")
		{
			$rate="<img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'><img src='images/star.gif' align='top' alt='$rate&nbsp;&nbsp;star'>";
		}
	
	





?>

<html>
<head>
<title>Leads &copy;ThinkInnovations.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/style.css">
</head>
<body bgcolor="#ffffff" topmargin="10" leftmargin="10" marginheight="10" marginwidth="10">


<script language=javascript src="js/functions.js"></script>

<table width="100%" cellpadding="0" cellspacing="0" border="0" >
<tr><td><img src="images/remotestafflogo.jpg" alt="think" width="416" height="108"></td>
	<td align="right" style="color:#FFFFFF;" valign="baseline">
	  
	  <a href="javascript:window.close();" style="FONT: bold 8pt verdana; color:#000000;">Close</a>&#160;&#160;
	</td>
</tr>
</table>
<img src="images/space.gif" height=8 width=1><br clear=all>


	<table width=100% cellspacing=0 cellpadding=1 align=center border=0 bgcolor=#CCCCCC>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td>&nbsp;&nbsp;<font style='font: bold 10pt verdana;'>Promotional Code : <? echo $tracking_no."<br>&nbsp;&nbsp;".$status;?></font></td></tr>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td>
	

<table width=100% cellspacing=1 cellpadding=3 align=center border=0 bgcolor=#ffffff>
<tr><td colspan="3" valign="top"><? if ($rate!="") {echo "<b>Ratings :&nbsp;" .$rate."</b>"; }?></td></tr>

<tr><td width="45%" valign="top" ><b>Date Registered</b></td>
<td width="1%" valign="top">:</td>
<td width="54%" valign="top"><? echo format_date($timestamp);?></td>
</tr>
<tr><td valign="top"><strong>Fullname</strong></td>
<td valign="top">:</td><td valign="top"><? echo $fname." ".$lname;?></td></tr>
<tr><td valign="top"><strong>Email</strong></td>
<td valign="top">:</td><td valign="top"><? echo $email;?></td></tr>
<tr><td valign="top"><strong>Company name</strong></td>
<td valign="top">:</td><td valign="top"><? echo $company_name;?></td></tr>
<tr><td valign="top"><strong>Job Position</strong></td>
<td valign="top">:</td><td valign="top"><? echo $company_position;?></td></tr>
<tr><td valign="top"><strong>Company Address</strong></td>
<td valign="top">:</td><td valign="top"><? echo $company_address;?></td></tr>
<tr><td valign="top"><strong>Website</strong></td>
<td valign="top">:</td><td valign="top"><? echo $website;?></td></tr>
<tr><td valign="top"><strong>Company No.</strong></td>
<td valign="top">:</td><td valign="top"><? echo $officenumber;?></td></tr>
<tr><td valign="top"><strong>Moblie No</strong></td>
<td valign="top">:</td><td valign="top"><? echo $mobile;?></td></tr>
<tr><td valign="top"><strong>No. of Employees</strong></td>
<td valign="top">:</td><td valign="top"><? echo $company_size;?></td></tr>
<tr><td valign="top"><strong>Company Turnover in a Year</strong></td>
<td valign="top">:</td><td valign="top"><? echo $company_turnover;?></td></tr>
<tr><td valign="top"><strong>Company Profile</strong></td>
<td valign="top">:</td><td valign="top"><ul style="margin-top:0px; margin-left:2px;"><? echo $company_description;?></ul></td></tr>

<tr><td colspan="3"><hr></td></tr>
<tr><td valign="top"><strong>No. of Remote Staff neeeded</strong></td>
<td valign="top">:</td><td valign="top"><? echo $remote_staff_needed;?></td></tr>
<tr><td valign="top"><strong>Remote Staff needed</strong></td>
<td valign="top">:</td><td valign="top"><? echo $remote_staff_needed_when;?></td></tr>

<tr><td valign="top"><strong>Remote Staff needed in Home Office</strong></td>
<td valign="top">:</td><td valign="top"><? echo $remote_staff_one_home;?></td></tr>
<tr><td valign="top"><strong>Remote Staff needed in Office</strong></td>
<td valign="top">:</td><td valign="top"><? echo $remote_staff_one_office;?></td></tr>
<tr><td valign="top"><strong>Remote Staff responsibilities</strong></td>
<td valign="top">:</td><td valign="top"><? echo $remote_staff_competences;?></td></tr>
<tr><td colspan="3"><hr></td></tr>
<tr><td valign="top"><strong>Questions / Concern</strong></td>
<td valign="top">:</td><td valign="top"><ul style="margin-top:0px; margin-left:2px;"><? echo $your_questions;?></ul></td></tr>
<? if($outsourcing_experience =="Yes")
echo "<tr><td valign=top><b>Outsourcing Experience / Details</b></td><td valign=top>:</td><td valign=top><ul style='margin-top:0px; margin-left:2px;'>".$outsourcing_experience_description."</ul></td></tr>";
?>

<tr><td colspan="3"><hr></td></tr>
<tr><td valign="top"><strong>Company Owner</strong></td>
<td valign="top">:</td><td valign="top"><? echo $company_owner;?></td></tr>
<tr><td colspan="3">For Staff Reporting</td></tr>
<tr><td valign="top"><strong>Contacts</strong></td>
<td valign="top">:</td><td valign="top"><? echo $contact;?></td></tr>
<tr><td valign="top"><strong>Accounts</strong></td>
<td valign="top">:</td><td valign="top"><? echo $others;?></td></tr>
<tr><td valign="top"><strong>Others</strong></td>
<td valign="top">:</td><td valign="top"><? echo $accounts;?></td></tr>




		</table>
		
		
	</td></tr>
	</table>

	</body>
	</html>

