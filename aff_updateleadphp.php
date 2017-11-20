<?php
include('conf/zend_smarty_conf.php');
include './lib/addLeadsInfoHistoryChanges.php';
include './lib/validEmail.php';
include './lib/CheckLeadsFullName.php';


if($_SESSION['agent_no'] =="" or $_SESSION['agent_no'] == NULL){
	header("location:index.php");
}



$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$agent_no = $_SESSION['agent_no'];
$created_by_id = $_SESSION['agent_no'];
$created_by_type = 'aff';
$site = $_SERVER['HTTP_HOST'];


$leads_id = $_REQUEST['leads_id'];


$page=$_REQUEST['page'];

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

if(!$email){
	//echo "No Email Address";
	header("location:aff_updatelead.php?mess=2&leads_id=$leads_id");
	exit;
}  
if (!validEmail($email)){ 
	//echo "invalid email address";
	header("location:aff_updatelead.php?mess=3&leads_id=$leads_id");
	exit;	
}

$sql = $db->select()
	->from('leads', 'email')
	->where('id = ?', $leads_id);
$registered_email = $db->fetchOne($sql);

if(trim($registered_email) != $email) {
	//check the email if existing
	$sql = $db->select()
		->from('leads', 'id')
		->where('email = ?', $email);
		$id = $db->fetchOne($sql);
		//echo $leads_id;
	if($id != Null) {
		//echo "email exist";
		header("location:aff_updatelead.php?mess=4&leads_id=$leads_id");
		exit;
	}
}


$data= array ('call_time_preference' => $time, 'remote_staff_competences' => $jobresponsibilities , 'remote_staff_needed' => $rsnumber, 'remote_staff_needed_when' => $needrs, 'remote_staff_one_office' => $rsinoffice, 'your_questions' => $questions, 'fname' => $fname, 'lname' => $lname, 'company_position' => $companyposition, 'company_name' =>$companyname, 'company_address' => $companyaddress, 'email' => $email, 'website' => $website, 'officenumber' => $officenumber, 'mobile' => $mobile, 'company_description' =>$companydesc, 'company_industry' => $industry, 'company_size' => $noofemployee, 'outsourcing_experience' => $used_rs, 'outsourcing_experience_description' => $usedoutsourcingstaff, 'company_turnover' => $companyturnover);

//print_r($data);exit;

addLeadsInfoHistoryChanges($data , $leads_id , $created_by_id , $created_by_type);
$where = "id = ".$leads_id;
$db->update('leads', $data , $where);	
		
header("location:aff_updatelead.php?mess=1&leads_id=$leads_id");
exit;
?>