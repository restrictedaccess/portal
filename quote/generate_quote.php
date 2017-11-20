<?php
include '../conf/zend_smarty_conf.php';
include 'quote_functions.php';
header('Content-type: text/html; charset=utf-8');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

if($_SESSION['agent_no'] !="" or $_SESSION['agent_no'] != NULL){
	
	$agent_no = $_SESSION['agent_no'];
	$sql=$db->select()
		->from('agent')
		->where('agent_no = ?' ,$agent_no);
	$agent = $db->fetchRow($sql);
	$created_by = $_SESSION['agent_no'];
	$created_by_type = 'agent';
	
}else if($_SESSION['admin_id'] !="" or $_SESSION['admin_id'] != NULL){

	$admin_id = $_SESSION['admin_id'];
	$sql=$db->select()
		->from('admin')
		->where('admin_id = ?' ,$admin_id);
	$admin = $db->fetchRow($sql);
	$created_by = $_SESSION['admin_id'];
	$created_by_type = 'admin';

}else{

	die("Session Expires. Please re-login.");
}

$ran = get_rand_id();
$ran = CheckRan($ran);


$sql="SELECT COUNT(id)AS counter FROM quote;";
$counter = $db->fetchOne($sql);
//$counter = $result['counter'];
$counter = $counter + 1;
$quote_no = $counter.date("Y").date("n");

$leads_id=$_REQUEST['id'];
if($leads_id == ""){
    die("Leads ID is missing");
}

$currency = $_REQUEST['currency'];
//echo sprintf('%s => %s', $leads_id, $currency);

//id, created_by, created_by_type, leads_id, date_quoted, quote_no, status, date_posted, ran
$data = array(
    'created_by' => $created_by, 
	'created_by_type' => $created_by_type, 
	'leads_id' => $leads_id, 
	'date_quoted' => $ATZ, 
	'quote_no' => $quote_no,
	'ran' => $ran
);
$db->insert('quote', $data);
$quote_id = $db->lastInsertId();

$data = array('last_updated_date' => $ATZ);
$db->update('leads', $data, 'id='.$leads_id);	

echo $quote_id;
exit;
?>