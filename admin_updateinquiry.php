<?php
/*
2010 -05-19 Normaneil Macutay <normaneil.macutay@gmail.com>
	- added leads information changes history

*/
include './conf/zend_smarty_conf_root.php';
include './lib/addLeadsInfoHistoryChanges.php';
if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
$url=$_GET['url'];
//echo $url; 

$leads_id = $_REQUEST['leads_id'];
if($leads_id==""){
	die("Leads ID is Missing. Please try again later.");
}

$page=$_REQUEST['page'];

$query ="SELECT * FROM leads WHERE id = $leads_id;";
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



$leads_country = $result['leads_country'];

$company_owner = $result['company_owner'];
$contact = $result['contact'];
$others = $result['others'];
$accounts= $result['accounts'];


$acct_dept_name1 = $result['acct_dept_name1']; 
$acct_dept_name2 = $result['acct_dept_name2'];
$acct_dept_contact1 = $result['acct_dept_contact1'];
$acct_dept_contact2 = $result['acct_dept_contact2']; 
$acct_dept_email1 = $result['acct_dept_email1']; 
$acct_dept_email2 = $result['acct_dept_email2'];
$supervisor_staff_name = $result['supervisor_staff_name']; 
$supervisor_job_title = $result['supervisor_job_title'];
$supervisor_skype = $result['supervisor_skype']; 
$supervisor_email = $result['supervisor_email'];
$supervisor_contact = $result['supervisor_contact']; 
$business_owners = $result['business_owners'];
$business_partners =$result['business_partners'];	


$agent_id = $result['agent_id'];
$business_partner_id = $result['business_partner_id'];

$location_id = $result['location_id'];


$sql = $db->select()
	->from('leads_location_lookup');
$leads_locations = $db->fetchAll($sql);
foreach($leads_locations as $leads_location){
	if($location_id == $leads_location['id']){
		$leads_location_options .= "<option selected value=".$leads_location['id'].">".$leads_location['location']."</option>\n";
	}else{
		$leads_location_options .= "<option value=".$leads_location['id'].">".$leads_location['location']."</option>\n";
	}
}




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
 
 
$countrynames = array(
	    "Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Ascension Island","Australia","Austria",
	    "Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia-Herzegovina","Botswana","Bouvet Island",
	    "Brazil","British Indian O. Terr.","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Rep.","Chad","Chile","China",
	    "Christmas Island","Cocos (Keeling) Isl.","Colombia","Comoros","Congo","Cook Islands","Costa Rica","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Diego Garcia","Djibouti","Dominica",
	    "Dominican Republic","East Timor","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Isl. (Malvinas)","Faroe Islands","Fiji","Finland","France","France (European Ter.)",
	    "French Southern Terr.","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Great Britain (UK)","Greece","Greenland","Grenada","Guadeloupe (Fr.)","Guam (US)","Guatemala","Guinea",
	    "Guinea Bissau","Guyana","Guyana (Fr.)","Haiti","Heard &amp; McDonald Isl.","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel",
	    "Italy","Ivory Coast","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea (North)","Korea (South)","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon",
	    "Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia (former Yugo.)","Madagascar (Republic of)","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands",
	    "Martinique (Fr.)","Mauritania","Mauritius","Mayotte","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru",
	    "Nepal","Netherland Antilles","Netherlands","New Caledonia (Fr.)","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","Northern Mariana Isl.","Norway","Oman","Pakistan","Palau",
	    "Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Polynesia (Fr.)","Portugal","Puerto Rico (US)","Qatar","Reunion (Fr.)","Romania","Russian Federation","Rwanda",
	    "Saint Lucia","Samoa","San Marino","Saudi Arabia","Senegal","Seychelles","Sierra Leone","Singapore","Slovakia (Slovak Rep)","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia  and  South Sand","Spain",
	    "Sri Lanka","St. Helena","St. Pierre &amp; Miquelon","St. Tome and Principe","St.Kitts Nevis Anguilla","St.Vincent &amp; Grenadines","Sudan","Suriname","Svalbard &amp; Jan Mayen Is","Swaziland","Sweden","Switzerland","Syria","Tadjikistan","Taiwan",
	    "Tanzania","Thailand","Togo","Tokelau","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom",
	    "United States","Uruguay","US Minor outlying Isl.","Uzbekistan","Vanuatu","Vatican City State","Venezuela","Vietnam","Virgin Islands (British)","Virgin Islands (US)","Wallis &amp; Futuna Islands","Western Sahara","Yemen","Yugoslavia","Zaire",
	    "Zambia","Zimbabwe");
		
 for ($count = 0; $count < count($countrynames); $count++) {
      if($leads_country == $countrynames[$count])
      {
	 $countryoptions .= "<option selected value=\"$countrynames[$count]\">$countrynames[$count]</option>\n";
      }
      else
      {
	 $countryoptions .= "<option value=\"$countrynames[$count]\">$countrynames[$count]</option>\n";
      }
	  
   }
 
