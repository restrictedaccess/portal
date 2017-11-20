<?
include '../../conf.php';
include '../../config.php';
include '../../time.php';

$range1 =$_REQUEST['range1'];
$range2 =$_REQUEST['range2'];

if($_SESSION['admin_id']=="")
{
	die("Invalid Id for Admin");
}

	 // status = draft
$query="SELECT id, description FROM client_invoice WHERE sub_total > $range1 AND sub_total< $range2   AND status = 'draft';";
echo $query;
$result=mysql_query($query);
$counter=0;
while(list($id,$description)=mysql_fetch_array($result))
{
	$counter++;
	$draft_data.="<div class='invoice_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onclick='showClientInvoiceDetail($id);' >".$counter.") ".$description."</div>";
}

// status = posted
$query="SELECT id, description FROM client_invoice WHERE  sub_total > $range1 AND sub_total< $range2  AND status = 'posted';";
//echo $query;
$result=mysql_query($query);
$counter=0;
while(list($id,$description)=mysql_fetch_array($result))
{
	$counter++;
	$posted_data.="<div class='invoice_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onclick='showClientInvoiceDetail($id);' >".$counter.") ".$description."</div>";
}


// status = paid
$query="SELECT id, description FROM client_invoice WHERE  sub_total > $range1 AND sub_total< $range2  AND status = 'paid';";
$result=mysql_query($query);
$counter=0;
while(list($id,$description)=mysql_fetch_array($result))
{
	$counter++;
	$paid_data.="<div class='invoice_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onclick='showClientInvoiceDetail($id);' >".$counter.") ".$description."</div>";
}
?>

<table width="100%">
<tr><td valign="top"><div  class="invoice_list_title">Draft</div></td></tr>
<tr><td valign="top" >
	<div class="scroll" >
	<?=$draft_data;?>
	</div>
</td></tr>
<tr><td valign="top" ><div class="invoice_list_title">Post | Email</div></td></tr>
<tr><td valign="top" >
	<div class="scroll" >
	<?=$posted_data;?>
	</div>
</td></tr>
<tr><td valign="top" ><div class="invoice_list_title">Paid</div></td></tr>
<tr><td valign="top" >
	<div class="scroll" >
	<?=$paid_data;?>
	</div>
</td></tr>
</table>
	