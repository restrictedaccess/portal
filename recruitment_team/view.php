<?php
include('../conf/zend_smarty_conf.php');
include('recruitment_functions.php');

header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']==""){
	die("Session expires. Please re login.");
}

$team_id = $_GET['team_id'];
if($team_id == ""){
    die("Team ID is required!");
}


$sql = $db->select()
    ->from(array('r' => 'recruitment_team'))
	->join(array('a' => 'admin') , 'a.admin_id = r.team_created_by_id', Array('admin_fname', 'admin_lname'))
	->where('id =?', $team_id);
$team = $db->fetchRow($sql);

if(!$team){
    die("Team does not exist");
}

$sql = "SELECT r.admin_id, member_position, admin_fname, admin_lname, a.status FROM recruitment_team_member r JOIN admin a ON a.admin_id = r.admin_id WHERE team_id = ".$team_id. " ORDER BY a.admin_fname;";
$members = $db->fetchAll($sql);
	
//get all team history
$sql = $db->select()
    ->from(array('h' => 'recruitment_team_history'), Array('history', 'date_history'))
	->join(array('a' => 'admin'), 'a.admin_id = h.admin_id', Array('admin_fname', 'admin_lname'))
	->where('h.team_id =?', $team_id);
$histories = $db->fetchAll($sql);

$smarty->assign('histories', $histories);
$smarty->assign('members', $members);
$smarty->assign('team', $team);
$smarty->display('team.tpl');
?>