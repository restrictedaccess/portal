<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
if (!isset($_SESSION["userid"])){
	header("Location:/portal/index.php");
}
$userid = $_SESSION['userid'];

$emailaddr = $_SESSION['emailaddr'];

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
	
	$u_id =$row['userid'];
	$name =$row['lname'].", ".$row['fname'];
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
	
	if($image=="")
	{
		$image="images/Client.png";
	}
	
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
<title>Applicant Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="css/resume.css">
<link rel=stylesheet type=text/css href="css/style.css">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

<style type="text/css"> 
    .cName { color: white; font-family:verdana; font-size:14pt; font-weight:bold}
    .cName label{ font-style:italic; font-size:8pt}
    .cName A{ color: white; text-decoration:underline;font-style:italic; font-size:8pt }
    .jobRESH {color:#000000; size:2; font-weight:bold}
</style>
<style>
<!--
div.scroll {
		height: 300px;
		width: 100%;
		overflow: auto;
		border: 1px solid #CCCCCC;
			
	}
	.scroll p{
		margin-bottom: 10px;
		margin-top: 4px;
		margin-left:0px;
	}
	.scroll label
	{
	
		width:90px;
		float: left;
		text-align:right;
		
	}
	.spanner
	{
		width: 400px;
		overflow: auto;
		padding:5px 0 5px 10px;
		margin-left:20px;
		
	}
	
#l {
	float: left;
	width: 350px;
	text-align:left;
	padding:5px 0 5px 10px;
	}	
#l ul{
	   margin-bottom: 10px;
		margin-top: 10px;
		margin-left:20px;
	}	

#r{
	float: right;
	width: 120px;
	text-align: left;
	padding:5px 0 5px 10px;
	
	
	}
	
	
.ads{
	width:580px;
	
		}
.ads h2{
	color:#990000;
	font-size: 2.5em;
	}	
.ads p{	
		margin-bottom: 5px;
		margin-top: 5px;
		margin-left:30px;
	}
.ads h3
{
	color:#003366;
	font-size: 1.5em;
	margin-left:30px;
}	
#comment{
	float: right;
	width: 500px;
	padding:5px 0 5px 10px;
	margin-right:20px;
	margin-top:0px;
}
#comment p
{

margin-bottom: 4px;
margin-top: 4px;
}


#comment label
{
display: block;
width:100px;
float: left;
padding-right: 10px;
font-size:11px;
text-align:right;

}


-->
</style>
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<input type="hidden" name="userid" value="<? echo $userid?>">
<script language=javascript src="js/functions.js"></script>
<!-- HEADER -->
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
<ul class="glossymenu">
 <li ><a href="applicantHome.php"><b>Home</b></a></li>
  <li class="current"><a href="myresume.php"><b>MyResume</b></a></li>
  <li><a href="myapplications.php"><b>Applications</b></a></li>
  <li><a href="jobs.php"><b>Search Jobs</b></a></li>
  <?php $hash_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $emailaddr ), 2, 17 ); ?>
    <li><a href="javascript:popup_win8('rschat.php?portal=1&email=<?php echo $emailaddr ?>&hash=<?php echo $hash_code ?>',800,600);" title="Open remostaff chat"><b>RSChat</b></a></li>
	<li><a href="applicant_test.php"><b>Take a Test</b></a></li>
</ul>


<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome, <? echo $name;?> this is your Online Resume</b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
<td width="170" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '><? include 'applicantleftnav.php';?></td>
<td width="1081" valign="top">
<table width='650' border='1' cellpadding='0' cellspacing='0' bordercolor="a8a8a8" bgcolor='646464'>
<tr><td width="650">
<table width='650' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor="666666">
  <tr><td valign='top' align='center'></td>
</tr></table>
<table width="625" border="0" align="center" cellpadding="3" cellspacing="2" bgcolor="666666">
  <tr>
    <td><div align="left"><font class="cName"><? echo $name;?> </b></font><br></div></td>
  </tr>
</table>
<table width="620" height="244" border="0" align="center" cellpadding="10" cellspacing="2"bgcolor="#FFFFFF">
  <tr>
  <?
  if ($userstatus=="BLACKLISTED")
  {
  	$bgcolor="#999999";
	$blacklist="BLACKLISTED APPLICANT";
  }
  else
  {
  	$bgcolor="#FFFFFF";
  }
  
  ?>
    <td valign="top" bgcolor=<? echo $bgcolor;?> >
