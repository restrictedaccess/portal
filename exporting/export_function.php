<?php
$admin_with_permission = array(5, 6, 43, 165, 380, 415, 419, 325, 384, 389);
function get_client_currency_setting($CLIENT_ID){
	global $couch_dsn;
	$currency_code = NULL;
	$currency_gst_apply = NULL;
	
	$CLIENT_ID = ((int)$CLIENT_ID);  //must be an integer
    $CLIENT = new couchClient($couch_dsn, 'client_docs');
	//client currency settings
	$CLIENT->startkey(Array($CLIENT_ID, Array(date('Y'),date('m'),date('d'),date('H'),date('i'),0,0)));
	$CLIENT->endkey(Array($CLIENT_ID, Array(2011,0,0,0,0,0,0)));
	$CLIENT->descending(True);
	$CLIENT->limit(1);
	if($CLIENT){
		$response = $CLIENT->getView('client', 'settings');
		if($response){
			$currency_code = $response->rows[0]->value[0];
			$currency_gst_apply = $response->rows[0]->value[1];
		}
	}
	return array('currency_code' => $currency_code, 'apply_gst' => $currency_gst_apply);
}
?>