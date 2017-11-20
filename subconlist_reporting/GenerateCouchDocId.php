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
	echo "Page cannot be viewed.";
	exit;
}

$sql=$db->select()
    ->from('admin')
	->where('admin_id =?',$_SESSION['admin_id']);
$admin = $db->fetchRow($sql);	

$from = $_REQUEST['from'];
$to = $_REQUEST['to'];


// If time1 is bigger than time2
// Then swap from and to
if (strtotime($_REQUEST['from']) > strtotime($_REQUEST['to'])) {
	$ttime = $_REQUEST['from'];
	$from = $_REQUEST['to'];
	$to = $ttime;
}
//echo sprintf('%s %s', $from, $to);
//exit;
//get all clients with active staff
//$sql = "SELECT s.leads_id FROM subcontractors s WHERE s.status IN ('ACTIVE','suspended') GROUP BY s.leads_id;";

$search_str="";
if($_REQUEST['csro_id']){
	$search_str= sprintf(' AND l.csro_id=%s', $_REQUEST['csro_id']);
}

$sql = "SELECT s.leads_id FROM subcontractors s JOIN leads l ON l.id= s.leads_id WHERE s.status IN ('ACTIVE','suspended') ".$search_str."  GROUP BY s.leads_id;";
//echo $sql;
$clients = $db->fetchAll($sql);
foreach($clients as $client){
	$ACTIVE_CLIENTS[]=$client['leads_id'];
}

//echo "<pre>";
//print_r($ACTIVE_CLIENTS);
//echo "</pre>";
//exit;
$leads_id=array();
if($_REQUEST['active_client_filter'] == 'all'){
	foreach($clients as $client){
		$leads_id[]=$client['leads_id'];
	}
}

if($_REQUEST['active_client_filter'] == 'leads_id'){
	$leads_id[] = $_REQUEST['active_client'];
}


if($_REQUEST['inactive_client_filter'] == 'all'){
	//get all clients with inactive staff
	//$sql = "SELECT s.leads_id FROM subcontractors s WHERE s.status IN ('terminated','resigned') GROUP BY s.leads_id;";
	$sql = "SELECT s.leads_id FROM subcontractors s LEFT JOIN leads l ON l.id=s.leads_id WHERE s.status IN ('terminated','resigned') ".$search_str." GROUP BY s.leads_id;";
	//echo $sql;
	//exit;
	$inactive_clients = $db->fetchAll($sql);
	
	foreach($inactive_clients as $client){
		if(!in_array($client['leads_id'],$ACTIVE_CLIENTS)){
			$leads_id_str .=sprintf('%s,',$client['leads_id']);
		}
	}
	if($leads_id_str){
		$leads_id_str=substr($leads_id_str,0,(strlen($leads_id_str)-1));
		$sql = "SELECT (id)AS leads_id , l.fname, l.lname FROM leads l WHERE id IN ($leads_id_str) ORDER BY l.fname;";
		$inactive_clients = $db->fetchAll($sql);
		foreach($inactive_clients as $client){
			$leads_id[] = $client['leads_id'];
		}
	}
}

if($_REQUEST['inactive_client_filter'] == 'leads_id'){
	$leads_id[] = $_REQUEST['inactive_client'];
}



if($_REQUEST['filter'] != 'all'){
	//echo $_REQUEST['filter'];
	$filter_leads_id = $leads_id;
	//echo "filter_leads_id => ".count($filter_leads_id);
	//echo "<br>";
	$leads_id=array();


	foreach($filter_leads_id as $lead){
		//echo $lead;
		$client_filter = "";
		$days_before_suspension ="0";
		$CLIENT_ID = ((int)$lead);  //must be an integer
		$CLIENT = new couchClient($couch_dsn, 'client_docs');
		
		//client currency settings
		$CLIENT->startkey(Array($CLIENT_ID, Array(date('Y'),date('m'),date('d'),date('H'),date('i'),0,0)));
		$CLIENT->endkey(Array($CLIENT_ID, Array(2011,0,0,0,0,0,0)));
		$CLIENT->descending(True);
		$CLIENT->limit(1);
		$CLIENT->include_docs(True);
		$response = $CLIENT->getView('client', 'settings');
		$doc = $response->rows[0]->doc;
		$doc->days_before_suspension;
		
		if($doc->days_before_suspension){
			$days_before_suspension = sprintf('%s', $doc->days_before_suspension);
			if(sprintf('%s', $doc->days_before_suspension) == '-30'){
				$client_filter = 'old';
			}else{
				$client_filter = 'new';
			}
		}else{
			$client_filter = 'new';
		}
		

		//echo $client_filter;
		//echo "<br>";
		if($_REQUEST['filter'] == $client_filter){
			$leads_id[] = $lead;
		}		
	}
	//echo "<hr>";
	//echo count($leads_id);
	
}
//exit;

//echo "<pre>";
//echo count($leads_id);
//echo "<br>";
//echo $_REQUEST['filter'];
//echo "<br>";
//print_r($leads_id);
//echo "</pre>";
//exit;



if($leads_id){
    $leads_id = array_unique($leads_id);	
	$leads_id_str="";
	foreach($leads_id as $lead){
		
			$leads_id_str .=sprintf('%s,',$lead);
			$clients[]=$lead;
		
	}
	$leads_id_str=substr($leads_id_str,0,(strlen($leads_id_str)-1));
	$conditions = " AND s.leads_id IN($leads_id_str)";
}else{
	echo "No result";
	exit;
}

if($_REQUEST['csro_id']){
	//$conditions = sprintf('%s AND csro_id');
}

$sql = "SELECT s.id, s.starting_date, (s.status)AS contract_status, s.date_terminated, s.resignation_date FROM subcontractors s WHERE  s.status IN ('ACTIVE', 'suspended', 'terminated', 'resigned') $conditions ;";
//echo $sql;exit;
$subcontractors = $db->fetchAll($sql);
$subcontractor_ids = array();
foreach($subcontractors as $subcon){
	
    if($subcon['contract_status'] == 'ACTIVE'){
	    $starting_date = $subcon['starting_date'];
		$starting_date = date('Y-m-d',strtotime($starting_date));
		if(strtotime($starting_date) <= strtotime($to)){
			array_push($subcontractor_ids, $subcon['id']);
		}
	}
	
	if($subcon['contract_status'] == 'deleted'){
	    $starting_date = $subcon['starting_date'];
		$starting_date = date('Y-m-d',strtotime($starting_date));
		if(strtotime($starting_date) <= strtotime($to)){
			array_push($subcontractor_ids, $subcon['id']);
		}
	}
	
	if($subcon['contract_status'] == 'suspended'){
	    $starting_date = $subcon['starting_date'];
		$starting_date = date('Y-m-d',strtotime($starting_date));
		if(strtotime($starting_date) <= strtotime($to)){
			array_push($subcontractor_ids, $subcon['id']);
		}
	}
	
	if($subcon['contract_status'] == 'resigned'){
		$end_date = $subcon['resignation_date'];
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
	if($subcon['contract_status'] == 'terminated'){
		$end_date = $subcon['date_terminated'];
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
   echo "Something weird happened: ".$e->getMessage()." (errcode=".$e->getCode().")\n";
   exit(1);
}
subconlist_reporting_adj_hours($response->id);
//echo "<pre>";
//echo sprintf('Doc Id => %s',$response->id);
//echo "</pre>";
$smarty->assign('doc_id', $response->id);
$smarty->display('GenerateCouchDocId.tpl');

?>