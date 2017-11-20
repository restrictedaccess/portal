<?php


include('conf/zend_smarty_conf.php');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['client_id']==""){
    header("location:index.php");
	exit;
}
	
$sql=$db->select()
	->from('leads')
	->where('id = ?' ,$_SESSION['client_id']);
$lead = $db->fetchRow($sql);
$smarty->assign('leads_id' , $_SESSION['client_id']);

$smarty->display('clientFAQs.tpl');
?>