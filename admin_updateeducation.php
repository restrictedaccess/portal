<?
include 'conf.php';
include 'config.php';
include 'function.php';
$userid = @$_GET["userid"]; //$_SESSION['userid'];
$mess="";
$mess=$_REQUEST['mess'];
$countryoptions="";
$countrycodes="";
$fieldoptions="";
$fieldstudy="";
$college_country="";


if($_SESSION['admin_id']=="")
{
	echo '
	<script language="javascript">
		alert("Session expired.");
	</script>
	';
	header("location:http:index.php");
}


/*
0 id,1 userid,2 educationallevel,3 fieldstudy,4 major,5 grade,6 gpascore,7 college_name,8 college_country,9 graduate_month,10 graduate_year
*/
$query="SELECT * FROM education WHERE userid=$userid";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result, MYSQL_NUM); 
	$educationallevel = $row[2];
	$educationallevel = str_replace("Bachelor's/College Degree","Bachelor/College Degree",$educationallevel);
	$fieldstudy = $row[3];
	$grade = $row[5];
	$score = $row[6];
	$major = $row[4];
	$college_name =$row[7];
	$college_country  = $row[8];
	$year =$row[10];
	$month =$row[9];
	
	
	
	
}	
$educationNames=array("High School Diploma","Vocational Diploma / Short Course Certificate","Bachelor/College Degree","Post Graduate Diploma / Master Degree","Professional License (Passed Board/Bar/Professional License Exam)","Doctorate Degree");
for ($count = 0; $count < count($educationNames); $count++) {
      if($educationallevel == $educationNames[$count])
      {
	 $educationalleveloptions .= "<option selected value=\"$educationNames[$count]\">$educationNames[$count]</option>\n";
      }
      else
      {
	 $educationalleveloptions .= "<option value=\"$educationNames[$count]\">$educationNames[$count]</option>\n";
      }
   }
$gradeNames=array("Grade Point Average (GPA)","Incomplete");
for ($count = 0; $count < count($gradeNames); $count++) {
      if($grade == $gradeNames[$count])
      {
	 $gradeoptions .= "<option selected value=\"$gradeNames[$count]\">$gradeNames[$count]</option>\n";
      }
      else
      {
	 $gradeoptions .= "<option value=\"$gradeNames[$count]\">$gradeNames[$count]</option>\n";
      }
   }

$monthNames = array("-","January","February","March","April","May","June","July","August","September","October","November","December");
for ($i = 0; $i <=12 ; $i++) {
      if($month == $i)
      {
	 $monthoptions .= "<option selected value=\"$i\">$monthNames[$i]</option>\n";
      }
      else
      {
	 $monthoptions .= "<option value=\"$i\">$monthNames[$i]</option>\n";
      }
 
   }	


//////////////
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
<title>MyProfile &copy;ThinkInnovations.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

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
<center>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr><td width="100%" bgcolor="#ffffff" align="center">
			<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
				<tr><td>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center><tr><td colspan=2 style='height: 1px;'>
<? if ($mess!="") {echo "<center><b><font color='#FF0000' size='3'>There's an  ".$mess." Please try again</font></b></center>"; }?>

</td></tr><tr>



<td width=100% valign=top align=right><img src=images/space.gif width=1 height=10><br clear=all><table width=100% cellpadding=10 cellspacing=0 border=0><tr><td><table width=98% cellspacing=0 cellpadding=0 align=center><tr><td class=msg><b>Fill in this section to give employers a snapshot of your profile.</b> <br></td>
</tr></table>
<br>
<form method="POST" name="edu" action="admin_updateeducationphp.php?userid=<?php echo $userid; ?>"onsubmit="return checkFields();">


<table width=100% cellspacing=8 cellpadding=2 border=0 align=left ><tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Highest Academic Qualification</b></td></tr><tr valign=top><td align=right  >Highest Level :</td><td>
<select name="educationallevel"  style="width:390px;font:8pt, Verdana">
<option value="0">-</option>
<? echo $educationalleveloptions;?>
</select></td></tr>
<tr valign=top><td align=right  >Field of Study :</td><td><select name="fieldstudy" style="width:390px;font:8pt, Verdana" >
<option value="000">-</option>
<? echo $fieldoptions; ?>

</select></td></tr>
<tr valign=top><td align=right  >&nbsp;&nbsp;&nbsp;Major :</td>
<td><INPUT maxLength=100 size=30 style='width:270px' class="text" name="major" value="<? echo $major;?>"></td></tr>
<tr valign=top><td align=right  >Grade :</td><td>
<select name="grade" style="width:270px;font:8pt, Verdana" >
<? echo $gradeoptions;?>
</select>
</td></tr>
<tr valign=top><td>&nbsp;</td>
<td>If GPA, please enter score: <INPUT maxLength=5 size=3 style='width:35px' class="text" name="gpascore" value="<? echo $score;?>"> out of 100</td>
</tr>
<tr valign=top><td align=right  >Institute / University :</td>
<td><INPUT maxLength="100" size="30" style="width:270px" class="text" name="college_name" value="<? echo $college_name; ?>"></td></tr>
<tr valign=top><td align=right  >Located In :</td>
<td><select name="college_country" style="width:270px;font:8pt, Verdana" >
<option value="00">-</option>
<? echo $countryoptions;?>
</select>
</td></tr><tr valign=top><td align=right  >Graduation Date :</td>
<td>
<select name="graduate_month" class=text>
<? echo $monthoptions;?>
s</select> - <input type="text" name="graduate_year" size=4 maxlength=4 style='width=50px' value="<? echo $year;?>"  class="text"> (YYYY)<br>&nbsp;&nbsp;<img src='images/arrow.gif'><font class=tip>Enter expected graduation date if still pursuing</font></td></tr></table><br clear=all><input type="hidden" name="userid" value="<? echo $userid?>"><br><table width=100% border=0 cellspacing=1 cellpadding=2><tr><td align=center><INPUT type=submit value='Save' name="btnSubmit" class=button style='width:120px'></td></tr></table></form></td></tr></table></td></tr></table>

				</td></tr>
			</table>
		</td></tr>
</table>
	<!-- /CONTENT -->
</center>	
</body>
</html>
