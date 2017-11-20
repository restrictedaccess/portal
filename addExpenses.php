<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';


$payments_invoice_id = $_REQUEST['id'];
$desc = $_REQUEST['desc'];
$price = $_REQUEST['amount'];
$total_amount=$_REQUEST['total_amount'];

if($payments_invoice_id =="")
{
	echo "Payments Invoice Number is Missing";
	die;
}

$QUERY ="SELECT COUNT(item_id) FROM payments_invoice_details p WHERE payments_invoice_id = $payments_invoice_id AND section = 'EXPENSES';";
//echo $QUERY;
$result = mysql_query($QUERY);
$row = mysql_fetch_array($result);
//$item_id=0;
if($row[0] > 0)
{
	$item_id = $row[0] + 1;
	//echo $item_id ;
	
}else{
	$item_id++;
}

/*
id, payments_invoice_id, item_id, description, peso_amount, section, dollar_amount, exchange_rate, dollar_amount_BPAFF, gst_percent, dollar_total_amount_BPAFF
*/

$sql="INSERT INTO payments_invoice_details SET payments_invoice_id = $payments_invoice_id, item_id = $item_id, description = '$desc' , dollar_amount = $price , section = 'EXPENSES'";
$result2 =mysql_query($sql);
if($result2)
{
	$queryExpenses="SELECT SUM(dollar_amount) FROM payments_invoice_details p WHERE payments_invoice_id = $payments_invoice_id AND section = 'EXPENSES';";
	$result = mysql_query($queryExpenses);
	$row = mysql_fetch_array($result);
	$total_expenses = $row[0];
	//echo $total_expenses;
	$queryUpdateExpenses="UPDATE payments_invoice SET total_expenses = $total_expenses WHERE id = $payments_invoice_id ;";
	$resultUpdate = mysql_query($queryUpdateExpenses);
	if($resultUpdate)
	{	
		$total_expenses = "$ ".number_format($total_expenses,2,'.',',');
		$total_amount_sec =number_format(($total_amount + $price),2,'.',',');
		$total_amount_sec2 =$total_amount + $price;
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
		echo "Error in Script! <br>" .$queryUpdateExpenses;
	}
}else{
	echo "Error in Script! <br>" .$sql;
}


?>