<?php
/*
2009-10-30 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    - commented out extra line outputs
2009-10-21 Normaneil Macutay	
	- password encrypted
2009-10-05 Normaneil Macutay
	- Makes the script to PHP ZEND standard coding.
*/

include './conf/zend_smarty_conf_root.php';
include './blowfish/blowfish_password.php';

$email = $_REQUEST['email'];
$password = doEncryptPassword($_REQUEST['password']);
$password_use = $_REQUEST['password'];


$query="SELECT * FROM admin WHERE admin_email = '$email' AND admin_password = '$password' AND status!='PENDING' AND status!='REMOVED';";
//echo $query;

$result = $db->fetchRow($query);
$admin_id = $result['admin_id'];
if ($admin_id != NULL or $admin_id != "" )
{
	$_SESSION['admin_id'] = $result['admin_id']; 
	$_SESSION['status'] = $result['status']; 
	$admin_email = $result['admin_email'];
	$details = "LOGIN DETAILS # EMAIL : ".$admin_email." / IP : ".$_SERVER['REMOTE_ADDR']." / SITE : ".$_SERVER['HTTP_HOST']."/adminloginphp.php";
	$logger_admin_login->info("$details");
	//$logger_admin_login->info("-");
	header("Location:adminHome.php");
	
}
else
{
	$details = "FAILED LOGIN DETAILS # EMAIL : ".$email." / IP : ".$_SERVER['REMOTE_ADDR']." / SITE : ".$_SERVER['HTTP_HOST']."/adminloginphp.php";
	$logger_admin_login->info("$details");
	//$logger_admin_login->info("-");
	header("Location:index.php?mess=5");
	exit;
}



?>
