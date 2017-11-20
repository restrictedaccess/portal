<?php
//2010-07-19 Normaneil Macutay <normanm@remotestaff.com.au>
// - removed the nationality field

include '../conf/zend_smarty_conf.php';
include '../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
session_start();

if($_SESSION['userid'] == "" or $_SESSION['userid'] == NULL){
	header("Location: ../registernow-step1-personal-details.php");
}

$userid=$_SESSION['userid'];
$fname = trim($_POST['fname']);
$lname = trim($_POST['lname']);
$middle_name = trim($_POST['middle_name']);
$nick_name = trim($_POST['nick_name']);


//TODO UPDATE THE personal table

$bmonth= $_POST['bmonth'];
$bday= $_POST['bday'];
$byear= $_POST['byear'];
$gender =$_POST['gender'];
$nationality = $_POST['nationality'];
$auth_no_type_id = $_POST['auth_no_type_id'];
$msia_new_ic_no = $_POST['msia_new_ic_no'];
$permanent_residence = $_POST['permanent_residence'];

$alt_email = $_POST['alt_email'];

$handphone_country_code = $_POST['handphone_country_code'];
$handphone_no = $_POST['handphone_no'];
$tel_area_code = $_POST['tel_area_code'];
$tel_no = $_POST['tel_no'];
$address1 = $_POST['address1'];

$postcode = $_POST['postcode'];
$country_id = $_POST['country_id'];
$state = $_POST['state'];
$city = $_POST['city'];

$msn_id = $_POST['msn_id'];
$yahoo_id = $_POST['yahoo_id'];
$icq_id = $_POST['icq_id'];
$skype_id = $_POST['skype_id'];
	
//TODO : new fields to be added in personal table
$marital_status = $_POST['marital_status'];
$no_of_kids = $_POST['no_of_kids'];
$pregnant = $_POST['pregnant'];
$dmonth = $_POST['dmonth'];
$dday = $_POST['dday'];
$dyear = $_POST['dyear'];
$pending_visa_application = $_POST['pending_visa_application'];
$active_visa = $_POST['active_visa'];

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
//userid, lname, fname, byear, bmonth, bday, auth_no_type_id, msia_new_ic_no, gender, nationality, permanent_residence, email, pass, alt_email, handphone_country_code, handphone_no, tel_area_code, tel_no, address1, address2, postcode, country_id, state, city, msn_id, yahoo_id, icq_id, skype_id, image, datecreated, dateupdated, status, home_working_environment, internet_connection, isp, computer_hardware, headset_quality, payment_details, voice_path, initial_skype_password, initial_email_password, marital_status, no_of_kids, pregnant, dmonth, dday, dyear, pending_visa_application, active_visa, middle_name, nick_name

$data = array('lname' => $lname, 'fname' => $fname , 'byear' => $byear, 'bmonth' => $bmonth, 'bday' => $bday, 'auth_no_type_id' => $auth_no_type_id, 'msia_new_ic_no' => $msia_new_ic_no, 'gender' => $gender, 'nationality' => $nationality, 'permanent_residence' => $permanent_residence, 'pass' => $pass, 'alt_email' => $alt_email, 'handphone_country_code' => $handphone_country_code, 'handphone_no' => $handphone_no, 'tel_area_code' => $tel_area_code, 'tel_no' => $tel_no, 'address1' => $address1,  'postcode' => $postcode, 'country_id' => $country_id, 'state' => $state, 'city' => $city, 'msn_id' => $msn_id, 'yahoo_id' => $yahoo_id, 'icq_id' => $icq_id, 'skype_id' => $skype_id, 'datecreated' => $ATZ, 'dateupdated' => $ATZ, 'status' => 'New' , 'marital_status' => $marital_status, 'no_of_kids' => $no_of_kids, 'pregnant' => $pregnant, 'dmonth' => $dmonth, 'dday' => $dday, 'dyear' => $dyear, 'pending_visa_application' => $pending_visa_application, 'active_visa' => $active_visa , 'middle_name' => $middle_name, 'nick_name' => $nick_name);
//print_r($data);

//echo "<hr>";


$where = "userid = ".$userid;
$db->update('personal', $data, $where);

//id, userid, form, form_url, date_completed
$sql = $db->select()
	->from('applicants_form' , 'id')
	->where('userid = ?' ,$userid)
	->where('form = ?' , 1);
$id = $db->fetchOne($sql);

$data = array('userid' => $userid, 'form' => 1, 'form_url' => $_SERVER['HTTP_HOST']."/".$_POST['page'], 'date_completed' => $ATZ);
if($id){
	$where = "id = ".$id;
	$db->update('applicants_form', $data, $where);
}else{
	$db->insert('applicants_form', $data);
}

include('register-email.php');
header("Location: ../registernow-step2-working-at-home-capabilities.php");
?>



