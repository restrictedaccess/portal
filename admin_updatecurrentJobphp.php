<?php
//2010-08-06    Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Removed filterfield
//2010-08-05    Lawrence Oliver Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   add session check
//from: currentJob.php
include 'config.php';
include 'function.php';
include 'conf.php';
include 'time.php';

$admin_id = $_SESSION["admin_id"];
if ($admin_id == '') {
    die('session not found');
}


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


//$userid=$_SESSION['userid'];
$userid=@$_GET["userid"]; //$_SESSION['userid'];
//$userid=$_REQUEST['userid'];

$freshgrad=$_REQUEST['freshgrad'];
/*
0 "I have been working for"
1 "I am a fresh graduate seeking my first job"
2 "I am still pursuing my studies and seeking internship or part-time jobs"
*/

if($freshgrad=="0")
{
	// years_worked
	// months_worked
	$years_worked=$_REQUEST['years_worked'];
	$months_worked=$_REQUEST['months_worked'];
}

if($freshgrad=="2")
{
	// years_worked
	// months_worked
	$intern_status=$_REQUEST['intern_status'];
	// x ="I am available for internship jobs.<div style='padding-top:3px;'>My internship period is from"
	// p = "I am not looking for an internship now"
	if ($intern_status=="x")
	{
		// iday , imonth, iyear, intern_notice
		$iday=$_REQUEST['iday'];
		$imonth=$_REQUEST['imonth'];
		$iyear=$_REQUEST['iyear'];
		$intern_notice=$_REQUEST['intern_notice'];
		
	}
	
}

//$company_name=$_REQUEST['company_name'];
//$company_industry=$_REQUEST['company_industry'];
//$title=$_REQUEST['title'];
//$dpt_field=$_REQUEST['dpt_field'];
//$positionlevel=$_REQUEST['positionlevel'];
//$monthjoined=$_REQUEST['monthjoined'];
//$yearjoined=$_REQUEST['yearjoined'];
//$monthleft=$_REQUEST['monthleft'];
//$yearleft=$_REQUEST['yearleft'];
////////////////////////////////// new fields june 13 2008
$companyname=$_REQUEST['companyname'];
$position=$_REQUEST['position'];
$monthfrom=$_REQUEST['monthfrom'];
$yearfrom=$_REQUEST['yearfrom'];
$monthto=$_REQUEST['monthto'];
$yearto=$_REQUEST['yearto'];
$duties=$_REQUEST['duties'];

$companyname2=$_REQUEST['companyname2'];
$position2=$_REQUEST['position2'];
$monthfrom2=$_REQUEST['monthfrom2'];
$yearfrom2=$_REQUEST['yearfrom2'];
$monthto2=$_REQUEST['monthto2'];
$yearto2=$_REQUEST['yearto2'];
$duties2=$_REQUEST['duties2'];

$companyname3=$_REQUEST['companyname3'];
$position3=$_REQUEST['position3'];
$monthfrom3=$_REQUEST['monthfrom3'];
$yearfrom3=$_REQUEST['yearfrom3'];
$monthto3=$_REQUEST['monthto3'];
$yearto3=$_REQUEST['yearto3'];
$duties3=$_REQUEST['duties3'];

$companyname4=$_REQUEST['companyname4'];
$position4=$_REQUEST['position4'];
$monthfrom4=$_REQUEST['monthfrom4'];
$yearfrom4=$_REQUEST['yearfrom4'];
$monthto4=$_REQUEST['monthto4'];
$yearto4=$_REQUEST['yearto4'];
$duties4=$_REQUEST['duties4'];

$companyname5=$_REQUEST['companyname5'];
$position5=$_REQUEST['position5'];
$monthfrom5=$_REQUEST['monthfrom5'];
$yearfrom5=$_REQUEST['yearfrom5'];
$monthto5=$_REQUEST['monthto5'];
$yearto5=$_REQUEST['yearto5'];
$duties5=$_REQUEST['duties5'];


$companyname6=$_REQUEST['companyname6'];
$position6=$_REQUEST['position6'];
$monthfrom6=$_REQUEST['monthfrom6'];
$yearfrom6=$_REQUEST['yearfrom6'];
$monthto6=$_REQUEST['monthto6'];
$yearto6=$_REQUEST['yearto6'];
$duties6=$_REQUEST['duties6'];

