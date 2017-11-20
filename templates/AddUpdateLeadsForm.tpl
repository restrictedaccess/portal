

<table width='100%' cellpadding='0'cellspacing='0' style="border:#333333 1px;" >
<tr>
<td width="50%"  style="border-right:#000000 1px solid;">
<!-- left info -->
<table width='100%' cellpadding='5'cellspacing='0' id="leads_info"  >





<tr>
<td width="37%" valign="middle" class="td_info td_la" >First name</td>
<td width="63%" class="td_info"><input type="text" name="fname" id="fname" size="37" value="{$leads_info.fname|escape}" /></td>
</tr>

<tr>
<td width="37%" valign="middle" class="td_info td_la" >Last name</td>
<td width="63%" class="td_info"><input type="text" name="lname" id="lname" size="37" value="{$leads_info.lname|escape}" /></td>
</tr>

<tr>
<td width="37%" valign="middle" class="td_info td_la" >Leads Location</td>
<td width="63%" class="td_info"><select name="leads_location" id="leads_location" style="width:240px;"  >
	{$leads_location_options}
	</select></td>
</tr>
<tr>
<td width="37%" valign="middle" class="td_info td_la" >Registration</td>
<td width="63%" class="td_info"><select name="registered_in" id="registered_in" style="width:240px;"  >
	{$registered_Options}
	</select></td>
</tr>

{if $leads_id neq ''}
	{if $leads_info.status eq ''}
		<tr>
		<td  valign="middle" class="td_info td_la">Status</td>
		<td  class="td_info"><input type="text" name="status" id="status" readonly value="New Leads" size="37" /></td>
		</tr>
	{else}
		<tr>
		<td  valign="middle" class="td_info td_la">Status</td>
		<td  class="td_info"><input type="text" name="status" id="status" readonly value="{$leads_info.status}" size="37" /></td>
		</tr>

	{/if}
{else}
<tr>
<td  valign="middle" class="td_info td_la">Status</td>
<td  class="td_info"><input type="text" name="status" id="status" readonly value="New Leads" size="37" /></td>
</tr>
{/if}
{if $leads_id neq ''}
<tr>
<td   class="td_info td_la">Date Registered / Added </td>
<td   class="td_info">{$date_registered}</td>
</tr>
{/if}


<tr>
<td   class="td_info td_la">Gender</td>
<td   class="td_info"><select name="gender" id="gender" ><option value="">-</option>
{foreach from=$gender_options item=g name=g}
<option value="{$g}" {if $g eq $leads_info.gender } selected="selected" {/if}>{$g|capitalize}</option>
{/foreach}
</select></td>
</tr>

<tr>
<td   class="td_info td_la">Ratings</td>
<td   class="td_info"><select name="star" id="star" ><option value="">-</option>{$rate_Options}</select>{$starOptions}</td>
</tr>


<tr>
<td class="td_info td_la">Primary Email</td>
<td class="td_info"><input type="text" name="email" id="email" size="37" value="{$leads_info.email}" /></td>
</tr>

<tr>
<td class="td_info td_la">Skype Id</td>
<td class="td_info"><input type="text" name="leads_skype_id" id="leads_skype_id" size="37" value="{$leads_info.leads_skype_id}" /></td>
</tr>


{if $mode eq 'Update'}
<tr>
<td  valign="top" class="td_info td_la">Alternative Email</td>
<td  valign="top" class="td_info"><a href="javascript:ShowAddAlternativeEmailsForm();" style="float:right; font-size:10px;">add email</a>
<div id="alternative_email_form"></div>
<div  id="alternative_emails_list">
<table width="80%" cellpadding="1" cellspacing="2">
{section name=j loop=$alternate_emails}
<tr>
<td width="72%">{$alternate_emails[j].email}</td>
<td width="28%"><a href="javascript:DeleteAlternativeEmail({$alternate_emails[j].id});">x</a></td>
</tr>
{/section}
</table>
</div>
</td>
</tr>
{/if}
<!--
<tr>
<td class="td_info td_la">Primary Email Receives Invoice</td>
<td class="td_info"><select name="email_receives_invoice" id="email_receives_invoice" >
    {$email_receives_invoiceOptions}
