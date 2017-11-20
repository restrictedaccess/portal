<?php
ini_set("memory_limit", -1);
require('../conf/zend_smarty_conf.php');

$leads_id = 11; //((int)$_GET['leads_id']);

$from = "2014-05-01";
$to = "2014-06-01";


$all_client = TRUE;

///$doc_client_docs = new couchClient($couch_dsn, 'client_docs');
//$doc_time_record_id = "b13c330f689b3531b21344be74f2338d"; 
//$doc_client_docs->key("$doc_time_record_id");
//$result = $doc_client_docs->getView('timerecord', 'tracking');
//print_r($result->rows);
//exit;


if( isset($_GET["from"]) and isset($_GET["to"]) ){
	$from = $_GET["from"];
	$to = $_GET["to"];
}

if( isset($_GET["leads_id"])){
	$leads_id = $_GET["leads_id"];
	$all_client = FALSE;
}



$from = explode("-", $from);
$to = explode("-", $to);

    
$from_range = Array((int)$from[0],(int)$from[1],(int)$from[2],0,0,0,0);
$to_range = Array((int)$to[0],(int)$to[1],(int)$to[2],23,59,59,0);

/*
 *http://184.107.130.10:5984/rssc_time_records/_design/reports/_view/not_charged_per_client?startkey=[11,[2014,5,2,0,0,0]]&endkey=[11,[2014,5,2,23,59,59]] 
 */

$doc_rssc = new couchClient($couch_dsn, 'rssc_time_records'); 

if($all_client){
	$doc_rssc->startkey($from_range);
	$doc_rssc->endkey($to_range);
	$response = $doc_rssc->getView('reports', 'not_charged');
	$label_str = "Leads Id";
}else{
	$doc_rssc->startkey(Array(intval($leads_id), $from_range));
	$doc_rssc->endkey(Array(intval($leads_id), $to_range));
	$response = $doc_rssc->getView('reports', 'not_charged_per_client');
	$label_str = "Userid";	
}



echo "<pre>";
//print_r($response);


$doc_client_docs = new couchClient($couch_dsn, 'client_docs');

echo "<ol>";

$data=array();
foreach($response->rows as $r){
	
	//Check the doc_id if already charged.
	/*
	 * http://184.107.130.10:5984/client_docs/_design/timerecord/_view/tracking?key=%22000ab73c6d144c1e8a1e99aef3175725%22
	 */
	 	 
	
	$doc_time_record_id = $r->id; 
	$doc_client_docs->key("$doc_time_record_id");
	$result = $doc_client_docs->getView('timerecord', 'tracking');
	//print_r($result->rows);
	
	
	if (count($result->rows)==0){
		echo "<li><ul>";
			echo "<li>Doc Id => ".$r->id."</li>";
			echo "<li>Charged => ".count($result->rows)."</li>";
			echo "<li>{$label_str} => ".$r->value[2]."</li>";
			echo "<li>Subcon Id => ".$r->value[3]."</li>";
		echo "</ul></li>";		
	}

	
		
	
}
echo "</ol>";
echo "</pre>";
exit;
?>