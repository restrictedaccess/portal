<?PHP
include('../../conf/zend_smarty_conf_root.php');
header("Expires: Mon, 26 Jul 1997 05:00:00GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
include '../../conf.php';
include '../../config.php';
include '../../time.php';


$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$status=$_REQUEST['status'];
$event_date = $_REQUEST['event_date'];
$client_invoice_id = $_REQUEST['client_invoice_id'];
$email = $_REQUEST['leads_email'];
$cc = $_REQUEST['cc'];
$bcc = $_REQUEST['bcc'];
$message = $_REQUEST['message'];


if($client_invoice_id==""){
	die("Invoice ID is Missing..");
}
if($status==""){
	die("Status is Missing..");
}

/*
id, leads_id, description, payment_details, drafted_by, drafted_by_type, updated_by, updated_by_type, status, start_date, end_date, invoice_date, draft_date, post_date, last_update_date, total_amount, invoice_month, paid_date
*/

if($status=="posted") {

	// Check the invoice if the status is "paid" if paid just send only this invoice thru email
	$queryCheckInvoiceStatus = "SELECT status FROM client_invoice WHERE id = $client_invoice_id;";
	$data = mysql_query($queryCheckInvoiceStatus);
	list($invoice_status)=mysql_fetch_array($data);
	
	//echo $invoice_status."<br>";
	if($invoice_status!="paid"){
	
		$query="UPDATE client_invoice SET status = 'posted' , post_date ='$ATZ' , last_update_date ='$ATZ' WHERE id = $client_invoice_id;";
		$result = mysql_query($query);
		//echo $query."<br>";	
	}	
	
	// send copy of invoice to the client via email
		
$sql="SELECT CONCAT(l.fname, ' ',l.lname)AS client_name, c.status, DATE_FORMAT(c.invoice_date,'%D %b %Y'), c.invoice_month, DATE_FORMAT(c.draft_date,'%D %b %Y'), DATE_FORMAT(c.post_date,'%D %b %Y'), DATE_FORMAT(c.paid_date,'%D %b %Y'),description, c.invoice_year , c.sub_total , c.gst, c.total_amount,l.company_name,l.company_address,c.invoice_number,DATE_FORMAT(invoice_payment_due_date,'%D %b %Y'),c.currency
FROM client_invoice c
LEFT JOIN leads l ON l.id = c.leads_id
WHERE c.id = $client_invoice_id;";
$result =mysql_query($sql);
list($client_name , $status , $invoice_date , $invoice_month , $draft_date , $post_date , $paid_date,$description, $invoice_year, $sub_total , $gst, $total_amount, $company_name, $company_address,$invoice_number,$invoice_payment_due_date, $currency)= mysql_fetch_array($result);


$company_name ? $company_name : '&nbsp;';
$company_address ? $company_address : '&nbsp;';
if($currency == "AUD")
{
	$currency_txt = "Australian Dollar (AUD)"; 
	$currency_symbol = "\$";
	$bank_account = "<P style='margin-bottom:2px;margin-top:2px;'>Account Name: Think Innovations Pty Ltd</P>
					 <P style='margin-bottom:2px;margin-top:2px;'>Account Number: 490 589 267</P>
					 <P style='margin-bottom:2px;margin-top:2px;'>BSB: 082 140</P>
					 <P style='margin-bottom:2px;margin-top:2px;'>Bank Branch: NAB at Bondi Juncation NSW Australia</P>
					 <P style='margin-bottom:2px;margin-top:2px;'>Swift Code: NATAAU33025</P>";
	$tax = "<p style='margin-bottom:5px; margin-top:5px; text-align:right;border-bottom:#CCCCCC solid 1px;'><label style='float:left;	display:block;	width:190px; font-weight:bold;'>GST (10%) :</label>$currency_symbol ".number_format(($gst ),2,'.',',')."</p>";

	
}

if($currency == "USD")
{
	$currency_txt = "US Dollar (USD)"; 
	$currency_symbol = "\$";
	$bank_account = "<P style='margin-bottom:2px;margin-top:2px;'>Account Name: Think Innovations Pty Ltd</P>
					 <P style='margin-bottom:2px;margin-top:2px;'>Account Number: THIINUSD01</P>
					 <P style='margin-bottom:2px;margin-top:2px;'>Bank Branch: NAB at Bondi Juncation NSW Australia</P>
					 <P style='margin-bottom:2px;margin-top:2px;'>Swift Code: NATAAU33025</P>";
	$tax = "";				 
	

}

if($currency == "POUND")
{
	$currency_txt = "UK POUND "; 
	$currency_symbol = "&pound;";
	$bank_account = "<P style='margin-bottom:2px;margin-top:2px;'>HSBC</P>
					 <P style='margin-bottom:2px;margin-top:2px;'>Think Innovations Pty Ltd</P>
					 <P style='margin-bottom:2px;margin-top:2px;'>BSC: 40-05-09</P>
					 <P style='margin-bottom:2px;margin-top:2px;'>ACC: 61506323</P>";
	$tax = "<p style='margin-bottom:5px; margin-top:5px; text-align:right;border-bottom:#CCCCCC solid 1px;'><label style='float:left;	display:block;	width:190px; font-weight:bold;'>VAT (15%) :</label>$currency_symbol ".number_format(($gst ),2,'.',',')."</p>";			 

}



//$currency ? $currency : '&nbsp;';

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
	$date_status ="<label style='float:left;display:block;width:140px;font-weight:bold;'>Draft Date :</label>".$draft_date;
}
if($status =="posted"){
	$date_status ="<label style='float:left;display:block;width:140px;font-weight:bold;'>Posted Date :</label>".$post_date;
}

if($status =="paid"){
	$date_status ="<label style='float:left;display:block;width:140px;font-weight:bold;'>Paid Date :</label>".$paid_date;
}

if($sub_total == 0){
	$sub_total = $total_amount;
}

// <--		
		$QUERY="SELECT DISTINCT(counter) FROM client_invoice_details WHERE client_invoice_id = $client_invoice_id";
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
					$data .="<div style='background:#FFFFFF;height:32PX;border:#000000 solid 1px;font-weight:normal;' >
								 <div style='float:left; 
									height:28px; 
									width:132px;  
									padding-top:5px; 
									text-align:center;'>$start_end_date</div>
								 <div style='float:left; 
									height:28px; 
									width:290px;  
									padding-top:5px; 
									text-align:center; 
									border-left:#000000 solid 1px; 
									border-right:#000000 solid 1px;'>$decription</div>
								<div style='float:left; 
									height:28px; 
									width:60px;  
									padding-top:5px; 
									text-align:center;'>$total_days_work</div>
								<div style='float:left; 
									height:28px; 
									width:60px;  
									padding-top:5px; 
									text-align:center; 
									border-left:#000000 solid 1px; 
									border-right:#000000 solid 1px;'>$currency_symbol ".number_format($rate,2,'.','.')."</div>
								<div style='float:left; 
									height:28px; 
									width:80px;  
									padding-top:5px; 
									text-align:center;'>$currency_symbol ".number_format($amount,2,'.','.')."</div>
							</div>";
				}
				$data.="&nbsp;</div>";
			}
		}
