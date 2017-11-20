<?php
// 2010-12-20 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Add timezone_id
// 2010-01-14 mike s. lacanilao <mike.lacanilao@remotestaff.com.au>
// -- password input field changed to blank, only for updating

include './conf/zend_smarty_conf.php';
if($_SESSION['client_id']=="")
{
	header("location:index.php");
	exit;
}
$client_id = $_SESSION['client_id'];
$page=$_REQUEST['page'];
$query ="SELECT * FROM leads WHERE id = $client_id;";
$result = $db->fetchRow($query);


$tracking_no =$result['tracking_no'];
$call_time_preference =$result['call_time_preference'];
$remote_staff_competences =$result['remote_staff_competences'];
$remote_staff_needed =$result['remote_staff_needed'];
$remote_staff_needed_when =$result['remote_staff_needed_when'];
$remote_staff_one_office =$result['remote_staff_one_office'];
$your_questions =$result['your_questions'];
	
$lname =$result['lname'];
$fname =$result['fname'];
$company_position =$result['company_position'];
$company_name =$result['company_name'];
$company_address =$result['company_address'];
$email =$result['email'];
$password=$result['password'];
$website =$result['website'];
$officenumber =$result['officenumber'];
$mobile =$result['mobile'];
$company_description =$result['company_description'];
$company_industry =$result['company_industry'];
$company_size =$result['company_size'];
$outsourcing_experience =$result['outsourcing_experience'];
$outsourcing_experience_description =$result['outsourcing_experience_description'];
$company_turnover =$result['company_turnover'];
$referal_program =$result['referal_program'];
$company_owner = $result['company_owner'];
$contact = $result['contact'];
$others = $result['others'];
$accounts= $result['accounts'];
$timezone_id = $result['timezone_id'];


//$your_questions=str_replace("\n","<br>",$your_questions);

