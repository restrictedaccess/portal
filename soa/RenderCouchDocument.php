<?php
include '../conf/zend_smarty_conf.php';
include '../admin_subcon/subcon_function.php';

header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']==""){
	echo "Page cannot be viewed.";
	exit;
}



$couch_client = new couchClient($couch_dsn, 'subconlist_reporting');
$doc = new stdClass();
$doc->_id = $_REQUEST['doc_id'];
try {
	$response = $couch_client->getDoc($_REQUEST['doc_id']);
} catch (Exception $e) {
	echo "Something weird happened: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
	exit(1);
}

if(!$response->result){
	echo "continue";
	exit;
}

//print_r($response->start_date);
//exit; 
$subcontractor_ids_str ="";
foreach($response->subcontractor_ids as $subcon){
	//echo sprintf('%s<br>', $subcon);
	$subcontractor_ids_str.=sprintf('%s,', $subcon);
}
//exit;
//remove the last comma;
$subcontractor_ids_str=substr($subcontractor_ids_str,0,(strlen($subcontractor_ids_str)-1));
if($subcontractor_ids_str != ""){
	$sql = "SELECT s.id,s.starting_date, s.userid , p.fname, p.lname , p.email ,s.leads_id, CONCAT(l.fname,' ',l.lname)AS client_name, (l.email)AS leads_email, s.client_timezone, s.client_start_work_hour, s.client_finish_work_hour, s.work_status, s.job_designation, flexi, s.prepaid, s.staff_working_timezone, currency, staff_currency_id, client_price, php_monthly, (s.status)AS contract_status, s.date_terminated, s.resignation_date
	FROM subcontractors s
	LEFT JOIN personal p ON p.userid = s.userid
	LEFT JOIN leads l ON l.id = s.leads_id
	WHERE s.id IN ($subcontractor_ids_str) ORDER BY p.fname ;";
	//echo $sql;exit;
	$filter_staffs = $db->fetchAll($sql);
	
	$staffs = array();
	include 'filter-subconlist.php';
	
	$smarty->assign('month', date('Y-m-d', strtotime($response->start_date)));
	$smarty->assign('staffs', $staffs);
	$smarty->assign('doc_id', $_REQUEST['doc_id']);
	$smarty->display('RenderCouchDocument.tpl');
}else{
	echo "<p>No Records to be shown...</p>";
	exit;
}
?>