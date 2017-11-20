<?php
//2010-07-19 Normaneil Macutay <normanm@remotestaff.com.au>
// - removed the nationality field

include '../../conf/zend_smarty_conf.php';
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

$linked_in = $_POST["linked_in"];


$external_source = $_POST['external_source'];
if($_POST['external_source']=='Others'){
	$external_source = $_POST['external_source_others'];
}else if ($_POST["external_source"]=="Select"){
	$external_source = "";
}
$referred_by = $_POST['referred_by'];



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

$data = array('lname' => $lname, 'fname' => $fname , 'byear' => $byear, 'bmonth' => $bmonth, 'bday' => $bday, 'auth_no_type_id' => $auth_no_type_id, 'msia_new_ic_no' => $msia_new_ic_no, 'gender' => $gender, 'nationality' => $nationality, 'permanent_residence' => $permanent_residence, 'pass' => $pass, 'alt_email' => $alt_email, 'handphone_country_code' => $handphone_country_code, 'handphone_no' => $handphone_no, 'tel_area_code' => $tel_area_code, 'tel_no' => $tel_no, 'address1' => $address1,  'postcode' => $postcode, 'country_id' => $country_id, 'state' => $state, 'city' => $city, 'msn_id' => $msn_id, 'yahoo_id' => $yahoo_id, 'icq_id' => $icq_id, 'skype_id' => $skype_id, 'datecreated' => $ATZ, 'dateupdated' => $ATZ, 'status' => 'New' , 'marital_status' => $marital_status, 'no_of_kids' => $no_of_kids, 'pregnant' => $pregnant, 'dmonth' => $dmonth, 'dday' => $dday, 'dyear' => $dyear, 'pending_visa_application' => $pending_visa_application, 'active_visa' => $active_visa , 'middle_name' => $middle_name, 'nick_name' => $nick_name, 'external_source' => $external_source, 'referred_by' => $referred_by, "linked_in"=>$linked_in);
//print_r($data);
 
//echo "<hr>"; 
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
			}else{
				$db->update("referrals", $referral, $db->quoteInto("id = ?", $refer["id"]));
			}
		}
		
	}
	
}

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

$datetime = date("Y-m-d")." ".date("H:i:s");
$sql = $db->select()
	->from('unprocessed_staff')
	->where('userid =?' , $_SESSION['userid']);
$result = $db->fetchRow($sql);

if(isset($result['id'])){
	$data = array(
		'date' => $datetime
	);
	$where = "userid = ".$_SESSION['userid'];	
	$db->update('unprocessed_staff' , $data , $where);	
}
else{
	$data = array(
		'userid' => $_SESSION['userid'],
		'admin_id' => 54, 
		'date' => $datetime
	);
	$db->insert('unprocessed_staff', $data);
}

//update recruiter assigned staff
$recruiterYesNo = $_POST["have_you_spoken"];
$db->delete("recruiter_staff", "userid = {$userid}");

if ($recruiterYesNo=="Yes"){
	$data = array("admin_id"=>$_POST["recruiter"], "userid"=>$userid, "date"=>date("Y-m-d h:i:s"), "auto_assigned_from_admin"=>1);
	$db->insert("recruiter_staff", $data);			
}

//send autoresponder to referee when referral registers as job seeker
$personal = $db->fetchRow($db->select()->from("personal", array("userid", "email"))->where("userid = ?", $_SESSION["userid"]));
if ($personal){
	$referral = $db->fetchRow($db->select()->from(array("r"=>"referrals"), array("r.firstname AS referral_fname", "r.lastname AS referral_lname", "r.id AS referral_id"))
								->joinInner(array("p"=>"personal"), "p.userid = r.user_id", array("p.fname AS referee_fname", "p.lname AS referee_lname", "p.email AS referee_email"))
								->where("r.email = ?", $personal["email"]));
	if ($referral){
		$db->update("referrals", array("jobseeker_id"=>$_SESSION["userid"]), $db->quoteInto("id = ?", $referral["referral_id"]));
		$emailSmarty = new Smarty();
		$emailSmarty->assign("referral_name", $referral["referral_fname"]." ".$referral["referral_lname"]);
		$emailSmarty->assign("referee_name", $referral["referee_fname"]." ".$referral["referee_lname"]);
		$emailTemplate = $emailSmarty->fetch("referral_created_jobseeker.tpl");			
		$mail = new Zend_Mail();
		$mail->setBodyHtml($emailTemplate);
		if (TEST){
			$mail->setSubject("TEST - Updates on your referral at Remotestaff");
		}else{
			$mail->setSubject("Updates on your referral at Remotestaff");
		}
		$mail->setFrom("recruitment@remotestaff.com.au");
		if (TEST){
			$mail->addTo("devs@remotestaff.com.au");
		}else{
			$mail->addTo($referral["referee_email"]);						
		}
		$mail->send($transport);
	}					
}
				
include('register-email.php');
//send skill test autoresponder
if ($personal){
	require_once dirname(__FILE__)."/../../application/classes/SkillTestEmail.php";
	$test = new SkillTestEmail($db);
	$test->sendEmail("recruitment@remotestaff.com.au", $personal["email"]);	
}



header("Location: ../registernow-step2-working-at-home-capabilities.php"); 
?> 



