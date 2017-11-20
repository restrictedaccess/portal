<?php
include '../conf/zend_smarty_conf.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;


$sql = $db->select()
    ->from('personal', Array('userid', 'fname', 'lname', 'image'))
	->where('userid =?', $_REQUEST['userid']);
$personal = $db->fetchRow($sql);

$smarty->assign('personal', $personal);
$smarty->display('ShowInhouseDetails.tpl');
?>