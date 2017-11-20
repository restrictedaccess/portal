<?
include 'config.php';
include 'conf.php';
include 'function.php';

//$userid = $_SESSION['userid'];
$userid = @$_GET["userid"];
$mess="";
$mess=$_REQUEST['mess'];


if($_SESSION['admin_id']=="")
{
	echo '
	<script language="javascript">
		alert("Session expired.");
	</script>
	';
	header("location:http:index.php");
}

$nationality="";
$countryoptions="";
//echo $userid;
/*
 userid, lname, fname, byear, bmonth, bday, auth_no_type_id, msia_new_ic_no, gender, nationality, permanent_residence, email, pass, alt_email, handphone_country_code, handphone_no, tel_area_code, tel_no, address1, address2, postcode, country_id, state, city, msn_id, yahoo_id, icq_id, skype_id, image, datecreated, dateupdated, status, home_working_environment, internet_connection, isp, computer_hardware, headset_quality

 */

$query="SELECT * FROM personal WHERE userid=$userid";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result);
	$image= $row['image'];
	$fname =$row['fname'];
	$lname=$row['lname'];
	$day =$row['bday'];
	$bmonth=$row['bmonth'];
	$byear =$row['byear'];
	$auth_no_type_id = $row['auth_no_type_id'];
	$msia_new_ic_no=$row[7];
	$gender = $row['gender'];
	$nationality = $row['nationality'];
	$permanent_residence = $row['permanent_residence'];

	$email = $row['email'];
	$pass=$row['pass'];
	$alt_email = $row['alt_email'];
	$handphone_no = $row['handphone_no'];
	$tel_area_code = $row['tel_area_code'];
	$tel_no = $row['tel_no'];
	$address1 = $row['address1'];
	$address2 = $row['address2'];
	$postcode = $row['postcode'];
	$country_id = $row['country_id'];
	$state = $row['state'];
	$city = $row['city'];
	$msn_id = $row['msn_id'];
	$yahoo_id =$row['yahoo_id'];
	$icq_id =$row['icq_id'];
	$skype_id = $row['skype_id'];
	$speed_test = $row["speed_test"];
	if (!is_null($row["english_communication_skill"])){
		$english_level = $row["english_communication_skill"];
	}else{
		$english_level = 0;
	}
	$home_working_environment=$row['home_working_environment'];
	$internet_connection=$row['internet_connection'];
	$isp=$row['isp'];
	$computer_hardware=$row['computer_hardware'];
	$headset_quality=$row['headset_quality'];

	//private room ,shared room, living room

	if($home_working_environment=="private room")
	{
		$selected1="checked";
	}
	if($home_working_environment=="shared room")
	{
		$selected2="checked";
	}
	if($home_working_environment=="living room")
	{
		$selected3="checked";
	}

	//$checked1 WI-FI DIAL-UP DSL
	if($internet_connection=="WI-FI")
	{
		$checked1="checked";
	}
	if($internet_connection=="DIAL-UP")
	{
		$checked2="checked";
	}
	if($internet_connection=="DSL")
	{
		$checked3="checked";
	}
}



