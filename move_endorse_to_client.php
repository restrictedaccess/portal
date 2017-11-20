<?php
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';
include 'time.php';

include('conf/zend_smarty_conf.php');

if($_SESSION['admin_id']=="" && $_SESSION['agent_no'] == "")
{
	echo '
	<script language="javascript">
		alert("Session expired.");
	</script>
	';
	header("location:http:index.php");
}



$userid = @$_GET["userid"];

$s = "SELECT DISTINCT lname, fname FROM personal WHERE userid='$userid' LIMIT 1;";
$r=mysql_query($s);
while(list($lname, $fname) = mysql_fetch_array($r))
{
	 $FullName=$fname." ".$lname;
	 $FullName=filterfield($FullName);
}


$sql3 = "SELECT DISTINCT l.id, l.lname, l.fname FROM leads l WHERE status='Client' ORDER BY l.fname ASC;";
$result3=mysql_query($sql3);
while(list($lead_id, $client_lname, $client_fname) = mysql_fetch_array($result3))
{
	 $client_fullname =$client_fname." ".$client_lname;
	 if ($kliyente==$lead_id)
	 {
	 	$usernameOptions2 .="<option selected value=".$lead_id.">".$client_fullname."</option>";
	 }
	 else
	 {
	 	$usernameOptions2 .="<option  value=".$lead_id.">".$client_fullname."</option>";
	 }	
}







