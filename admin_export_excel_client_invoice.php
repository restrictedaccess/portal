<?php
require('./conf/zend_smarty_conf_root.php');
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

//'draft','posted','paid'
$status = $_GET['status'];
$month = $_GET['month'];
$year = $_GET['year'];
$leads_id = $_GET['client'];


$AusDate = date("Y")."-".date("m")."-".date("d");

if (in_array($status, array('draft','posted','paid','overdue')) == false) {
    die("Invalid Client Tax Invoice status!");
}


if($month > 0){
	$month_condition = " AND  c.invoice_month = '$month' ";
}
if($year>0){
	$year_condition = " AND c.invoice_year = '$year' ";
}

if($leads_id > 0){
    $condition = " AND c.leads_id =" .$client ;
}



if($month>0){
	$month_condition = " AND MONTH(invoice_date) = $month";
}

if($year >0){
	$year_condition=" AND YEAR(invoice_date) = $year";
}

$sql="SELECT c.id, c.description, c.leads_id, l.fname, l.lname FROM client_invoice c JOIN leads l ON l.id = c.leads_id WHERE c.status = '".$status."' $condition $month_condition $year_condition ORDER BY l.fname ASC;";
//echo $sql;exit;
$result = $db->fetchAll($sql);


// total nos. of client with active subcon
//echo count($result); 


//$filename="Client_With_Subcon".$ATZ.".xls";

$filename="Remotestaff_Client_Invoice_".$status."_".$AusDate.".xls";


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

xlsWriteLabel(0,0,"INVOICE-".strtoupper($status)."-".$year);

// Make column labels. (at line 3)
xlsWriteLabel(2,0,"Invoice");
xlsWriteLabel(2,1,"ID / Client Name");
xlsWriteLabel(2,2,"Invoice Description");
/*
xlsWriteLabel(2,3,"Company");
xlsWriteLabel(2,4,"Contact Nos");
xlsWriteLabel(2,5,"Client Since");
xlsWriteLabel(2,6,"Date Registered");
xlsWriteLabel(2,7,"Subcon");
*/

// Put data records from mysql by while loop.
// Get data records from table. 
$counter=0;
$xlsRow = 3;

foreach($result as $row)
{
	$counter++;
	xlsWriteNumber($xlsRow,0,$counter);
	xlsWriteLabel($xlsRow,1,sprintf('#%s %s %s', $row['leads_id'], $row['fname'], $row['lname'] ));
	
	xlsWriteLabel($xlsRow,2,$row['description']);
	/*
	xlsWriteLabel($xlsRow,3,$row['company_name']);
	xlsWriteLabel($xlsRow,4,$row['contact_nos']);
	xlsWriteLabel($xlsRow,5,$row['client_since']);
	xlsWriteLabel($xlsRow,6,$row['date_registered']);
	*/
	
	
	
	
	$xlsRow++;
} 
xlsEOF();
exit();
?>