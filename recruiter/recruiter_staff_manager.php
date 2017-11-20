<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';

if (!isset($_REQUEST["redirect"])){
	header("Location:/portal/recruiter/categorized.php");
	die;
}

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$smarty = new Smarty;

//START: validate user
if(!$_SESSION['admin_id']){
	header("location:index.php");
}

if($_SESSION['status'] <> "HR" && $_SESSION['status'] <> "FULL-CONTROL"){ 
	echo "This page is for HR usage only.";
	exit;
}

$admin_id = $_SESSION['admin_id'];
$sql=$db->select()
	->from('admin')
	->where('admin_id = ?' ,$admin_id);
$admin = $db->fetchRow($sql);
$recruiter_full_name = $admin['admin_fname']." ".$admin['admin_lname'];
$recruiter_user_type = $admin['status'];
//ENDED: validate user



$date_start = $_GET['date_start'];
$date_end = $_GET['date_end'];
$keyword = $_GET['keyword'];
$keyword_type = $_GET['keyword_type'];
$subcategory = $_GET['subcategory'];
$recruiter = $_GET['recruiter'];
$on_asl = $_GET['on_asl'];
$adv_rate = $_GET['adv_rate'];

//additional filter as per Liz
$work_availability = $_GET['work_availability'];
$timezone_availability = $_GET["timezone_availability"];
$selected_gender = $_GET["gender"];
$city = $_GET["city"];
$selected_region = $_GET["region"];
$selected_marital_status = $_GET["marital_status"];

if(($date_start == NULL)||($date_start == '')){
	$select = "SELECT date(sub_category_applicants_date_created) 
		FROM job_sub_category_applicants
		order by sub_category_applicants_date_created asc
		limit 1";
	$date_start = $db->fetchOne($select);  
}
if(($date_end == NULL)||($date_end == '')){
	$date_end = date('Y-m-d');
}

include_once 'categories_functions.php';


$categories = getCategories();
$subcategories_option = "<option value=''>All Subcategory</option>";

foreach($categories as $key=>$category){
	
	$categories[$key]['subcategories'] = getSubCategories($category['category']['id']);
	$subcategories_option .= "<optgroup label='".$category['category']['name']."'>";;
	foreach($categories[$key]['subcategories'] as $key2=>$subcategory){
	
		//create sub-categories option 
		$selected = "";
		if($key2 == $_GET['subcategory']){
			$selected = "selected";
		}
		if($subcategory['category_name'] != ''){
			$subcategories_option .= "<option value='".$key2."' ".$selected.">".$subcategory['category_name']."</option>";
		}
		
	}
	$subcategories_option .= "</optgroup>";
}

$category = null;
if($_GET['subcategory'] != ''){
	//get the category of the selected sub-category
	$select = "SELECT category_id FROM `job_sub_category`
		where sub_category_id='".$_GET['subcategory']."'";
	$category = $db->fetchOne($select); 
}

$total_applicants = 0;
$categories = getCategories($category);
$uniques = array();
//$rowsCount = getUniqueResumes($date_start,$date_end,$keyword,$keyword_type,$recruiter,$on_asl,$adv_rate);
foreach($categories as $key=>$category){
	$categories[$key]["category_name"] = $category["category"]["name"];
	$categories[$key]['subcategories'] = getSubCategories($category['category']['id']);
	
	$categories[$key]['total_applicants'] = 0;
	foreach($categories[$key]['subcategories'] as $key2=>$subcategory){
		
		if($_GET['subcategory'] != ''){
			if($_GET['subcategory'] == $key2){
				$result = getApplicants($key2,$date_start,$date_end,$keyword,$keyword_type,$recruiter,$on_asl,$adv_rate);
				
				foreach($result["applicants"] as $keyVal=>$applicant_item){
					if (!in_array($keyVal, $uniques)){
						$uniques[] = $keyVal;
					}
				}
				
				$categories[$key]['subcategories'][$key2]['applicants'] = $result["applicants"];
				$categories[$key]['subcategories'][$key2]['total_applicants'] = count($categories[$key]['subcategories'][$key2]['applicants']);
				$categories[$key]['total_applicants'] += $categories[$key]['subcategories'][$key2]['total_applicants'];
			}
		}
		else{
			$result = getApplicants($key2,$date_start,$date_end,$keyword,$keyword_type,$recruiter,$on_asl,$adv_rate);
			
			foreach($result["applicants"] as $keyVal=>$applicant_item){
				if (!in_array($keyVal, $uniques)){
					$uniques[] = $keyVal;
				}
			}
			$categories[$key]['subcategories'][$key2]['applicants'] = $result["applicants"];
			$categories[$key]['subcategories'][$key2]['total_applicants'] = count($categories[$key]['subcategories'][$key2]['applicants']);
			$categories[$key]['total_applicants'] += $categories[$key]['subcategories'][$key2]['total_applicants'];
		}
		
	}
	
	$total_applicants += $categories[$key]['total_applicants'];
}

