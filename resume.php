<?
include 'config.php';
include 'function.php';

$userid=$_REQUEST['userid'];
//echo $userid;
/*
userid, lname, fname, byear, bmonth, bday, auth_no_type_id, msia_new_ic_no, gender, nationality, permanent_residence, email, pass, alt_email, handphone_country_code, handphone_no, tel_area_code, tel_no, address1, address2, postcode, country_id, state, city, msn_id, yahoo_id, icq_id, skype_id, image, datecreated, dateupdated, status, home_working_environment, internet_connection, isp, computer_hardware, headset_quality

*/
$query="SELECT * FROM personal p  WHERE p.userid=$userid";
$query2="SELECT * FROM currentjob c  WHERE c.userid=$userid";
$result2=mysql_query($query2);
//echo $query;
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result); 
	$row2 = mysql_fetch_array ($result2); 
	$latest_job_title=$row2['latest_job_title'];
	$image= $row['image'];

	$name =$row['lname']."  ,".$row['fname'];
	$dateapplied =$row['datecreated'];
	$dateupdated =$row['dateupdated'];
	$address=$row['address1']." ".$row['city']." ".$row['postcode']." <br>".$row['state']." ".$row['country_id'];
	$tel=$row['tel_area_code']." - ".$row['tel_no'];
	$cell =$row['handphone_country_code']."+".$row['handphone_no'];
	$email =$row['email'];
	$byear = $row['byear'];
	$bmonth = $row['bmonth'];
	$bday = $row['bday'];
	$gender =$row['gender'];
	$nationality =$row['nationality'];
	$residence =$row['permanent_residence'];
	
	$home_working_environment=$row['home_working_environment'];
	$internet_connection=$row['internet_connection'];
	$isp=$row['isp'];
	$computer_hardware=$row['computer_hardware'];
	$headset_quality=$row['headset_quality'];
	
	$computer_hardware2=str_replace("\n","<b>",$computer_hardware);
	if($headset_quality=="0") {
		$headset_quality ="No Headset Available";
	}	
	$message="<p align =justify>Working Environment :".$home_working_environment."<br>";
	$message.="Internet Connection :".$internet_connection."<br>";
	$message."Internet Provider :".$isp."<br>";
	$message.="Computer Hardware/s :".$computer_hardware2."<br>";
	$message.="Headset Quality :".$headset_quality."<br></p>";
	$yr = date("Y");
	switch($bmonth)
	{
		case 1:
		$bmonth= "Jan";
		break;
		case 2:
		$bmonth= "Feb";
		break;
		case 3:
		$bmonth= "Mar";
		break;
		case 4:
		$bmonth= "Apr";
		break;
		case 5:
		$bmonth= "May";
		break;
		case 6:
		$bmonth= "Jun";
		break;
		case 7:
		$bmonth= "Jul";
		break;
		case 8:
		$bmonth= "Aug";
		break;
		case 9:
		$bmonth= "Sep";
		break;
		case 10:
		$bmonth= "Oct";
		break;
		case 11:
		$bmonth= "Nov";
		break;
		case 12:
		$month= "Dec";
		break;
		default:
		break;
	}
	
	
}




?>




<html>
<head>
<title>MyProfile &copy;ThinkInnovations.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/resume.css">
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">


<script language=javascript src="js/functions.js"></script>
<script language=javascript src="js/cookie.js"></script>
<script language=javascript src="js/js2/functions.js"></script>
<script language=javascript src="js/js2/png.js"></script>

<? include 'header.php';?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="32">
				<tr><td width="736"  bgcolor="#abccdd" >
					<table width="736">
						<tr>
							<td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome, <? echo $name;?>
							
							<a href="#" style="color: #0065B7;" > Click here</a> to go back to your Personal Page.
							</b></td>
							<td align="right" style="font: 8pt verdana; ">
		<a href="">Preview Your Printable Resume</a>&#160;</td>
							
						</tr>
					</table>
				</td></tr>
