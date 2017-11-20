
<input type="hidden" id="admin_id" value="{$admin_id}" />
<div id="password_form"></div>
<div id="div_add_update_form">
	<div class="name_profile_hdr">Admin {$admin_fname} {$admin_lname} Profile</div>
	<div style="padding:5px;">
	<p><label>First Name : </label><input type="text" class="select" id="admin_fname" name="admin_fname" value="{$admin_fname}"></p>
	<p><label>Last Name : </label><input type="text" class="select" id="admin_lname" name="admin_lname" value="{$admin_lname}"></p>
	<p><label>Selected Timezone : </label>
        <select name="timezone_id" id="timezone_id">
            {foreach from=$timezone_lookup item=k}
                {if $k.timezone eq $admin_tz}
                    <option value="{$k.id}" selected="selected">{$k.timezone}</option>
                {else}
                    <option value="{$k.id}">{$k.timezone}</option>
                {/if}
            {/foreach}
        </select>
    </p>
	<p><b style="color:#FF0000;">Login Details</b></p>
	<p><label>Email : </label><input type="text" class="select" id="admin_email" name="admin_email" value="{$admin_email}"></p>
	<hr />
	<p><b>Signature Template</b> (<i>This will reflect in every email that you sent in the system Admin Section only.</i>)</p>
	<p><label>Notes :</label><textarea name="signature_notes" id="signature_notes" class="select" style="width:450px;">{$signature_notes}</textarea></p>
	<p><label>Company :</label><input type="text" class="select" id="signature_company" name="signature_company" style="width:350px;" value="{$signature_company}"></p>
	<p><label>Websites :</label><input type="text" class="select" id="signature_websites" name="signature_websites" style="width:450px;" value="{$signature_websites}"></p>
	<p><label>Contact No/s : </label><textarea name="signature_contact_nos" id="signature_contact_nos" class="select" style="height:80px; width:450px;">{$signature_contact_nos}</textarea></p>
	<p>
		<input type="button" class="bttn" value="Update" id="update_bttn" />
		<input type="button" class="bttn" value="Reset Password" id="reset_pass_bttn" />
		<span id="addupdate_status" style="margin-left:10px;"></span>
	</p>
	</p>
</div>

