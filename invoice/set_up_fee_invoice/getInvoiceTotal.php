<?
include '../../conf.php';
include '../../config.php';
include '../../time.php';

$set_fee_invoice_id =$_REQUEST['set_fee_invoice_id'];
$agent_no = $_SESSION['agent_no'];
$admin_id = $_SESSION['admin_id'];

if($_SESSION['agent_no']==NULL and $_SESSION['admin_id'] ==NULL){
	die("Session Id is Missing");
}

if($set_fee_invoice_id==""){
	die("Set-UP Fee Invoice ID is Missing..");
}

$query = "SELECT * FROM set_up_fee_invoice s WHERE id = $set_fee_invoice_id;";
$result = mysql_query($query);
$row = mysql_fetch_array($result);

$sub_total = $row['sub_total'];
$gst = $row['gst'];
$total_amount = $row['total_amount'];
$currency = $row['currency'];

//AUD","USD","POUND
if($currency == "AUD"){
	$currency = "Invoice to be paid in Australian Dollar (AUD)";
	$currency_symbol = "\$";
	$tax = "GST : ";
}

if($currency == "USD"){
	$currency = "Invoice to be paid in United States Dollar (USD)";
	$currency_symbol = "\$";
	$tax = "TAX : ";
}

if($currency == "POUND"){
	$currency = "Invoice to be paid in United Kingdom Pounds (POUNDs)";
	$currency_symbol = "&pound;";
	$tax = "TAX : ";
}

?>

<div style="text-align:right;"><?=$currency_txt;?></div>
<div>
<div style=" float:right;width:100px; text-align:right;"><?=$currency_symbol;?> <span id="sub_total"><?=number_format($sub_total,2,'.',',');?></span></div>
<div style="float:right;  display:block;"><b>Sub Total : </b></div>
<div style="clear:both;"></div>
</div>

<div>
<div style=" float:right;width:100px;text-align:right;"><?=$currency_symbol;?> <span id="gst"><?=number_format($gst,2,'.',',');?></span></div>
<div style="float:right;  display:block;"><b><?php echo $tax;?></b></div>
<div style="clear:both;"></div>
</div>


<div>
<div style=" float:right; width:100px;text-align:right;"><?=$currency_symbol;?> <span id="total"><?=number_format($total_amount,2,'.',',');?></span></div>
<div style="float:right;  display:block;"><b>TOTAL : </b></div>
<div style="clear:both;"></div>
</div>