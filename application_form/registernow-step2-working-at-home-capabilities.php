<?php 
include '../conf/zend_smarty_conf.php';
include './inc/home_pages_link_for_template.php';
include './inc/register-right-menu.php';
include '../lib/validEmail.php';

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
		->from('personal')
		->where('userid = ?' ,$userid);
	$result = $db->fetchRow($sql);		
	
	//TODO EXTRA FIELDS
	$work_from_home_before = $result['work_from_home_before'];
	$start_worked_from_home=$result['start_worked_from_home'];
	$date=explode("and",$start_worked_from_home);
	//print_r($date);
	$start_worked_from_home_year = trim(str_replace('years','',$date[0]));
	$start_worked_from_home_month = trim(str_replace('months','',$date[1]));
	
	
	$have_a_baby_in_the_house = $result['has_baby'];
	$who_is_the_main_caregiver = $result['main_caregiver'];
	$why_do_you_want_to_work_from_home = $result['reason_to_wfh'];
	$how_long_do_you_see_yourself_working_for_rs = $result['timespan'];
	$internet_connection_others = $result['internet_connection_others'];
	$internet_plan = $result['internet_connection'];
	$speed_test_result_link = $result['speed_test'];
	$internet_consequences = $result['internet_consequences'];
	$internet_connection=$result['isp'];
	$home_working_environment=$result['home_working_environment'];
	$computer_hardware=$result['computer_hardware'];
	
	$tools=explode("\n",$computer_hardware);
	$desktop=str_replace("desktop ","",$tools[0]);
	if($desktop!=""){
		$desktop_computer="yes";
		$desktop_specs=explode(",",$desktop);
		$desktop_os=$desktop_specs[1];
		$desktop_processor=$desktop_specs[2];
		$desktop_ram=$desktop_specs[3];
	}
	
	$laptop=str_replace("laptop ","",$tools[1]);
	if($laptop!=""){
		$laptop_computer="yes";
		$laptop_specs=explode(",",$laptop);
		$laptop_os=$laptop_specs[1];
		$laptop_processor=$laptop_specs[2];
		$laptop_ram=$laptop_specs[3];
	}
	
	$headset = $tools[2];
	$headphone = $tools[3];
	$printer = $tools[4];
	$scanner = $tools[5];
	$tablet = $tools[6];
	$pen_tablet = $tools[7];
	$noise_levels = array();
	$noise_levels=explode(',',$result['noise_level']);
}

$noise_levels_array = array('quiet/no noise','tricycles','general car traffic','dog/rooster/chicken','children' ,'family members in-house','street vendors','planes','surrounding construction/home renovations');

if($noise_levels != null){
	for($i=0; $i<count($noise_levels_array); $i++){
		$checked = '';
		if(in_array($noise_levels_array[$i],$noise_levels)){
			$checked = 'checked';
		}
		$noise_level_Options .="<input type=\"checkbox\" ".$checked." name=\"noise_level[]\" value=\"".$noise_levels_array[$i]."\"/>".$noise_levels_array[$i]."<br />";
	}
}

//$loptop_checked
if($laptop_computer != ''){
	if($laptop_computer == 'yes'){
		$laptop_checked = 'checked';
	}
}

//desktop_checked
if($desktop_computer != ''){
	if($desktop_computer == 'yes'){
		$desktop_checked = 'checked';
	}
}

$operating_systems = array("Windows XP" , "Windows Vista" ,"Windows 7" , "Linux");
for($i=0; $i<count($operating_systems); $i++){
	//desktop
	if($desktop_os == $operating_systems[$i]){
		$desktop_os_Options .= "<option value=\"".$operating_systems[$i]."\" selected>".$operating_systems[$i]."</option>";
	}else{
		$desktop_os_Options .= "<option value=\"".$operating_systems[$i]."\">".$operating_systems[$i]."</option>";
	}
	//loptop
	if($laptop_os == $operating_systems[$i]){
		$laptop_os_Options .= "<option value=\"".$operating_systems[$i]."\" selected>".$operating_systems[$i]."</option>";
	}else{
		$laptop_os_Options .= "<option value=\"".$operating_systems[$i]."\" >".$operating_systems[$i]."</option>";
	}
}






//
if($work_from_home_before!=""){
	if($work_from_home_before == 1){
		$smarty->assign('work_from_home_before_yes' , 'checked');
	}else{
		$smarty->assign('work_from_home_before_no' , 'checked');
	}
}

$monthOptions="<option >Months</option>"; 
for($i=0; $i<12;$i++){
	if($start_worked_from_home_month == $i){
		$monthOptions.="<option value=\"".$i."\" selected=\"true\" >".$i."</option>"; 
	}else{
		$monthOptions.="<option value=\"".$i."\">".$i."</option>";
	}
}

$yearOptions="<option >Year</option>"; 
for($i=0; $i<=15;$i++){
	if($start_worked_from_home_year == $i){
		$yearOptions.="<option value=\"".$i."\" selected=\"true\" >".$i."</option>"; 
	}else{
		$yearOptions.="<option value=\"".$i."\">".$i."</option>";
	}
}