if(@isset($_POST["send"]))
{
		$AusTime = date("H:i:s"); 
		$AusDate = date("Y")."-".date("m")."-".date("d");
		$ATZ = $AusDate." ".$AusTime;
		$date=date('l jS \of F Y h:i:s A');
		
		$admin_id = $_SESSION['admin_id'];
		$admin_status=$_SESSION['status'];
		
		$sql="SELECT * FROM admin WHERE admin_id = $admin_id;";
		
		$resulta=mysql_query($sql);
		$ctr=@mysql_num_rows($resulta);
		if ($ctr >0 )
		{
			$row = mysql_fetch_array ($resulta); 
			$admin_email = $row['admin_email'];
		}
		
		// used to create automatic creation of ads
		$kliyente=$_REQUEST['kliyente'];
		
		// check the client Business Partner
		$sqlAgentcheck="SELECT * FROM leads WHERE id=$kliyente";
		$resultAgentCheck=mysql_query($sqlAgentcheck);
		$rowAgentCheck = mysql_fetch_array ($resultAgentCheck); 
		
		$agent_no = $rowAgentCheck['agent_id'];
		$client_email = $rowAgentCheck['email'];
		if($agent_no=="")
		{
			$query="SELECT * FROM agent WHERE email ='$admin_email';";
			$result=mysql_query($query);
			$ctr2=@mysql_num_rows($result);
			if ($ctr2 >0 )
			{
				$row = mysql_fetch_array ($result); 
				$agent_no = $row['agent_no'];
			}
		}	
		
		if(isset($_REQUEST['ads']))
		{
			$ads=$_REQUEST['ads'];
		}
		else
		{
			$ads=$_REQUEST['ads_temp'];
			$pos = "for the ".$ads." position to one of our clients.";
		}

		$sql="SELECT jobposition FROM posting WHERE id = '$ads';";
		$r=mysql_query($sql);
		$ctr=@mysql_num_rows($r);
		if ($ctr >0 )
		{
			$rw = mysql_fetch_array ($r); 
			$ads = $rw['jobposition'];
			$pos = "for the ".$rw['jobposition']." position to one of our clients.";			
		}
		if ($ads=="")
		{
			$ads="";
			$pos = "to one of our clients.";
		}
		



		$status = "Active";
		$date_endoesed = date("Y-m-d");
		$final_Interview = "";
		$comment = "";
		$status = "On Hold";
		$part_time_rate = $_POST['p_time'];
		$full_time_rate = $_POST['f_time'];
		mysql_query("INSERT INTO tb_endorsement_history (userid, client_name, position, final_Interview, comment, part_time_rate, full_time_rate, status, date_endoesed) VALUES('$userid', '$kliyente', '$ads', '$final_Interview', '$comment', '$part_time_rate', '$full_time_rate', '$status', '$date_endoesed')");
		//mysql_query("UPDATE applicants SET status='Endorsed' WHERE userid='$userid' LIMIT 1");

		// SEND AN EMAIL TO SUB-CONTRACTOR
		$sqlEmail="SELECT * FROM personal p WHERE p.userid=$userid";
		$result=mysql_query($sqlEmail);
		$row = mysql_fetch_array ($result); 
		//$email =$row['email'];
		$fullname =$row['fname']." ".$row['lname'];
		$subcontructor_email =$row['email'];
		



		//START: add status lookup or history
		$status_to_use = "ENDORSED";
		$data2 = array(
		'personal_id' => $userid,
		'admin_id' => $admin_id,
		'status' => $status_to_use,
		'date' => date("Y-m-d")." ".date("H:i:s")
		);
		$db->insert('applicant_status', $data2);
		//ENDED: add status lookup or history
		
		
		//START: insert staff history
		include('lib/staff_history.php');
		staff_history($db, $userid, $_SESSION['admin_id'], 'ADMIN', 'STAFF STATUS', 'INSERT', 'ENDORSED');
		//ENDED: insert staff history		
		
		
		//START: staff status
		include_once('lib/staff_status.php') ;
		staff_status($db, $_SESSION['admin_id'], $userid, 'ENDORSED');
		//ENDED: staff status
		
//<!----- BODY ---------------------------------------------------------------------------------------------------------->
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
	$image=basename($row['image']);

/*
userid, lname, fname, byear, bmonth, bday, auth_no_type_id, msia_new_ic_no, gender, nationality, permanent_residence, email, pass, alt_email, handphone_country_code, handphone_no, tel_area_code, tel_no, address1, address2, postcode, country_id, state, city, msn_id, yahoo_id, icq_id, skype_id, image, datecreated, dateupdated, status, home_working_environment, internet_connection, isp, computer_hardware, headset_quality	
*/

	$u_id =$row['userid'];
	$name =$row['fname'];
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
	
	$yahoo_id =$row['yahoo_id']; 
	$skype_id=$row['skype_id'];
	
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
$txt = $_POST["body_message"];
$txt=str_replace("\n","<br>",$txt);

$body="

<style type=\"text/css\"> 
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

<div align='center'>
	<table width='650' cellpadding='0' cellspacing='0' bgcolor='#ffffff'>
		<tr>
			<td>
				<br />".$txt."	<br /><br /><br />
			</td>
		</tr>
	</table>
  <table width='650' border='1' cellpadding='0' cellspacing='0' bordercolor=\"a8a8a8\" bgcolor='646464'>
<tr><td width=\"650\" bgcolor='#ffffff'>
</td></tr>  
<tr><td width=\"650\">
<table width='650' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor=\"666666\">
  <tr><td valign='top' align='center'><br>
  <table width=\"620\" height=\"100\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#F4F4F4\" bgcolor=\"#FFFFFF\">
 
  <tr>
    <td><table width=\"625\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
      
        <tr><td ><img src=\"http://www.remotestaff.com.au/portal/images/banner/remoteStaff-logo.jpg\" alt=\"think\" width=\"416\" height=\"108\"></td>
      </tr>
    </table></td>
  </tr>
 
</table>
        </td>
</tr></table>
<table width=\"625\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"2\" bgcolor=\"666666\">
  <tr>
    <td><div align=\"left\"><font class=\"cName\"> $name </b></font><br></div></td>
  </tr>
</table>
<table width=\"620\" height=\"244\" border=\"0\" align=\"center\" cellpadding=\"10\" cellspacing=\"2\"bgcolor=\"#FFFFFF\">
  <tr>
  ";
  

  if ($userstatus=="BLACKLISTED")
  {
  	$bgcolor="#999999";
	$blacklist="BLACKLISTED APPLICANT";
  }
  else
  {
  	$bgcolor="#FFFFFF";
  }
  
  
$body = $body."
    <td valign=\"top\" bgcolor= $bgcolor >
<div class=\"ads\">
<H3> $blacklist </H3>
	<p align=\"right\"><!--<i><b>Date Applied: </b> ".format_date($dateapplied)."</i>--><br>";
	
	
if ($dateupdated!="")
{
	$body = $body."<!--<i><b>Last Update: </b>".format_date($dateupdated)."</i>-->"; 
}
	
	$body = $body."</p>
		<!-- image -->
		<table width=\"100%\">
			<tr>
			<td width=\"30%\">
			";

if ($image!='') 
{
	$body = $body."<img border=0 src='http://www.remotestaff.com.au/portal/uploads/pics/".$image."' width=110 height=150>";
}	

$body = $body."
	</td>
<td width=\"70%\" class=\"subtitle\" valign=\"top\">Remotestaff Applicant ID: ".$userid."
</td>
</tr>
</table>

<!-- image -->

<!-- Personal Information -->  
<table width=\"100%\">
<tr bgcolor=\"#CCCCCC\"><td colspan=\"6\"><b>Personal Information</b></td></tr>
<tr><td width=\"26%\" valign=\"top\"><b>Age</b></td>
<td width=\"3%\" valign=\"top\">:</td>
<td width=\"35%\" valign=\"top\"> $yr-$byear </td>
<td width=\"17%\" valign=\"top\"><b>Date of Birth</b></td>
<td width=\"2%\" valign=\"top\">:</td>
<td width=\"17%\" valign=\"top\"> $bmonth "." ".$bday." ".$byear."</td>
</tr>
<tr><td valign=\"top\"><b>Nationality</b></td><td valign=\"top\">:</td>
<td valign=\"top\"> $nationality </td>
<td valign=\"top\"><b>Gender</b></td>
<td valign=\"top\">:</td>
<td valign=\"top\"> $gender </td></tr>
<tr><td valign=\"top\"><b>Permanent Residence</b></td>
<td valign=\"top\">:</td>
<td valign=\"top\"> $residence </td>
<td valign=\"top\" colspan=\"3\"></td></tr><tr><td valign=\"top\" colspan=\"6\"> </td></tr>
<tr bgcolor=\"#CCCCCC\"><td colspan=\"6\"><b>Working at Home Capabilities</b></td></tr>

<tr><td valign=\"top\" colspan=\"6\">
<!-- DETAILS HERE -->
$message 
<!-- DETAILS HERE -->
</td>
</tr>
";


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

$body = $body."
<tr bgcolor=\"#CCCCCC\"><td valign=\"top\" colspan=\"6\" class=\"ResumeHdr\"><b>Highest Qualification</b></td>
<tr><td valign=\"top\"><b>Level</b></td><td valign=\"top\">:</td>
<td valign=\"top\"> $level </td>
";

 if ($score >0)
 {
 	$body = $body."<td valign='top'><b>CGPA</b></td><td valign='top'>:</td><td valign='top'>".$score."/100</td>";
 }

$body = $body."
</tr><tr><td valign=\"top\"><b>Field of Study</b></td><td valign=\"top\">:</td><td valign=\"top\"> $field </td><td valign=\"top\" colspan=\"3\"></td></tr>
<tr><td valign=\"top\"><b>Major</b></td><td valign=\"top\">:</td>
<td valign=\"top\" colspan=\"4\"> $major </td></tr>
<tr><td valign=\"top\"><b>Institute / University</b></td>
<td valign=\"top\">:</td><td valign=\"top\" colspan=\"4\"> $school </td></tr>
<tr><td valign=\"top\"><b>Located In</b></td><td valign=\"top\">:</td>
<td valign=\"top\"> $loc </td>
<td valign=\"top\"><b>Graduation Date</b></td>
<td valign=\"top\">:</td><td valign=\"top\"> $month &nbsp; $year </td>
</tr>

<!--- work Experience --->
";

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
		$str = "Can start work after &nbsp;".$row3[20]."&nbsp;month(s) of notice period";
		if($row3[20] == 0)
		{
			$str ="I can work immediately";
		}
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


$body = $body."
<tr><td valign=\"top\" colspan=\"6\"></td></tr><tr class=\"TRHeader\">
<!--- work Experience --->
";

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
	//6
	$company6 = $row3['companyname6'];
	$position6= $row3['position6'];
	$period6 = $row3['monthfrom6']." ".$row3['yearfrom6']." "."to"." ".$row3['monthto6']." ".$row3['yearto6'];
	$duties6 =$row3['duties6'];
	//7
	$company7 = $row3['companyname7'];
	$position7= $row3['position7'];
	$period7 = $row3['monthfrom7']." ".$row3['yearfrom7']." "."to"." ".$row3['monthto7']." ".$row3['yearto7'];
	$duties7 =$row3['duties7'];	
	//8
	$company8 = $row3['companyname8'];
	$position8= $row3['position8'];
	$period8 = $row3['monthfrom8']." ".$row3['yearfrom8']." "."to"." ".$row3['monthto8']." ".$row3['yearto8'];
	$duties8 =$row3['duties8'];	
	//9
	$company9 = $row3['companyname9'];
	$position9= $row3['position9'];
	$period9 = $row3['monthfrom9']." ".$row3['yearfrom9']." "."to"." ".$row3['monthto9']." ".$row3['yearto9'];
	$duties9 =$row3['duties9'];	
	//10
	$company10 = $row3['companyname10'];
	$position10= $row3['position10'];
	$period10 = $row3['monthfrom10']." ".$row3['yearfrom10']." "."to"." ".$row3['monthto10']." ".$row3['yearto10'];
	$duties10 =$row3['duties10'];		
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

$body = $body."
<tr bgcolor=\"#CCCCCC\">
<td valign=\"top\" colspan=\"6\" class=\"ResumeHdr\"><b>Employment History</b></td>
</tr>
<tr><td valign=\"top\" colspan=\"6\">
<table width=\"100%\" border=\"0\">
";

if ($company!="") 
{
	$body=$body."
		<tr><td valign=\"top\" width=\"3%\">1. </td>
		<td valign=\"top\" width=\"20%\"><b>Company Name</b></td>
		<td valign=\"top\" width=\"1%\">:</td>
		<td valign=\"top\" width=\"75%\"> $company 
		</td></tr>
		<tr>
		<td valign=\"top\"></td>
		<td valign=\"top\"><b>Position Title</b></td><td valign=\"top\">:</td>
		<td valign=\"top\"> $position </td></tr>
		<tr><td valign=\"top\"></td>
		<td valign=\"top\"><b>Employment Period</b></td>
		<td valign=\"top\">:</td>
		<td valign=\"top\"> $period </td></tr>
		<tr><td valign=\"top\"></td>
		<td valign=\"top\"><b>Responsibilies /Achievements</b></td>
		<td valign=\"top\">:</td><td valign=\"top\"> $duties </td></tr>";
}

if ($company2!="") 
{
	$body = $body."
	<tr><td valign=\"top\" width=\"3%\">2. </td>
	<td valign=\"top\" width=\"20%\"><b>Company Name</b></td>
	<td valign=\"top\" width=\"1%\">:</td>
	<td valign=\"top\" width=\"75%\"> $company2 
	</td></tr>
	<tr>
	<td valign=\"top\"></td>
	<td valign=\"top\"><b>Position Title</b></td><td valign=\"top\">:</td>
	<td valign=\"top\"> $position2 </td></tr>
	<tr><td valign=\"top\"></td>
	<td valign=\"top\"><b>Employment Period</b></td>
	<td valign=\"top\">:</td>
	<td valign=\"top\"> $period2 </td></tr>
	<tr><td valign=\"top\"></td>
	<td valign=\"top\"><b>Responsibilies /Achievements</b></td>
	<td valign=\"top\">:</td><td valign=\"top\"> $duties2 </td></tr>
	";
}

if ($company3!="") 
{
	$body=$body."
	<tr><td valign=\"top\" width=\"3%\">3. </td>
	<td valign=\"top\" width=\"20%\"><b>Company Name</b></td>
	<td valign=\"top\" width=\"1%\">:</td>
	<td valign=\"top\" width=\"75%\"> $company3 
	</td></tr>
	<tr>
	<td valign=\"top\"></td>
	<td valign=\"top\"><b>Position Title</b></td><td valign=\"top\">:</td>
	<td valign=\"top\"> $position3 </td></tr>
	<tr><td valign=\"top\"></td>
	<td valign=\"top\"><b>Employment Period</b></td>
	<td valign=\"top\">:</td>
	<td valign=\"top\"> $period3 </td></tr>
	<tr><td valign=\"top\"></td>
	<td valign=\"top\"><b>Responsibilies /Achievements</b></td>
	<td valign=\"top\">:</td><td valign=\"top\"> $duties3 </td></tr>";
}

if ($company4!="") 
{

	$body = $body."
	<tr><td valign=\"top\" width=\"3%\">4. </td>
	<td valign=\"top\" width=\"20%\"><b>Company Name</b></td>
	<td valign=\"top\" width=\"1%\">:</td>
	<td valign=\"top\" width=\"75%\"> $company4 
	</td></tr>
	<tr>
	<td valign=\"top\"></td>
	<td valign=\"top\"><b>Position Title</b></td><td valign=\"top\">:</td>
	<td valign=\"top\"> $position4 </td></tr>
	<tr><td valign=\"top\"></td>
	<td valign=\"top\"><b>Employment Period</b></td>
	<td valign=\"top\">:</td>
	<td valign=\"top\"> $period4 </td></tr>
	<tr><td valign=\"top\"></td>
	<td valign=\"top\"><b>Responsibilies /Achievements</b></td>
	<td valign=\"top\">:</td><td valign=\"top\"> $duties4 </td></tr>";

}

if ($company5!="") 
{
	$body = $body."
		<tr><td valign=\"top\" width=\"3%\">5. </td>
		<td valign=\"top\" width=\"20%\"><b>Company Name</b></td>
		<td valign=\"top\" width=\"1%\">:</td>
		<td valign=\"top\" width=\"75%\"> $company5 
		</td></tr>
		<tr>
		<td valign=\"top\"></td>
		<td valign=\"top\"><b>Position Title</b></td><td valign=\"top\">:</td>
		<td valign=\"top\"> $position5 </td></tr>
		<tr><td valign=\"top\"></td>
		<td valign=\"top\"><b>Employment Period</b></td>
		<td valign=\"top\">:</td>
		<td valign=\"top\"> $period5 </td></tr>
		<tr><td valign=\"top\"></td>
		<td valign=\"top\"><b>Responsibilies /Achievements</b></td>
		<td valign=\"top\">:</td><td valign=\"top\"> $duties5 </td></tr>";

}


if ($company6!="") 
{
	$body = $body."
		<tr><td valign=\"top\" width=\"3%\">6. </td>
		<td valign=\"top\" width=\"20%\"><b>Company Name</b></td>
		<td valign=\"top\" width=\"1%\">:</td>
		<td valign=\"top\" width=\"75%\"> $company6 
		</td></tr>
		<tr>
		<td valign=\"top\"></td>
		<td valign=\"top\"><b>Position Title</b></td><td valign=\"top\">:</td>
		<td valign=\"top\"> $position6 </td></tr>
		<tr><td valign=\"top\"></td>
		<td valign=\"top\"><b>Employment Period</b></td>
		<td valign=\"top\">:</td>
		<td valign=\"top\"> $period6 </td></tr>
		<tr><td valign=\"top\"></td>
		<td valign=\"top\"><b>Responsibilies /Achievements</b></td>
		<td valign=\"top\">:</td><td valign=\"top\"> $duties6 </td></tr>";

}

if ($company7!="") 
{
	$body = $body."
		<tr><td valign=\"top\" width=\"3%\">7. </td>
		<td valign=\"top\" width=\"20%\"><b>Company Name</b></td>
		<td valign=\"top\" width=\"1%\">:</td>
		<td valign=\"top\" width=\"75%\"> $company7 
		</td></tr>
		<tr>
		<td valign=\"top\"></td>
		<td valign=\"top\"><b>Position Title</b></td><td valign=\"top\">:</td>
		<td valign=\"top\"> $position7 </td></tr>
		<tr><td valign=\"top\"></td>
		<td valign=\"top\"><b>Employment Period</b></td>
		<td valign=\"top\">:</td>
		<td valign=\"top\"> $period7 </td></tr>
		<tr><td valign=\"top\"></td>
		<td valign=\"top\"><b>Responsibilies /Achievements</b></td>
		<td valign=\"top\">:</td><td valign=\"top\"> $duties7 </td></tr>";

}


if ($company8!="") 
{
	$body = $body."
		<tr><td valign=\"top\" width=\"3%\">8. </td>
		<td valign=\"top\" width=\"20%\"><b>Company Name</b></td>
		<td valign=\"top\" width=\"1%\">:</td>
		<td valign=\"top\" width=\"75%\"> $company8 
		</td></tr>
		<tr>
		<td valign=\"top\"></td>
		<td valign=\"top\"><b>Position Title</b></td><td valign=\"top\">:</td>
		<td valign=\"top\"> $position8 </td></tr>
		<tr><td valign=\"top\"></td>
		<td valign=\"top\"><b>Employment Period</b></td>
		<td valign=\"top\">:</td>
		<td valign=\"top\"> $period8 </td></tr>
		<tr><td valign=\"top\"></td>
		<td valign=\"top\"><b>Responsibilies /Achievements</b></td>
		<td valign=\"top\">:</td><td valign=\"top\"> $duties8 </td></tr>";

}


if ($company9!="") 
{
	$body = $body."
		<tr><td valign=\"top\" width=\"3%\">9. </td>
		<td valign=\"top\" width=\"20%\"><b>Company Name</b></td>
		<td valign=\"top\" width=\"1%\">:</td>
		<td valign=\"top\" width=\"75%\"> $company9 
		</td></tr>
		<tr>
		<td valign=\"top\"></td>
		<td valign=\"top\"><b>Position Title</b></td><td valign=\"top\">:</td>
		<td valign=\"top\"> $position9 </td></tr>
		<tr><td valign=\"top\"></td>
		<td valign=\"top\"><b>Employment Period</b></td>
		<td valign=\"top\">:</td>
		<td valign=\"top\"> $period9 </td></tr>
		<tr><td valign=\"top\"></td>
		<td valign=\"top\"><b>Responsibilies /Achievements</b></td>
		<td valign=\"top\">:</td><td valign=\"top\"> $duties9 </td></tr>";
}


if ($company10!="") 
{
	$body = $body."
		<tr><td valign=\"top\" width=\"3%\">10. </td>
		<td valign=\"top\" width=\"20%\"><b>Company Name</b></td>
		<td valign=\"top\" width=\"1%\">:</td>
		<td valign=\"top\" width=\"75%\"> $company10 
		</td></tr>
		<tr>
		<td valign=\"top\"></td>
		<td valign=\"top\"><b>Position Title</b></td><td valign=\"top\">:</td>
		<td valign=\"top\"> $position10 </td></tr>
		<tr><td valign=\"top\"></td>
		<td valign=\"top\"><b>Employment Period</b></td>
		<td valign=\"top\">:</td>
		<td valign=\"top\"> $period10 </td></tr>
		<tr><td valign=\"top\"></td>
		<td valign=\"top\"><b>Responsibilies /Achievements</b></td>
		<td valign=\"top\">:</td><td valign=\"top\"> $duties10 </td></tr>";
}





$body = $body."<tr><td valign=\"top\" colspan=\"4\" align=\"left\">&nbsp;</td></tr>";

if ($mess!="")
{
	$body=$body."<tr><td valign='top' colspan=3 align=left>".$mess."</td>";
}


if ($str!="")
{
	$body=$body."<tr><td valign='top' colspan=3 align=left>".$str."</td>";
}

//$body=$body."<tr><td valign=\"top\" colspan=\"2\" align=\"left\"><b> $currency $salary $neg </b></td></tr>
$body=$body."
</table>
</td>
</tr>
";

if($company=="")
{
	
	if($mess!="")
	{
		$body=$body. "<tr bgcolor='#CCCCCC'><td valign='top' colspan='6'><b>Intership Status</b></td></tr>";
		$body=$body. "<tr><td colspan=6>&nbsp;</td></tr>";
		$body=$body. "<tr><td colspan=6>$mess</td></tr>";
		$body=$body. "<tr><td colspan=6>&nbsp;</td></tr>";
	}
	if($str!="")
	{
		$body=$body. "<tr bgcolor='#CCCCCC'><td valign='top' colspan='6'><b>Availability Status</b></td></tr>";
		$body=$body. "<tr><td colspan=6>&nbsp;</td></tr>";
		$body=$body. "<tr><td colspan=6>$str</td></tr>";
		$body=$body. "<tr><td colspan=6>&nbsp;</td></tr>";
	}
}



$body=$body."
<tr bgcolor=\"#CCCCCC\"><td valign=\"top\" colspan=\"6\" ><b>Languages</b></td></tr>
<tr><td valign=\"top\" colspan=\"6\">
<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\"><tr><td valign=\"top\"></td>
<td valign=\"top\" align=\"right\" colspan=\"3\"><b>Proficiency</b> (0=Poor - 10=Excellent)</td></tr>
<tr><td valign=\"top\"><b>Language</b></td><td valign=\"top\" align=\"center\"><b>Spoken</b></td><td valign=\"top\" align=\"center\"><b>Written</b></td></tr>
";

$counter = 0;
$query="SELECT id,language,spoken,written FROM language WHERE userid=$userid;";
//echo $query;
$result=mysql_query($query);
//echo @mysql_num_rows($result);
$ctr=@mysql_num_rows($result);

	
	while(list($id,$language,$spoken,$written) = mysql_fetch_array($result))
	{
		
		$body=$body."<tr>
			  <td valign='top'>".$language."</td>
			  <td valign='top' align='center'>".$spoken."</td>
			  <td valign='top' align='center'>".$written."</td>
			  </tr>";
	}	


$body=$body."</table></td></tr>";

$counter = 0;
$query="SELECT id, skill, experience, proficiency FROM skills WHERE userid=$userid;";
//echo $query;
$result=mysql_query($query);
//echo @mysql_num_rows($result);
$ctr=@mysql_num_rows($result);

$body=$body."
<tr ><td valign=\"top\" colspan=\"6\" >&nbsp;</td></tr>
<tr bgcolor=\"#CCCCCC\"><td valign=\"top\" colspan=\"6\" ><b>Skills</b></td></tr>
<tr><td valign=\"top\" colspan=\"6\">
<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\"><tr><td width=\"22%\" valign=\"top\"></td>
<td valign=\"top\" align=\"right\" colspan=\"3\"><b>Proficiency</b> (1=Beginner - 2=Intermediate - 3=Advanced)</td></tr>
<tr><td valign=\"top\"><b>Skill</b></td><td width=\"39%\" align=\"center\" valign=\"top\"><b>Experience</b></td>
<td width=\"39%\" align=\"center\" valign=\"top\"><b>Proficiency</b></td>
</tr>
";

	while(list($id,$skill,$exp,$pro) = mysql_fetch_array($result))
	{
		
		$body=$body. "<tr>
			  <td valign='top'>".$skill."</td>
			  <td valign='top' align='center'>".$exp." yr/s</td>
			  <td valign='top' align='center'>".$pro."</td>
			  </tr>";
	}	

$body=$body."
</table></td></tr>";







//voice
$body = $body."
<tr bgcolor=\"#CCCCCC\"><td valign=\"top\" colspan=\"6\" ><b>Voice</b></td>
</tr>
<tr><td valign=\"top\" colspan=\"6\">
<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\">
<tr>
			  																<td valign='top'>
																			<div style=\"margin-bottom:5px; solid 1px; font:11px Arial; margin-left:10px;\">";
																			$queryApplicants = "SELECT voice_path FROM personal WHERE userid='$userid'";
																			$data2 = mysql_query($queryApplicants);
																			while(list($voice_path)=mysql_fetch_array($data2))
																			{
																						if ($voice_path!="") 
																						{ 
																							$body = $body."<object type=\"application/x-shockwave-flash\" data=\"audio_player/player.swf\" id=\"audioplayer1\" height=\"24\" width=\"176\">
																							<param name=\"movie\" value=\"audio_player/player.swf\">
																							<param name=\"FlashVars\" value=\"playerID=1&amp;soundFile=./".$voice_path."\">
																							<param name=\"quality\" value=\"high\">
																							<param name=\"menu\" value=\"false\">
																							<param name=\"wmode\" value=\"transparent\">
																							</object><br>
																							<a href=\"http://www.remotestaff.com.au/portal/".$voice_path."\">Download</a>";
																						}
																			}
																						 
$body = $body."																						
																			</div>
																			</td>
</tr>
</table></td></tr>
";
//end voice





//samples
$body = $body."
<tr bgcolor=\"#CCCCCC\"><td valign=\"top\" colspan=\"6\" ><b>Samples</b></td></tr>
<tr><td valign=\"top\" colspan=\"6\">
<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\">
<tr>
	<td valign='top'>
	<div style=\"margin-bottom:5px; solid 1px; font:11px Arial; margin-left:10px;\">
																<table>";
																			$f_counter = @$_POST["f_counter"];
																			$num = 1;
																			$temp = "";
																			for($i = 1; $i <= $f_counter; $i++)
																			{
																				if(@isset($_POST["file".$i]))
																				{
																					$temp = $temp."<tr><td valign=top><font face='arial' size=2>".$num.")</font></td>";
																					$temp = $temp."<td valign=top>"."<font color='#000000' face='arial' size=2>".$row["file_description"]."</font><font color='#CCCCCC' face='arial' size=1><b>(Download</b><i>&nbsp;&nbsp;<a href='http://www.remotestaff.com.au/portal/applicants_files/".$_POST["file".$i]."' target='_blank'>".$_POST["file".$i]."</a></i><strong>)</strong></font></td></tr>";
																					$num++;
																				}	
																			}
																			$body=$body.$temp;
$body = $body."
																</table>
	</div>
	</td>
</tr>
</table></td></tr>
";
//end samples




//comment
$body = $body."
<tr bgcolor=\"#CCCCCC\"><td valign=\"top\" colspan=\"6\" ><b>Comments</b></td>
</tr>
<tr><td valign=\"top\" colspan=\"6\">
<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\">
<tr>
			  																<td valign='top'>
																			<div style=\"margin-bottom:5px; solid 1px; font:11px Arial; margin-left:10px;\">
																			<table>
																			";
																			$c_counter = @$_POST["c_counter"];
																			$num = 1;
																			$temp = "";
																			for($i = 1; $i <= $c_counter; $i++)
																			{
																				if(@isset($_POST["comment".$i]))
																				{
																					$temp = $temp."<tr><td valign=top>".$num.")</td>";
																					$temp = $temp."<td>".$_POST["comment".$i]."</td></tr>";
																					$num++;
																				}	
																			}
																			$body=$body.$temp;
$body = $body."																					
																			</table>							
																			</div>
																			</td>
</tr>
</table></td></tr>
";
//end comment



//rate
$body = $body."
<tr bgcolor=\"#CCCCCC\"><td valign=\"top\" colspan=\"6\" ><b>Rate</b></td>
</tr>
<tr><td valign=\"top\" colspan=\"6\">
<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\">
<tr>
			  																<td valign='top'>
																			";
																			$body=$body."Monthly full time rate (9 hour shift with 1 hour lunch break): ".$_POST["f_time"]."<br />Monthly part time rate (4 hour shift): ".$_POST["p_time"];
$body = $body."																					
																			</td>
</tr>
</table></td></tr>
";
//end rate








//signature
$body = $body."
<tr bgcolor=\"#CCCCCC\"><td valign=\"top\" colspan=\"6\" ></td>
</tr>
<tr><td valign=\"top\" colspan=\"6\">
<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\">
<tr>
	<td valign='top' align=left>";




										$subject =@$_POST["subject"];		
										//SEGNATURE						   
										$admin_id = $_SESSION['admin_id'];
										$admin_status=$_SESSION['status'];
										$site = $_SERVER['HTTP_HOST'];
										
										$sql="SELECT * FROM admin WHERE admin_id = $admin_id;";
										$result=mysql_query($sql);
										$ctr=@mysql_num_rows($result);
										if ($ctr >0 )
										{
											$row = mysql_fetch_array ($result); 
											$admin_email = $row['admin_email'];
											$name = $row['admin_fname']." ".$result['admin_lname'];
											$admin_email=$row['admin_email'];
											$signature_company = $row['signature_company'];
											$signature_notes = $row['signature_notes'];
											$signature_contact_nos = $row['signature_contact_nos'];
											$signature_websites = $row['signature_websites'];
										}
										
										if($signature_notes!=""){
											$signature_notes = "<p><i>$signature_notes</i></p>";
										}else{
											$signature_notes = "";
										}
										if($signature_company!=""){
											$signature_company="<br>$signature_company";
										}else{
											$signature_company="<br>RemoteStaff";
										}
										if($signature_contact_nos!=""){
											$signature_contact_nos = "<br>$signature_contact_nos";
										}else{
											$signature_contact_nos = "";
										}
										if($signature_websites!=""){
											$signature_websites = "<br>Websites : $signature_websites";
										}else{
											$signature_websites = "";
										}
										
										$signature_template = $signature_notes;
										$signature_template .="<a href='http://$site/$agent_code'>
													<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>";
										$signature_template .= "<p><b>$name</b>$signature_company$signature_contact_nos<br>Email : $admin_email$signature_websites</p>";
										//END SEGNATURE		

$body = $body.$signature_template."
	</td>
</tr>
</table></td></tr>
<tr ><td valign=\"top\" colspan=\"6\" >&nbsp;</td></tr>

</table>
</div>	  
	  
     </td>
 
  </tr>
</table><p>&nbsp;</p></td>
</tr></table>
</div>
";
//end end signature


		$from_email=$admin_email;
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .= "From: ".$from_email." \r\n"."Reply-To: ".$from_email."\r\n";	

if (TEST) 
{
	$client_email = 'devs@remotestaff.com.au';
}
mail($client_email, $subject, $body, $header);
$to_counter = $_POST["to_counter"];
if($to_counter > 0)
{
	for($i = 0; $i <= $to_counter; $i++)
	{
		$to = $_POST["to".$i];
		if($to == "" || $to == NULL)
		{
			//do nothing
		}
		else
		{
			if (TEST) 
			{
				$to = 'devs@remotestaff.com.au';
			}
			mail($to, $subject, $body, $header);			
		}	
	}
}	


		
		
		
		
		
		
		
		
		
		
		
///RESPONDER TO SUBCONTRUCTOR
if($pos == "")
{
	$pos = "for the ".@$_POST["ads_temp"]." position to one of our clients.";
}
$body="
<style type=\"text/css\"> 
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
Dear ".$fullname.",
<p> <br>
</p>
<p>We are happy to inform you that we have just recommended you ".$pos." </p>
<p>The client will either hire you on the spot based on your resume, voice recording an initial interview summary or request a final interview.<br>
</p>
<p>We will get back to you with a feedback within 5 business days with regards to the client&rsquo;s decision.</p>
<p>&nbsp;</p>
<p>Should you happen to find/accept a lucrative offer/job from another company within these 2 days, please inform us so we could pull your application out.<br>
</p>
";		
$subject = "Remotestaff: Application Update";



						   
										//SEGNATURE						   
										$admin_id = $_SESSION['admin_id'];
										$admin_status=$_SESSION['status'];
										$site = $_SERVER['HTTP_HOST'];
										
										$sql="SELECT * FROM admin WHERE admin_id = $admin_id;";
										$result=mysql_query($sql);
										$ctr=@mysql_num_rows($result);
										if ($ctr >0 )
										{
											$row = mysql_fetch_array ($result); 
											$admin_email = $row['admin_email'];
											$name = $row['admin_fname']." ".$result['admin_lname'];
											$admin_email=$row['admin_email'];
											$signature_company = $row['signature_company'];
											$signature_notes = $row['signature_notes'];
											$signature_contact_nos = $row['signature_contact_nos'];
											$signature_websites = $row['signature_websites'];
										}
										

										
										if($signature_notes!=""){
											$signature_notes = "<p><i>$signature_notes</i></p>";
										}else{
											$signature_notes = "";
										}
										if($signature_company!=""){
											$signature_company="<br>$signature_company";
										}else{
											$signature_company="<br>RemoteStaff";
										}
										if($signature_contact_nos!=""){
											$signature_contact_nos = "<br>$signature_contact_nos";
										}else{
											$signature_contact_nos = "";
										}
										if($signature_websites!=""){
											$signature_websites = "<br>Websites : $signature_websites";
										}else{
											$signature_websites = "";
										}
										
										$signature_template = $signature_notes;
										$signature_template .="<a href='http://$site/$agent_code'>
													<img src='http://$site/portal/images/remote_staff_logo.png' width='171' height='49' border='0'></a><br>";
										$signature_template .= "<p><b>$name</b>$signature_company$signature_contact_nos<br>Email : $admin_email$signature_websites</p>";
										$body .= $signature_template;						   
										//END SEGNATURE						

if (TEST) 
{
	$subcontructor_email = 'devs@remotestaff.com.au';
}
mail($subcontructor_email, $subject, $body, $header);		
//END AUTORESPONDER FOR SUBCONTRUCTOR		
		
		
		$userid = @$_GET["userid"];
		$a = mysql_query("SELECT fname, lname FROM personal WHERE userid='$userid' LIMIT 1");
		$name = mysql_result($a,0,"fname")." ".mysql_result($a,0,"lname");
		?>
		<script language="javascript">
			alert("<?php echo $name; ?> has been successfully endorsed. The resume will be sent to the client along with an email");
			window.close();
		</script>
		
<?php		
}
$subject_value = "Remotestaff: (".$FullName.")";
?>














