{if $staff_status eq 'terminated' or $staff_status eq 'resigned' or $staff_status eq 'deleted'}
<div id="overlay2" style="padding-bottom:20px;">{$staff_status}</div>
{else}
<div id="overlay2" style="visibility:hidden;">lock</div>
{/if}
<div id="staff_details_holder" style="padding-bottom:20px;">
<h1 style="text-align:center; color:#FF0000; text-transform:uppercase; margin-top:1px; margin-bottom:1px; font-family:Courier New">{$staff_status}</h1>
<input type="hidden" id="id" value="{$id}" />
<input type="hidden" id="userid" value="{$userid}" />
<input type="hidden" name="orig_email" id="orig_email" value="{$email}"/>
<input type="hidden" name="staff_name" id="staff_name" value="{$name}"/>
<input type="hidden" name="mode" id="mode" value="{$mode}"/>
<input type="hidden" name="table_used" id="table_used" value="{$table}"/>
<input type="hidden" name="orig_client_price" id="orig_client_price" value="{$orig_client_price}"  />
<input type="hidden" name="orig_client_price_effective_date" id="orig_client_price_effective_date" value="{$orig_client_price_effective_date}"  />
<input type="hidden" name="view_inhouse_confidential" id="view_inhouse_confidential" value="{$view_inhouse_confidential}"  />

<table width="100%" cellpadding="2" cellspacing="0">
<tr>
<td width="12%" valign="top"><img src="http://www.remotestaff.com.au/portal/tools/staff_image2.php?w=138&h=180&id={$userid}" /></td>
<td width="35%" valign="top">
	<table width="100%" cellpadding="3" cellspacing="2">
		<tr>
		<td width="41%"><strong>Name</strong></td>
		<td width="59%">{$name}</td>
		</tr>
		<tr>
		
		
		<td><strong>Personal Email</strong></td>
		<td>
		{if $registered_email neq ''}
			{$registered_email}
			<input type="hidden" class="select" name="staff_registered_email" id="staff_registered_email" value="{$registered_email}" />
		{else}
			
				{$email}
				<input type="hidden" class="select" name="staff_registered_email" id="staff_registered_email" value="{$email}" />
			
		{/if}
		</td>
		</tr>
		<tr>
		<td><strong>Staff Email</strong></td>
		<td>
        {if $mode eq 'add' || $mode eq 'new'}
		    <input type="text" class="select" name="email" id="email" value="{$email}" />	       
		{else}
        	{if $staff_status eq 'ACTIVE'}
            	{if $mode eq 'edit'}
					<a href="/portal/django/subcontractors/staff_email/{$id}">{$email}</a>                	
                {/if}
            {else}
            	<strong>{$email}</strong>
            {/if}
            <input type="hidden" class="select" name="email" id="email" value="{$email}" />
        {/if}
		<br /><small style="color:#FF0000;">This will be used in Remotestaff login</small>
		</td>
		</tr>
	
		
		
		
		<tr>
		<td><strong>Staff Email Password</strong></td>
		<td>
		<input type="text" class="select" name="initial_email_password" id="initial_email_password" value="{$initial_email_password}" />
		<br /><small style="color:#FF0000;">This will be used in Remotestaff login</small>
		</td>
		</tr>
		
		
		<tr>
		<td><strong>Staff Skype</strong></td>
		<td><input type="text" class="select" name="skype" id="skype" value="{$skype}" /></td>
		</tr>
		<tr>
		<td><strong>Staff Skype Password</strong></td>
		<td><input type="text" class="select" name="initial_skype_password" id="initial_skype_password" value="{$initial_skype_password}" /></td>
		</tr>
	</table>
	
	
	