$companyname7=$_REQUEST['companyname7'];
$position7=$_REQUEST['position7'];
$monthfrom7=$_REQUEST['monthfrom7'];
$yearfrom7=$_REQUEST['yearfrom7'];
$monthto7=$_REQUEST['monthto7'];
$yearto7=$_REQUEST['yearto7'];
$duties7=$_REQUEST['duties7'];

$companyname8=$_REQUEST['companyname8'];
$position8=$_REQUEST['position8'];
$monthfrom8=$_REQUEST['monthfrom8'];
$yearfrom8=$_REQUEST['yearfrom8'];
$monthto8=$_REQUEST['monthto8'];
$yearto8=$_REQUEST['yearto8'];
$duties8=$_REQUEST['duties8'];

$companyname9=$_REQUEST['companyname9'];
$position9=$_REQUEST['position9'];
$monthfrom9=$_REQUEST['monthfrom9'];
$yearfrom9=$_REQUEST['yearfrom9'];
$monthto9=$_REQUEST['monthto9'];
$yearto9=$_REQUEST['yearto9'];
$duties9=$_REQUEST['duties9'];

$companyname10=$_REQUEST['companyname10'];
$position10=$_REQUEST['position10'];
$monthfrom10=$_REQUEST['monthfrom10'];
$yearfrom10=$_REQUEST['yearfrom10'];
$monthto10=$_REQUEST['monthto10'];
$yearto10=$_REQUEST['yearto10'];
$duties10=$_REQUEST['duties10'];

$latest_job_title=$_REQUEST['latest_job_title'];

////////////////////////////////////////////////////
$salary_currency=$_REQUEST['salary_currency'];
$expected_salary=$_REQUEST['expected_salary'];
$expected_salary_neg=$_REQUEST['expected_salary_neg'];

$available_status=$_REQUEST['available_status'];
// p ="I am not actively looking for a job now"
// Work Immediately
if($available_status=="a")
{
	//available_notice
	$available_notice=$_REQUEST['available_notice'];
}

if($available_status=="b")
{
	//aday , amonth , ayear
	$aday=$_REQUEST['aday'];
	$amonth=$_REQUEST['amonth'];
	$ayear=$_REQUEST['ayear'];

}

$queryCheck="SELECT * FROM currentjob WHERE userid=$userid;";
$res=mysql_query($queryCheck);
$ctr=@mysql_num_rows($res);

