<?php
include '../../conf.php';
include '../../config.php';
include '../../time.php';

if($_SESSION['admin_id']=="")
{
	die("Invalid Id for Admin");
}

$month=$_REQUEST['month'];
$year=$_REQUEST['year'];
$client = $_REQUEST['client'];

$AusDate = date("Y")."-".date("m")."-".date("d");

if($client > 0){
	$condition = " AND leads_id =" .$client ;
}else{
	$condition ="";
}

if($month>0){
	$month_condition = " AND MONTH(invoice_date) = $month";
}else{
	$month_condition = "";
}

if($year >0){
	$year_condition=" AND YEAR(invoice_date) = $year";
}else{
	$year_condition="";
}


//echo $client. "<br>";
//echo $month. "<br>";
//echo $year. "<br>";

$counter1=0;
$counter2=0;
$counter3=0;
$counter4=0;

//draft
$query1="SELECT id, description FROM client_invoice WHERE status = 'draft' $condition $month_condition $year_condition ORDER BY draft_date DESC;";
$result1=mysql_query($query1);
while(list($id,$description)=mysql_fetch_array($result1))
{
	$counter1++;
	$all_draft_invoice.="<div class='invoice_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onclick='showClientInvoiceDetail($id);' >".$counter1.") ".$description."</div>";
}

//posted
$query2="SELECT id, description ,invoice_payment_due_date FROM client_invoice WHERE status = 'posted' AND invoice_payment_due_date > '$AusDate'
ORDER BY post_date DESC;";
$result2=mysql_query($query2);
while(list($id,$description)=mysql_fetch_array($result2))
{
	$counter2++;
	$all_posted_invoice.="<div class='invoice_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onclick='showClientInvoiceDetail($id);' >".$counter2.") ".$description."</div>";
}

//paid
$query3="SELECT id, description FROM client_invoice WHERE status = 'paid' $condition $month_condition $year_condition ORDER BY draft_date DESC;";
$result3=mysql_query($query3);
while(list($id,$description)=mysql_fetch_array($result3))
{
	$counter3++;
	$all_paid_invoice.="<div class='invoice_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onclick='showClientInvoiceDetail($id);' >".$counter3.") ".$description."</div>";
}


//overdue
$query4="SELECT id, description ,invoice_payment_due_date FROM client_invoice WHERE status = 'posted' AND invoice_payment_due_date < '$AusDate' $condition $month_condition $year_condition ORDER BY post_date ASC;";
$result4=mysql_query($query4);
while(list($id,$description)=mysql_fetch_array($result4))
{
	$counter4++;
	$all_overdue_invoice.="<div class='invoice_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onclick='showClientInvoiceDetail($id);' >".$counter4.") ".$description."</div>";
}


//echo $query2;
//echo "<hr>";
//echo $query4;

?>



<table width="100%">
<tr><td valign="top">
	<div class="invoice_section_wrapper">
		<div  class="invoice_list_title">Draft</div>
		<div class="csv_btn"><input type="button" value="CSV" onClick="exportToCSV('draft')"></div>
		<div style="clear:both;"></div>
	</div>
	<div class="scroll" >
		<?php echo $all_draft_invoice;?>
	</div>
	<div class="invoice_section_wrapper">
		<div  class="invoice_list_title">Posted</div>
		<div class="csv_btn"><input type="button" value="CSV" onClick="exportToCSV('posted')"></div>
		<div style="clear:both;"></div>
	</div>
	<div class="scroll" >
	<?php echo $all_posted_invoice;?>
	</div>
	<div class="invoice_section_wrapper">
		<div  class="invoice_list_title">Over Due Posted Invoice </div>
		<div class="csv_btn"><input type="button" value="CSV" onClick="exportToCSV('overdue')"></div>
		<div style="clear:both;"></div>
	</div>

	<div class="scroll" >
	<?php echo $all_overdue_invoice;?>
	</div>
<div class="invoice_section_wrapper">
	<div class="invoice_list_title">Paid</div>
		<div class="csv_btn"><input type="button" value="CSV" onClick="exportToCSV('paid')"></div>
		<div style="clear:both;"></div>
	</div>
	<div class="scroll" >
	<?php echo $all_paid_invoice;?>
	</div>
</td></tr>
</table>
