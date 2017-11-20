<?php
include './conf/zend_smarty_conf.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;


if($_SESSION['client_id']=="")
{
	header("location:index.php");
	exit;
}
$client_id = $_SESSION['client_id'];
$sql= $db->select()
    ->from('leads', array('csro_id', 'hiring_coordinator_id'))
	->where('id=?', $client_id);
$lead = $db->fetchRow($sql);	
	
$csro_id = $lead['csro_id'];
$hiring_coordinator_id = $lead['hiring_coordinator_id'];

$sql = "SELECT admin_id, admin_fname, admin_email, extension_number, local_number, skype_id, work_schedule FROM admin a WHERE csro='Y' AND status NOT IN('PENDING','REMOVED') ORDER BY admin_fname ASC;";
$csros = $db->fetchAll($sql);

//$sql = "SELECT admin_id, admin_fname, admin_email, extension_number, local_number, skype_id, work_schedule FROM admin a WHERE status ='FINANCE-ACCT' ORDER BY admin_fname ASC;";
//$accounts = $db->fetchAll($sql);

if($hiring_coordinator_id){
	$sql = "SELECT admin_id, admin_fname, admin_email, extension_number, local_number, skype_id, work_schedule FROM admin a WHERE status NOT IN('PENDING','REMOVED') AND admin_id=".$hiring_coordinator_id;
	$hiring_coordinator = $db->fetchRow($sql);
	$smarty->assign('hiring_coordinator', $hiring_coordinator);
}


$smarty->assign('csros', $csros);
$smarty->assign('csro_id', $csro_id);
$smarty->display('support_team_contact_details.tpl')
?>