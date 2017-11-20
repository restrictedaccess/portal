<?php 


include '../conf/zend_smarty_conf.php';

if (TEST){
	header("Location:http://test.remotestaff.com.ph/register/");
	die;
}else{
	header("Location:http://remotestaff.com.ph/register/");
	die;	
}

include './inc/home_pages_link_for_template.php';
include './inc/register-right-menu.php';
include '../lib/validEmail.php';
include 'class.php';

$smarty = new Smarty();
$img_result = ShowActiveInactiveImages(LOCATION_ID);

if(isset($_GET)){
	$code = $_GET['code'];
	$email = trim($_GET['email']); 
}
if((isset($_POST['ph_form']))&&(!isset($_SESSION['userid']))){

	$email = $_POST['email'];
		
	$data_serialized = serialize($_POST);
	
	$data = array(
		'post' => $data_serialized 
	); 
	$where = " email='".$email."' ";
	$db->update('tb_temporary_email_account', $data, $where);	

}
else{

	if(isset($_POST['email'])){
	
		$email = $_POST['email'];
	
		$sql = $db->select()
			->from('tb_temporary_email_account')
			->where('email = ?' ,$_POST['email']);
		$result = $db->fetchRow($sql);	
		
		if(isset($result['post'])){
			$_POST = unserialize($result['post']);
		}
	}
}

//track promo code
if (isset($_REQUEST["promo_code"])&&$_REQUEST["promo_code"]){
	if (!isset($_COOKIE["promo_code"])){
		$booking_code = $_REQUEST["promo_code"];
		$_SESSION["promo_code"] = $booking_code;
		setcookie("promo_code",$booking_code,2592000 + time()) ;
	}else{
		$_SESSION["promo_code"] = $_COOKIE["promo_code"];
	}
}

$error = $_REQUEST['error'];
$error_msg = $_REQUEST['error_msg'];
//echo $error_msg;
 
if($error == "True"){ 
	$email = trim($_POST['email']);
	$fname = trim($_POST['fname']);
	$lname = trim($_POST['lname']);
	$code = $_POST['code'];
	$smarty->assign('error',True);
	$smarty->assign('error_msg',$error_msg);
}else{
	$smarty->assign('error',False);
	$smarty->assign('error_msg',$error_msg);
}

