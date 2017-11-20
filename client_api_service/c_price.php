<?php
require('../conf/zend_smarty_conf.php');

if (TEST){
	if (isset($_GET["c"])){
		$CLIENT_ID = ((int)$_GET['c']);  //must be an integer
	}else{
		if (!isset($_SESSION["client_id"])){
			echo json_encode(array("success"=>false, "error"=>"Authentication Failed"));
			die;
		}
		$CLIENT_ID = ((int)$_SESSION['client_id']);  //must be an integer
	}
}else{
	
	$CLIENT_ID = ((int)$_SESSION['client_id']);  //must be an integer
	
}
$client = new couchClient($couch_dsn, 'client_docs');
$response = $client->key($CLIENT_ID)->group()->getView('client', 'running_balance');
//echo "=> ".count($response);
$remaining_credits = $response->rows[0]->value;
if(!$remaining_credits){
    $remaining_credits = 0;
}


//client currency settings
$client->startkey(Array($CLIENT_ID, Array(date('Y'),date('m'),date('d'),date('H'),date('i'),0,0)));
$client->endkey(Array($CLIENT_ID, Array(2011,0,0,0,0,0,0)));
$client->descending(True);
$client->limit(1);
$response = $client->getView('client', 'settings');
//print_r($response->rows[0]->id);
//exit;
$currency_code = $response->rows[0]->value[0];
$currency_gst_apply = $response->rows[0]->value[1];

//Get client days_before_suspension in couchdb
$doc = $client->getDoc($response->rows[0]->id);
$days_before_suspension = $doc->days_before_suspension;

if($currency_code != ""){
    $sql = $db->select()
	    ->from('currency_lookup')
		->where('code =?', $currency_code);
	$currency = $db->fetchRow($sql);	
}


$total_staffs_per_day_rate = 0;
$number_of_days_credit = 0;
$sql_active_staff = "SELECT id,  userid, client_price, work_status FROM subcontractors WHERE status IN('ACTIVE', 'suspended') AND leads_id=".$CLIENT_ID;
$active_staffs = $db->fetchAll($sql_active_staff);
if(count($active_staffs) > 0){
    foreach($active_staffs as $s){
	    $staff_per_day_rate = 0;
		$gst = 0;
		if($s['client_price'] > 0){
		    $staff_per_day_rate = ((($s['client_price'] * 12) / 52) / 5); //client per day rate per staff
			if($currency_code == 'AUD' and $currency_gst_apply == 'Y'){
			     $gst = $staff_per_day_rate * .10;
			}
		}
		$total_staffs_per_day_rate = ($total_staffs_per_day_rate + ($staff_per_day_rate + $gst));	
	}
	try{
		if ($total_staffs_per_day_rate==0){
			$number_of_days_credit = 0;		
		}else{
			$number_of_days_credit = $remaining_credits / $total_staffs_per_day_rate;	
			
		}
	}catch(Exception $e){
		$number_of_days_credit = 0;
		
	}
}

$credits = $currency['sign'].number_format($remaining_credits,2,'.',',');
$number_of_days_credit = round($number_of_days_credit, 2);

if($days_before_suspension == "-30"){
	$credits = "N/A";
	$number_of_days_credit ="N/A";
}

echo json_encode(array(
	"success"=>true, 
	"credits"=>$credits, 
	"staffs"=>count($active_staffs), 
	"number_of_days_credit"=> $number_of_days_credit, 
	"days_before_suspension" => $days_before_suspension
));