</select></td>
</tr>
-->


<tr>
<td width="37%"  class="td_info td_la">Country / IP</td>
<td width="63%"  class="td_info"><select name="leads_country" id="leads_country" style="width:240px;" onchange="GetLeadsCountryState('search')"><option value="">-</option>{$countryOptions}</select><br />{$leads_info.leads_ip}

{literal}
<script type="text/javascript">
GetLeadsCountryState('default');
</script>
{/literal}
</td>
</tr>

<tr>
<td width="37%"  class="td_info td_la">State</td>
<td width="63%"  class="td_info"><div id="state_div"></div></td>
</tr>






<tr>
<td width="37%"  class="td_info td_la">Business Partner</td>
<td width="63%"  class="td_info"><select name="business_partner_id" id="business_partner_id" style="width:240px;" >{$BPOptions}</select></td>
</tr>


<tr>
<td width="37%"  class="td_info td_la">Promotional Codes</td>
<td width="63%"  class="td_info"><select name="tracking_no" id="tracking_no" style="width:240px;"  ><option value="">-</option>{$promocodesOptions}</select></td>
</tr>

 

<tr>
<td width="37%"  class="td_info td_la">Affiliates</td>
<td width="63%"  class="td_info"><select name="agent_id" id="agent_id" style="width:240px;" >
	<option value="">-</option>
	{$AFFOptions}
	</select></td>
</tr>





<tr>
<td width="37%"  class="td_info td_la">Company</td>
<td width="63%"  class="td_info"><input type="text" name="company_name" id="company_name" size="37" value="{$leads_info.company_name|escape}" /></td>
</tr>

<tr>
<td width="37%"  class="td_info td_la">Company Position</td>
<td width="63%"  class="td_info"><input type="text" name="company_position" id="company_position" size="37" value="{$leads_info.company_position|escape}" /></td>
</tr>


<tr>
<td width="37%"  class="td_info td_la">ABN Number</td>
<td width="63%"  class="td_info"><input type="text" name="abn_number" id="abn_number" size="37" value="{$leads_info.abn_number|escape}" /></td>
</tr>

<tr>
<td width="37%"  class="td_info td_la">Company Address</td>
<td width="63%"  class="td_info"><textarea cols="30" rows="3" name="company_address" id="company_address" >{$leads_info.company_address|escape}</textarea></td>
</tr>

<tr>
<td width="37%"  class="td_info td_la">Website</td>
<td width="63%"  class="td_info"><input type="text" name="website" id="website" size="37" value="{$leads_info.website|escape}" /></td>
</tr>

<tr>
<td width="37%"  class="td_info td_la">Company Phone</td>
<td width="63%"  class="td_info"><input type="text" name="officenumber" id="officenumber" size="37" value="{$leads_info.officenumber|escape}" /></td>
</tr>

<tr>
<td width="37%"  class="td_info td_la">Mobile Phone</td>
<td width="63%"  class="td_info"><input type="text" name="mobile" id="mobile" size="37" value="{$leads_info.mobile|escape}" /></td>
</tr>

<tr>
<td width="37%"  class="td_info td_la" valign="top">Company Industry</td>
<td width="63%"  class="td_info">{$industryoptions}</td>
</tr>

<tr>
<td width="37%"  class="td_info td_la">No.of Employee</td>
<td width="63%"  class="td_info"><input type="text" name="company_size" id="company_size" size="37" value="{$leads_info.company_size}" /></td>
</tr>

<tr>
<td width="37%"  class="td_info td_la">Company Turnover in a Year</td>
<td width="63%"  class="td_info"><select name="company_turnover" id="company_turnover" style="width:240px;"  ><option value="">-</option>{$moneyoptions}</select></td>
</tr>

<tr>
<td width="37%"  class="td_info td_la">Company Profile</td>
<td width="63%"  class="td_info"><textarea cols="30" rows="3" name="company_description" id="company_description" >{$leads_info.company_description|escape}</textarea></td>
</tr>