$sql="SELECT agent_no,fname,lname,work_status FROM agent WHERE status='ACTIVE' ORDER BY work_status DESC;";
$result = $db->fetchAll($sql);
foreach ($result as $result) {
   if($agent_id == $result['agent_no']){
		$agentOptions.="<option selected value=".$result['agent_no'].">".$result['work_status']." -->".$result['fname']."&nbsp;".$result['lname']."</option>";
	}
	else{
		$agentOptions.="<option value=".$result['agent_no'].">".$result['work_status']." -->".$result['fname']."&nbsp;".$result['lname']."</option>";
	}	
}


$sql="SELECT * FROM agent WHERE status='ACTIVE' ORDER BY fname ASC;";
$result = $db->fetchAll($sql);
foreach ($result as $result) {
	if($result['work_status']=="BP"){
		if($business_partner_id == $result['agent_no']){
   			$BPOptions.="<option selected value=".$result['agent_no'].">".$result['fname']."&nbsp;".$result['lname']."</option>";
		}else{
			$BPOptions.="<option value=".$result['agent_no'].">".$result['fname']."&nbsp;".$result['lname']."</option>";
		}
    }else{
		if($agent_id == $result['agent_no']){
			$AFFOptions.="<option selected value=".$result['agent_no'].">".$result['fname']."&nbsp;".$result['lname']."</option>";
		}else{
			$AFFOptions.="<option value=".$result['agent_no'].">".$result['fname']."&nbsp;".$result['lname']."</option>";
		}	
	}
		
}




//echo $agent_id."<br>";
//echo $business_partner_id;
if($agent_id != $business_partner_id){
	$affiliate_id = $agent_id;
}	
?>

<html>
<head>
<title>Update Leads  Form</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/MochiKit.js"></script>
<script type="text/javascript" src="js/admin_add_lead.js"></script>
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form action="admin_updateinquiryphp.php" id="form" name="form" method="post" onSubmit="return checkFields();">
<input type="hidden" name="leads_id" value="<? echo $leads_id;?>" />
<input type="HIDDEN" name="page" value="<? echo $page;?>" />
<input type="hidden" name="promocode" id="promocode" value="<?php echo $tracking_no;?>">
<input type="HIDDEN" name="url" value="<?php echo $url;?>" />
<input type="HIDDEN" name="lead_status" value="<?php echo $_GET['lead_status'];?>">

<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 >

<tr><td valign="top" width="158" style="border-right: #006699 2px solid;">
<? include 'adminleftnav.php';?>
</td>
<td width=1093 valign='top'  >
<?php if ($url!="") {?>
	<input type="button" class="btn" value="Back" onClick="self.location='<?php echo $url;?>&lead_status=<?php echo $_GET['lead_status'];?>'"/>
<? } ?>
<table width="60%" cellspacing="1" cellpadding="5" bgcolor="#CCCCCC" style="margin-left:50px; margin-top:5px;">
<tr><td colspan="2"><b>Leads Allocation</b></td></tr>

