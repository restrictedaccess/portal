<?
// Connect database. 
include 'conf.php';
include 'config.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$filename="SubConPaymentDetails".$AusDate.".xls";

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

// Get data records from table. 
$query="SELECT DISTINCT u.fname, u.lname,REPLACE (payment_details,'\r\n', ' ')
		FROM personal u
		JOIN subcontractors s ON s.userid = u.userid
		WHERE s.status = 'ACTIVE'
		ORDER BY u.fname ASC;";
$result=mysql_query($query);

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

xlsWriteLabel(0,0,"List of Sub-Contractor PAYMENT DETAILS.");

// Make column labels. (at line 3)
xlsWriteLabel(2,0,"#");
xlsWriteLabel(2,1,"Sub-Contractor Name");
xlsWriteLabel(2,2,"Payment Details");
//xlsWriteLabel(2,3,"");
//xlsWriteLabel(2,4,"Address");
//xlsWriteLabel(2,5,"Suburb");
//xlsWriteLabel(2,6,"State");
//xlsWriteLabel(2,7,"Postal Code");
//xlsWriteLabel(2,8,"Country");
//xlsWriteLabel(2,9,"No. of Employee");
//xlsWriteLabel(2,10,"Company Industry");
//xlsWriteLabel(2,11,"Employer Type");
//xlsWriteLabel(2,12,"Registered Date");

$xlsRow = 4;

// Put data records from mysql by while loop.
// Get data records from table. 
$counter=0;
while(list($fname, $lname,$payment_details) = mysql_fetch_array($result))
{
	$counter=$counter+1;
	xlsWriteNumber($xlsRow,0,$counter);
	xlsWriteLabel($xlsRow,1,$fname." ".$lname);
	xlsWriteLabel($xlsRow,2,$payment_details);
	//xlsWriteLabel($xlsRow,3,$payment_details);
	//xlsWriteLabel($xlsRow,4,$address);
	//xlsWriteLabel($xlsRow,5,$suburb);
	//xlsWriteLabel($xlsRow,6,$state);
	//xlsWriteLabel($xlsRow,7,$postcode);
	//xlsWriteLabel($xlsRow,8,$country);
	//xlsWriteLabel($xlsRow,9,$employeesno);
	//xlsWriteLabel($xlsRow,10,$industry);
	//xlsWriteLabel($xlsRow,11,$employertype);
	//xlsWriteLabel($xlsRow,12,$date);

	$xlsRow++;
} 
xlsEOF();
exit();
?>

