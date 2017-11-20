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
$right_menus = RightMenus(8 , $userid);
$smarty->assign('right_menus' , $right_menus);
$sql = "SELECT count(*) as formnum FROM `applicants_form` WHERE (userid = '".$userid."')";
$result = $db->fetchRow($sql);
$formnum = $result['formnum'];
if ($formnum==8){ 
	$success=true;
	//session_destroy();
	//header("Location: /portal/applicantHome.php");
	$smarty->assign("success", $success);
	$smarty->display('registernow-finish.tpl');
}
else{
	$message = 'Please complete all the required forms';
	header("Location: registernow-step8-uploadphoto.php?error_msg=".urlencode($message));
}