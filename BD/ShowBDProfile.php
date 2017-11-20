<?php
include '../conf/zend_smarty_conf.php';
include './lib/AddAgentHistoryChanges.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

if(!$_SESSION['admin_id'])
{
	header("location:index.php");
}

$agent_no = $_REQUEST['agent_no'];

$sql = $db->select()
	->from('agent')
	->where('agent_no =?' , $agent_no);
$agent = $db->fetchRow($sql);	

$ShowAgentInfoChangesHistory = ShowAgentInfoChangesHistory($agent_no);
	
$sql = $db->select()
	->from(array('f' => 'agent_affiliates') , array('id'))
	->join(array('a' => 'agent') , 'a.agent_no = f.affiliate_id' , array('fname' , 'lname'))
	->where('a.status =?' , 'ACTIVE')
	->where('a.work_status =?' , 'AFF')
	->where('f.business_partner_id =?' , $agent_no)
	->order('fname ASC');
$affiliates = $db->fetchAll($sql);

$smarty->assign('ShowAgentInfoChangesHistory' , $ShowAgentInfoChangesHistory);
$smarty->assign('agent' , $agent);
$smarty->assign('affiliates' , $affiliates);
$smarty->assign('affiliates_count' , count($affiliates));

$smarty->display('ShowBDProfile.tpl');
?>