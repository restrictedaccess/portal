<?
include '../../conf.php';
include '../../config.php';
include '../../time.php';

$userid =$_REQUEST['userid'];

if($_SESSION['admin_id']=="")
{
	die("Invalid Id for Admin");
}

// Search Client invoice by the Subcontractor userid
$sql="SELECT DISTINCT(client_invoice_id) FROM client_invoice_details c WHERE subcon_id = $userid;";
$resulta=mysql_query($sql);
while(list($invoice_number)=mysql_fetch_array($resulta))
{
	//echo $invoice_number."<br>";



//echo $userid;

	 // status = draft
$query="SELECT id, description FROM client_invoice WHERE id = $invoice_number  AND status = 'draft';";
//echo $query;
$result=mysql_query($query);
$counter=0;
while(list($id,$description)=mysql_fetch_array($result))
{
	$counter++;
	$draft_data.="<div class='invoice_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onclick='showClientInvoiceDetail($id);' >".$counter.") ".$description."</div>";
}

// status = posted
$query="SELECT id, description FROM client_invoice WHERE id = $invoice_number  AND status = 'posted';";
//echo $query;
$result=mysql_query($query);
$counter=0;
while(list($id,$description)=mysql_fetch_array($result))
{
	$counter++;
	$posted_data.="<div class='invoice_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onclick='showClientInvoiceDetail($id);' >".$counter.") ".$description."</div>";
}


// status = paid
$query="SELECT id, description FROM client_invoice WHERE id = $invoice_number  AND status = 'paid';";
$result=mysql_query($query);
$counter=0;
while(list($id,$description)=mysql_fetch_array($result))
{
	$counter++;
	$paid_data.="<div class='invoice_wrapper' onMouseOver='highlight(this);' onMouseOut='unhighlight(this);' onclick='showClientInvoiceDetail($id);' >".$counter.") ".$description."</div>";
}


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
	