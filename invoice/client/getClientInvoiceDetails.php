<?php
/*  2010-02-03  Lawrence Oliver C. Sunglao
    -   bugfix on gst, possible values can be negative as well

*/
include '../../conf.php';
include '../../config.php';
include '../../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;



$client_invoice_id=$_REQUEST['id'];
if($_SESSION['admin_id']=="")
{
	die("Invalid Id for Admin");
}



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
	$currency_symbol = "\$ ";
}
if($currency == "USD"){
	$currency_txt ="Tax Invoice to be Paid in US Dollar (USD)";
	$currency_symbol = "\$ ";
}
if($currency == "POUND" || $currency == "GBP"){
	$currency_txt ="Tax Invoice to be Paid in United Kingdom  (POUNDs)";
	$currency_symbol = "&pound; ";
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

if($gst != 0 ){
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

<p><label>Status :</label><?=$status;?></p>
<p><?=$date_status;?></p>

</div>
<div style="clear:both;"></div>
<div style="margin-top:10px; padding:3px; background:#CCCCCC; border:#CCCCCC outset 1px;"><b>Payments</b></div>
<div style="padding:5px; border:#CCCCCC solid 1px;">
<p><label>Tax Invoice Currency :</label><?=$currency_txt;?></p>
<p><label>Payment Method : </label><?=$payment_details;?></p>
<p style="margin-top:2px;"><label>Sub Total :</label><b><?=$currency_symbol;?> <?=number_format($sub_total,2,'.',',');?></b></p>

<? if ($currency=="AUD") {
	$disabled='';
	$gst_txt =$currency_symbol.number_format(($gst),2,'.',',');
	echo "<p style='margin-top:2px;'><label><input align='absmiddle' type='checkbox' name='gst' id='gst' ".$disabled." ".$checked." onclick='setGst(".$client_invoice_id.")'/>GST (%10) :</label><b> ".$gst_txt."</b></p>";

}else if($currency=="POUND"){
	$disabled='';
	$gst_txt =$currency_symbol. number_format(($gst),2,'.',',');
	
	echo "<p style='margin-top:2px;'><label><input align='absmiddle' type='checkbox' name='gst' id='gst' ".$disabled." ".$checked." onclick='setGst(".$client_invoice_id.")'/>VAT (%15) :</label><b> ".$gst_txt."</b></p>";
	
}else{
	$disabled='disabled="disabled"';
	$gst_txt = "Not Available";
	
	echo "<p style='margin-top:2px;'><label><input align='absmiddle' type='checkbox' name='gst' id='gst' ".$disabled." ".$checked." onclick='setGst(".$client_invoice_id.")'/>GST (%10) :</label><b> ".$gst_txt."</b></p>";
}
?>

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
<input type="button" class="btn"  value="Send Invoice" onClick="javascript: popup_win('./pdf_report/mail_client_tax_invoice.php?client_invoice_id=<?=$client_invoice_id;?>',700,600);" />

  
  
  
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
		<!--
		<div class="invoice_working_days">DAYS</div>
		-->
		<div class="invoice_rate">RATE</div>
		<div class="invoice_rate2">COMPANY RATE</div>
		<div class="invoice_amount">AMOUNT</div>
	</div>
	<?=$data;?>
	<div style="clear:both;"></div>
</div>
