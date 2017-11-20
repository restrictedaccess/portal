<?php
include '../../conf.php';
include '../../config.php';
include '../../time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;


$mode=$_REQUEST['mode'];
$month=$_REQUEST['month'];
$client=$_REQUEST['client'];
$description =$_REQUEST['description'];
$year=$_REQUEST['year'];

$currency =$_REQUEST['currency'];

if($_SESSION['admin_id']=="")
{
	die("Invalid Id for Admin");
}

$monthArray=array("0","1","2","3","4","5","6","7","8","9","10","11","12");
$monthName=array("-","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
for ($i = 0; $i < count($monthArray); $i++)
{
  if($month == $monthArray[$i])
  {
 	$monthoptions = "$monthName[$i]";
	break;
  }
  
}

$queryClient ="SELECT fname,lname FROM leads WHERE id = $client;";
$result=mysql_query($queryClient);
list($fname,$lname)=mysql_fetch_array($result);
$client_name =  $fname." ".$lname;

// Check if the selected Month's is existing then add a new one then increment counter  by one..
$queryCheck ="SELECT COUNT(invoice_month)AS counter FROM client_invoice WHERE invoice_month =$month AND leads_id =$client;";
//echo $queryCheck;
$resultCheck = mysql_query($queryCheck);
list($counter) = mysql_fetch_array($resultCheck);
if($counter > 0) {
	$counter++;
}else{
	$counter++;
}
//if($description==""){
//	$description ="#$counter [". $monthoptions."-".$year."] Invoice for Client " .$client_name;
//}	

// Create invoice number
$sqlInvoiceNumber = "SELECT MAX(invoice_number) FROM client_invoice;";
$resultSqlInvoiceNum = mysql_query($sqlInvoiceNumber);
$row_result = mysql_fetch_array($resultSqlInvoiceNum);
if($row_result[0] == 0 or $row_result[0]==""){
	$invoice_number = 1000;
}else{
	$invoice_number = $row_result[0] + 1;
}	
if($description==""){
	$description ="#".$invoice_number." Client Invoice " .$client_name;
}	


$query="INSERT INTO client_invoice SET leads_id = $client, description = '$description' , drafted_by =".$_SESSION['admin_id']." , drafted_by_type = 'admin',status = 'draft', invoice_date = '$ATZ', draft_date = '$ATZ' , invoice_month = '$month',invoice_year = '$year' , invoice_number = $invoice_number ,invoice_payment_due_date = date_add('$ATZ', INTERVAL 5 DAY),currency = '$currency';";
$result = mysql_query($query);
$client_invoice_id = mysql_insert_id();



	$sql="SELECT CONCAT(l.fname, ' ',l.lname)AS client_name, c.status, DATE_FORMAT(c.invoice_date,'%D %b %Y'), c.invoice_month, DATE_FORMAT(c.draft_date,'%D %b %Y'), DATE_FORMAT(c.post_date,'%D %b %Y'), DATE_FORMAT(c.paid_date,'%D %b %Y'),description, c.invoice_year, c.sub_total , c.gst, c.total_amount,l.company_name,l.company_address ,c.invoice_number,DATE_FORMAT(invoice_payment_due_date,'%D %b %Y'),c.currency,l.email
		FROM client_invoice c
		LEFT JOIN leads l ON l.id = c.leads_id
		WHERE c.id = $client_invoice_id;";
		$result =mysql_query($sql);
		list($client_name , $status , $invoice_date  , $invoice_month , $draft_date , $post_date , $paid_date ,$description , $invoice_year , $sub_total , $gst, $total_amount, $company_name, $company_address,$invoice_number,$invoice_payment_due_date,$currency,$email)= mysql_fetch_array($result);
		
		if($status =="draft"){
			$date_status ="<label>Draft Date :</label>".$draft_date;
		}
		if($status =="posted"){
			$date_status ="<label>Posted Date :</label>".$post_date;
		}
		
		if($status =="paid"){
			$date_status ="<label>Paid Date :</label>".$paid_date;
		}
		
		
?>

<div id="client_invoice">
<div style="padding:3px; margin-left:2px; float:left; width:400px;">
<p><b><?php echo $description;?></b></p>
<p><label>Client Name :</label><b style="color:#FF0000;"><?php echo $client_name;?></b></p>
<p><label>Company Name :</label><?php echo $company_name ? $company_name : '&nbsp;';?></p>
<p><label>Company Address :</label><?php echo $company_address ? $company_address : '&nbsp;';?></p>
<p style="margin-top:2px;"><label>Sub Total :</label><b>$ <?php echo number_format($sub_total,2,'.',',');?></b></p>
<?php if ($currency=="AUD") {
	$disabled='';
	$gst_txt =$currency_symbol. number_format(($gst),2,'.',',');
	echo "<p style='margin-top:2px;'><label><input align='absmiddle' type='checkbox' name='gst' id='gst' ".$disabled." ".$checked." onclick='setGst(".$client_invoice_id.")'/>GST (%10) :</label><b> ".$gst_txt."</b></p>";

}else if($currency=="POUND"){
	$disabled='';
	$gst_txt =$currency_symbol. number_format(($gst),2,'.',',');
	
	echo "<p style='margin-top:2px;'><label><input align='absmiddle' type='checkbox' name='gst' id='gst' ".$disabled." ".$checked." onclick='setGst(".$client_invoice_id.")'/>VAT (%17.5) :</label><b> ".$gst_txt."</b></p>";
	
}else{
	$disabled='disabled="disabled"';
	$gst_txt = "Not Available";
	
	echo "<p style='margin-top:2px;'><label><input align='absmiddle' type='checkbox' name='gst' id='gst' ".$disabled." ".$checked." onclick='setGst(".$client_invoice_id.")'/>GST (%10) :</label><b> ".$gst_txt."</b></p>";
}
?>
<p style="margin-top:5px; "><label>Total :</label><b style="color:#0000FF;">$ <?php echo number_format($total_amount,2,'.',',');?></b></p>
<p id="payment_due_date"><label>Invoice Payment Due Date :</label><?php echo $invoice_payment_due_date;?>  
<span style=" margin-left:20px;color:#666666; font:12px; cursor:pointer;" onclick="editDueDate(<?php echo $client_invoice_id;?>);">edit</span>
</p>
</div>
<div style="padding:3px; margin-left:2px; float:right; margin-right:20px; ">
<p><label>Invoice No:</label><?php echo $invoice_number;?></p>
<p><label>Invoice Month / Year:</label><?php echo $monthoptions;?> - <?php echo $invoice_year;?></p>
<p><label>Date Created :</label><?php echo $invoice_date;?></p>
<p><?php echo $date_status;?></p>
<p><label>Invoice Currency :</label><?php echo $currency ? $currency : '&nbsp;';?></p>
</div>
<div style="clear:both;"></div>

<div id="due_date_div" style="display:none; padding:7px; background:#333333; border:#666666 outset 1px; color:#FFFFFF; font-weight:bold;"></div>
<div id="invoice_controls" style="margin:3px; padding:3px; border:#999999 dashed 1px;">
<?php
if($status=="draft"){
?>
  <input name="button" type="button" onclick="addItem(<?php echo $client_invoice_id;?>);" value="Add Item" />
  &nbsp;
  <input type="button" value="Post this Invoice" onclick="show_hide('post_div');" />&nbsp;
  <input type="button" value="Delete this Invoice" onclick="deleteInvoice(<?php echo $client_invoice_id;?>)" />&nbsp;
<?php } 
if ($status=="posted"){
?>
	<input type="button" value="Move to Paid Section" onclick="paidInvoice(<?php echo $client_invoice_id;?>)" />&nbsp;
    <input type="button" value="Delete this Invoice" onclick="deleteInvoice(<?php echo $client_invoice_id;?>)" />&nbsp;
<?php
}
?>  
</div>
<div id="post_div"  style="padding:10px; display:none;">
<p>Are you sure want to POST this Invoice No. : <?php echo $invoice_number;?></p>
<p>A copy of this Invoice will be sent via email to :&nbsp; <input type="text" name="leads_email" id="leads_email" class="select" value="<?php echo $email;?>" /></p>
<p> <input type="button" value="Post" onclick="postInvoice(<?php echo $client_invoice_id;?>)" />&nbsp; <input type="button" value="Cancel" onclick="show_hide('post_div');" />&nbsp;</p>
</div>

<div id="edit_div"></div>

<div style="clear:both;"></div>


	<div class="invoice_title_wrrapper_hdr">
		<div class="invoice_start_end_date">DATE</div>
		<div class="invoice_offshore_staff">OFFSHORE STAFF &amp; JOB DESCRIPTION</div>
		<!--<div class="invoice_working_days">DAYS</div>-->
		<div class="invoice_rate">RATE</div>
		<div class="invoice_amount">AMOUNT</div>
	</div>
	<div class='invoice_data_wrrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);'>
						<div class='invoice_start_end_date'>&nbsp;</div>
						<div class='invoice_offshore_staff'>&nbsp;</div>
						<!--<div class='invoice_working_days'>&nbsp;</div>-->
						<div class='invoice_rate'>&nbsp;</div>
						<div class='invoice_amount'>&nbsp;</div>	
						<div class='invoice_button'>&nbsp;</div>			
					</div>
	<div style="clear:both;"></div>
</div>