<?php
if (!isset($db)) {  //test if $db is already set
	include_once('../conf/zend_smarty_conf.php');
	header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
    header("Cache-Control: no-cache");
    header('Content-type: text/html; charset=utf-8');
    header("Pragma: no-cache");
    $smarty = new Smarty;
}

if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	
	$smarty->assign('agent_section',True);
	
		
	$current_user = array(
	    'user_type' => 'BP',
		'id' => $agent['agent_no'],
		'fname' => $agent['fname'],
		'lname' => $agent['lname'],
		'email' => $agent['email'],
		'access_all_leads' => $agent['access_all_leads'],
		'view_leads_setting' => $agent['view_leads_setting'],
		'leads_order_by_setting' => $agent['leads_order_by_setting'],
		'change_by_type' => 'bp',
		'menu_status' => 'FULL-CONTROL'
	);
	
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){
	
	$admin_id = $_SESSION['admin_id'];
	$admin_status=$_SESSION['status'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	$smarty->assign('admin_section',True);	
	$current_user = array(
	    'user_type' => 'Admin',
		'id' => $admin['admin_id'],
		'fname' => $admin['admin_fname'],
		'lname' => $admin['admin_lname'],
		'email' => $admin['admin_email'],
		'access_all_leads' => 'YES',
		'view_leads_setting' => 'all',
		'leads_order_by_setting' => '',
		'change_by_type' => 'admin',
		'menu_status' => $admin['status']
	);
}else{
	header("location:../");
}	



$smarty->assign('current_user', $current_user);
?>