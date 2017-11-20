<?php
/*  2010-02-03 Lawrence Oliver C. Sunglao
    -   Added security
*/
include '../../conf.php';
include '../../config.php';
include '../../time.php';

if($_SESSION['admin_id']=="") {
	die("Invalid Id for Admin");
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$id=$_REQUEST['id'];
$tax=$_REQUEST['tax'];

if($id==""){
	die("Invoice ID is Missing..");
}


$query = "SELECT sub_total , total_amount , currency FROM client_invoice WHERE id = $id;";
$result =mysql_query($query);
list($sub_total, $total_amount ,$currency) = mysql_fetch_array($result);

if($tax=="true")
{
	if($currency == "AUD"){
		$percent = 10;
	}
	
	if($currency == "POUND"){
		$percent = 17.5;
	}
	
	$sub_total = $total_amount;
	$gst = (($total_amount /100)* $percent);
	
	$total_amount = ($sub_total + $gst);
	$sql="UPDATE client_invoice SET last_update_date = '$ATZ', sub_total = $sub_total, gst = $gst, total_amount = $total_amount WHERE id = $id;";
	mysql_query($sql);
	
	
}
if($tax=="false")
{
	$gst = ($total_amount * 0);
	$total_amount = ($sub_total + $gst);
	$sql="UPDATE client_invoice SET last_update_date = '$ATZ', sub_total = $sub_total, gst = $gst, total_amount = $total_amount WHERE id = $id;";
	mysql_query($sql);
}


?>
<input type="hidden" name="client_invoice_id" id="client_invoice_id" value="<?=$id;?>">
