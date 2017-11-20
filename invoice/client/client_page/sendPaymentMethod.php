<?
include '../../../conf.php';
include '../../../config.php';
include '../../../time.php';
$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$method =$_REQUEST['method'];
$id = $_REQUEST['id'];
$card_type = $_REQUEST['card_type'];
$card = $_REQUEST['card'];
$expiration_date = $_REQUEST['expiration_date'];
$cvv = $_REQUEST['cvv'];

if($id=="")
{
	die("Invalid ID !");
}
if($_SESSION['client_id']=="")
{
	die("Client ID is Missing !");
}

if($method == 1)
{
	$payment_details = "ELECTRONIC TRANSFER";
}

if($method == 2)
{
	//$payment_details = "CREDIT CARD PAYMENT  <BR>CARD TYPE : " .$card_type . " <BR>CARD : " .$card. " <BR>EXPIRATION DATE : " .$expiration_date. " <BR>CVV : " .$cvv;
	$payment_details = "CREDIT CARD PAYMENT";
}

if($method == 3)
{
	$payment_details = "DIRECT DEBIT PAYMENT THROUGH EZI DEBIT";
}



$query ="UPDATE client_invoice SET payment_details = '$payment_details' ,last_update_date = '$ATZ' WHERE id = $id;";
//echo $query;
mysql_query($query);



?>
	
<input type="hidden" name="client_invoice_id" id="client_invoice_id" value="<?=$id;?>" />
	