</table>
			<!-- /WELCOME MESSAGE -->
	
	<!-- CONTENT -->
	<table cellpadding="0" cellspacing="0" border="0" width="744">
		<tr><td width="736" bgcolor="#ffffff" align="center">
			<table width="736" cellpadding="0" cellspacing="0" border="0" align="center">
				<tr><td>
<table width=736 cellpadding=0 cellspacing=0 border=0 align=center>
<tr>
<td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='images/space.gif' width=1 height=10><br clear=all>

<?
if ($userid!="")
{
	include 'applicantleftnav.php';
}


?>
<br>
</td>
<td width=566 valign=top align=right>
<img src=images/space.gif width=1 height=10>
<br clear=all>
<table width=100% cellpadding=10 cellspacing=0 border=0>
<tr>
<td>
<table width=100% cellspacing=1 cellpadding=2 border=0>
<tr><td>


<table width='100%' border='0' cellpadding='2' cellspacing='0' align='center'>
<tr valign="top">
<td valign="top" colspan="6">
<!-- image -->
<table width="100%">
<tr>
<td width="30%"><?  if ($image!="") echo "<img border=0 src='$image' width=110 height=150>";?></td>
<td width="70%" class="subtitle"><? echo $name;?><br>
<? echo $latest_job_title;?>
</td>
</tr>
</table>

<!-- image -->
</td></tr><tr><td valign="top" colspan="6" class="subtitle">
<? //echo $name;?>
</td></tr><tr><td colspan="3" style="padding-bottom:5px">
				<a href="#"><img border=0 style='vertical-align:middle' src='images/attach.gif'></a>
				<a href="#">View My Attached Resume</a></td>
<td colspan="4" align="right">
<i><b>Date Applied: </b><? echo format_date($dateapplied);?></i><br>
<? if ($dateupdated!=""){echo "<i><b>Last Update: </b>";echo format_date($dateupdated);echo "</i>"; }?></td></tr>

<!-- personal info -->

<tr class="TRHeader"><td valign="top" colspan="6" class="ResumeHdr"><b>Contact Info</b></td><td width="5%" valign="top">
<a href="updatepersonal.php?userid=<? echo $userid;?>">Edit</a>
</td>
</tr>
<tr>
<td width="20%" valign="top"><b>Address</b></td>
<td width="2%" valign="top">:</td>
<td valign="top" colspan="4">
<? echo $address;?></td></tr><tr><td valign="top"><b>Telephone No.</b></td><td valign="top">:</td>
<td valign="top" colspan="4">
<? echo $tel;?></td></tr><tr><td valign="top"><b>Mobile No.</b></td>
<td valign="top">:</td><td valign="top" colspan="4">
<? echo $cell;?>
</td></tr>
<tr><td valign="top"><b>Email</b></td><td valign="top">:</td><td width="37%" valign="top">
<a href=mailto:<? echo $email; ?>><? echo $email;?></a>
</td>
<td valign="top" colspan="3"> </td></tr><tr><td valign="top" colspan="6"> </td></tr><tr class="TRHeader"><td valign="top" colspan="6" class="ResumeHdr"><b>Personal Particulars</b></td><td valign="top"><a href="updatepersonal.php?userid=<? echo $userid;?>">Edit</a> </td></tr><tr><td valign="top"><b>Age</b></td><td valign="top">:</td>
<td valign="top"><? echo $yr-$byear;?></td>
<td width="17%" valign="top"><b>Date of Birth</b></td>
<td width="2%" valign="top">:</td>
<td width="17%" valign="top"><? echo $bmonth." ".$bday." ".$byear;?></td>
</tr>
<tr><td valign="top"><b>Nationality</b></td><td valign="top">:</td>
<td valign="top"><? echo $nationality;?></td>
<td valign="top"><b>Gender</b></td>
<td valign="top">:</td>
<td valign="top"><? echo $gender;?></td></tr>
<tr><td valign="top"><b>Permanent Residence</b></td>
<td valign="top">:</td>
<td valign="top"><? echo $residence;?></td>
<td valign="top" colspan="3"> </td></tr><tr><td valign="top" colspan="6">  </td></tr>

