<?php 
//hardcoded


$link=mysql_connect ("localhost","remotestaff","remote8eicar8");
if(!$link){die("Could not connect to MySQL");}
mysql_select_db("remotestaff",$link) or die ("could not open db".mysql_error());

include('conf/zend_smarty_conf.php');
include('inc/home_pages_link_for_template.php');
include ("inc/register-right-menu.php");
include 'portal/lib/validEmail.php';
$smarty = new Smarty();
$img_result = ShowActiveInactiveImages(LOCATION_ID);


$code = $_GET['code'];
$email = $_GET['email'];
$fname = $_GET['fname'];
$lname = $_GET['lname'];

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

$userid=$_SESSION['userid'];
if($userid!="" or $userid!=NULL){
	
	$sql=$db->select()
		->from('personal')
		->where('userid = ?' ,$userid);
	$result = $db->fetchRow($sql);	
	$fname = $result['fname'];
	$lname=$result['lname'];
	$email = $result['email'];
	
	$bmonth= $result['bmonth'];
	$bday= $result['bday'];
	$byear= $result['byear'];
	$gender =$result['gender'];
	$nationality = $result['nationality'];
	$identification = $result['auth_no_type_id'];
	$identification_number = $result['msia_new_ic_no'];
	$permanent_residence = $result['permanent_residence'];
	
	$alt_email = $result['alt_email'];
	
	$handphone_country_code = $result['handphone_country_code'];
	$handphone_no = $result['handphone_no'];
	$tel_area_code = $result['tel_area_code'];
	$tel_no = $result['tel_no'];
	$address1 = $result['address1'];
	
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
	
		
}
if($gender == "") $gender = "Male";
if($permanent_residence == "") $permanent_residence = "PH"; 
if($nationality == "") $nationality = "Filipino";
if($country_id == "") $country_id = "PH";
//userid, lname, fname, byear, bmonth, bday, auth_no_type_id, msia_new_ic_no, gender, nationality, permanent_residence, email, pass, alt_email, handphone_country_code, handphone_no, tel_area_code, tel_no, address1, address2, postcode, country_id, state, city, msn_id, yahoo_id, icq_id, skype_id, image, datecreated, dateupdated, status, home_working_environment, internet_connection, isp, computer_hardware, headset_quality, payment_details, voice_path, initial_skype_password, initial_email_password

