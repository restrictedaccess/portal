<input type="hidden" name="quote_id" id="quote_id" value="{$quote.id}" />
<input type="hidden" name="status" id="status" value="{$quote.status}" />
<div id="quote_details_div">
{if $show_control_buttons eq 'True'}
<div align="right" style="color:#CCCCCC">Quote ID: {$quote.id}</div>
{/if}
{if $show_control_buttons eq 'False'}
<table id="header" width="100%" cellpadding="0" cellspacing="0">
<tr>
<td valign="top" width="65%"><div><img height="76" width="267" src="../../images/remote_staff_logo.png"></div>
AUS : 104 / 529 Old South Head Road, Rose Bay, NSW 2029<br />
UK : Remote Staff Limited, 2 Martin House, <br />
179 - 181 North End Road, London W14 9NL<br />
PH: 02 8014 9196<br />
Fax: 02 8088 7247<br />
USA Fax : (650) 745 1088<br />
Email : {$quote.quoted_by_email}
</td>
<td valign="top" width="35%" ><div><img height="90" width="259" src="../../images/think_innovations_logo.png"></div>
Think Innovations Pty. Ltd. ABN 37 094 364 511<br />
www.remotestaff.com.au,<br />
 www.remotestaff.co.uk,<br />
 www.remotestaff.biz
</td>
</tr>
</table>
{/if}

<h2>QUOTE #{$quote.id}</h2>

<div class="created_by_details">
<p><label>Quoted by : </label>{$quote.quoted_by}</p>
<p><label>Quoted Date : </label>{$quote.date_quoted|date_format:"%B %e, %Y %H:%M:%S %p"}</p>
<p><label>Status : </label>{$quote.status}</p>
{if $quote.status eq 'posted'}
<p><label>Date Posted : </label>{$quote.date_posted|date_format:"%B %e, %Y %H:%M:%S %p"}</p>
{/if}
</div>

<p><label>Name : </label>{if $show_control_buttons eq 'True'} #{$quote.leads_id} {/if} {$quote.fname|capitalize} {$quote.lname|capitalize}</p>
<p><label>Email : </label>{$quote.email}</p>
<p><label>Company : </label>{if $quote.company_name} {$quote.company_name} {else} &nbsp; {/if}</p>
<p><label>Address : </label>{if $quote.company_address} {$quote.company_address} {else} &nbsp;{/if}</p>
</div>

{if $show_control_buttons eq 'True'}
<div align="right">
{if $quote.status eq 'new'}
<input type="button" id="add_quote_details_btn" value="Add Quote Details" quote_id="{$quote.id}" />
<input type="button" id="delete_quote_btn" value="Delete" title="Delete Quote no.{$quote.quote_no}" quote_id="{$quote.id}" />
{else}
<input type="button" id="add_quote_details_btn" value="Add Quote Details" disabled="disabled" />
<input type="button" id="delete_quote_btn" value="Delete" title="Delete Quote no.{$quote.quote_no}" disabled="disabled" />
{/if}


<input type="button" id="close_btn" value="Close" />
</div>
{/if}


{foreach from=$details item=d name=d}
<hr />
<div>

{if $show_control_buttons eq 'True'}
<div class="q_details_control">
{if $quote.status eq 'new'}
<span class="q_details_control_edit_link" quote_id="{$quote.id}" detail_id="{$d.id}">Edit</span>
<span class="q_details_control_delete_link" quote_id="{$quote.id}" detail_id="{$d.id}">Remove</span>
<!--<span class="q_details_control_note_link" quote_id="{$quote.id}" detail_id="{$d.id}">Note</span>-->
{/if}
</div>
{/if}


<p class="work_position"><strong>{$d.work_position|upper}</strong></p>
{if $d.work_description}<p class="work_description" >Description : {$d.work_description}</p> {/if}
</div>
<table width="100%" cellpadding="0" cellspacing="0" style="margin-top:10px;">
<tr>
<td width="45%" valign="top">
<ul class="q_details">
<li>Staff from {$d.staff_country} </li>
{if $d.userid} 
<li><span style="background:#FFFF00; text-transform:capitalize;">Candidate : {$d.candidate}</span></li> 
{/if}
<li>{if $d.work_status eq 'Full-Time'}Full-Time 9hrs w/ 1hr break{/if}{if $d.work_status eq 'Part-Time'}Part-Time 4hrs no break{/if}</li>
<li>Staff Timezone : {$d.staff_timezone}</li>
<li>Staff Time : {$d.staff_working_hours}</li>
<li>Working hours per day : {$d.working_hours}</li>
<li>Working days in a week : {$d.days}</li>

<li>Client Timezone : {$d.client_timezone} </li>
<li>Client Time : {$d.client_working_hours}</li>

<li>Quoted Price :  {$d.currency_lookup.code} {$d.currency_lookup.sign}{$d.quoted_price|number_format:2:".":","} </li>
<!--<li>Hourly {$d.currency_lookup.code} {$d.currency_lookup.sign}{$d.hourly|number_format:2:".":","} </li>-->
</ul>
</td>
<td width="22%" valign="top">
<div class="formula_div">
<p><label>Yearly :</label> {$d.currency_lookup.code} {$d.currency_lookup.sign}{$d.yearly|number_format:2:".":","}</p>
<p><label>Monthly :</label> {$d.currency_lookup.code} {$d.currency_lookup.sign}{$d.quoted_price|number_format:2:".":","}</p>
<p><label>Weekly :</label> {$d.currency_lookup.code} {$d.currency_lookup.sign}{$d.weekly|number_format:2:".":","}</p>
<p><label>Daily :</label> {$d.currency_lookup.code} {$d.currency_lookup.sign}{$d.daily|number_format:2:".":","}</p>
<p><label>Hourly :</label> {$d.currency_lookup.code} {$d.currency_lookup.sign}{$d.hourly|number_format:2:".":","}</p>
</div>
</td>
<td width="33%" valign="top">
<div class="quoted_div">
<p><label>Montly Quoted Price :</label> {$d.currency_lookup.code} {$d.currency_lookup.sign}{$d.quoted_price|number_format:2:".":","}</p>
<p><label>No. of Staff :</label>x {$d.no_of_staff}</p>
<p>------------------</p>

{if $d.gst gt 0}
<p>{$d.currency_lookup.code} {$d.currency_lookup.sign}{$d.sub_total|number_format:2:".":","}</p>
<p><label>GST :</label>+ {$d.currency_lookup.sign}{$d.gst|number_format:2:".":","}</p>
<p>------------------</p>
{/if}

<p style="font-weight:bold; background:#FFFF00;"><label>TOTAL :</label>{$d.currency_lookup.code} {$d.currency_lookup.sign}{$d.total|number_format:2:".":","}</p>
<br clear="all" />
</div>
</td>
</tr>
</table>
{foreachelse}
<hr />
<div class="formula_div"><p>No Quote Details to be shown...</p></div>
{/foreach}

{if $show_control_buttons eq 'False'}
<div class="footer_notes" >
Quotes are best guess indication and may vary depending on the offshore labour market conditions in any given month.<br />
Quotes are valid for only one month.<br />
By paying our invoice(s) you acknowlege & agree to our Service Agreement & Terms & Conditions found on the website www.remotestaff.com.au, www.remotestaff.co.uk, www.remotestaff.biz, www.remotestaff.net
</div>
{/if}