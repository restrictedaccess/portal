<?php

require('../conf/zend_smarty_conf.php');
include '../time.php';

$AusDate = date("Y")."-".date("m")."-".date("d");


$admin_id = $_SESSION['admin_id'];
$admin_status = $_SESSION['status'];

if ($admin_id == null){
    die('Invalid ID for Admin.');
}

$sql= $db->select()
    ->from('admin')
	->where('admin_id =?', $admin_id);
$admin = $db->fetchRow($sql);


//'draft','posted','paid'
$status = $_GET['status'];
$month = $_GET['month'];
$year = $_GET['year'];
$leads_id = $_GET['client'];
//$leads_name = $_GET['leads_name'];
//$month_fullname = $_GET['month_fullname'];

if (in_array($status, array('draft','posted','paid','overdue')) == false) {
    die("Invalid Client Tax Invoice status!");
}


if($month > 0){
	$month_conditions = " AND  MONTH(invoice_date) = '$month' ";
	$month_file_name = "_".$month_fullname;
}else{
	$month_conditions = "";
}

if($year>0){
	$year_conditions = " AND YEAR(invoice_date) = '$year' ";
	$year_filename = "_".$year;
}else{
	$year_conditions = "";
}

if($leads_id > 0){
	$client_condition = " AND c.leads_id =" .$leads_id;
	$client_filename = "_".$leads_name;
}else{
	$client_condition = "";
}

if($status!='overdue'){
	if($status=='posted'){
		$conditions = "c.status = 'posted' AND invoice_payment_due_date > '$AusDate' " .$month_conditions.$client_condition.$month_conditions.$year_conditions;
	}else{
		$conditions = "c.status = '$status'".$month_conditions.$client_condition.$month_conditions.$year_conditions;
	}
}else{
	$conditions = "c.status = 'posted' AND invoice_payment_due_date <= '$AusDate' " .$month_conditions.$client_condition.$month_conditions.$year_conditions;
}

//echo $conditions;
// Add a overdue exporting of invoice



//id, leads_id, description, payment_details, drafted_by, drafted_by_type, updated_by, updated_by_type, status, start_date, end_date, invoice_date, draft_date, post_date, last_update_date, sub_total, gst, total_amount, invoice_month, invoice_year, paid_date, invoice_number, currency, fix_currency_rate, current_rate, invoice_payment_due_date, card_type, card_transaction_date
$query = $db->select()
            ->from(array('c' => 'client_invoice'), array('id','description','leads_id','sub_total', 'gst', 'total_amount', 'currency', 'invoice_payment_due_date', 'invoice_number'))
            ->join(array('l' => 'leads'), 'l.id = c.leads_id', array('fname','lname'))
            ->where($conditions)
            ->order('l.fname ASC');
//echo $query;exit;
$invoice_records = $db->fetchAll($query);

$tmpfname = tempnam(null, null);

$handle = fopen($tmpfname, "w");

//put csv header
fputcsv($handle, array(
    '#', 
   	'Client',
    'Description',
	'Invoice Number',
	'Amount',
	'GST',
	'Currency', 
    'Total',
	'Due Date'
    ));

// separate line from the header
$record = array(" ");
fputcsv($handle, $record);
$record = array(strtoupper($status));
fputcsv($handle, $record);
$record = array(" ");
fputcsv($handle, $record);
//
$counter = 0;
foreach ($invoice_records as $line) {

	//currency symbol
	if($line['currency']){
	    $currency = $line['currency'];
	    if($currency == 'POUND') $currency = 'GBP';
	    //$sql = $db->select()
	    //    ->from('currency_lookup', 'sign')
		//    ->where('code =?', $currency);
	    //$sign = $db->fetchOne($sql);
	}	
	$counter++;
	$record = array(
			$counter, 
			sprintf('#%s %s %s ',$line['leads_id'],$line['fname'],$line['lname']),
			$line['description'],
			$line['invoice_number'],
			sprintf('%s', number_format($line['sub_total'],2,".",",")),  //amount
			sprintf('%s', number_format($line['gst'],2,".",",")) , //gst,
			sprintf('%s', $currency),
			sprintf('%s', number_format($line['total_amount'],2,".",",")),
			$line['invoice_payment_due_date']
			);
	
	fputcsv($handle, $record);
	
}


$filename_status = strtoupper($status);
$filename = "CLIENT_INVOICE_".$filename_status."_".basename($tmpfname . ".csv");
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.$filename);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($tmpfname));

//send email notify devs
$mail = new Zend_Mail('utf-8');
$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
$mail->addTo('devs@remotestaff.com.au', 'Devs');

if(! TEST){
	$output = "Admin ".sprintf('#%s %s %s', $admin['admin_id'],$admin['admin_fname'], $admin['admin_lname'])." is exporting client invoice list Filename : ".$filename;
}else{
	$output = "TEST Admin ".sprintf('#%s %s %s', $admin['admin_id'],$admin['admin_fname'], $admin['admin_lname'])." is exporting client invoice list Filename : ".$filename;
}

$mail->setSubject($output);
$mail->setBodyHtml($output);
$myImage = file_get_contents($tmpfname);
			$at = new Zend_Mime_Part($myImage);
			$at->type        = 'application/octet-stream';
			$at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
			$at->encoding = Zend_Mime::ENCODING_BASE64;
			$at->filename    = $filename;
			$mail->addAttachment($at);
$mail->send($transport);


ob_clean();
flush();
readfile($tmpfname);
unlink($tmpfname);
?>