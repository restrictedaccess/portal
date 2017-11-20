<?php
//2011-01-06    Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   Added timezone
include '../conf/zend_smarty_conf.php';
include '../time.php';
include '../function.php';
require_once("../lib/Smarty/libs/Smarty.class.php");

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
$date=date('l jS \of F Y h:i:s A');

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}

$admin_id = $_SESSION['admin_id'];

/*
admin_id, admin_fname, admin_lname, admin_email, admin_password, adjust_time_sheet, force_logout, notify_invoice_notes, admin_created_on, status, signature_notes, signature_contact_nos, signature_company, signature_websites
*/

$query = "SELECT * FROM admin WHERE admin_id = $admin_id;";
$result = $db->fetchRow($query);
$admin_fname = $result['admin_fname'];
$admin_lname = $result['admin_lname'];
$admin_email = $result['admin_email'];

$signature_notes = $result['signature_notes'];
$signature_contact_nos = $result['signature_contact_nos'];
$signature_company = $result['signature_company'];
$signature_websites = $result['signature_websites'];


//get timezone
if ($result['timezone_id'] == Null) {
    $admin_tz = 'Asia/Manila';
}
else {
    $sql = $db->select()
        ->from('timezone_lookup', 'timezone')
        ->where('id = ?', $result['timezone_id']);
    $admin_tz = $db->fetchOne($sql);
}

//get timezone lookup
$sql = $db->select()
        ->from('timezone_lookup', Array('timezone', 'id'));
$timezone_lookup = $db->fetchAll($sql);
asort($timezone_lookup);

$smarty = new Smarty();
$smarty->assign('mode', $mode);
$smarty->assign('admin_id', $admin_id);
$smarty->assign('admin_fname', $admin_fname);
$smarty->assign('admin_lname', $admin_lname);
$smarty->assign('admin_tz', $admin_tz);
$smarty->assign('timezone_lookup', $timezone_lookup);
$smarty->assign('admin_email', $admin_email);
$smarty->assign('signature_notes', $signature_notes);
$smarty->assign('signature_contact_nos', $signature_contact_nos);
$smarty->assign('signature_company', $signature_company);
$smarty->assign('signature_websites', $signature_websites);

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/plain');
$smarty->display('showAdminEditForm.tpl');
	

?>
