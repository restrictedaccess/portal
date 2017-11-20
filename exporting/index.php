<?php
require('../conf/zend_smarty_conf.php');
require('../tools/CouchDBMailbox.php');
include('export_function.php');

header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


if($_SESSION['admin_id']=="") {
    die("Admin ID is missing.");
}


    
$sql= $db->select()
    ->from('admin')
	->where('admin_id =?', $_SESSION['admin_id']);
$admin = $db->fetchRow($sql);

if (in_array($_SESSION['admin_id'], $admin_with_permission) == False) {
    	
	$attachments_array =NULL;
	$bcc_array=array('devs@remotestaff.com.au');
    $cc_array = NULL;
    $from = 'No Reply<noreply@remotestaff.com.au>';
    $html = NULL;
    $subject = "Permission Denied. In viewing exporting list.";
    $text = sprintf('Admin #%s %s %s is trying to view exporting list.', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname']);
    $to_array = array('admin@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	die("Permission Denied. In viewing exporting list.");
	
}


$smarty->assign('admin', $admin);
$smarty->assign('base_api_url', $base_api_url);
$smarty->display('index.tpl');
?>