<!-- education info -->
<?
/*
0 id,1 userid,2 educationallevel,3 fieldstudy,4 major,5 grade,6 gpascore,7 college_name,8 college_country,9 graduate_month,10 graduate_year
*/
$query="SELECT * FROM education WHERE userid=$userid";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row = mysql_fetch_array ($result, MYSQL_NUM); 
	$level = $row[2];
	$field = $row[3];
	$score = $row[6];
	$major = $row[4];
	$school =$row[7];
	$loc  = $row[8];
	$year =$row[10];
	$month =$row[9];
	switch($month)
	{
		case 1:
		$month= "Jan";
		break;
		case 2:
		$month= "Feb";
		break;
		case 3:
		$month= "Mar";
		break;
		case 4:
		$month= "Apr";
		break;
		case 5:
		$month= "May";
		break;
		case 6:
		$month= "Jun";
		break;
		case 7:
		$month= "Jul";
		break;
		case 8:
		$month= "Aug";
		break;
		case 9:
		$month= "Sep";
		break;
		case 10:
		$month= "Oct";
		break;
		case 11:
		$month= "Nov";
		break;
		case 12:
		$month= "Dec";
		break;
		default:
		break;
	}
	
}	

?>

<tr class="TRHeader"><td valign="top" colspan="6" class="ResumeHdr"><b>Highest Qualification</b></td><td valign="top">
<a href="updateeducation.php?userid=<? echo $userid;?>">Edit</a>
 </td></tr>
<tr><td valign="top"><b>Level</b></td><td valign="top">:</td>
<td valign="top"><? echo $level;?></td>
<?
 if ($score >0)
 {
 	//echo "<td valign='top'><b>CGPA</b></td><td valign='top'>:</td><td valign='top'>".$score."/100</td>";
 }

?>
</tr><tr><td valign="top"><b>Field of Study</b></td><td valign="top">:</td><td valign="top"><? echo $field;?></td><td valign="top" colspan="3"></td></tr>
<tr><td valign="top"><b>Major</b></td><td valign="top">:</td>
<td valign="top" colspan="4"><? echo $major;?></td></tr>
<tr><td valign="top"><b>Institute / University</b></td>
<td valign="top">:</td><td valign="top" colspan="4"><? echo $school;?></td></tr>
<tr><td valign="top"><b>Located In</b></td><td valign="top">:</td>
<td valign="top"><? echo $loc;?></td>
<td valign="top"><b>Graduation Date</b></td>
<td valign="top">:</td><td valign="top"><? echo $month;?>&nbsp;<? echo $year;?></td>
</tr>

<!--- work Experience --->
<?

