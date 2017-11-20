{*  2010-03-12  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   made the password readonly, random character password generated
*}
<input type="hidden" id="mode" value="{$mode}" />
<input type="hidden" id="admin_id" value="{$admin.admin_id}" />
<div id="div_add_update_form">

    <p><label>Inhouse Staff : </label><select name="userid" id="userid" class="select" {if $userid} disabled="disabled" {/if} >
    <option value="">Please select a staff</option>
    {html_options values=$STAFF_USERIDS  output=$STAFF_NAMES selected=$admin.userid  }
     </select></p>

    <hr />
    <span id="inhouse_details"></span>
    <p align="center"><strong style="color:#F00;">Admin Details</strong></p>
	<p><label>First Name : </label><input type="text" class="select" id="admin_fname" name="admin_fname" value="{$admin.admin_fname}"></p>
	<p><label>Last Name : </label><input type="text" class="select" id="admin_lname" name="admin_lname" value="{$admin.admin_lname}"></p>
    <p><label>Email : </label><input type="text" class="select" id="admin_email" name="admin_email" value="{$admin.email}" style="width:100px;"><select id="domain" name="domain"  class="select" style="width:155px;">{html_options values=$ALLOWED_EMAIL_DOMAIN  output=$ALLOWED_EMAIL_DOMAIN selected=$admin.domain  }</select></p>
    <p><label>Restriction :</label><select id="status" name="status"  class="select">{html_options values=$ADMIN_STATUS  output=$ADMIN_STATUS selected=$admin.status  }</select><p>
    
    {if $current_admin.edit_admin_settings eq 'Y'}
    <hr /> 
    <p align="center"><strong style="color:#F00;">Admin Settings</strong></p>
    {/if}   
    <p {if $current_admin.edit_admin_settings eq 'N'} class="hid" {/if} ><label>Manage Recruiters : </label><span id="head_recruiter_span"><select id="manage_recruiters" name="manage_recruiters"  class="select yesno">{html_options values=$ANSWERS  output=$ANSWERS_STR selected=$admin.manage_recruiters  }</select></span></p>
    <p {if $current_admin.edit_admin_settings eq 'N'} class="hid" {/if}><label>Can Adjust Timesheet :</label><select id="adjust_time_sheet" name="adjust_time_sheet" class="select yesno">{html_options values=$ANSWERS  output=$ANSWERS_STR selected=$admin.adjust_time_sheet  }</select></p>
	<p {if $current_admin.edit_admin_settings eq 'N'} class="hid" {/if}><label>Can Force Logout :</label><select id="force_logout" name="force_logout" class="select yesno">{html_options values=$ANSWERS  output=$ANSWERS_STR selected=$admin.force_logout  }</select></p>
	<p {if $current_admin.edit_admin_settings eq 'N'} class="hid" {/if}><label>Notified in Staff Invoices Notes :</label><select id="notify_invoice_notes" name="notify_invoice_notes" class="select yesno">{html_options values=$ANSWERS  output=$ANSWERS_STR selected=$admin.notify_invoice_notes  }</select></p>
	<p {if $current_admin.edit_admin_settings eq 'N'} class="hid" {/if}><label>Notified in Staff Timesheet Notes :</label><select id="notify_timesheet_notes" name="notify_timesheet_notes" class="select yesno">{html_options values=$ANSWERS  output=$ANSWERS_STR selected=$admin.notify_timesheet_notes  }</select></p>
	
	<p {if $current_admin.edit_admin_settings eq 'N'} class="hid" {/if}><label>CSRO :</label><select id="csro" name="csro" class="select yesno">{html_options values=$ANSWERS  output=$ANSWERS_STR selected=$admin.csro  }</select></p>
	<p {if $current_admin.edit_admin_settings eq 'N'} class="hid" {/if}><label>Hiring Coordinator :</label><select id="hiring_coordinator" name="hiring_coordinator" class="select yesno">{html_options values=$ANSWERS  output=$ANSWERS_STR selected=$admin.hiring_coordinator  }</select></p>
   	<p {if $current_admin.edit_admin_settings eq 'N'} class="hid" {/if}><label>View Sceen shots :</label><select id="view_screen_shots" name="view_screen_shots" class="select yesno">{html_options values=$ANSWERS  output=$ANSWERS_STR selected=$admin.view_screen_shots  }</select></p>
	<p {if $current_admin.edit_admin_settings eq 'N'} class="hid" {/if}><label>View Camera shots :</label><select id="view_camera_shots" name="view_camera_shots" class="select yesno">{html_options values=$ANSWERS  output=$ANSWERS_STR selected=$admin.view_camera_shots  }</select></p>
	<p {if $current_admin.edit_admin_settings eq 'N'} class="hid" {/if}><label>View Other Admins' Calendar :</label><select id="view_admin_calendar" name="view_admin_calendar" class="select yesno">{html_options values=$ANSWERS  output=$ANSWERS_STR selected=$admin.view_admin_calendar  }</select></p>
	
	<p {if $current_admin.edit_admin_settings eq 'N'} class="hid" {/if}><label>View RSSC Dashboard :</label><select id="view_rssc_dashboard" name="view_rssc_dashboard" class="select yesno">{html_options values=$ANSWERS  output=$ANSWERS_STR selected=$admin.view_rssc_dashboard  }</select></p>
	<p {if $current_admin.edit_admin_settings eq 'N'} class="hid" {/if}><label>Edit RSSC Settings :</label><select id="edit_rssc_settings" name="edit_rssc_settings" class="select yesno">{html_options values=$ANSWERS  output=$ANSWERS_STR selected=$admin.edit_rssc_settings  }</select></p>
	<p {if $current_admin.edit_admin_settings eq 'N'} class="hid" {/if}><label>Manage Staff Invoice :</label><select id="manage_staff_invoice" name="manage_staff_invoice" class="select yesno">{html_options values=$ANSWERS  output=$ANSWERS_STR selected=$admin.manage_staff_invoice  }</select></p>

    
    
    <p {if not $view_inhouse_confidential_access} class="hid" {/if} ><label>View Inhouse Confidential Info :</label><select id="view_inhouse_confidential" name="view_inhouse_confidential" class="select yesno" >{html_options values=$ANSWERS  output=$ANSWERS_STR selected=$admin.view_inhouse_confidential  }</select></p>
    <p {if not $view_inhouse_confidential_access} class="hid" {/if} ><label>Edit Admin Settings : </label><select id="edit_admin_settings" name="edit_admin_settings" class="select yesno">{html_options values=$ANSWERS  output=$ANSWERS_STR selected=$admin.edit_admin_settings  }</select></p>
    
    
    
    <hr />
    <p align="center"><strong style="color:#F00;">Signature Template</strong><br />
