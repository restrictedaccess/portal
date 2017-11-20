<?php
include "../conf/zend_smarty_conf.php";
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

if(!$_SESSION['userid']){
	die("Page cannot be viewed.");
}

$sql = $db->select()
    ->from('personal', Array('fname', 'lname', 'email'))
	->where('userid =?', $_SESSION['userid']);
$staff = $db->fetchRow($sql);	

$smarty->assign('staff', $staff);
$smarty->display('gmail_management.tpl');
?>