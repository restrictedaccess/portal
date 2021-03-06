<div>Affiliate Name : {$agent_name|escape}</div>
<div>Description : {$description|escape}</div>
<div id="invoice_id" invoice_id="{$invoice_id}">Invoice No. : {$invoice_id}</div>
<div>Invoice date : {$invoice_date}</div>
<div>Start date : {$start_date}</div>
<div>End date : {$end_date}</div>
{if $status eq 'draft'}
    <div><button id="btn_full_payment_details">Full payment details :</button></div>
{elseif $status eq 'approved'}
    <div><button id="btn_full_payment_details">Full payment details :</button></div>
{else}
    <div>Full payment details :</div>
{/if}
<div id="full_payment_details"><textarea id="text_area_payment_details" readOnly="true">{$payment_details|escape}</textarea></div>
<div class="clear"></div>
<div id="full_payment_details_buttons" class="invisible"><button id="btn_save_payment_details">Save Payment Details</button><button id="btn_cancel_edit_payment_details">Cancel</button></div>
<div class="spacer"></div>
<div class="clear"></div>
{if $status eq 'draft'}
    <div><button id="btn_add_item_to_invoice">Add Item to the Invoice</button></div>
{/if}
<div id="invoice_details_header">
    <div class="invoice_item_no">Item</div>
    {if $status eq 'draft'}
        <div class="invoice_desc_admin_str">Description</div>
    {else}
        <div class="invoice_desc">Description</div>
    {/if}
    <div id="invoice_amt_hdr">Amount</div>
    <div class="clear"></div>
</div>

<div id="invoice_details">
    {section name=j loop=$invoice_details}
    {strip}
        <div class="invoice_details_row">
			{if $invoice_details[j].counter eq ''}		
            	<div class="invoice_item_no">&nbsp;</div>
			{else}
				<div class="invoice_item_no">{counter}</div>
			{/if}		
            {if $status eq 'draft'}
                <div class="invoice_desc_admin" title="{$invoice_details[j].description|escape}">
				{if $invoice_details[j].counter eq ''}
					--&nbsp;{$invoice_details[j].description|escape}
				{else}
					{$invoice_details[j].description|escape}
				{/if}	
				</div>
            {else}
                <div class="invoice_desc" title="{$invoice_details[j].description|escape}">
				{if $invoice_details[j].counter eq ''}
					--&nbsp;{$invoice_details[j].description|escape}
				{else}
					{$invoice_details[j].description|escape}
				{/if}
				</div>
            {/if}
			{if $invoice_details[j].amount eq '' }
            	<div class="invoice_amt">&nbsp;</div>
            {else}
				<div class="invoice_amt">{$invoice_details[j].amount|number_format:2:".":","}</div>
			{/if}	
			{if $status eq 'draft'}
			   {if $invoice_details[j].amount eq '' }
                <div class="div_invoice_edit_del">
                  &nbsp;
                </div>
			   {else}
			   <div class="div_invoice_edit_del">
                    <button class="btn_edit_invoice_detail" invoice_comment_id="{$invoice_details[j].id}" amount="{$invoice_details[j].amount}" description="{$invoice_details[j].description}">edit</button>
                    <button class="btn_delete_invoice_detail" invoice_comment_id="{$invoice_details[j].id}">del</button>
                </div>
			   {/if}	
            {/if}
            <div class="clear"></div>
        </div>
    {/strip}
    {/section}
	
<div class="invisible" id="total_invoice_amount" amount="Total : P{$amount|number_format:2:".":","}"></div>
</div>


<div class="clear"></div>
<div class="invoice_percent" id="invoice_sub_total">Sub Total : $ {$total_amount|number_format:2:".":","}</div>
<div class="invoice_percent">GST + $ {$percent|number_format:2:".":","}</div>
<div class="invoice_percent">-----------------------</div>
<div id="converted_amount" class="invoice_converted">Total : $ {$converted_amount|number_format:2:".":","}</div>
<div class="clear"></div>




{strip}
<div>
    {if $status eq 'draft'}
        <button id="btn_approve_invoice">Approve this invoice</button>
        <button id="btn_delete_invoice">Delete this invoice</button>
        <button id="btn_paid_invoice">Paid</button>
    {elseif $status eq 'approved'}
        <button id="btn_delete_invoice">Delete this invoice</button>
        <button id="btn_paid_invoice">Paid</button>
    {/if}

</div>
{/strip}
<div id="comment_pane">
    <div id="notes_comments_title">Notes / Comments</div>
    <div id="comment_div_container">
    {section name=j loop=$invoice_comments}
    {strip}
        <div class="comment_row {cycle values="comment_row_color_1,comment_row_color_2"}">
            <div class="comment_by_name">{$invoice_comments[j].commented_by}</div>
            <div class="comment_detail">{$invoice_comments[j].comment|escape}</div>
            <div class="clear"></div>
        </div>
    {/strip}
    {/section}
    </div>
    <div id="comment_functions">
        <input id="input_comment"/>
        <button id="btn_add_comment">Add Comment</button>
    </div>
</div>
<div class="clear"></div>

{strip}
<div id="form_add_edit" class="invisible">
    <div id="title_add_edit"></div>
    <div>
        <div>Description : </div>
        <div><input id="input_invoice_description"/></div>
    </div>
    <div>
        <div>Amount : </div>
        <div><input id="input_invoice_amt"/></div>
    </div>
    <div>
        <button id="btn_save_item">Save</button>
        <button id="btn_cancel_item">Cancel</button>
    </div>
</div>
{/strip}
