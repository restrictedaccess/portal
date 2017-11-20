<div id="invoice_listings">
    <div class="invoice_list_title" id="invoice_title_drafts">Drafts</div>
    <div class="invoice_list_contents" id="invoice_list_drafts">
        {section name=j loop=$draft_records}
        {strip}
            <div class="invoice_list" 
                invoice_id="{$draft_records[j].id}" 
                invoice_type="{$draft_records[j].status}"
                modifiable="{$draft_records[j].modifiable}" 
                start_date="{$draft_records[j].start_date}" 
                end_date="{$draft_records[j].end_date}" 
                total_amount="{$draft_records[j].total_amount}" 
                description="{$draft_records[j].description|escape}" 
                invoice_date="{$draft_records[j].invoice_date}">
                 <b> {counter} )</b>   {$draft_records[j].invoice_date} Invoice # {$draft_records[j].id} {$draft_records[j].description|escape}
            </div>
        {/strip}
        {/section}
    </div>
    <div class="invoice_list_title" id="invoice_title_approved">Approved</div>
    <div class="invoice_list_contents" id="invoice_list_approved">
	
        {section name=j loop=$approved_records}
	
        {strip}
            <div class="invoice_list" 
                invoice_id="{$approved_records[j].id}" 
                invoice_type="{$approved_records[j].status}"
                modifiable="{$approved_records[j].modifiable}" 
                start_date="{$approved_records[j].start_date}" 
                end_date="{$approved_records[j].end_date}" 
                total_amount="{$approved_records[j].total_amount}" 
                description="{$approved_records[j].description|escape}" 
                invoice_date="{$approved_records[j].invoice_date}">
                 <b> {counter} )</b>   {$approved_records[j].invoice_date} Invoice # {$approved_records[j].id} {$approved_records[j].description|escape}
            </div>
        {/strip}
        {/section}
    </div>
    <div class="invoice_list_title" id="invoice_title_received">Paid</div>
    <div class="invoice_list_contents" id="invoice_list_received">
        {section name=j loop=$posted_records}
        {strip}
            <div class="invoice_list" 
                invoice_id="{$posted_records[j].id}" 
                invoice_type="{$posted_records[j].status}"
                modifiable="{$posted_records[j].modifiable}" 
                start_date="{$posted_records[j].start_date}" 
                end_date="{$posted_records[j].end_date}" 
                total_amount="{$posted_records[j].total_amount}" 
                description="{$posted_records[j].description|escape}" 
                invoice_date="{$posted_records[j].invoice_date}">
                <b> {counter} )</b>    {$posted_records[j].invoice_date} Invoice # {$posted_records[j].id} {$posted_records[j].description|escape}
            </div>
        {/strip}
        {/section}
    </div>
    <div class="clear"/>
</div>
