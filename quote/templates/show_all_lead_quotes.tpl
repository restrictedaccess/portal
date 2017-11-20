<div class="quote_list_div">
{foreach from= $quote_list_new item= q name=q}
<div class="quote_list" quote_id="{$q.id}">#{$q.quote_no} {$q.leads_name}<small>{$q.creator}</small></div>
{/foreach}
{foreach from= $quote_list_posted item= q name=q}
<div class="quote_list" quote_id="{$q.id}">#{$q.quote_no} {$q.leads_name}</div>
{/foreach}
</div>