<html>
<head>
<title>Administrator-Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<script type='text/javascript' language='JavaScript' src='js/common_funcs.js'></script>
<script type='text/javascript' language='JavaScript' src='js/form_utils.js'></script>

<script type="text/javascript" src="js/calendar.js"></script> 
<script type="text/javascript" src="lang/calendar-en.js"></script> 
<script type="text/javascript" src="js/calendar-setup.js"></script>
<script type="text/javascript" src="js/ajax.js"></script>

<script src="selectClient.js"></script>

<script type="text/javascript" src="media/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>	
<script type="text/javascript">
tinyMCE.init({

    // General options

    mode : "textareas",

    theme : "advanced",

    plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",



    // Theme options

    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",

    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",

    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",

    theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",

    theme_advanced_toolbar_location : "top",

    theme_advanced_toolbar_align : "left",

    theme_advanced_statusbar_location : "bottom",

    theme_advanced_resizing : true,



    // Example content CSS (should be your site CSS)

    content_css : "css/example.css",



    // Drop lists for link/image/media/template dialogs

    template_external_list_url : "js/template_list.js",

    external_link_list_url : "js/link_list.js",

    external_image_list_url : "js/image_list.js",

    media_external_list_url : "js/media_list.js",



    // Replace values for the template plugin

    template_replace_values : {

        username : "Some User",

        staffid : "991234"

    }

});
</script>


