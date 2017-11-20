<?php 
include('conf/zend_smarty_conf.php');
include('inc/home_pages_link_for_template.php');
include ("inc/register-right-menu.php");
include './portal/lib/validEmail.php';
$smarty = new Smarty();
$img_result = ShowActiveInactiveImages(LOCATION_ID);


$error = $_REQUEST['error'];
$error_msg = $_REQUEST['error_msg'];
if($error == "") $error = False;
if($error == "True"){ 
	$email = trim($_POST['email']);
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
		->from('education')
		->where('userid = ?' ,$userid);
	$result = $db->fetchRow($sql);	
	
	$trainings_seminars=$result['trainings_seminars'];
	$educationallevel=$result['educationallevel'];
	$fieldstudy=$result['fieldstudy'];
	$major=$result['major'];
	$grade=$result['grade'];
	$gpascore=$result['gpascore'];
	$college_name=$result['college_name'];
	$college_country=$result['college_country'];
	$graduate_month=$result['graduate_month'];
	$graduate_year=$result['graduate_year'];
		
}



//check if this form has already saved in the applicants_form
if($userid!=""){
	$sql = $db->select()
		->from('applicants_form')
		->where('userid = ?' ,$userid)
		->where('form = ?' , 3);
	$result = $db->fetchRow($sql);
	$form_id = $result['id'];
	$date_completed = $result['date_completed'];
	if($date_completed == "") {
		$status = "Not yet filled up";
	}else{
		$status = "Completed ".$date_completed;
	}	
	$smarty->assign('form_id',$form_id);
	
	$welcome = sprintf("Welcome ID%s %s %s<br>Step 3 Form status : %s " ,$userid ,$fname, $lname , $status);
	$smarty->assign('welcome',$welcome);
	
}

$levels_array = array("High School Diploma","Vocational Diploma / Short Course Certificate","Bachelors/College Degree","Post Graduate Diploma / Master Degree","Post Graduate Diploma / Master Degree","Professional License (Passed Board/Bar/Professional License Exam)","Doctorate Degree","Others");
$highest_level_options="<option value=\"\" >-</option>";
for($i=0; $i<count($levels_array);$i++){
	if($educationallevel == $levels_array[$i]){
		$highest_level_options.="<option value=\"".$levels_array[$i]."\" selected=\"true\" >".$levels_array[$i]."</option>"; 
	}else{
		$highest_level_options.="<option value=\"".$levels_array[$i]."\">".$levels_array[$i]."</option>";
	}
}


$fields_array=array("Advertising/Media","Agriculture/Aquaculture/Forestry","Airline Operation/Airport Management","Architecture","Art/Design/Creative Multimedia","Biology","BioTechnology","Business Studies/Administration/Management","Chemistry","Commerce","Computer Science/Information Technology","Dentistry","Economics","Education/Teaching/Training","Engineering (Aviation/Aeronautics/Astronautics)","Engineering (Bioengineering/Biomedical)","Engineering (Chemical)","Engineering (Civil)","Engineering (Computer/Telecommunication)","Engineering (Electrical/Electronic)","Engineering (Environmental/Health/Safety)","Engineering (Industrial)","Engineering (Marine)","Engineering (Material Science)","Engineering (Mechanical)","Engineering (Mechatronic/Electromechanical)","Engineering (Metal Fabrication/Tool & Die/Welding)","Engineering (Mining/Mineral)","Engineering (Others)","Engineering (Petroleum/Oil/Gas)","Finance/Accountancy/Banking","Food & Beverage Services Management","Food Technology/Nutrition/Dietetics","Geographical Science","Geology/Geophysics","History","Hospitality/Tourism/Hotel Management","Human Resource Management","Humanities/Liberal Arts","Journalism","Law","Library Management","Linguistics/Languages","Logistic/Transportation","Maritime Studies","Marketing","Mass Communications","Mathematics","Medical Science","Medicine","Music/Performing Arts Studies","Nursing","Optometry","Others","Personal Services","Pharmacy/Pharmacology","Philosophy","Physical Therapy/Physiotherapy","Physics","Political Science","Property Development/Real Estate Management","Protective Services & Management","Psychology","Quantity Survey","Science & Technology","Secretarial","Social Science/Sociology","Sports Science & Management","Textile/Fashion Design","Urban Studies/Town Planning","Veterinary");
$field_of_study_options="<option value=\"\" >-</option>";
for($i=0; $i<count($fields_array);$i++){
	if($fieldstudy == $fields_array[$i]){
		$field_of_study_options.="<option value=\"".$fields_array[$i]."\" selected=\"true\" >".$fields_array[$i]."</option>"; 
	}else{
		$field_of_study_options.="<option value=\"".$fields_array[$i]."\">".$fields_array[$i]."</option>";
	}
}

