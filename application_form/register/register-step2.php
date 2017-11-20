<?php

include '../../conf/zend_smarty_conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['userid'] == "" or $_SESSION['userid'] == NULL){
	header("Location: ../registernow-step1-personal-details.php");
}

$userid=$_SESSION['userid'];
$defaults = array(0, 0);
for($i=0;$i<20;$i++){
	$defaults[] = "";
}
$exclude = array("form_id", "x", "y", "page");
$i = 0;
$defaulted = true;
foreach($_POST as $key=>$value){
	if (!in_array($key, $exclude)){
		if (!is_array($value)&&$defaults[$i]!=trim($value)){
			$defaulted = false;
			break;
		}
		$i++;
	}
}
if (!$defaulted){
	$work_from_home_before=$_POST['work_from_home_before'];
	
	$start_worked_from_home_month=$_POST['start_worked_from_home_month'];
	if($start_worked_from_home_month == ''){
		$start_worked_from_home_month = 0;
	}
	
	$start_worked_from_home_year=$_POST['start_worked_from_home_year'];
	if($start_worked_from_home_year == ''){
		$start_worked_from_home_year = 0;
	}
	
	$have_a_baby_in_the_house=$_POST['have_a_baby_in_the_house'];
	$who_is_the_main_caregiver=$_POST['who_is_the_main_caregiver'];
	$why_do_you_want_to_work_from_home=$_POST['why_do_you_want_to_work_from_home'];
	$how_long_do_you_see_yourself_working_for_rs=$_POST['how_long_do_you_see_yourself_working_for_rs'];
	$home_working_environment=$_POST['home_working_environment'];
	$internet_connection=$_POST['internet_connection'];
	$internet_connection_others=$_POST['internet_connection_others'];
	$internet_plan=$_POST['internet_plan'];
	$speed_test_result_link=$_POST['speed_test_result_link'];
	$internet_consequences=$_POST['internet_consequences'];
	$desktop_computer=$_POST['desktop_computer'];
	$desktop_os=$_POST['desktop_os'];
	$desktop_processor=$_POST['desktop_processor'];
	$desktop_ram=$_POST['desktop_ram'];
	$loptop_computer=$_POST['loptop_computer'];
	$loptop_os=$_POST['loptop_os'];
	$loptop_processor=$_POST['loptop_processor'];
	$loptop_ram=$_POST['loptop_ram'];
	$headset=$_POST['headset'];
	$headphone=$_POST['headphone'];
	$printer=$_POST['printer'];
	$scanner=$_POST['scanner'];
	$tablet=$_POST['tablet']; 
	$pen_tablet=$_POST['pen_tablet'];
	$noise_level=$_POST['noise_level'];
	
	//$noises = '';
	if($noise_level != ''){
		$noises = implode(',',$noise_level);
	}
	
	
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
	
	$start_worked_from_home=$start_worked_from_home_year."years and ".$start_worked_from_home_month."months";
	
	if($desktop_computer=="yes")$desktop_specs = "desktop,".$desktop_os.",".$desktop_processor.",".$desktop_ram."\n";
	if($loptop_computer=="yes")$laptop_specs = "laptop,".$loptop_os.",".$loptop_processor.",".$loptop_ram."\n";
	$others_specs = "";
	$others_specs .= $headset."\n";
	$others_specs .= $headphone."\n";
	$others_specs .= $printer."\n";
	$others_specs .= $scanner."\n";
	$others_specs .= $tablet."\n";
	$others_specs .= $pen_tablet."\n";
	$computer_hardware=$desktop_specs.$laptop_specs.$others_specs;
	
	if($work_from_home_before == 'No'){
		$work_from_home_before = 0;
	}
	else{
		$work_from_home_before = 1;
	}
	
	$data = array( 
		'work_from_home_before' => $work_from_home_before,
		'start_worked_from_home' => $start_worked_from_home,
		'has_baby' => $have_a_baby_in_the_house,
		'main_caregiver' => $who_is_the_main_caregiver,
		'reason_to_wfh' => $why_do_you_want_to_work_from_home,
		'timespan' => $how_long_do_you_see_yourself_working_for_rs,
		'home_working_environment' => $home_working_environment,
		'isp' => $internet_connection,
		'internet_connection_others' => $internet_connection_others,
		'internet_connection' => $internet_plan,
		'speed_test' => $speed_test_result_link,
		'internet_consequences' => $internet_consequences,
		'computer_hardware' => $computer_hardware,  
		'noise_level' => $noises
	);
	if (isset($_COOKIE["promo_code"])){
		$data["promotional_code"] = $_COOKIE["promo_code"];
	}
	$where = "userid = ".$userid;
	$db->update('personal', $data, $where); 
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
		
	//id, userid, form, form_url, date_completed
	
	
	$sql = $db->select()
		->from('applicants_form' , 'id')
		->where('userid = ?' ,$userid)
		->where('form = ?' , 2); 
	$id = $db->fetchOne($sql);
	 
	$data = array('userid' => $userid, 'form' => 2, 'form_url' => $_SERVER['HTTP_HOST']."/".$_POST['page'], 'date_completed' => $ATZ);
	
	if($id){
		$where = "id = ".$id;
		$db->update('applicants_form', $data, $where);
	}else{
		$db->insert('applicants_form', $data);
	}
}

header("Location: ../registernow-step3-educational-details.php");  
