
<table width='100%' cellpadding='0'cellspacing='0' style="border:#333333 1px;" >
<tr><td style="border-right:#000000 1px solid;">&nbsp;</td><td align="right" valign="bottom"><br /><a href="AddUpdateLeads.php?leads_id={$leads_id}&lead_status={$lead_status}&page_type={$page_type}&url={$url}">Edit Leads Information</a></td></tr>
<tr>
<td width="50%" valign="top" style="border-right:#000000 1px solid;">
<!-- left info -->
<table width='100%' cellpadding='3'cellspacing='0' id="leads_info"  >
<tr>
<td width="30%" valign="top" class="td_info td_la" >Fullname</td>
<td width="70%" valign="top" class="td_info"><b>{$leads_info.fname|escape} {$leads_info.lname|escape} #{$leads_id}</b>
{if $identical }
<span style="color:#FFFFFF; background:#FF0000; cursor:pointer; padding-bottom:1px; padding-top:0px; padding-left:2px; padding-right:2px; float:right; " onclick="ShowIdentical()"><small style=" font:bold 8px verdana;">IDENTICAL</small></span>
<div id="identical">
<div class="iden_hdr">IDENTICAL NAME TO:
<span onclick="toggle('identical')">[ X ]</span>
</div>
{$identical}


<input type="button" value="View" onclick="location.href='leads_identical.php?id={$leads_id}&lead_status={$lead_status}'" />
</div>
{/if}
</td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Gender</td>
<td  valign="top" class="td_info">{$leads_info.gender|capitalize}</td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Status</td>
<td  valign="top" class="td_info"><b style="color:#FF0000;">{$leads_info.status}</b></td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Promotional Code</td>
<td  valign="top" class="td_info" style="color:#006600;">{$leads_info.tracking_no}</td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Ratings</td>
<td  valign="top" class="td_info"><span id="ratings">{$starOptions}</span><span style="float:right;"><small>change rating</small> <select name="star" id="star" style="font:10px tahoma;" onchange="ChangeLeadsRating()" >
{$rate_Options}

</select>&nbsp;</span></td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Date Registered</td>
<td  valign="top" class="td_info">{$date_registered}
<span style="float:right; font-family:tahoma; font-size:10px; color:#666666;">
{if $leads_info.last_updated_date} Last Updated Date : {$leads_info.last_updated_date|date_format:"%b. %e, %Y %I:%M:%S %p"}<br />{/if}
{if $leads_info.last_viewed_date} Last Viewed Date : {$leads_info.last_viewed_date|date_format:"%b. %e, %Y %I:%M:%S %p"} {/if}
</span>
</td>
</tr>

{if $leads_info.registration_dates }
<tr>
<td  valign="top" class="td_info td_la">Original Registration Date</td>
<td  valign="top" class="td_info">{$leads_info.registration_dates|replace:',':'<br>'}</td>
</tr>
{/if}

<tr>
<td  valign="top" class="td_info td_la">Primary Email</td>
<td  valign="top" class="td_info">{$leads_info.email}
<span style="float:right;"><a href="javascript:popup_win('./leads_information/admin_bp_reset_password_for_lead.php?leads_id={$leads_id}',400,200);" style=" font-size:10px;">reset password</a></span>
</td>
</tr>


<tr>
<td  valign="top" class="td_info td_la">Skype Id</td>
<td  valign="top" class="td_info">{$leads_info.leads_skype_id}</td>
</tr>



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


<tr>
<td width="30%" valign="top" class="td_info td_la">Country / IP</td>
<td width="70%" valign="top" class="td_info">{$leads_info.leads_country}  {$leads_info.leads_ip}</td>
</tr>

<tr>
<td width="30%" valign="top" class="td_info td_la">Registered In</td>
<td width="70%" valign="top" class="td_info">{$leads_info.registered_in_str}</td>
</tr>

<tr>
<td width="30%" valign="top" class="td_info td_la">State</td>
<td width="70%" valign="top" class="td_info">{$leads_info.state}</td>
</tr>


<tr>
<td width="30%" valign="top" class="td_info td_la">Leads of</td>
<td width="70%" valign="top" class="td_info">{$leads_of}</td>
</tr>


<tr>
<td width="30%" valign="top" class="td_info td_la">Company</td>
<td width="70%" valign="top" class="td_info">{$leads_info.company_name|escape}</td>
</tr>

<tr>
<td width="30%" valign="top" class="td_info td_la">Company Position</td>
<td width="70%" valign="top" class="td_info">{$leads_info.company_position|escape}</td>
</tr>

