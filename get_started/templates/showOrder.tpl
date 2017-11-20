<input type="hidden" id="gs_job_role_selection_id" value="{$gs_job_role_selection_id}" />
<input type="hidden" id="invoice_id" value="{$invoice_id}" />

<table class="tb_prc" align="center" width="98%" cellpadding="5" cellspacing="1" >
<tr><td colspan="2" class="td_w">Personal Information</td></tr>
<tr class="tr_w" >
	<td width="20%" class="lbl" align="right">Name</td>
	<td width="80%">{$fname} {$lname} <span style="float:right; color:#666666;">LEADS ID : {$leads_id}</span></td>
</tr>

<tr class="tr_w" >
	<td class="lbl" align="right">Email</td>
	<td >{$email}</td>
</tr>

<tr><td colspan="2" class="td_w">No. of Job Title &amp; Currency Selection</td></tr>

<tr class="tr_w" >
	<td class="lbl" align="right">No. of Job Roles</td>
	<td>{$no_of_job_role} Job Position(s) selected</td>
</tr>

<tr class="tr_w" >
	<td class="lbl" align="right">Proposed Start Date</td>
	<td>{$proposed_start_date}</td>
</tr>
<tr class="tr_w" >
	<td class="lbl" align="right">Duration Status</td>
	<td>{$duration_status}</td>
</tr>
<tr class="tr_w" >
	<td class="lbl" align="right">Currency</td>
	<td>{$code}</td>
</tr>


<tr><td colspan="2" class="td_w">Work Schedule</td></tr>
{section name=j loop=$selected_job_titles}
{strip}
	<tr class="tr_w" >
	<td colspan="2">
		<div class="selected">{$selected_job_titles[j].no_of_staff_needed} {$selected_job_titles[j].level} LEVEL {$selected_job_titles[j].selected_job_title}</div>
		<ul>
			<li>{$selected_job_titles[j].work_status}</li>
			<li>{$selected_job_titles[j].prices}</li>
			<li>{$selected_job_titles[j].working_timezone}</li>
			<li>{$selected_job_titles[j].working_time}</li>
			<li><a href="javascript:popup_win('get_started/job_spec.php?gs_job_titles_details_id={$selected_job_titles[j].gs_job_titles_details_id}&jr_cat_id={$selected_job_titles[j].jr_cat_id}&jr_list_id={$selected_job_titles[j].jr_list_id}&gs_job_role_selection_id={$gs_job_role_selection_id}',950,600)">Job Specification Form</a>
			 {if $selected_job_titles[j].form_filled_up == "yes"}
			 	&nbsp;<img src="./get_started/media/images/check-icon.png" />
			 {/if}	
			</li>
			
			
		</ul>
	</td>
	</tr>
{/strip}
{/section}

<tr><td colspan="2" class="td_w">Recruitment Setup Fee payment</td></tr>
<tr class="tr_w" >
	<td class="lbl" align="right">Description</td>
	<td>{$description}</td>
</tr>

<tr class="tr_w" >
	<td class="lbl" align="right">Currency Payment</td>
	<td>{$code}</td>
</tr>

<tr class="tr_w" >
	<td class="lbl" align="right">Status</td>
	<td>{$status}</td>
</tr>

<tr class="tr_w" >
	<td class="lbl" align="right">Invoice </td>
	<td>#ID {$invoice_id} <span style="margin-left:10px; color:#999999;">Date :{$date_created}</span></td>
</tr>
{if $leads_invoice.id neq ''}
<tr><td colspan="2" class="td_w">Tax Invoice</td></tr>
<tr class="tr_w" ><td colspan="2" valign="top" style="padding:0px;" >
<!-- recruitment setup -->
<div style="margin-top:3px; margin-bottom:3px; padding-left:5px;">
Invoice #: {$leads_invoice.id}<br />
Name: {$leads_invoice.fname} {$leads_invoice.lname} &lt;{$leads_invoice.email}&gt;
</div>

<div style="background:#FFFFFF; ">

<table cellpadding="0" cellspacing="1" style="font-size: 12px; font-family: verdana; width: 100%;">
<th width="7%" bgcolor="gray" style="color:#FFFFFF">Item #</th>
<th width="65%" bgcolor="gray" style="color:#FFFFFF">Item Description</th>
<th bgcolor="gray" style="color:#FFFFFF">Qty</th>
<th bgcolor="gray" style="color:#FFFFFF">Unit Price</th>
<th bgcolor="gray" style="color:#FFFFFF">Amount</th>
{foreach from=$leads_invoice_items item=invoice_item name=invoice_item}
<tr bgcolor="{cycle values=#eeeeee,#d0d0d0}">
    <td>{$smarty.foreach.invoice_item.iteration}</td>
    <td>{$invoice_item.description}</td>
    <td align="right">{$invoice_item.qty}</td>
    <td align="right">{$invoice_item.unit_price}</td>
    <td align="right">{$invoice_item.qty*$invoice_item.unit_price|number_format:2:".":","}</td>
</tr>
{/foreach}
<tr bgcolor="#cccccc">
    <td colspan=2>Sub-Total</td><td align="right">{$sum_qty|number_format:2:".":","}</td><td>&nbsp;</td><td align="right">{$leads_invoice.code} {$leads_invoice.sign}{$subtotal|number_format:2:".":","}</td>
</tr>
</table>
Other Charges:
<table style="font-size: 12px; font-family: verdana; width: 100%;">
{foreach from=$other_charges item=other_charge name=other_charge}
    <tr bgcolor="{cycle values=#eeeeee,#d0d0d0}">
        <td>{$other_charge.description}</td><td align="right">{$other_charge.amount|number_format:2:".":","}</td>
    </tr>
{/foreach}
</table>

<p/>
<div style="padding: 8px; background-color: #cccccc; font-weight: bold; text-align: right; color: black">
    Total: {$leads_invoice.code} {$leads_invoice.sign}{$total|number_format:2:".":","}
</div>
</div>
<!-- recruitment setup -->
</td></tr>
<tr class="tr_w">
<td valign="top" colspan="2" >
<div class="notes_sec">
<div class="notes_hdr">NOTES / COMMENTS</div>
<div id="notes_list">
<ol>
{section name=j loop=$messages}
{strip}
	<li>{$messages[j].name} => {$messages[j].notes|escape} <span>{$messages[j].date_created}</span></li>
{/strip}
{/section}
</ol>
</div>
<div class="notes_con"><input type="text" id="message" name="message" size="90" /><input type="button" value="Add Comment" onclick="addComments()" /></div>
</div>
</td>
</tr>
{/if}



</table>



