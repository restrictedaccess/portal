<?
include 'config.php';
include 'conf.php';
include 'time.php';
include 'function.php';

if($_SESSION['admin_id']=="")
{
	echo "Invalid Admin ID!";
	die;
}

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$current_month=date("m");
$current_month_name=date("F");
$ATZ = $AusDate." ".$AusTime;


$payments_invoice_id = $_REQUEST['id'];
$payment_invoice_details_id = $_REQUEST['payment_invoice_details_id'];
$amount = $_REQUEST['amount'];

if($payments_invoice_id =="")
{
	echo "Payments Invoice Number is Missing";
	die;
}
 
//echo $amount;
/*
id, payments_invoice_id, item_id, description, peso_amount, dollar_amount, exchange_rate, client_amount, profit_amount, paid_date, client_pay_status, section, dollar_amount_BPAFF, gst_percent, dollar_total_amount_BPAFF
*/

//Get the subcon subcontracted monthly pay then subctract the Client Monthly pay for this subcon to get the company profit
$sql = "SELECT dollar_amount FROM payments_invoice_details WHERE id = $payment_invoice_details_id AND payments_invoice_id = $payments_invoice_id;";
$result_sql = mysql_query($sql);
list($dollar_amount)=mysql_fetch_array($result_sql);
$profit = ($amount - $dollar_amount);


$query = "UPDATE payments_invoice_details SET client_amount = $amount , profit_amount = $profit , paid_date = '$ATZ' , client_pay_status = 'PAID' WHERE id = $payment_invoice_details_id AND payments_invoice_id = $payments_invoice_id;";
$result = mysql_query($query);
if($result)
{
	//echo "Client Pay has been Made.";

// Subcontractors 
$query ="SELECT id, description,peso_amount,dollar_amount,client_amount,profit_amount,client_pay_status,DATE_FORMAT(paid_date,'%D %b %Y') FROM payments_invoice_details WHERE payments_invoice_id = $payments_invoice_id AND section = 'SUBCON';";
//echo $query;
$result =mysql_query($query);
$counter=0;
while(list($payment_invoice_details_id,$name,$amount,$converted_amount,$client_amount,$profit_amount,$client_pay_status,$paid_date)=mysql_fetch_array($result))
{	$counter++;
	
	if($client_pay_status==""){
		$payment_details ="&nbsp;";
		$button_name = "paid";
		$pay ="";
	}else{
		$payment_details =" <b>Profit :</b> $ ".number_format($profit_amount,2,'.',','). "<br><b> Paid Date : </b>". $paid_date ." &nbsp; ".$client_pay_status;
		$button_name = "edit";
		$pay ="Paid.";
	}
	$total_amount =$total_amount + $amount;
	$total_amount_dollar =$total_amount_dollar + $converted_amount;
	$total_profit = $total_profit + $profit_amount;
	
?>
		<div class="list_wrapper" onClick="highlight(this,'true');" onMouseOver="highlight(this,'false');" onMouseOut="unhighlight(this,'false');">
				<div class="subcon_item_txt"><?=$counter;?></div>
				<div class="subcon_name_txt"><?=$name;?></div>
				<div class="subcon_peso_txt">P <?=number_format($amount,2,'.',',');?></div>
				<div class="subcon_dollar_txt">$ <?=number_format($converted_amount,2,'.',',');?></div>
				<div class="subcon_client_price_txt"><span style="float:left; padding-left:5px;"><?=$pay;?></span>
				<span style="float:right; padding-right:5px;">
				$ <?=number_format($client_amount,2,'.',',');?> <input type='button' class="show_hide_button" value='<?=$button_name;?>' onclick ="show_hide('subcon_section_client_aount_form<?=$counter;?>') ; "/>
				</span>
				<div style="clear:both;"></div>
				<div class="subcon_section_client_aount_form" id="subcon_section_client_aount_form<?=$counter;?>" style="">
				<?=$counter;?><? //=$payment_invoice_details_id." | ".$payments_invoice_id;?>
				<p style="padding:2px; margin-top:3px; margin-bottom:3px; margin-left:20px;"><b>Amount Paid by the Client</b></p>
				<p style="padding:2px; margin-top:5px; margin-bottom:5px; margin-left:20px;"><label style="float:left; display:block; width:70px;">Amount :</label><input type="text" name="client_paid_amount<?=$counter;?>" id="client_paid_amount<?=$counter;?>" value="<?=number_format($client_amount,2,'.',',');?>"?></p>
				<p style="padding:2px; margin-top:3px; margin-bottom:3px; margin-left:20px;">
				<input type="button" name="add_new_expenses" id="add_new_expenses" onClick="javascript: addAmount(document.form.client_paid_amount<?=$counter;?>.value,<?=$payment_invoice_details_id;?>);" value="add"/>&nbsp;
	<input type="button" name="cancel" id="cancel" onClick="javascript: show_hide('subcon_section_client_aount_form<?=$counter;?>');" value="cancel"/></p>
				</div>
				</div>
				<div class="subcon_section_client_payment_details" style=""><?=$payment_details;?></div>
</div>
				
<?
}
				$total_profit_str = number_format($total_profit,2,'.',',');
				echo "<input type='hidden' value='$total_profit_str' name='total_profit_str' id='total_profit_str'/>";
				echo "<input type='hidden' value='$total_profit' name='total_profit_num' id='total_profit_num'/>";
				$sqlUpdatePaymentInvoice="UPDATE payments_invoice SET total_profit_amount = $total_profit WHERE id = $payments_invoice_id;";
				mysql_query($sqlUpdatePaymentInvoice);
				
?>	
</div>
	
	
<?	
}else{
	echo "Error in Script .<br>" .$query;
	die;
}


?>