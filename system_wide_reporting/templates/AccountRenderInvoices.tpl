<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC" >
<tr bgcolor="#FFFFFF" >
<td valign="top" width="50%" >

	<strong>Client Invoice</strong>
	<div class="iresult">
	<p><strong>Number of issued invoice to Clients</strong> <span style="margin-left:20px; font-style:italic;">{$from_str} - {$to_str}</span></p>
	<ul>
	<li>Paid : <span class="invoice_result" table="client_invoice" status="paid">{$client_invoice_paid}</span></li>
	<li>Posted : <span class="invoice_result" table="client_invoice" status="posted">{$client_invoice_posted}</span></li>
	<li>Overdue : <span class="invoice_result" table="client_invoice" status="overdue">{$client_invoice_overdue}</span></li>
	<li>Due date today : <span class="invoice_result" table="client_invoice" status="due date today">{$client_invoice_due_date_today}</span></li>
	
	<!--
	{section name=j loop=$invoices_status}
	<li>{$invoices_status[j].status} : <span class="invoice_result" table="client_invoice" status="{$invoices_status[j].status}">{$invoices_status[j].count}</span></li>
	{sectionelse}
	
	<p>No client invoice results to be shown</p>
	{/section}
	-->
	</ul>
	<!--
	<p><strong>First Invoices issued</strong> : {if $client_first_invoice > 0}<a href="javascript: popup_win('./system_wide_reporting/FirstInvoice.php?pop_window=True&from={$from}&to={$to}' ,700 , 500)">{$client_first_invoice}</a> {else} {$client_first_invoice}  {/if}</p>
	-->
	<strong>First Invoices issued</strong>
	<ul>
		<li>Paid : <a href="javascript: popup_win('./system_wide_reporting/FirstInvoice.php?pop_window=True&status=paid&from={$from}&to={$to}' ,700 , 500)">{$paid}</a></li>
		<li>Posted : <a href="javascript: popup_win('./system_wide_reporting/FirstInvoice.php?pop_window=True&status=posted&from={$from}&to={$to}' ,700 , 500)">{$posted}</a></li>
		<li>Overdue : <a href="javascript: popup_win('./system_wide_reporting/FirstInvoice.php?pop_window=True&status=overdue&from={$from}&to={$to}' ,700 , 500)">{$overdue}</a></li>
		{if $due_date_today neq 0}
		<li>Due Date Today : <a href="javascript: popup_win('./system_wide_reporting/FirstInvoice.php?pop_window=True&status=due date today&from={$from}&to={$to}' ,700 , 500)">{$due_date_today}</a></li>	
		{/if}
		
	</ul>
	</div>
	<strong>Client Invoice Yearly reports</strong><br />
	<br clear="all" />
	{$year_report_str}
	<br clear="all" />
	<p><strong>Overdue client invoice</strong> : {$overdue_client_invoice_count}</p>

</td>

<td valign="top" width="50%" >

	<strong>Subcon Invoice</strong>
	<div class="iresult">
	<p><strong>Number of issued invoice to Subcons</strong> <span style="margin-left:20px; font-style:italic;">{$from_str} - {$to_str}</span></p>
	<ul>
	{section name=j loop=$subcon_invoices_status}
	<li>{$subcon_invoices_status[j].status} : <span class="invoice_result" table="subcon_invoice" status="{$subcon_invoices_status[j].status}">{$subcon_invoices_status[j].count}</span></li>
	{sectionelse}
	<p>No subcon invoices to be shown</p>
	{/section}
	</ul>
	</div>
	<strong>Subcon Invoice Yearly reports</strong><br />
	<br clear="all" />
	{$subcon_year_report_str}

</td>

</tr>
</table>