$grade_array=array("Grade Point Average (GPA)","Incomplete");
$grade_options="";
for($i=0; $i<count($grade_array);$i++){
	if($grade == $grade_array[$i]){
		$grade_options.="<option value=\"".$grade_array[$i]."\" selected=\"true\" >".$grade_array[$i]."</option>"; 
	}else{
		$grade_options.="<option value=\"".$grade_array[$i]."\">".$grade_array[$i]."</option>";
	}
}

$college_location_array=array("Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Ascension Island","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia-Herzegovina","Botswana","Bouvet Island","Brazil","British Indian O. Terr.","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Rep.","Chad","Chile","China","Christmas Island","Cocos (Keeling) Isl.","Colombia","Comoros","Congo","Cook Islands","Costa Rica","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Diego Garcia","Djibouti","Dominica","Dominican Republic","East Timor","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Isl. (Malvinas)","Faroe Islands","Fiji","Finland","France","France (European Ter.)","French Southern Terr.","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Great Britain (UK)","Greece","Greenland","Grenada","Guadeloupe (Fr.)","Guam (US)","Guatemala","Guinea","Guinea Bissau","Guyana","Guyana (Fr.)","Haiti","Heard &amp; McDonald Isl.","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Ivory Coast","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea (North)","Korea (South)","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia (former Yugo.)","Madagascar (Republic of)","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique (Fr.)","Mauritania","Mauritius","Mayotte","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherland Antilles","Netherlands","New Caledonia (Fr.)","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","Northern Mariana Isl.","Norway","Oman","Pakistan","Palau","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Polynesia (Fr.)","Portugal","Puerto Rico (US)","Qatar","Reunion (Fr.)","Romania","Russian Federation","Rwanda","Saint Lucia","Samoa","San Marino","Saudi Arabia","Senegal","Seychelles","Sierra Leone","Singapore","Slovakia (Slovak Rep)","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia  and  South Sand","Spain","Sri Lanka","St. Helena","St. Pierre &amp; Miquelon","St. Tome and Principe","St.Kitts Nevis Anguilla","St.Vincent &amp; Grenadines","Sudan","Suriname","Svalbard &amp; Jan Mayen Is","Swaziland","Sweden","Switzerland","Syria","Tadjikistan","Taiwan","Tanzania","Thailand","Togo","Tokelau","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","US Minor outlying Isl.","Uzbekistan","Vanuatu","Vatican City State","Venezuela","Vietnam","Virgin Islands (British)","Virgin Islands (US)","Wallis &amp; Futuna Islands","Western Sahara","Yemen","Yugoslavia","Zaire","Zambia","Zimbabwe");
$$university_location_options="<option value=\"\" >-</option>";
for($i=0; $i<count($college_location_array);$i++){
	if($college_country == $college_location_array[$i]){
		$university_location_options.="<option value=\"".$college_location_array[$i]."\" selected=\"true\" >".$college_location_array[$i]."</option>"; 
	}else{
		$university_location_options.="<option value=\"".$college_location_array[$i]."\">".$college_location_array[$i]."</option>";
	}
}

$month_array = array("Month","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
$month_options="<option value=\"\">-</option>";
for($i=0; $i<count($month_array);$i++){
	if($graduate_month == $i){
		$month_options.="<option value=\"".$i."\" selected=\"true\" >".$month_array[$i]."</option>"; 
	}else{
		$month_options.="<option value=\"".$i."\">".$month_array[$i]."</option>";
	}
}


//right menus
$right_menus = RightMenus(3 , $userid);
$smarty->assign('right_menus' , $right_menus);

$smarty->assign('page' , basename($_SERVER['SCRIPT_FILENAME']));
$smarty->assign('userid' , $userid);
$smarty->assign('img_result',$img_result);
$smarty->assign('code',$code);
$smarty->assign('email',$email);


$smarty->assign('trainings_seminars' , $trainings_seminars);   
$smarty->assign('educationallevel' , $educationallevel);
$smarty->assign('highest_level_options' , $highest_level_options); 
$smarty->assign('fieldstudy' , $fieldstudy);
$smarty->assign('field_of_study_options' , $field_of_study_options);
$smarty->assign('others' , $others);
$smarty->assign('major' , $major);
$smarty->assign('grade_options' , $grade_options);
$smarty->assign('gpascore' , $gpascore);
$smarty->assign('college_name' , $college_name);
$smarty->assign('university_location_options' , $university_location_options);
$smarty->assign('month_options' , $month_options);
$smarty->assign('graduate_year' , $graduate_year);


header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");
$smarty->display('registernow-step3-educational-details.tpl');



?>
