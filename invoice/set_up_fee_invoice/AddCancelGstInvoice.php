<?
include '../../conf.php';
include '../../config.php';
include '../../time.php';

$set_fee_invoice_id =$_REQUEST['set_fee_invoice_id'];
$flag =$_REQUEST['flag'];

$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];



if($_SESSION['agent_no']==NULL and $_SESSION['admin_id'] ==NULL){
	die("Session Id is Missing");
}

if($set_fee_invoice_id==""){
	die("Set-UP Fee Invoice ID is Missing..");
}

//Check the flag
$query = "SELECT * FROM set_up_fee_invoice s WHERE id = $set_fee_invoice_id;";
//echo $query;
$result = mysql_query($query);
$row = mysql_fetch_array($result);

$sub_total = $row['sub_total'];
$gst = $row['gst'];
$total_amount = $row['total_amount'];



if($flag == "yes"){
	$gst = ($sub_total * .10);
	$total_amount = ($sub_total + $gst);
	$gst_flag = "yes";
}

if($flag == "no"){
	$gst = 0;
	$total_amount = $sub_total;
	$gst_flag = "no";
}


$sql = "UPDATE set_up_fee_invoice SET sub_total = $sub_total, 
		gst = $gst,
		total_amount = $total_amount ,
		gst_flag = '$gst_flag'
		WHERE id = $set_fee_invoice_id;";
//echo $sql;
mysql_query($sql);

////////////
$query2 = "SELECT * FROM set_up_fee_invoice s WHERE id = $set_fee_invoice_id;";
$result2 = mysql_query($query2);
$rows = mysql_fetch_array($result2);

$sub_total = $rows['sub_total'];
$gst = $rows['gst'];
$total_amount = $rows['total_amount'];
$currency = $rows['currency'];

//AUD","USD","POUND
if($currency == "AUD"){
	$currency = "Invoice to be paid in Australian Dollar (AUD)";
}

if($currency == "USD"){
	$currency = "Invoice to be paid in United States Dollar (USD)";
}

if($currency == "POUND"){
	$currency = "Invoice to be paid in United Kingdom Pounds (POUNDs)";
}




?>

<p style="font:11px Arial; color:#0033FF;"><?=$currency;?></p>
<p><label>Sub Total :</label><span id="sub_total"><?=number_format($sub_total,2,'.',',');?></span></p>
<p><label>GST :</label><span id="gst"><?=number_format($gst,2,'.',',');?></span></p>
<p><label>Total :</label><span id="total"><?=number_format($total_amount,2,'.',',');?></span></p>
