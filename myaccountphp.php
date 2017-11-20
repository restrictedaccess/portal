<?php
// 2010-12-20 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Add timezone_id
// 2010-01-14 mike s. lacanilao <mike.lacanilao@remotestaff.com.au>
// -- password input changed to encrypted

include './conf/zend_smarty_conf.php';
include './lib/addLeadsInfoHistoryChanges.php';
if($_SESSION['client_id']==""){
	echo "Session expires. Please re-login.";
	exit;
}


$client_id = $_SESSION['client_id'];

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
$password=$_REQUEST['password'];
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


$company_owner = $_REQUEST['company_owner'];
$contact = $_REQUEST['contact'];
$others = $_REQUEST['others'];
$accounts = $_REQUEST['accounts'];
$timezone_id = $_POST['timezone_id'];

if (trim($timezone_id) == '') {
    $timezone_id = null;
}

$data = array(
	'fname' => $fname,
	'lname' => $lname,
	'company_position' => $companyposition, 
	'company_name' => $companyname, 
	'company_address' => $companyaddress, 
	'email' => $email, 
	//'password' => $password,
	'website' => $website, 
	'officenumber' => $officenumber, 
	'mobile' => $mobile, 
	'company_description' => $companydesc, 
	'company_industry' => $industry, 
	'company_size' => $noofemployee, 
	'company_turnover' => $companyturnover,
	'company_owner' => $company_owner, 
	'contact' => $contact, 
	'others' => $others, 
	'accounts' => $accounts,
    'timezone_id' => $timezone_id
	 );

// UPDATE PASSWORD ONLY IF NOT EMPTY
if (trim($password) != '') $data['password'] = sha1($password);

addLeadsInfoHistoryChanges($data , $_SESSION['client_id'] , $_SESSION['client_id'] , 'client');
$where = "id = " .$_SESSION['client_id'];
$result = $db->update('leads', $data, $where);
header("location:clientHome.php");
exit;
?>