<div class="ads">
<H3><? echo $blacklist;?></H3>
	<p align="right"><i><b>Date Applied: </b><? echo format_date($dateapplied);?></i><br>
<? if ($dateupdated!=""){echo "<i><b>Last Update: </b>";echo format_date($dateupdated);echo "</i>"; }?></p>
 
 <!-- image -->
<table width="80%" style="margin-left:10px;">
<tr>
<td width="44%"><?  if ($image!="") echo "<img border=0 src='$image' width=176 height=200>";?></td>
<td width="56%" class="subtitle" valign="top" ><p style="margin-left:50px; margin-top:50px; " ><? echo $name;?><br>
Remotestaff&nbsp;Applicant&nbsp;ID:&nbsp;<? echo $u_id;?><br />
<? echo $latest_job_title;?>
</p>
</td>
</tr>
</table>

<!-- image -->

<!-- Personal Information -->  
<table width="100%" cellpadding="4" cellspacing="0">
<tr bgcolor="#CCCCCC"><td colspan="5"><b>Personal Information</b></td><td align="right"><a href="updatepersonal.php?userid=<? echo $userid;?>">Edit</a></td></tr>
<tr><td width="26%" valign="top"><b>Age</b></td>
<td width="3%" valign="top">:</td>
<td width="35%" valign="top"><? echo $yr-$byear;?></td>
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
<tr bgcolor="#CCCCCC"><td colspan="6"><b>Contact Information</b></td></tr>
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
<td valign="top" colspan="3"> </td></tr>
<td valign="top" colspan="3"> </td></tr><tr><td valign="top" colspan="6">  </td></tr>

<tr bgcolor="#CCCCCC"><td colspan="6"><b>Working at Home Capabilities</b></td></tr>

<tr><td valign="top" colspan="6">
<!-- DETAILS HERE -->
<? echo $message;?>
<!-- DETAILS HERE -->
</td>
</tr>




