<?php
require('./conf/zend_smarty_conf_root.php');
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$sql = "SELECT DISTINCT(leads_id), fname, lname, email, company_address FROM subcontractors s LEFT JOIN leads l ON l.id = s.leads_id WHERE s.status='ACTIVE' ORDER BY l.fname;";
$result = $db->fetchAll($sql);


$filename="Remotestaff_Active_Clients_with_Active_Subcon_".$AusDate.".xls";


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

xlsWriteLabel(0,0,"Remotestaff Active Clients with Active Staff");

// Make column labels. (at line 3)
xlsWriteLabel(2,0,"ID");
xlsWriteLabel(2,1,"Client Name");
xlsWriteLabel(2,2,"Email");
xlsWriteLabel(2,3,"Address");
xlsWriteLabel(2,4,"Active Staff");


// Put data records from mysql by while loop.
// Get data records from table. 
$counter=0;
$xlsRow = 3;

foreach($result as $row)
{
	$counter++;
	xlsWriteNumber($xlsRow,0,$row['leads_id']);
	xlsWriteLabel($xlsRow,1,$row['fname']." ".$row['lname']);
	xlsWriteLabel($xlsRow,2,$row['email']);
	xlsWriteLabel($xlsRow,3,$row['company_address']);
	
	
	// get the leads subcon
	$sql = "SELECT CONCAT(p.fname,' ',p.lname)AS subcon FROM subcontractors s LEFT JOIN personal p ON p.userid = s.userid WHERE s.status = 'ACTIVE' AND s.leads_id = ".$row['leads_id']." ORDER BY p.fname;";
	$resulta = $db->fetchAll($sql);
	if(count($resulta) > 0){
		$ctr = 0;
		foreach($resulta as $line){
			$ctr++;
			xlsWriteLabel($xlsRow,4,$ctr.") ".$line['subcon']);
			$xlsRow++;			
		}
	}
	
	
	$xlsRow++;
} 
xlsEOF();


exit();

?>