/*
id, userid, freshgrad, years_worked, months_worked, intern_status, iday, imonth, iyear, intern_notice, available_status, available_notice, aday, amonth, ayear, salary_currency, expected_salary, expected_salary_neg, companyname, position, monthfrom, yearfrom, monthto, yearto, duties, companyname2, position2, monthfrom2, yearfrom2, monthto2, yearto2, duties2, companyname3, position3, monthfrom3, yearfrom3, monthto3, yearto3, duties3, companyname4, position4, monthfrom4, yearfrom4, monthto4, yearto4, duties4, companyname5, position5, monthfrom5, yearfrom5, monthto5, yearto5, duties5, latest_job_title
*/
$query="SELECT * FROM currentjob WHERE userid=$userid";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row3 = mysql_fetch_array ($result); 
	// 1
	$company = $row3['companyname'];
	$position= $row3['position'];
	$period = $row3['monthfrom']." ".$row3['yearfrom']." "."to"." ".$row3['monthto']." ".$row3['yearto'];
	$duties =$row3['duties'];
	// 2
	$company2 = $row3['companyname2'];
	$position2= $row3['position2'];
	$period2 = $row3['monthfrom2']." ".$row3['yearfrom2']." "."to"." ".$row3['monthto2']." ".$row3['yearto2'];
	$duties2 =$row3['duties2'];
	// 3
	$company3 = $row3['companyname3'];
	$position3= $row3['position3'];
	$period3 = $row3['monthfrom3']." ".$row3['yearfrom3']." "."to"." ".$row3['monthto3']." ".$row3['yearto3'];
	$duties3 =$row3['duties3'];
	// 4
	$company4 = $row3['companyname4'];
	$position4= $row3['position4'];
	$period4 = $row3['monthfrom4']." ".$row3['yearfrom4']." "."to"." ".$row3['monthto4']." ".$row3['yearto4'];
	$duties4 =$row3['duties4'];
	//5
	$company5 = $row3['companyname5'];
	$position5= $row3['position5'];
	$period5 = $row3['monthfrom5']." ".$row3['yearfrom5']." "."to"." ".$row3['monthto5']." ".$row3['yearto5'];
	$duties5 =$row3['duties5'];
	///////////////////////////
	$currency =$row3['salary_currency'];
	$salary =$row3['expected_salary'];
	$neg = $row3['expected_salary_neg'];
	
	$current = $row3['freshgrad'];
	if ($current=="2")
	{
		$intern =$row3['intern_status']; 
		switch ($intern)
		{
			case 'x':
	$mess=  "I am available for internship jobs.My internship period is from &nbsp;".$row3['iday']." ".$row3['imonth']." ".$row3['iyear']."&nbsp;and the duration is &nbsp;".$row3['intern_notice'];
			break;
			case 'p':
			$mess = "I am not looking for an internship now";
			break;
			default:
			break;
					
		}
	}
	
	$status = $row3['available_status'];
	switch($status)
	{
		case 'a':
		$str = "Can start work after &nbsp;".$row3['available_notice'];
		break;
		case 'b':
		$str = "Can start work after &nbsp;".$row3['amonth']."-".$row3['aday']."-".$row3['ayear'];
		break;
		case 'p':
		$str ="I am not actively looking for a job now";
		break;
		case 'Work Immediately';
		$str ="I can work immediately";
		break;
		default:
		break;
	}
	
}

?>

<tr><td valign="top" colspan="6"> </td></tr><tr class="TRHeader">
<td valign="top" colspan="6" class="ResumeHdr"><b>Latest Employment</b></td><td valign="top">
<a href="#">Edit</a> </td>
</tr>
<tr><td valign="top" colspan="6">
<table width="100%" border="0">

<? if ($company!="") {?>
<tr><td valign="top" width="3%">1. </td>
<td valign="top" width="20%"><b>Company Name</b></td>
<td valign="top" width="1%">:</td>
<td valign="top" width="75%"><? echo $company;?>
</td></tr>
<tr>
<td valign="top"></td>
<td valign="top"><b>Position Title</b></td><td valign="top">:</td>
<td valign="top"><? echo $position;?></td></tr>
<tr><td valign="top"></td>
<td valign="top"><b>Employment Period</b></td>
<td valign="top">:</td>
<td valign="top"><? echo $period;?></td></tr>
<tr><td valign="top"></td>
<td valign="top"><b>Responsibilies /Achievements</b></td>
<td valign="top">:</td><td valign="top"><? echo $duties;?></td></tr>
<? }?>

<? if ($company2!="") {?>
<tr><td valign="top" width="3%">2. </td>
<td valign="top" width="20%"><b>Company Name</b></td>
<td valign="top" width="1%">:</td>
<td valign="top" width="75%"><? echo $company2;?>
</td></tr>
<tr>
<td valign="top"></td>
<td valign="top"><b>Position Title</b></td><td valign="top">:</td>
<td valign="top"><? echo $position2;?></td></tr>
<tr><td valign="top"></td>
<td valign="top"><b>Employment Period</b></td>
<td valign="top">:</td>
<td valign="top"><? echo $period2;?></td></tr>
<tr><td valign="top"></td>
<td valign="top"><b>Responsibilies /Achievements</b></td>
<td valign="top">:</td><td valign="top"><? echo $duties2;?></td></tr>
<? }?>