<link rel="stylesheet" type="text/css" media="all" href="css/calendar-blue.css" title="win2k-1" />

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
<script language=javascript src="js/functions.js"></script>
<script type="text/javascript">
var i=0;
var temp;
var sub_value = "Remotestaff: (<?php echo $FullName; ?>)";
var to_array=new Array();
var to_inputbox;
var checker;

function createNewTextBox()
{
	checker = document.getElementById('to_id'+i).value;
	if(i > 0 && checker == "")
	{
		//do nothing
	}
	else
	{
		to_inputbox = "<table cellspacing=2 border=0 width=100%>";
		to_array[i]=document.getElementById('to_id'+i).value;
		i = i + 1;	
		for(temp=1; temp<=i; temp++)
		{
			if(temp == i)
			{
				to_inputbox = to_inputbox+"<tr><td><input type='text' id='to_id" + temp + "' name='to" + temp + "' style='width:50%' class='text' value=''></td></tr>"		
			}
			else
			{
				to_inputbox = to_inputbox+"<tr></td><input type='text' id='to_id" + temp + "' name='to" + temp + "' style='width:50%' class='text' value='" + to_array[temp] + "'></td></tr>"
			}
		}
		to_inputbox = to_inputbox+"</table>";
		document.getElementById('myDivName').innerHTML = to_inputbox;
		document.getElementById('to_counter_id').value = i;
	}	
}

