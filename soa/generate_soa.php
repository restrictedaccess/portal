<?php
include '../conf/zend_smarty_conf.php';
include '../admin_subcon/subcon_function.php';
include 'mq_producer_subconlist_reporting_adj_hours.php';

header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']==""){
	echo json_encode(array("success"=>false, "msg"=>"Session expires. Please re-login" ));
	exit;
}

$sql=$db->select()
    ->from('admin')
	->where('admin_id =?',$_SESSION['admin_id']);
$admin = $db->fetchRow($sql);	

$data = json_decode(file_get_contents('php://input'), true);
$leads_id = $data["Query"]["leads_id"];
$clients[] = $leads_id;
$date_str= explode('/', $data["Query"]["date_str"]);

$from =  date('Y-m-d', strtotime(sprintf('%s-%s-01', $date_str[1],$date_str[0])));
$to = date('Y-m-t', strtotime($from));
//echo $to;
//exit;

$sql = "SELECT s.id, s.starting_date, s.status, s.end_date FROM subcontractors s WHERE s.status IN('ACTIVE','suspended', 'resigned', 'terminated') AND s.leads_id=".$leads_id;
$subcontractors = $db->fetchAll($sql);
$subcontractor_ids = array();
foreach($subcontractors as $subcon){
	
    if($subcon['status'] == 'ACTIVE'){
	    $starting_date = $subcon['starting_date'];
		$starting_date = date('Y-m-d',strtotime($starting_date));
		if(strtotime($starting_date) <= strtotime($to)){
			array_push($subcontractor_ids, $subcon['id']);
		}
	}
	
	if($subcon['status'] == 'suspended'){
	    $starting_date = $subcon['starting_date'];
		$starting_date = date('Y-m-d',strtotime($starting_date));
		if(strtotime($starting_date) <= strtotime($to)){
			array_push($subcontractor_ids, $subcon['id']);
		}
	}
	
	if($subcon['status'] == 'resigned'){
		$end_date = $subcon['end_date'];
		$end_date = date('Y-m-d',strtotime($end_date));
		
		$starting_date = $subcon['starting_date'];
		$starting_date = date('Y-m-d',strtotime($starting_date));
		if(strtotime($starting_date) <= strtotime($to)){
		    if( strtotime($end_date) >= strtotime($from) and strtotime($end_date) >= strtotime($to) ){
				array_push($subcontractor_ids, $subcon['id']);
		    }
		
		    if( strtotime($end_date) >= strtotime($from) and strtotime($end_date) <= strtotime($to) ){
				array_push($subcontractor_ids, $subcon['id']);
		    }
		}
		
	}
	if($subcon['status'] == 'terminated'){
		$end_date = $subcon['end_date'];
		$end_date = date('Y-m-d',strtotime($end_date));
		
		$starting_date = $subcon['starting_date'];
		$starting_date = date('Y-m-d',strtotime($starting_date));
		
		if(strtotime($starting_date) <= strtotime($to)){
		    if( strtotime($end_date) >= strtotime($from) and strtotime($end_date) >= strtotime($to) ){
			    array_push($subcontractor_ids, $subcon['id']);
		    }
		
		    if( strtotime($end_date) >= strtotime($from) and strtotime($end_date) <= strtotime($to) ){
			    array_push($subcontractor_ids, $subcon['id']);
		    }
		}
		
	}
	$end_date = "";
	
}
//echo "<pre>";
//print_r($subcontractor_ids) ;
//echo "</pre>";
//exit;

//save details in couchdb
$couch_client = new couchClient($couch_dsn, 'subconlist_reporting');
$doc = new stdClass();
$doc->client_id = $clients;
$doc->generated_in = $_SERVER['SCRIPT_FILENAME'];
$doc->requested_by = sprintf('%s %s', $admin['admin_fname'], $admin['admin_lname']);
$doc->requested_on = date('Y-m-d H:i:s');
$doc->start_date= $from;
$doc->end_date=$to;
$doc->subcontractor_ids = $subcontractor_ids;
	
//echo "Storing \$doc : \$client->storeDoc(\$doc)\n";
try {
	$response = $couch_client->storeDoc($doc);
} catch (Exception $e) {
   $msg =  "Something weird happened: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
   echo json_encode(array("success"=>false, "msg"=>$msg));
   exit(1);
}
subconlist_reporting_adj_hours($response->id);
echo json_encode(array("success"=>true, "doc_id"=>$response->id));
?>