(<em>This will reflect in every email that you sent in the system Admin Section only.</em>)
</p>
	<p >Notes :</p>
    <p align="center"><textarea name="signature_notes" id="signature_notes" class="select" style="width:450px; text-align:left;">{$admin.signature_notes}</textarea></p>
	<p>Company :</p>
    <p align="center"><input type="text" class="select" id="signature_company" name="signature_company" style="width:450px;" value="{$admin.signature_company}"></p>
	<p>Websites :</p>
    <p align="center"><input type="text" class="select" id="signature_websites" name="signature_websites" style="width:450px;" value="{$admin.signature_websites}"></p>
	<p>Contact No/s : </p>
    <p align="center"><textarea name="signature_contact_nos" id="signature_contact_nos" class="select" style="height:80px; width:450px;">{$admin.signature_contact_nos}</textarea></p>
	<p>
		<input type="button" class="bttn" value="{$mode}" id="addupdate_bttn" />
		<input type="button" class="bttn" value="close" onclick="fade('div_add_update_form'); OnLoadAdminList();" />
		<span id="addupdate_status" style="margin-left:10px;"></span>
	</p>

   
   {if $admin.histories}
   <hr />
   <p align="center"><strong style="color:#F00;">HISTORY</strong></p>
       <ol>
       {foreach from=$admin.histories name=history item=history}
           <li class="history" onclick="toggle('h_{$history.history_id}')">{$history.admin_name} - [<em>{$history.date_changes|date_format:"%B %e, %Y %I:%M:%S %p"}</em>]</li>
           <ul class="history_details" id="h_{$history.history_id}" >
              {foreach from=$history.changes name=changes item=changes}
                  <li>{$changes}</li>
              {/foreach}
           </ul>
       {/foreach}
       </ol> 
   {/if} 

</div>