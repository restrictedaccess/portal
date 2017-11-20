{* 2010-03-12 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   Generate a random password for admin
*}
<div id="div_add_update_form">
<input type="hidden" id="admin_id" value="{$admin_id}" />
<input type="hidden" id="admin_name" value="{$admin_fname} {$admin_lname}" />
<input type="hidden" id="admin_email" value="{$admin_email}" />
	<div style="padding:5px;">
	<b>PASSWORD RESET</b>
	<p><b>{$admin_fname} {$admin_lname}</b> - [ {$admin_email} ]</p>
	<p><b style="color:#FF0000;">Login Details</b></p>
	<p><label>New Password : </label><input readonly="readonly" class="select" id="admin_password" name="admin_password" value="{$admin_password}"></p>
	<p>Admin passwords may also be reset and retrieved from our login page.</p>
	<p>
		<input type="button" class="bttn" value="change" id="change_pass_bttn" />
		<input type="button" class="bttn" value="cancel" onclick="fade('div_add_update_form'); OnLoadAdminList();" />
		<span id="addupdate_status" style="margin-left:10px;"></span>
	</p>
	
</div>

