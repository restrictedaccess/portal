<?php 
include '../conf/zend_smarty_conf.php';
include '../time.php'; 

if($_SESSION['agent_no']!="")
{
	$user_id = $_SESSION['agent_no'];
	$user_type = "Business Partner";
	$sql="SELECT * FROM agent WHERE agent_no = $user_id;";
	$result = $db->fetchRow($sql);
	$user_name = $result['fname']." ".$result['lname'];
	//echo "Welcome ".$user_type." ".$user_name . $ATZ;
	$query = "SELECT id, users_id, users_type, DATE_FORMAT(date_created , '%D %b %y')AS date_created, message FROM sticky_notes s WHERE users_id = $user_id AND users_type = 'agent' AND status = 'new';";
}
$result = $db->fetchAll($query);
echo count($result);

?>