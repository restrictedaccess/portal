{*  2010-03-03  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   Removed Payment Details
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
<div id="invoice_details_header">
    <div class="invoice_item_no">Item</div>
    <div class="invoice_desc">Description</div>
    <div id="invoice_amt_hdr">Amount</div>
    <div class="clear"></div>
</div>
<div id="invoice_details">
    {section name=j loop=$invoice_details}
    {strip}
        <div class="invoice_details_row">
            <div class="invoice_item_no">{counter}</div>
            <div class="invoice_desc" title="{$invoice_details[j].description|escape}">{$invoice_details[j].description|escape}</div>
            <div class="invoice_amt">{$invoice_details[j].amount|number_format:2:".":","}</div>
            <div class="clear"></div>
        </div>
    {/strip}
    {/section}
<div class="invisible" id="total_invoice_amount" amount="Total : P{$amount|number_format:2:".":","}"></div>
</div>
<div class="clear"></div>
<div id="invoice_total_amount">Total : P{$amount|number_format:2:".":","}</div>
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