$rowsCount = count($uniques);
//get recruiters list
$recruiters_option = "<option value=''>All Recruiters</option>";
$select = "SELECT admin_id,admin_fname,admin_lname 	 
	FROM `admin`
	where (status='HR') AND status <> 'REMOVED'  AND admin_id <> 161   
	order by admin_fname";
	
$recruiters = $db->fetchAll($select); 
foreach($recruiters as $recruiter){
	
	if($recruiter['admin_id'] == $_GET['recruiter']){
		$recruiters_option .= "<option value='".$recruiter['admin_id']."' selected >".$recruiter['admin_fname'].' '.$recruiter['admin_lname']."</option>";
	}
	else{
		$recruiters_option .= "<option value='".$recruiter['admin_id']."' >".$recruiter['admin_fname'].' '.$recruiter['admin_lname']."</option>";
	}
}

//on asl option
if($on_asl == ""){
	$on_asl_option .= "<option value='' selected >All</option>";
	$on_asl_option .= "<option value='0' >Yes</option>";
	$on_asl_option .= "<option value='1' >No</option>";
	$on_asl_option .= "<option value='2' >Under Consideration</option>";
}
else{
	$on_asl_option .= "<option value=''>All</option>";
	if($on_asl == 0){
		$on_asl_option .= "<option value='0' selected>Yes</option>";
		$on_asl_option .= "<option value='1' >No</option>";
		$on_asl_option .= "<option value='2' >Under Consideration</option>";
	}
	else if ($on_asl==1){
		$on_asl_option .= "<option value='0' >Yes</option>";
		$on_asl_option .= "<option value='1' selected >No</option>";
		$on_asl_option .= "<option value='2' >Under Consideration</option>";
	}else{
		$on_asl_option .= "<option value='0' >Yes</option>";
		$on_asl_option .= "<option value='1'>No</option>";
		$on_asl_option .= "<option value='2' selected>Under Consideration</option>";
	}
}
//advertized rate option
if(($adv_rate == '')||($adv_rate == 'hourly')){
	$adv_rate_option = "<option value='hourly' selected >Hourly</option>";
	$adv_rate_option .= "<option value='monthly' >Monthly</option>";
}
else{
	$adv_rate_option = "<option value='hourly' >Hourly</option>";
	$adv_rate_option .= "<option value='monthly' selected >Monthly</option>";
}
$inactiveChoices = array("BLACKLISTED", "NO POTENTIAL", "NOT INTERESTED", "NOT READY");
$inactiveSelect = "";
foreach($inactiveChoices as $inactiveChoice){
	if (isset($_GET["inactive"])&&($_GET["inactive"]==$inactiveChoice)){	
		$inactiveSelect.="<option value='{$inactiveChoice}' selected>{$inactiveChoice}</option>";	
	}else{
		$inactiveSelect.="<option value='{$inactiveChoice}'>{$inactiveChoice}</option>";
	}
}
if (isset($_GET["inactive"])&&(in_array($_GET["inactive"], $inactiveChoices))){
	if (isset($_GET["date_updated_start"])&&isset($_GET["date_updated_end"])&&$_GET["date_updated_start"]!=""&&$_GET["date_updated_end"]!=""){
		$smarty->assign("total_count", "<strong>".$rowsCount." ".$_GET["inactive"]." candidates from {$_GET["date_updated_start"]} and {$_GET["date_updated_end"]}</strong>");
	}else{
		$smarty->assign("total_count", "<strong>".$rowsCount." ".$_GET["inactive"]." candidates</strong>");
	}
		

}else{
	if (isset($_GET["date_updated_start"])&&isset($_GET["date_updated_end"])&&$_GET["date_updated_start"]!=""&&$_GET["date_updated_end"]!=""){
		$smarty->assign("total_count", "<strong>".$rowsCount." categorized candidates from {$_GET["date_updated_start"]} and {$_GET["date_updated_end"]}</strong>");
	}else{
		$smarty->assign("total_count", "<strong>".$rowsCount." categorized candidates</strong>");
	}
}
//availability inputs
$options = "<option value=''></option>";
for($i=1;$i<=11;$i++){
	if ($i==$_GET["available_notice"]){
		$options.="<option value='{$i}' selected>$i</option>";	
	}else{
		$options.="<option value='{$i}'>$i</option>";		
	}

}

