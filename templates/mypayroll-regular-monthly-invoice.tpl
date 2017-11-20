<div id="invoice">
<p align="center" style="font-family:Trebuchet MS; font-size:18px;">Regular Monthly Invoice</p>
<p style=" font-weight:bold;">Click the Invoice Number to show details</p>
<table align="center" width="100%" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">

<tr bgcolor="#333333">
<td width="4%" style="color:#FFFFFF; font-weight:bold;">#</td>
<td width="10%" style="color:#FFFFFF; font-weight:bold;">Invoice Number</td>
<td width="9%" style="color:#FFFFFF; font-weight:bold;">Invoice Date</td>
<td width="9%" style="color:#FFFFFF; font-weight:bold;">Due Date</td>
<td width="9%" style="color:#FFFFFF; font-weight:bold;">Paid Date</td>
<td width="35%" style="color:#FFFFFF; font-weight:bold;">Description</td>
<td width="6%" align="center" style="color:#FFFFFF; font-weight:bold;">Status</td>
<td width="7%" align="center" style="color:#FFFFFF; font-weight:bold;">Currency</td>
<td width="11%" align="right" style="color:#FFFFFF; font-weight:bold;">Total Amount</td>
</tr>


{foreach from=$invoices item=invoice name=invoice}
<tr bgcolor="{cycle values='#FFFFFF, #EEEEEE'}">
<td>{$smarty.foreach.invoice.iteration})</td>
<td class="invoice_number" invoice_id="{$invoice.id}">{$invoice.invoice_number}</td>
<td>{$invoice.draft_date|date_format}</td>
<td>{$invoice.invoice_payment_due_date|date_format}</td>
<td>{$invoice.paid_date|date_format}</td>
<td>{$invoice.description}</td>
<td align="center">{$invoice.status}</td>
<td align="center">{$invoice.currency}</td>
<td align="right">{$invoice.sign}{$invoice.total_amount}</td>
</tr>
{/foreach}


</table>
</div>