<tr>
	<td width="30%" valign="top" class="td_info td_la">ABN Number</td>
	<td width="70%" valign="top" class="td_info">{$leads_info.abn_number|escape}</td>
</tr>

<tr>
<td width="30%" valign="top" class="td_info td_la">Company Address</td>
<td width="70%" valign="top" class="td_info">{$leads_info.company_address|escape}</td>
</tr>

<tr>
<td width="30%" valign="top" class="td_info td_la">Website</td>
<td width="70%" valign="top" class="td_info">{$leads_info.website|escape}</td>
</tr>

<tr>
<td width="30%" valign="top" class="td_info td_la">Company Phone</td>
<td width="70%" valign="top" class="td_info">{$leads_info.officenumber|escape}</td>
</tr>

<tr>
<td width="30%" valign="top" class="td_info td_la">Mobile Phone</td>
<td width="70%" valign="top" class="td_info">{$leads_info.mobile|escape}</td>
</tr>

<tr>
<td width="30%" valign="top" class="td_info td_la">Company Industry</td>
<td width="70%" valign="top" class="td_info">{$leads_info.company_industry|replace:',':'<br>'}</td>
</tr>

<tr>
<td width="30%" valign="top" class="td_info td_la">No.of Employee</td>
<td width="70%" valign="top" class="td_info">{$leads_info.company_size}</td>
</tr>

<tr>
<td width="30%" valign="top" class="td_info td_la">Company Turnover in a Year</td>
<td width="70%" valign="top" class="td_info">{$leads_info.company_turnover}</td>
</tr>

<tr>
<td width="30%" valign="top" class="td_info td_la">Company Profile</td>
<td width="70%" valign="top" class="td_info">{$leads_info.company_description|escape}</td>
</tr>


<tr>
<td width="30%" valign="top" class="td_info td_la">No.of Remote Staff neeeded</td>
<td width="70%" valign="top" class="td_info">{$leads_info.remote_staff_needed}</td>
</tr>


<tr>
<td width="30%" valign="top" class="td_info td_la">Remote Staff needed</td>
<td width="70%" valign="top" class="td_info">{$leads_info.remote_staff_needed_when|escape}</td>
</tr>

<tr>
<td width="30%" valign="top" class="td_info td_la">Remote Staff needed in Home Office</td>
<td width="70%" valign="top" class="td_info">{$leads_info.remote_staff_one_home}</td>
</tr>


<tr>
<td width="30%" valign="top" class="td_info td_la">Remote Staff needed in Office</td>
<td width="70%" valign="top" class="td_info">{$leads_info.remote_staff_one_office}</td>
</tr>


<tr>
<td width="30%" valign="top" class="td_info td_la">Remote Staff responsibilities</td>
<td width="70%" valign="top" class="td_info">{$leads_info.remote_staff_competences|regex_replace:"/[\r\t\n]/":"<br>"}</td>
</tr>

<tr>
<td valign="top" class="td_info td_la">Client Staff Relations Officer</td>
<td valign="top" class="td_info">{$csro_officer.admin_fname} {$csro_officer.admin_lname}</td>
</tr>

<tr>
<td valign="top" class="td_info td_la">Hiring Coordinator</td>
<td valign="top" class="td_info">{$hiring_coordinator.admin_fname} {$hiring_coordinator.admin_lname}</td>
</tr>


<tr>
<td valign="top" class="td_info td_la">Lead is Inquiring about : </td>
<td valign="top" class="td_info" >
<div ><a href="javascript:ShowPosition();" id="add_position_link" style=" font-size:10px;">Add Position</a></div>
<div id="add_position"></div>
<div id="job_positions">
<table width="100%" cellpadding="2" cellspacing="1">
{$job_positions}
</table>
</div>
</td>
</tr>

<tr>
<td valign="top" class="td_info td_la">Currency <small style="color:#FF0000;">( Client Settings. )</small></td>
<td valign="top" class="td_info" ><strong>{$leads_info.currency}</strong> <small style="margin-left:10PX;">{if $leads_info.currency eq 'AUD'} {if $leads_info.apply_gst eq 'Y'} GST APPLIED {else} GST NOT APPLIED {/if} {/if}</small></td>
</tr>



</table>
<!-- end left info --></td>
<td width="50%" valign="top" style="padding-left:2px;">
<!-- right info -->
<table width='100%' cellpadding='3'cellspacing='0' id="leads_info"  >
<tr>
<td  colspan="2" valign="top" class="td_info" ><b style="color:#FF0000;">Contact Details</b></td>
</tr>