// -->	

$admin_email ="admin@remotestaff.com.au";
$subject="RemoteStaff.com.au Client Tax Invoice ".strtoupper($client_name)." [".$monthoptions." - ".$invoice_year."] ";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "From: ".$admin_email." \r\n"."Reply-To: ".$admin_email."\r\n";	
$headers .= "Cc: ".$cc."\r\n";
$headers .= 'Bcc: chrisj@remotestaff.com.au,ricag@remotestaff.com.au,normanm@remotestaff.com.au' . "\r\n";

if($message!=""){
	$message = "<div style='padding:5px;font:12px Arial;'>".str_replace("\n","<br>",$message)."</div>";
}else{
	$message = "";
}

$body=$message."<table width='720px' border='0' cellspacing='0' cellpadding='5' style='border:#999999 solid 1px; font:12px Arial;'>
<tr><td colspan='2' valign='top'>
<div style=' padding:10px; border:#CCCCCC solid 1px; margin:5px;'>
<table   style='font:12px Arial;'>
<tr><td width='336' valign='top' >
<div style='padding:5px; margin-left:5px;'>
<img src='http://remotestaff.com.au/portal/images/remote_staff_logo.png' width='254' height='76'  />
</div>
</td>
<td width='349' >
<div style='padding:5px; margin-left:5px;'>
<img src='http://remotestaff.com.au/portal/images/think_innovations_logo.png' width='224' height='98'  /></div>
</td>
</tr>
<tr><td valign='top'>
<div style='margin-left:5px; color:#666666' >
Suite 1A, level 2 802 Pacific Highway, Gordon NSW 2072 Australia<br />
PH: 02 9016 4461<br />
Fax: 02 8088 7242<br />
Email: admin@remotestaff.com.au<br />
</div>
</td>
<td valign='top'>
<div style='margin-left:5px;color:#666666' >
Think Inovations Pty. Ltd. ABN 37 094 364 511<br />
Website: www.remotestaff.com.au<br />
</div>
</td>
</tr>
</table>
</div>




