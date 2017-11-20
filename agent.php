<?php
include './conf/zend_smarty_conf.php';

header("location:http://www.remotestaff.com.au/client-referral.php");
exit;

$mess="";
$mess=$_REQUEST['mess'];


$contact_nos="Phone :\nMobile :\nFax:\n";

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

?>
<html>
<head>
<title>Affiliate Registration</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="css/affiliate.css">
<link rel=stylesheet type=text/css href="css/marketing_gallery.css">
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
	//
	if (document.form.country_location.selectedIndex == "0")
	{
		missinginfo += "\n     -  Please enter your Country";
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
	
	
	
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" action="agentphp.php" onSubmit="return checkFields();">
<!-- HEADER -->
<? include 'header.php';?>
<ul class="glossymenu">
  <li class="current"><a href="index.php"><b>Home</b></a></li>
  <li ><a href="ads_list.php"><b>Advertisements</b></a></li>
</ul>
<table width="100%">
<tr>
<td width="10%" valign="top">&nbsp;</td>
<td width="50%" valign="top">
<div id="page_desc">
<b>Be part of the fastest growing industry. Join RemoteStaff Affiliate Program by filling out the form below.</b>  </div>
<? if ($mess=="1") {echo "<center><b><font color='#FF0000' size='2'>Email address aleardy Exist !<br>Please try to register different account.</font></b></center>"; }?>
<div class="box_contacted_leads" >Affiliate Form
<div class="box_new_leads_content" >
<div id="form_info">
<p><b>Login Details</b></p>
<p><label>Email :</label><INPUT maxLength=100  style='width:270px' class="text" name="email" value=""></p>
<p><label>Password :</label><INPUT  type="password" class=text style="width:270px" name="password" value=""></p>
<hr style="width:90%;">
<p><b>TELL US ABOUT YOURSELF : </b></p>
<p><label>First Name :</label><INPUT  type="text" class=text style="width:270px" name="fname" value=""></p>
<p><label>Last Name :</label><INPUT  type="text" class=text style="width:270px" name="lname" value=""></p>
<p><label>Company Name :</label><INPUT  type="text" class=text style="width:270px" name="companyname" value=""></p>
<p><label>Company Position :</label><INPUT  type="text" class=text style="width:270px" name="companyposition" value=""></p>
<p><label>Country :</label>
<select name="country_location" style="width:270px;font:8pt, Verdana">
<option value="0">Select Country</option>
<?=$country_locationoptions;?>
</select></p>
<p><label>Address :</label><textarea class='text' style="width:270px" name="address" rows="3"></textarea></p>
<p><label>Contact Nos. : </label><textarea  class="text" style="width:270px" name="phone" rows="3"><?=$contact_nos;?></textarea></p>
<hr style="width:90%;">
<p><b>TELL US ABOUT YOUR SITE : </b></p>
<p><label>&nbsp;</label><br>
<ul>
<li>Traffic statistic - unique visitors per month</li>
<li>Nature of business</li>
<li>Site audience profile</li>
</ul>
</p>
<p><label>Website URL :</label><INPUT  type="text" class=text style="width:270px" name="hosting" value=""></p>
<p><label>&nbsp;</label><textarea cols="30" rows="7" class=text style="width:270px" name="marketing_plan" ></textarea></p>
<p>Would you like to integrate our Remote Staff Inquiry Form into your site ? <input type="radio" name="integrate" value="YES">YES &nbsp;<input type="radio" name="integrate" value="NO">NO</p>
<p align="center"><INPUT type="submit" value="Save" name="save" class="button" style="width:120px"></p>
<hr style="width:90%;">
<div id="page_desc" style="color:#999999;">
<P style="float:left;">
Owned and Managed by Think Innovations Pty. Ltd.
<br>
www.remotestaff.com.au</P>
<P style="float:RIGHT;">
ABN: 37-094-364-511 
<br>
Ph: +61 2 9365 0018  or 1 300 733 430</P>
<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
</div>
</div>
</div></td>
<td width="40%" valign="top">
<div style="margin-top:22px; margin-left:5px; padding:12px;">
<p><img src="images/banner2/JPEG/300x250_wlogo.jpg" title="Image use for Affiliate Marketing stuff"  ></p>
<p><img src="images/banner2/JPEG/banner_remote1.jpg" title="Image use for Affiliate Marketing stuff"></p>
<p><img src="images/banner2/JPEG/120x240.jpg"   title="Image use for Affiliate Marketing stuff"></p>
<p><img src="images/banner2/JPEG/120x60.jpg"  title="Image use for Affiliate Marketing stuff"></p>
</div></td>
</tr>
</table>

<? include 'footer.php';?>		
</form>
</body>
</html>
