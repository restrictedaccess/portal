<?php
require('../conf/zend_smarty_conf.php');
require('../tools/CouchDBMailbox.php');
include('export_function.php');
require('../admin_subcon/subcon_function.php');

header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$smarty = new Smarty;

if($_SESSION['admin_id']=="") {
    die("Admin ID is missing.");
}


$script_name = $_SERVER['SCRIPT_FILENAME'];
if($_SERVER['QUERY_STRING']){
    $script_name =sprintf('%s?%s', $script_name,$_SERVER['QUERY_STRING'] );
}
    
$sql= $db->select()
    ->from('admin')
	->where('admin_id =?', $_SESSION['admin_id']);
$admin = $db->fetchRow($sql);

if (in_array($_SESSION['admin_id'], $admin_with_permission) == False) {
    	
	$attachments_array =NULL;
	$bcc_array=array('devs@remotestaff.com.au');
    $cc_array = NULL;
    $from = 'No Reply<noreply@remotestaff.com.au>';
    $html = NULL;
    $subject = "Permission Denied.";
    $text = sprintf('Admin #%s %s %s is trying to export client running balance (as of by date) %s .', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname'], $script_name);
    $to_array = array('admin@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	die("Exporting of client invoices denied.");
	
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){


	$doc_client = new couchClient($couch_dsn, 'client_docs'); 
	
	
	$from = explode("-", $_POST["from"]);
	
	$year = intval($from[0]);
	$month = intval($from[1]);
	$day = intval($from[2]);
	
	
	$from_range = Array($year,$month,$day,0,0,0,0);
	$to_range = Array($year,$month,$day,23,59,59,0);
	
	$doc_client->startkey(Array($from_range));
	$doc_client->endkey(Array($to_range));    
	$response = $doc_client->getView('reports', 'rssc_prepaid_on_finish_work');
	//echo "<pre>";
	//print_r($response);
	//exit;
	
	
	
	
	$tmpfname = tempnam(null, null);
	$handle = fopen($tmpfname, "w");
	
	//put csv header
	fputcsv($handle, array(
	    'Client ID',
	    'Client Name',
	    'Currency',
	    'Client Houry Rate',
	    'Charge',
	    'Running Balance',
	    'Added On',
	    'Type',
	    'Particular'
	));
	
	foreach($response->rows as $r){
		
		$sql = "SELECT CONCAT(fname,' ', lname)AS client_name FROM leads WHERE id=".$r->value->client_id;
		$client_name = $db->fetchOne($sql);
		/*
	    $data[] = array(
	        'id' => $r->id,
	        'client_id' => $r->value->client_id,
	        'currency' => $r->value->currency,
	        'client_name' => $client_name,
	        'client_hourly_rate' => $r->value->client_hourly_rate,
	        'charge' => $r->value->charge,
	        'running_balance' => $r->value->running_balance,
	        'added_on' => $r->value->added_on,
	        'type' => $r->value->type,
	        'particular' => $r->value->particular        
	    );*/
	    $added_on = sprintf("%s-%s-%s %s:%s:%s", $r->value->added_on[0], $r->value->added_on[1], $r->value->added_on[2], $r->value->added_on[3], $r->value->added_on[4], $r->value->added_on[5]);
		$added_on = date('Y-m-d H:i:s', strtotime($added_on));
	    $record = array(
	        $r->value->client_id,
	        $client_name,
	        $r->value->currency,
	        $r->value->client_hourly_rate,
	        $r->value->charge,
	        $r->value->running_balance,
	        $added_on,
	        $r->value->credit_type,
	        $r->value->particular
	    );
	    fputcsv($handle, $record);           
	}
	
	
	$filename ="Remotestaff_Clients_Running_Balance_{$year}_{$month}_{$day}".basename($tmpfname . ".csv");
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.$filename);
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . filesize($tmpfname));
	
	
	
	$attachments_array=array();
    $data=array(
        'tmpfname' => $tmpfname,
        'filename' => $filename
    );
    array_push($attachments_array, $data);
    
    $bcc_array= NULL;
    $cc_array = NULL;
    $from = 'No Reply<noreply@remotestaff.com.au>';
    $html = NULL;
    $subject = "Exporting of Client Running Balance";
    $text = sprintf('Admin #%s %s %s exported Client Running Balance %s', $admin['admin_id'],$admin['admin_fname'], $admin['admin_lname'], $script_name);
    $to_array = array('normanm@remotestaff.com.au', 'charisse.m@remotestaff.com.au', 'allan.t@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	
	
	ob_clean();
	flush();
	readfile($tmpfname);
	unlink($tmpfname);
	//print_r($data);
	//echo "</pre>";
	
}

$smarty->assign('from', date("Y-m-d"));
$smarty->assign('admin', $admin);
$smarty->display('export_client_running_balance.tpl');
exit;
?>