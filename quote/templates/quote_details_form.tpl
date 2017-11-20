<input type="hidden" id="quote_detail_id" name="quote_detail_id" value="{$quote_detail_id}" />
<div id="configure_working_hours_box" style="visibility:hidden;"></div>
<div id="quote_details_div">

<h2>QUOTE #{$quote.id}</h2>

<div class="created_by_details">
<p><label>Quoted by : </label>{$quote.quoted_by}</p>
<p><label>Quoted Date : </label>{$quote.date_quoted|date_format:"%B %e, %Y %H:%M:%S %p"}</p>
<p><label>Status : </label>{$quote.status}</p>
{if $quote.status eq 'posted'}
<p><label>Date Posted : </label>{$quote.date_posted|date_format:"%B %e, %Y %H:%M:%S %p"}</p>
{/if}
</div>

<p><label>Name : </label>#{$quote.leads_id} {$quote.fname} {$quote.lname}</p>
<p><label>Email : </label>{$quote.email}</p>
<p><label>Company : </label>{if $quote.company_name} {$quote.company_name} {else} &nbsp; {/if}</p>
<p><label>Address : </label>{if $quote.company_address} {$quote.company_address} {else} &nbsp;{/if}</p>
</div>
<hr />


<div id="quote_details_form">
<p><label>Job Position : </label><input type="text" name="work_position" id="work_position" size="82" value="{$quote_detail.work_position}" /><span class="required" title="required">*</span></p>
<p><label>Staff Country : </label><select name="staff_country" id="staff_country" style="width:250px;"  >
			{foreach from=$staff_country item=c name=c}
			<option value="{$c}" {if $c eq $quote_detail.staff_country} selected="selected" {/if}>{$c}</option>
			{/foreach}
    </select>
</p>

<p><label>Candidate :</label><select name="userid" id="userid" style="width:426px;"  >
            {if $applicants}
			<option value="">Select Candidate from Endorsed and Interviewed Orders</option>
			{foreach from=$applicants item=userid name=userid}
			<option value="{$userid.userid}" {if $userid.userid eq $quote_detail.userid} selected="selected" {/if}  >{$userid.fname|capitalize} {$userid.lname|capitalize} - #{$userid.userid}</option>
			{/foreach}
			{else}
			<option value="">No Endorsed/Interviewed Candidates</option>
			{/if}
</select></p>


<p><label>Staff Timezone : </label><select name="staff_timezone" id="staff_timezone" style="width:250px;" >
			{foreach from = $staff_timezone name=t item=t}
		        <option value="{$t}" {if $t eq $quote_detail.staff_timezone} selected="selected" {/if}>{$t}</option>
		    {/foreach}
    </select>
	
<span id="staff_working_hours_str">{$quote_detail.staff_working_hours_str}</span>
</p>

<p><label>Staff Working Hours : </label><span id="staff_working_hours_span">
<select name="work_start" id="work_start"  >
{foreach from=$time_display item=t name=t}
<option value="{$t.time}" { if $quote_detail.work_start eq $t.time} selected="selected" {/if}>{$t.time_str}</option>
{/foreach}
</select>
<select name="work_finish" id="work_finish"  >
{foreach from=$time_display item=t name=t}
<option value="{$t.time}" { if $quote_detail.work_finish eq $t.time} selected="selected" {/if}>{$t.time_str}</option>
{/foreach}
</select>
<input type="hidden" id="working_hours" name="working_hours" value="{$quote_detail.working_hours}" readonly size="4" />
</span>
</p>

<p><label>Staff No. of working days : </label>
<input type="text" id="days" name="days" value="{$quote_detail.days}" disabled="disabled" size="4" />
</p>

<p><label>Work Status : </label><select name="work_status" id="work_status" style="width:250px;"  >
			{$work_status_Options}
    </select>
</p>	
	
<p><label>Monthly Salary : </label><input type="text" name="staff_currency" id="staff_currency" value="{$quote_detail.staff_currency}" readonly size="5" /><input type="text" name="salary" id="salary" value="{$quote_detail.salary}" /><span class="required" title="required">*</span></p>
<p><label>No.of Staff : </label><input type="text" name="no_of_staff" id="no_of_staff" size="10" value="{$quote_detail.no_of_staff}" /><span class="required" title="required">*</span></p>
<p><label>Work Description : </label><textarea id="work_description" rows="4" cols="78">{$quote_detail.work_description}</textarea></p>

<div id="quote_pricing_div"></div>

<p><label>Client Timezone : </label><select name="client_timezone" id="client_timezone" style="width:250px;" >
			{foreach from = $timezone_identifiers name=t item=t}
		        <option value="{$t}" {if $t eq $quote_detail.client_timezone} selected="selected" {/if}>{$t}</option>
		    {/foreach}
    </select></p>
	


<p><label>Client Preffered Working Hours : </label> <select name="client_start_work_hour" id="client_start_work_hour"  >{$client_start_work_hour_start_hours_Options}</select> - <input type="text" name="client_finish_work_hour_str" id="client_finish_work_hour_str" value="{$quote_detail.client_finish_work_hour_str}"   disabled="disabled" size="10" /><input type="hidden" name="client_finish_work_hour" id="client_finish_work_hour" value="{$quote_detail.client_finish_work_hour}"  readonly /></p>

<p><label>Client Quoted Price : </label><select name="currency" id="currency" style="width:55px;"  >
			{foreach from = $client_currency name=c item=c}
		        <option value="{$c}" {if $c eq $quote_detail.currency} selected="selected" {/if}>{$c}</option>
		    {/foreach}
    </select><input type="text" name="quoted_price" id="quoted_price" quoted_price="{$quote_detail.quoted_price}" value="{$quote_detail.quoted_price}" /><span class="required" title="required">*</span><span id="client_quoted_price_str"></span></p>
	
<p><label>GST : </label><input type="checkbox" id="gst" name="gst" gst="{$quote_detail.gst}" value="yes"  /> </p>	
	

<p><label>Quoted Quote Range  : </label><textarea id="quoted_quote_range" name="quoted_quote_range" rows="3" cols="44">{$quote_detail.quoted_quote_range}</textarea></p>

<p>
{if $quote_detail_id}
<input type="button" value="Update" id="quote_detail_form_button" mode="update" quote_id="{$quote.id}" />
{else}
<input type="button" value="Save" id="quote_detail_form_button" mode="insert" quote_id="{$quote.id}" />
{/if}
<input type="button" value="Cancel" id="quote_detail_form_cancel_button" quote_id="{$quote.id}"  />
</p>
</div>