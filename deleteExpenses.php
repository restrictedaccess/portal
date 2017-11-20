<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';

$id = $_REQUEST['id'];
$payments_invoice_id=$_REQUEST['payments_invoice_id'];
$total_amount=$_REQUEST['total_amount'];

//echo $id."<br>";
//echo $payments_invoice_id;
if($id=="")
{
	echo "Payment Invoice Details Id is Missing!";
	die;
}
$query="DELETE FROM payments_invoice_details WHERE id = $id;";
mysql_query($query);


$queryExpenses="SELECT SUM(dollar_amount) FROM payments_invoice_details p WHERE payments_invoice_id = $payments_invoice_id AND section = 'EXPENSES';";
$result = mysql_query($queryExpenses);
$row = mysql_fetch_array($result);
$total_expenses = $row[0];

if($total_expenses==""){
	$total_expenses= 0;
}
	//echo $total_expenses;
	$queryUpdateExpenses="UPDATE payments_invoice SET total_expenses = $total_expenses WHERE id = $payments_invoice_id ;";
	$resultUpdate = mysql_query($queryUpdateExpenses);
	if($resultUpdate)
	{	
		$total_expenses = "$ ".number_format($total_expenses,2,'.',',');
		//$total_amount_sec =number_format(($total_amount + $price),2,'.',',');
		//$total_amount_sec2 =$total_amount + $price;
		$queryPaymentsInvoice = "SELECT * FROM payments_invoice p WHERE id =$payments_invoice_id;";
		$results  = mysql_query($queryPaymentsInvoice);
		$rows = mysql_fetch_array($results);
		
		$dollar_total_amount_subcon_payments = $rows['dollar_total_amount_subcon_payments'];
		$dollar_total_amount_BPAFF = $rows['dollar_total_amount_BPAFF'];

		$total_amount_sec = number_format(($dollar_total_amount_subcon_payments + $dollar_total_amount_BPAFF + $row[0]),2,'.',',');
		$total_amount_sec2 = ($dollar_total_amount_subcon_payments + $dollar_total_amount_BPAFF + $row[0]);
		
		
		echo "<input type='hidden' value='$total_expenses' name='total_expenses_txt' id='total_expenses_txt'/>";
		echo "<input type='hidden' value='$total_amount_sec' name='total_amount_hidden' id='total_amount_hidden'/>";
		echo "<input type='hidden' value='$total_amount_sec2' name='total_amount_hidden2' id='total_amount_hidden2'/>";
		// Parse all Data
		$queryAll="SELECT id, description, dollar_amount FROM payments_invoice_details p WHERE payments_invoice_id = $payments_invoice_id AND section = 'EXPENSES';";
		$resultAll = mysql_query($queryAll);
		$counter =0;
		while(list($id, $description, $dollar_amount)=mysql_fetch_array($resultAll))
		{
			$counter++;
			echo "<div class='list_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);'>
					<div class='item_no'>$counter</div>
					<div class='name_desc'>$description</div>
					<div class='amount_dollar'>\$ $dollar_amount <input type='button' value='del' onclick ='deleteExpenses($id)'/></div>
				</div>";
			
		}
	}else{
		echo "Error in Script page : deleteExpenses.php! <br>" .$queryUpdateExpenses;
	}
	
?>
