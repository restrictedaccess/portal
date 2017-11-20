<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';

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
foreach($categories as $key=>$category){
	
	$categories[$key]['subcategories'] = getSubCategories($category['category']['id']);
	
	$categories[$key]['total_applicants'] = 0;
	foreach($categories[$key]['subcategories'] as $key2=>$subcategory){
		
		if($_GET['subcategory'] != ''){
			if($_GET['subcategory'] == $key2){
				$categories[$key]['subcategories'][$key2]['applicants'] = getApplicants($key2,$date_start,$date_end,$keyword,$keyword_type,$recruiter,$on_asl);
				$categories[$key]['subcategories'][$key2]['total_applicants'] = count($categories[$key]['subcategories'][$key2]['applicants']);
				$categories[$key]['total_applicants'] += $categories[$key]['subcategories'][$key2]['total_applicants'];
			}
		}
		else{
			$categories[$key]['subcategories'][$key2]['applicants'] = getApplicants($key2,$date_start,$date_end,$keyword,$keyword_type,$recruiter,$on_asl);
			$categories[$key]['subcategories'][$key2]['total_applicants'] = count($categories[$key]['subcategories'][$key2]['applicants']);
			$categories[$key]['total_applicants'] += $categories[$key]['subcategories'][$key2]['total_applicants'];
		}
	}
	
	$total_applicants += $categories[$key]['total_applicants'];
}


//get recruiters list
$recruiters_option = "<option value=''>All Recruiters</option>";
$select = "SELECT admin_id,admin_fname,admin_lname 	 
	FROM `admin`
	where status='HR'
	or (admin_fname='TinaKareen' and admin_lname='Borillo')
	or (admin_fname='SherryMae' and admin_lname='Atillo')";
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
}
else{
	$on_asl_option .= "<option value=''>All</option>";
	if($on_asl == 0){
		$on_asl_option .= "<option value='0' selected>Yes</option>";
		$on_asl_option .= "<option value='1' >No</option>";
	}
	else{
		$on_asl_option .= "<option value='0' >Yes</option>";
		$on_asl_option .= "<option value='1' selected >No</option>";
	}
}

$smarty->assign('total_applicants', $total_applicants);
$smarty->assign('categories', $categories);
$smarty->assign('subcategories_option', $subcategories_option);
$smarty->assign('recruiters_option', $recruiters_option);
$smarty->assign('on_asl_option', $on_asl_option);
$smarty->assign('get', $_GET);
$smarty->assign('date_start', $date_start);
$smarty->assign('date_end', $date_end);
$smarty->display('recruiter_staff_manager.tpl');
?>
