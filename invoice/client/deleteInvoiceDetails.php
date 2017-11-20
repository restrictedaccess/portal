<?php
//  2010-02-28  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   added session checking
//  -   removed tracking when invoice detail is deleted
//  -   add history

include '../../conf.php';
include '../../config.php';
include '../../time.php';

$admin_id = $_SESSION['admin_id'];
if($admin_id=="") { //session check 
    die("Session not found!\nPlease relogin");
}


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$id=$_REQUEST['id'];
$client_invoice_id = $_REQUEST['client_invoice_id'];
$tax_flag = $_REQUEST['tax'];

if($id==""){
	die("Invoice Detail ID is Missing..");
}

if($client_invoice_id==""){
	die("Invoice ID is Missing..");
}


//insert history
$sql = "select decription from client_invoice_details where id = $id";
$result = mysql_query($sql);
$data = mysql_fetch_row($result);
$description = $data[0];

$query = "INSERT into client_invoice_history (client_invoice_id, changes, changed_by_id, date_changed) VALUES ($client_invoice_id, 'DELETED DETAIL $id : $description', $admin_id, NOW())";
$result = mysql_query($query);


//delete tracking
$query="DELETE FROM timesheet_client_invoice_tracking WHERE client_invoice_details_id = $id;";
$result = mysql_query($query);
if(!$result) {
    die('failed to delete from client invoice tracking!<br>'.$query);
}


$query="DELETE FROM client_invoice_details  WHERE id = $id";
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
		//Check if GST included
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