if ($ctr >0 )
{
$query="UPDATE currentjob SET freshgrad = '$freshgrad' , years_worked = '$years_worked' , months_worked = '$months_worked', intern_status = '$intern_status',
			 iday = '$iday', imonth = '$imonth', iyear = '$iyear', intern_notice = '$intern_notice' ,available_status = '$available_status',
			 available_notice = '$available_notice' , aday = '$aday', amonth = '$amonth', ayear = '$ayear', salary_currency = '$salary_currency', 
			 expected_salary = '$expected_salary', expected_salary_neg = '$expected_salary_neg',companyname ='$companyname', position = '$position', 
			 monthfrom = '$monthfrom', yearfrom = '$yearfrom', monthto = '$monthto', yearto = '$yearto', duties = '$duties', companyname2 = '$companyname2', 
			 position2 = '$position2', monthfrom2 = '$monthfrom2', yearfrom2 = '$yearfrom2', monthto2 = '$monthto2', yearto2 = '$yearto2', duties2 = '$duties2',
			 companyname3 = '$companyname3', position3 = '$position3', monthfrom3 = '$monthfrom3', yearfrom3 = '$yearfrom3', monthto3 = '$monthto3', 
			 yearto3 = '$yearto3', duties3 = '$duties3', companyname4 = '$companyname4', position4 = '$position4', monthfrom4 = '$monthfrom4', 
			 yearfrom4 = '$yearfrom4', monthto4 = '$monthto4', yearto4 = '$yearto4', duties4 = '$duties4', companyname5 = '$companyname5', position5 = '$position5',
			 monthfrom5 = '$monthfrom5', yearfrom5 = '$yearfrom5', monthto5 = '$monthto5', yearto5 = '$yearto5', duties5 = '$duties5', 
			 companyname6 = '$companyname6', position6 = '$position6', monthfrom6 = '$monthfrom6', yearfrom6 = '$yearfrom6', monthto6 = '$monthto6', yearto6 = '$yearto6', duties6 = '$duties6', 
			 companyname7 = '$companyname7', position7 = '$position7', monthfrom7 = '$monthfrom7', yearfrom7 = '$yearfrom7', monthto7 = '$monthto7', yearto7 = '$yearto7', duties7 = '$duties7', 
			 companyname8 = '$companyname8', position8 = '$position8', monthfrom8 = '$monthfrom8', yearfrom8 = '$yearfrom8', monthto8 = '$monthto8', yearto8 = '$yearto8', duties8 = '$duties8', 			 
			 companyname9 = '$companyname9', position9 = '$position9', monthfrom9 = '$monthfrom9', yearfrom9 = '$yearfrom9', monthto9 = '$monthto9', yearto9 = '$yearto9', duties9 = '$duties9', 			 			 
			 companyname10 = '$companyname10', position10 = '$position10', monthfrom10 = '$monthfrom10', yearfrom10 = '$yearfrom10', monthto10 = '$monthto10', yearto10 = '$yearto10', duties10 = '$duties10',
			 latest_job_title = '$latest_job_title' WHERE userid = $userid;";
}
else
{

$query="INSERT INTO currentjob SET freshgrad = '$freshgrad' , years_worked = '$years_worked' , months_worked = '$months_worked', intern_status = '$intern_status',
			 iday = '$iday', imonth = '$imonth', iyear = '$iyear', intern_notice = '$intern_notice' ,available_status = '$available_status',
			 available_notice = '$available_notice' , aday = '$aday', amonth = '$amonth', ayear = '$ayear', salary_currency = '$salary_currency', 
			 expected_salary = '$expected_salary', expected_salary_neg = '$expected_salary_neg',companyname ='$companyname', position = '$position', 
			 monthfrom = '$monthfrom', yearfrom = '$yearfrom', monthto = '$monthto', yearto = '$yearto', duties = '$duties', companyname2 = '$companyname2', 
			 position2 = '$position2', monthfrom2 = '$monthfrom2', yearfrom2 = '$yearfrom2', monthto2 = '$monthto2', yearto2 = '$yearto2', duties2 = '$duties2',
			 companyname3 = '$companyname3', position3 = '$position3', monthfrom3 = '$monthfrom3', yearfrom3 = '$yearfrom3', monthto3 = '$monthto3', 
			 yearto3 = '$yearto3', duties3 = '$duties3', companyname4 = '$companyname4', position4 = '$position4', monthfrom4 = '$monthfrom4', 
			 yearfrom4 = '$yearfrom4', monthto4 = '$monthto4', yearto4 = '$yearto4', duties4 = '$duties4', 
			 companyname5 = '$companyname5', position5 = '$position5', monthfrom5 = '$monthfrom5', yearfrom5 = '$yearfrom5', monthto5 = '$monthto5', yearto5 = '$yearto5', duties5 = '$duties5',
			 companyname6 = '$companyname6', position6 = '$position6', monthfrom6 = '$monthfrom6', yearfrom6 = '$yearfrom6', monthto6 = '$monthto6', yearto6 = '$yearto6', duties6 = '$duties6', 
			 companyname7 = '$companyname7', position7 = '$position7', monthfrom7 = '$monthfrom7', yearfrom7 = '$yearfrom7', monthto7 = '$monthto7', yearto7 = '$yearto7', duties7 = '$duties7', 
			 companyname8 = '$companyname8', position8 = '$position8', monthfrom8 = '$monthfrom8', yearfrom8 = '$yearfrom8', monthto8 = '$monthto8', yearto8 = '$yearto8', duties8 = '$duties8', 			 
			 companyname9 = '$companyname9', position9 = '$position9', monthfrom9 = '$monthfrom9', yearfrom9 = '$yearfrom9', monthto9 = '$monthto9', yearto9 = '$yearto9', duties9 = '$duties9', 			 			 
			 companyname10 = '$companyname10', position10 = '$position10', monthfrom10 = '$monthfrom10', yearfrom10 = '$yearfrom10', monthto10 = '$monthto10', yearto10 = '$yearto10', duties10 = '$duties10',
			 latest_job_title = '$latest_job_title' ,userid = $userid;";
}
//echo $query;
$result=mysql_query($query);
if (!$result)
{
	$mess="Error";
	echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
	//header("location:currentJob.php?mess=$mess&userid=$userid");
}
else
{
	//echo "Data Inserted";
	$queryUpdate ="UPDATE personal SET dateupdated='$ATZ ' WHERE userid = $userid;";
	mysql_query($queryUpdate);
?>
	<script language="javascript">
		alert("Form Saved.");
		window.close();
	</script>
<?php	
	//header("location:myresume.php");
	//$mess="";
}

// to: -> skillsStrengths.php
?>