<!-- Education -->
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
<tr bgcolor="#CCCCCC"><td valign="top" colspan="5" class="ResumeHdr"><b>Highest Qualification</b></td><td align="right"><a href="updateeducation.php?userid=<? echo $userid;?>">Edit</a></td></tr>
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
0 id,1 userid,2 freshgrad,3 years_worked,4 months_worked,5 intern_status,6 iday,7 imonth,8 iyear,9 intern_notice,10 company_name,11 company_industry,12 title,
13 dpt_field,14 positionlevel,15 monthjoined,16 yearjoined,17 monthleft,18 yearleft,19 available_status,20 available_notice,21 aday,22 amonth,23 ayear,
24 salary_currency,25 expected_salary,26 expected_salary_neg
*/
$query="SELECT * FROM currentjob WHERE userid=$userid";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$row3 = mysql_fetch_array ($result, MYSQL_NUM); 
	$company = $row3[10];
	$title= $row3[12];
	$level2 = $row3[14];
	$specialization = $row3[13];
	$industry = $row3[11];
	$month =$row3[15];
	$currency =$row3[24];
	$salary =$row3[25];
	$neg = $row3[26];
	
	$current = $row3[2];
	if ($current=="2")
	{
		$intern =$row3[5]; 
		switch ($intern)
		{
			case 'x':
	$mess=  "I am available for internship jobs.My internship period is from &nbsp;".$row3[6]." ".$row3[7]." ".$row3[8]."&nbsp;and the duration is &nbsp;".$row3[9];
			break;
			case 'p':
			$mess = "I am not looking for an internship now";
			break;
			default:
			break;
					
		}
	}
	
		
	
	
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
	
	$start =$month." ".$row3[16];
	
	$month2 =$row3[17];
	switch($month2)
	{
		case 1:
		$month2= "Jan";
		break;
		case 2:
		$month2= "Feb";
		break;
		case 3:
		$month2= "Mar";
		break;
		case 4:
		$month2= "Apr";
		break;
		case 5:
		$month2= "May";
		break;
		case 6:
		$month2= "Jun";
		break;
		case 7:
		$month2= "Jul";
		break;
		case 8:
		$month2= "Aug";
		break;
		case 9:
		$month2= "Sep";
		break;
		case 10:
		$month2= "Oct";
		break;
		case 11:
		$month2= "Nov";
		break;
		case 12:
		$month2= "Dec";
		break;
		default:
		break;
	}
	$end =$month2." ".$row3[18];
	
	$status = $row3[19];
	switch($status)
	{
		case 'a':
		$str = "Can start work after &nbsp;".$row3[20];
		break;
		case 'b':
		$str = "Can start work after &nbsp;".$row3[22]."-".$row3[21]."-".$row3[23];
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
<!--- work Experience --->
<?
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

<tr bgcolor="#CCCCCC">
<td valign="top" colspan="5" class="ResumeHdr"><b>Employment History</b></td><td align="right"><a href="updatecurrentJob.php?userid=<? echo $userid;?>">Edit</a></td>
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
</table>
</td>
</tr>

<?

if($company=="")
{
	
	if($mess!="")
	{
		echo "<tr bgcolor='#CCCCCC'><td valign='top' colspan='6'><b>Intership Status</b></td></tr>";
		echo "<tr><td colspan=6>&nbsp;</td></tr>";
		echo "<tr><td colspan=6>$mess</td></tr>";
		echo "<tr><td colspan=6>&nbsp;</td></tr>";
	}
	if($str!="")
	{
		echo "<tr bgcolor='#CCCCCC'><td valign='top' colspan='6'><b>Availability Status</b></td></tr>";
		echo "<tr><td colspan=6>&nbsp;</td></tr>";
		echo "<tr><td colspan=6>$str</td></tr>";
		echo "<tr><td colspan=6>&nbsp;</td></tr>";
	}
}

?>
<!--- languages --->
<tr bgcolor="#CCCCCC"><td valign="top" colspan="5" ><b>Languages</b></td><td align="right"><a href="updatelanguages.php">Edit</a></td></tr>
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

	
	while(list($id,$language,$spoken,$written) = mysql_fetch_array($result))
	{
		
		echo "<tr>
			  <td valign='top'>".$language."</td>
			  <td valign='top' align='center'>".$spoken."</td>
			  <td valign='top' align='center'>".$written."</td>
			  </tr>";
	}	

?>

</table></td></tr>
<!-- Skills -->
<?

$counter = 0;
$query="SELECT id, skill, experience, proficiency FROM skills WHERE userid=$userid;";
//echo $query;
$result=mysql_query($query);
//echo @mysql_num_rows($result);
$ctr=@mysql_num_rows($result);

?>
<tr ><td valign="top" colspan="6" >&nbsp;</td></tr>
<tr bgcolor="#CCCCCC"><td valign="top" colspan="5" ><b>Skills</b></td><td align="right"><a href="updateskillsStrengths.php?userid=<? echo $userid;?>">Edit</a></td></tr>
<tr><td valign="top" colspan="6">
<table width="100%" cellpadding="2" cellspacing="0"><tr><td width="22%" valign="top"> </td>
<td valign="top" align="right" colspan="3"><b>Proficiency</b> (1=Beginner - 2=Intermediate - 3=Advanced)</td></tr>
<tr><td valign="top"><b>Skill</b></td><td width="39%" align="center" valign="top"><b>Experience</b></td>
<td width="39%" align="center" valign="top"><b>Proficiency</b></td>
</tr>
<?	
	while(list($id,$skill,$exp,$pro) = mysql_fetch_array($result))
	{
		if ($exp==0.5){
			$exp = "Less than 6 months";	
		}else if ($exp==0.75){
			$exp = "Over 6 months";
		}else if ($exp>10){
			$exp = "More than 10 years";
		}
		
		
		echo "<tr>
			  <td valign='top'>".$skill."</td>
			  <td valign='top' align='center'>".$exp."</td>
			  <td valign='top' align='center'>".$pro."</td>
			  </tr>";
	}	

?>

</table></td></tr></table>
</div>	  
	  
     </td>
 
  </tr>
</table><p>&nbsp;</p></td>
</tr></table>

</td>
</tr>
</table>
<? include 'footer.php';?>
<!-- Google Code for Application Conversion Page -->
<script type="text/javascript">
<!--
var google_conversion_id = 1043597459;
var google_conversion_language = "en_US";
var google_conversion_format = "1";
var google_conversion_color = "ffffff";
var google_conversion_label = "FT1ECKnzvgEQk5HQ8QM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1043597459/?label=FT1ECKnzvgEQk5HQ8QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

</body>
</html>
