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
//echo $payments_invoice_id;	
$queryPaymentsInvoice = "SELECT id, description, p.status, DATE_FORMAT(created_date, '%D %b %Y'), peso_total_amount_subcon_payments, dollar_total_amount_subcon_payments, payments_month, dollar_total_amount_BPAFF,a.admin_fname,total_expenses,total_profit_amount FROM payments_invoice p LEFT JOIN admin a ON a.admin_id = p.drafted_by WHERE id =$payments_invoice_id;";
//echo  $queryPaymentsInvoice;
$results  = mysql_query($queryPaymentsInvoice);
list($id, $description, $status, $created_date, $peso_total_amount_subcon_payments, $dollar_total_amount_subcon_payments, $payments_month, $dollar_total_amount_BPAFF,$admin_fname,$total_expenses,$total_profit_amount)= mysql_fetch_array($results);

/*
echo "<div class='title_header'>".$description."
		<div style='color:#999999; padding:2px;'><span style='float:left;'>Summary View | Date Created : ".$created_date." </span><span style='float:right;'>By: ".$admin_fname."</span>
		<div style='clear:both;'></div>
		</div>";
*/
//echo "<p><b>Summary View</b></p>";
//echo "<p>".$description."</p>";
echo "<div class='view_title_header'>".$description.
	 "<div style='color:#999999; padding:2px;'><span style='float:left;'>Summary View | Date Created : ".$created_date." </span><span style='float:right;'>Created by: ".$admin_fname."</span><br style='clear:both;'></div>";
	 
echo "<div class='view_headers'>
				<div class='item_no'><b>#</b></div>
				<div class='name'><b>Desc</b></div>
				<div class='amount_peso'><b>Peso</b></div>
				<div class='view_amount_dollar'><b>Dollar</b></div>
			</div>";
echo "<div class='scroll2'>";

echo "<div class='list_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);'>
				<div class='view_item_no'>1</div>
				<div class='view_name'>Suncontractor Total Payments</div>
				<div class='view_amount_peso'>P ".number_format($peso_total_amount_subcon_payments,2,'.',',')."</div>
				<div class='view_amount_dollar'>$ ".number_format($dollar_total_amount_subcon_payments,2,'.',',')."</div>
			</div>";

echo "<div class='list_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);'>
				<div class='view_item_no'>2</div>
				<div class='view_name'>Business Partners &amp; Affiliates Total Payments</div>
				<div class='view_amount_peso'>-</div>
				<div class='view_amount_dollar'>$ ".number_format($dollar_total_amount_BPAFF,2,'.',',')."</div>
			</div>";
			
echo "<div class='list_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);'>
				<div class='view_item_no'>3</div>
				<div class='view_name'>Others Expenses</div>
				<div class='view_amount_peso'>-</div>
				<div class='view_amount_dollar'>$ ".number_format($total_expenses,2,'.',',')."</div>
			</div>";
$total = $dollar_total_amount_subcon_payments + $dollar_total_amount_BPAFF + $total_expenses;	
echo "<div class='list_wrapper'>
				<div class='view_total'><b>Total : $ ".number_format($total,2,'.',',')."</b></div>
				<div class='view_total'><b>Profit from Client Payments made for Remote Staff  : $ ".number_format($total_profit_amount,2,'.',',')."</b></div>
			</div>";

			
echo "<div style='margin:10px; padding:10px; text-align:right'>
<input type='hidden' value='$payments_invoice_id' name='payments_invoice_id'/>
<input type='button' value ='Delete' name='del' id='del' onClick=deleteInvoice('".$payments_invoice_id."');>&nbsp;
<input type='submit' value ='View' name='view' id='view'>
</div>";		
echo "</div>";
/*

echo "<div style='clear:both;'></div>";
echo "<p><label>Status :</label><span>".$status."</span></p>";
echo "<div style='clear:both;'></div>";
echo "<p><label>Suncontractor Total Payments :</label><span>".$peso_total_amount_subcon_payments."</span><span>".$dollar_total_amount_subcon_payments."</span></p>" ;
echo "<div style='clear:both;'></div>";
echo "<p><label>Business Partners &amp; Affiliates Total Payments :</label><span>".$dollar_total_amount_subcon_payments ."</span></p>";
*/



?>