function fillAds(ads)
{
	document.form.ads2.value=ads;
}
function checkFields()
{

	if((document.form.kliyente.selectedIndex=="0")||(document.getElementById('client_id_display').value==""))
	{
		alert("Please choose a Client in the List!");
		return false;
	}
	
	var answer = confirm ("Are you sure you want to endorse this candidate?")
	if (answer)
	{	
		return true;
	}
	else
	{
		return false;
	}
}




		
		//SEARCH LEADS
		//var curSubMenu = '';
		var keyword;	
		var SL_request = makeObject()
		function SL_query_lead()
		{
			//get_applicant_name(this.value); 
			//alert(id);
			keyword = document.getElementById('key_id').value;
			if(keyword == "" || keyword == "(fname/lname/email)")
			{
				alert("Please Enter Your Keyword!");
			}
			else
			{
				SL_request.open('get', 'search-leads.php?key='+keyword)
				SL_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
				SL_request.onreadystatechange = SL_active_listings 
				SL_request.send(1)
			}
		}
		function SL_active_listings()
		{
			var data;
			data = SL_request.responseText
			if(SL_request.readyState == 4)
			{
				document.getElementById('search_div').innerHTML = "<table width='100%' height='100%' align='center' cellspacing='5' cellspading='5'><tr><td align=center>"+data+"</td></tr></table>";
			}
			else
			{
				document.getElementById('search_div').innerHTML = "<table width='100%' height='100%' align='center' cellspacing='5' cellspading='5'><tr><td align=center><img src='images/ajax-loader.gif'></td></tr></table>";
			}
		}		
		function SL_search_lead()
		{
			//num_selected = num;
			//if (curSubMenu!='') 
			//SL_hideSubMenu();
			eval('search_div').style.visibility='visible';			
			//document.getElementById('search_div').innerHTML = document.getElementById('search_box').innerHTML;	
			//curSubMenu='search_div';
		}
		function SL_hideSubMenu()
		{
			eval('search_div').style.visibility='hidden';	
			//document.getElementById(curSubMenu).innerHTML = "";
			//curSubMenu='';
		}	
		function SL_assign(id,name)
		{
			document.getElementById('kliyente').value = id;
			document.getElementById('client_id_display').value = name;		
		}	
		//ENDED - SEARCH LEADS	
		
