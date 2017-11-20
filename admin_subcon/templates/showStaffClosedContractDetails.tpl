<h3 align="center">{$staff_status}</h3>
<table width="100%" cellpadding="2" cellspacing="0">
<tr>
<td width="7%" valign="top"><img src="{$image}" /></td>
<td width="28%" valign="top">
	<p ><label ><b>Name : </b></label>{$name}</a></p>
	<p ><label ><b>Email :</b></label>{$email}</p>
	<p ><label ><b>Skype :</b></label>{$skype}</p>
</td>
<td width="65%" valign="top">
	<table width="100%" cellpadding="3" cellspacing="2">
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
	<td valign="top">{$job_designation}</td>
	</tr>

	</table>
	
</td>
</tr>
</table>

<div class="client_box">
	<p><b>{$name} will be subcontracted to </b></p>
	<p><span class="choose_client">Choose Remotestaff Client</span>&nbsp;&nbsp;&nbsp;&nbsp;<select name="leads_id" id="leads_id" class="select_box" onchange="showClientAds(this.value);">
	<option value="0">Please Select Client</option>
	 {$leadsOptions}
	</select></p>
	<div id="client_history"><input type="hidden" name="max_month_interval" id="max_month_interval" value="0" /></div>
</div>

<fieldset>
	<legend><b>Client Posted Advertisement</b> <span class="gray">(optional)</span></legend>
	<div id="client_ads" ><p>Select a client first to view it's Remotestaff active posted advertisement..</p></div>
</fieldset>

<div style="margin-top:20px;" >
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td width="30%"><table width="360" cellspacing="2" cellpadding="2">
			<tr>
				<td class="contract_td" width="125">Staff Work Status</td>
				<td width="8">:</td>
		  	  <td width="205">
			  <select name="work_status" id="work_status" class="select" onchange="autoPopulate();">
				<option value="0">Please select</option>
				{$work_status_Options}
				</select>
			  </td>
			</tr>
			<tr>
				<td class="contract_td" width="125">Monthly Salary</td>
				<td width="8">:</td>
		  	  <td width="205"><input type="text" class="select" name="staff_monthly" id="staff_monthly" onkeyup="convertSalary();" value="{$staff_monthly}" /></td>
			</tr>
			<tr>
				<td class="contract_td">Client Timezone</td>
				<td>:</td>
			  <td><select name="client_timezone" id="client_timezone"  onchange="setTimeZone()" class="select">
                <option value="0">Select Client Timezone</option>
				   {$timezones_Options}
		      </select></td>
			</tr>
			<tr>
				<td class="contract_td" width="125">Client Working Hours</td>
				<td width="8">:</td>
			  	<td width="205">
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
				<td class="contract_td" width="125">Work Start Date</td>
				<td width="8">:</td>
		  	  <td width="205">
			  <input type="text" id="starting_date" name="starting_date" class="select" style="width:180px;" readonly value="{$starting_date}" > <img align="absmiddle" src="images/calendar_ico.png"   id="bd" style="cursor: pointer; " title="Date selector" onMouseOver="this.style.background='red'" onMouseOut="this.style.background=''" />
	 
			  
			  </td>
			</tr>
			
			
		  </table></td>