</td>
<td width="53%" valign="top">
	
	<table width="100%" cellpadding="3" cellspacing="2">
	{if $staff_status eq 'resigned'}
	<tr>
	<td width="18%" valign="top"><b>Job Designation</b></td>
	<td width="1%" valign="top">:</td>
	<td width="81%" valign="top">{$job_designation}</td>
	</tr>
	<tr>
	<td valign="top"><b>Date Resigned</b></td>
	<td valign="top">:</td>
	<td valign="top">{$resignation_date}</td>
	</tr>
    
	<tr>
	<td valign="top"><b>Reason</b></td>
	<td valign="top">:</td>
	<td valign="top">{$reason}</td>
	</tr>
    
    <tr>
	<td valign="top"><b>Reason Type</b></td>
	<td valign="top">:</td>
	<td valign="top">{$reason_type}</td>
	</tr>
    
    <tr>
	<td valign="top"><b>Service Type</b></td>
	<td valign="top">:</td>
	<td valign="top">{$service_type}</td>
	</tr>
    
    <tr>
	<td valign="top"><b>Replacement Request</b></td>
	<td valign="top">:</td>
	<td valign="top">{$replacement_request}</td>
	</tr>
	
	{elseif $staff_status eq 'terminated'}
	<tr>
	<td width="18%" valign="top"><b>Job Designation</b></td>
	<td width="1%" valign="top">:</td>
	<td width="81%" valign="top">{$job_designation}</td>
	</tr>
	<tr>
	<td valign="top"><b>Date Terminated</b></td>
	<td valign="top">:</td>
	<td valign="top">{$date_terminated}</td>
	</tr>
	<tr>
	<td valign="top"><b>Reason</b></td>
	<td valign="top">:</td>
	<td valign="top">{$reason}</td>
	</tr>
    
    <tr>
	<td valign="top"><b>Reason Type</b></td>
	<td valign="top">:</td>
	<td valign="top">{$reason_type}</td>
	</tr>
    
    <tr>
	<td valign="top"><b>Service Type</b></td>
	<td valign="top">:</td>
	<td valign="top">{$service_type}</td>
	</tr>
    
    <tr>
	<td valign="top"><b>Replacement Request</b></td>
	<td valign="top">:</td>
	<td valign="top">{$replacement_request}</td>
	</tr>
    
	{else}
	<tr>
	<td width="18%" valign="top"><b>Date Registered</b></td>
	<td width="1%" valign="top">:</td>
	<td width="81%" valign="top">{$dateapplied}</td>
	</tr>
	<tr>
	<td valign="top"><b>Address</b></td>
	<td valign="top">:</td>
	<td valign="top">{$address}</td>
	</tr>

	<tr>
	<td valign="top"><b>Job Designation</b></td>
	<td valign="top">:</td>
	<td valign="top"><input type="text" name="job_designation" size="50" id="job_designation" value="{$job_designation}" /></td>
	</tr>
	
	<tr>
	<td valign="top"><b>Staff Other Client Email</b></td>
	<td valign="top">:</td>
	<td valign="top"><input type="text" name="staff_other_client_email" size="50" id="staff_other_client_email" value="{$staff_other_client_email}" /></td>
	</tr>
	
	<tr>
	<td valign="top"><b>Staff Other Client Email Password</b></td>
	<td valign="top">:</td>
	<td valign="top"><input type="text" name="staff_other_client_email_password" size="50" id="staff_other_client_email_password" value="{$staff_other_client_email_password}" /></td>
	</tr>
	
	{/if}
	</table>
	{if $scheduled_label}
	<div style="border:#FF0000 dashed 2px; padding:5px; width:450px; background:#FFFF00;">{$scheduled_label}</div>
	{/if}
    
</td>
</tr>
</table>

<div class="client_box">
	<p><b>{$name} will be subcontracted to </b></p>
	<p><span class="choose_client">Choose Remotestaff Client</span>&nbsp;&nbsp;&nbsp;&nbsp;<select name="leads_id" id="leads_id" class="select_box" onchange="showClientAds(this.value);">
	<option value="0">Please Select Client</option>
	 {$leadsOptions}
	</select> <small>Clients with existing currency settings.</small></p>
	<div id="client_history"><input type="hidden" name="max_month_interval" id="max_month_interval" value="0" /></div>
</div>

<fieldset>
	<legend><b>Client Posted Advertisement</b> <span class="gray">(optional)</span></legend>
	<div id="client_ads" ><p>Select a client first to view it's Remotestaff active posted advertisement..</p></div>
</fieldset>

