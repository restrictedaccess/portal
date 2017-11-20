<?
//$userid=$_REQUEST['userid'];
include 'conf.php';
$userid=$_SESSION['userid'];
//echo $userid;
$mess="";
$mess=$_REQUEST['mess'];
$countryoptions="";
$countrycodes="";
$fieldoptions="";
$fieldstudy="";
$college_country="";

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
      if($college_country == $countrycodes[$count])
      {
	 $countryoptions .= "<option selected value=\"$countrycodes[$count]\">$countrynames[$count]</option>\n";
      }
      else
      {
	 $countryoptions .= "<option value=\"$countrycodes[$count]\">$countrynames[$count]</option>\n";
      }
   }

$fieldCodesArray=array("Advertising/Media","Agriculture/Aquaculture/Forestry","Airline Operation/Airport Management","Architecture","Art/Design/Creative Multimedia","Biology","BioTechnology","Business Studies/Administration/Management","Chemistry","Commerce","Computer Science/Information Technology","Dentistry","Economics","Education/Teaching/Training","Engineering (Aviation/Aeronautics/Astronautics)","Engineering (Bioengineering/Biomedical)","Engineering (Chemical)","Engineering (Civil)","Engineering (Computer/Telecommunication)","Engineering (Electrical/Electronic)","Engineering (Environmental/Health/Safety)","Engineering (Industrial)","Engineering (Marine)","Engineering (Material Science)","Engineering (Mechanical)","Engineering (Mechatronic/Electromechanical)","Engineering (Metal Fabrication/Tool & Die/Welding)","Engineering (Mining/Mineral)","Engineering (Others)","Engineering (Petroleum/Oil/Gas)","Finance/Accountancy/Banking","Food & Beverage Services Management","Food Technology/Nutrition/Dietetics","Geographical Science","Geology/Geophysics","History","Hospitality/Tourism/Hotel Management","Human Resource Management","Humanities/Liberal Arts","Journalism","Law","Library Management","Linguistics/Languages","Logistic/Transportation","Maritime Studies","Marketing","Mass Communications","Mathematics","Medical Science","Medicine","Music/Performing Arts Studies","Nursing","Optometry","Others","Personal Services","Pharmacy/Pharmacology","Philosophy","Physical Therapy/Physiotherapy","Physics","Political Science","Property Development/Real Estate Management","Protective Services & Management","Psychology","Quantity Survey","Science & Technology","Secretarial","Social Science/Sociology","Sports Science & Management","Textile/Fashion Design","Urban Studies/Town Planning","Veterinary");

 for ($count = 0; $count < count($fieldCodesArray); $count++) {
      if($fieldstudy == $fieldCodesArray[$count])
      {
	$fieldoptions .= "<option selected value=\"$fieldCodesArray[$count]\">$fieldCodesArray[$count]</option>\n";
      }
      else
      {
	 $fieldoptions .= "<option value=\"$fieldCodesArray[$count]\">$fieldCodesArray[$count]</option>\n";
      }
   }