<td align="center">
<p><b><span id="salary_formula">Default Formula : ((((Monthly salary * 12months) / 52weeks) / 5days)/8hrs)</span></b></p>
<table cellpadding="1" cellspacing="0" width="600" style="border: 1px #62A4D5 solid ;">
			<tr class="rate_tr_hdr">
				<td width="162" class="rate_td_hdr">CURRENCY</td>	
				<td width="101" class="rate_td_hdr">Rates</td>	
				<td width="105" class="rate_td_hdr">M</td>	
				<td width="113" class="rate_td_hdr">W</td>	
				<td width="134" class="rate_td_hdr">D</td>	
				<td width="106" class="rate_td_hdr">H</td>	
			</tr>	
			<tr class="rate_tr">
				<td width="162" class="rate_td"><b>PHP</b></td>	
				<td width="101" class="rate_td">-</td>	
				<td width="105" class="rate_td"><span class="bold_rate" id="ph_m">-</span></td>	
				<td width="113" class="rate_td"><span class="bold_rate" id="ph_w">-</span></td>	
				<td width="134" class="rate_td"><span class="bold_rate" id="ph_d">-</span></td>	
				<td width="106" class="rate_td"><span class="bold_rate" id="ph_h">-</span></td>	
			</tr>
			<tr class="rate_tr">
				<td width="162" class="rate_td">AUD</td>	
				<td width="101" class="rate_td">41.00</td>	
				<td width="105" class="rate_td"><span id="au_m">-</span></td>	
				<td width="113" class="rate_td"><span id="au_w">-</span></td>	
				<td width="134" class="rate_td"><span id="au_d">-</span></td>	
				<td width="106" class="rate_td"><span id="au_h">-</span></td>	
			</tr>
			<tr class="rate_tr">
				<td width="162" class="rate_td">USD</td>	
				<td width="101" class="rate_td">45.00</td>	
				<td width="105" class="rate_td"><span id="us_m">-</span></td>	
				<td width="113" class="rate_td"><span id="us_w">-</span></td>	
				<td width="134" class="rate_td"><span id="us_d">-</span></td>	
				<td width="106" class="rate_td"><span id="us_h">-</span></td>	
			</tr>
			<tr class="rate_tr">
				<td width="162" class="rate_td">GBP</td>	
				<td width="101" class="rate_td">77.00</td>	
				<td width="105" class="rate_td"><span id="uk_m">-</span></td>	
				<td width="113" class="rate_td"><span id="uk_w">-</span></td>	
				<td width="134" class="rate_td"><span id="uk_d">-</span></td>	
				<td width="106" class="rate_td"><span id="uk_h">-</span></td>	
			</tr>
			
			<tr class="rate_tr">
				<td width="162" class="rate_td">EURO</td>	
				<td width="101" class="rate_td">68.00</td>	
				<td width="105" class="rate_td"><span id="eu_m">-</span></td>	
				<td width="113" class="rate_td"><span id="eu_w">-</span></td>	
				<td width="134" class="rate_td"><span id="eu_d">-</span></td>	
				<td width="106" class="rate_td"><span id="eu_h">-</span></td>	
			</tr>
			<tr class="rate_tr">
				<td width="162" class="rate_td">CAD</td>	
				<td width="101" class="rate_td">45.00</td>	
				<td width="105" class="rate_td"><span id="ca_m">-</span></td>	
				<td width="113" class="rate_td"><span id="ca_w">-</span></td>	
				<td width="134" class="rate_td"><span id="ca_d">-</span></td>	
				<td width="106" class="rate_td"><span id="ca_h">-</span></td>	
			</tr>
		</table></td>

</tr>


