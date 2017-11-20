{*  2010-03-03  Lawrence Sunglao    <lawrence.sunglao@remotestaff.com.au>
    -   Removed Full Payment Details
*}
<div>Name : {$subcon_name|escape}</div>
<div>Description : {$description|escape}</div>
<div id="invoice_id" invoice_id="{$invoice_id}">Invoice No. : {$invoice_id}</div>
<div>Invoice date : {$invoice_date}</div>
<div>Start date : {$start_date}</div>
<div>End date : {$end_date}</div>
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
        <div class="invoice_desc_admin">Description</div>
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
            <div class="invoice_item_no">{counter}</div>
            {if $status eq 'draft'}
                <div class="invoice_desc_admin" title="{$invoice_details[j].description|escape}">{$invoice_details[j].description|escape}</div>
            {else}
                <div class="invoice_desc" title="{$invoice_details[j].description|escape}">{$invoice_details[j].description|escape}</div>
            {/if}
            <div class="invoice_amt">{$invoice_details[j].amount|number_format:2:".":","}</div>
            {if $status eq 'draft'}
                <div class="div_invoice_edit_del">
                    <button class="btn_edit_invoice_detail" invoice_comment_id="{$invoice_details[j].id}" amount="{$invoice_details[j].amount}" description="{$invoice_details[j].description|escape}">edit</button>
                    <button class="btn_delete_invoice_detail" invoice_comment_id="{$invoice_details[j].id}">del</button>
                </div>
            {/if}
            <div class="clear"></div>
        </div>
    {/strip}
    {/section}
<div class="invisible" id="total_invoice_amount" amount="Total : P{$amount|number_format:2:".":","}"></div>
</div>
<div class="clear"></div>
<div id="invoice_total_amount">Total : P{$amount|number_format:2:".":","}</div>
<!-- Added by Normaneil 10/24/08 
Show the conversion made : Formula and the Equation
-->
{if $converted_amount eq '' }
<div class="input_currency_wrapper">&nbsp;</div>
{else}
<div class="input_currency_wrapper">
	<div class="equation">P{$amount|number_format:2:".":","}</div>
	<div class="equation"><small class="exchange_rate_label">Exchange Rate :</small>   {$exchange_rate}</div>
	<div class="equation">${$converted_amount|number_format:2:".":","}</div>
</div>
{/if}

<!-- 10/24/08 -->

<div class="clear"></div>

<!-- Added by Normaneil 10/23/08 -->
<div class ="input_currency">
	<div class="currency_title">Australian Dollar Conversion</div>
    <input id="total_amount" value='{$amount}' class="invisible" />
	<input id="converted_amount" class="invisible"/>
	<div class="input_currency_wrapper">
	<label class="currency_details" style="width:200px;">Total : P{$amount|number_format:2:".":","}</label>
	<label class="currency_details" style="50px;" >Exchange Rate ($AUD 1.00 -> PHP 1.00) :</label>
	<label class="currency_details"><input id="input_currency" maxlength="10" onkeyup="convertSalary();"/></label>
	</div>
	<div class="clear"></div>
	<div class ="show_conversion" id="show_conversion"></div>
	<div class="btn_save_conversion"><button id="btn_save_conversion">Save Conversion</button></div>
	<div class="clear"></div>
</div>

<!-- Ends Here -->
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
