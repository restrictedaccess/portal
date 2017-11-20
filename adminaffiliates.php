<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
include 'time.php';

$mess=$_REQUEST['mess'];

if($mess==1)
{
	$mess="New Admin user added successfully!";
}

if($mess==2)
{
	$mess="Update successfully!";
}


//$AusTime = date("H:i:s"); 
//$AusDate = date("Y")."-".date("m")."-".date("d");
//$AustodayDate = date ("jS \of F Y");
//$ATZ = $AusDate." ".$AusTime;
$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];
/*
admin_id, admin_fname, admin_lname, admin_email, admin_password, admin_created_on, status
*/
$query="SELECT * FROM admin WHERE admin_id=$admin_id;";

$result=mysqli_query($link2, $query);
$ctr=@mysqli_num_rows($result);
if ($ctr >0 )
{
	$row = mysqli_fetch_array ($result); 
	$name = $row['admin_lname'].",  ".$row['admin_fname'];
	
}
$id=$_REQUEST['id'];
$edit=$_REQUEST['edit'];
$delete=$_REQUEST['delete'];

if($edit=="TRUE")
{	//agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn, email2, status
	$sql="SELECT lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, email2, status, hosting,country_location,commission_type FROM agent WHERE agent_no=$id;";
	$result2=mysqli_query($link2, $sql);
	list($agent_lname, $agent_fname, $agent_email, $agent_password, $date_registered, $agent_code, $agent_address, $agent_contact, $email2, $agent_status,
	$agent_website,$country_location,$commission_type  ) = mysqli_fetch_array($result2);
	$button="<input type='submit' name='update' value='Update' style='width:120px;'>";
}

if($delete=="TRUE")
{	//admin_id, admin_fname, admin_lname, admin_email, admin_password, admin_created_on, status
	$sql3="DELETE FROM agent WHERE agent_no=$id;";
	mysqli_query($link2, $sql3);
	
}


if($button=="")
{
	$button="<input type='submit' name='save' value='Save / Add'>";
}



