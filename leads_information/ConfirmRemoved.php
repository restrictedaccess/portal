<?php
include '../conf/zend_smarty_conf.php';
include '../time.php';

//id, leads_id, date_change, changes, change_by_id, change_by_type
if($_SESSION['admin_id']!="") {
	
	$change_by_id = $_SESSION['admin_id'] ;
	$change_by_type = 'admin';
	
}else if($_SESSION['agent_no']!="") {

	$change_by_id = $_SESSION['agent_no'] ;
	$change_by_type = 'bp';
	
}else{
	die("Session Expired. Please re-login");
}


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$leads_id = $_REQUEST['leads_id'];

//echo $leads_id;

$sql = $db->select()
	->from('leads_invoice')
	->where('leads_id =?' , $leads_id);
$orders = $db->fetchAll($sql);	
//echo 1;
echo count($orders);

?>

