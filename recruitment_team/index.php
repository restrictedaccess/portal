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


if(isset($_GET['nav'])){
    $body_attributes = "id='navselected'";
}else{
    $body_attributes = "id='navadminhome'";
}

$sql = $db->select()
    ->from('recruitment_team')
	->where('team_status =?', 'active');
$recruitment_teams = $db->fetchAll($sql);
$teams=array();
foreach($recruitment_teams as $team){
    $sql = "SELECT r.admin_id, member_position, admin_fname, admin_lname, a.status FROM recruitment_team_member r JOIN admin a ON a.admin_id = r.admin_id WHERE team_id = ".$team['id'];
	$members = $db->fetchAll($sql);
	
	$data = array(
	    'id' => $team['id'],
		'team' => $team['team'],
		'team_description' => $team['team_description'],
		'members' => $members    
	);
    array_push($teams, $data);		
}




$smarty->assign('teams',$teams);
$smarty->assign('selected_nav' , $_GET['nav']);
$smarty->assign('navs', $navs);
$smarty->assign('body_attributes', $body_attributes);
$smarty->display('index.tpl');
?>