if($outsourcing_experience=="Yes")
{
	$check="checked='checked'";
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


$sql = $db->select()
        ->from('timezone_lookup')
        ->order('timezone asc');
$timezones = $db->fetchAll($sql);

$timezone_options = '<option value="">Select Timezone</option>';
foreach($timezones as $timezone) {
    if ($timezone['timezone'] == 'PST8PDT') {
        $timezone['timezone'] = 'San Francisco';
    }
    if ($timezone['id'] == $timezone_id) {
        $timezone_options .= sprintf("<option selected='selected' value='%s'>%s</option>", $timezone['id'], $timezone['timezone']);
    }
    else {
        $timezone_options .= sprintf("<option value='%s'>%s</option>", $timezone['id'], $timezone['timezone']);
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
<title>My Account-Client</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<script language=javascript src="js/functions.js"></script>
<script type="text/javascript">
<!--
function checkFields()
{
	
	missinginfo = "";
	
	if (document.form.fname.value == "")
	{
		missinginfo += "\n     -  Please enter your First name";
	}
	if (document.form.lname.value == "")
	{
		missinginfo += "\n     -  Please enter your Last name";
	}
	
	if (document.form.email.value == "")
	{
		missinginfo += "\n     -  Please site a email address"; //
	}
	
		
	if (missinginfo != "")
	{
		missinginfo =" " + "You failed to correctly fill in the required information:\n" +
		missinginfo + "\n\n";
		alert(missinginfo);
		return false;
	}
	else return true;
	
}



function showhide(str)
{
	if(str=="Yes")
	{
		newitem1="<p><label>Type it here</label>";
		newitem1+="<br>";
	 	newitem1+="<textarea name=\"usedoutsourcingstaff\" +";
		newitem1+="\" cols=\"25\" rows=\"5\" class=\"select\"><?php echo $outsourcing_experience_descriptio;?></textarea></p><p></p>";
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
<form action="myaccountphp.php" id="form" name="form" method="post" onSubmit="return checkFields();">
<!-- HEADER -->
<?php include 'header.php';?>
<?php include 'client_top_menu.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr><td width="24%"style="border-right: #006699 2px solid; width: 170px; vertical-align:top;"><?php include 'clientleftnav.php';?></td>
<td width="76%" >
<table width="60%"  cellspacing="0" cellpadding="3" style="border:#CCCCCC solid 1px; margin-left:10px; margin-top:20px; margin-bottom:20px;">
<tr bgcolor="#CCCCCC">
<td height="21" colspan="3" valign="middle" style="border-bottom:#666666 solid 1px;"><font color="#000000"><B>Account Information</B></font></tr>

<tr><td height="33" colspan="3"><strong>Log In Details</strong></td></tr>
 <tr>
    <td width='40%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Email </td>
    <td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><?php echo $email;?><input type="hidden" id="email" name="email" class="select" value="<?php echo $email;?>"  /></td>
  </tr>
  
   <tr>
    <td width='40%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Password </td>
    <td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="password" id="password" name="password" class="select" value=""  /><br />
	<span class='tip'>Enter value if you want to change your password.</span></td>
  </tr>
  <tr><td height="33" colspan="3"><strong>Personal Details</strong></td></tr>
  <tr>
    <td width='40%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>First Name </td>
    <td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><?php echo $fname;?><input type="hidden" id="fname" name="fname" class="select" value="<?php echo $fname;?>" /></td>
  </tr>
  <tr>
    <td width='40%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Last Name </td>
    <td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><?php echo $lname;?><input type="hidden" id="lname" name="lname" class="select" value="<?php echo $lname;?>"/></td>
  </tr>
 
  
  
  <tr>
    <td width='40%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Name</td>
    <td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="companyname" name="companyname" class="select"  value="<?php echo $company_name;?>" /></td>
  </tr>
  <tr>
    <td width='40%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Position</td>
    <td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="companyposition" name="companyposition" class="select" value="<?php echo $company_position;?>" /></td>
  </tr>
  <tr>
    <td width='40%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Address</td>
    <td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="companyaddress" name="companyaddress" class="select" value="<?php echo $company_address;?>"  /></td>
  </tr>
  <tr>
    <td width='40%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Office Number</td>
    <td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="officenumber" name="officenumber"  class="select" value="<?php echo $officenumber;?>" /></td>
  </tr>
  <tr>
    <td width='40%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Mobile No. </td>
    <td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="mobile" name="mobile"  class="select" value="<?php echo $mobile;?>" /></td>
  </tr>
  <tr>
    <td width='40%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Preferred Timezone </td>
    <td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>
        <select name="timezone_id" id="timezone_id"  class="select"  >
            <?php echo  $timezone_options;?> 
        </select>
    </td>
  </tr>
  <tr>
    <td width='40%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Industry</td>
    <td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><select name="industry" id="industry"  class="select"  >
	<option selected="selected" value="0">Select an industry</option>
	<?php echo  $industryoptions;?>

</select></td>
  </tr>
  <tr>
    <td width='40%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>No. of Employees</td>
    <td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="noofemployee" name="noofemployee" class="select" value="<?php echo $company_size;?>"  /></td>
  </tr>
   <tr>
    <td width='40%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Website</td>
    <td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><input type="text" id="website" name="website" class="select" value="<?php echo $website;?>"  /></td>
  </tr>
  <tr>
    <td width='40%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'>Company Description</td>
    <td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
    <td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><textarea cols="25" rows="5" name="companydesc" id="companydesc" class="select" ><?php echo $company_description;?></textarea></td>
  </tr>
 

<tr>
<td width='40%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>Company Turnover</td>
<td width='3%' valign='top' style='border-bottom:#FFFFFF solid 1px;'>:</td>
<td width='57%' valign='top' style='border-left:#FFFFFF solid 1px; border-bottom:#FFFFFF solid 1px;'><select name="companyturnover" class="select">
<option value="-">-</option>
<?php echo $moneyoptions;?>
</select></td>
</tr>
  <tr><td colspan="3"><hr></td></tr>
<tr><td valign="top">Company Owner</td>
<td valign="top">:</td><td valign="top" ><input id="company_owner" name="company_owner" type="text" class="select" value="<?php echo $company_owner;?>"></td></tr>
<tr><td colspan="3" >For Staff Reporting</td></tr>
<tr><td valign="top">Contacts</td>
<td valign="top">:</td><td valign="top" ><input id="contact" name="contact" type="text" class="select" value="<?php echo $contact;?>"></td></tr>
<tr><td valign="top">Accounts</td>
<td valign="top">:</td><td valign="top" ><input id="others" name="others" type="text" class="select" value="<?php echo $others;?>" ></td></tr>
<tr><td valign="top">Others</td>
<td valign="top">:</td><td valign="top" ><input id="accounts" name="accounts" type="text" class="select" value="<?php echo $accounts;?>"></td></tr>


</table>
</td>

</tr>
<tr>
<td colspan="3" style="border-top:#666666 solid 1px;">&nbsp;</td>
</tr>
<tr bgcolor="#FFFFFF">
<td colspan="3" valign="middle"  height="30" style="border-bottom:#666666 solid 1px;" align="center">
<p align="center"><font color="#999999" size="1"><b>Tracking Code : <?php echo $tracking_no;?></b></font><br />
<input type="submit" value="Update Form" class="button" />
</p>


</td></tr>
</table></td>
</tr>
</table>
</form>
<?php include 'footer.php';?>

</body>
</html>
