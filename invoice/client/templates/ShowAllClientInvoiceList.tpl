	<div class="invoice_section_wrapper">
		<div  class="invoice_list_title">Draft</div>
		<div class="csv_btn"><input type="button" value="CSV" onClick="exportToCSV('draft')"></div>
		<div style="clear:both;"></div>
	</div>
	<div class="scroll" >
		{foreach from=$draft_invoices item=invoice name=invoice}
            {strip}
                <div class="invoice_row" value="{$invoice.id}" status="{$invoice.status}">
	                <small>{$smarty.foreach.invoice.iteration})</small> {$invoice.description}
                </div>
            {/strip}
        {/foreach}
	</div>
	<div class="invoice_section_wrapper">
		<div  class="invoice_list_title">Posted</div>
		<div class="csv_btn"><input type="button" value="CSV" onClick="exportToCSV('posted')"></div>
		<div style="clear:both;"></div>
	</div>
	<div class="scroll" >
	    {foreach from=$posted_invoices item=invoice name=invoice}
            {strip}
                <div class="invoice_row" value="{$invoice.id}" status="{$invoice.status}">
	                <small>{$smarty.foreach.invoice.iteration})</small> {$invoice.description}
                </div>
            {/strip}
        {/foreach}
	</div>
	<div class="invoice_section_wrapper">
		<div  class="invoice_list_title">Overdue Posted Invoice </div>
		<div class="csv_btn"><input type="button" value="CSV" onClick="exportToCSV('overdue')"></div>
		<div style="clear:both;"></div>
	</div>

	<div class="scroll" >
	    {foreach from=$overdue_invoices item=invoice name=invoice}
            {strip}
                <div class="invoice_row" value="{$invoice.id}" status="{$invoice.status}">
	                <small>{$smarty.foreach.invoice.iteration})</small> {$invoice.description}
                </div>
            {/strip}
        {/foreach}
	</div>
<div class="invoice_section_wrapper">
	<div class="invoice_list_title">Paid</div>
		<div class="csv_btn"><input type="button" value="CSV" onClick="exportToCSV('paid')"></div>
		<div style="clear:both;"></div>
	</div>
	<div class="scroll" >
	    {foreach from=$paid_invoices item=invoice name=invoice}
            {strip}
                <div class="invoice_row" value="{$invoice.id}" status="{$invoice.status}">
	                <small>{$smarty.foreach.invoice.iteration})</small> {$invoice.description}
                </div>
            {/strip}
        {/foreach}
	</div>
<div class="invoice_section_wrapper">
	<div class="invoice_list_title">Deleted</div>
		<div class="csv_btn">&nbsp;</div>
		<div style="clear:both;"></div>
	</div>
	<div class="scroll" >
	    {foreach from=$deleted_invoices item=invoice name=invoice}
            {strip}
                <div class="invoice_row" value="{$invoice.id}" status="{$invoice.status}">
	                <small>{$smarty.foreach.invoice.iteration})</small> {$invoice.description}
                </div>
            {/strip}
        {/foreach}
	</div>	