<tr>
<td width="50%"  valign="top" class="td_info td_la">Accounts Department Staff Name 1</td>
<td width="50%"  valign="top" class="td_info">{$leads_info.acct_dept_name1}</td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Accounts Department Email 1</td>
<td  valign="top" class="td_info">{$leads_info.acct_dept_email1}</td>
</tr>


<tr>
<td  valign="top" class="td_info td_la">Accounts Department Contact nos. 1</td>
<td  valign="top" class="td_info">{$leads_info.acct_dept_contact1}</td>
</tr>

<tr>
<td width="50%"  valign="top" class="td_info td_la">Accounts Department Staff Name 2</td>
<td width="50%"  valign="top" class="td_info">{$leads_info.acct_dept_name2}</td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Accounts Department Email 2</td>
<td  valign="top" class="td_info">{$leads_info.acct_dept_email2}</td>
</tr>


<tr>
<td  valign="top" class="td_info td_la">Accounts Department Contact nos. 2</td>
<td  valign="top" class="td_info">{$leads_info.acct_dept_contact2}</td>
</tr>



<tr>
<td colspan="2"  valign="top" class="td_info"><b style="color:#FF0000;">Person directly working with sub-contractor in client organization</b></td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Name</td>
<td  valign="top" class="td_info">{$leads_info.supervisor_staff_name|escape}</td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Job Title</td>
<td  valign="top" class="td_info">{$leads_info.supervisor_job_title}</td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Skype</td>
<td  valign="top" class="td_info">{$leads_info.supervisor_skype}</td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Email</td>
<td  valign="top" class="td_info">{$leads_info.supervisor_email}</td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Contact</td>
<td  valign="top" class="td_info">{$leads_info.supervisor_contact}</td>
</tr>


<tr>
<td  valign="top" class="td_info td_la">Business Owner/Director/CEO</td>
<td  valign="top" class="td_info">{$leads_info.business_owners}</td>
</tr>


<tr>
<td  valign="top" class="td_info td_la">Business Partners</td>
<td  valign="top" class="td_info">{$leads_info.business_partners}</td>
</tr>

<tr>
<td colspan="2"  valign="top" class="td_info"><b style="color:#FF0000;">Secondary Contact Person</b></td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Name</td>
<td  valign="top" class="td_info">{$leads_info.secondary_contact_person|escape}</td>
</tr>



<tr>
<td  valign="top" class="td_info td_la">Email</td>
<td  valign="top" class="td_info">{$leads_info.sec_email|escape}</td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Phone No.</td>
<td  valign="top" class="td_info">{$leads_info.sec_phone|escape}</td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Company Position</td>
<td  valign="top" class="td_info">{$leads_info.sec_position|escape}</td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Note</td>
<td  valign="top" class="td_info">{$leads_info.note|escape}</td>
</tr>

<tr>
<td  valign="top" class="td_info td_la" colspan="2"><b style="color:#FF0000;">Upload Files</b></td>
</tr>
<tr>
<td  valign="top" class="td_info" colspan="2">
		<table cellspacing=1 cellpadding=3 width=100%>
			<tr>
				<td colspan="2">File Type/Size<font color="#666666"><em>(doc, pdf or image format) Upload limit per file is 5 MB)</em></font></td>
			</tr>
			<tr>
				<td>Type</td>
				<td>
					<select name="type">
	                    <option value="" selected>Select File Type</option>
						<option value="Signed contract">Signed contract</option>
						<option value="Credit card form">Credit card form</option>
						<option value="Direct debit form">Direct debit form</option>
                        <option value="Other">Other</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Staff</td>
				<td>
					<select name="staff">
	                    <option value="" selected>Select Staff</option>
						{ $hired_staff_Options }
					</select>
				</td>
			</tr>  
			<tr>
				<td>File</td>
				<td><input type="file" name="fileimg" value="" size="35" />	</td>
			</tr>                      
			<tr>
				<td valign="top">Notes</td>
				<td><textarea name="notes" rows="3" cols="35"></textarea></td>
			</tr>
			<tr>
            	<td></td>
				<td><input type="submit" value="Upload File" name="upload_file" class="button"></td>
			</tr>			
		</table>
</td>
</tr>

<tr>
<td  valign="top" class="td_info td_la">Preffers to Communicate Via : </td>
<td  valign="top" class="td_info">{$leads_info.preffered_communication}</td>
</tr>
<tr>
<td  valign="top" class="td_info td_la">Test Account : </td>
<td  valign="top" class="td_info">{$leads_info.is_test}</td>
</tr>
</table>

<!-- end right info --></td>
</tr>
</table>