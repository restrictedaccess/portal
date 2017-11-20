<?
include '../../../conf.php';
include '../../../config.php';
include '../../../time.php';

$month=$_REQUEST['month'];
$year=$_REQUEST['year'];
$AusDate = date("Y")."-".date("m")."-".date("d");
//echo $leads_id;
if($_SESSION['client_id']=="")
{
	die("Client ID is Missing !");
}

$client = $_SESSION['client_id'];


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

//posted
$query2="SELECT id, description FROM client_invoice WHERE status = 'posted' $condition $month_condition $year_condition ORDER BY draft_date DESC;";
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

?>

<table width="100%">
<tr><td valign="top" ><div class="invoice_list_title">Post</div></td></tr>
<tr><td valign="top" >
	<div class="scroll" >
	<?php echo $all_posted_invoice;?>
	</div>
</td></tr>
<tr><td valign="top"><div  class="invoice_list_title">Overdue Posted Invoice</div></td></tr>
<tr><td valign="top" >
	<div class="scroll" >
	<?php echo $all_overdue_invoice;?>
	</div>
</td></tr>

<tr><td valign="top" ><div class="invoice_list_title">Paid</div></td></tr>
<tr><td valign="top" >
	<div class="scroll" >
	<?php echo $all_paid_invoice;?>
	</div>
</td></tr>
</table>
	