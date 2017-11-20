<?
//from: currentJob.php
include 'config.php';
include 'function.php';
include 'conf.php';

$userid=$_SESSION['userid'];
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

$latest_job_title=$_REQUEST['latest_job_title'];

$companyname =filterfield($companyname);
$position =filterfield($position);
$duties=filterfield($duties);

$companyname2 =filterfield($companyname2);
$position2 =filterfield($position2);
$duties2=filterfield($duties2);

$companyname3 =filterfield($companyname3);
$position3 =filterfield($position3);
$duties3=filterfield($duties3);

$companyname4 =filterfield($companyname4);
$position4 =filterfield($position4);
$duties4=filterfield($duties4);

$companyname5 =filterfield($companyname5);
$position5 =filterfield($position5);
$duties5=filterfield($duties5);
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

/*
echo "Current Status =".$freshgrad."<br>".
	"years_worked =".$years_worked."<br>".
	"months_worked =".$months_worked."<br>".
	"intern_status =".$intern_status."<br>".
	"iday =".$iday."<br>".
	"imonth =".$imonth."<br>".
	"iyear =".$iyear."<br>".
	"intern_notice =".$intern_notice."<br>".
	"company_name =".$company_name."<br>".
	"company_industry =".$company_industry."<br>".
	"title =".$title."<br>".
	"dpt_field =".$dpt_field."<br>".
	"positionlevel =".$positionlevel."<br>".
	"monthjoined =".$monthjoined."<br>".
	"yearjoined =".$yearjoined."<br>".
	"monthleft =".$monthleft."<br>".
	"yearleft =".$yearleft."<br>".
	"available_status =".$available_status."<br>".
	"available_notice =".$available_notice."<br>".
	"aday =".$aday."<br>".
	"amonth =".$amonth."<br>".
	"ayear =".$ayear."<br>".
	"salary_currency =".$salary_currency."<br>".
	"expected_salary =".$expected_salary."<br>".
	"expected_salary_neg =".$expected_salary_neg."<br>";
*/
/*
id, userid, freshgrad, years_worked, months_worked, intern_status, iday, imonth, iyear, intern_notice, available_status, available_notice, aday, amonth, ayear, salary_currency, expected_salary, expected_salary_neg, companyname, position, monthfrom, yearfrom, monthto, yearto, duties, companyname2, position2, monthfrom2, yearfrom2, monthto2, yearto2, duties2, companyname3, position3, monthfrom3, yearfrom3, monthto3, yearto3, duties3, companyname4, position4, monthfrom4, yearfrom4, monthto4, yearto4, duties4, companyname5, position5, monthfrom5, yearfrom5, monthto5, yearto5, duties5
*/



$query="INSERT INTO currentjob (userid, freshgrad, years_worked, months_worked, intern_status, iday, imonth, iyear, intern_notice,available_status, available_notice, aday, amonth, ayear, salary_currency, expected_salary, expected_salary_neg,companyname, position, monthfrom, yearfrom, monthto, yearto, duties, companyname2, position2, monthfrom2, yearfrom2, monthto2, yearto2, duties2, companyname3, position3, monthfrom3, yearfrom3, monthto3, yearto3, duties3, companyname4, position4, monthfrom4, yearfrom4, monthto4, yearto4, duties4, companyname5, position5, monthfrom5, yearfrom5, monthto5, yearto5, duties5, latest_job_title) 


VALUES ($userid, '$freshgrad', '$years_worked', '$months_worked', '$intern_status', '$iday', '$imonth', '$iyear', '$intern_notice','$available_status', '$available_notice', '$aday', '$amonth', '$ayear', '$salary_currency', '$expected_salary', '$expected_salary_neg','$companyname', '$position', '$monthfrom', '$yearfrom', '$monthto', '$yearto', '$duties', '$companyname2', '$position2', '$monthfrom2', '$yearfrom2', '$monthto2', '$yearto2', '$duties2', '$companyname3', '$position3', '$monthfrom3', '$yearfrom3', '$monthto3', '$yearto3', '$duties3', '$companyname4', '$position4', '$monthfrom4', '$yearfrom4', '$monthto4', '$yearto4', '$duties4', '$companyname5', '$position5', '$monthfrom5', '$yearfrom5', '$monthto5', '$yearto5', '$duties5', '$latest_job_title');";

//echo $query;
$result=mysql_query($query);
if (!$result)
{
	$mess="Error";
	//echo ("Query: $query\n<br />MySQL Error: " . mysql_error());
	header("location:currentJob.php?mess=$mess&userid=$userid");
}
else
{
	//echo "Data Inserted";
	header("location:skillsStrengths.php");
	$mess="";
}

// to: -> skillsStrengths.php
?>

