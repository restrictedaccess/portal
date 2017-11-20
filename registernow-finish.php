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

//check if this form has already saved in the applicants_form
if($userid!=""){
	$sql = "SELECT count(*) as formnum FROM `applicants_form` WHERE (userid = '".$userid."')";
	$result = $db->fetchRow($sql);
	$formnum = $result['formnum'];
	if ($formnum==7){ 
		$success=true;
		//session_destroy();
	}
	//else header("Location: registernow-step7-uploadphoto.php");
	else header("Location: http://test.remotestaff.com.au/portal/applicantHome.php");
} 

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");
$smarty->display('registernow-finish.tpl');



?>
