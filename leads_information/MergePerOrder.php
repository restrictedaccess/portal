<?php
//2010-11-08 Normaneil Macutay <normanm@remotestaff.co.au>
include '../conf/zend_smarty_conf.php';

if($_SESSION['agent_no'] != "" || $_SESSION['agent_no'] !=NULL){
	$created_by_id = $_SESSION['agent_no'];
	$created_by_type = 'agent';
}else if($_SESSION['admin_id'] != "" || $_SESSION['admin_id']!=NULL){
	$created_by_id = $_SESSION['admin_id'];
	$created_by_type = 'admin';
}else{
	die("Session Expired. Please re-login");
}

$leads_transactions_id = $_REQUEST['leads_transactions_id'];
if(!$leads_transactions_id){
	echo "Leads Transactions ID is missing";
	exit;
}


//id, leads_id, leads_new_info_id, reference_column_name, reference_no, reference_table, date_added
$where = "id = ".$leads_transactions_id;	
$db->delete('leads_transactions' , $where);


echo "Successfully merged!";
exit;

?>

