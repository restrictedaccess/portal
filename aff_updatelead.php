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
//// Leads Information
$leads_id = $_REQUEST['leads_id'];

$query ="SELECT * FROM leads WHERE id = $leads_id;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	//$row = mysql_fetch_array ($result, MYSQL_NUM); 
	$row = mysql_fetch_array($result);
	$tracking_no =$row['tracking_no'];
	$call_time_preference =$row['call_time_preference'];
	$remote_staff_competences =$row['remote_staff_competences'];
	$remote_staff_needed =$row['remote_staff_needed'];
	$remote_staff_needed_when =$row['remote_staff_needed_when'];
	$remote_staff_one_office =$row['remote_staff_one_office'];
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
	
	//$your_questions=str_replace("\n","<br>",$your_questions);

	if($outsourcing_experience=="Yes")
	{
		$check="checked='checked'";
	}	
	
}




///////////////////
$timeArray=array("9am to 10am","10am to 11am","11am to 12pm","12pm to 1pm","1pm to 2pm","2pm to 3pm","3pm to 4pm","4pm to 5pm","5pm to 6pm","6pm to 7pm","7pm Sharp");
for ($i = 0; $i < count($timeArray); $i++) {
      if($call_time_preference == $timeArray[$i])
      {
	 $timeoptions .= "<option selected value=\"$timeArray[$i]\">$timeArray[$i]</option>\n";
      }
      else
      {
	 $timeoptions .= "<option value=\"$timeArray[$i]\">$timeArray[$i]</option>\n";
      }
   }	

$whenArray = array("Within 2 weeks","Within 1 month","Over the next few Months","ASAP");
for ($i = 0; $i < count($whenArray); $i++) {
      if($remote_staff_needed_when == $whenArray[$i])
      {
	 $whenoptions .= "<option selected value=\"$whenArray[$i]\">$whenArray[$i]</option>\n";
      }
      else
      {
	 $whenoptions .= "<option value=\"$whenArray[$i]\">$whenArray[$i]</option>\n";
      }
   }	


if($remote_staff_one_office == "Yes")
      {
	 $answeroptions = "<option value='Yes' selected='selected'>Yes</option>
   					  <option value='No'>No</option>";
      }
      else
      {
	 $answeroptions = "<option value='Yes' >Yes</option>
   					   <option value='No' selected='selected'>No</option>";
      }
$indutryArray=array("Accounting","Administration","Advert./Media/Entertain.","Banking & Fin. Services","Call Centre/Cust. Service","Community & Sport","Construction","Consulting & Corp. Strategy","Education & Training","Engineering","Government/Defence","Healthcare & Medical","Hospitality & Tourism","HR & Recruitment","Insurance & Superannuation","I.T. & T","Legal","Manufacturing/Operations","Mining, Oil & Gas","Primary Industry","Real Estate & Property","Retail & Consumer Prods.","Sales & Marketing","Science & Technology","Self-Employment","Trades & Services","Transport & Logistics");  
for ($i = 0; $i < count($indutryArray); $i++) {
      if($company_industry == $indutryArray[$i])
      {
	 $industryoptions .= "<option selected value=\"$indutryArray[$i]\">$indutryArray[$i]</option>\n";
      }
      else
      {
	 $industryoptions .= "<option value=\"$indutryArray[$i]\">$indutryArray[$i]</option>\n";
      }
   }	

