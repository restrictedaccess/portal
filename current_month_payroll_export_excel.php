<?
// Connect database. 
include 'conf.php';
include 'config.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$current_month=date("m");
$ATZ = $AusDate." ".$AusTime;

$start_date =$_REQUEST['start_date'];
$end_date =$_REQUEST['end_date'];
$status = $_REQUEST['status'];
$filename="SubConCurrentMonthPayroll".$AusDate.".xls";

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

// Get data records from table. 
/*
$query="SELECT DISTINCT(s.userid),u.fname,u.lname,u.payment_details,s.total_amount
FROM subcon_invoice s
JOIN personal u ON u.userid =s.userid
WHERE drafted_by_type = 'admin'
AND s.status ='approved'
AND s.start_date='$start_date'
AND s.end_date='$end_date'
GROUP BY u.userid
ORDER BY u.fname ASC;";
*/

if(isset($_POST['export']))
{

	$query="SELECT DISTINCT(s.userid),u.fname,u.lname,s.payment_details,s.total_amount,s.converted_amount,s.exchange_rate
	FROM subcon_invoice s
	JOIN personal u ON u.userid =s.userid
	WHERE drafted_by_type = 'admin'
	AND	s.status ='$status' 
	AND invoice_date between '$start_date' AND '$end_date'
	GROUP BY u.userid
	ORDER BY u.fname ASC;";
	//echo $query;
	
	
	//MONTH(invoice_date)='11' AND MONTH(draft_date)='11'
	
	//die($query);
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
	
	
	//Make a top line on your excel sheet at line 1 (starting at 0).
	//The first number is the row number and the second number is the column, both are start at '0'
	
	
	xlsWriteLabel(0,0,"Sub-Contractor Current Month Payroll.");
	
	// Make column labels. (at line 3)
	xlsWriteLabel(2,0,"#");
	xlsWriteLabel(2,1,"Sub-Contractor Name");
	xlsWriteLabel(2,2,"Payment Details");
	xlsWriteLabel(2,3,"Peso Total Amount");
	xlsWriteLabel(2,4,"Dollar Total Amount");
	xlsWriteLabel(2,5,"Exchange Rate");
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
	while(list($userid,$fname, $lname,$payment_details,$total_amount,$converted_amount,$exchange_rate) = mysql_fetch_array($result))
	{
		$counter++;
		$payment_details2=trim($payment_details);
		//$payment_details2 = preg_replace( '/[^[:alpha:]|[:punct:]]+/', ' ', $payment_details2);
		$payment_details2 = preg_replace('/[^\w\d\-\@\.\& \^\+\=\|\\\!\#\$\%\*\(\)\{\}\[\]\'\"\<\>\,\?\/\~\`]/', '', $payment_details2);
	
		xlsWriteNumber($xlsRow,0,$counter);
		xlsWriteLabel($xlsRow,1,$fname." "."$lname");
		xlsWriteLabel($xlsRow,2,"$payment_details2");
		xlsWriteLabel($xlsRow,3,"P ".number_format($total_amount,2,'.',','));
		xlsWriteLabel($xlsRow,4,"$ ".number_format($converted_amount,2,'.',','));
		xlsWriteLabel($xlsRow,5,"$ ".number_format($exchange_rate,2,'.',','));
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
	//exit();

}
?>
<div style="background:#E1E4F0; border:#E1E4F0 outset 1px; font:bold 14px Arial; padding:5px;">Export to Excel</div>
<div style="padding:20px; border:#E1E4F0 solid 1px;">
<form name="form" method="post" action="<?=$_SERVER['PHP_SELF'];?>">
<input type="hidden" name="start_date" id="start_date" value="<?=$start_date;?>" />
<input type="hidden" name="end_date" id="end_date" value="<?=$end_date;?>" />
<select name="status" id="status" class="select">
<option value="draft">Draft</option>
<option value="approved">Approved</option>
<option value="posted" selected="selected">Paid</option>
</select>
<input type="submit" name="export" id="export" value="Export" />
</form>
</div>


