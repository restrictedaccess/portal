<?php
ini_set("memory_limit","100M");
include('conf/zend_smarty_conf.php');
require_once "recruiter/lib/Force.php";
$date_start = $_GET["date_start"];
$date_end = $_GET["date_end"];

$data = array("id"=>"ID4", "jsonrpc"=>"2.0","method"=>"get_clients_transactions", "params"=>array($date_start,$date_end));

$data_string = json_encode($data);                                                                                   
if (TEST){
	$ch = curl_init('http://test.remotestaff.com.au/portal/django/admin_running_balance_maintenance/jsonrpc/');	
}else{
	$ch = curl_init('http://remotestaff.com.au/portal/django/admin_running_balance_maintenance/jsonrpc/');
}
                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
 
$result = curl_exec($ch);
$result = json_decode($result);
$fp = fopen('all_client_balance.csv', 'w');

fputcsv($fp, array("Client", "Client ID", "Transaction Date", "Type", "Particular", "Remarks", "Added By", "Credit", "Charge", "Available Balance"));

foreach($result->result as $result_item){
	$transaction_date = $result_item->added_on[0]."-".$result_item->added_on[1]."-".$result_item->added_on[2]." ".$result_item->added_on[3].":".$result_item->added_on[4].":".$result_item->added_on[5];
	fputcsv($fp, array($result_item->client_fname." ".$result_item->client_lname, $result_item->client_id, $transaction_date, $result_item->credit_type, $result_item->particular,$result_item->remarks, $result_item->added_by, $result_item->credit, $result_item->charge, $result_item->running_balance));
}
fclose($fp);
output_file("all_client_balance.csv", "all_client_balance.csv", "text/csv");
unlink("all_client_balance.csv");