$moneyArray=array("$0 to $300,000","$300,000 to $700,000","$700,000 to $1.2m","$1.2m to $2m","$2m to $3m","$3 to $5m","Above $5m");
for ($i = 0; $i < count($moneyArray); $i++) {
      if($company_turnover == $moneyArray[$i])
      {
	 $moneyoptions .= "<option selected value=\"$moneyArray[$i]\">$moneyArray[$i]</option>\n";
      }
      else
      {
	 $moneyoptions .= "<option value=\"$moneyArray[$i]\">$moneyArray[$i]</option>\n";
      }
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
<form method="POST" name="form" action="aff_updateleadphp.php" accept-charset = "utf-8" onSubmit="return CheckInputs()">
<input type="HIDDEN" name="leads_id" value="<? echo $leads_id;?>" />
<table width="1000px;" align="center" style="background:#FFFFFF; margin-top:10px; border:#E7F0F5 ridge 1px;">
<tr><td><div><img src="images/remotestafflogo.jpg"></div></td></tr>
<tr><td valign="top"><? include 'AFF_header.php';?>
</td></tr>
<tr>
<td height="54" valign="top">
<!-- Contents Here -->
<h3 class="h3_style">Affiliate System</h3>
<div class="welcome">
Welcome <?php echo $name;?></div>
<div class="logout"><a href="logout.php">Logout</a></div>
<div style="clear:both"></div>
<table width="99%">
<tr>
<td width="230px" valign="top"><?php include 'aff_leftnav.php';?></td>
<td width="81%" valign="top">
<?php
if($mess==1){
	echo "<p align='center'><b>Updated Successfuly !</b></p>";
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

<div class="box_blue" >Update Lead</div>
<div class="box_blue_content" >
<table cellspacing="0" style="border:#666666 solid 1px;">
<td width="50%" valign="top"><table width="100%"  cellspacing="0" cellpadding="3">
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>First Name </td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="fname" name="fname" class="select" value="<? echo $fname;?>" /></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Last Name </td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="lname" name="lname" class="select" value="<? echo $lname;?>"/></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Email </td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="email" name="email" class="select" value="<? echo $email;?>"  /></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Name</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="companyname" name="companyname" class="select"  value="<? echo $company_name;?>" /></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Position</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="companyposition" name="companyposition" class="select" value="<? echo $company_position;?>" /></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Address</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="companyaddress" name="companyaddress" class="select" value="<? echo $company_address;?>"  /></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Office Number</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="officenumber" name="officenumber"  class="select" value="<? echo $officenumber;?>" /></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Mobile No. </td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="mobile" name="mobile"  class="select" value="<? echo $mobile;?>" /></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Industry</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><select name="industry" id="industry"  class="select"  >
	<option selected="selected" value="0">Select an industry</option>
	<? echo  $industryoptions;?>

</select></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>No. of Employees</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="noofemployee" name="noofemployee" class="select" value="<? echo $company_size;?>"  /></td>
  </tr>
   <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Website</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="website" name="website" class="select" value="<? echo $website;?>"  /></td>
  </tr>
  <tr>
    <td width='32%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Description</td>
    <td width='2%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='66%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><textarea cols="25" rows="5" name="companydesc" id="companydesc" class="select" ><? echo $company_description;?></textarea></td>
  </tr>
</table></td>
<td width="50%" valign="top">
<table width="100%"  cellspacing="0" cellpadding="3">
<td width='44%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#FFFFFF solid 1px;'>Preffered Time to Call</td>
<td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
<td width='53%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><select name="time" class="select"  >
<? echo $timeoptions;?>
</select></td>
</tr>
<tr>
<td width='44%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#FFFFFF solid 1px;'>RemoteStaff Responsibilities</td>
<td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
<td width='53%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><textarea cols="25" rows="5" class="select" name="jobresponsibilities"  id="jobresponsibilities" ><? echo $remote_staff_competences;?></textarea></td>
</tr>
<tr>
<td width='44%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#FFFFFF solid 1px;'>No. of RemoteStaff needed</td>
<td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
<td width='53%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="rsnumber" name="rsnumber" class="select" value="<? echo $remote_staff_needed;?>" /></td>
</tr>
<tr>
<td width='44%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#FFFFFF solid 1px;'>When will you need remote staff? </td>
<td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
<td width='53%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><select name="needrs" class="select">
<? echo $whenoptions;?>
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
    <? echo $answeroptions;?>
  </select></td>
</tr>

<tr>
<td width='44%' valign='top' style='border-left:#666666 solid 1px; border-bottom:#FFFFFF solid 1px;'>Questions/Concerns</td>
<td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
<td width='53%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><textarea name="questions" cols="25" rows="5" class="select" ><? echo $your_questions;?></textarea></td>
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
<option value="-">-</option>
<? echo $moneyoptions;?>
</select></td>
</tr>
</table></td>
</tr>
<tr>
<td colspan="3" style="border-top:#666666 solid 1px;">&nbsp;</td>
</tr>
<tr bgcolor="#FFFFFF">
<td colspan="3" valign="middle"  height="30" style="border-bottom:#666666 solid 1px;" align="center">
<p align="center"><font color="#999999" size="1"><b>Tracking Code : <? echo $tracking_no;?></b></font><br />
<input type="submit" value="Update Form" class="button" />
</p>


</td></tr>
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