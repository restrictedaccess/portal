<?php
include './conf/zend_smarty_conf_root.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	$session_name = $agent['fname']." ".$agent['lname'];
	$session_email = $agent['email'];
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'agent';
	$smarty->assign('agent_section',True);
	
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	
	$session_name = $admin['admin_fname']." ".$admin['admin_lname'];
	$session_email = $admin['admin_email'];
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';
	$smarty->assign('admin_section',True);	

}else{

	die("Session Expires . Please re-login");
}



$id=$_REQUEST['id'];
if(!$id){
	die("History ID is missing");
}

$sql = $db->select()
	->from('history_affiliates')
	->where('id =?' , $id);
$result = $db->fetchRow($sql);

//Affiliate
$affiliate_id = $result['to_by_id'];
$sql=$db->select()
   ->from('agent')
  ->where('agent_no =?',$affiliate_id);
$aff = $db->fetchRow($sql);


//BP
$sql=$db->select()
   ->from('agent')
  ->where('agent_no =?',$result['created_by_id']);
$bp = $db->fetchRow($sql);   
 




$smarty->assign('aff', $aff);
$smarty->assign('bp', $bp);
$smarty->assign('actions' , $result['actions']);
$smarty->assign('result', $result);
$smarty->assign('message',stripslashes($result['history']) );
$smarty->display('viewAffHistory.tpl');
?>