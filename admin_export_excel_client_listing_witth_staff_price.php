<?php
require('./conf/zend_smarty_conf_root.php');
include 'time.php';

if($_SESSION['admin_id']=="")
{
	die("Page cannot be viewed!");
}


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$query = "SELECT DISTINCT(l.id), CONCAT(l.fname,' ',l.lname)AS client_name , l.email FROM leads l LEFT JOIN subcontractors s ON s.leads_id =  l.id WHERE l.status = 'Client'  AND s.status = 'ACTIVE' ORDER BY l.fname ASC;";
$result = $db->fetchAll($query);

// total nos. of client with active subcon
//echo count($result); 


//$filename="Client_With_Subcon".$ATZ.".xls";

$filename="Remotestaff_Client_with_Subcon_".$AusDate.".xls";


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

xlsWriteLabel(0,0,"Remotestaff Clients with Subcon");

// Make column labels. (at line 3)
xlsWriteLabel(2,0,"ID");
xlsWriteLabel(2,1,"Client Name");
xlsWriteLabel(2,2,"Email");
xlsWriteLabel(2,3,"Subcon");
xlsWriteLabel(2,4,"Client Monthly Price");
xlsWriteLabel(2,5,"Client Hourly Price");
xlsWriteLabel(2,7,"Staff Monthly Price");
xlsWriteLabel(2,8,"Staff Monthly Price");
xlsWriteLabel(2,9,"Work Status");
xlsWriteLabel(2,10,"No.of Working Days");
xlsWriteLabel(2,11,"No.of Working Hours");

// Put data records from mysql by while loop.
// Get data records from table. 
$counter=0;
$xlsRow = 3;

foreach($result as $row)
{
	$counter++;
	xlsWriteNumber($xlsRow,0,$row['id']);
	xlsWriteLabel($xlsRow,1,$row['client_name']);
	xlsWriteLabel($xlsRow,2,$row['email']);

	
	
	// get the leads subcon
	$sql = "SELECT CONCAT(p.fname,' ',p.lname)AS subcon , client_price , php_monthly , working_days , working_hours , work_status FROM subcontractors s LEFT JOIN personal p ON p.userid = s.userid WHERE s.status = 'ACTIVE' AND s.leads_id = ".$row['id'].";";
	$resulta = $db->fetchAll($sql);
	if(count($resulta) > 0){
		$ctr = 0;
		foreach($resulta as $line){
			$ctr++;
			xlsWriteLabel($xlsRow,3,$line['subcon']);
			xlsWriteLabel($xlsRow,4,$line['client_price']);
			
			if($line['client_price'] != "" and $line['working_days'] != "" and $line['working_hours']!=""){
				$client_hourly = (((($line['client_price'] * 12)/52)/$line['working_days'])/$line['working_hours']);
				xlsWriteLabel($xlsRow,5,$client_hourly);
			}
			
			
			xlsWriteLabel($xlsRow,7,$line['php_monthly']);
			
			if($line['php_monthly'] != "" and $line['working_days'] != "" and $line['working_hours']!=""){
				$staff_hourly = (((($line['php_monthly'] * 12)/52)/$line['working_days'])/$line['working_hours']);
				xlsWriteLabel($xlsRow,8,$staff_hourly);
			}
			
			xlsWriteLabel($xlsRow,9,$line['work_status']);
			xlsWriteLabel($xlsRow,10,$line['working_days']);
			xlsWriteLabel($xlsRow,11,$line['working_hours']);
			
			$xlsRow++;			
		}
	}
	
	
	$xlsRow++;
} 
xlsEOF();


exit();

?>


