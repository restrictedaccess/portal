<?
include '../../../conf.php';
include '../../../config.php';
include '../../../time.php';



$client_invoice_id=$_REQUEST['id'];
//echo $client_invoice_id;
if($_SESSION['client_id']=="")
{
	die("Client ID is Missing !");
}

$sql="SELECT CONCAT(l.fname, ' ',l.lname)AS client_name, c.status, DATE_FORMAT(c.invoice_date,'%D %b %Y'), c.invoice_month, DATE_FORMAT(c.draft_date,'%D %b %Y'), DATE_FORMAT(c.post_date,'%D %b %Y'), DATE_FORMAT(c.paid_date,'%D %b %Y'),description, c.invoice_year , c.sub_total , c.gst, c.total_amount,l.company_name,l.company_address , c.payment_details,c.invoice_number,c.currency ,DATE_FORMAT(invoice_payment_due_date,'%D %b %Y')
FROM client_invoice c
LEFT JOIN leads l ON l.id = c.leads_id
WHERE c.id = $client_invoice_id;";
$result =mysql_query($sql);
list($client_name , $status , $invoice_date , $invoice_month , $draft_date , $post_date , $paid_date,$description, $invoice_year, $sub_total , $gst, $total_amount, $company_name, $company_address , $payment_details,$invoice_number, $currency , $invoice_payment_due_date)= mysql_fetch_array($result);

