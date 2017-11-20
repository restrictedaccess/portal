<?php
/*
2009-11-13 Normaneil Macutay <normanm@remotestaff.com.au>
- included the admin notify_timesheet_notes in the code

*/
include '../conf/zend_smarty_conf.php';
include '../time.php';
include '../function.php';
$smarty = new Smarty();



$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
$date=date('l jS \of F Y h:i:s A');

if($_SESSION['admin_id']=="")
{
	die("Session expires. Please re-login");
}

/*
admin_id, admin_fname, admin_lname, admin_email, admin_password, adjust_time_sheet, force_logout, notify_invoice_notes, notify_timesheet_notes, csro, view_camera_shots, view_screen_shots, admin_created_on, status, signature_notes, signature_contact_nos, signature_company, signature_websites, timezone_id, view_rssc_dashboard, edit_rssc_settings, manage_staff_invoice, hiring_coordinator, head_recruiter, head_recruiter_id

*/

$query="SELECT * FROM admin WHERE status !='REMOVED' ORDER BY admin_fname ASC;";

if (in_array($_SESSION['admin_id'], array(5, 17, 43, 6, 2, 32, 57, 31, 30)) == true) {
     $smarty->assign('access', True);
}

$result = $db->fetchAll($query);

$smarty->assign('result', $result);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/plain');
$smarty->display('getAllAdminUsers.tpl');

?>