<tr>
<td width="37%"  class="td_info td_la">No.of Remote Staff neeeded</td>
<td width="63%"  class="td_info"><input type="text" name="remote_staff_needed" id="remote_staff_needed" size="37" value="{$leads_info.remote_staff_needed}" /></td>
</tr>


<tr>
<td width="37%"  class="td_info td_la">Remote Staff needed</td>
<td width="63%"  class="td_info"><input type="text" name="remote_staff_needed_when" id="remote_staff_needed_when" size="37" value="{$leads_info.remote_staff_needed_when}" /></td>
</tr>

<tr>
<td width="37%"  class="td_info td_la">Remote Staff needed in Home Office</td>
<td width="63%"  class="td_info"><select name="remote_staff_one_home" id="remote_staff_one_home" >
    <option value="">-</option>
    
    
{$rsInHomeOptions}


</select></td>
</tr>


<tr>
<td width="37%"  class="td_info td_la">Remote Staff needed in Office</td>
<td width="63%"  class="td_info"><select name="remote_staff_one_office" id="remote_staff_one_office" >
    <option value="">-</option>
    
{$rsInOfficeOptions}

</select></td>
</tr>


<tr>
<td width="37%"  class="td_info td_la">Remote Staff responsibilities</td>
<td width="63%"  class="td_info"><textarea cols="30" rows="3" name="remote_staff_competences" id="remote_staff_competences" >{$leads_info.remote_staff_competences|escape}</textarea></td>
</tr>

<tr>
<td valign="top" class="td_info td_la">Client Staff Relations Officer</td>
<td valign="top" class="td_info"><select name="csro_id" id="csro_id" style="width:240px;"  >
	<option value="">-</option>
	{$csro_Options}
	</select></td>
</tr>

<tr>
<td valign="top" class="td_info td_la">Hiring Coordinator</td>
<td valign="top" class="td_info"><select name="hiring_coordinator_id" id="hiring_coordinator_id" style="width:240px;"  >
	<option value="">-</option>
	{$hiring_coordinator_Options}
	</select></td>
</tr>

{if $mode eq 'Update'}
<tr>
<td valign="top" class="td_info td_la">Lead is Inquiring about</td>
<td valign="top" class="td_info">
<div ><a href="javascript:ShowPosition();" id="add_position_link">Add Position</a></div>
<div id="add_position"></div>
<div id="job_positions">
<table width="100%" cellpadding="2" cellspacing="1">
{$job_positions}
</table>
</div>
</td>
</tr>


<!--
<tr>
<td valign="top" class="td_info td_la">Apply GST in Client Invoice </td>
<td valign="top" class="td_info" ><select name="apply_gst" id="apply_gst" {if $currency_code and  currency_gst_apply} disabled="disabled" {/if}  >
	{$apply_gstOptions}
	</select> <small style="float:right; color:#FF0000;">( Applicable only if currency setting is in AUD. )</small></td>
</tr>
-->
{/if}
</table>
<!-- end left info --></td>
<td width="50%" valign="top"  style="padding-left:2px;">
<!-- right info -->
<table width='100%' cellpadding='5'cellspacing='0' id="leads_info"  >
<tr>
<td  colspan="2"  class="td_info" ><b style="color:#FF0000;">Contact Details</b></td>
</tr>

<tr>
<td width="50%"   class="td_info td_la">Accounts Department Staff Name 1</td>
<td width="50%"   class="td_info"><input type="text" name="acct_dept_name1" id="acct_dept_name1" size="37" value="{$leads_info.acct_dept_name1|escape}" /></td>
</tr>

<tr>
<td   class="td_info td_la">Accounts Department Email 1</td>
<td   class="td_info"><input type="text" name="acct_dept_email1" id="acct_dept_email1" size="37" value="{$leads_info.acct_dept_email1|escape}" /></td>
</tr>


<tr>
<td   class="td_info td_la">Accounts Department Contact nos. 1</td>
<td   class="td_info"><input type="text" name="acct_dept_contact1" id="acct_dept_contact1" size="37" value="{$leads_info.acct_dept_contact1|escape}" /></td>
</tr>