</script>


<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td width=100% valign=top >
<table width=100%  cellspacing=0 cellpadding=2 border=0 align=left >
<tr>
<td width="86%" valign="top" align="left">


					<div id='search_div' STYLE='POSITION: Absolute; VISIBILITY: HIDDEN'>
						<table cellpadding="1" cellspacing="0" bgcolor="#003366">
							<tr><td>
								<div id="listings_div">
									<table cellpadding="2" cellspacing="2" bgcolor="#FFFF99">
										<tr><td colspan="2">(Keyword: <font color="#FF0000"><strong>ALL</strong></font> '<em>displays all leads</em>')</td></tr>	 
										<tr>
											<td colspan="2">
												<input name="key" id="key_id" type="text" value="(fname/lname/email)" onMouseOut="javascript: if(this.value=='') { this.value='(fname/lname/email)'; } " onClick="javascript: if(this.value=='(fname/lname/email)') { this.value=''; } ">
												<input type="button" value="Search" class="button" onClick="javascript: SL_query_lead(this.value); ">
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td align="right"><a href="javascript: SL_hideSubMenu(); "><img src="images/action_delete.gif" border="0"></a></td>
										</tr>	
									</table>
								</div>
							</td></tr>
						</table>                                                                
					</div>
<form name="form" method="post" action="?userid=<?php echo @$_GET["userid"]; ?>" onSubmit="return checkFields();">
<input type="hidden" size="20%" name="to_counter" id="to_counter_id" value=0 />
<table width="100%" style="border:#CCCCCC solid 1px;" cellpadding="3" cellspacing="3">
	<tr>
		<td height="40" colspan="2">
			<div style='padding:3px; font:12px Arial;background:#E9E9E9; border:#CCCCCC outset 1px;'>
				<b>Endorse to Client</b>
			</div>				
		</td>
	</tr>	
	<tr>
		<td valign="top" colspan="2">
			<b><?php echo $FullName; ?></b>
		</td>
	</tr>  
	<tr>
		<td colspan="2" valign="top"><hr></td>
	</tr>
	<tr>
		<td height="32" colspan="2" valign="middle">
			<table width="100%">
				<tr>
					<td colspan="3" height="24"><strong>Sub-Contracted to</strong></td>
				</tr>
				<tr>
					<td width="11%" height="28">Client</td>
					<td width="1%">:</td>
					<td width="88%">
                    	<!--
						<select name="kliyente" class="select" onChange="showClientCompany(this.value);">
							<option value="0">-</option>
							<?=$usernameOptions2;?>
						</select>
                        -->
						<input type="hidden" ID="kliyente" NAME="kliyente" value="" />
						<input class="text" type="text" id="client_id_display" name="client_display" readonly="readonly" value="" />                        
                        <a href="javascript: SL_search_lead(); "><img src="images/view.gif" border="0"></a>
					</td>
				</tr>
				<tr>
					<td width="11%" height="28" valign="top">CC</td>
					<td width="1%" valign="top">:</td>
					<td width="88%" valign="top">
						<input type="hidden" id="to_id0" value="">
						<div name="temp" id="myDivName"></div><input type='button' onClick="createNewTextBox();" value="Add" />					
					</td>
				</tr>				
				<tr>
					<td width="11%" height="28">Subject</td>
					<td width="1%">:</td>
					<td width="88%">
                      <input type="text" id="subject_id" name="subject" class="text" style="width:70%" value="<?php echo $subject_value; ?>">