$month_array = array("Month","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
for($i=0; $i<count($month_array);$i++){
	if($bmonth == $month_array[$i]){
		$monthOptions.="<option value=".$i." selected>".$month_array[$i]."</option>";
	}else{
		$monthOptions.="<option value=".$i.">".$month_array[$i]."</option>";
	}
}

for($i=1;$i<32;$i++){
	if($bday == $i){
		$dayOptions .="<option value=".$i." selected>".$i."</option>";
	}else{
		$dayOptions .="<option value=".$i.">".$i."</option>";
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


/*
//http://www.englishclub.com/vocabulary/world-countries-nationality.htm
$countries = array("Afghanistan","Albania","Algeria","Andorra","Angola","Argentina","Armenia","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bhutan","Bolivia","Bosnia-Herzegovina","Botswana","Brazil","Britain","Brunei","Bulgaria","Burkina","Burma","Burundi","Cambodia","Cameroon","Canada","Cape Verde Islands","Chad","Chile","China","Colombia","Congo","Costa Rica","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","England");


$nationalities = array("Afghan","Albanian","Algerian","Andorran","Angolan","Argentinian","Armenian","Australian","Austrian","Azerbaijani","Bahamian","Bahraini","Bangladeshi","Barbadian","Belorussian or Byelorussian","Belgian","Belizian","Beninese","Bhutanese","Bolivian","Bosnian","Botswanan","Brazilian","British","Bruneian","Bulgarian","Burkinese","Burmese","Burundian","Cambodian","Cameroonian","Canadian","Cape Verdean","Chadian","Chilean","Chinese","Colombian","Congolese","Costa Rican","Croat or Croatian","Cuban","Cypriot","Czech","Danish","Djiboutian","Dominican","Dominican","Ecuadorean","Egyptian","Salvadorean","English");
*/

$nationalities = "Afghan,Albanian,Algerian,American,Andorran,Angolan,Antiguans,Argentinean,Armenian,Australian,Austrian,Azerbaijani,Bahamian,Bahraini,Bangladeshi,Barbadian,Barbudans,Batswana,Belarusian,Belgian,Belizean,Beninese,Bhutanese,Bolivian,Bosnian,Brazilian,British,Bruneian,Bulgarian,Burkinabe,Burmese,Burundian,Cambodian,Cameroonian,Canadian,Cape Verdean,Central African,Chadian,Chilean,Chinese,Colombian,Comoran,Congolese,Congolese,Costa Rican,Croatian,Cuban,Cypriot,Czech,Danish,Djibouti,Dominican,Dominican,Dutch,Dutchman,Dutchwoman,East Timorese,Ecuadorean,Egyptian,Emirian,Equatorial Guinean,Eritrean,Estonian,Ethiopian,Fijian,Filipino,Finnish,French,Gabonese,Gambian,Georgian,German,Ghanaian,Greek,Grenadian,Guatemalan,Guinea-Bissauan,Guinean,Guyanese,Haitian,Herzegovinian,Honduran,Hungarian,I-Kiribati,Icelander,Indian,Indonesian,Iranian,Iraqi,Irish,Irish,Israeli,Italian,Ivorian,Jamaican,Japanese,Jordanian,Kazakhstani,Kenyan,Kittian and Nevisian,Kuwaiti,Kyrgyz,Laotian,Latvian,Lebanese,Liberian,Libyan,Liechtensteiner,Lithuanian,Luxembourger,Macedonian,Malagasy,Malawian,Malaysian,Maldivan,Malian,Maltese,Marshallese,Mauritanian,Mauritian,Mexican,Micronesian,Moldovan,Monacan,Mongolian,Moroccan,Mosotho,Motswana,Mozambican,Namibian,Nauruan,Nepalese,Netherlander,New Zealander,Ni-Vanuatu,Nicaraguan,Nigerian,Nigerien,North Korean,Northern Irish,Norwegian,Omani,Pakistani,Palauan,Panamanian,Papua New Guinean,Paraguayan,Peruvian,Polish,Portuguese,Qatari,Romanian,Russian,Rwandan,Saint Lucian,Salvadoran,Samoan,San Marinese,Sao Tomean,Saudi,Scottish,Senegalese,Serbian,Seychellois,Sierra Leonean,Singaporean,Slovakian,Slovenian,Solomon Islander,Somali,South African,South Korean,Spanish,Sri Lankan,Sudanese,Surinamer,Swazi,Swedish,Swiss,Syrian,Taiwanese,Tajik,Tanzanian,Thai,Togolese,Tongan,Trinidadian or Tobagonian,Tunisian,Turkish,Tuvaluan,Ugandan,Ukrainian,Uruguayan,Uzbekistani,Venezuelan,Vietnamese,Welsh,Welsh,Yemenite,Zambian,Zimbabwean";


$nationalities = explode("," ,$nationalities);
for($i=0; $i<count($nationalities); $i++){
	if($nationality == $nationalities[$i]){
		$nationalityOptions .= "<option value=\"".$nationalities[$i]."\" selected>".$nationalities[$i]."</option>";
	}else{
		$nationalityOptions .= "<option value=\"".$nationalities[$i]."\">".$nationalities[$i]."</option>";
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
	
	//Do you have active Visa’s for US, Australia, UK, Dubai ?
	if($active_visa == $yes_no[$i]){
		$active_visa_Options.="<input name='active_visa' type='radio' value='".$yes_no[$i]."' style='width:15px;' checked='checked' /> ".$yes_no[$i];
	}else{
		$active_visa_Options.="<input name='active_visa' type='radio' value='".$yes_no[$i]."' style='width:15px;'/> ".$yes_no[$i];
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

$right_menus = RightMenus(1 , $userid);

$smarty->assign('page' , basename($_SERVER['SCRIPT_FILENAME']));
$smarty->assign('userid' , $userid);
$smarty->assign('img_result',$img_result);
$smarty->assign('right_menus' , $right_menus);

$smarty->assign('code',$code);
$smarty->assign('email',$email);
$smarty->assign('fname',$fname);
$smarty->assign('lname',$lname);
$smarty->assign('middle_name',$middle_name);
$smarty->assign('nick_name',$nick_name);

$smarty->assign('monthOptions',$monthOptions);
$smarty->assign('dayOptions',$dayOptions);
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


header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");
$smarty->display('registernow-step1-personal-details.tpl');

?>

