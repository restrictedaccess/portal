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

//header("location:/portal/django/accounts/create_soa/");
//exit;

$sql=$db->select()
    ->from('admin')
	->where('admin_id =?',$_SESSION['admin_id']);
$admin = $db->fetchRow($sql);




$sql = "SELECT s.leads_id , l.fname, l.lname, l.email FROM subcontractors s JOIN leads l ON l.id = s.leads_id WHERE s.status IN ('ACTIVE','suspended', 'resigned', 'terminated') GROUP BY s.leads_id ORDER BY l.fname;;";
$clients = $db->fetchAll($sql);
//echo $sql;
//exit;

$smarty->assign('admin', $admin);
$smarty->assign('clients', $clients);
$smarty->display('index.tpl');
?>