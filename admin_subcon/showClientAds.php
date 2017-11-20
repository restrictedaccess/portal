<?php
include '../conf/zend_smarty_conf.php';
$smarty = new Smarty();

$leads_id = $_REQUEST['leads_id'];
$sql = $db->select()
    ->from('clients', 'prepaid')
	->where('leads_id =?', $leads_id);
$prepaid = $db->fetchOne($sql);
	
$id = $_REQUEST['id'];
$table_used = $_REQUEST['table_used'];

$posting_id =0;
if($id!=""){
	$sql = "SELECT currency, posting_id FROM ".$table_used." s WHERE id = $id;";
	$result = $db->fetchRow($sql);
	$posting_id = $result['posting_id'];
}

//Client is in Prepaid fetch the latest currency used
$CLIENT_ID = ((int)$leads_id);  //must be an integer
$CLIENT = new couchClient($couch_dsn, 'client_docs');
//client currency settings
$CLIENT->startkey(Array($CLIENT_ID, Array(date('Y'),date('m'),date('d'),date('H'),date('i'),0,0)));
$CLIENT->endkey(Array($CLIENT_ID, Array(2011,0,0,0,0,0,0)));
$CLIENT->descending(True);
$CLIENT->limit(1);
$response = $CLIENT->getView('client', 'settings');
$currency_code = $response->rows[0]->value[0];
$currency_gst_apply = $response->rows[0]->value[1];	


/*
//if the client still has no currency settings
//check the subcontractors for his existing staff and get the currency used 
if($currency_code == ""){
    $sql = "SELECT DISTINCT(currency) FROM subcontractors s WHERE leads_id = $leads_id AND currency IS NOT NULL;";
	$currencies = $db->fetchAll($sql);
	//echo count($currencies);
}
*/	

//echo $prepaid."<br>";
//echo $currency_code;


$query="SELECT p.id,DATE_FORMAT(p.date_created,'%D %b %Y')AS date_created ,p.outsourcing_model , p.companyname, p.jobposition,p.status FROM posting p WHERE p.lead_id = $leads_id  AND p.status='ACTIVE' ORDER BY p.date_created DESC;";
$result = $db->fetchAll($query);
//print_r($result);
$smarty->assign('prepaid', $prepaid);
$smarty->assign('result',$result);
$smarty->assign('posting_id',$posting_id);
$smarty->assign('currency_code', $currency_code);
$smarty->assign('currency_gst_apply', $currency_gst_apply);				



header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header('Content-type: text/plain');
$smarty->display('showClientAds.tpl');
?>