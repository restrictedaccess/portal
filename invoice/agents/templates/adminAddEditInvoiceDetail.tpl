
{section name=j loop=$invoice_details}
{strip}
    <div class="invoice_details_row">
        {if $invoice_details[j].counter eq ''}		
            	<div class="invoice_item_no">&nbsp;</div>
		{else}
				<div class="invoice_item_no">{counter}</div>
		{/if}		
        <div class="invoice_desc_admin">
			{if $invoice_details[j].counter eq ''}
				--&nbsp;{$invoice_details[j].description|escape}
			{else}
				{$invoice_details[j].description|escape}
			{/if}	
		</div>
		{if $invoice_details[j].amount eq ''}
        	<div class="invoice_amt">&nbsp;</div>
        		<div class="div_invoice_edit_del">&nbsp;</div>
		{else}
			<div class="invoice_amt">{$invoice_details[j].amount|number_format:2:".":","}</div>
        		<div class="div_invoice_edit_del">
            	<button class="btn_edit_invoice_detail" invoice_comment_id="{$invoice_details[j].id}" amount="{$invoice_details[j].amount}" description="{$invoice_details[j].description}">edit</button>
            	<button class="btn_delete_invoice_detail" invoice_comment_id="{$invoice_details[j].id}">del</button>
        	</div>	
		{/if}
        <div class="clear"></div>
    </div>
{/strip}
{/section}
<div class="invisible"  id="total_invoice_amount" amount="Total : $ {$amount|number_format:2:".":","}"></div>
<div class="invisible"  id="total_converted_amount" amount="Total : $ {$converted_amount|number_format:2:".":","}"></div>