<div style="margin-top:20px;" >
{ if $salary_updates }
    { foreach from=$salary_updates name=salary_update item=salary_update }
        <div style="padding:8px; width:50%; background:#FFFF00; margin:auto; text-align:center; margin-bottom:10px; font-weight:bold;">This contract is already scheduled for salary update on 
        { $salary_update.scheduled_date|date_format }</div> 
    {/foreach}
    <br clear="all" />
{/if }
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td width="40%"><table width="515" cellspacing="2" cellpadding="2">
			<tr>
				<td class="contract_td" width="189">Staff Work Status</td>
				<td width="8">:</td>
		  	  <td width="296">
			  <select name="work_status" id="work_status" class="select" onchange="autoPopulate();"  { if in_array($mode,Array('edit', 'updated')) } disabled="disabled" {/if }  >
				<option value="0">Please select</option>
				{$work_status_Options}
				</select>
			  </td>
			</tr>
			<tr>
				<td class="contract_td" width="189">Staff Salary Currency in </td>
				<td width="8">:</td>
		  	  <td width="296"><select name="staff_currency_id" id="staff_currency_id" class="select" { if in_array($mode,Array('edit', 'updated')) } disabled="disabled" {/if } >
			  <option value="">Please select</option>
				{$staff_currency_Options}
				</select></td>
			</tr>
			<tr>
				<td class="contract_td" width="189">Monthly Salary</td>
				<td width="8">:</td>
		  	  <td width="296">
              {if $leads_id eq '11' and $view_inhouse_confidential eq 'N'}
                  <strong>Confidential</strong>
                  <input type="hidden" name="staff_monthly" id="staff_monthly" value="{$staff_monthly}" />
              {else}
                  <input type="text" class="select" name="staff_monthly" id="staff_monthly" onkeyup="convertSalary();" value="{$staff_monthly}" { if in_array($mode,Array('edit', 'updated')) } disabled="disabled" {/if } />
              {/if}
              </td>
			</tr>
			<tr>
				<td class="contract_td">Staff Timezone</td>
				<td>:</td>
			  <td><select name="staff_timezone" id="staff_timezone"  onchange="setTimeZone()" class="select" >
                <option value="">Select Staff Timezone</option>
				   {$staff_timezones_Options}
		      </select></td>
			</tr>
			<tr>
				<td class="contract_td">Client Timezone</td>
				<td>:</td>
			  <td><select name="client_timezone" id="client_timezone"  onchange="setTimeZone()" class="select" >
                <option value="0">Select Client Timezone</option>
				   {$timezones_Options}
		      </select></td>
			</tr>
			<tr>
				<td class="contract_td" width="189">Client Working Hours</td>
				<td width="8">:</td>
			  	<td width="296">
					<div align="center"  class="gray">Client preferred working hours</div>
					<table width="177">
						<tr><td width="60">Start</td>
						<td width="105">
						<select name="client_start_work_hour" id="client_start_work_hour"  onChange="autoPopulate();" class="select" style="width:140px;" >
			<option value="0">-</option>
			{$client_start_work_hour_start_hours_Options}
		  </select></td></tr>
						<tr><td>Finish</td>
						  <td><span id="finish_time_div">
						  <input type="text" readonly name="client_finish_work_hour" id="client_finish_work_hour" class="select" style="width:140px;" value="{$client_finish_work_hour}" />
</span></td>
						</tr>
				  </table>
				
				<!--{$client_start_work_hour}&nbsp;{$client_finish_work_hour}-->
			  </td>
			</tr>
			<tr>
				<td class="contract_td" width="189">Work Start Date</td>
				<td width="8">:</td>
		  	  <td width="296">
			  <input type="text" id="starting_date" name="starting_date" class="select" style="width:75px;" readonly value="{$starting_date}" > <img align="absmiddle" src="images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
			  </td>
			</tr>
			   
			<tr>
				<td class="contract_td" width="189">Prepaid Start Date</td>
				<td width="8">:</td>
		  	  <td width="296">
			 
	          <input type="text" id="prepaid_start_date" name="prepaid_start_date" class="select"  style="width:75px;" disabled="disabled"  value="{$prepaid_start_date|date_format:'%Y-%m-%d'}" > 
			  </td>
			</tr>

			<tr>
				<td class="contract_td" width="189">Work Finished Date</td>
				<td width="8">:</td>
		  	  <td width="296">
              {if $staff_status eq 'resigned'}
                  {$resignation_date|date_format:"%B %e, %Y"}
              {/if}
              {if $staff_status eq 'terminated'}
                  {$date_terminated|date_format:"%B %e, %Y"}
              {/if}
              </td>
			</tr>
			<tr>
			<td class="contract_td" width="189">Flexi</td>
			<td width="8">:</td>
		  	<td width="296">{$flexi_str}</td>
			</tr>
			
			<tr>
			<td class="contract_td" width="189">Auto Approve All Over Times</td>
			<td width="8">:</td>
		  	<td width="296"><select name="overtime" id="overtime"  onChange="EnabledDisabledMonthlyLimit()" class="select" style="width:50px;" >
			{$approve_all_overtimes_Options}
		  </select> Weekly Limit <input type="text" id="overtime_monthly_limit" name="overtime_monthly_limit" value="{$overtime_monthly_limit}" overtime_monthly_limit="{$overtime_monthly_limit}" class="select" style="width:70px;" {if $overtime eq 'NO'} disabled="disabled" {/if} onkeyup="CheckIfNumeric(this)" /></td>
			</tr>
			
			<tr>
			<td class="contract_td" width="189">Prepaid Staff</td>
			<td width="8">:</td>
		  	<td width="296"><input type="text" name="prepaid" id="prepaid"  class="select" style="width:50px;" readonly /></td>
			</tr>
			
		  </table></td>