$userid = $_SESSION['userid'];
if($userid!="" or $userid!=NULL){
	
	$sql=$db->select()
		->from('personal')
		->where('userid = ?' ,$userid);
	$result = $db->fetchRow($sql);	
	
	$fname = $result['fname'];
	$lname=$result['lname'];
	$email = $result['email'];

	if(isset($_POST['bmonth'])){
		$bmonth = $_POST['bmonth'];
	}
	else{
		$bmonth = $result['bmonth'];
	}
	
	if(isset($_POST['bday'])){
		$bday = $_POST['bday'];
	}
	else{
		$bday = $result['bday'];
	}
	
	if(isset($_POST['byear'])){
		$byear = $_POST['byear'];
	}
	else{
		$byear = $result['byear'];
	}
	
	if(isset($_POST['gender'])){
		$gender = $_POST['gender'];
	}
	else{
		$gender = $result['gender'];
	}

	$permanent_residence = $result['permanent_residence'];
	
	$alt_email = $result['alt_email'];
	
	$handphone_country_code = $result['handphone_country_code'];
	$handphone_no = $result['handphone_no'];
	$tel_area_code = $result['tel_area_code'];
	$tel_no = $result['tel_no'];
	$address1 = $result['address1'];
	$external_source = $result['external_source'];
	
	$postcode = $result['postcode'];
	$country_id = $result['country_id'];
	$state = $result['state'];
	$city = $result['city'];
	
	$msn_id = $result['msn_id'];
	$yahoo_id = $result['yahoo_id'];
	$icq_id = $result['icq_id'];
	$skype_id = $result['skype_id'];
	
	//TODO : new fields to be added in personal table
	$middle_name = $result['middle_name'];
	$nick_name = $result['nick_name'];
	$marital_status = $result['marital_status'];
	$no_of_kids = $result['no_of_kids'];
	$pregnant = $result['pregnant'];
	$dmonth = $result['dmonth'];
	$dday = $result['dday'];
	$dyear = $result['dyear'];
	$pending_visa_application = $result['pending_visa_application'];
	$active_visa = $result['active_visa'];
	$linked_in = $result["linked_in"];
	
	$referred_by = $result['referred_by'];
	$external_source = $result['external_source'];
	if($referred_by != ""){
		$external_source = "";
	}
	
	$nationality = $result['nationality'];

if(isset($_POST['rv']) ||isset($_POST['pass2'])){
	
	$rv = $_POST['rv'];
	$pass2 = $_POST['pass2'];

	$passGen = new passGen(5);

	if(!$passGen->verify($pass2, $rv)){
		header("Location: registernow-step1-personal-details.php?error_msg=Invalid+security+code");
		exit();
	}
} 
		
}
if($gender == "") $gender = "Male";
if(isset($_POST['fname']))$fname = $_POST['fname'];
if(isset($_POST['lname']))$lname = $_POST['lname'];
if(isset($_POST['bday']))$bday = $_POST['bday'];
if(isset($_POST['bmonth']))$bmonth = $_POST['bmonth'];
if(isset($_POST['byear']))$byear = $_POST['byear'];
if(isset($_POST['permanent_residence']))$permanent_residence = $_POST['permanent_residence'];
if(isset($_POST['nationality'])) $nationality = $_POST['nationality'];
if(isset($_POST['auth_no_type_id'])){ 
	$identification = $_POST['auth_no_type_id']; 
}
else{
	$identification = $result['auth_no_type_id']; 
}
if(isset($_POST['msia_new_ic_no'])){
	$identification_number = $_POST['msia_new_ic_no']; 
}else{
	$identification_number = $result['msia_new_ic_no']; 
}
//userid, lname, fname, byear, bmonth, bday, auth_no_type_id, msia_new_ic_no, gender, nationality, permanent_residence, email, pass, alt_email, handphone_country_code, handphone_no, tel_area_code, tel_no, address1, address2, postcode, country_id, state, city, msn_id, yahoo_id, icq_id, skype_id, image, datecreated, dateupdated, status, home_working_environment, internet_connection, isp, computer_hardware, headset_quality, payment_details, voice_path, initial_skype_password, initial_email_password

