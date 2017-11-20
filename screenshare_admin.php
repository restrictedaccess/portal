<?php
/*screenshare_admin.php //2013-08-09*/
include('conf/zend_smarty_conf.php');
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

$smarty = new Smarty;


$admin_id = $_SESSION['admin_id'];

if($admin_id == ''){
	header("location:index.php");
    exit();
}

$sql=$db->select()
	->from('admin')
	->where('admin_id = ?' ,$admin_id);
$admin = $db->fetchRow($sql);


if( !empty($_SESSION['admin_id']) && $_SESSION['firstrun'] == "" ) {
	$hash_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $_SESSION['emailaddr'] ), 2, 17 );
	$smarty->assign('session_exists', 1);
	$smarty->assign('hash',$hash_code);
	$smarty->assign('emailaddr', $_SESSION['emailaddr']);
}


$smarty->assign('admin',$admin);

$smarty->display('screenshare_admin.tpl');
?>
