{*
2010-07-10  Normaneil Macutay <normanm@remotestaff.com.au>

2010-10-20	Normaneil Macutay <normanm@remotestaff.com.au>
	- Removed the Steps Taken
	
2010-11-03	Normaneil Macutay <normanm@remotestaff.com.au>
	- Removed the Message from Leads Tab in the Communication Records , because it is still not finish
	
2011-01-11 Adding ASL Alert <Roy Pepito>    
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Invoicing / Payroll</title>
<link rel=stylesheet type=text/css href="css/font.css">

<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="./leads_information/media/css/example.css">
<link rel=stylesheet type=text/css href="invoice/client/media/css/client_invoice.css">
<link rel=stylesheet type=text/css href="./css/overlay.css">

<script type="text/javascript" src="./js/MochiKit.js"></script>
<script type="text/javascript" src="invoice/client/media/js/adminInvoicesForClient.js"></script>
<script language=javascript src="js/functions.js"></script>

<body style="margin-top:0; margin-left:0" onLoad="placeIt()">
<div id="overlay">
    <div id="invoice_form" style="width:620px;">
	    <h3>Invoice Details</h3>
	</div>
</div>
{if $page_type neq "iframe" }
{php}include("header.php"){/php}
{php}include("client_top_menu.php"){/php}
{/if}
<form name="form" method="post" enctype="multipart/form-data" action="#" accept-charset = "utf-8">



<table width="100%" cellpadding=0 cellspacing=0 border=0 id="lid" >
<tr>
{if $page_type neq "iframe" }
<td width="173" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; ' >
	{php}include("clientleftnav.php"){/php}
</td>
{/if}
<td valign="top" style="padding-left:10px; padding-right:10px;">

<div class="tabber">
    <div class="tabbertab">
	    <h2>Regular Monthly Invoice</h2>
        {include file="mypayroll-regular-monthly-invoice.tpl"}
    </div>
	 
    <div class="tabbertab">
	    <h2>Prepaid Orders</h2>
		{include file="mypayroll-prepaid-orders.tpl"}
	</div>
  
</div>




</td>
</tr>
</table>
</form>
{literal}
<script type="text/javascript" src="./leads_information/media/js/tabber.js"></script>
<script type='text/javascript' src='js/overlay.js'></script>
<script>
var items = getElementsByTagAndClassName('td', 'invoice_number');
for (var item in items){
    connect(items[item], 'onclick', ShowInvoiceDetails);
}
</script>
{/literal}
{if $page_type neq "iframe" }
	{php}include("footer.php"){/php}
{/if}
</body>
</html>
