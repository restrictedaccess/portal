{*
    2010-03-12  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
    -   Added note
*}
<div style="padding:5px; background:#FCFCFC;">
	<b>PASSWORD RESET</b>
	<p><b>{$admin_fname} {$admin_lname}</b> - [ {$admin_email} ]</p>
	<p><b style="color:#FF0000;">Login Details</b></p>
	<p><label>Enter Old Password : </label><input type="password" class="select" id="old_password" name="old_password" value=""></p>
	<p><label>Enter New Password : </label><input type="password" class="select" id="admin_password" name="admin_password" value=""></p>
	<p><label>Re-type New Password : </label><input type="password" class="select" id="admin_password2" name="admin_password2" value=""></p>
    <p style="color:#FF0000"><b>Sensitive data</b> are available using your credentials! </p>
    <p style="color:#FF0000">We encourage you to have passwords with at least 8 characters combined with numbers and special characters in between.</p>
	<p>
		<input type="button" class="bttn" value="change" id="change_password_bttn" />
		<input type="button" class="bttn" value="cancel" onclick="javascript:toggle('password_form');" />
		<span id="addupdate_status" style="margin-left:10px;"></span>
	</p>
	
</div>