<tr bgcolor="#FFFFFF">
<td width="45%" align="right">Leads Location</td>
<td width="55%"><select name="leads_location" id="leads_location" class="select" >
	<option value="0">- Select -</option>
	<?php echo $leads_location_options;?>
	</select></td>
</tr>


<tr bgcolor="#FFFFFF">
<td align="right">Business Partner</td>
<td><div><select name="agent" id="agent" class="select" onChange="getAgentsPromocodes(this.value);getBusinessPartnerAffiliates();">
	<option value="0">- Select -</option>
	<?php echo $BPOptions;?>
	</select></div>
	</td>
</tr>


<tr bgcolor="#FFFFFF">
<td align="right">Business Partner Affiliates</td>
<td><div id="agent_affiliates">
	<select name="affiliate_id" id="affiliate_id" class="select" onChange="setDefault('other_affiliate_id')" disabled="disabled">
	<option value=""></option>
	</select>
	</div></td>
</tr>


<tr bgcolor="#FFFFFF">
<td align="right">Promotional Code</td>
<td><div id="agent_promocodes">
	<select name="tracking_no" id="tracking_no" class="select" >
	<option value="0">-</option>
</select>
</div></td>
</tr>


<tr bgcolor="#FFFFFF">
<td align="right">All Affiliates</td>
<td><select name="other_affiliate_id" id="other_affiliate_id" class="select" onChange="getAgentsPromocodes(this.value);setDefault('affiliate_id');">
	<option value="">-</option>
	<?php echo $AFFOptions;?>
	</select></td>
</tr>

<tr bgcolor="#FFFFFF">
<td align="right">Country</td>
<td><select name="nationality" id="nationality" class="select" >
<option value="">-</option>
<?php echo $countryoptions;?>
</select></td>
</tr>

<tr bgcolor="#FFFFFF">
<td align="right">First Name</td>
<td><input type="text" id="fname" name="fname" class="select" value="<?php echo $fname;?>" /></td>
</tr>

<tr bgcolor='#FFFFFF'>
    <td align="right" >Last Name </td>
    
    <td ><input type="text" id="lname" name="lname" class="select" value="<? echo $lname;?>"/></td>
  </tr>
  <tr bgcolor='#FFFFFF'>
    <td align="right">Email </td>
    
    <td ><input type="text" id="email" name="email" class="select" value="<? echo $email;?>"  /></td>
  </tr>
  <tr bgcolor='#FFFFFF'>
    <td align="right">Company Name</td>
    
    <td ><input type="text" id="companyname" name="companyname" class="select"  value="<? echo $company_name;?>" /></td>
  </tr>
  <tr bgcolor='#FFFFFF'>
    <td align="right">Company Position</td>
    
    <td ><input type="text" id="companyposition" name="companyposition" class="select" value="<? echo $company_position;?>" /></td>
  </tr>
  <tr bgcolor='#FFFFFF'>
    <td align="right">Company Address</td>
    
    <td ><input type="text" id="companyaddress" name="companyaddress" class="select" value="<? echo $company_address;?>"  /></td>
  </tr>
  <tr bgcolor='#FFFFFF'>
    <td align="right">Office Number</td>
    
    <td ><input type="text" id="officenumber" name="officenumber"  class="select" value="<? echo $officenumber;?>" /></td>
  </tr>
  <tr bgcolor='#FFFFFF'>
    <td align="right" >Mobile No. </td>
    
    <td ><input type="text" id="mobile" name="mobile"  class="select" value="<? echo $mobile;?>" /></td>
  </tr>
  <tr bgcolor='#FFFFFF'>
    <td align="right">Company Industry</td>
    
    <td ><select name="industry" id="industry"  class="select"  >
	<option selected="selected" value="0">Select an industry</option>
	<? echo  $industryoptions;?>

