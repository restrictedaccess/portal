<?php
/*
2012-07-05 Normaneil Macutay <normanm@remotestaff.com.au>
- Revised this whole script
2010-03-12 Lawrence Sunglao<lawrence.sunglao@remotestaff.com.au>
- made the password readonly, random character password generated
2009-11-13 Normaneil Macutay <normanm@remotestaff.com.au>
- included the admin notify_timesheet_notes in the code

*/
include '../conf/zend_smarty_conf.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']==""){
	die("Session expires. Please re-login");
}

$sql=$db->select()
    ->from('admin')
	->where('admin_id =?', $_SESSION['admin_id']);
$current_admin = $db->fetchRow($sql);

if (in_array($_SESSION['admin_id'], $ADMIN_MANAGE_INHOUSE_CONFIDENTIAL_INFO) == true) {
     $smarty->assign('view_inhouse_confidential_access', True);
}

$ANSWERS=array('N','Y');
$ANSWERS_STR=array('No','Yes');
$ADMIN_STATUS=array('PENDING','COMPLIANCE','HR','FULL-CONTROL','FINANCE-ACCT','REMOVED');

$admin_id = $_REQUEST['admin_id'];
$mode = $_REQUEST['mode'];
$domains = $ALLOWED_EMAIL_DOMAIN;

if ($mode == "")$mode='add';

if($admin_id > 0){
	$sql =$db->select()
	    ->from('admin')
		->where('admin_id =?', $admin_id);
	$admin = $db->fetchRow($sql);
	//echo "<pre>";
	//print_r($admin);
	//echo "</pre>";
	$sql = "SELECT ad.admin_fname, ad.admin_lname, a.id, changes,  date_changes FROM admin_history a JOIN admin ad ON ad.admin_id = a.changed_by_id WHERE a.admin_id = ".$admin_id." AND (changes IS NOT NULL AND changes !='');";
	$results = $db->fetchAll($sql);
	$histories=array();
	foreach($results as $history){
		$changes = explode(',', $history['changes']);
		$data=array(
		    'admin_name' => sprintf('%s %s', $history['admin_fname'], $history['admin_lname']),
			'history_id' => $history['id'],
			'date_changes' => $history['date_changes'],
			'changes' => $changes
		);
		
		array_push($histories, $data);
	}
	$admin['histories'] =$histories;
	$pos = strrpos($admin['admin_email'], "@");
    $email = substr($admin['admin_email'],0,$pos);
    $domain = substr($admin['admin_email'],$pos);
    $admin['email'] = $email;
	$admin['domain'] = $domain;
    if (in_array($domain, $ALLOWED_EMAIL_DOMAIN) == false) {
	    $ALLOWED_EMAIL_DOMAIN[] = $domain;
    }
	if($admin['userid'] != ""){
		//$smarty->assign('userid', $admin['userid']);
	}
	if($admin['userid'] == ""){
		$sql = "SELECT DISTINCT(s.userid)AS userid FROM subcontractors s JOIN personal p ON p.userid = s.userid WHERE s.leads_id = 11 AND s.status = 'ACTIVE' AND  p.lname ='".$admin['admin_lname']."' ORDER BY fname;";
		//echo $sql;
        $userid = $db->fetchOne($sql);
		if($userid){
			$admin['userid'] = $userid;
		}
	}
}
//get all active inhouse staff
$sql = "SELECT DISTINCT(s.userid)AS userid , fname, lname FROM subcontractors s JOIN personal p ON p.userid = s.userid WHERE s.leads_id = 11 AND s.status = 'ACTIVE' ORDER BY fname;";
$inhouse_staffs = $db->fetchAll($sql);



$STAFF_USERIDS=array();
$STAFF_NAMES=array();
foreach($inhouse_staffs as $staff){
	$STAFF_USERIDS[]=$staff['userid'];
    $STAFF_NAMES[]= sprintf('%s %s',ucwords(strtolower($staff['fname'])), $staff['lname']);
}
//print_r($admin);

$smarty->assign('ALLOWED_EMAIL_DOMAIN', $ALLOWED_EMAIL_DOMAIN);
$smarty->assign('current_admin',$current_admin); //current user
$smarty->assign('admin', $admin);
$smarty->assign('mode', $mode);
$smarty->assign('STAFF_USERIDS', $STAFF_USERIDS);
$smarty->assign('STAFF_NAMES', $STAFF_NAMES);
$smarty->assign('ANSWERS', $ANSWERS);
$smarty->assign('ANSWERS_STR', $ANSWERS_STR);
$smarty->assign('ADMIN_STATUS', $ADMIN_STATUS);
$smarty->display('showAdminAddEditUsers.tpl');
?>