</td>
</tr>








<tr><td colspan='2'  >
<div style=' padding:10px; margin:10px; font:bold 17px Arial; text-align:center;'>
Tax Invoice No ".$invoice_number."
</div>


<div style='padding:2px; border:#FFFFFF solid 1px; margin:5px;'>
<table width='691' style='font:11px Arial;'>
<tr>
<td width='385' valign='top'>
<div style='padding:5px; background:#CCCCCC; border:#999999 outset 1px;'><b>Client</b></div>
<div style='padding:5px; background:#FFFFFF; border:#999999 solid 1px; height:120px;'>
<p style='margin-bottom:3px; margin-top:3px;'><label style='float:left;	display:block;	width:120px; font-weight:bold;'>Bill to :</label>&nbsp;<b style='color:#FF0000;'>".strtoupper($client_name)."</b></p>
<p style='margin-bottom:3px; margin-top:3px;'><label style='float:left;	display:block;	width:120px; font-weight:bold;'>Company Name :</label>&nbsp;".$company_name."</p>
<p style='margin-bottom:3px; margin-top:3px;'><label style='float:left;	display:block;	width:125px; font-weight:bold;'>Company Address :</label>&nbsp;".$company_address."</p>
</div>
</td>

<td width='294' valign='top'>
<div style='margin-left:8px;'>
<div style='padding:5px; background:#CCCCCC; border:#999999 outset 1px;'><b>Tax Invoice Info:</b></div>
<div style='padding:5px; background:#FFFFFF; border:#999999 solid 1px; height:120px;'>
<p style='margin-bottom:3px; margin-top:3px;'><label style='float:left;	display:block;width:140px;font-weight:bold;'>Tax Invoice No :</label>".$invoice_number."</p>
<p style='margin-bottom:3px; margin-top:3px;'><label style='float:left;	display:block;width:140px;font-weight:bold;'>Tax Invoice Month / Year:</label>".$monthoptions." - ".$invoice_year."</p>
	<p style='margin-bottom:3px; margin-top:3px;'><label style='float:left;	display:block;width:140px;font-weight:bold;'>Date Created :</label>".$invoice_date."</p>
	<p style='margin-bottom:3px; margin-top:3px;'>".$date_status."</p>
</div>
</div>
</td>
</tr>
<tr>
<td colspan='2' valign='top'>
<div style='padding:5px; background:#CCCCCC; border:#999999 outset 1px; margin-top:20px; '><b>Payment Method</b></div>
<div style='padding:5px; background:#FFFFFF; border:#999999 solid 1px;'>
<table width='674' height='120' style='font:11px Arial;'>
<tr>
<td width='306' height='114' valign='top' style='height:110px; border:#CCCCCC solid 1px;'>
<div style='padding:5px;'>
	<strong>1. Electronic Transfer to:</strong><br />
	".$bank_account."
