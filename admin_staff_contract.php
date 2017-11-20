<?php
include './conf/zend_smarty_conf.php';
require('./tools/CouchDBMailbox.php');
$smarty = new Smarty();


header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');


if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}
$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];



//Check if the admin can access staff contracts
$sql = $db->select()
    ->from('admin')
	->where('admin_id =?', $_SESSION['admin_id']);
$admin =$db->fetchRow($sql);
$view_staff_contract =  $admin['view_staff_contract'];
if ($view_staff_contract == 'N') {
	
	$attachments_array =NULL;
	$bcc_array=NULL;
    $cc_array = NULL;
    $from = 'No Reply<noreply@remotestaff.com.au>';
    $html = NULL;
    $subject = "Staff Contract Management Access Denied";
    $text = sprintf('Admin #%s%s %s is trying to view Staff Contract Management', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname']);
    $to_array = array('devs@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	die("Staff Contract Access Denied.");
}	

header("location:/portal/django/subcontractors/temp_contracts/");
exit;

$date = new DateTime();
$date->setDate(date('Y'), date('m'), date('d'));
//$date->modify("+2 day");
$date_advanced = $date->format("Y-m-d");
$min_date = $date->format("Ymd");

$smarty->assign('min_date', $min_date);
$smarty->display('admin_staff_contract.tpl');

exit;
?>