<td valign="top">
<div id="staff_salary_formula">
	<div id="salary_formula" style="font-weight:bold;"></div>
	<div id="staff_yearly"></div>
	<div id="staff_monthly"></div>
	<div id="staff_weekly"></div>
	<div id="staff_daily"></div>
	<div id="staff_hourly"></div>
</div>
		</td>

</tr>


</table>
</div>

	<hr />
	<div class="staff_working_hrs_det"><b>STAFF WORKING HOURS DETAILS</b></div>
	<table cellpadding="1" width="100%" align="center">
		<tr>
			<td width="50%">
			<div id="working_days_div">
				<table width="100%" cellpadding="1" style="border: 1px #62A4D5 solid ;">
					
					<tr class="rate_tr_hdr">
						<td width="19%" height="25"></td>
						<td colspan="3" align="center" class="rate_td_hdr">Working Hours</td>
						<td colspan="3" align="center" class="rate_td_hdr">Lunch</td>
					</tr>
					<tr>
						<td class="rate_td3"><b>Day</b></td>
						<td width="15%" class="rate_td2"><strong>Start</strong></td>
						<td width="14%" class="rate_td2"><strong>Finish</strong></td>
						<td width="11%" class="rate_td2"><strong>Hours</strong></td>
						<td width="17%" class="rate_td2"><strong>Start</strong></td>
						<td width="15%" class="rate_td2"><strong>Finish</strong></td>
						<td width="9%" class="rate_td2"><strong>Hours</strong></td>
					</tr>
					
					{$working_days}
					
					<tr>
						<td class="rate_td3"><b>No.work days</b>&nbsp;<input type="hidden" name="work_days" id="work_days" value="{$reg_work_days}"  /><input type="text" readonly id="days" name="days" class="select" style="width:20px;" value="5" /></td>
						<td colspan="2" class="rate_td3"><b>Total Weekly hours</b></td>
						<td class="rate_td2"><b><span><input type="text" readonly id="total_weekly_hrs" name="total_weekly_hrs" class="select_small" /></span></b></td>
						<td colspan="2"></td>
						<td align="center" ><input type="text" readonly id="total_lunch_hrs" name="total_lunch_hrs" class="select_small" /></td>
					</tr>
				</table>
			  </div>			</td>
		</tr>
		<tr>
		<td >
		<div class="client_charge_out_rate">CLIENT CHARGE OUT RATE / COMMISSIONS</div>
		<div class="client_charge_out_rate_box">
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
			<td width="40%"><table width="461" cellspacing="2" cellpadding="2">
			<tr>
				<td class="contract_td" width="158">Currency</td>
				<td width="8">:</td>
		  	  <td width="258"><span id="currency_box">
			  <select name="currency" id="currency" class="select" onchange="setClientChargeOutRate();">
				<option value="0">Choose Currency</option>
				{$rate_Options}
				</select>			  </span></td>
			</tr>
			<tr>
				<td class="contract_td" width="158">Payment Type</td>
				<td width="8">:</td>
		  	  <td width="258">
			  <select name="payment_type" id="payment_type" class="select" onchange="setClientChargeOutRate();" >
				<!--<option value="0">-</option>-->
				{$payment_Options}
				</select>			  </td>
			</tr>
            { if $client_price_updates }
                { foreach from=$client_price_updates name=client_price_update item=client_price_update }
                    <tr bgcolor="#FFFF00">
                        <td colspan="3" align="center">
                            Scheduled for Client Price Updates on { $client_price_update.scheduled_date|date_format }, Amount {$client_price_update.rate}
                        </td>
                    </tr> 
                {/foreach}
            {/if }


			<tr>
				<td class="contract_td" width="158">Client Price</td>
				<td width="8">:</td>
		  	  <td width="258">
              {if $mode eq 'add' || $mode eq 'new'}
			      <input type="text" class="select" name="client_price" id="client_price" onkeyup="setClientChargeOutRate();showClientRateEffectiveDate();" value="{$client_price}"  />                 
			  {else}
              	  {if $leads_id eq '11' and $view_inhouse_confidential eq 'N'}	
                  <input type="hidden" name="client_price" id="client_price" value="{$client_price}"  /><strong>Confidential</strong>
                  {else}
                  <input type="button" {if $staff_status neq 'ACTIVE'} disabled {/if} name="client_price" id="client_price" value="{$client_price}"  title="update client price" onclick="location.href='/portal/django/subcontractors/client_rate/{$id}'" {if $mode eq 'updated'} disabled="disabled"{/if}  />
                   <small>click to update client price</small>
                  {/if}
                 
              {/if}
			  </td>
			</tr>
			{if $mode neq 'add'}
			<tr >
			<td class="contract_td">Client Price Effective Date:</td>
			<td >:</td>
		  	<td >{$client_price_effective_date}</td>
			</tr>
			{/if}
			
			<tr>
				<td class="contract_td">Fix currency rate</td>
				<td>:</td>
			  <td><input type="text" readonly class="select" name="fix_currency_rate" id="fix_currency_rate" style="width:50px;"/><span id="fix_currency_rate_str"></span></td>
			</tr>
			
			<tr>
				<td class="contract_td">Currency Rate used :</td>
				<td>:</td>
			  <td><input type="text" class="select" name="current_rate" id="current_rate" onkeyup="setClientChargeOutRate()" style="width:50px;" value="{$current_rate}"/>
			   </td>
			</tr>
			
			<tr>
				<td class="contract_td"><span id="tax_str">GST 10%</span></td>
				<td>:</td>
			    <td><select name="with_tax" id="with_tax" onchange="setClientChargeOutRate()" class="select_box">
			      
				{$gst_Options}
			
			      </select>		<!--{$lead_apply_gst} => {$with_tax}-->	    </td>
			</tr>
			<tr>
				<td class="contract_td" width="158">Total charge out rate</td>
				<td width="8">:</td>
		  	  <td width="258">
              {if $leads_id eq '11' and $view_inhouse_confidential eq 'N'}	
              <input type="hidden" readonly class="select" name="total_charge_out_rate" id="total_charge_out_rate" value="{$total_charge_out_rate}"  /><strong>Confidential</strong>
              {else}
              <input type="text" readonly class="select" name="total_charge_out_rate" id="total_charge_out_rate" value="{$total_charge_out_rate}"  />
              {/if}
              </td>
			</tr>
			
			<tr>
				<td class="contract_td">BP Commission</td>
				<td>:</td>
				<td><select name="with_bp_comm" id="with_bp_comm" onchange="setClientChargeOutRate()" class="select_box">
				{$with_bp_comm_Options}
			  </select>
			  <span id="bp_str"></span>
			  </td>
			</tr>
			<tr>
				<td class="contract_td">AFF Commission</td>
				<td>:</td>
				<td><select name="with_aff_comm" id="with_aff_comm" onchange="setClientChargeOutRate()" class="select_box">
			     					{$with_aff_comm_Options}
			
			      </select><span id="aff_str"></span> </td>
			</tr>
			
			
		  </table></td>
			<td valign="top" align="center" width="70%">
			<p><b><span id="salary_formula2" ></span></b></p>
				<table cellpadding="1" cellspacing="0" width="600" style="border: 1px #62A4D5 solid ;">
					<tr class="rate_tr_hdr">
						<td width="162" class="rate_td_hdr">CURRENCY</td>	
						<td width="105" class="rate_td_hdr">Y</td>
						<td width="105" class="rate_td_hdr">M</td>	
						<td width="113" class="rate_td_hdr">W</td>	
						<td width="134" class="rate_td_hdr">D</td>	
						<td width="106" class="rate_td_hdr">H</td>	
					</tr>	
					<tr class="rate_tr">
						<td width="162" class="rate_td4"><span id="currency_txt">-</span></td>	
						<td width="105" class="rate_td4"><span id="client_y">-</span></td>	
						<td width="105" class="rate_td4"><span id="client_m">-</span></td>	
						<td width="113" class="rate_td4"><span id="client_w">-</span></td>	
						<td width="134" class="rate_td4"><span id="client_d">-</span></td>	
						<td width="106" class="rate_td4"><span id="client_h">-</span></td>	
					</tr>
				</table>
			<p><span id="salary_formula2">&nbsp;</span></p>
				<table cellpadding="5" cellspacing="0" width="600" style="border: 1px #62A4D5 solid ;">
					
					<tr class="rate_tr">
						<td colspan="3" align="right" class="rev_td"><b>Revenue</b></td>
						<td  class="rev_td" id="revenue">-</td>	
					</tr>
					<tr class="rate_tr">
						<td width="146" class="rev_td">&nbsp;</td>
						<td colspan="3" class="rev_td" id="revenue">Commissions <em>(Applicable if Payment type is CASH)</em><span id="with_comm"></span></td>
					</tr>	
			
					<tr class="rate_tr">	
						<td  class="rev_td">Business Partner</td>	
						<td  colspan="2" class="rev_td">15% <small>(from revenue)</small></td>
						<td  class="rev_td" id="bp_comm">NA</td>
					</tr>	
					<tr class="rate_tr">
						<td  class="rev_td">Affiliate Commission</td>	
						<td  colspan="2" class="rev_td">5% <small>(from client price)</small></td>
						<td  class="rev_td" id="aff_comm">NA</td>
					</tr>	
					<tr class="rate_tr">
											
						<td colspan="3" align="right" class="rev_td"><b>NET</b></td>
						<td class="rev_td" width="105" id="net">-</td>
					</tr>
				</table>	
				 <div id="revenue_margin"></div>	
			</td>
			</tr>
		</table>
		</div>	</td>
		</tr>
		</table>
