<p align="center" style="font-family:Trebuchet MS; font-size:18px;">Prepaid Transactions</p>

<table align="center" width="100%" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">

<tr bgcolor="#333333">
<td width="4%" style="color:#FFFFFF; font-weight:bold;">#</td>
<td width="10%" style="color:#FFFFFF; font-weight:bold;">Invoice Number</td>
<td width="12%" style="color:#FFFFFF; font-weight:bold;">Date</td>
<td width="40%" style="color:#FFFFFF; font-weight:bold;">Description</td>
<td width="4%" align="center" style="color:#FFFFFF; font-weight:bold;">Status</td>
<td width="4%" align="center" style="color:#FFFFFF; font-weight:bold;">Currency</td>
<td width="8%" align="right" style="color:#FFFFFF; font-weight:bold;">Total Amount</td>
</tr>


{foreach from=$prepaid_orders item=invoice name=invoice}
<tr bgcolor="{cycle values='#FFFFFF, #EEEEEE'}">
<td>{$smarty.foreach.invoice.iteration})</td>
<td ><a href="{$site}/portal/v2/payments/top-up/{$invoice.order_id}" target="_blank">{$invoice.order_id}</a></td>
<td>{$invoice.date}</td>
<td>{$invoice.description|truncate:330:" ..."}</td>
<td align="center">{$invoice.status}</td>
<td align="center">{$invoice.currency}</td>
<td align="right">{$invoice.sign}{$invoice.total_amount}</td>
</tr>
{/foreach}


</table>