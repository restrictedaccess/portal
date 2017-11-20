<?
include '../../conf.php';
include '../../config.php';
include '../../time.php';


if($_SESSION['admin_id']=="")
{
	die("Invalid Id for Admin");
}




?>

<table width="100%">
<tr><td valign="top"><div  class="invoice_list_title">Draft</div></td></tr>
<tr><td valign="top" >
	<div class="scroll" >
	List here for draft
	</div>
</td></tr>
<tr><td valign="top" ><div class="invoice_list_title">Post</div></td></tr>
<tr><td valign="top" >
	<div class="scroll" >
	List  here for posted Invoices
	</div>
</td></tr>
<tr><td valign="top" ><div class="invoice_list_title">Paid</div></td></tr>
<tr><td valign="top" >
	<div class="scroll" >
	List  here for Paid Invoices
	</div>
</td></tr>
</table>