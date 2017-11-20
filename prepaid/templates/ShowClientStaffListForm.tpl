<h3>Prepaid Client Conversion
<span id="close_link" leads_id="{$lead.id}">[close]</span>
</h3>
<FORM NAME="parentForm" method="post" onSubmit="return ValidateConversion()">
<input type="hidden" name="client" id="client" value="{$lead.id}" />
<input type="hidden" value="{$staffs_count}" id="staffs_count" />
<input type="hidden" id="min_date" value="{$min_date}" />
<input type="hidden" id="max_date" value="{$max_date}" />
<p>Convert #{$lead.id} {$lead.fname} {$lead.lname} into prepaid client and including staffs.</p>
{if $currency_code and  currency_gst_apply}
<input type="submit" name="convert" id="convert_btn" value="convert to prepaid">
{else}
<input type="submit" name="convert" id="convert_btn" value="convert to prepaid" disabled="disabled"><br />
<span style="background:#FFFF00; font-family:'Courier New', Courier, monospace; padding:5px; display:block;">No Client Currency settings detected. You need to set client currency settings first. Click <a href="./AdminRunningBalance/RunningBalance.html?client_id={$lead.id}" target="_blank">HERE</a> to set up.</span>
{/if}
<div id="invoice_details">

<ol>
{foreach from= $staffs item=staff name=staff}
    <li style="background:{cycle values= '#FFFFCC, #FFFFFF'};"><img class="s_i" src="http://www.remotestaff.com.au/portal/tools/staff_image2.php?w=40&h=50&id={$staff.userid}" />
	    <input type="hidden" name="userids[{$smarty.foreach.staff.index}]" value="{$staff.userid}" />#{$staff.userid} {$staff.fname} {$staff.lname}<br />
		<span>Prepaid Contract Start Date : <input type="text" name="cal[{$smarty.foreach.staff.index}]" id="u_{$smarty.foreach.staff.index}" readonly /> </span>
		<br clear="all" />
	</li>
{/foreach}
</ol>
</div>
</FORM>