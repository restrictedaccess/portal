<?php
/*
2010-03-12 Lawrence Sunglao<lawrence.sunglao@remotestaff.com.au>
- made the password readonly, random character password generated

*/

include '../conf/zend_smarty_conf.php';
include '../time.php';
include '../function.php';
require_once("../lib/Smarty/libs/Smarty.class.php");

$x = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_-");
$admin_password = sprintf("%s%s%s%s%s%s%s%s", $x[rand(0,74)], $x[rand(0,74)], $x[rand(0,74)], $x[rand(0,74)], $x[rand(0,74)], $x[rand(0,74)], $x[rand(0,74)], $x[rand(0,74)]);


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
$date=date('l jS \of F Y h:i:s A');

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

$admin_id = $_REQUEST['admin_id'];


$query = "SELECT * FROM admin WHERE admin_id = $admin_id;";
$result = $db->fetchRow($query);
$admin_fname = $result['admin_fname'];
$admin_lname = $result['admin_lname'];
$admin_email = $result['admin_email'];

$smarty = new Smarty();
$smarty->assign('mode', $mode);
$smarty->assign('admin_id', $admin_id);
$smarty->assign('admin_fname', $admin_fname);
$smarty->assign('admin_lname', $admin_lname);
$smarty->assign('admin_email', $admin_email);
$smarty->assign('admin_password', $admin_password);



header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/plain');
$smarty->display('showResetPasswordForm.tpl');


?>

