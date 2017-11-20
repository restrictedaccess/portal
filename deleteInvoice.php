<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';


$payments_invoice_id = $_REQUEST['id'];
if($payments_invoice_id =="")
{
	echo "Payments Invoice Number is Missing";
	die;
}


$queryPaymentsInvoice = "SELECT description FROM payments_invoice WHERE id =$payments_invoice_id;";
$results  = mysql_query($queryPaymentsInvoice);
list($description)= mysql_fetch_array($results);




$query ="DELETE FROM payments_invoice WHERE id = $payments_invoice_id;";
$result = mysql_query($query);
if($result){
	$message = $description . " has been deleted ! ";
	$query2="DELETE FROM payments_invoice_details WHERE payments_invoice_id = $payments_invoice_id";
	mysql_query($query2);
	
}else{
	$message = $description . " could not be deleted! Please try again.. ";
}	

echo $message;
//echo "<input type='text' name='mess' id='mess' value='$message' />";
?>

