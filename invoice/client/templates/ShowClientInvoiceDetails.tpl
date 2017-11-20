<h2 align="center" >{$invoice.description}</h2>
<div id="invoice_leads_details_box">
    <div>
        <strong>Invoice No. {$invoice.invoice_number}</strong><br />
        <p style="color:#CCCCCC;">Invoice ID. <strong>{$invoice.id}</strong></p>
        <p>Date Created : {$invoice.draft_date|date_format:"%B %e, %Y"}</p>
        
		{ if $invoice.post_date }
		    <p>Date Posted : {$invoice.post_date|date_format:"%B %e, %Y"}</p>
		{ /if }
		
		{ if $invoice.paid_date }
		    <p><strong>Date Paid : {$invoice.paid_date|date_format:"%B %e, %Y"}</strong></p>
		{ /if }
		
		<p>Invoice Status : <strong>{$invoice.status}</strong></p>
    </div>
		
<p>Name : <strong>{$invoice.fname|capitalize} {$invoice.lname|capitalize}</strong></p>
<p>Email : {$invoice.email}</p>
<p>Company : {$invoice.company_name}</p>
<p>Address : <small>{$invoice.company_address}</small></p>	
</div>


<table width="100%" cellpadding="4" cellspacing="0" border="1">
<tr>
<td colspan="2"><strong>Client Tax Invoice to be paid in {$currency.currency|capitalize}</strong></td>
</tr>
<tr>
<td width="20%">Sub Total</td>
<td width="70%"  align="right" class="money_value">{$currency.code} {$currency.sign}{$invoice.sub_total|number_format:2:".":","}</td>
</tr>
{if $currency.code eq 'AUD'}
<tr>
<td>GST</td>
<td align="right" class="money_value">{$currency.code} {$currency.sign}{$invoice.gst|number_format:2:".":","}</td>
</tr>
{/if}
<tr>
<td>Total Amount</td>
<td align="right" class="money_value"><span style="background:#FFFF00; font-weight:bold;">{$currency.code} {$currency.sign}{$invoice.total_amount|number_format:2:".":","}</span></td>
</tr>
<tr><td colspan="2">Invoice Payment Due Date : <span id="invoice_payment_due_date">{$invoice.invoice_payment_due_date|date_format:"%B %e, %Y"}</span> {if $invoice.status eq 'draft' || $invoice.status eq 'posted' }<img src="images/b_edit.png" id="edit_due_date" title="Edit Due Date" invoice_id="{$invoice.id}" style="cursor:pointer;" /> <span id="invoice_due_date_box"></span>{/if}</td></tr>
</table>
<div style="margin-top:20px;">
<input type="button" id="add_invoice_item" invoice_id ="{$invoice.id}"  value="Add Invoice Item" {if $invoice.status eq 'paid' || $invoice.status eq 'deleted'} disabled="disabled" {/if} />
<input type="button" value="Export to PDF" onClick="self.location='./pdf_report/client_tax_invoice.php?client_invoice_id={$invoice.id}'" {if $invoice.status eq 'deleted'} disabled="disabled" {/if}/>
<input type="button" value="Send Invoice" onClick="javascript: popup_win('./pdf_report/mail_client_tax_invoice.php?client_invoice_id={$invoice.id}',700,600);" {if  $invoice.status eq 'deleted'} disabled="disabled" {/if} />


<input type="button" id="move_to_paid_btn" value="Move to Paid" status="paid" invoice_id ="{$invoice.id}" {if $invoice.status eq 'paid' || $invoice.status eq 'deleted'} disabled="disabled" {/if} />
<span id="invoice_paid_date_form"></span>
<input type="button" id="remove_btn" value="Delete Invoice" status="deleted" invoice_id ="{$invoice.id}" {if $invoice.status eq 'paid' || $invoice.status eq 'deleted' } disabled="disabled" {/if} />

{if $currency.code eq 'AUD'}
<input type="button" value="{$gst_str_btn}" id="add_remove_gst" invoice_id="{$invoice.id}" method="{$gst_method}" {if $invoice.status eq 'paid' || $invoice.status eq 'deleted'} disabled="disabled" {/if} />
{else}
<input type="button" value="GST" id="add_remove_gst"  disabled="disabled"  />
{/if}
{if $currency.code eq 'AUD'}
<div style="margin-top:10px; font-weight:bold;">NOTE : In adding , updating, and deleting invoice items GST <small><em>(if applicable)</em></small> is automatically computed and included.</div>
{/if}
</div>

<div id="invoice_items_box">
<div id="edit_div"></div>
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