<?php
include '../../conf.php';
include '../../config.php';
include '../../time.php';
include '../../function.php';


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$id=$_REQUEST['id'];
$start_date=$_REQUEST['start_date'];
$end_date=$_REQUEST['end_date'];
$description=filterfield($_REQUEST['description']);
$total_days_work=$_REQUEST['total_days_work'];
$rate=$_REQUEST['rate'];
$amount=$_REQUEST['amount'];
$client_invoice_id = $_REQUEST['client_invoice_id'];
$tax_flag = $_REQUEST['tax'];
//echo $description."<br>".$client_invoice_id;exit;
if($id==""){
	die("Invoice Detail ID is Missing..");
}

if($client_invoice_id==""){
	die("Invoice ID is Missing..");
}



$query="UPDATE client_invoice_details SET start_date = '$start_date', end_date = '$end_date' , decription = '$description', total_days_work = $total_days_work , rate = $rate, amount = $amount WHERE id = $id;";
$result = mysql_query($query);
if($result)
{
	$querySum="SELECT SUM(amount)AS total_amount FROM client_invoice_details WHERE client_invoice_id = $client_invoice_id;";
	//echo $querySum ."<br>";
	$resultSum=mysql_query($querySum);
	list($sub_total_amount)=mysql_fetch_array($resultSum);
	if($sub_total_amount==""){
		$sub_total_amount=0.00;
	}
	if($resultSum)
	{
		//$queryUpdateTotalAmount="UPDATE client_invoice SET total_amount = $total_amount , last_update_date = '$ATZ' WHERE id = $client_invoice_id;";
		//echo $queryUpdateTotalAmount ."<br>";
		//mysql_query($queryUpdateTotalAmount);
		if($tax_flag == "true")
		{
			$new_tax = ($sub_total_amount * .10 );
			$total_amount = ($sub_total_amount + (number_format($new_tax,2)));
		
		}else{
		
			$total_amount = $sub_total_amount ;
			$new_tax = 0.00;
		
		}
		// update payments
		$queryUpdateSub_GST_Total="UPDATE client_invoice SET sub_total = $sub_total_amount , 
									gst = $new_tax, 
									total_amount = $total_amount ,
									last_update_date = '$ATZ' 
									WHERE id = $client_invoice_id;";
		mysql_query($queryUpdateSub_GST_Total);
		
	}
	
	
	
	
	
	
	
	
}else{
	die("Error in script<br>".$query);
}
?>
<input type="hidden" name="client_invoice_id" id="client_invoice_id" value="<?=$client_invoice_id;?>">
