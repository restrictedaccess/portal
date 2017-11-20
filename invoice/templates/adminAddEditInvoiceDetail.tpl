{section name=j loop=$invoice_details}
{strip}
    <div class="invoice_details_row">
        <div class="invoice_item_no">{counter}</div>
        <div class="invoice_desc_admin">{$invoice_details[j].description|escape}</div>
        <div class="invoice_amt">{$invoice_details[j].amount|number_format:2:".":","}</div>
        <div class="div_invoice_edit_del">
            <button class="btn_edit_invoice_detail" invoice_comment_id="{$invoice_details[j].id}" amount="{$invoice_details[j].amount}" description="{$invoice_details[j].description|escape}">edit</button>
            <button class="btn_delete_invoice_detail" invoice_comment_id="{$invoice_details[j].id}">del</button>
        </div>
        <div class="clear"></div>
    </div>
{/strip}
{/section}
<div class="invisible" id="total_invoice_amount" amount="Total : P{$amount|number_format:2:".":","}"></div>