?>
<html>
<head>
<title>MyProfile &copy; RemoteStaff.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
<script language=javascript src="js/util.js"></script>
<script type="text/javascript">
<!--
function checkFields()
{
	//if (confirm("Are you sure"))
	//{
	//	return true;
	//}
	//else return false;
	var year =document.edu.graduate_year.value;
	
	missinginfo = "";
	if (document.edu.educationallevel.selectedIndex=="0")
	{
		missinginfo += "\n     -  Please choose your Educational Attainment";
	}
	if (document.edu.fieldstudy.selectedIndex=="0")
	{
		missinginfo += "\n     -  Please choose your Field of Study";
	}//grade
	if (document.edu.grade.value == "Grade Point Average (GPA)")
	{
		if (document.edu.gpascore.value=="")
		{
			missinginfo += "\n     -  Please enter your Grade Point Average (GPA) score";
		}
		if (IsNumeric(document.edu.gpascore.value)==false)
		{
			missinginfo += "\n     -  Please enter a valid Grade Point Average (GPA) score";
		}

		
	}
	if (document.edu.college_name.value == "")
	{
		missinginfo += "\n     -  Please enter your Institution / University /School Name";
	}
	
	if (document.edu.college_country.selectedIndex=="0")
	{
		missinginfo += "\n     -  Please enter your Institution / University /School Location";
	}
	//
	if (document.edu.graduate_month.selectedIndex=="0")
	{
		missinginfo += "\n     -  Please enter Graduation Month";
	}
	if (year == "")
	{
		missinginfo += "\n     -  Please enter Graduation Year";
	}
	if (year.length <4 && year!="")
	{
		missinginfo += "\n     -  Please enter a valid Graduation Year \n \t Format must be (YYYY)";
	}
	///////////////////////////////////////////////
		
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
<form method="POST" name="edu" action="educationphp.php"onsubmit="return checkFields();">
<!-- header -->
<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="background-color:#FFFFFF; background-repeat: repeat-x;">
<tr><td width="546" style="width: 220px; height: 60px;"><img src="images/remotestafflogo.jpg" alt="think" width="416" height="108"></td>
<td width="474">&nbsp;</td>
<td width="211" align="right" valign="bottom"></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width: 100%; background: URL('images/bg1.gif'); background-repeat: repeat-x">
<tr><td style="border-bottom: 2px #0d509e solid; " >&nbsp;</td>
</tr>
</table>
<!-- header -->
<table cellpadding="0" cellspacing="0" border="0" width="744">
		<tr><td width="736" bgcolor="#ffffff" align="center">
			<table width="736" cellpadding="0" cellspacing="0" border="0" align="center">
				<tr><td>
<table width=736 cellpadding=0 cellspacing=0 border=0 align=center><tr><td colspan=2 style='height: 1px;'>
<? if ($mess!="") {echo "<center><b><font color='#FF0000' size='3'>There's an  ".$mess." Please try again</font></b></center>"; }?>

</td></tr><tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<div style="border: #FFFFFF solid 1px; width:230px; margin-top:20px;">
<p><a href="index.php" class="link12b">Home</a></p>
<p>Applicants Registration Form</p>
<ul>-- Status --
<li style="margin-bottom:10px;">Personal Details <img src="images/action_check.gif" align="absmiddle"></li>
<li style="margin-bottom:10px;"><b style="color:#0000FF">Educational Details </b><img src="images/arrow.gif"></li>
<li style="margin-bottom:10px;">Work Experinced Details <img src="images/cross.gif"></li>
<li style="margin-bottom:10px;">Skills Details <img src="images/cross.gif"></li>
<li style="margin-bottom:10px;">Languages Details <img src="images/cross.gif"></li>
<li style="margin-bottom:10px;">Upload Photo <img src="images/cross.gif"></li>
<li style="margin-bottom:10px;">Voice Recording <img src="images/cross.gif"></li>
</ul>
</div>


</td><td width=566 valign=top align=right><img src=images/space.gif width=1 height=10><br clear=all><table width=566 cellpadding=10 cellspacing=0 border=0><tr><td><table width=98% cellspacing=0 cellpadding=0 align=center>
<tr><td class=msg><b>Fill in this section to give employers a snapshot of your profile.</b></td></tr>
<tr><td valign="top">
<div style=" margin-top:10px;">
	<div><b>Trainings and Seminars Attended</b></div>
	<textarea id="trainings_seminars" name="trainings_seminars" style="width:100%; height:400px;" ><?=$trainings_seminars;?></textarea>
</div>
</td></tr>

</table>

<table width=100% cellspacing=8 cellpadding=2 border=0 align=left ><tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Highest Academic Qualification</b></td></tr><tr valign=top><td align=right  >Highest Level :</td><td>
<select name="educationallevel"  style="width:390px;font:8pt, Verdana">
<option value="0">-</option>
<option value="High School Diploma">High School Diploma</option>
<option value="Vocational Diploma / Short Course Certificate" >Vocational Diploma / Short Course Certificate</option>
<option value="Bachelor/College Degree">Bachelor/College Degree </option>
<option value="Post Graduate Diploma / Master Degree">Post Graduate Diploma / Master Degree</option>
<option value="Professional License (Passed Board/Bar/Professional License Exam)">Professional License (Passed Board/Bar/Professional License Exam)</option>
<option value="Doctorate Degree">Doctorate Degree</option>
</select></td></tr>
<tr valign=top><td align=right  >Field of Study :</td><td><select name="fieldstudy" style="width:390px;font:8pt, Verdana" >
<option value="000">-</option>
<? echo $fieldoptions; ?>

</select></td></tr>
<tr valign=top><td align=right  >&nbsp;&nbsp;&nbsp;Major :</td>
<td><INPUT maxLength=100 size=30 style='width:270px' class="text" name="major" value=""></td></tr>
<tr valign=top><td align=right  >Grade :</td><td>
<select name="grade" style="width:270px;font:8pt, Verdana" >
<option value="Grade Point Average (GPA)" >Grade Point Average (GPA)</option>
<option value="Incomplete">Incomplete</option>
</select></td></tr>
<tr valign=top><td>&nbsp;</td>
<td>If GPA, please enter score: <INPUT maxLength=5 size=3 style='width:35px' class="text" name="gpascore" value=""> out of 100</td>
</tr>
<tr valign=top><td align=right  >Institute / University :</td>
<td><INPUT maxLength="100" size="30" style="width:270px" class="text" name="college_name" value=""></td></tr>
<tr valign=top><td align=right  >Located In :</td>
<td><select name="college_country" style="width:270px;font:8pt, Verdana" >
<option value="00">-</option>
<? echo $countryoptions;?>
</select>
</td></tr><tr valign=top><td align=right  >Graduation Date :</td>
<td>
<select name="graduate_month" class=text>
 <option value='0'></option>
 <option value=1>January</option>
 <option value=2>February</option>
 <option value=3>March</option>
 <option value=4>April</option>
 <option value=5>May</option>
 <option value=6>June</option>
 <option value=7>July</option>
 <option value=8 >August</option>
 <option value=9>September</option>
 <option value=10>October</option>
 <option value=11>November</option>
 <option value=12>December</option>

</select> - <input type="text" name="graduate_year" size=4 maxlength=4 style='width=50px' value=""  class="text"> (YYYY)<br>&nbsp;&nbsp;<img src='images/arrow.gif'><font class=tip>Enter expected graduation date if still pursuing</font></td></tr></table><br clear=all><input type="hidden" name="userid" value="<? echo $userid?>"><br><table width=100% border=0 cellspacing=1 cellpadding=2><tr><td align=center><INPUT type=submit value='Save & Next' name="btnSubmit" class=button style='width:120px'></td></tr></table></td></tr></table></td></tr></table>

				</td></tr>
			</table>
		</td></tr>
</table>
<? include 'footer.php';?>
</form>
</body>
</html>