</select></td>
  </tr>
  <tr bgcolor='#FFFFFF'>
    <td align="right">No. of Employees</td>
    
    <td ><input type="text" id="noofemployee" name="noofemployee" class="select" value="<? echo $company_size;?>"  /></td>
  </tr>
   <tr bgcolor='#FFFFFF'>
    <td align="right">Website</td>
    
    <td ><input type="text" id="website" name="website" class="select" value="<? echo $website;?>"  /></td>
  </tr>
  <tr bgcolor='#FFFFFF'>
    <td align="right">Company Description</td>
    
    <td ><textarea cols="25" rows="5" name="companydesc" id="companydesc" class="select" ><? echo $company_description;?></textarea></td>
  </tr>

<tr bgcolor="#CCCCCC"><td colspan="2"><b>Leads Accounts Department Information</b></td></tr>
<tr bgcolor="#FFFFFF"><td align='right'>Accounts Department Staff Name 1</td>
<td valign="top"><input type="text" id="acct_dept_name1" name="acct_dept_name1" class="select" value="<? echo $acct_dept_name1;?>"  /></td></tr>
<tr bgcolor="#FFFFFF"> <td align='right'>Accounts Department Email 1</td>
<td valign="top"><input type="text" id="acct_dept_email1" name="acct_dept_email1" class="select" value="<? echo $acct_dept_email1;?>"  /></td></tr>
<tr bgcolor="#FFFFFF"><td align='right'>Accounts Department Contact nos. 1</td>
<td valign="top"><input type="text" id="acct_dept_contact1" name="acct_dept_contact1" class="select" value="<? echo $acct_dept_contact1;?>"  /></td></tr>


<tr bgcolor="#FFFFFF"><td align='right'>Accounts Department Staff Name 2</td>
<td valign="top"><input type="text" id="acct_dept_name2" name="acct_dept_name2" class="select" value="<? echo $acct_dept_name2;?>"  /></td></tr>
<tr bgcolor="#FFFFFF"><td align='right'>Accounts Department Email 2</td>
<td valign="top"><input type="text" id="acct_dept_email2" name="acct_dept_email2" class="select" value="<? echo $acct_dept_email2;?>"  /></td></tr>
<tr bgcolor="#FFFFFF"><td align='right'>Accounts Department Contact nos. 2</td>
<td valign="top"><input type="text" id="acct_dept_contact2" name="acct_dept_contact2" class="select" value="<? echo $acct_dept_contact2;?>"  /></td></tr>
<!--
<tr bgcolor='#FFFFFF'>
<td align='right'>Preffered Time to Call</td>

<td ><select name="time" class="select"  >
<?php // echo $timeoptions;?>
</select></td>
</tr>
-->
<tr bgcolor='#FFFFFF'>
<td align='right'>RemoteStaff Responsibilities</td>

<td ><textarea cols="25" rows="5" class="select" name="jobresponsibilities"  id="jobresponsibilities" ><? echo $remote_staff_competences;?></textarea></td>
</tr>
<tr bgcolor='#FFFFFF'>
<td align='right'>No. of RemoteStaff needed</td>

<td ><input type="text" id="rsnumber" name="rsnumber" class="select" value="<? echo $remote_staff_needed;?>" /></td>
</tr>
<tr bgcolor='#FFFFFF'>
<td align='right'>When will you need remote staff? </td>

<td ><select name="needrs" class="select">
<? echo $whenoptions;?>
</select></td>
</tr>

<tr bgcolor='#FFFFFF'>
<td align='right'>RemoteStaff working from a home </td>

<td ><select name="rsinhome" class="select">
<option value="">-</option>
<option value="Yes">Yes</option>
<option value="No">No</option>
</select></td>
</tr>

<tr bgcolor='#FFFFFF'>
<td align='right'>or from one of our Philippines office </td>

<td ><select name="rsinoffice" class="select">
    <? echo $answeroptions;?>
  </select></td>
</tr>