$month_array = array("Month","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
$monthOptions = '';
$dmonthOptions = '';
for($i=0; $i<count($month_array);$i++){
	if($bmonth == $i){
		$monthOptions.="<option value=".$i." selected>".$month_array[$i]."</option>";
	}else{
		$monthOptions.="<option value=".$i.">".$month_array[$i]."</option>";
	}
	
	if($dmonth == $i){
		$dmonthOptions.="<option value=".$i." selected>".$month_array[$i]."</option>";
	}else{
		$dmonthOptions.="<option value=".$i.">".$month_array[$i]."</option>";
	}
}

$dayOptions = '';
$ddayOptions = '';
for($i=1;$i<32;$i++){
	if($bday == $i){
		$dayOptions .="<option value=".$i." selected>".$i."</option>";
	}else{
		$dayOptions .="<option value=".$i.">".$i."</option>";
	}
	if($dday == $i){
		$ddayOptions .="<option value=".$i." selected>".$i."</option>";
	}else{
		$ddayOptions .="<option value=".$i.">".$i."</option>";
	}
	
}

$identification_array = array("SSS ID","TIN","Passport","Postal ID","Drivers License","PRC ID");
for($i=0; $i<count($identification_array);$i++){
	if($identification == $identification_array[$i]){
		$identificationOptions .="<option value=\"".$identification_array[$i]."\" selected>".$identification_array[$i]."</option>";
	}else{
		$identificationOptions .="<option value=\"".$identification_array[$i]."\">".$identification_array[$i]."</option>";
	}
}

$gender_array = array("Male" , "Female");
for($i=0; $i<count($gender_array);$i++){
	if($gender == $gender_array[$i]){
		$genderOptions.="<input name='gender' type='radio' value='".$gender_array[$i]."' style='width:15px;' checked='checked' /> ".$gender_array[$i];
	}else{
		$genderOptions.="<input name='gender' type='radio' value='".$gender_array[$i]."' style='width:15px;'/> ".$gender_array[$i];
	}
}


$marital_statuses = array("Single","Married","DeFacto","Its Complicated","Engaged");
for($i=0; $i<count($marital_statuses);$i++){
	if($marital_status == $marital_statuses[$i]){
		$marital_status_Options .="<option value=\"".$marital_statuses[$i]."\" selected>".$marital_statuses[$i]."</option>";
	}else{
		$marital_status_Options .="<option value=\"".$marital_statuses[$i]."\">".$marital_statuses[$i]."</option>";
	}
}

$pregnant_array= array("Yes","No","No! I'm a Male Applicant","No, but I wish I was");
for($i=0; $i<count($pregnant_array);$i++){
	if($pregnant == $pregnant_array[$i]){
		$pregnant_Options .="<option value=\"".$pregnant_array[$i]."\" selected>".$pregnant_array[$i]."</option>";
	}else{
		$pregnant_Options .="<option value=\"".$pregnant_array[$i]."\">".$pregnant_array[$i]."</option>";
	}
}




//echo $permanent_residence;

$sql = $db->select()
	->from('country'); 
$countries = $db->fetchAll($sql) or die (mysql_error());	

$countryOptions2 = "<option value=\"\">Select country</option>";
$countryOptions = "<option value=\"\">Select country</option>";
foreach($countries as $country){
	
	if($country_id == $country['iso']){
		$countryOptions2 .= "<option value=\"".$country['iso']."\" selected>".$country['printable_name']."</option>";
	}else{
		$countryOptions2 .= "<option value=\"".$country['iso']."\">".$country['printable_name']."</option>";
	}
	
	if($permanent_residence == $country['iso']){
		$countryOptions .= "<option value=\"".$country['iso']."\" selected>".$country['printable_name']."</option>";
	}else{
		$countryOptions .= "<option value=\"".$country['iso']."\">".$country['printable_name']."</option>";
	}
	
}


$sql = $db->select()

	->from('country')

	->order('printable_name');

$nationalities = $db->fetchAll($sql);	


//$nationalities = explode("," ,$nationalities);
$nationalityOptions .= "<option value=\"\" selected>Select nationality</option>";
foreach($nationalities as $nationality_option){
	if($nationality == $nationality_option['printable_name']){
		$nationalityOptions .= "<option value=\"".$nationality_option['printable_name']."\" selected>".$nationality_option['printable_name']."</option>";
	}else{
		$nationalityOptions .= "<option value=\"".$nationality_option['printable_name']."\">".$nationality_option['printable_name']."</option>";
	}
}

if($country=='Philippines'){
	//Philippines States
	$ph_states_array=array('Armm','Bicol Region','C.A.R.','Cagayan Valley','Central Luzon','Central Mindanao','Caraga','Central Visayas','Eastern Visayas','Ilocos Region','National Capital Reg','Northern Mindanao','Southern Mindanao','Southern Tagalog','Western Mindanao','Western Visayas');
	for($i=0; $i<count($ph_states_array); $i++){
		if($state == $ph_states_array[$i]){
			$ph_state_options .= "<option value=\"".$ph_states_array[$i]."\" selected>".$ph_states_array[$i]."</option>";
		}else{
			$ph_state_options .= "<option value=\"".$ph_states_array[$i]."\">".$ph_states_array[$i]."</option>";
		}
	}
}

$yes_no =  array("Yes", "No");
for($i=0; $i<count($yes_no); $i++){
	//Do you have pending Visa application ?
	if($pending_visa_application == $yes_no[$i]){
		$pending_visa_application_Options.="<input name='pending_visa_application' type='radio' value='".$yes_no[$i]."' style='width:15px;' checked='checked' /> ".$yes_no[$i];
	}else{
		$pending_visa_application_Options.="<input name='pending_visa_application' type='radio' value='".$yes_no[$i]."' style='width:15px;'/> ".$yes_no[$i];
	}
	
	//Do you have active Visa�s for US, Australia, UK, Dubai ?
	if($active_visa == $yes_no[$i]){
		$active_visa_Options.="<input name='active_visa' type='radio' value='".$yes_no[$i]."' style='width:15px;' checked='checked' /> ".$yes_no[$i];
	}else{
		$active_visa_Options.="<input name='active_visa' type='radio' value='".$yes_no[$i]."' style='width:15px;'/> ".$yes_no[$i];
	}
	
	 
}

$referred_by_array = array('Contacted by Remotestaff','Facebook','Twitter','Google','JobStreet','JobsDB', 'Friend','Linkedin','Bestjobs.ph','Others');
$referredByOptions = "<option> Select </option>"; 
for($i=0; $i<count($referred_by_array);$i++){
	
	
	if($external_source == $referred_by_array[$i]){
		$referredByOptions .= "<option value='".$referred_by_array[$i]."' selected>".$referred_by_array[$i]."</option>";
	}else{
		$referredByOptions .= "<option value='".$referred_by_array[$i]."'>".$referred_by_array[$i]."</option>";
		
		if(($external_source != '')&&(!in_array($external_source,$referred_by_array))&&($referred_by_array[$i] == 'Others')){
			$referredByOptions .= "<option value='".$referred_by_array[$i]."' selected >".$referred_by_array[$i]."</option>";
		}
	}
	
}

//check if the applicant is tied up with a recruiter
$answers = array("Yes", "No");
if ($_SESSION["userid"]){
	$sql = $db->select()->from("recruiter_staff", array("recruiter_staff.admin_id AS admin_id"))
			->joinInner("admin", "admin.admin_id = recruiter_staff.admin_id", array("CONCAT(admin.admin_fname, ' ', admin.admin_lname) AS client"))
			->where("recruiter_staff.userid = ?",$userid);
	$data = $db->fetchRow($sql);
}

$select = "SELECT admin_id,admin_fname,admin_lname 	 
		FROM `admin`
		where (status='HR' 
		OR admin_id='41' 
		OR admin_id='71'
		OR admin_id='78'
		OR admin_id='81')  
		AND status <> 'REMOVED' AND admin_id <> '161'  
		order by admin_fname";

$recruiters = $db->fetchAll($select);
$recruiterYesNo = "";
$recruiterOption = "";
if ($data){
	$recruiterYesNo .= "<option value='Yes' selected>Yes</option>";
	$recruiterYesNo .= "<option value='No'>No</option>";
	foreach($recruiters as $recruiter){
		if ($recruiter["admin_id"]==$data["admin_id"]){
			$recruiterOption.="<option value='{$recruiter["admin_id"]}' selected>{$recruiter["admin_fname"]} {$recruiter["admin_lname"]}</option>";	
		}else{
			$recruiterOption.="<option value='{$recruiter["admin_id"]}'>{$recruiter["admin_fname"]} {$recruiter["admin_lname"]}</option>";
		}	
	}
}else{
	$recruiterYesNo .= "<option value='Yes'>Yes</option>";
	$recruiterYesNo .= "<option value='No' selected >No</option>";
	foreach($recruiters as $recruiter){
		$recruiterOption.="<option value='{$recruiter["admin_id"]}'>{$recruiter["admin_fname"]} {$recruiter["admin_lname"]}</option>";
	}
}


//check if this form has already saved in the applicants_form
if($userid!=""){
	$sql = $db->select()
		->from('applicants_form')
		->where('userid = ?' ,$userid)
		->where('form = ?' , 1);
	$result = $db->fetchRow($sql);
	$form_id = $result['id'];
	$date_completed = $result['date_completed'];
	if($date_completed == "") {
		$status = "Not yet filled up";
	}else{
		$status = "Completed ".$date_completed;
	}	
	$smarty->assign('form_id',$form_id);
	
	$welcome = sprintf("Welcome ID%s %s %s<br>Step 1 Form status : %s " ,$userid ,$fname, $lname , $status);
	$smarty->assign('welcome',$welcome);
	
}

$passGen = new passGen(5);	 
$rv = $passGen->password(0, 1);
$_SESSION["captcha_text"] = $rv;
$rv_image = $passGen->images('./font', 'gif', 'f_', '20', '20');
$smarty->assign('rv' , $rv);
$smarty->assign('rv_image',$rv_image);

$right_menus = RightMenus(1 , $userid);

$smarty->assign('page' , basename($_SERVER['SCRIPT_FILENAME']));
$smarty->assign('userid' , $userid);
$smarty->assign('img_result',$img_result);
$smarty->assign('right_menus' , $right_menus);
$smarty->assign("recruiterYesNo", $recruiterYesNo);
$smarty->assign("recruiterOption", $recruiterOption);
$smarty->assign('code',$code);
$smarty->assign('email',$email);
$smarty->assign('fname',$fname);
$smarty->assign('lname',$lname);
$smarty->assign('middle_name',$middle_name);
$smarty->assign('nick_name',$nick_name);

$smarty->assign('monthOptions',$monthOptions);
$smarty->assign('dmonthOptions',$dmonthOptions);
$smarty->assign('dayOptions',$dayOptions);
$smarty->assign('ddayOptions',$ddayOptions);
$smarty->assign('byear',$byear);

$smarty->assign('identificationOptions',$identificationOptions);
$smarty->assign('identification_number',$identification_number);
$smarty->assign('genderOptions',$genderOptions);
$smarty->assign('marital_status_Options',$marital_status_Options);
$smarty->assign('no_of_kids',$no_of_kids);
$smarty->assign('pregnant_Options',$pregnant_Options);
$smarty->assign('nationalityOptions',$nationalityOptions);
$smarty->assign('countryOptions',$countryOptions);
$smarty->assign('countryOptions2',$countryOptions2);

$smarty->assign('pending_visa_application_Options',$pending_visa_application_Options);
$smarty->assign('active_visa_Options',$active_visa_Options);
$smarty->assign('referredByOptions',$referredByOptions);


$smarty->assign('alt_email',$alt_email);
$smarty->assign('handphone_country_code',$handphone_country_code);
$smarty->assign('handphone_no',$handphone_no);
$smarty->assign('tel_area_code',$tel_area_code);
$smarty->assign('tel_no',$tel_no);
$smarty->assign('address1' , $address1);

$smarty->assign('postcode' , $postcode);
$smarty->assign('state' , $state);
$smarty->assign('city' , $city);

$smarty->assign('msn_id' , $msn_id);
$smarty->assign('yahoo_id' , $yahoo_id);
$smarty->assign('icq_id' , $icq_id);
$smarty->assign('skype_id' , $skype_id);
$smarty->assign("linked_in", $linked_in);

$smarty->assign('referred_by' , $referred_by); 
$smarty->assign('external_source' , $external_source);

if(($external_source != '')&&(!in_array($external_source,$referred_by_array))){
	$display_others = "block";
}
else{
	$display_others = "none";
}
$smarty->assign('display_others' , $display_others);

$smarty->assign("TEST", TEST);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");
$smarty->display('registernow-step1-personal-details.tpl');

?>

