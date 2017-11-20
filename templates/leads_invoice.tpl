<html>
<head>
    <title>Leads Invoice # {$leads_invoice.id}</title>
</head>
<body style="font-size: 12px; font-family: verdana;">
<div>
    <img width="484" height="89" src="/images/remote-staff-logo.jpg">
</div>
<hr/>
Invoice #: {$leads_invoice.id}
<p/>
Name: {$leads_invoice.fname} {$leads_invoice.lname} &lt;{$leads_invoice.email}&gt;
<p/>
Leads ID: {$leads_invoice.leads_id}
<p/>
Description: {$leads_invoice.description|escape}
<p/>
<table style="font-size: 12px; font-family: verdana; width: 100%;">
<th>Item #</th><th>Item Description</th><th>Qty</th><th>Unit Price</th><th>Amount</th>
{foreach from=$leads_invoice_items item=invoice_item name=invoice_item}
<tr bgcolor="{cycle values="#eeeeee,#d0d0d0}">
    <td>{$smarty.foreach.invoice_item.iteration}</td>
    <td>{$invoice_item.description} :: CODE {$invoice_item.code}</td>
    <td align="right">{$invoice_item.qty}</td>
    <td align="right">{$invoice_item.unit_price}</td>
    <td align="right">{$invoice_item.qty*$invoice_item.unit_price|number_format:2:".":","}</td>
</tr>
{/foreach}
<tr bgcolor="#cccccc">
    <td colspan=2>Sub-Total</td><td align="right">{$sum_qty|number_format:2:".":","}</td><td>&nbsp;</td><td align="right">{$leads_invoice.code} {$leads_invoice.sign}{$subtotal|number_format:2:".":","}</td>
</tr>
</table>
<p/>
Other Charges:
<table style="font-size: 12px; font-family: verdana; width: 100%;">
{foreach from=$other_charges item=other_charge name=other_charge}
    <tr bgcolor="{cycle values="#eeeeee,#d0d0d0}">
        <td>{$other_charge.description}</td><td align="right">{$other_charge.amount|number_format:2:".":","}</td>
    </tr>
{/foreach}
</table>

<p/>
<div style="padding: 8px; background-color: #cccccc; font-weight: bold; text-align: right; color: black">
    Total: {$leads_invoice.code} {$leads_invoice.sign}{$total|number_format:2:".":","}
</div>
</body>
</html>