$monthArray=array("0","1","2","3","4","5","6","7","8","9","10","11","12");
$monthName=array("-","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
for ($i = 0; $i < count($monthArray); $i++)
{
  if($invoice_month == $monthArray[$i])
  {
 	$monthoptions .= "$monthName[$i]";
	break;
  }
}

if($status =="draft"){
	$date_status ="<label>Draft Date :</label>".$draft_date;
}
if($status =="posted"){
	$date_status ="<label>Posted Date :</label>".$post_date;
}

if($status =="paid"){
	$date_status ="<label>Paid Date :</label>".$paid_date;
}

if($sub_total == 0){
	$sub_total = $total_amount;
}
/*
$QUERY="SELECT id, CONCAT(DATE_FORMAT(start_date , '%D %b'),' - ',DATE_FORMAT(end_date , '%D %b %Y') )AS start_end_date  , decription, total_days_work, rate, amount FROM client_invoice_details WHERE client_invoice_id = $client_invoice_id";
//echo $QUERY;
$RESULT=mysql_query($QUERY);
while(list($id, $start_end_date , $decription, $total_days_work, $rate, $amount)=mysql_fetch_array($RESULT))
{
	// DATA HERE
	$data .="<div class='invoice_data_wrrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);'>
				<div class='invoice_start_end_date'>$start_end_date</div>
				<div class='invoice_offshore_staff'>$decription</div>
				<div class='invoice_working_days'>$total_days_work</div>
				<div class='invoice_rate'>$".number_format($rate,2,'.','.')."</div>
				<div class='invoice_amount'>$".number_format($amount,2,'.','.')."</div>
			</div>";
}
*/
// <--		
		$QUERY="SELECT counter FROM client_invoice_details WHERE client_invoice_id = $client_invoice_id";
		$RESULT=mysql_query($QUERY);
		$num=0;
		while(list($counter)=mysql_fetch_array($RESULT))
		{	
			if ($counter!=""){		
				$num++;	
				$data.="<div style='background:#E9E9E9;padding-top:10px;border-bottom:#000000 dashed 1px;'><b>$num )</b>";
				$QUERY2="SELECT id, CONCAT(DATE_FORMAT(start_date , '%D %b'),' - ',DATE_FORMAT(end_date , '%D %b %Y') )AS start_end_date  , decription, total_days_work, rate, amount  FROM client_invoice_details WHERE client_invoice_id = $client_invoice_id AND sub_counter = $counter;";		
				$RESULT2=mysql_query($QUERY2);
				while(list($id, $start_end_date , $decription, $total_days_work, $rate, $amount )=mysql_fetch_array($RESULT2))
				{		
					// DATA HERE
					$data .="<div class='invoice_data_wrrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);'>
				<div class='invoice_start_end_date'>$start_end_date</div>
				<div class='invoice_offshore_staff'>$decription</div>
				<div class='invoice_rate'>$".number_format($rate,2,'.','.')."</div>
				<div class='invoice_amount'>$".number_format($amount,2,'.','.')."</div>
			</div>";
				}
				$data.="&nbsp;</div>";
			}
		}
// -->	


?>
<table width="700px" border="0" cellspacing="0" cellpadding="0" style="border:#999999 outset 1px;">
<tr><td >
<div style='padding:5px; margin-left:3px;'>
<img src='http://<?php echo $_SERVER['HTTP_HOST'];?>/portal/images/think_innovations_logo.png' width='172' height='70'  /></div>
</td>
<td >
<div style='padding:5px; margin-left:3px;'>
<img src='http:/<?php echo $_SERVER['HTTP_HOST'];?>/portal/images/remote_staff_logo.png' width='175' height='59'  /></div>
</td>
</tr>
<tr><td valign='top'>
<div style='margin-left:20px; color:#666666' >
104 / 529 Old South Head Road, Rose Bay, NSW 2029<br />
PH: 02 9365 0018<br />
Fax: 0291301001<br />
Think Inovations Pty. Ltd.

</div>
</td>
<td valign='top'>
<div style='margin-left:5px;color:#666666' >
Email: admin@remotestaff.com.au<br />
Website: www.remotestaff.com.au<br />

</div>
</td>
</tr>
<tr><td colspan="2" align="center">
<div style="margin:10px; padding:10px;">
<b><?=strtoupper($description);?></b>
</div>
</td></tr>
<tr>
<td width="57%" valign="top">
	<div id="invoice_details" style="margin-left:20px;" >
		<p><label>Bill to :</label>&nbsp;<b style="color:#FF0000;"><?=strtoupper($client_name);?></b></p>
		<p><label>Company Name :</label>&nbsp;<?=$company_name;?></p>
		<p><label>Company Address :</label>&nbsp;<?=$company_address;?></p>
		<p ><label>Payment Method:</label>&nbsp;</p>
		<P><?=$payment_details;?></P>
		<p>&nbsp;</p>
		
		

		
		
	</div>
</td>
<td width="43%" valign="top">
	<div id="tax_invoice">
	<p><label>Invoice No :</label><?=$invoice_number;?></p>
<p><label>Invoice Month / Year:</label><?=$monthoptions;?> - <?=$invoice_year;?></p>
	<p><label>Date Created :</label><?=$invoice_date;?></p>
	<p><label>Status :</label><?=$status;?></p>
	<p><?=$date_status;?></p>
	<p><label>Invoice Currency :</label><?=$currency ? $currency : '&nbsp;';?></p>
	<p id="payment_due_date"><label>Payment Due Date :</label><?=$invoice_payment_due_date;?>  </p>
	</div>
</td>
</tr>
<tr>
<td colspan="2" valign="top">
<div id="total_invoice_payments">
<p ><label>Sub Total :</label><b>$ <?=number_format($sub_total,2,'.',',');?></b></p>
<p ><label>GST (%10) :</label><b>$ <?=number_format(($gst ),2,'.',',');?></b></p>
<p ><label>Total :</label><b style="color:#0000FF;">$ <?=number_format($total_amount,2,'.',',');?></b></p>
</div>

</td>
</tr>
<tr><td colspan="2" >
<hr />
<div id="payment_methods">
<div class="box_payment" >
<input type="hidden" name="client_invoice_id" id="client_invoice_id" value="<?=$client_invoice_id;?>" />
<input type="radio" name="peyment_method"  onclick="sendPaymentMethod(1)" />
<strong>1. Electronic Transfer to:</strong><br />
<strong>Australia</strong><br />
Account Name: Think Innovations Pty. Ltd.<br />
BSB: 082 973<br />
Account Number: 49 058 9267<br />
Bank Branch: Darling Street, Balmain NSW 2041<br />
Swift Code: NATAAU3302S<br />
<strong>United Kingdom</strong><br />
Account Name: Think Innovations Pty. Ltd.<br />
UK Bank Address: HSBC. 25 Nothing Hill Gate.London. W11 3JJ<br />
Sort code: 40-05-09<br />
Acc: 61-50-63-23<br />
Swift Code: MIDLGB22<br />
IBAN Number: GB54MIDL40050961506323<br />
<strong>United States</strong>
Account Name: Think Innovations Pty. Ltd.<br />
Bank Branch: HSBC Bank USA NA 452 Fifth Avenue, New York, NY 10018<br />
Account number: 048-984-515<br />
Routing Number: 021001088<br />
SWIFT code: MRMDUS33<br />
</div>


<div class="box_payment" style="margin-bottom:10px;" ><input type="radio" name="peyment_method" onclick="sendPaymentMethod(2)" />
<strong>2. Credit Card Payment:</strong>
<!--
<P><label>Number and Card Type:</label><input type="text" name="card_type" id="card_type" class="text" /></P>
<P><label>Name on the Credit Card:</label><input type="text" name="card" id="card"class="text"/></P>
<P><label>Expiration Date:</label><input type="text" name="expiration_date" id="expiration_date" class="text"/></P>
<P><label>CVV Code:</label><input type="text" name="cvv" id="cvv" class="text"/></P>

<p align="right" ><input type="button" value="Submit" id="send" onclick="sendPaymentMethod('send');" disabled="disabled" /></p>
-->
</div>
<div class="box_payment"  >
<input type="radio" name="peyment_method" onclick="sendPaymentMethod(3)" />
<strong>
3. Direct Debit Payment through EZI Debit</strong></div>

</td>
</tr>
<tr><td colspan="2" valign="top"><br />
<br />

<div id="client_invoice">
<div style="clear:both;"></div>
	<div class="invoice_title_wrrapper_hdr">
		<div class="invoice_start_end_date">DATE</div>
		<div class="invoice_offshore_staff">OFFSHORE STAFF &amp; JOB DESCRIPTION</div>
		<!--<div class="invoice_working_days">WORKING DAYS</div>-->
		<div class="invoice_rate">RATE</div>
		<div class="invoice_amount">AMOUNT</div>
	</div>
	<?=$data;?>
	<div style="clear:both;"></div>
	<div style="margin:5px; color:#FF0000;">RemoteStaff Service Providers are paid in local currency. If
the exchange rate falls below or equal to AUD$1= 38 Pesos , RemoteStaff
will adjust the currency fee fluctuations and pass part of it to
you. Please note that if and when currency adjustment for this invoice
is applicable, it will be added and indicated on your next invoice.</div>
</div>
</td>
</tr>
<tr><td valign="top" colspan="2">&nbsp;
</td></tr>
</table>