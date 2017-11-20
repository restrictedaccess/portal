<?php 
include '../conf/zend_smarty_conf.php';
include '../time.php'; 
require_once("../lib/Smarty/libs/Smarty.class.php");


if($_SESSION['agent_no']!="")
{
	$user_id = $_SESSION['agent_no'];
	$user_type = "Business Partner";
	$sql="SELECT * FROM agent WHERE agent_no = $user_id;";
	$result = $db->fetchRow($sql);
	$user_name = $result['fname']." ".$result['lname'];
	
	$sql = "SELECT DATE(date_created)AS date_option ,DATE_FORMAT(date_created , '%D %b %y')AS date_created  FROM sticky_notes s WHERE users_id = $user_id AND users_type = 'agent' AND status = 'new' GROUP BY DATE(date_created) ORDER BY DATE(date_created) DESC;";
	$query = "SELECT id, users_id, users_type, DATE(date_created)AS date_option2 , DATE_FORMAT(date_created , '%h:%i %p')AS time_created, message FROM sticky_notes s WHERE users_id = $user_id AND users_type = 'agent' AND status = 'new' ORDER BY id DESC;";

}

$result = $db->fetchAll($sql);
$result2 = $db->fetchAll($query);
$smarty = new Smarty();
$smarty->assign('result', $result);
$smarty->assign('result2', $result2);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/plain');
$smarty->display('OnLoadStickyNotes.tpl');


?>