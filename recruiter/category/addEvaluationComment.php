<?php
include('../../config.php') ;
include('../../conf.php') ;
include('../../conf/zend_smarty_conf_root.php');
include '../../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['admin_id']=="")
{
	die("Admin ID is Missing.");
}
$admin_id = $_SESSION['admin_id'];
$userid = $_REQUEST['userid'];
$notes = $_REQUEST['notes'];
$count = $db->fetchOne($db->select()->from(array("e"=>"evaluation_comments"), array(new Zend_Db_Expr("MAX(e.ordering) AS ordering")))->where("userid = ?", $_REQUEST["userid"]));
if (!$count){
	$count = 1;
}else{
	$count+=1;
}

$data = array(
	'userid' => $userid,
	'comment_by' => $admin_id,
	'comments' => $notes,
	'comment_date' => $ATZ,
	"ordering"=>$count
);
$db->insert('evaluation_comments', $data);

$sql = $db->select()->from("resume_evaluation_history")
	->where("userid = ?", $userid)
	->where("admin_id = ?", $admin_id)
	->where("DATE(date_created) = DATE(?)", $ATZ);
	
$found = $db->fetchRow($sql);

if (!$found){
	$db->insert("resume_evaluation_history", array("userid"=>$userid,"admin_id"=>$admin_id,"date_created"=>$ATZ));
}

$AusTime = date("h:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
$date = $ATZ;
$dateupdated = date("M d, Y H:i:s A", strtotime($date));
mysql_query("UPDATE personal SET dateupdated = '".$date."' WHERE userid = ".$userid);
?>