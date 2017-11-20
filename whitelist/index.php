<?php
include '../conf/zend_smarty_conf.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']==""){
	echo "Page cannot be viewed. Please login again.";
	exit;
}

if(!in_array($_SESSION['admin_id'], array(43, 5, 143, 378,379)) ){
	echo "Page cannot be viewed. No access.";
	exit;
}


$sql=$db->select()
    ->from('admin')
	->where('admin_id =?',$_SESSION['admin_id']);
$admin = $db->fetchRow($sql);

//$API_URL = "//staging.api.remotestaff.com.au";
//if(TEST){
//	$API_URL = "//test.api.remotestaff.com.au";
//}

$smarty->assign("API_URL", $base_api_url);
$smarty->assign('admin', $admin);
$smarty->display('index.tpl');
?>