$yes_no =  array(array('1' , 'Yes'), array('0' , 'No'));
for($i=0; $i<count($yes_no); $i++){
	//Do  you have a baby in the house ?
	if($have_a_baby_in_the_house == $yes_no[$i][0]){
		$have_a_baby_in_the_house_Options.="<input name='have_a_baby_in_the_house'  type='radio' value='".$yes_no[$i][0]."' style='width:15px;' checked='checked' /> ".$yes_no[$i][1];
	}else{
		$have_a_baby_in_the_house_Options.="<input name='have_a_baby_in_the_house' type='radio' value='".$yes_no[$i][0]."' style='width:15px;'/> ".$yes_no[$i][1];
	}
}

$timespan = array("1 month" , "3 months" , "6 months" , "9 months" , "1 year" , "2 years" , "as long as possible");
for($i=0; $i<count($timespan); $i++){
	if($how_long_do_you_see_yourself_working_for_rs == $timespan[$i]){
		$timespan_Options .= "<option value=\"".$timespan[$i]."\" selected>".$timespan[$i]."</option>";
	}else{
		$timespan_Options .= "<option value=\"".$timespan[$i]."\">".$timespan[$i]."</option>";
	}
}


//home_working_environment
$home_working_environments = array("private room", "shared room" ,"living room");
$home_working_environments2 = array("Private Room", "Shared Room" ,"Living Room");
for($i=0; $i<count($home_working_environments); $i++){
	//Do  you have a baby in the house ?
	if($home_working_environment == $home_working_environments[$i]){
		$home_working_environment_Options.="<input name='home_working_environment' id='home_working_environment' type='radio' value='".$home_working_environments[$i]."' style='width:15px;' checked='checked' /> ".$home_working_environments2[$i];
	}else{
		$home_working_environment_Options.="<input name='home_working_environment' id='home_working_environment' type='radio' value='".$home_working_environments[$i]."' style='width:15px;'/> ".$home_working_environments2[$i];
	}
}

//internet_connection
$internet_connections = array("PLDT MyDSL" , "PLDT WeRoam Wireless" , "BayanTel DSL" , "Globelines Broadband" , "Globelines Wireless/WiMax/Tattoo" , "Smart Bro Wireless" , "Sun Broadband Wireless" ,"Others");
for($i=0; $i<count($internet_connections); $i++){
	if($internet_connection == $internet_connections[$i]){
		$internet_connections_Options .= "<option value=\"".$internet_connections[$i]."\" selected>".$internet_connections[$i]."</option>";
	}else{
		$internet_connections_Options .= "<option value=\"".$internet_connections[$i]."\">".$internet_connections[$i]."</option>";
	}
}





//check if this form has already saved in the applicants_form
if($userid!=""){
	$sql = $db->select()
		->from('applicants_form')
		->where('userid = ?' ,$userid)
		->where('form = ?' , 2);
	$result = $db->fetchRow($sql);
	$form_id = $result['id'];
	$date_completed = $result['date_completed'];
	if($date_completed == "") {
		$status = "Not yet filled up";
	}else{
		$status = "Completed ".$date_completed;
	}	
	$smarty->assign('form_id',$form_id);
	
	$welcome = sprintf("Welcome ID%s %s %s<br>Step 2 Form status : %s " ,$userid ,$fname, $lname , $status);
	$smarty->assign('welcome',$welcome);
	
}

//right menus
$right_menus = RightMenus(2 , $userid);
$smarty->assign('right_menus' , $right_menus);
$smarty->assign('page' , basename($_SERVER['SCRIPT_FILENAME']));
$smarty->assign('userid' , $userid);
$smarty->assign('img_result',$img_result);
$smarty->assign('code',$code);



$smarty->assign('monthOptions',$monthOptions);
$smarty->assign('yearOptions',$yearOptions);
$smarty->assign('dayOptions',$dayOptions);
$smarty->assign('byear',$byear);

$smarty->assign('start_worked_from_home_year',$start_worked_from_home_year);
$smarty->assign('have_a_baby_in_the_house_Options',$have_a_baby_in_the_house_Options);
$smarty->assign('who_is_the_main_caregiver',$who_is_the_main_caregiver);
$smarty->assign('why_do_you_want_to_work_from_home',$why_do_you_want_to_work_from_home);
$smarty->assign('timespan_Options' ,$timespan_Options);
$smarty->assign('home_working_environment_Options',$home_working_environment_Options);
$smarty->assign('internet_connections_Options',$internet_connections_Options);
$smarty->assign('internet_connection_others',$internet_connection_others);
$smarty->assign('internet_plan',$internet_plan);
$smarty->assign('speed_test_result_link',$speed_test_result_link);
$smarty->assign('internet_consequences' ,$internet_consequences);
$smarty->assign('desktop_checked',$desktop_checked);
$smarty->assign('laptop_checked',$laptop_checked);
$smarty->assign('desktop_os_Options' , $desktop_os_Options);
$smarty->assign('desktop_processor',$desktop_processor);
$smarty->assign('desktop_ram',$desktop_ram);

$smarty->assign('laptop_os_Options' ,$laptop_os_Options);
$smarty->assign('laptop_processor',$laptop_processor);
$smarty->assign('laptop_ram' , $laptop_ram);

$smarty->assign('headset' , $headset);   
$smarty->assign('headphone' , $headphone);
$smarty->assign('printer' , $printer);
$smarty->assign('scanner' , $scanner);
$smarty->assign('tablet' , $tablet);
$smarty->assign('pen_tablet' , $pen_tablet);

$smarty->assign('noise_level_Options',$noise_level_Options);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");
$smarty->display('registernow-step2-working-at-home-capabilities.tpl');

?>