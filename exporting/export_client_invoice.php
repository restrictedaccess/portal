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
    $text = sprintf('Admin #%s %s %s is trying to export client invoices in %s .', $admin['admin_id'], $admin['admin_fname'], $admin['admin_lname'], $script_name);
    $to_array = array('admin@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
	die("Exporting of client invoices denied.");
	
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
    //echo "<pre>";
    //print_r($_POST);
    //echo "</pre><hr>";
    //exit; 
       
    
    $tmpfname = tempnam(null, null);
    $handle = fopen($tmpfname, "w");
    
    //put csv header
    fputcsv($handle, array(
        'Client Name',
        'Order ID',
        'Status',
        'Order Date',
        'Due Date',
        'Currency',
        'Applied GST',
        'Total Amount',
        'Payment Mode',
        'Date Paid',
        'Auto Debit',
        'Suspension Days',
        'Days Running Low',
        'Zero to Negative',
        'Client Id',
        'Couchdb Id'
    ));
        
    $from = explode("-", $_POST["from"]);
    $to = explode("-", $_POST["to"]);
    
    $currency = (string)$_POST['currency'];
    $apply_gst = (string)$_POST['apply_gst'];
    //$currency = "'".$currency."'";
    //$apply_gst = "'".$apply_gst."'";
    
    //echo "<pre>";
   	print_r($from);
    print_r($to);
    //echo "</pre>";
    //exit;
    
    $from_range = Array((int)$from[0],(int)$from[1],(int)$from[2],0,0,0,0);
    $to_range = Array((int)$to[0],(int)$to[1],(int)$to[2],23,59,59,0);
    
    //echo "<pre>";
    //print_r($from_range);
    //print_r($to_range);
    //echo "</pre>";
    //exit;
    
    $doc_client = new couchClient($couch_dsn, 'client_docs');
    
    $doc_client->endkey(Array("$currency", "$apply_gst", $to_range));
    $doc_client->startkey(Array("$currency", "$apply_gst", $from_range));    
    //$doc_client->descending(True);
    //$doc->limit(1);
    $response = $doc_client->getView('reports', 'all_invoices');
    //print_r($response);exit;
    
    foreach($response->rows as $r){
        
        $order_date = sprintf("%s-%s-%s %s:%s:%s", $r->value->order_date[0], $r->value->order_date[1], $r->value->order_date[2], $r->value->order_date[3], $r->value->order_date[4], $r->value->order_date[5]);
		$pay_before_date = "";
		if (isset($r->value->pay_before_date)){
			$pay_before_date = sprintf("%s-%s-%s %s:%s:%s", $r->value->pay_before_date[0], $r->value->pay_before_date[1], $r->value->pay_before_date[2], $r->value->pay_before_date[3], $r->value->pay_before_date[4], $r->value->pay_before_date[5]);	
		}
		
		
        /*
        $data[] = array(
            'id' => $r->id,
            'order_id' => $r->value->order_id,
            'status' => $r->value->status,
            'apply_gst' => $r->value->apply_gst,
            'date' => date("Y-m-d h:i:s" , strtotime($order_date)),
            'currency' => $r->value->currency,
            'total_amount' => $r->value->total_amount,
            'client_id' => $r->value->client_id,
            'client_name' => $r->value->client_name,
        );*/
        
        $record = array(
            $r->value->client_name,
            $r->value->order_id,
            $r->value->status,
            sprintf('%s', date("Y-m-d h:i:s" , strtotime($order_date))),
            sprintf('%s', date("Y-m-d h:i:s" , strtotime($pay_before_date))),
            $r->value->currency,
            $r->value->apply_gst,
            $r->value->total_amount,
            $r->value->payment_mode,
            $r->value->date_paid,
            //$r->value->autodebit,
			//$r->value->days_before_suspension,
			//$r->value->days_running_low,
			$r->value->zero_to_negative_day_notice,
            $r->id,
            $r->value->client_id
        );
        fputcsv($handle, $record);
        
           
    }
    //echo "<pre>";
    print_r($record);
    //echo "</pre>";
    //exit;
    
    $filename ="Remotestaff_Clients_Invoice_".basename($tmpfname . ".csv");
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
    $subject = "Exporting of Client Invoice";
    $text = sprintf('Admin #%s %s %s exported Client Invoice in %s', $admin['admin_id'],$admin['admin_fname'], $admin['admin_lname'], $script_name);
    $to_array = array('normanm@remotestaff.com.au', 'charisse.m@remotestaff.com.au', 'allan.t@remotestaff.com.au');
    SaveToCouchDBMailbox($attachments_array, $bcc_array, $cc_array, $from, $html, $subject, $text, $to_array);
        
    
    
    ob_clean();
    flush();
    readfile($tmpfname);
    unlink($tmpfname);
    

}

$smarty->assign('from', date("Y-m-d"));
$smarty->assign('to', date("Y-m-t"));
$smarty->assign('admin', $admin);
$smarty->display('client_invoice.tpl');
exit;
?>