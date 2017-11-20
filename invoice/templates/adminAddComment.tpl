{section name=j loop=$invoice_comments}
{strip}
    <div class="comment_row {cycle values="comment_row_color_1,comment_row_color_2"}">
        <div class="comment_by_name">{$invoice_comments[j].commented_by}</div>
        <div class="comment_detail">{$invoice_comments[j].comment|escape}</div>
        <div class="clear"></div>
    </div>
{/strip}
{/section}
<div class="clear"></div>
