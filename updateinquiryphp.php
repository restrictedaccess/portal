<?php
/*
2010 -05-19 Normaneil Macutay <normaneil.macutay@gmail.com>
	- added leads information changes history

2009-10-02 Normaneil Macutay	
	- add allocation of leads to affiliates
*/
include './conf/zend_smarty_conf_root.php';
include './lib/addLeadsInfoHistoryChanges.php';


if($_SESSION['agent_no']=="")
{
	header("location:index.php");
}




$affiliate_id = $_REQUEST['affiliate_id'];
$other_affiliate_id = $_REQUEST['other_affiliate_id'];

$agent_id = $_SESSION['agent_no'];
if($affiliate_id!=""){
	$affiliate = $affiliate_id;
}
if($other_affiliate_id!=""){
	$affiliate = $other_affiliate_id;
}

if($affiliate_id == "" and $other_affiliate_id == "" ){
	$affiliate = $agent_id;
}

$tracking_no = $_REQUEST['tracking_no'];



$page=$_REQUEST['page'];
$leads_id = $_REQUEST['leads_id'];
if($leads_id==""){
	die("Leads ID is Missing. Please try again later.");
}


$leads_location = $_REQUEST['leads_location'];
$time=$_REQUEST['time'];
$jobresponsibilities=$_REQUEST['jobresponsibilities'];
$rsnumber=$_REQUEST['rsnumber'];
$needrs=$_REQUEST['needrs'];
$rsinoffice=$_REQUEST['rsinoffice'];
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
$used_rs=$_REQUEST['used_rs'];
if ($used_rs=="Yes")
{
	$usedoutsourcingstaff=$_REQUEST['usedoutsourcingstaff'];
}
if ($used_rs=="No")
{
	$usedoutsourcingstaff="";
}
	
$companyturnover=$_REQUEST['companyturnover'];
$openreferral=$_REQUEST['openreferral'];

//$company_owner = $_REQUEST['company_owner'];
//$contact = $_REQUEST['contact'];
//$others = $_REQUEST['others'];
//$accounts = $_REQUEST['accounts'];

$acct_dept_name1 = $_REQUEST['acct_dept_name1']; 
$acct_dept_name2 = $_REQUEST['acct_dept_name2'];
$acct_dept_contact1 = $_REQUEST['acct_dept_contact1'];
$acct_dept_contact2 = $_REQUEST['acct_dept_contact2']; 
$acct_dept_email1 = $_REQUEST['acct_dept_email1']; 
$acct_dept_email2 = $_REQUEST['acct_dept_email2'];
$supervisor_staff_name = $_REQUEST['supervisor_staff_name']; 
$supervisor_job_title = $_REQUEST['supervisor_job_title'];
$supervisor_skype = $_REQUEST['supervisor_skype']; 
$supervisor_email = $_REQUEST['supervisor_email'];
$supervisor_contact = $_REQUEST['supervisor_contact']; 
$business_owners = $_REQUEST['business_owners'];
$business_partners =$_REQUEST['business_partners'];	
$nationality = $_REQUEST['nationality'];



$data = array (
	'location_id' => $leads_location,
	'remote_staff_competences' => $jobresponsibilities,
	'remote_staff_needed' => $rsnumber, 
	'remote_staff_needed_when' => $needrs,
	'remote_staff_one_office' => $rsinoffice, 
	'your_questions' => $questions, 
	'fname' => $fname,
	'lname' => $lname, 
	'company_position' => $companyposition, 
	'company_name' => $companyname, 
	'company_address' => $companyaddress, 
	'email' => $email, 
	'website' => $website, 
	'officenumber' => $officenumber, 
	'mobile' => $mobile, 
	'company_description' => $companydesc, 
	'company_industry' => $industry, 
	'company_size' => $noofemployee, 
	'outsourcing_experience' => $used_rs, 
	'outsourcing_experience_description' => $usedoutsourcingstaff, 
	'company_turnover' => $companyturnover , 
	'leads_country' => $nationality ,
	'tracking_no' => $tracking_no,
	'acct_dept_name1' => $acct_dept_name1, 
	'acct_dept_name2' => $acct_dept_name2,
	'acct_dept_contact1' => $acct_dept_contact1,
	'acct_dept_contact2' => $acct_dept_contact2, 
	'acct_dept_email1' => $acct_dept_email1, 
	'acct_dept_email2' => $acct_dept_email2,
	'supervisor_staff_name' => $supervisor_staff_name, 
	'supervisor_job_title' => $supervisor_job_title,
	'supervisor_skype' => $supervisor_skype, 
	'supervisor_email' => $supervisor_email,
	'supervisor_contact' => $supervisor_contact, 
	'business_owners' => $business_owners,
	'business_partners' => $business_partners,
	'agent_id' => $affiliate,
	'business_partner_id' => $agent_id	
	);
	
addLeadsInfoHistoryChanges($data , $leads_id , $_SESSION['agent_no'] , 'bp');
$where = "id = " .$leads_id;
$result = $db->update('leads', $data, $where);


$mess ="Data Updated";
$url = $_POST['url']."&lead_status=".$_POST['lead_status'];	
header("location:".$url);

	


?>

