<?php
include '../conf/zend_smarty_conf.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']==""){
	echo "Page cannot be viewed.";
	exit;
}



$from = date('Y-m-d') ;
$to = date('Y-m-d') ;

$sql = "SELECT s.leads_id, l.fname, l.lname, l.email  FROM subcontractors s JOIN leads l ON l.id= s.leads_id WHERE ( s.status IS NOT NULL ) $conditions GROUP BY s.leads_id ORDER BY l.fname;";
$clients = $db->fetchAll($sql);


$smarty->assign('clients', $clients);
//$smarty->assign('from', $from);
//$smarty->assign('to', $to);
$smarty->assign('script_filename',basename($_SERVER['SCRIPT_FILENAME']));
$smarty->display('client_csro_name_changed.tpl');
?>