$statusArray=array("PENDING","ACTIVE");
 for ($i = 0; $i < count($statusArray); $i++)
  {
      if($agent_status == $statusArray[$i])
      {
	 $statusoptions .= "<option selected value=\"$statusArray[$i]\">$statusArray[$i]</option>\n";
      }
      else
      {
	$statusoptions.= "<option value=\"$statusArray[$i]\">$statusArray[$i]</option>\n";
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
      if($country_location == $countrynames[$count])
      {
	 $country_locationoptions .= "<option selected value=\"$countrynames[$count]\">$countrynames[$count]</option>\n";
      }
      else
      {
	 $country_locationoptions .= "<option value=\"$countrynames[$count]\">$countrynames[$count]</option>\n";
      }
   }



// commission_type
$commission_type_Array=array("LOCAL","INTERNATIONAL");
for ($i = 0; $i < count($commission_type_Array); $i++)
{
  if($commission_type == $commission_type_Array[$i])
      {
	 $commission_type_options .= "<option selected value=\"$commission_type_Array[$i]\">$commission_type_Array[$i]</option>\n";
      }
  else
      {
	 $commission_type_options.= "<option value=\"$commission_type_Array[$i]\">$commission_type_Array[$i]</option>\n";
      }
}

?>
<html>
<head>
<title>Administrator-Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="css/affiliate.css">
<script language=javascript src="js/functions.js"></script>
<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type="text/javascript">
<!--
function show_hide(element) 
{
	toggle(element);
}
-->
</script>

<script type="text/javascript">
<!--
function checkFields()
{
	missinginfo = "";
	
	if (document.form.email.value == "")
	{
		missinginfo += "\n     -  Please site a email address"; 
	}
	if (document.form.password.value == "")
	{
		missinginfo += "\n     -  Please enter your Password"; 
	}
	if (document.form.fname.value == "")
	{
		missinginfo += "\n     -  Please enter your First Name";
	}
	if (document.form.lname.value == "")
	{
		missinginfo += "\n     -  Please enter your Last Name";
	}
	if (document.form.address.value == "")
	{
		missinginfo += "\n     -  Please enter your Home Address";
	}
	if (document.form.phone.value == "")
	{
		missinginfo += "\n     -  Please enter your Contact No(s).";
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
-->
</script>	
<style type="text/css">
<!--
div.scroll {
	height: 400px;
	width: 100%;
	overflow: auto;
	padding: 8px;
	
}
.tableContent tr:hover
{
	background:#FFFFCC;
	
}

.tablecontent tbody tr:hover {
  background: #FFFFCC;
  }
-->
</style>
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="POST" name="form" action="adminaffiliatesphp.php"  onsubmit="return checkFields();">
<input type="hidden" name="id" value="<? echo $id;?>">

<script language=javascript src="js/functions.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<? include 'admin_header_menu.php';?>

<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td width=100% valign=top >
<table width=100%  cellspacing=0 cellpadding=2 border=0 align=left >
<tr>
  <td bgcolor="#666666" height="25" colspan=3><font color='#FFFFFF'><b>Admin Home</b></font></td>
</tr>
<tr ><td  valign="top" style="border-right: #006699 2px solid;"><b><? echo $name;?></b></td><td colspan="2"><? echo $mess;?></td></tr>
<tr><td width="18%" height="135" valign="top" style="border-right: #006699 2px solid;">
<? include 'adminleftnav.php';?>
</td>
<td width="82%" valign="top" align="left">
<table width=650 cellpadding=10 cellspacing=0 border=0>
<tr><td>


<table width=100% cellspacing=8 cellpadding=2 border=0 align=left >
<tr bgcolor='#666666'><td  colspan=2><font color="#FFFFFF"><b>Add Affiliates</b></font></td>
</tr>
<tr><td colspan=2 >Administrator use only</td></tr>
<tr><td align=right width=22% >Email : </td>
<td width="78%"><INPUT maxLength=100 size=30 style='width:270px' class="text" name="email" value="<?=$agent_email;?>"></td></tr>
<tr><td align=right width=22% >RemoteStaff Email : </td>
<td><INPUT  type="text"size="30" class=text style="width:270px" name="email2" value="<?=$email2;?>"></td></tr>
<tr><td align=right width=22% >Password : </td>
<td><INPUT  type="password"size="30" class=text style="width:270px" name="password" value="<?=$agent_password;?>"></td></tr>
<tr><td align=right width=22% >First Name : </td>
<td><INPUT  type="text"size="30" class=text style="width:270px" name="fname" value="<?=$agent_fname;?>"></td></tr>
<tr><td align=right width=22% >Last Name : </td>
<td><INPUT  type="text"size="30" class=text style="width:270px" name="lname" value="<?=$agent_lname;?>"></td></tr>
<tr><td align=right width=22% >Address : </td>
<td><INPUT  type="text"size="30" class=text style="width:270px" name="address" value="<?=$agent_address;?>"></td></tr>
<tr><td align=right width=22% >Contact No : </td>
<td><INPUT  type="text"size="30" class=text style="width:270px" name="phone" value="<?=$agent_contact;?>"></td></tr>
<tr><td align=right width=22% >Website : </td>
<td><INPUT  type="text"size="30" class=text style="width:270px" name="hosting" value="<?=$agent_website;?>"><br>
(<b>NOTE : </b>Specify if the Affiliates have their own Website.)
</td></tr>


<tr><td align=right width=22% >Status</td>
<td><select name="status" class="text">
<option value="">-</option>
<? echo $statusoptions;?>
</select></td></tr>
<tr><td align=right width=22% >Country :</td>
<td><select name="country_location" style="width:270px;font:8pt, Verdana">
<option value="0">Select Country</option>
<?=$country_locationoptions;?>
</select></td>
</tr>
<tr><td align=right width=22% >Commission Type</td>
<td><select name="commission_type" class="text">
<option value="">-</option>
<? echo $commission_type_options;?>
</select></td></tr>

<tr><td colspan=2>
<table width=100% border=0 cellspacing=1 cellpadding=2>
<tr><td align=center>
<?=$button;?>
&nbsp;&nbsp;
<INPUT type="reset" value="Cancel" name="Cancel" style="width:120px">
</td></tr></table>
</td></tr>
</table>
<!-- skills list -->
<br clear=all><br>



<!-- --->
<br>

</td></tr></table>
<br>
<table width="800"><tr><td>
<div class="box_contacted_leads" >Affiliates List
<div class="box_new_leads_content" >
<div style=" clear:both;"></div>
<?
//agent_no, lname, fname, email, agent_password, date_registered, agent_code, agent_address, agent_contact, agent_abn, email2, status, hosting, work_status, access_aff_leads, agent_bank_account, aff_marketing_plans, companyname, companyposition, integrate, country_location

$query="SELECT agent_no, lname, fname, email, agent_password, DATE_FORMAT(date_registered,'%D %b %Y'), agent_code, agent_address, agent_contact, email2, status ,agent_bank_account, aff_marketing_plans ,companyname, companyposition, integrate, country_location ,commission_type

 FROM agent WHERE work_status ='AFF' ORDER BY date_registered DESC;";
//echo $query;
$resulta=mysqli_query($link2, $query);
$counter=0;
while(list($id, $lname, $fname, $email,  $password, $date, $agent_code, $agent_address, $agent_contact, $email2, $status, $bank_account , $aff_marketing_plans,
$companyname, $companyposition, $integrate ,$countrylocation , $commissiontype ) = mysqli_fetch_array($resulta))	
{	$counter=$counter+1;

	$bank_account=str_replace("\n","<br>",$bank_account);
	$aff_marketing_plans=str_replace("\n","<br>",$aff_marketing_plans);	
	
?>
<span class="leads_wrapper" style=" cursor:pointer;">
<label class="leads_wrapper_label" style="width:50px;"><? echo $counter;?>)</label>
<label class="leads_wrapper_label" style="width:300px; "><a href='javascript: show_hide("<? echo $id;?>");' ><? echo $fname." ".$lname;?></a></label>
<label class="leads_wrapper_label" style="width:70px;"><? echo $agent_code;?></label>
<label class="leads_wrapper_label" style="width:100px;"><? echo $status;?></label>
<label class="leads_wrapper_label" style="width:100px;"><?=$date;?></label>
<label class="leads_wrapper_label" style="width:100px;"><small style="color:#999999"><? echo $commissiontype;?></small></label>
</span>
<div id='<? echo $id;?>' style='display:none; margin-top:5px; margin-bottom:5px; padding:5px 5px 5px 5px;'>
<span style="float:right; margin-right:20px;"><a href='javascript: show_hide("<? echo $id;?>");'title="close"><b>[X]</b></a></span>
<span style="color:#999999;"><? echo $fname." ".$lname;?></span>

	 <ul>
	 	  <li>Date Created : <?=$date;?></li>
		  <li>Email : <?=$email;?></li>
		  <li>Company Name : <?=$companyname?></li>
		  <li>Company Position : <?=$companyposition;?></li>
		  <li>Integrate Remotestaff Inquiry Form : <?=$integrate;?></li>
 		  <li>RemoteStaff Email: <?=$email2;?></li>
		  <li>Country : <?=$countrylocation;?></li>
		  <li>Commission Type : <?=$commissiontype;?></li>
		  <li>Address : <?=$agent_address;?></li>
		  <li>Contact # : <?=$agent_contact;?></li>
		  <li>Bank Account : <?=$bank_account;?></li>
		  <li>Marketing Plans : <?=$aff_marketing_plans;?></li>
		  <li>Status : <?=$status;?></li>
 	  
		  <li><a href="adminaffiliates.php?id=<? echo $id;?>&edit=TRUE">Edit</a> | <a href="adminaffiliates.php?id=<? echo $id;?>&delete=TRUE">Delete</a></li>
		  </ul>
	

</div>
<? 
}
?>
</div>
</div>
</td>
</tr>
</table>
  </td>
</tr>
</table>

</td>
</tr>
</table>
</td></tr>
</table>

<!-- LIST HERE -->
<? include 'footer.php';?>
</form>	
</body>
</html>
