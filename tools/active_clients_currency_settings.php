<?php
include('../conf/zend_smarty_conf.php');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

//GET ALL ACTIVE CLIENTS WITH AT LEAST 1 ACTIVE STAFF
$sql = "SELECT leads_id, l.fname, l.lname, l.email FROM subcontractors s JOIN leads l ON l.id = s.leads_id  WHERE s.status='ACTIVE' GROUP BY s.leads_id ORDER BY l.fname;";
$clients = $db->fetchAll($sql);
$active_clients = array();
foreach($clients as $client){
    
    $CLIENT_ID = ((int)$client['leads_id']);  //must be an integer
    $CLIENT = new couchClient($couch_dsn, 'client_docs');
    //client currency settings
    $CLIENT->startkey(Array($CLIENT_ID, Array(date('Y'),date('m'),date('d'),date('H'),date('i'),0,0)));
    $CLIENT->endkey(Array($CLIENT_ID, Array(2011,0,0,0,0,0,0)));
    $CLIENT->descending(True);
    $CLIENT->limit(1);
    $response = $CLIENT->getView('client', 'settings');
	/*
	$data= array(
	    'leads_id' => $client['leads_id'],
		'fname' => $client['fname'],
		'lname' => $client['lname'],
		'email' => $client['email'],
        'currency_code' => $response->rows[0]->value[0],
        'currency_gst_apply' => $response->rows[0]->value[1]				
	);
	*/
	//array_push($active_clients,$data);
    echo "<pre>";
	echo sprintf('%s %s %s<br>', $client['leads_id'], $client['fname'] , $client['lname']);
	$sql = "SELECT DISTINCT(currency)AS currency_code FROM subcontractors s where status='ACTIVE' AND leads_id = ".$client['leads_id']." AND currency IS NOT NULL AND currency != '';";
	$currency = $db->fetchAll($sql);
	echo "subcontractors.currency =>";
	foreach($currency as $c){
	    echo sprintf('[%s] ', $c['currency_code']);
	}
	echo "<br>";
	echo "couchdb currency settings =>";
	echo sprintf('%s %s ', $response->rows[0]->value[0], $response->rows[0]->value[1]);
	echo "<br>";
	echo "</pre>";
}


//echo "<pre>";
//print_r($active_clients);
//echo "</pre>";
//$smarty->assign('active_clients',$active_clients);
//$body = $smarty->fetch('active_clients_currency_settings.tpl');
//echo $body;
?>