</td>
				</tr>			
				<tr>
					<td width="11%" height="28">Monthly Rate</td>
					<td width="1%">:</td>
					<td width="88%">
						Monthly full time rate (9 hour shift with 1 hour lunch break): <br />
						<input type="text" class="text" name="f_time" style="width:10%" value=""> <em><font size="1">(Full Time)</font></em>
					</td>
				</tr>	
				<tr>
					<td width="11%" height="28"></td>
					<td width="1%">:</td>
					<td width="88%">
						Monthly part time rate (4 hour shift): <br />
						<input type="text" class="text" name="p_time" style="width:10%" value=""> <em><font size="1">(Part Time)</font></em>
					</td>
				</tr>			
				<tr>
					<td width="11%" height="28" valign="top">Include Comments</td>
					<td width="1%" valign="top">:</td>
					<td width="88%">
						<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<?php
							$userid = @$_GET["userid"];
							$c = "SELECT comments FROM evaluation_comments WHERE userid='$userid';";
							$r=mysql_query($c);
							$c_counter = 0;
							while(list($comments) = mysql_fetch_array($r))
							{
								$c_counter++;
								//$comments = str_replace("<","&gt;",$comments);						
								//$comments = str_replace(">","&lt;",$comments);				
						?>		
							<tr>
								<td valign="top"><input type="checkbox" name="comment<?php echo $c_counter; ?>" value="<?php echo $comments; ?>" checked></td>
								<td width="100%"><?php echo $comments; ?></td>
							</tr>
						<?php	
							}
						?>
						<input type="hidden" value="<?php echo $c_counter; ?>" name="c_counter">
						</table>
					</td>
				</tr>
				
				
				<tr>
					<td width="11%" height="28" valign="top">Include Samples</td>
					<td width="1%" valign="top">:</td>
					<td width="88%">
						<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<?php
							$c = mysql_query("SELECT * FROM tb_applicant_files WHERE userid='$userid'");	
							$c_counter = 0;
							while ($row = @mysql_fetch_assoc($c)) 
							{		
								$c_counter++;
						?>			
							<tr>
								<td valign="top"><input type="checkbox" name="file<?php echo $c_counter; ?>" value="<?php echo $row["name"]; ?>" checked></td>
								<td width="100%">
								<?php 
									if($row["file_description"] != "" || $row["file_description"] != NULL)
									{
										echo $row["file_description"].":&nbsp;<i><a href='applicants_files/".$row["name"]."' target='_blank'>".$row["name"]."</a></i>"; 
									}
									else
									{
										echo "<i><a href='applicants_files/".$row["name"]."' target='_blank'>".$row["name"]."</a></i>"; 
									}
								?>										
								</td>
							</tr>
						<?php	
							}
						?>
						<input type="hidden" value="<?php echo $c_counter; ?>" name="f_counter">
						</table>
					</td>
				</tr>					
				
						
				<td width="11%" height="28" valign="top">Job Position<em>(optional)</em></td>
					<td width="1%">:</td>
					<td width="88%">
						<input type="text" id="ads_temp" name="ads_temp"  class="text">
						<br />					
						<font size="1"><em>(This will be use when the client has no Active or Current Job Advertisement)</em></font>
					</td>									
				<tr>
					<td colspan="3">
						<div id="client_details" >&nbsp;</div>
					</td>
				</tr>
				<tr>
					<td colspan="3">
					Your Message to Client
					</td>
				</tr>					
				<tr>
					<td colspan="3">
					<textarea name="body_message" cols="48" rows="7" wrap="physical" class="text"  style="width:100%"></textarea>
					<script language="javascript1.2">
						generate_wysiwyg('contents');
					</script>					
					</td>
				</tr>				
				<tr>
					<td>
					<INPUT type="submit" value="Send" name="send" class="button" style="width:120px">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" valign="top"></td>
	</tr>
</table>
</form>




</td>
</tr>
</table>
</td>
</tr>
</table>
</td></tr>
</table>
 
</body>
</html>



