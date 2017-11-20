<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();


if($_SESSION['admin_id']=="")
{
	die("Invalid ID for Admin. Please re-login");
}


$leads_id = $_REQUEST['leads_id'];
if($leads_id == "") {
    die("leads id is missing");
}

$CLIENT_ID = ((int)$leads_id);  //must be an integer
$client = new couchClient($couch_dsn, 'client_docs');
//client currency settings
$client->startkey(Array($CLIENT_ID, Array(date('Y'),date('m'),date('d'),date('H'),date('i'),0,0)));
$client->endkey(Array($CLIENT_ID, Array(2011,0,0,0,0,0,0)));
$client->descending(True);
$client->limit(1);
$response = $client->getView('client', 'settings');
$currency_code = $response->rows[0]->value[0];
$currency_gst_apply = $response->rows[0]->value[1];

//print_r($response->rows[0]->value);

$sql = $db->select()
    ->from('leads')
	->where('id=?', $leads_id);
$lead = $db->fetchRow($sql);	

$sql = "SELECT s.userid, p.fname, p.lname FROM subcontractors s JOIN personal p ON p.userid = s.userid WHERE s.status ='ACTIVE' AND prepaid='no' AND  s.leads_id = ".$leads_id." ORDER BY p.fname;";
$staffs = $db->fetchAll($sql);


$date = new DateTime();
$date->setDate(date('Y'), date('m'), date('d'));
//$date->modify("+2 day");
$date_advanced = $date->format("Y-m-d");
$min_date = $date->format("Ymd");

$date = new DateTime();
$date->setDate(date('Y'), date('m'), date('d'));
$date->modify("+2 month");
$max_date = $date->format("Ymt");

$smarty->assign('currency_code', $currency_code);
$smarty->assign('currency_gst_apply', $currency_gst_apply);
$smarty->assign('min_date',$min_date);
$smarty->assign('max_date',$max_date);
$smarty->assign('lead', $lead);
$smarty->assign('staffs', $staffs);
$smarty->assign('staffs_count', count($staffs));
$smarty->display('ShowClientStaffListForm.tpl');
?>