<? if ($company3!="") {?>
<tr><td valign="top" width="3%">3. </td>
<td valign="top" width="20%"><b>Company Name</b></td>
<td valign="top" width="1%">:</td>
<td valign="top" width="75%"><? echo $company3;?>
</td></tr>
<tr>
<td valign="top"></td>
<td valign="top"><b>Position Title</b></td><td valign="top">:</td>
<td valign="top"><? echo $position3;?></td></tr>
<tr><td valign="top"></td>
<td valign="top"><b>Employment Period</b></td>
<td valign="top">:</td>
<td valign="top"><? echo $period3;?></td></tr>
<tr><td valign="top"></td>
<td valign="top"><b>Responsibilies /Achievements</b></td>
<td valign="top">:</td><td valign="top"><? echo $duties3;?></td></tr>
<? }?>

<? if ($company4!="") {?>
<tr><td valign="top" width="3%">4. </td>
<td valign="top" width="20%"><b>Company Name</b></td>
<td valign="top" width="1%">:</td>
<td valign="top" width="75%"><? echo $company4;?>
</td></tr>
<tr>
<td valign="top"></td>
<td valign="top"><b>Position Title</b></td><td valign="top">:</td>
<td valign="top"><? echo $position4;?></td></tr>
<tr><td valign="top"></td>
<td valign="top"><b>Employment Period</b></td>
<td valign="top">:</td>
<td valign="top"><? echo $period4;?></td></tr>
<tr><td valign="top"></td>
<td valign="top"><b>Responsibilies /Achievements</b></td>
<td valign="top">:</td><td valign="top"><? echo $duties4;?></td></tr>
<? }?>

<? if ($company5!="") {?>
<tr><td valign="top" width="3%">5. </td>
<td valign="top" width="20%"><b>Company Name</b></td>
<td valign="top" width="1%">:</td>
<td valign="top" width="75%"><? echo $company5;?>
</td></tr>
<tr>
<td valign="top"></td>
<td valign="top"><b>Position Title</b></td><td valign="top">:</td>
<td valign="top"><? echo $position5;?></td></tr>
<tr><td valign="top"></td>
<td valign="top"><b>Employment Period</b></td>
<td valign="top">:</td>
<td valign="top"><? echo $period5;?></td></tr>
<tr><td valign="top"></td>
<td valign="top"><b>Responsibilies /Achievements</b></td>
<td valign="top">:</td><td valign="top"><? echo $duties5;?></td></tr>
<? }?>
<tr><td valign="top" colspan="4" align="left">&nbsp;</td></tr>

<? if ($mess!=""){

echo "<tr>
<td valign='top' colspan=3 align=left>".$mess."</td>";

}
?>

<? if ($str!=""){

echo "<tr>
<td valign='top' colspan=3 align=left>".$str."</td>";
}
?>
<tr><td valign="top" colspan="2" align="left"><b><? echo $currency." ".$salary." ".$neg;?></b></td></tr>
</table></td></tr><tr><td valign="top" colspan="6"> </td></tr>
<!-- Skills -->
<?

$counter = 0;
$query="SELECT id, skill, experience, proficiency FROM skills WHERE userid=$userid;";
//echo $query;
$result=mysql_query($query);
//echo @mysql_num_rows($result);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
?>
<tr ><td valign="top" colspan="6" >&nbsp;</td></tr>
<tr class="TRHeader"><td valign="top" colspan="6" class="ResumeHdr"><b>Skills</b></td></tr>
<tr><td valign="top" colspan="6">
<table width="100%" cellpadding="2" cellspacing="0"><tr><td width="22%" valign="top"> </td>
<td valign="top" align="right" colspan="3"><b>Proficiency</b> (1=Beginner - 2=Intermediate - 3=Advanced)</td></tr>
<tr><td valign="top"><b>Skill</b></td><td width="39%" align="center" valign="top"><b>Experience</b></td>
<td width="39%" align="center" valign="top"><b>Proficiency</b></td>
</tr>
<?	
	while(list($id,$skill,$exp,$pro) = mysql_fetch_array($result))
	{
		
		echo "<tr>
			  <td valign='top'>".$skill."</td>
			  <td valign='top' align='center'>".$exp." yr/s</td>
			  <td valign='top' align='center'>".$pro."</td>
			  </tr>";
	}	
}
?>