<tr>
<td width="50%"   class="td_info td_la">Accounts Department Staff Name 2</td>
<td width="50%"   class="td_info"><input type="text" name="acct_dept_name2" id="acct_dept_name2" size="37" value="{$leads_info.acct_dept_name2|escape}" /></td>
</tr>

<tr>
<td   class="td_info td_la">Accounts Department Email 2</td>
<td   class="td_info"><input type="text" name="acct_dept_email2" id="acct_dept_email2" size="37" value="{$leads_info.acct_dept_email2|escape}" /></td>
</tr>


<tr>
<td   class="td_info td_la">Accounts Department Contact nos. 2</td>
<td   class="td_info"><input type="text" name="acct_dept_contact2" id="acct_dept_contact2" size="37" value="{$leads_info.acct_dept_contact2|escape}" /></td>
</tr>



<tr>
<td colspan="2"   class="td_info"><b style="color:#FF0000;">Person directly working with sub-contractor in client organization</b></td>
</tr>

<tr>
<td   class="td_info td_la">Name</td>
<td   class="td_info"><input type="text" name="supervisor_staff_name" id="supervisor_staff_name" size="37" value="{$leads_info.supervisor_staff_name|escape}" /></td>
</tr>

<tr>
<td   class="td_info td_la">Job Title</td>
<td   class="td_info"><input type="text" name="supervisor_job_title" id="supervisor_job_title" size="37" value="{$leads_info.supervisor_job_title|escape}" /></td>
</tr>

<tr>
<td   class="td_info td_la">Skype</td>
<td   class="td_info"><input type="text" name="supervisor_skype" id="supervisor_skype" size="37" value="{$leads_info.supervisor_skype|escape}" /></td>
</tr>

<tr>
<td   class="td_info td_la">Email</td>
<td   class="td_info"><input type="text" name="supervisor_email" id="supervisor_email" size="37" value="{$leads_info.supervisor_email|escape}" /></td>
</tr>

<tr>
<td class="td_info td_la">Contact</td>
<td class="td_info"><input type="text" name="supervisor_contact" id="supervisor_contact" size="37" value="{$leads_info.supervisor_contact|escape}" /></td>
</tr>


<tr>
<td class="td_info td_la">Business Owner/Director/CEO</td>
<td class="td_info"><input type="text" name="business_owners" id="business_owners" size="37" value="{$leads_info.business_owners|escape}" /></td>
</tr>


<tr>
<td class="td_info td_la">Business Partners</td>
<td class="td_info"><input type="text" name="business_partners" id="business_partners" size="37" value="{$leads_info.business_partners|escape}" /></td>
</tr>


<tr>
<td colspan="2"  valign="top" class="td_info"><b style="color:#FF0000;">Secondary Contact Person</b></td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Name</td>
<td  valign="top" class="td_info"><input type="text" name="secondary_contact_person" id="secondary_contact_person" value="{$leads_info.secondary_contact_person|escape}" size="37" /></td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Email</td>
<td  valign="top" class="td_info"><input type="text" name="sec_email" id="sec_email" value="{$leads_info.sec_email|escape}" size="37" /></td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Phone No.</td>
<td  valign="top" class="td_info"><input type="text" name="sec_phone" id="sec_phone" value="{$leads_info.sec_phone|escape}" size="37" /></td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Company Position</td>
<td  valign="top" class="td_info"><input type="text" name="sec_position" id="sec_position" value="{$leads_info.sec_position|escape}" size="37" /></td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Note</td>
<td  valign="top" class="td_info"><textarea cols="30" rows="3" name="note" id="note" >{$leads_info.note|escape}</textarea></td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Preffers to Communicate Via : </td>
<td  valign="top" class="td_info"><select name="preffered_communication" id="preffered_communication" style="width:240px;"  >
	{$preffered_communication_Options}
	</select></td>
</tr>

<tr>
<td width="37%"  class="td_info td_la">Test Account</td>
<td width="63%"  class="td_info"><select name="is_test" id="is_test" > 
{$is_TestOptions}
</select></td>
</tr>

</table>

 <!-- end right info --></td>
</tr>
</table>