$headsetQualityArray=array("No Headset","1","2","3","4","5");
for ($i = 0; $i <count($headsetQualityArray) ; $i++) {
	if($headset_quality == $i)
	{
	 $headsetQualityoptions .= "<option selected value=$i>$headsetQualityArray[$i]</option>\n";
	}
	else
	{
	 $headsetQualityoptions .= "<option value=$i>$headsetQualityArray[$i]</option>\n";
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
	if($nationality == $countrynames[$count])
	{
	 $countryoptions .= "<option selected value=\"$countrynames[$count]\">$countrynames[$count]</option>\n";
	}
	else
	{
	 $countryoptions .= "<option value=\"$countrynames[$count]\">$countrynames[$count]</option>\n";
	}
	 
}

for ($date = 1; $date <=31; $date++) {
	if($day == $date)
	{
	 $dayoptions .= "<option selected value=\"$date\">$date</option>\n";
	}
	else
	{
	 $dayoptions .= "<option value=\"$date\">$date</option>\n";
	}

}
$monthNames = array("-","January","February","March","April","May","June","July","August","September","October","November","December");
for ($i = 0; $i <=12 ; $i++) {
	if($bmonth == $i)
	{
	 $monthoptions .= "<option selected value=\"$i\">$monthNames[$i]</option>\n";
	}
	else
	{
	 $monthoptions .= "<option value=\"$i\">$monthNames[$i]</option>\n";
	}

}

$idNames=array("IC No.","Social Card No.","Tax Card No.","Drivers License No.","Student Card No.","Passport No.","Professional License No.");
for ($i = 0; $i < count($idNames) ; $i++) {
	if($auth_no_type_id == $idNames[$i])
	{
	 $idoptions .= "<option selected value=\"$idNames[$i]\">$idNames[$i]</option>\n";
	}
	else
	{
	 $idoptions .= "<option value=\"$idNames[$i]\">$idNames[$i]</option>\n";
	}

}
 
///////////////////
$countrycodes = array(
	    "AF","AL","DZ","AS","AD","AO","AI","AQ","AG","AR","AM","AW","AC","AU","AT","AZ","BS","BH","BD","BB",
	    "BY","BE","BZ","BJ","BM","BT","BO","BA","BW","BV","BR","IO","BN","BG","BF","BI","KH","CM","CA","CV","KY","CF","TD","CL",
	    "CN","CX","CC","CO","KM","CG","CK","CR","HR","CU","CY","CZ","DK","DG","DJ","DM","DO","TP","EC","EG","SV","GQ","ER","EE",
	    "ET","FK","FO","FJ","FI","FR","FX","TF","GA","GM","GE","DE","GH","GI","GB","GR","GL","GD","GP","GU","GT","GN","GW","GY",
	    "GF","HT","HM","HN","HK","HU","IS","IN","ID","IR","IQ","IE","IL","IT","CI","JM","JP","JO","KZ","KE","KI","KP","KR","KW",
	    "KG","LA","LV","LB","LS","LR","LY","LI","LT","LU","MO","MK","MG","MW","MY","MV","ML","MT","MH","MQ","MR","MU","YT","MX",
	    "FM","MD","MC","MN","MS","MA","MZ","MM","NA","NR","NP","AN","NL","NC","NZ","NI","NE","NG","NU","NF","MP","NO","OM","PK",
	    "PW","PA","PG","PY","PE","PH","PN","PL","PF","PT","PR","QA","RE","RO","RU","RW","LC","WS","SM","SA","SN","SC","SL","SG",
	    "SK","SI","SB","SO","ZA","GS","ES","LK","SH","PM","ST","KN","VC","SD","SR","SJ","SZ","SE","CH","SY","TJ","TW","TZ","TH",
	    "TG","TK","TO","TT","TN","TR","TM","TC","TV","UG","UA","AE","UK","US","UY","UM","UZ","VU","VA","VE","VN","VG","VI","WF",
	    "EH","YE","YU","ZR","ZM","ZW");

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
for ($count = 0; $count < count($countrycodes); $count++) {
	if($country_id == $countrycodes[$count])
	{
	 $country_idoptions .= "<option selected value=\"$countrycodes[$count]\">$countrynames[$count]</option>\n";
	}
	else
	{
	 $country_idoptions .= "<option value=\"$countrycodes[$count]\">$countrynames[$count]</option>\n";
	}
}
 
//////////////
$residenceCode=array("AU","CA","CN","HK","IN","ID","JP","MY","NZ","PH","SG","TH","GB","US");
$residenceNames=array("Australia","Canada","China","Hong Kong","India","Indonesia","Japan","Malaysia","New Zealand","Philippines","Singapore","Thailand","United Kingdom","United States");

for ($count = 0; $count < 3; $count++) {
	if($permanent_residence == $residenceCode[$count])
	{
	 $residenceoptions .= "<td><input type='radio' name='permanent_residence' value='$residenceCode[$count]'Checked>$residenceNames[$count]</td>";
	}
	else
	{
		$residenceoptions .= "<td><input type='radio' name='permanent_residence' value='$residenceCode[$count]'>$residenceNames[$count]</td>";
	}
}
 
for ($count = 3; $count <6; $count++) {
	if($permanent_residence == $residenceCode[$count])
	{
	 $residenceoptions2 .= "<td><input type='radio' name='permanent_residence' value='$residenceCode[$count]'Checked>$residenceNames[$count]</td>";
	}
	else
	{
		$residenceoptions2 .= "<td><input type='radio' name='permanent_residence' value='$residenceCode[$count]'>$residenceNames[$count]</td>";
	}
}
 
for ($count = 6; $count <9; $count++) {
	if($permanent_residence == $residenceCode[$count])
	{
	 $residenceoptions3 .= "<td><input type='radio' name='permanent_residence' value='$residenceCode[$count]'Checked>$residenceNames[$count]</td>";
	}
	else
	{
		$residenceoptions3 .= "<td><input type='radio' name='permanent_residence' value='$residenceCode[$count]'>$residenceNames[$count]</td>";
	}
}

for ($count = 9; $count <12; $count++) {
	if($permanent_residence == $residenceCode[$count])
	{
	 $residenceoptions4 .= "<td><input type='radio' name='permanent_residence' value='$residenceCode[$count]'Checked>$residenceNames[$count]</td>";
	}
	else
	{
		$residenceoptions4 .= "<td><input type='radio' name='permanent_residence' value='$residenceCode[$count]'>$residenceNames[$count]</td>";
	}
}

for ($count = 12; $count <14; $count++) {
	if($permanent_residence == $residenceCode[$count])
	{
	 $residenceoptions5 .= "<td><input type='radio' name='permanent_residence' value='$residenceCode[$count]'Checked>$residenceNames[$count]</td>";
	}
	else
	{
		$residenceoptions5.= "<td><input type='radio' name='permanent_residence' value='$residenceCode[$count]'>$residenceNames[$count]</td>";
	}
}





?>
<html>
<head>
<title>MyProfile &copy;ThinkInnovations.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>
<body style="background: #ffffff" text="#000000" topmargin="0"
	leftmargin="0" marginheight="0" marginwidth="0">
	<!-- CONTENT -->
	<script language=javascript src="js/validation.js"></script>
	<script type="text/javascript">
<!--
function checkFields()
{
		
	var countryid =document.frmPersonal.country_id.value;
	missinginfo = "";
	if (document.frmPersonal.fname.value == "")
	{
		missinginfo += "\n     -  Please enter your First Name";
	}
	if (document.frmPersonal.lname.value == "")
	{
		missinginfo += "\n     -  Please enter your Last Name";
	}
	if (document.frmPersonal.gender[0].checked == false && document.frmPersonal.gender[1].checked == false)
	{	
			missinginfo += "\n     -  Please choose your gender";
		
	}
	if (document.frmPersonal.nationality.selectedIndex=="0")
	{
		missinginfo += "\n     -  Please choose your nationality";
	}
	if (document.frmPersonal.email.value == "")
	{
		missinginfo += "\n     -  Please site a email address"; 
	}
	if (document.frmPersonal.handphone_no.value == "")
	{
		missinginfo += "\n     -  Please enter your mobile number";
	}
	if (document.frmPersonal.tel_area_code.value == "")
	{
		missinginfo += "\n     -  Please enter your area code";
	}
	if (document.frmPersonal.tel_no.value == "")
	{
		missinginfo += "\n     -  Please enter your telephone number";
	}
	if (document.frmPersonal.address1.value == "")
	{
		missinginfo += "\n     -  Please enter your Address";
	}
	if (document.frmPersonal.postcode.value == "")
	{
		missinginfo += "\n     -  Please enter your Postal Code"; //
	}
	if (document.frmPersonal.country_id.selectedIndex=="0")
	{
		missinginfo += "\n     -  Please state your Country";
	}
	
	if (countryid=="AU"|| countryid=="BD"|| countryid=="HK"|| countryid=="ID"|| countryid=="IN"|| countryid=="MY"|| countryid=="PH"|| countryid=="SG"|| countryid=="TH"|| countryid=="VN")
	{
		if (document.frmPersonal.msia_state_id.selectedIndex=="0")
		{
			missinginfo += "\n     -  Please enter your State or Region";
		}
	}
	else
	{
		if (document.frmPersonal.state.value == "")
		{
			missinginfo += "\n     -  Please enter your State or Region";

		}
	}
	if(document.frmPersonal.city.value == "")
	{
		missinginfo += "\n     -  Please enter your City";
	}
	if (document.frmPersonal.byear.value == "")
	{
		missinginfo += "\n     -  Please enter your Birth Year";
	}
	///////////////////////////////////////////////
	
	
	//companyturnover  AU BD HK ID IN MY PH SG TH VN
	
	
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
	<script language="javascript">
var AU = new Array();
AU[0] = "('Select a State','00','')";
AU[1] = "('A.C.T','AT','')";
AU[2] = "('Northern Territory','NO','')";
AU[3] = "('New South Wales','NW','')";
AU[4] = "('Queensland','QL','')";
AU[5] = "('South Australia','SA','')";
AU[6] = "('Tasmania','TS','')";
AU[7] = "('Victoria','VI','')";
AU[8] = "('Western Australia','WA','')";
var BD = new Array();
BD[0] = "('Select a Division','00','')";
BD[1] = "('Barisal','BS','')";
BD[2] = "('Chittagong','CI','')";
BD[3] = "('Dhaka','DK','')";
BD[4] = "('Khulna','KN','')";
BD[5] = "('Rajshahi','RH','')";
BD[6] = "('Sylhet','YH','')";
var HK = new Array();
HK[0] = "('Hong Kong','HK','')";
var ID = new Array();
ID[0] = "('Select a State','00','')";
ID[1] = "('Aceh','AC','')";
ID[2] = "('Bali','BA','')";
ID[3] = "('Bangka Belitung','BB','')";
ID[4] = "('Banten','BN','')";
ID[5] = "('Bengkulu','BE','')";
ID[6] = "('Gorontalo','GR','')";
ID[7] = "('Jakarta Raya','JA','')";
ID[8] = "('Jambi','JB','')";
ID[9] = "('Jawa Barat','JR','')";
ID[10] = "('Jawa Tengah','JT','')";
ID[11] = "('Jawa Timur','JW','')";
ID[12] = "('Kalimantan Barat','KB','')";
ID[13] = "('Kalimantan Selatan','KS','')";
ID[14] = "('Kalimantan Tengah','KU','')";
ID[15] = "('Kalimantan Timur','KV','')";
ID[16] = "('Lampung','LP','')";
ID[17] = "('Maluku','ML','')";
ID[18] = "('Maluku Utara','MJ','')";
ID[19] = "('Nusa Tenggara Barat','NB','')";
ID[20] = "('Nusa Tenggara Timur','NT','')";
ID[21] = "('Papua','IJ','')";
ID[22] = "('Riau','RI','')";
ID[23] = "('Sulawesi Selatan','SE','')";
ID[24] = "('Sulawesi Tengah','SF','')";
ID[25] = "('Sulawesi Tenggara','SH','')";
ID[26] = "('Sulawesi Utara','SJ','')";
ID[27] = "('Sumatera Barat','SK','')";
ID[28] = "('Sumatera Selatan','SN','')";
ID[29] = "('Sumatera Utara','SP','')";
ID[30] = "('Yogyakarta','YG','')";
var IN = new Array();
IN[0] = "('Select a State','00','')";
IN[1] = "('Andaman & Nicobar','AN:40100:','')";
IN[2] = "('Andhra Pradesh - Hyderabad','AP:40210:Hyderabad:','')";
IN[3] = "('Andhra Pradesh - Secunderabad','AP:40210:Secunderabad:','')";
IN[4] = "('Andhra Pradesh - Vishakapatnam','AP:40220:Vishakapatnam:','')";
IN[5] = "('Andhra Pradesh - Vijaywada','AP:40230:Vijaywada:','')";
IN[6] = "('Andhra Pradesh - Other cities','AP:40299:','')";
IN[7] = "('Assam - Gauhati','AS:40310:Gauhati:','')";
IN[8] = "('Assam - Other cities','AS:40399:','')";
IN[9] = "('Arunachal Pradesh','AU:40400:','')";
IN[10] = "('Bihar - Patna','BI:40510:Patna:','')";
IN[11] = "('Bihar - Other cities','BI:40599:','')";
IN[12] = "('Chandigarh','CH:40600:','')";
IN[13] = "('Chhattisgarh','CT:43400:','')";
IN[14] = "('Daman & Diu','DD:40700:','')";
IN[15] = "('Delhi - Delhi','DE:40800:Delhi:','')";
IN[16] = "('Delhi - Faridabad','DE:40800:Faridabad:','')";
IN[17] = "('Delhi - Ghaziabad','DE:40800:Ghaziabad','')";
IN[18] = "('Delhi - Gurgoan','DE:40800:Gurgoan:','')";
IN[19] = "('Delhi - Noida','DE:40800:Noida:','')";
IN[20] = "('Dadra & Nagar Haveli','DN:40900:','')";
IN[21] = "('Goa','GO:41000:','')";
IN[22] = "('Gujarat - Ahmedabad','GU:41110:Ahmedabad:','')";
IN[23] = "('Gujarat - Vadodara','GU:41120:Vadodara:','')";
IN[24] = "('Gujarat - Other cities','GU:41199:','')";
IN[25] = "('Haryana - Panipat','HA:41210:Panipat:','')";
IN[26] = "('Haryana - Other cities','HA:41299:','')";
IN[27] = "('Himachal Pradesh','HP:41300:','')";
IN[28] = "('Jammu & Kashmir','JK:41400:','')";
IN[29] = "('Jharkhand - Jamshedpur','JN:43510:Jamshedpur:','')";
IN[30] = "('Jharkhand - Ranchi','JN:43520:Ranchi:','')";
IN[31] = "('Jharkhand - Other cities','JN:43599:','')";
IN[32] = "('Karnataka - Bangalore','KA:41510:Bangalore:','')";
IN[33] = "('Karnataka - Mysore','KA:41520:Mysore:','')";
IN[34] = "('Karnataka - Mangalore','KA:41530:Mangalore:','')";
IN[35] = "('Karnataka - Other cities','KA:41599:','')";
IN[36] = "('Kerala - Cochin','KE:41610:Cochin:','')";
IN[37] = "('Kerala - Trivandrum','KE:41620:Trivandrum:','')";
IN[38] = "('Kerala - Other cities','KE:41699:','')";
IN[39] = "('Lakshadweep','LA:41700:','')";
IN[40] = "('Maharashtra - Aurangabad','MA:41810:Aurangabad:','')";
IN[41] = "('Maharashtra - Mumbai','MA:41820:Mumbai:','')";
IN[42] = "('Maharashtra - Nagpur','MA:41830:Nagpur:','')";
IN[43] = "('Maharashtra - Nashik','MA:41840:Nashik:','')";
IN[44] = "('Maharashtra - Pune','MA:41850:Pune:','')";
IN[45] = "('Maharashtra - Other cities','MA:41899:','')";
IN[46] = "('Meghalaya','ME:41900:','')";
IN[47] = "('Mizoram','MI:42000:','')";
IN[48] = "('Manipur','MN:42100:','')";
IN[49] = "('Madhya Pradesh - Bhopal','MP:42210:Bhopal:','')";
IN[50] = "('Madhya Pradesh - Indore','MP:42220:Indore:','')";
IN[51] = "('Madhya Pradesh - Other cities','MP:42299:','')";
IN[52] = "('Nagaland','NA:42300:','')";
IN[53] = "('Orissa - Bhubaneshwar','OR:42410:Bhubaneshwar:','')";
IN[54] = "('Orissa - Other cities','OR:42499:','')";
IN[55] = "('Pondicherry','PO:42500:','')";
IN[56] = "('Punjab - Jalandhar','PU:42610:Jalandhar:','')";
IN[57] = "('Punjab - Ludhiana','PU:42620:Ludhiana:','')";
IN[58] = "('Punjab - Other cities','PU:42699:','')";
IN[59] = "('Rajasthan - Jaipur','RA:42710:Jaipur:','')";
IN[60] = "('Rajasthan - Kota','RA:42720:Kota:','')";
IN[61] = "('Rajasthan - Other cities','RA:42799:','')";
IN[62] = "('Sikkim','SI:42800:','')";
IN[63] = "('Tamil Nadu - Chennai','TN:42910:Chennai:','')";
IN[64] = "('Tamil Nadu - Coimbatore','TN:42920:Coimbatore:','')";
IN[65] = "('Tamil Nadu - Madurai','TN:42930:Madurai:','')";
IN[66] = "('Tamil Nadu - Trichy','TN:42940:Trichy:','')";
IN[67] = "('Tamil Nadu - Salem','TN:42950:Salem:','')";
IN[68] = "('Tamil Nadu - Hosur','TN:42960:Hosur:','')";
IN[69] = "('Tamil Nadu - Other cities','TN:42999:','')";
IN[70] = "('Tripura','TR:43000:','')";
IN[71] = "('Uttaranchal','UT:43600:','')";
IN[72] = "('Uttar Pradesh - Lucknow','UP:43110:Lucknow:','')";
IN[73] = "('Uttar Pradesh - Kanpur','UP:43120:Kanpur:','')";
IN[74] = "('Uttar Pradesh - Other cities','UP:43199:','')";
IN[75] = "('West Bengal - Kolkata','WB:43210:Kolkata:','')";
IN[76] = "('West Bengal - Other cities','WB:43299:','')";
var MY = new Array();
MY[0] = "('Select a State','00','')";
MY[1] = "('Johor','JH','')";
MY[2] = "('Kedah','KH','')";
MY[3] = "('Kuala Lumpur','KL','')";
MY[4] = "('Kelantan','KT','')";
MY[5] = "('Melaka','MK','')";
MY[6] = "('Negeri Sembilan','NS','')";
MY[7] = "('Penang','PG','')";
MY[8] = "('Pahang','PH','')";
MY[9] = "('Perak','PK','')";
MY[10] = "('Perlis','PS','')";
MY[11] = "('Sabah','SB','')";
MY[12] = "('Selangor','SL','')";
MY[13] = "('Sarawak','SW','')";
MY[14] = "('Terengganu','TG','')";
MY[15] = "('Labuan','LB','')";
var PH = new Array();
PH[0] = "('Select a State','00','')";
PH[1] = "('Armm','AR','')";
PH[2] = "('Bicol Region','BR','')";
PH[3] = "('C.A.R','CA','')";
PH[4] = "('Cagayan Valley','CG','')";
PH[5] = "('Central Luzon','CL','')";
PH[6] = "('Central Mindanao','CM','')";
PH[7] = "('Caraga','CR','')";
PH[8] = "('Central Visayas','CV','')";
PH[9] = "('Eastern Visayas','EV','')";
PH[10] = "('Ilocos Region','IL','')";
PH[11] = "('National Capital Reg','NC','')";
PH[12] = "('Northern Mindanao','NM','')";
PH[13] = "('Southern Mindanao','SM','')";
PH[14] = "('Southern Tagalog','ST','')";
PH[15] = "('Western Mindanao','WM','')";
PH[16] = "('Western Visayas','WV','')";
var SG = new Array();
SG[0] = "('Singapore','SG','')";
var TH = new Array();
TH[0] = "('Select a State','00','')";
TH[1] = "('North','TA','')";
TH[2] = "('North Eastern','TB','')";
TH[3] = "('Central','TC','')";
TH[4] = "('Eastern','TD','')";
TH[5] = "('South','TE','')";
var VN = new Array();
VN[0] = "('Select a City','00','')";
VN[1] = "('An Giang','VN:110101:An Giang:','')";
VN[2] = "('Ba Ria-Vung Tau','VN:110102:Ba Ria-Vung Tau:','')";
VN[3] = "('Bac Can','VN:110103:Bac Can:','')";
VN[4] = "('Bac Giang','VN:110104:Bac Giang:','')";
VN[5] = "('Bac Lieu','VN:110105:Bac Lieu:','')";
VN[6] = "('Bac Ninh','VN:110106:Bac Ninh:','')";
VN[7] = "('Ben Tre','VN:110107:Ben Tre:','')";
VN[8] = "('Binh Dinh','VN:110108:Binh Dinh:','')";
VN[9] = "('Binh Duong','VN:110109:Binh Duong:','')";
VN[10] = "('Binh Phuoc','VN:110110:Binh Phuoc:','')";
VN[11] = "('Binh Thuan','VN:110111:Binh Thuan:','')";
VN[12] = "('Ca Mau','VN:110112:Ca Mau:','')";
VN[13] = "('Can Tho','VN:110113:Can Tho:','')";
VN[14] = "('Cao Bang','VN:110114:Cao Bang:','')";
VN[15] = "('Da Nang','VN:110115:Da Nang:','')";
VN[16] = "('Dac Lac','VN:110116:Dac Lac:','')";
VN[17] = "('Dong Nai','VN:110117:Dong Nai:','')";
VN[18] = "('Dong Thap','VN:110118:Dong Thap:','')";
VN[19] = "('Gia Lai','VN:110119:Gia Lai:','')";
VN[20] = "('Ha Giang','VN:110120:Ha Giang:','')";
VN[21] = "('Ha Nam','VN:110121:Ha Nam:','')";
VN[22] = "('Ha Noi','VN:110122:Ha Noi:','')";
VN[23] = "('Ha Tay','VN:110123:Ha Tay:','')";
VN[24] = "('Ha Tinh','VN:110124:Ha Tinh:','')";
VN[25] = "('Hai Duong','VN:110125:Hai Duong:','')";
VN[26] = "('Haiphong','VN:110126:Haiphong:','')";
VN[27] = "('Ho Chi Minh','VN:110127:Ho Chi Minh:','')";
VN[28] = "('Hoa Binh','VN:110128:Hoa Binh:','')";
VN[29] = "('Hung Yen','VN:110129:Hung Yen:','')";
VN[30] = "('Khanh Hoa','VN:110130:Khanh Hoa:','')";
VN[31] = "('Kien Giang','VN:110131:Kien Giang:','')";
VN[32] = "('Kon Tum','VN:110132:Kon Tum:','')";
VN[33] = "('Lai Chau','VN:110133:Lai Chau:','')";
VN[34] = "('Lam Dong','VN:110134:Lam Dong:','')";
VN[35] = "('Lang Son','VN:110135:Lang Son:','')";
VN[36] = "('Lao Cai','VN:110136:Lao Cai:','')";
VN[37] = "('Long An','VN:110137:Long An:','')";
VN[38] = "('Nam Dinh','VN:110138:Nam Dinh:','')";
VN[39] = "('Nghe An','VN:110139:Nghe An:','')";
VN[40] = "('Ninh Binh','VN:110140:Ninh Binh:','')";
VN[41] = "('Ninh Thuan','VN:110141:Ninh Thuan:','')";
VN[42] = "('Phu Tho','VN:110142:Phu Tho:','')";
VN[43] = "('Phu Yen','VN:110143:Phu Yen:','')";
VN[44] = "('Quang Binh','VN:110144:Quang Binh:','')";
VN[45] = "('Quang Nam','VN:110145:Quang Nam:','')";
VN[46] = "('Quang Ngai','VN:110146:Quang Ngai:','')";
VN[47] = "('Quang Ninh','VN:110147:Quang Ninh:','')";
VN[48] = "('Quang Tri','VN:110148:Quang Tri:','')";
VN[49] = "('Soc Trang','VN:110149:Soc Trang:','')";
VN[50] = "('Son La','VN:110150:Son La:','')";
VN[51] = "('Tay Ninh','VN:110151:Tay Ninh:','')";
VN[52] = "('Thai Binh','VN:110152:Thai Binh:','')";
VN[53] = "('Thai Nguyen','VN:110153:Thai Nguyen:','')";
VN[54] = "('Thanh Hoa','VN:110154:Thanh Hoa:','')";
VN[55] = "('Thua Thien-Hue','VN:110155:Thua Thien-Hue:','')";
VN[56] = "('Tien Giang','VN:110156:Tien Giang:','')";
VN[57] = "('Tra Vinh','VN:110157:Tra Vinh:','')";
VN[58] = "('Tuyen Quang','VN:110158:Tuyen Quang:','')";
VN[59] = "('Vinh Long','VN:110159:Vinh Long:','')";
VN[60] = "('Vinh Phuc','VN:110160:Vinh Phuc:','')";
VN[61] = "('Yen Bai','VN:110161:Yen Bai:','')";
VN[62] = "('Others','VN:110199:','')";
var strArrayList = ",AU,BD,HK,ID,IN,MY,PH,SG,TH,VN";function emptyLocationSelect(objOtherState, strCountry, objStateSelect, objCitySelect, objLocationSelect){ 
var NS4 = (document.layers) ? true : false; 
var temp = "";  
		if(!NS4){ 	objStateSelect.style.visibility = 'hidden'; } 
		if(strArrayList.indexOf(strCountry) > 0){ 
			while(objStateSelect.options.length > eval(strCountry + ".length")){  
				objStateSelect.options[(objStateSelect.options.length-1)] = null;  
			}  
		objOtherState.disabled = true;  
		objOtherState.value = '';  
		for(i=0;i<eval(strCountry + ".length");i++){  
			temp = eval(strCountry + "[i]");	 
				if(!NS4){  
					objOtherState.size = 10  
					objOtherState.style.visibility = 'hidden';  
					objStateSelect.style.visibility = 'visible';  
				}  
				else{  
					objOtherState.disabled = true;  
				}  
				eval("objStateSelect.options[i] = new Option" + temp);  
		}  
	}else{  
		while(objStateSelect.options.length > 1){  
			objStateSelect.options[(objStateSelect.options.length-1)] = null;  
		}  
		if(!NS4){  
			objStateSelect.options[0] = new Option("","00");  
			objStateSelect.style.visibility = 'hidden';  
			objOtherState.style.visibility = 'visible';  
			objOtherState.size = 20  
			objOtherState.disabled = false; 
		}else{	  
			objStateSelect.options[0] = new Option(Others,"00");  
			objOtherState.disabled = false;  
		}  
	}  
	objStateSelect.selectedIndex = 0;  
	
}  
function enterCity(ld,  objCitySelect, objLocationSelect, cls){  
	var id = ld.split(":") ; 
	objLocationSelect.value = "";
	if(id[1] != null && id[1].length > 0){ 
		objLocationSelect.value = id[1]; 
			if(id[2] != null && id[2].length > 0 ){ 
				objCitySelect.value = ""; 
				objCitySelect.value = id[2]; 
		} else{  
			if(cls == true) { 
				objCitySelect.value = ""; 
			} 
		} 
	}else{ 
	   if(cls == true) { 
		objCitySelect.value = ""; 
	   } 
	} 
} 
 function repopulateLocation(objMsiaState, data, startindex, endindex) {  
	for(var i =0 ; i< objMsiaState.options.length; i++)  
	{		
		var tempVar =  data;  
		if(objMsiaState.options[i].value == tempVar 
		||  (objMsiaState.options[i].value.substring(startindex, endindex) == tempVar.substring(startindex, endindex))) 
		{ 
			objMsiaState.selectedIndex = i; 
			break; 
		} 
	} 
   return i;  
} 
function populateDuplicateLocation(objMsiaState, data, strmsia, strloc, strcity){   
	for(var i =0 ; i< objMsiaState.options.length; i++){  
 		if(objMsiaState.options[i].value == data){  
			objMsiaState.selectedIndex = i;  
			break; 
		}else{ 
			var tmpst =  strmsia; 
			var tmplc =  strloc; 
			var tmpct =  strcity;	 
				var d = objMsiaState.options[i].value.split(":"); 
			if(d[0] == tmpst && d[1] == tmplc){ 
				var c = d[2].toLowerCase(); 
				var tmpct = tmpct.toLowerCase(); 
				if ( c.indexOf(tmpct) >= 0 || tmpct.indexOf(c) >= 0 ){ 
					objMsiaState.selectedIndex = i; 
						break; 
				} 
			} 
		} 
   }  
   return i;  
}  
function populateOtherLocation(objMsiaState, objCity, objLocation, strmsia, strcity){ 
  for(var i =0 ; i< objMsiaState.options.length; i++){ 
	var tmpst = strmsia; 
	var tmpct =  strcity;	 
				var d = objMsiaState.options[i].value.split(":"); 
			if(d[0] == tmpst){ 
			   if(d[2] != null && d[2].length > 0 ){ 
				var c = d[2].toLowerCase();  
				var tmpct = tmpct.toLowerCase(); 
				if ( c.indexOf(tmpct) >= 0 || tmpct.indexOf(c) >= 0 ){ 
					objMsiaState.selectedIndex = i; 
					break; 
				} 
				} 
			}
		} 
	if(i <  objMsiaState.options.length){ 
		enterCity(objMsiaState.options[i].value, objCity, objLocation, false) 
   }  
   return i;  
  }  
</script>

	<center>
		<table width="100%">
			<tr>
				<td>
					<table cellpadding=0 cellspacing=0 border=0 align=center
						width="100%">
						<tr>
							<td colspan=2 style='height: 1px;'><? if ($mess!="") {echo "<center><b><font color='#FF0000' size='3'>There's an  ".$mess." Please try again</font></b></center>"; }?>
							</td>
						</tr>
						<tr>
							<td width=100% valign=top align=center><img
								src='images/space.gif' width='1' height='10'><br clear=all>
								<table width=100% cellpadding=10 cellspacing=0 border=0>
									<tr>
										<td>
											<table width=98% cellspacing=0 cellpadding=0 align=center>
												<tr>
													<td class=msg><b>Fill in this section to give employers a
															snapshot of your profile.</b> <br></td>
												</tr>
											</table> <br>
											<form method="POST" name="frmPersonal"
												action="admin_updatepersonalphp.php?userid=<?php echo $userid; ?>"
												onsubmit="return checkFields();">
												<input type="hidden" name="userid"
													value="<? echo $userid;?>" />
												<table width=100% cellspacing=8 cellpadding=2 border=0
													align=left>
													<tr>
														<td width=100% bgcolor=#DEE5EB colspan=3><b>Personal
																Details</b></td>
													</tr>
													<tr>
														<td width=30% align=right>First Name :</td>
														<td colspan=2><INPUT size='30' class='text'
															style="width: 270px" name='fname'
															value="<? echo $fname;?>"></td>
													</tr>
													<tr>
														<td width=30% align=right>Family/Last Name :</td>
														<td colspan=2><INPUT size="30" class=text
															style="width: 270px" name="lname"
															value="<? echo $lname;?>"></td>
													</tr>
													<tr valign=top>
														<td align=right width=30%>Date of Birth :</td>
														<td colspan=2><select name="bday" class="text">
														<? echo $dayoptions;?>
														</select> - <select name="bmonth" class="text">
														<? echo $monthoptions;?>
														</select> - <input type="text" name="byear" size="4"
															maxlength=4 style='' value="<? echo $byear;?>" class=text>
															(YYYY)</td>
													</tr>

													<tr valign=top>
														<td align=right width=30%>Identification :<br>(Optional)
															&nbsp;</td>
														<td colspan=2><select name="auth_no_type_id"
															style="font: 8pt, Verdana">
																<option value="0" selected>-</option>
																<? echo $idoptions;?>
														</select> - <INPUT maxLength=30 size=15 style=''
															class="text" name="msia_new_ic_no"
															value="<? echo $msia_new_ic_no;?>"><br>&nbsp;&nbsp; <img
															src='images/arrow.gif'><a href="#">which one should I
																use?</a></td>
													</tr>
													<tr valign=top>
														<td align=right width=30%>Gender :</td>
														<td colspan=2><?
														if ($gender == "Male")
														{
															echo "<INPUT type=radio value='Female' name='gender'>Female &nbsp;&nbsp;
		   <INPUT type=radio value='Male' checked name='gender' >Male";
														}
														elseif ($gender == "Female")
														{
															echo "<INPUT type=radio value='Female' checked name='gender'>Female &nbsp;&nbsp;
		  <INPUT type=radio value='Male' name='gender' >Male";
														}
														else
														{
															echo "<INPUT type=radio value='Female' name='gender'>Female &nbsp;&nbsp;
		  <INPUT type=radio value='Male' name='gender' >Male";
														}




														?>
														</td>
													</tr>
													<tr valign=top>
														<td align=right width=30%>Nationality :</td>
														<td colspan=2><select name="nationality"
															style="width: 270px; font: 8pt, Verdana">
																<option value="0">-</option>
																<? echo $countryoptions;?>
														</select>
														</td>
													</tr>
													<tr valign=top>
														<td align=right width=30%>Permanent Resident&nbsp;&nbsp;<br>Status
															In :<br>(Optional)&nbsp;&nbsp;</td>
														<td colspan=2>

															<table cellspacing=1 width=100% border=0 cellpadding=1
																align=center>
																<tr valign=top>
																<? echo $residenceoptions; ?>
																</tr>
																<tr>
																<? echo $residenceoptions2; ?>
																</tr>
																<tr>
																<? echo $residenceoptions3; ?>
																</tr>
																<tr>
																<? echo $residenceoptions4; ?>
																</tr>
																<tr>
																<? echo $residenceoptions5; ?>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td width=100% bgcolor=#DEE5EB colspan=3><b>Working at
																Home Capabilities</b></td>
													</tr>
													<tr valign=top>
														<td align=right width=30%>Home Working Environment :</td>
														<td><input name="home_working_environment" type="radio"
															value="private room" <?=$selected1;?>> Private Room&nbsp;<input
															type="radio" <?=$selected2;?>
															name="home_working_environment" value="shared room">Shared
															Room&nbsp;<input type="radio" <?=$selected3;?>
															name="home_working_environment" value="living room">Living
															Room&nbsp;</td>
													</tr>
													<tr valign=top>
														<td align=right width=30%>Internet Connection :</td>
														<td><input type="radio" name="internet_connection"
														<?=$checked1;?> value="WI-FI">WI-FI&nbsp;<input
															type="radio" <?=$checked2;?> name="internet_connection"
															value="DIAL-UP">Dial-Up&nbsp;<input type="radio"
															<?=$checked3;?> name="internet_connection" value="DSL">DSL&nbsp;</td>
													</tr>
													<tr valign=top>
														<td align=right width=30%>Internet Provider (ISP) :</td>
														<td><INPUT size=30 style='width: 270px' class="text"
															name="isp" value="<?=$isp;?>"></td>
													</tr>
													<tr valign=top>
														<td align=right width=30%>Speed Test Link :</td>
														<td><INPUT size=30 style='width: 270px' class="text"
															name="speed_test" value="<?=$speed_test;?>"></td>
													</tr>
													<tr valign=top>
														<td align=right width=30%>List of Computer Hardware:</td>
														<td><textarea name="computer_hardware" cols="30" rows="5">
														<?=$computer_hardware;?>
															</textarea></td>
													</tr>
													<tr valign=top>
														<td width=30% height="23" align=right>Headset Quality :</td>
														<td><select name="headset_quality" class="text">
																<option value=0>No Headset</option>
																<?=$headsetQualityoptions;?>
														</select>&nbsp;1 = Low...5 = High&nbsp;&nbsp;</td>
													</tr>
													<tr>
														<td width=100% bgcolor=#DEE5EB colspan=3><b>Login Details</b>
														</td>
													</tr>
													<tr valign=top>
														<td align=right width=30%>Primary Email :</td>
														<td><INPUT maxLength=100 size=30 style='width: 270px'
															class="text" name="email" value="<? echo $email;?>"
															onChange="javascript: ValidateOneEmail(this);"></td>
													</tr>
													<tr valign=top>
														<td align=right width=30%>Password :</td>
														<td><?=$pass;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a
															href="/portal/forgotpass.php?user=applicant"
															target="_blank">Change Password</a></td>
													</tr>

												</table>
												<br clear=all> <br>
												<table width=100% cellspacing=8 cellpadding=2 border=0
													align=left>
													<tr>
														<td width=100% bgcolor=#DEE5EB colspan=3><b>Communication Skill</b>
														</td>
													</tr>
													<tr valign=top>
														<td align=right width=30%>English Communication Skill: </td>
														<td>
															<select name="english_communication_skill">
															<?php 
																for($i=0;$i<=10;$i++){
																	
																	if ($i==0){
																		$label = ""; 
																	}else{
																		$label = $i;
																	}
																	
																	if ($i==$english_level){
																		$selected = "selected";
																	}else{
																		$selected = "";
																	}
																	?><option value="<?php echo $i?>" <?php echo $selected?>><?php echo $label?></option><?php 																	
																}
																
															?>										
															</select>
															
														</td>
													</tr>
												</table>

												<br clear=all> <br>
												<table width=100% cellspacing=8 cellpadding=2 border=0
													align=left>
													<tr>
														<td width=100% bgcolor=#DEE5EB colspan=3><b>Contact Info</b>
														</td>
													</tr>

													<tr valign=top>
														<td align=right width=30%>Alternative Email :<br>(Optional)&nbsp;&nbsp;</td>
														<td><INPUT maxLength=100 size=30 style='width: 270px'
															class="text" name="alt_email"
															value="<? echo $alt_email;?>"
															onChange="javascript: if (Trim(this.value) != '') {	if (Trim(this.value) == Trim(form.email.value)) { alert('Please enter your alternate email different from your Primary Email'); validated = false; return false; } else { return ValidateOneEmail(this); }}"><br>&nbsp;&nbsp;<img
															src='images/arrow.gif'><font class=tip>will be used if
																primary email is not reachable</font></td>
													</tr>
													<tr valign=top>
														<td align=right width=30%>Mobile No. :</td>
														<td><SELECT name="handphone_country_code"
															style='font: 8pt, Verdana; width: 120px'>
																<option value=""></option>
																<option value="880">88 (Bangladesh)</option>
																<option value="91">91 (India)</option>
																<option value="62">62 (Indonesia)</option>
																<option value="60">60 (Malaysia)</option>
																<option value="63" selected>63 (Philippines)</option>
																<option value="65">65 (Singapore)</option>
																<option value="0">Other</option>
														</SELECT> - <INPUT maxLength=15 size=15
															style='width: 136px' class="text" name="handphone_no"
															value="<? echo $handphone_no;?>">
														</td>
													</tr>
													<tr valign=top>
														<td align=right width=30%>Telephone No. :</td>
														<td><INPUT maxLength=5 size=5 style='width: 60px'
															class="text" name="tel_area_code"
															value="<? echo $tel_area_code;?>"> - <INPUT maxLength=20
															size=22 style='width: 196px' class=text name="tel_no"
															value="<? echo $tel_no;?>"><br> <font class=tip>Area Code
																- Number</font></td>
													</tr>
													<tr valign=top>
														<td align=right width=30% valign=top>Address :</td>
														<td><INPUT size=30 style='width: 270px' class="text"
															name="address1" value="<? echo $address1;?>"></td>
													</tr>
													<tr valign=top>
														<td align=right width=30%>Address 2 :</td>
														<td><INPUT size=30 style='width: 270px'
															class="text" name="address2" value="<? echo $address2;?>">
														</td>
													</tr>
													
													<tr valign=top>
														<td align=right width=30%>Postal Code :</td>
														<td><INPUT maxLength=20 size=30 style='width: 270px'
															class="text" name="postcode" value="<? echo $postcode;?>">
														</td>
													</tr>
													<tr valign=top>
														<td align=right width=30%>Country :</td>
														<td><select name="country_id"
															onChange="javascript: emptyLocationSelect(this.form.state, this.options[this.selectedIndex].value,this.form.msia_state_id,this.form.city, this.form.location_code) ;"
															style="width: 270px; font: 8pt, Verdana">
																<option value="00">-</option>
																<? echo $country_idoptions ;?>
														</select>
														</td>
													</tr>
													<tr>
														<td align=right width=30%>State/Region :</td>
														<td><select name="msia_state_id" value="NC"
															onChange="return enterCity(form.msia_state_id.options[form.msia_state_id.options.selectedIndex].value, this.form.city, this.form.location_code, true);"
															style="width: 270px; font: 8pt verdana"><OPTION
																	value="00">Select State/Region
																	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</OPTION>
																<OPTION value="00">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</OPTION>
														</select> <br> <INPUT maxLength=20 size=30
															style='width: 270px' class="text" name="state"
															value="<? echo $state;?>"><input type=hidden
															name="state2" value=""></td>
													</tr>
													<tr valign=top>
														<td align=right width=30%>City :</td>
														<td><input type=hidden name=location_code value=""><INPUT
															maxLength=20 size=30 style='width: 270px' class="text"
															name="city" value="<? echo $city;?>"></td>
													</tr>
												</table>
												<br clear=all>
												<table width=100% cellspacing=8 cellpadding=2 border=0
													align=left>
													<tr>
														<td width=100% bgcolor=#DEE5EB colspan=3><b>&nbsp;Online
																Contact Info (OPTIONAL)</b></td>
													</tr>
													<tr>
														<td><div id='internet_acc' class='toggleshow'>
																<table width='100%' cellpadding=2 cellspacing=4 border=0>
																	<tr valign=top>
																		<td align=left colspan=2><a name='ia'>Fill in your
																				Instant Messaging (IM) Usernames here to provide us
																				with an alternative way to contact you. <font
																				color=red><b>Note: This section is fully optional.</b>
																			</font> </a><br> <br></td>
																	</tr>
																	<tr valign=top>
																		<td align=right width=30%>MSN Messenger ID :</td>
																		<td><INPUT maxLength=80 size=30 style='width: 200px'
																			class=text name="msn_id" value="<? echo $msn_id;?>">
																		</td>
																	</tr>
																	<tr valign=top>
																		<td align=right width=30%>Yahoo! Messenger ID :</td>
																		<td><INPUT maxLength=80 size=30 style='width: 200px'
																			class="text" name="yahoo_id"
																			value="<? echo $yahoo_id;?>"></td>
																	</tr>
																	<tr valign=top>
																		<td align=right width=30%>ICQ Number :</td>
																		<td><INPUT maxLength=80 size=30 style='width: 200px'
																			class=text name="icq_id" value="<? echo $icq_id;?>">
																		</td>
																	</tr>
																	<tr valign=top>
																		<td align=right width=30%>Skype ID :</td>
																		<td><INPUT maxLength=80 size=30 style='width: 200px'
																			class="text" name="skype_id"
																			value="<? echo $skype_id;?>"></td>
																	</tr>
																	<tr>
																		<td colspan=2>&nbsp;</td>
																	</tr>
																</table>
															</div></td>
													</tr>
												</table>
												<br clear=all> <br>
												<table width=100% border=0 cellspacing=1 cellpadding=2>
													<tr>
														<td align=center><INPUT type=submit value='Update'
															name="btnSubmit" class="button" style='width: 120px'></td>
													</tr>
												</table>
											</form></td>
									</tr>
								</table></td>
						</tr>
					</table> <script language="javascript">
	emptyLocationSelect(document.frmPersonal.state, document.frmPersonal.country_id.options[document.frmPersonal.country_id.selectedIndex].value,document.frmPersonal.msia_state_id, document.frmPersonal.city, document.frmPersonal.location_code);
	repopulateLocation(document.frmPersonal.msia_state_id, "NC", 0, 2);
</script>
				</td>
			</tr>
		</table>
		</td>
		</tr>
		</table>
	</center>

</body>
</html>
