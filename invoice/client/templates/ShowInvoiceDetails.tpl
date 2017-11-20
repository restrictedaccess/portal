<h3 align="center" >Invoice Number {$invoice.invoice_number}<span id="close_link" >[ close ]</span></h3>


<div id="invoice_details">
<p class="invoice_item_list">Description : {$invoice.description}<br />
Date Created : {$invoice.draft_date|date_format:"%B %e, %Y"}<br />
        
		{ if $invoice.post_date }
		    Date Posted : {$invoice.post_date|date_format:"%B %e, %Y"}<br />
		{ /if }
		
		{ if $invoice.paid_date }
		    
<strong>Date Paid : {$invoice.paid_date|date_format:"%B %e, %Y"}</strong><br />
		{ /if }
		
		Invoice Status : <strong>{$invoice.status}</strong><br />
<table width="100%" cellpadding="2" cellspacing="1" border="0" bgcolor="#CCCCCC" style="color:#333333; font-family:tahoma !important ;">
<tr bgcolor="#FFFFFF" >

<td colspan="2" class="invoice_item_list"><strong>Client Tax Invoice to be paid in {$currency.currency|capitalize}</strong></td>
</tr>
<tr bgcolor="#FFFFFF" >

<td width="20%" class="invoice_item_list">Sub Total</td>
<td width="70%"  align="right" class="money_value">{$currency.code} {$currency.sign}{$invoice.sub_total|number_format:2:".":","}</td>
</tr>
{if $currency.code eq 'AUD'}
<tr bgcolor="#FFFFFF" >

<td class="invoice_item_list">GST</td>
<td align="right" class="money_value">{$currency.code} {$currency.sign}{$invoice.gst|number_format:2:".":","}</td>
</tr>
{/if}
<tr bgcolor="#FFFFFF" >

<td class="invoice_item_list">Total Amount</td>
<td align="right" class="money_value"><span style="background:#FFFF00; font-weight:bold;">{$currency.code} {$currency.sign}{$invoice.total_amount|number_format:2:".":","}</span></td>
</tr>
<tr bgcolor="#FFFFFF" >

<td colspan="2" class="invoice_item_list">Invoice Payment Due Date : <span id="invoice_payment_due_date">{$invoice.invoice_payment_due_date|date_format:"%B %e, %Y"}</span> </td></tr>
</table>		
<table width="100%" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" style="color:#333333;">
<tr class="invoice_items_hdr">
<td width="5%">#</td>
<td width="15%">Date</td>
<td width="60%">Description</td>
<td width="20%">Amount</td>
</tr>
{foreach from=$invoice_items item=item name=item}
<tr bgcolor="#FFFFFF" >
<td class="invoice_item_list">{$smarty.foreach.item.iteration}</td>
<td align="left" class="invoice_item_list" >{$item.start_date|date_format:"%b. %e, %Y"} <br /> {$item.end_date|date_format:"%b. %e, %Y"}</td>
<td align="center" class="invoice_item_list" >{$item.decription}</td>
<td align="right" class="money_value" valign="bottom" >{if $invoice.status neq 'paid' && $invoice.status neq 'deleted'}<span id="item_{$item.id}" class="edit_delete_box"><img src="images/b_edit.png" class="edit_delete_invoice_item" item_id="{$item.id}" method="edit" invoice_id="{$invoice.id}" /><img src="images/delete.png" class="edit_delete_invoice_item" item_id="{$item.id}" method="delete" invoice_id="{$invoice.id}" description="{$item.decription}" /></span>{/if}{$currency.sign}{$item.amount|number_format:2:".":","} </td>
</tr>
{/foreach}
</table>
</div>
