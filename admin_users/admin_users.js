/*
2011-01-06    Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
- Added timezone
2010-03-12 Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
- generate random string for password reset, removed the comparison of password confirm field
2009-11-13 Normaneil Macutay <normanm@remotestaff.com.au>
- included the admin notify_timesheet_notes in the code

2009-10-01 Normaneil Macutay
	- this script use for add , edit , delete Admin Users
*/
var PATH = 'admin_users/';
//connect(window, "onload", OnLoadAdminList);

function ShowInhouseDetails(e){
	var userid = $('userid').value;
	if($('mode').value == 'add'){
		if(userid == ''){
			$('admin_fname').disabled = true;
	        $('admin_lname').disabled = true;
	        $('admin_email').disabled = true;
	        $('domain').disabled = true;
	        $('status').disabled = true;
	        $('addupdate_bttn').disabled = true;
			$('admin_fname').value = "";
	        $('admin_lname').value = "";
	        $('admin_email').value = "";
			$('inhouse_details').innerHTML="";
		}else{
			$('admin_fname').disabled = false;
	        $('admin_lname').disabled = false;
	        $('admin_email').disabled = false;
	        $('domain').disabled = false;
	        $('status').disabled = false;
	        $('addupdate_bttn').disabled = false;
		}
	}
	if(userid != ""){
		var query = queryString({'userid': userid});
	    var result = doXHR(PATH + 'ShowInhouseDetails.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessShowInhouseDetails, OnFailShowInhouseDetails);
	}
}

function OnSuccessShowInhouseDetails(e){
	$('inhouse_details').innerHTML=e.responseText;
	if($('mode').value == 'add'){
		var fname = getNodeAttribute($('personal'), 'fname');
		var lname = getNodeAttribute($('personal'), 'lname');
		$('admin_fname').value = fname;
		$('admin_lname').value = lname;
	}
	$('admin_fname').disabled = false;
	$('admin_lname').disabled = false;
	$('admin_email').disabled = false;
	$('domain').disabled = false;
	$('status').disabled = false;
	$('addupdate_bttn').disabled = false;
}
function OnFailShowInhouseDetails(e){
	alert("Failed to show inhouse staff details.");
}

function ShowHeadRecruiters(e){
	var status = $('status').value;
	var manage_recruiters = $('manage_recruiters').value;
	var admin_id = $('admin_id').value;
	
	$('manage_recruiters').disabled = false;
	//$('head_recruiter_id').disabled = true;
	//$('head_recruiter_id').value = '';
	if(status != 'FULL-CONTROL'){
		$('manage_recruiters').disabled = true;
		$('manage_recruiters').value = 'N';
		//fade('assigned_recruiters');
	}
	
	if(status == 'HR'){
		//$('manage_recruiters').value = 'N';
		//$('head_recruiter_id').disabled = false;
		
	}
	
	if(status != 'HR'){
		//$('head_recruiter_id').value = '';
	}
	
	if(status == 'FULL-CONTROL' && manage_recruiters != 'Y'){
		//fade('assigned_recruiters');
	}
	
	if(status == 'FULL-CONTROL' && manage_recruiters == 'Y'){
		//$('manage_recruiters').disabled = false;
		//appear('assigned_recruiters');
	}
	
	
}

function showResetPasswordForm(admin_id){
	//alert(admin_id)	;
	$('admin_users_list').style.display="block";
	$('admin_users_list').innerHTML ="Loading";
	var result = doSimpleXMLHttpRequest(PATH + 'showResetPasswordForm.php', {'admin_id': admin_id });
    result.addCallbacks(OnSuccessShowResetPasswordForm, OnFailOnLoadShowResetPasswordForm);

}
function OnSuccessShowResetPasswordForm(e){
	$('admin_users_list').innerHTML = e.responseText;
	connect('change_pass_bttn', 'onclick', OnClickResetAdminPassword);
}
function OnClickResetAdminPassword(){
	var admin_id = 	$('admin_id').value ;
	
	var admin_password = $('admin_password').value;
	
	var admin_name = $('admin_name').value;
	var admin_email = $('admin_email').value;
	
	if(admin_password==""){
		alert("Please enter new Password");
		return false;
	}
	
	$('addupdate_status').innerHTML = "<i><img src=\"images/ajax-loader.gif\" />Updating password....</i>";
	$('change_pass_bttn').disabled = true;
	//alert(admin_id);
	
	var query = queryString({'admin_id': admin_id, 'admin_password' :admin_password, 'admin_name' : admin_name , 'admin_email' : admin_email});
	var result = doXHR(PATH + 'updateAdminUsersPassword.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateAdminUsersPassword, OnFailUpdateAdminUsersPassword);
	
}
function OnSuccessUpdateAdminUsersPassword(e){
	//$('admin_users_list').innerHTML = e.responseText;
	alert(e.responseText);
	OnLoadAdminList();
}

function OnFailUpdateAdminUsersPassword(e){
	alert('Failed to reset Admin Password .\n Please reload the page and try again later.');
}

function OnFailOnLoadShowResetPasswordForm(e){
	alert('Failed to fetch Admin Reset Password Form .\n Please reload the page and try again later.');
}

function OnLoadAdminList(e){
	$('admin_users_list').innerHTML ="Loading";
	var result = doSimpleXMLHttpRequest(PATH + 'getAllAdminUsers.php');
    result.addCallbacks(OnSuccessOnLoadAdminList, OnFailOnLoadAdminList);
}
function OnSuccessOnLoadAdminList(e){
	$('admin_users_list').innerHTML =e.responseText;
	//connect('add_admin_users', 'onclick', OnClickShowAdminAddEditUsers);
	
}
function OnFailOnLoadAdminList(e){
	alert('Failed to fetch Admin Users.\n Please reload the page and try again later.');
}

function viewAdminDetails(admin_id){
	toggle('div_view_'+admin_id);
}

function OnLoadShowAdminEditForm(){
	$('admin_users_list').style.display="block";
	$('admin_users_list').innerHTML ="<i><img src=\"images/ajax-loader.gif\" /> Loading....</i>";
	var result = doSimpleXMLHttpRequest(PATH + 'showAdminEditForm.php');
    result.addCallbacks(OnSuccessShowAdminEditForm, OnFailShowAdminEditForm);
}
function OnFailShowAdminEditForm(e){
	alert('Failed to fetch Admin Profile Form.\n Please reload the page and try again later.');
}

function OnSuccessShowAdminEditForm(e){
	$('admin_users_list').innerHTML = e.responseText;
	connect('update_bttn','onclick',OnClickUpdateAdminProfile);
	connect('reset_pass_bttn','onclick',OnClickShowAdminResetPasswordForm);
}
function OnClickShowAdminResetPasswordForm(e){
	var result = doSimpleXMLHttpRequest(PATH + 'showAdminResetPasswordForm.php');
    result.addCallbacks(OnSuccessShowAdminResetPasswordForm, OnFailOnLoadShowAdminResetPasswordForm);
}
function OnSuccessShowAdminResetPasswordForm(e){
	$('password_form').style.display="block";
	$('password_form').innerHTML ="Loading";
	$('password_form').innerHTML =e.responseText;
	connect('change_password_bttn', 'onclick', OnClickResetAdminUserPassword);
}
function OnClickResetAdminUserPassword(){

	var old_password = $('old_password').value;
	var admin_password = $('admin_password').value;
	var admin_password2 = $('admin_password2').value;

	if(old_password==""){
		alert("Please enter old Password");
		return false;
	}
	
	if(admin_password==""){
		alert("Please enter new Password");
		return false;
	}
	if(admin_password!=admin_password2){
		alert("Password is seems incorrect!");	
		return false;
	}
	
	$('addupdate_status').innerHTML = "<i><img src=\"images/ajax-loader.gif\" /> Changing password....</i>";
	$('change_password_bttn').disabled = true;

	
	var query = queryString({'old_password': old_password, 'new_password' :admin_password});
	var result = doXHR(PATH + 'updateAdminPassword.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateAdminPassword, OnFailUpdateAdminPassword);
}
function OnSuccessUpdateAdminPassword(e){
	//$('password_form').innerHTML =
	var response = e.responseText;
	if(response == "error"){
		alert("Old password is seems incorrect");
		$('addupdate_status').innerHTML = "&nbsp;";
		$('change_password_bttn').disabled = false;
		return false;
	}
	alert(response) ;
	location.href = "index.php";
}
function OnFailUpdateAdminPassword(e){
	alert('Failed to fetch Admin Update Password .\n Please reload the page and try again later.');
}

function OnFailOnLoadShowAdminResetPasswordForm(e){
	alert('Failed to fetch Admin Reset Password Form.\n Please reload the page and try again later.');
}
function OnClickUpdateAdminProfile(){
	var admin_fname = $('admin_fname').value;
	var admin_lname = $('admin_lname').value;
	var admin_email = $('admin_email').value;
	var signature_notes = $('signature_notes').value;
	var signature_company = $('signature_company').value;
	var signature_websites = $('signature_websites').value;
	var signature_contact_nos = $('signature_contact_nos').value;
    var timezone_id = $('timezone_id').value;

	if(admin_fname == ""){
		alert("First Name is required field!");
		return false;
	}
	
	if(admin_lname == ""){
		alert("Last Name is required field!");
		return false;
	}
	
	if(admin_email == ""){
		alert("Email is required field!");
		return false;
	}


	$('addupdate_status').innerHTML = "<i><img src=\"images/ajax-loader.gif\" />Processing....</i>";
	$('update_bttn').disabled = true;
	var query = queryString({'admin_fname': admin_fname, 'admin_lname': admin_lname, 'admin_email': admin_email , 'signature_notes': signature_notes , 'signature_company': signature_company, 'signature_websites': signature_websites, 'signature_contact_nos' : signature_contact_nos, 'timezone_id' : timezone_id});
	//alert(query);
    var result = doXHR(PATH + 'updateAdminUsers.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateAdminUsers, OnFailUpdateAdminUsers);


}
function OnFailUpdateAdminUsers(e){
	alert("Failed to update!");
}
function OnSuccessUpdateAdminUsers(e){
	$('update_status').innerHTML = e.responseText;
	OnLoadShowAdminEditForm();
}

function OnClickShowAdminAddEditFormUsers(admin_id , mode  ){
	//toggle('admin_users_list');
	$('admin_users_list').style.display="block";
	$('admin_users_list').innerHTML ="Loading";
	var result = doSimpleXMLHttpRequest(PATH + 'showAdminAddEditUsers.php', {'admin_id': admin_id , 'mode' : mode});
    result.addCallbacks(OnSuccessShowAdminAddUsers, OnFailOnLoadShowAdminAddUsers);
	
}

function OnSuccessShowAdminAddUsers(e){
	$('admin_users_list').innerHTML = e.responseText;
	connect('addupdate_bttn', 'onclick', OnClickAddUpdateAdminUsers);
	//connect('status', 'onchange', ShowHeadRecruiters);
	//connect('manage_recruiters', 'onchange', ShowHeadRecruiters);
	//ShowHeadRecruiters();
	if($('mode')){
		var mode = $('mode').value;
		if(mode == 'add'){
			//var items = getElementsByTagAndClassName('input', 'select');
            ///for (var item in items){
            //    $(items[item]).disabled = true;
            //}
			// By default disable these fields . Enabled it when they selected a inhouse staff.
			
			$('admin_fname').disabled = true;
			$('admin_lname').disabled = true;
			$('admin_email').disabled = true;
			$('domain').disabled = true;
			$('status').disabled = true;
			$('addupdate_bttn').disabled = true;
			
		}
		connect('userid', 'onchange', ShowInhouseDetails);
		ShowInhouseDetails();
	}
	
}
function OnFailOnLoadShowAdminAddUsers(e){
	alert('Failed to fetch Admin Admin Add Users Form.\n Please reload the page and try again later.');
}

function OnClickAddUpdateAdminUsers(e){
	var mode = 	$('mode').value ;
	var admin_id = 	$('admin_id').value ;
	var admin_fname = $('admin_fname').value;
	var admin_lname = $('admin_lname').value;
	var admin_email = $('admin_email').value;
	var domain = $('domain').value;
	
	var status = $('status').value;
	var adjust_time_sheet = $('adjust_time_sheet').value;
	var force_logout = $('force_logout').value;
	var notify_invoice_notes = $('notify_invoice_notes').value;
	var notify_timesheet_notes = $('notify_timesheet_notes').value;
	var signature_notes = $('signature_notes').value;
	var signature_company = $('signature_company').value;
	var signature_websites = $('signature_websites').value;
	var signature_contact_nos = $('signature_contact_nos').value;
	var csro = $('csro').value;
	
	var view_screen_shots = $('view_screen_shots').value;
	var view_camera_shots = $('view_camera_shots').value;
	var view_admin_calendar = $('view_admin_calendar').value;
	
	
	var view_rssc_dashboard = $('view_rssc_dashboard').value;
	var edit_rssc_settings = $('edit_rssc_settings').value;
	var manage_staff_invoice = $('manage_staff_invoice').value;
	var hiring_coordinator = $('hiring_coordinator').value;
	
	var manage_recruiters = $('manage_recruiters').value;
	var view_inhouse_confidential = $('view_inhouse_confidential').value;
	var edit_admin_settings = $('edit_admin_settings').value;
	
	var userid = $('userid').value;
	
	if(admin_fname == ""){
		alert("First Name is required field!");
		return false;
	}
	
	if(admin_lname == ""){
		alert("Last Name is required field!");
		return false;
	}
	
	if(admin_email == ""){
		alert("Email is required field!");
		return false;
	}
	
	$('addupdate_status').innerHTML = "<i><img src=\"images/ajax-loader.gif\" />Processing....</i>";
	$('addupdate_bttn').disabled = true;
	
	var query = queryString({'mode': mode, 'admin_id': admin_id, 'admin_fname': admin_fname, 'admin_lname': admin_lname, 'admin_email': admin_email , 'domain' : domain, 'status': status, 'adjust_time_sheet': adjust_time_sheet , 'force_logout': force_logout, 'notify_invoice_notes': notify_invoice_notes , 'notify_timesheet_notes' : notify_timesheet_notes , 'signature_notes': signature_notes , 'signature_company': signature_company, 'signature_websites': signature_websites, 'signature_contact_nos' : signature_contact_nos , 'csro' : csro, 'view_screen_shots' : view_screen_shots, 'view_camera_shots' : view_camera_shots, 'view_admin_calendar':view_admin_calendar, 'view_rssc_dashboard' : view_rssc_dashboard, 'edit_rssc_settings' : edit_rssc_settings, 'manage_staff_invoice' : manage_staff_invoice, 'hiring_coordinator' : hiring_coordinator, 'manage_recruiters' : manage_recruiters, 'view_inhouse_confidential' : view_inhouse_confidential, 'edit_admin_settings' : edit_admin_settings, 'userid' : userid});
	//alert(query);return false;
    var result = doXHR(PATH + 'AddUpdateAdminUsers.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessAddUpdateAdminUsers, OnFailAddUpdateAdminUsers);
}

function OnSuccessAddUpdateAdminUsers(e){
	$('admin_users_list').innerHTML = e.responseText;
	//$('debug').innerHTML = e.responseText;
	alert(e.responseText);
	OnLoadAdminList();
}

function OnFailAddUpdateAdminUsers(e){
	var mode = 	$('mode').value ;
	alert("Failed to "+mode+" Admin Users .\n Please reload the page and try again later.");
}

function OnClickDeleteAdminUsers(admin_id){
	if(confirm("Are you sure you want to delete this Admin user?")){
		var query = queryString({'admin_id': admin_id});
		var result = doXHR(PATH + 'DeleteAdminUsers.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
		result.addCallbacks(OnSuccessDeleteAdminUsers, OnFailDeleteAdminUsers);
	}	
}

function OnSuccessDeleteAdminUsers(e){
	alert(e.responseText);
	//$('admin_users_list').innerHTML = e.responseText;
	OnLoadAdminList();
}
function OnFailDeleteAdminUsers(e){
	alert("Failed to delete Admin Users .\n Please reload the page and try again later.");
}
