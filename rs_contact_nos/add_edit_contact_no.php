<?php
include '../conf/zend_smarty_conf.php';

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/html; charset=utf-8');
$smarty = new Smarty;

if($_SESSION['admin_id']==""){
	die('Session expires.');
}

if($_POST['id']){	
	$sql = "select * from rs_contact_nos where id=".$_POST['id'];
	$contact_no = $db->fetchRow($sql);	
}

$sites=array(
    'aus' => 'Australia Contact No.',
	'usa' => 'USA Contact No.',
	'php' => 'Philippine Contact No.'
);


$types=array('company number', 'header number', 'office number', 'call hotline', 'text hotline', 'subcon call hotline', 'subcon text hotline');

$smarty->assign('sites', $sites);
$smarty->assign('types', $types);
$smarty->assign('contact_no', $contact_no);
$smarty->display('form_contact_no.tpl');
?>