</table></td></tr>

<!--- languages --->
<?



?>
<tr class="TRHeader"><td valign="top" colspan="6" class="ResumeHdr"><b>Languages</b></td><td valign="top"><a href="#">Edit</a> </td></tr>
<tr><td valign="top" colspan="6">
<table width="100%" cellpadding="2" cellspacing="0"><tr><td valign="top"> </td>
<td valign="top" align="right" colspan="3"><b>Proficiency</b> (0=Poor - 10=Excellent)</td></tr>
<tr><td valign="top"><b>Language</b></td><td valign="top" align="center"><b>Spoken</b></td><td valign="top" align="center"><b>Written</b></td></tr>
<?

$counter = 0;
$query="SELECT id,language,spoken,written FROM language WHERE userid=$userid;";
//echo $query;
$result=mysql_query($query);
//echo @mysql_num_rows($result);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	
	while(list($id,$language,$spoken,$written) = mysql_fetch_array($result))
	{
		
		echo "<tr>
			  <td valign='top'>".$language."</td>
			  <td valign='top' align='center'>".$spoken."</td>
			  <td valign='top' align='center'>".$written."</td>
			  </tr>";
	}	
}
?>






</table></td></tr><tr><td valign="top" colspan="6">  </td></tr>
<tr class="TRHeader"><td valign="top" colspan="6" class="ResumeHdr"><b>Preferences</b></td>
<td valign="top"><a href="#">Edit</a> </td></tr>
<tr><td valign="top" colspan="6">
<table width="100%" border="0"><tr><td valign="top" width="35%"><b>Expected Monthly Salary</b></td><td valign="top">:</td>
<td valign="top"><? echo $currency." ".$salary;?>&nbsp;&nbsp;<? if ($neg=="Yes"){ echo "(Negotiable)";}?></td></tr>

<tr><td valign="top"><b>Availability</b></td>
<?
if ($current=="2")
{
?>
<td valign="top">:</td><td valign="top"><? echo $mess;?></td>
<? } else { ?>
<td valign="top">:</td><td valign="top"><? echo $str;?></td>

<? }?>
</tr></table></td></tr>
<tr class="TRHeader">
<td valign="top" colspan="6" class="ResumeHdr"><b>Working at Home Capabilities</b></td>
<td valign="top"><a href="textResume.php?userid=<? echo $userid;?>">Edit</a></td>
</tr><tr>
<tr><td valign="top" colspan="6">
<!-- DETAILS HERE -->
<? echo $message;?>
<!-- DETAILS HERE -->
</td>
</tr>


<tr><td valign="top" colspan="6">  </td></tr>
<tr class="TRHeader">
<td valign="top" colspan="6" class="ResumeHdr"><b>Text Resume</b></td>
<td valign="top"><a href="textResume.php?userid=<? echo $userid;?>">Edit</a></td>
</tr><tr><td valign="top" colspan="6">
<?
// id, userid, txt
$query="SELECT * FROM txtresume WHERE userid = $userid;";
$result=mysql_query($query);
//echo @mysql_num_rows($result);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row4 = mysql_fetch_array ($result, MYSQL_NUM); 
	$txt = $row4[2];
	$str= str_replace("\n","<br>",$txt);
	echo $str;
}
?>
</td>
</tr></table></td></tr><tr><td align=right>

<a class=link10 href=#>Back to top</a></td></tr></table><br clear=all></td></tr></table></td></tr></table>
				</td></tr>
			</table>
		</td></tr>
	</table>
<? include 'footer.php';?>	
</body>
</html>