<tr bgcolor='#FFFFFF'>
<td align='right'>Questions/Concerns</td>

<td ><textarea name="questions" cols="25" rows="5" class="select" ><? echo $your_questions;?></textarea></td>
</tr>
<!--
<tr bgcolor='#FFFFFF'>
<td align='right'>Have you use any outsourcing staff in the past?.</td>

<td ><input type="radio" id="used_rs" name="used_rs"  value="Yes" onClick="" />Yes&nbsp;<input type="radio" id="used_rs" name="used_rs" value="No" onClick="" />No</td>
</tr>
<tr bgcolor='#FFFFFF'>
<td align='right'>Please Describe</td>

<td ><textarea cols="25" rows="5" class="select" name="usedoutsourcingstaff"  id="usedoutsourcingstaff" ><?php //echo $outsourcing_experience_descriptio;?></textarea></td>
</tr>
-->


<tr bgcolor='#FFFFFF'>
<td align='right'>Company Turnover</td>

<td ><select name="companyturnover" class="select">
<option value="-">-</option>
<? echo $moneyoptions;?>
</select></td>
</tr>

<tr bgcolor="#CCCCCC"><td colspan="2"><b>Person directly working with sub-contractor in client organization</b></td></tr>
<tr bgcolor='#FFFFFF'><td align = 'right'>Name</td>
<td valign="top"><input type="text" id="supervisor_staff_name" name="supervisor_staff_name" class="select" value="<? echo $supervisor_staff_name;?>"  /></td></tr>
<tr bgcolor='#FFFFFF'><td align = 'right'>Job Title</td>
<td valign="top"><input type="text" id="supervisor_job_title" name="supervisor_job_title" class="select" value="<? echo $supervisor_job_title;?>"  /></td></tr>
<tr bgcolor='#FFFFFF'><td align = 'right'>Skype</td>
<td valign="top"><input type="text" id="supervisor_skype" name="supervisor_skype" class="select" value="<? echo $supervisor_skype;?>"  /></td></tr>
<tr bgcolor='#FFFFFF'><td align = 'right'>Email</td>
<td valign="top"><input type="text" id="supervisor_email" name="supervisor_email" class="select" value="<? echo $supervisor_email;?>"  /></td></tr>
<tr bgcolor='#FFFFFF'><td align = 'right'>Contact</td>
<td valign="top"><input type="text" id="supervisor_contact" name="supervisor_contact" class="select" value="<? echo $supervisor_contact;?>"  /></td></tr>
<tr bgcolor='#FFFFFF'><td align = 'right'>Business Owner/Director/CEO</td>
<td valign="top"><input type="text" id="business_owners" name="business_owners" class="select" value="<? echo $business_owners;?>"  /></td></tr>
<tr bgcolor='#FFFFFF'><td align = 'right'>Business Partners</td>
<td valign="top"><input type="text" id="business_partners" name="business_partners" class="select" value="<? echo $business_partners;?>"  /></td></tr>

<tr bgcolor="#FFFFFF">
<td colspan="2" valign="middle"  height="30" style="border-bottom:#666666 solid 1px;" align="center">
<p align="center"><font color="#999999" size="1"><b>Tracking Code : <? echo $tracking_no;?></b></font><br />
<input type="submit" value="Update Form" class="button" />
</p>


</td></tr>


</table>

<?php showLeadsInfoHistory($leads_id , 'no' , 10);?>



<!-- -->
</td>
</tr></table>
</form>
<script type="text/javascript">
<!--
//getAgentsPromocodes();
getBusinessPartnerAffiliates(<?php echo $affiliate_id;?>);
<?php
if($agent_id != $business_partner_id){
?>
	getAgentsPromocodes(<?php echo $affiliate_id;?>);
<?	
}else{ ?>
	getAgentsPromocodes(<?php echo $business_partner_id;?>);
<?	
}
?>

-->
</script>


<? include 'footer.php';?>

</body>
</html>