</div>
</td>
<td>&nbsp;</td>
<td width='356' valign='top' style='height:110px; border:#CCCCCC solid 1px;'>
<div style='padding:5px;  '>
	<strong>2. Credit Card Payment:</strong>
	<p style='margin-bottom:3px; margin-top:3px;'><label style='float:left;	display:block;width:135px; '>Number and Card Type :</label> 
	_ _ _ _ _ _ _ _ _ _ _ _ _ _ _</p>
	<p style='margin-bottom:3px; margin-top:3px;'><label style='float:left;	display:block;width:135px; '>Credit Card Name :</label> 
	_ _ _ _ _ _ _ _ _ _ _ _ _ _ _</p>
	<p style='margin-bottom:3px; margin-top:3px;'><label style='float:left;	display:block;width:135px; '>Expiration Date :</label> 
	_ _ _ _ _ _ _ _ _ _ _ _ _ _ _</p>
	<p style='margin-bottom:3px; margin-top:3px;'><label style='float:left;	display:block;width:135px; '>CVV Code :</label> 
	_ _ _ _ _ _ _ _ _ _ _ _ _ _ _</p>
</div>

</td>
</tr>
<tr>
<td colspan='3'  valign='top' style='height:8px;'>

</td>
</tr>

<tr>
<td colspan='3'  valign='top' style='border:#CCCCCC solid 1px;'>
<div style='padding:5px; height:40px; '>
	<strong>3. Direct Debit Payment through EZI Debit</strong>
	
</div>

</td>
</tr>


</table>
<div style='clear:both;'></div>
</div>

</td>
</tr>
</table>
</div>

</td>
</tr>
<tr><td colspan='2' valign='top' >
<div style='padding:2px; border:#003300 solid 1px; 	font: 11px Arial; 	width:690PX;'>
<div style='clear:both;'></div>
	<div style='background:#9FFFB8;height:32PX; border:#000000 solid 1px;font-weight:bold;'>
		<div style='float:left;height:28px;width:132px;padding-top:5px;text-align:center;'>DATE</div>
		<div style='float:left;height:28px;width:290px;padding-top:5px;text-align:center;border-left:#000000 solid 1px;border-right:#000000 solid 1px;'>OFFSHORE STAFF &amp; JOB DESCRIPTION</div>
		<div style='float:left;height:28px;width:60px;padding-top:5px;text-align:center;'>WORKING DAYS</div>
		<div style='float:left;height:28px;width:60px;padding-top:5px;text-align:center;border-left:#000000 solid 1px;border-right:#000000 solid 1px;'>RATE</div>
		<div style='float:left;height:28px;width:80px;padding-top:5px;text-align:center;' >AMOUNT</div>
	</div>
	".$data."
	<div style='clear:both;'></div>
</td></tr>
<tr>
<td colspan='2' valign='top'>
<div style='padding:5px; background:#CCCCCC; border:#999999 outset 1px; margin-top:20px;'><b>Payment Details</b></div>
<div style='padding:5px; background:#FFFFFF; border:#999999 solid 1px; height:100px;'>
<p style='margin-bottom:5px; margin-top:5px; text-align:right;border-bottom:#CCCCCC solid 1px;'><label style='float:left;	display:block;width:220px;font-weight:bold;'>Tax Invoice Currency to be Paid :</label>".$currency_txt."</p>
<p style='margin-bottom:5px; margin-top:5px; text-align:right;border-bottom:#CCCCCC solid 1px;'><label style='float:left;	display:block;	width:190px; font-weight:bold;'>Sub Total :</label>$currency_symbol ".number_format($sub_total,2,'.',',')."</p>
".$tax."
<p style='margin-bottom:5px; margin-top:5px; text-align:right;border-bottom:#CCCCCC solid 1px;'><label style='float:left;	display:block;	width:190px; font-weight:bold;'>Total :</label>$currency_symbol ".number_format($total_amount,2,'.',',')."</p>
<p style='margin-top:5px; text-align:right;border-bottom:#CCCCCC solid 1px;'><label style='float:left;	display:block;	width:190px; font-weight:bold;'>Payment Due Date :</label>&nbsp; ".$invoice_payment_due_date."</p>
</div>



</td>
</tr>

<tr><td colspan='2' valign='top'>	
	<div style='margin:5px; color:#FF0000;'>RemoteStaff Service Providers are paid in local currency. If
the exchange rate falls below or equal to AUD$1= 36 Pesos , RemoteStaff
will adjust the currency fee fluctuations and pass part of it to
you. Please note that if and when currency adjustment for this invoice
is applicable, it will be added and indicated on your next invoice.</div>
</div>
</td>
</tr>

