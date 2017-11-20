<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();

$leads_id=$_REQUEST['leads_id'];
$actions = $_REQUEST['actions'];

//echo $leads_id ."<br>".$actions;
$sql = $db->select()
	->from('leads')
	->where('id=?' ,$leads_id);
$lead = $db->fetchRow($sql);	
//print_r($lead);
if($lead['hiring_coordinator_id']){
	$sql = $db->select()
	    ->from('admin', Array('admin_id', 'admin_fname', 'admin_lname', 'admin_email'))
		->where('admin_id =?', $lead['hiring_coordinator_id']);
	$hm= $db->fetchRow($sql);
	//print_r($hm);
	$smarty->assign('hm',$hm);
}


if($lead['csro_id']){
	$sql = $db->select()
	    ->from('admin', Array('admin_id', 'admin_fname', 'admin_lname', 'admin_email'))
		->where('admin_id =?', $lead['csro_id']);
	$csro= $db->fetchRow($sql);
	//print_r($csro);
	$smarty->assign('csro',$csro);
}

if($lead['business_partner_id']){
	$sql = $db->select()
	    ->from('agent', Array('fname', 'lname', 'email'))
		->where('agent_no =?', $lead['business_partner_id']);
	$bd= $db->fetchRow($sql);
	//print_r($csro);
	$smarty->assign('bd',$bd);
}


if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	$current_user_name = $agent['fname']." ".$agent['lname'];
	$current_user_email = $agent['email'];	
}

if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);	
	$current_user_name = $admin['admin_fname']." ".$admin['admin_lname'];
	$current_user_email = $admin['admin_email'];
}

//$subject = sprintf('Message from Remotestaff c/o %s', $current_user_name);
$subject="";
$smarty->assign('subject', $subject);
$smarty->assign('current_user', sprintf('%s <%s>', $current_user_name, $current_user_email) );
$smarty->assign('actions',$actions);
$smarty->assign('name',$lead['fname']." ".$lead['lname']);
$smarty->assign('email',$lead['email']);



header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Pragma: no-cache");
$smarty->display('ShowHideActions.tpl');
?>