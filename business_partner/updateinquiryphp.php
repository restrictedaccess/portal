<?
include '../config.php';
include '../conf.php';
$leads_id = $_REQUEST['leads_id'];
if($leads_id=="")
{
	die("Lead ID is missing..!");
}

$time=$_REQUEST['time'];
$jobresponsibilities=$_REQUEST['jobresponsibilities'];
$rsnumber=$_REQUEST['rsnumber'];
$needrs=$_REQUEST['needrs'];
$rsinoffice=$_REQUEST['rsinoffice'];
$rsinhome=$_REQUEST['rsinhome'];
$questions=$_REQUEST['questions'];
$fname=$_REQUEST['fname'];
$lname=$_REQUEST['lname'];
$companyposition=$_REQUEST['companyposition'];
$companyname=$_REQUEST['companyname'];
$companyaddress=$_REQUEST['companyaddress'];
$email=$_REQUEST['email'];
$website=$_REQUEST['website'];
$officenumber=$_REQUEST['officenumber'];
$mobile=$_REQUEST['mobile'];
$companydesc=$_REQUEST['companydesc'];
$industry=$_REQUEST['industry'];
$noofemployee=$_REQUEST['noofemployee'];
$usedoutsourcingstaff=$_REQUEST['usedoutsourcingstaff'];
$companyturnover=$_REQUEST['companyturnover'];
$openreferral=$_REQUEST['openreferral'];

$query="UPDATE leads SET call_time_preference='$time', remote_staff_competences='$jobresponsibilities', remote_staff_needed='$rsnumber', remote_staff_needed_when='$needrs', remote_staff_one_office='$rsinoffice' , remote_staff_one_home='$rsinhome', your_questions='$questions', fname='$fname',lname='$lname', company_position='$companyposition', company_name='$companyname', company_address='$companyaddress', email='$email', website='$website', officenumber='$officenumber', mobile='$mobile', company_description='$companydesc', company_industry='$industry', company_size='$noofemployee', outsourcing_experience='$used_rs', outsourcing_experience_description='$usedoutsourcingstaff', company_turnover='$companyturnover' WHERE id=$leads_id;";
//echo $query;
$result=mysql_query($query);
if (!$result)
{
	die("Query: $query\n<br />MySQL Error: " . mysql_error());
}
?>
<input type="hidden" id="result_message" value="updated" />
<input type="hidden" id="leadname" value="<?=$fname." ".$lname;?>" />


