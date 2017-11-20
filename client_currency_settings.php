<?php
include('conf/zend_smarty_conf.php');

if($_SESSION['admin_id'] ==""){
	die("Page cannot be viewed");
}


$CLIENT_ID = ((int)$_GET['leads_id']);  //must be an integer
$CLIENT = new couchClient($couch_dsn, 'client_docs');
    //client currency settings
$CLIENT->startkey(Array($CLIENT_ID, Array(date('Y'),date('m'),date('d'),date('H'),date('i'),0,0)));
$CLIENT->endkey(Array($CLIENT_ID, Array(2011,0,0,0,0,0,0)));
$CLIENT->descending(True);
$CLIENT->limit(1);
$response = $CLIENT->getView('client', 'settings');

echo "<pre>";
print_r($response);
echo "</pre>";
?>