<?php
include './conf/zend_smarty_conf.php';
include './admin_subcon/subcon_function.php';
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header('Content-type: text/html; charset=utf-8');
header("Pragma: no-cache");
$smarty = new Smarty;



$couch_client = new couchClient($couch_dsn, 'staff_invoice');

$filename="invoicing_report.xls";


// Functions for export to excel.
function xlsBOF() { 
echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); 
return; 
} 
function xlsEOF() { 
echo pack("ss", 0x0A, 0x00); 
return; 
} 
function xlsWriteNumber($Row, $Col, $Value) { 
echo pack("sssss", 0x203, 14, $Row, $Col, 0x0); 
echo pack("d", $Value); 
return; 
} 
function xlsWriteLabel($Row, $Col, $Value ) { 
$L = strlen($Value); 
echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L); 
echo $Value; 
return; 
} 

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");;
header("Content-Disposition: attachment;filename=$filename"); 
header("Content-Transfer-Encoding: binary ");


xlsBOF();

/*
Make a top line on your excel sheet at line 1 (starting at 0).
The first number is the row number and the second number is the column, both are start at '0'
*/

xlsWriteLabel(0,0,"Invoicing Report December 2011 - January 2012");

// Make column labels. (at line 3)
xlsWriteLabel(2,0,"Client");
xlsWriteLabel(2,1,"Staff");
xlsWriteLabel(2,2,"Monthly Rate");
xlsWriteLabel(2,3,"Work Status");
xlsWriteLabel(2,4,"Staff Invoice Amount in PHP for December 2011");
xlsWriteLabel(2,5,"Client Charge Out Rate");
xlsWriteLabel(2,6,"Client Invoice amount for Dec 2011");
xlsWriteLabel(2,7,"Client Invoice amount for January 2012");



$counter=0;
$xlsRow = 3;

$clients=array();

//get all clients with active staff
$sql = "SELECT COUNT(s.id)AS no_staff, s.leads_id , l.fname, l.lname FROM subcontractors s JOIN leads l ON l.id = s.leads_id WHERE s.status = 'ACTIVE' GROUP BY s.leads_id ORDER BY l.fname;";
$active_clients = $db->fetchAll($sql);
foreach($active_clients as $client){
    
	$counter++;
	xlsWriteLabel($xlsRow,0,sprintf('(%s) %s %s %s', $client['no_staff'],$client['leads_id'], $client['fname'], $client['lname']));
	//get client december 2011 invoices
	$dec_total_amount = 0;
	$sql="SELECT invoice_number, total_amount, status, currency FROM client_invoice WHERE (status = 'posted' OR status='paid') AND leads_id =" .$client['leads_id']." AND MONTH(invoice_date)='12' AND YEAR(invoice_date) ='2011'  ORDER BY draft_date DESC;";
	$dec_invoices = $db->fetchAll($sql);
	foreach($dec_invoices as $invoice){
	     $dec_total_amount = $dec_total_amount + $invoice['total_amount'];
	}
	
	xlsWriteLabel($xlsRow,6,$dec_total_amount);
	//get client january 2012 invoices
	$jan_total_amount = 0;
	$sql="SELECT invoice_number, total_amount, status, currency FROM client_invoice WHERE (status = 'posted' OR status='paid') AND leads_id =" .$client['leads_id']." AND MONTH(invoice_date)='1' AND YEAR(invoice_date) ='2012'  ORDER BY draft_date DESC;";
	$jan_invoices = $db->fetchAll($sql);
	foreach($jan_invoices as $invoice){
	     $jan_total_amount = $jan_total_amount + $invoice['total_amount'];
	}
	xlsWriteLabel($xlsRow,7,$jan_total_amount);
	
	
	
	//client active subcon
	$sql = "SELECT s.userid, p.fname, p.lname, s.client_price, s.php_monthly, s.work_status, staff_currency_id, currency FROM subcontractors s JOIN personal p ON p.userid = s.userid WHERE s.status ='ACTIVE' AND  s.leads_id = ".$client['leads_id']." ORDER BY p.fname;";
	$active_staffs = $db->fetchAll($sql);
	foreach($active_staffs as $staff){
	
	    xlsWriteLabel($xlsRow,1,sprintf('%s %s %s', $staff['userid'], $staff['fname'], $staff['lname']));
		xlsWriteLabel($xlsRow,2,$staff['php_monthly']);
		xlsWriteLabel($xlsRow,3,$staff['work_status']);
		
		$couch_client->startkey(Array((int)$staff['userid'], Array(2011,12,1)));
        $couch_client->endkey(Array((int)$staff['userid'], Array(2011,12,31)));	
		$response = $couch_client->getView('invoice','userid_date_paid_or_approved');

		foreach($response->rows as $row){
            //echo $row->value[0]; //id
	        //echo $row->value[1]; //currency
			//echo $row->value[2]; //amount
			//echo "<hr>";
			xlsWriteLabel($xlsRow,4,$row->value[2]);
			//$xlsRow++;
        }
		xlsWriteLabel($xlsRow,5,$staff['client_price']);
		$xlsRow++;
	}
	
	
	$xlsRow++;
}

xlsEOF();
exit();
?>