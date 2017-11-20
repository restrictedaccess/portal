<?php
include '../../conf/zend_smarty_conf.php';
include '../../quote/quote_functions.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

$ran = $_REQUEST['ran'];
if($ran == ""){
    die("Page cannot be viewed");
}


//header("Location:/portal/v2/quote/show/?ran={$ran}");
//exit;
$sql = $db->select()
    ->from('quote', 'id')
	->where('ran =?', $ran);
$id = $db->fetchOne($sql);	

if($id == ""){
    die("Invalid Code");
}


$smarty->assign('id', $id);
$smarty->display('quote.tpl');	
?>