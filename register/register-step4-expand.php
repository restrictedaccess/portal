<?php

include '../conf/zend_smarty_conf.php'; 
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['userid'] == "" or $_SESSION['userid'] == NULL){
	header("Location: ../registernow-step4-personal-details.php");
}

$userid=$_SESSION['userid'];
$current_status=$_POST['current_status'];
$years_worked=$_POST['years_worked'];
$months_worked=$_POST['months_worked'];
$expected_salary_neg=$_POST['expected_salary_neg'];
$expected_salary=$_POST['expected_salary'];
$salary_currency=$_POST['salary_currency'];
$latest_job_title=$_POST['latest_job_title'];

$position_first_choice=$_POST['position_first_choice'];
$position_first_choice_exp=$_POST['position_first_choice_exp'];
$position_second_choice=$_POST['position_second_choice'];
$position_second_choice_exp=$_POST['position_second_choice_exp'];
$position_third_choice=$_POST['position_third_choice'];
$position_third_choice_exp=$_POST['position_third_choice_exp'];

$history_company_name=$_POST['history_company_name'];
$history_position=$_POST['history_position'];
$history_monthfrom=$_POST['history_monthfrom'];
$history_yearfrom=$_POST['history_yearfrom'];
$history_monthto=$_POST['history_monthto'];
$history_yearto=$_POST['history_yearto'];
$history_responsibilities=$_POST['history_responsibilities'];


if($_POST['form_id'] == "") {
	$password = trim($_POST['password']);
	if($password == "") {
		//make a random string password for client 
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$rand_pw = '';    
		for ($p = 0; $p < 10; $p++) {
			$rand_pw .= $characters[mt_rand(0, strlen($characters))];
		}
		$password = $rand_pw;
	}
	$pass= sha1($password);
}else{
	$sql = $db->select()
		->from('personal' ,'pass')
		->where('userid = ?' , $userid);
	$pass = $db->fetchOne($sql);	 
}


if($current_status=="still studying"){
	$intern_status=1;
	$freshgrad=0;
}
else{
	if($current_status=="fresh graduate"){
		$intern_status=0;
		$freshgrad=1;
	}else{
		$intern_status=0;
		$freshgrad=1;
	}
}


$data = array( 
	'userid' =>$userid,
	'freshgrad' => $freshgrad,
	'intern_status' => $intern_status,
	'years_worked' => $years_worked,
	'months_worked' => $months_worked,
	'expected_salary_neg' => $expected_salary_neg,
	'expected_salary' => $expected_salary,
	'salary_currency' => $salary_currency,
	'latest_job_title' => $latest_job_title,
	

	'position_first_choice' => $position_first_choice,
	'position_first_choice_exp' => $position_first_choice_exp,
	'position_second_choice' => $position_second_choice,
	'position_second_choice_exp' => $position_second_choice_exp,
	'position_third_choice' => $position_third_choice,
	'position_third_choice_exp' => $position_first_choice_exp
);

$result=array();
$result=array_merge($result,$data);
for($i=0;$i<count($history_company_name);$i++){
	$db_column_suffix = $i+1;
	if($i==0)$db_column_suffix = "";
	$result = array_merge($result,array('companyname'.$db_column_suffix => $history_company_name[$i]));
	$result = array_merge($result,array('position'.$db_column_suffix => $history_position[$i]));
	$result = array_merge($result,array('monthfrom'.$db_column_suffix => $history_monthfrom[$i]));
	$result = array_merge($result,array('yearfrom'.$db_column_suffix => $history_yearfrom[$i]));
	$result = array_merge($result,array('monthto'.$db_column_suffix => $history_monthto[$i]));
	$result = array_merge($result,array('yearto'.$db_column_suffix => $history_yearto[$i]));
	$result = array_merge($result,array('duties'.$db_column_suffix => $history_responsibilities[$i]));
}


$sql = $db->select()
	->from('currentjob' , 'userid')
	->where('userid = ?' ,$userid);
$exists = $db->fetchOne($sql);
if($exists){
	$where = "userid = ".$userid;
	$db->update('currentjob', $result, $where);
}else{
	$db->insert('currentjob', $result);
}

//id, userid, form, form_url, date_completed
$sql = $db->select()
	->from('applicants_form' , 'id')
	->where('userid = ?' ,$userid)
	->where('form = ?' , 4); 
$id = $db->fetchOne($sql);
 
$data = array('userid' => $userid, 'form' => 4, 'form_url' => $_SERVER['HTTP_HOST']."/".$_POST['page'], 'date_completed' => $ATZ);

if($id){
	$where = "id = ".$id;
	$db->update('applicants_form', $data, $where);
}else{
	$db->insert('applicants_form', $data);
}



header("Location: ../registernow-step4-work-history-details.php"); 






?>