</div>		
		<hr />
		<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
		<td style="padding:5px; background:#FFFFCC; border:#333333 solid 1px;">
		<h3>HISTORY</h3>
		{foreach from=$histories item=history name=history}
            <div style="margin-bottom:10px;">
                <div style=" padding-bottom:2px;">{$smarty.foreach.history.iteration} ) By <a href="javascript:toggle('{$history.id}_history')"><b>{$history.admin_name}</b> [{$history.date_changes}]</a></div>
                <div id="{$history.id}_history"  style="display:none; border-bottom:#999999 solid 1px;">
                    <ul>
						<li><b>Status </b>: {$history.changes_status} </li>
                        {foreach from=$history.changes item=changes name=changes}
						    <li>{$changes}</li>
                        {/foreach}
						
					</ul>
					<p><em>{$history.note}</em></p>
                </div>
            </div>
        {foreachelse}
           <p>No history to be shown</p>
        {/foreach}
		</td>
		
		</tr>
		<tr>
		<td>
		<div id="approve_controls">
		
		{if $mode eq 'new'}
		    {if $prepaid eq 'yes'}
			    {if not $counter}
				    <h2>Not yet been invoiced</h2>
				{/if}
			{/if}
		{/if}
		
		mode => {$mode}<br />
		counter => {$counter}<br />
		prepaid => {$prepaid}
        -->
        <p><label style="width:150px;">Service Type : </label><select id="service_type" name="service_type">{$service_type_Options}</select></p>
		{if $mode eq 'new'}
		<p>Notes / Comments</p>
			<textarea name="admin_notes" id="admin_notes" style="width:99%; height:50px;" class="select"></textarea>
			
				<p>
				{if $prepaid eq 'yes'}
				    {if not $counter}
				   	   <input name="button" type="button" id="approve" disabled="disabled"  value="Approve Contract" />
					   <input name="button" type="button" id="update2" value="Update Contract" onclick="ApprovedEditUpdateCancelContract('update2')" />
				    {else}
				       <input name="button" type="button" id="approve" onclick="ApprovedEditUpdateCancelContract('approve')" value="Approve Contract" />	   
				    {/if}
				{else}
				    <input name="button" type="button" id="approve" onclick="ApprovedEditUpdateCancelContract('approve')" value="Approve Contract" />
				{/if}
				
				   {if not $counter}
				   	   <input name="button" type="button" id="cancel" onclick="ApprovedEditUpdateCancelContract('cancel')" value="Cancel Contract" />
				   {else}
				       <input name="button" type="button" id="cancel"  disabled="disabled" value="Cancel Contract" />	   
				   {/if}
			</p>
		{elseif $mode eq 'edit'}
            
			{if $mode eq 'edit' and ($staff_status eq 'terminated' or $staff_status eq 'resigned')}
            <p><label style="width:150px;">Contract Status : </label><select id="contract_status" name="contract_status">
            {foreach from=$STATUS item=s name=s}
                <option value="{$s}" {if $s eq $staff_status} selected="selected" {/if}>{$s|upper}</option>
            {/foreach}
            </select></p>
            
            <p><label style="width:150px;">Reason Type : </label><select id="reason_type" name="reason_type">{$type_Options}</select></p>
            <p><label style="width:150px;">Replacement Request : </label><select id="replacement_request" name="replacement_request">{$replacement_Options}</select></p>          
            {/if}
            <p>Notes / Comments / Reason</p>
			<textarea name="admin_notes" id="admin_notes" style="width:99%; height:50px;" class="select"  >{if $mode eq 'edit' and ($staff_status eq 'terminated' or $staff_status eq 'resigned')}{$reason}{/if}</textarea>
				<b>Note : Edited/Updated contracts are subject for Admin approval</b>		
				<p>
					{if $staff_status eq 'ACTIVE'}
					<input name="button" type="button" id="update" onclick="ApprovedEditUpdateCancelContract('edit')" value="Update Contract" /> 
					<input name="button" type="button" id="resigned" onclick="ShowCloseContractCalendarForm('resigned')" value="Resigned" /> 
					<input name="button" type="button" id="terminated" onclick="ShowCloseContractCalendarForm('terminated')" value="Terminated" />
                    {if $leads_id eq '11' and $view_inhouse_confidential eq 'N'} 
                    <input name="button" type="button" disabled="disabled" value="Update Salary" />
                    <input name="button" type="button" disabled="disabled" value="Update Client Price" /> 
                    {else}
                    <input name="button" type="button" id="update_salary" onclick="location.href='/portal/django/subcontractors/subcon_rate/{$id}'" value="Update Salary" />
                    <input name="button" type="button" id="update_client_rate" onclick="location.href='/portal/django/subcontractors/client_rate/{$id}'" value="Update Client Price" />
                    {/if}
					{else}
					    {if $staff_status eq 'terminated' or $staff_status eq 'resigned'}
                            {if $activate_inactive_staff_contracts}
                                <input type="button" id="activate_inactive_staff_contracts" value="Reactivate" onclick="ReActivate()" />
                            {/if}
						    <input type="button" id="update_reason_btn" value="Update Reason" onclick="UpdateReason()" /> 
                            <!--<input type="button" id="update_comment_btn" value="Update Comment" onclick="UpdateComment()" /> -->                       
					    {else}
					        <input name="button" type="button" disabled="disabled"  value="Update Contract" /> 
					        <input name="button" type="button" disabled="disabled" value="Resigned" /> 
					        <input name="button" type="button" disabled="disabled" value="Terminated" />
					    {/if} 
					{/if}
					
					{ if $staff_status eq 'suspended' }
                        { if $activate_suspended_staff_contracts == 'Y' }
					<input name="button" type="button" id="activate" onclick="ActivateSuspendedStaffContract({$id})" value="Activate Contract" /> 
                        {/if}
					{ /if }
                    
                    {if $admin_delete_staff_contracts}
                         <input type="button" id="delete_contract_btn" value="Delete Contract" onclick="DeleteContract()" {if $staff_status eq 'deleted'} disabled="disabled" {/if} />
                    {/if}
				</p>
				
		{elseif $mode eq 'updated'}	
		<p>Notes / Comments</p>
			<textarea name="admin_notes" id="admin_notes" style="width:99%; height:50px;" class="select"></textarea>	
				
				<p><input name="button" type="button" id="approve_update" onclick="ApprovedEditUpdateCancelContract('update')" value="Approve Updated Contract" />
				   <input name="button" type="button" id="cancel" onclick="ApprovedEditUpdateCancelContract('cancel')" value="Cancel Contract" />
				</p>
		{elseif $mode eq 'cancel'}						
		--
		{else}
		<p>Notes / Comments</p>
			<textarea name="admin_notes" id="admin_notes" style="width:99%; height:50px;" class="select"></textarea>
				<p><input name="button" type="button" id="process" onclick="processContract()" value="Add New Contract" /> <b>Note : New contracts made are subject for Admin approval</b></p>
				
							
		{/if}
		
		
		
		
		</div>
		</td>
		</tr>
	</table>