</table>

	<hr />
	<div class="staff_working_hrs_det"><b>STAFF WORKING HOURS DETAILS</b></div>
	<table cellpadding="1" width="100%" align="center">
		<tr>
			<td width="50%">
			<div id="working_days_div">
				<table width="100%" cellpadding="1" style="border: 1px #62A4D5 solid ;">
					<!--<tr>
					<td ><b>Staff Timezone</b></td>
					<td colspan="6"><select name="staff_timezone" id="staff_timezone" class="select">
                <option value="0">Select Staff Timezone</option>
				   {$timezones_Options2}
		      </select>
			  <input type="button" value="convert" onclick="convertToStaffTimeZone()" />
			  </td>
					</tr>-->
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
			<td width="30%"><table width="370" cellspacing="2" cellpadding="2">
			<tr>
				<td class="contract_td" width="145">Currency</td>
				<td width="8">:</td>
		  	  <td width="230">
			  <select name="currency" id="currency" class="select" onchange="setClientChargeOutRate();">
				<option value="0">Choose Currency</option>
				{$rate_Options}
				</select>			  </td>
			</tr>
			<tr>
				<td class="contract_td" width="145">Payment Type</td>
				<td width="8">:</td>
		  	  <td width="230">
			  <select name="payment_type" id="payment_type" class="select" onchange="setClientChargeOutRate();" >
				<option value="0">-</option>
				{$payment_Options}
				</select>			  </td>
			</tr>
			<tr>
				<td class="contract_td" width="145">Client Price</td>
				<td width="8">:</td>
		  	  <td width="230"><input type="text" class="select" name="client_price" id="client_price" onkeyup="setClientChargeOutRate()" value="{$client_price}" /></td>
			</tr>
			<tr>
				<td class="contract_td">Fix currency rate</td>
				<td>:</td>
			  <td><input type="text" readonly class="select" name="fix_currency_rate" id="fix_currency_rate" style="width:50px;"/>
			  PHP			  </td>
			</tr>
			
			<tr>
				<td class="contract_td">Current rate</td>
				<td>:</td>
			  <td><input type="text" class="select" name="current_rate" id="current_rate" onkeyup="setClientChargeOutRate()" style="width:50px;" value="{$current_rate}"/>
			  <small class="gray">Must be higher than the Fix currency rate</small>			  </td>
			</tr>
			
			<tr>
				<td class="contract_td"><span id="tax_str">GST 10%</span></td>
				<td>:</td>
			    <td><select name="with_tax" id="with_tax" onchange="setClientChargeOutRate()" class="select_box">
			      
				{$gst_Options}
			
			      </select>		<!--{$table} {$with_tax}-->	    </td>
			</tr>
			<tr>
				<td class="contract_td" width="145">Total charge out rate</td>
				<td width="8">:</td>
		  	  <td width="230"><input type="text" readonly class="select" name="total_charge_out_rate" id="total_charge_out_rate" value="{$total_charge_out_rate}"  /></td>
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
			<p><b><span >Default Formula : ((((Monthly salary * 12months) / 52weeks) / 5days)/8hrs)</span></b></p>
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
		<tr>
		<td style="padding:5px; background:#FFFFCC; border:#333333 solid 1px;">
		<h3>HISTORY</h3>
		
		{section name=j loop=$resulta}
				<div style="margin-bottom:10px;">
					<div style="border-bottom:#999999 solid 1px; padding-bottom:2px;">{$smarty.section.j.iteration} ) By <b>{$resulta[j].admin_name}</b> [{$resulta[j].date_changes}]</div>
					<ul>
						<li><b>status </b>: {$resulta[j].changes_status} </li>
						<li>{$resulta[j].changes}</li>
						
					</ul>
					<p><em>{$resulta[j].note}</em></p>
				</div>
		{sectionelse}
			<p>No history to be shown</p>
		{/section}
		
		
		</td>
		
		</tr>
		<tr>
		<td>
		<div id="approve_controls">
		<p>Notes / Comments</p>
		
		{if $mode eq 'new'}
			<textarea name="admin_notes" id="admin_notes" style="width:99%; height:50px;" class="select"></textarea>
			<p>Admin Controls</p>
				<p><input name="button" type="button" id="approve" onclick="ApprovedEditUpdateCancelContract('approve')" value="Approve Contract" />
				   <input name="button" type="button" id="cancel" onclick="ApprovedEditUpdateCancelContract('cancel')" value="Cancel" />
			</p>
		{elseif $mode eq 'edit'}
			
			<textarea name="admin_notes" id="admin_notes" style="width:99%; height:50px;" class="select"></textarea>
				<b>Note : Edited/Updated contracts are subject for Admin approval</b>		
				<p>
					{if $staff_status eq 'ACTIVE'}
					<input name="button" type="button" id="update" onclick="ApprovedEditUpdateCancelContract('edit')" value="Update Contract" /> 
					<input name="button" type="button" id="resigned" onclick="CloseContract('resigned')" value="Resigned" /> 
					<input name="button" type="button" id="terminated" onclick="CloseContract('terminated')" value="Terminated" /> 
					{else}
					<input name="button" type="button" disabled="disabled"  value="Update Contract" /> 
					<input name="button" type="button" disabled="disabled" value="Resigned" /> 
					<input name="button" type="button" disabled="disabled" value="Terminated" /> 
					{/if}
				</p>
				
		{elseif $mode eq 'updated'}	
			<textarea name="admin_notes" id="admin_notes" style="width:99%; height:50px;" class="select"></textarea>	
				<p>Admin Controls</p>
				<p><input name="button" type="button" id="approve_update" onclick="ApprovedEditUpdateCancelContract('update')" value="Approve Updated Contract" />
				   <input name="button" type="button" id="cancel" onclick="ApprovedEditUpdateCancelContract('cancel')" value="Cancel" />
				</p>
		{elseif $mode eq 'cancel'}						
		--
		{else}
			<textarea name="admin_notes" id="admin_notes" style="width:99%; height:50px;" class="select"></textarea>
				<p><input name="button" type="button" id="process" onclick="processContract()" value="Add New Contract" /> <b>Note : New contracts made are subject for Admin approval</b></p>
				
							
		{/if}
		
		
		
		
		</div>
		</td>
		</tr>
	</table>
</div>