</table>";
//echo $headers;
//echo $body;
$to =$email;
//echo $to;
//mail($to,$subject, $body, $headers);
$mail = new Zend_Mail();
$mail->setBodyHtml($body);
$mail->setFrom('noreply@remotestaff.com.au', 'No Reply');
if(!TEST){
	$mail->addTo($email, $client_name);
	$mail->addCc($cc);// Adds a recipient to the mail with a "Cc" header
	//$mail->addCc('angel@remotestaff.com.au' , 'Angel Secuya');// Adds a recipient to the mail with a "Cc" header
	
	$mail->addBcc('chrisj@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
	$mail->addBcc('ricag@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
	
}else{
	$mail->addTo('devs@remotestaff.com.au' , 'Inhouse Developers');
	//$mail->addCc('rhiza@remotestaff.com.au' , 'Rhiza Lanche');// Adds a recipient to the mail with a "Cc" header
}
//$mail->addBcc('normanm@remotestaff.com.au');// Adds a recipient to the mail not visible in the header.
$mail->setSubject($subject);
$mail->send($transport);

	
	/****/
}
if($status=="paid") {
	//$event_date = $_REQUEST['event_date'];
	if($event_date == ""){
		$event_date = $ATZ;
	}
	$query="UPDATE client_invoice SET status = 'paid' , paid_date ='$event_date' ,last_update_date ='$ATZ' WHERE id = $client_invoice_id;";
	$result = mysql_query($query);
}



if(!$result)
{
	die("Error in script<br>".$query);
}
?>

<!--
<input type="hidden" name="client_invoice_id" id="client_invoice_id" value="<?php //$client_invoice_id;?>">
-->
<?
$sql="SELECT CONCAT(l.fname, ' ',l.lname)AS client_name, c.status, DATE_FORMAT(c.invoice_date,'%D %b %Y'), c.invoice_month, DATE_FORMAT(c.draft_date,'%D %b %Y'), DATE_FORMAT(c.post_date,'%D %b %Y'), DATE_FORMAT(c.paid_date,'%D %b %Y'),description, c.invoice_year , c.sub_total , c.gst, c.total_amount,l.company_name,l.company_address, c.payment_details,c.invoice_number,c.currency ,DATE_FORMAT(invoice_payment_due_date,'%D %b %Y'),l.email
FROM client_invoice c
LEFT JOIN leads l ON l.id = c.leads_id
WHERE c.id = $client_invoice_id;";
//echo $sql;
$result =mysql_query($sql);
list($client_name , $status , $invoice_date , $invoice_month , $draft_date , $post_date , $paid_date,$description, $invoice_year, $sub_total , $gst, $total_amount, $company_name, $company_address, $payment_details,$invoice_number, $currency , $invoice_payment_due_date,$email)= mysql_fetch_array($result);

$monthArray=array("0","1","2","3","4","5","6","7","8","9","10","11","12");
//$monthName=array("-","January","February","March","April","May","June","July","August","September","October","November","December");
$monthName=array("-","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
for ($i = 0; $i < count($monthArray); $i++)
{
  if($invoice_month == $monthArray[$i])
  {
 	$monthoptions .= "$monthName[$i]";
	break;
  }
}


if($currency == "AUD"){
	$currency_txt ="Tax Invoice to be Paid in Australian Dollar (AUD)";
	$currency_symbol = "\$";
}
if($currency == "USD"){
	$currency_txt ="Tax Invoice to be Paid in US Dollar (USD)";
	$currency_symbol = "\$";
}
if($currency == "POUND"){
	$currency_txt ="Tax Invoice to be Paid in United Kingdom  (POUNDs)";
	$currency_symbol = "&pound;";
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

if($gst >0 ){
	 $checked="checked='checked'";
}
if($payment_details==""){
	$payment_details="&nbsp;";
}
// <--		
		$QUERY="SELECT DISTINCT(counter) FROM client_invoice_details WHERE client_invoice_id = $client_invoice_id";
		//echo $QUERY."<br>";
		$RESULT=mysql_query($QUERY);
		$num=0;
		while(list($counter)=mysql_fetch_array($RESULT))
		{	
			if ($counter!=""){		
				$num++;	
				$data.="<div style='background:#E9E9E9;padding-top:10px;border-bottom:#000000 dashed 1px;'><b>$num )</b>";
				$QUERY2="SELECT id, CONCAT(DATE_FORMAT(start_date , '%D %b'),' - ',DATE_FORMAT(end_date , '%D %b %Y') )AS start_end_date  , decription, total_days_work, rate, amount , company_rate  FROM client_invoice_details WHERE client_invoice_id = $client_invoice_id AND sub_counter = $counter;";		
				$RESULT2=mysql_query($QUERY2);
				//echo $QUERY2;
				while(list($id, $start_end_date , $decription, $total_days_work, $rate, $amount, $company_rate )=mysql_fetch_array($RESULT2))
				{		
					// DATA HERE
					$rate ? "/$ ".number_format($rate,2,'.','.') : '-';
					$company_rate ? "/$ ".number_format($company_rate,2,'.','.') : '-';
					
					if($total_days_work=="") $total_days_work = "-";
					
					
					
					$data .="<div class='invoice_data_wrrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this)'; >
								<div class='invoice_data_start_end_date'>$start_end_date</div>
								<div class='invoice_data_offshore_staff'>$decription</div>
								<div class='invoice_data_working_days'>$total_days_work</div>
								<div class='invoice_data_rate'>".$rate."</div>
								<div class='invoice_data_rate2'>".$company_rate."</div>
								<div class='invoice_data_amount'>$currency_symbol ".number_format($amount,2,'.','.')."</div>	
								<div class='invoice_data_button'>
									
									<input type='button' class ='butt' value='edit' onclick='editInvoiceDetails($id,$client_invoice_id)'  />
									<input type='button' class ='butt' value='del' onclick='deleteInvoiceDetails($id,$client_invoice_id)'  />
									
								</div>	
								<div style='clear:both;'></div>
							</div>";
					
					
				}
				$data.="&nbsp;</div>";
			}
		}
// -->	
?>

<script language="javascript">
		function send_mail(id) 
		{
			alert(1);
			previewPath = "./pdf_report/mail_client_tax_invoice.php?client_invoice_id="+id;
			window.open(previewPath,'_blank','width=800,height=500,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		}
</script>


<div id="client_invoice">
<div style="padding:3px; margin-left:2px; float:left;width:400px;">
<p><b><?=$description;?></b></p>
<p><label>Client Name :</label><b style="color:#FF0000;"><?=$client_name;?></b></p>
<p><label>Company Name :</label><?=$company_name ? $company_name : '&nbsp;';?></p>
<p><label>Company Address :</label><?=$company_address ? $company_address : '&nbsp;';?></p>


</div>
<div style="padding:3px; margin-left:px; float:right; margin-right:20px; ">
<p><label>Tax Invoice No:</label><?=$invoice_number;?></p>
<p><label>Tax Invoice Month / Year:</label><?=$monthoptions;?> - <?=$invoice_year;?></p>
<p><label>Date Created :</label><?=$invoice_date;?></p>
<p><?=$date_status;?></p>

</div>
<div style="clear:both;"></div>
<div style="margin-top:10px; padding:3px; background:#CCCCCC; border:#CCCCCC outset 1px;"><b>Payments</b></div>
<div style="padding:5px; border:#CCCCCC solid 1px;">
<p><label>Tax Invoice Currency :</label><?=$currency_txt;?></p>
<p><label>Payment Method : </label><?=$payment_details;?></p>
<p style="margin-top:2px;"><label>Sub Total :</label><b><?=$currency_symbol;?> <?=number_format($sub_total,2,'.',',');?></b></p>

<? if ($currency!="AUD") {
	$disabled='disabled="disabled"';
	$gst_txt = "Not Available";
	
}else{
	$disabled='';
	$gst_txt ="\$ ". number_format(($gst),2,'.',',');
}
?>

<p style="margin-top:2px; "><label><input align="absmiddle" type="checkbox" name="gst" id="gst" <?=$disabled;?> onclick="setGst(<?=$client_invoice_id;?>)" <? echo $checked;?> />GST (%10) :</label><b> <?=$gst_txt;?></b></p>
<p><label>Total :</label><b style="color:#0000FF;"><?=$currency_symbol;?> <?=number_format($total_amount,2,'.',',');?></b></p>
<p id="payment_due_date"><label>Invoice Payment Due Date :</label><?=$invoice_payment_due_date;?>  
<span style=" margin-left:20px;color:#666666; font:12px; cursor:pointer;" onclick="editDueDate(<?=$client_invoice_id;?>);">edit</span>
</p>

</div>

<div id="due_date_div" style="display:none; padding:10px; background:#333333; border:#666666 outset 1px; color:#FFFFFF; font-weight:bold;"></div>

<div id="invoice_controls" style="margin:3px; padding:3px; border:#999999 dashed 1px;">
<?
if($status!="paid"){
?>
<input name="button" class="btn" type="button" onclick="addItem(<?=$client_invoice_id;?>);" value="Add Item" />&nbsp;
  <input type="button" class="btn" value="Post this Invoice" onclick="show_hide('post_div');" />&nbsp;
  <input name="button2" class="btn" type="button" onclick="paidInvoice(<?=$client_invoice_id;?>)" value="Move to Paid Section" />&nbsp;
  <input type="button" class="btn" value="Delete this Invoice" onclick="deleteInvoice(<?=$client_invoice_id;?>)" />&nbsp;
<? } 

if($status == "paid") {
?>
	<input type='button' class="btn" value='Email this Invoice' onclick="show_hide('post_div');" />
<?	
}

?>
<input type="button" class="btn"  value="Export to PDF" onClick="self.location='./pdf_report/client_tax_invoice.php?client_invoice_id=<?=$client_invoice_id;?>'"/>
<input type="button" class="btn"  value="Send Invoice" onClick="javascript: previewPath = './pdf_report/mail_client_tax_invoice.php?client_invoice_id=<?=$client_invoice_id;?>'; window.open(previewPath,'_blank','width=500,height=400,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no'); " />

  
  
  
</div>
<div id="post_div" >
<div style="float:left;">
	<p>Are you sure want to POST this Invoice No. : <?=$invoice_number;?></p>
	<p>A copy of this Invoice will be sent via email</p>
	<p><label style="width:40px;display:block;float:left;">To :</label><input type="text" name="leads_email" id="leads_email" class="select" value="<?=$email;?>" /></p>
	<p><label style="width:40px;display:block;float:left;">CC :</label><input type="text" name="cc" id="cc" class="select" value="" /></p>
	<p>
	 <input type="button" class="btn" value="Post" onclick="postInvoice(<?=$client_invoice_id;?>)" />
	 <input type="button" class="btn" value="Cancel" onclick="show_hide('post_div');" />
	 </p>
</div>	 
<div style="float:left; margin-left:20px;">
	<p align="right"><b>Message</b></p>
	<textarea id="message" name="message" class="select" style="width:370px; height:150px;"></textarea>
</div>
<div style="clear:both;"></div>
</div>

<div id="paid_div">
<div style="background:#62A4D5; padding:5px; color:#FFFFFF;"><b>Move <?php echo $description;?> to Paid Section</b></div>
<div style="padding:5px;">
<p>Paid Date : &nbsp;
<input type="text" class="select" name="event_date" id="event_date" value="<?php echo $AusDate;?>" readonly  size="15" > <img align="absmiddle" src="images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
</p>
<p>
<input type="button" class="btn" onclick="moveToPaidSection(<?=$client_invoice_id;?>)" value="Move" />
<input type="button" class="btn" onclick="show_hide('paid_div');" value="Cancel" />

</p>
</div>
</div>

<div id="edit_div"></div>

<div style="clear:both;"></div>


	<div class="invoice_title_wrrapper_hdr">
		<div class="invoice_start_end_date">DATE</div>
		<div class="invoice_offshore_staff">OFFSHORE STAFF &amp; JOB DESCRIPTION</div>
		<div class="invoice_working_days">DAYS</div>
		<div class="invoice_rate">RATE</div>
		<div class="invoice_rate2">COMPANY RATE</div>
		<div class="invoice_amount">AMOUNT</div>
	</div>
	<?=$data;?>
	<div style="clear:both;"></div>
</div>



