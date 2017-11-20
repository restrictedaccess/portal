<?php
include('conf/zend_smarty_conf.php');

header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'agent';
	$smarty->assign('agent_section',True);
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';
	$smarty->assign('admin_section',True);

}else{

	header("location:index.php");
	exit;
}

//echo sprintf('%s %s', $created_by_id, $created_by_type);
//exit;
$smarty->assign('leads_id', $_GET['leads_id']);
$smarty->display('quote.tpl');
?>