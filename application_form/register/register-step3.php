<?php

include '../../conf/zend_smarty_conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime; 


if($_SESSION['userid'] == "" or $_SESSION['userid'] == NULL){
	header("Location: ../registernow-step3-personal-details.php");
}

$userid=$_SESSION['userid'];
$trainings_and_seminars_attended=$_POST['trainings_and_seminars_attended'];
$highest_level=$_POST['highest_level'];
$field_of_study=$_POST['field_of_study'];
$others=$_POST['others'];
$major=$_POST['major'];
$grade=$_POST['grade'];
$gpa=$_POST['gpa'];
$university=$_POST['university'];
$graduate_month=$_POST['graduate_month'];
$graduate_year=$_POST['graduate_year'];
$university_location=$_POST['university_location'];


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

$start_worked_from_home=$start_worked_from_home_year."-".$start_worked_from_home_month."-".$start_worked_from_home_day;

if($desktop_computer=="yes")$desktop_specs = "desktop ".$desktop_os." ".$desktop_processor." ".$desktop_ram."\n";
if($loptop_computer=="yes")$laptop_specs = "laptop ".$loptop_os." ".$loptop_processor." ".$loptop_ram."\n";
$others_specs = "";
$others_specs .= $headset."\n";
$others_specs .= $headphone."\n";
$others_specs .= $printer."\n";
$others_specs .= $scanner."\n";
$others_specs .= $tablet."\n";
$others_specs .= $pen_tablet."\n";
$computer_hardware=$desktop_specs.$laptop_specs.$others_specs;

if($field_of_study=="Others") $fieldstudy = $others;
else $fieldstudy = $field_of_study;

$data = array( 
	'trainings_seminars' => $trainings_and_seminars_attended,
	'educationallevel' => $highest_level,
	'fieldstudy' => $fieldstudy,
	'major' => $major,
	'grade' => $grade,
	'gpascore' => $gpa,
	'college_name' => $university,
	'college_country' => $university_location,
	'graduate_month' => $graduate_month,
	'graduate_year' => $graduate_year,
	'userid' => $userid	
);

$sql = $db->select()
	->from('education' , 'userid')
	->where('userid = ?' ,$userid);
$exists = $db->fetchOne($sql);

if($exists){
	$where = "userid = ".$userid;
	$db->update('education', $data, $where);
}else{
	$db->insert('education', $data);
}

//id, userid, form, form_url, date_completed
$sql = $db->select()
	->from('applicants_form' , 'id')
	->where('userid = ?' ,$userid)
	->where('form = ?' , 3); 
$id = $db->fetchOne($sql);

if (isset($_COOKIE["promo_code"])){
	$db->update("personal", array("promotional_code"=> $_COOKIE["promo_code"]), $db->quoteInto("userid = ?", $userid));
}
if (isset($_COOKIE["promo_code"])){
	//get promo code owner
	$promocode = $db->fetchRow($db->select()->from("personal_promo_codes")->where("promocode = ?", $_COOKIE["promo_code"]));
	if ($promocode){
		//register as a referral with type promocode
		$personal = $db->fetchRow($db->select()->from("personal")->where("userid = ?", $userid));
		
		if ($personal){
			$referral = array(
				"user_id"=>$promocode["userid"],
				"firstname"=>$personal["fname"],
				"lastname"=>$personal["lname"],
				"email"=>$personal["email"],
				"contactnumber"=>$personal["handphone_country_code"]."+".$personal["handphone_no"],
				"date_created"=>date("Y-m-d H:i:s"),
				"contacted"=>0,
				"jobseeker_id"=>$userid,
				"type"=>"promo_code"
			);
			$refer = $db->fetchRow($db->select()->from("referrals")->where("user_id = ?", $promocode["userid"])->where("jobseeker_id = ?", $userid));
			if (!$refer){
				$db->insert("referrals", $referral);
			}
		}
		
			
	}
	
}
 
$data = array('userid' => $userid, 'form' => 3, 'form_url' => $_SERVER['HTTP_HOST']."/".$_POST['page'], 'date_completed' => $ATZ);

if($id){
	$where = "id = ".$id;
	$db->update('applicants_form', $data, $where);
}else{
	$db->insert('applicants_form', $data);
}

header("Location: ../registernow-step4-work-history-details.php"); 






?>