$smarty->assign("available_notice_options", $options);
//for the radio box in search
$available_status = $_GET["available_status"];
if ($available_status=="a"){
	$a_selected = "checked";
	$b_selected = "";
	$p_selected = "";
	$w_selected = "";
}else if ($available_status=="b"){
	$a_selected = "";
	$b_selected = "checked";
	$p_selected = "";
	$w_selected = "";
}else if ($available_status=="p"){
	$a_selected = "";
	$b_selected = "";
	$p_selected = "checked";
	$w_selected = "";
}else if ($available_status=="Work Immediately"){
	$a_selected = "";
	$b_selected = "";
	$p_selected = "";
	$w_selected = "checked";
}


//additional filters as per Liz
$genders = array("Male", "Female");
$gender_options = "";
foreach($genders as $gender){
	if ($gender==$selected_gender){
		$gender_options.="<option value='".$gender."' selected>".$gender."</option>";
	}else{
		$gender_options.="<option value='".$gender."'>".$gender."</option>";		
	}
}

$availabilities = array( "Any","AU", "UK", "US");
$time_availability_options = "";
foreach($availabilities as $selected_time_availability){
	if ($selected_time_availability==$_GET["time_availability"]){
		$time_availability_options .= "<option value='".$selected_time_availability."' selected>".$selected_time_availability.'</option>';
	}else{
		$time_availability_options .= "<option value='".$selected_time_availability."'>".$selected_time_availability.'</option>';		
	}
}
$availabilities = array("Full-Time", "Part-Time");
$work_availability_options = "";
foreach($availabilities as $selected_work_availability){
	if ($selected_work_availability==$work_availability){
		$work_availability_options .= "<option value='".$selected_work_availability."' selected>".$selected_work_availability."</option>";
	}else{
		$work_availability_options .= "<option value='".$selected_work_availability."'>".$selected_work_availability."</option>";
	}
}

$regions = array('Armm','Bicol Region','C.A.R.','Cagayan Valley','Central Luzon','Central Mindanao','Caraga','Central Visayas','Eastern Visayas','Ilocos Region','National Capital Reg','Northern Mindanao','Southern Mindanao','Southern Tagalog','Western Mindanao','Western Visayas');
$regions_key = array("AR", "BR", "CA", "CG", "CL", "CM", "CR", "CV", "EV", "IL", "NC", "NM", "SM", "ST", "WM", "WV");
$region_options = "";
foreach($regions as $key=>$region){
	if ($region==$selected_region){
		$region_options.="<option value='".$regions_key[$key]."' selected>".$region."</option>";
	}else{
		$region_options.="<option value='".$regions_key[$key]."'>".$region."</option>";
	}
}

$marital_statuses = array("Single","Married","DeFacto","Its Complicated","Engaged");
$marital_status_options = "";
foreach($marital_statuses as $marital_status){
	if ($marital_status==$selected_marital_status){
		$marital_status_options .= "<option value='".$marital_status."' selected>".$marital_status."</option>";
	}else{
		$marital_status_options .= "<option value='".$marital_status."'>".$marital_status."</option>";
	}
}

$smarty->assign("a_selected", $a_selected);
$smarty->assign("b_selected", $b_selected);
$smarty->assign("p_selected", $p_selected);
$smarty->assign("w_selected", $w_selected);
$smarty->assign("inactive_options", $inactiveSelect);
$smarty->assign('total_applicants', $total_applicants);
$smarty->assign("date_updated_start", $_GET["date_updated_start"]);
$smarty->assign("date_updated_end", $_GET["date_updated_end"]);
$smarty->assign("date_registered_start", $_GET["date_registered_start"]);
$smarty->assign("date_registered_end", $_GET["date_registered_end"]);
$smarty->assign("gender_options", $gender_options);
$smarty->assign("time_availability_options", $time_availability_options);
$smarty->assign("work_availability_options", $work_availability_options);
$smarty->assign("marital_status_options", $marital_status_options);
$smarty->assign("region_options", $region_options);

$smarty->assign("city", $city);

$smarty->assign('categories', $categories);
$smarty->assign('subcategories_option', $subcategories_option);
$smarty->assign('recruiters_option', $recruiters_option);
$smarty->assign('on_asl_option', $on_asl_option);
$smarty->assign('adv_rate_option', $adv_rate_option);
$smarty->assign('get', $_GET);
$smarty->assign('date_start', $date_start);
$smarty->assign("rows_count", $rowsCount);
$smarty->assign('date_end', $date_end);
$smarty->display('recruiter_staff_manager.tpl');
?>
