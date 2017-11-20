// JavaScript Document

function RemoveAdmin(e){
	var admin_id = $('admin_id').value;
	if(confirm("Delete this Admin?")){		
		$('update_admin').disabled=true;
		$('reset_admin_password').disabled=true;
		$('remove_admin').disabled=true;
		$('back_btn').disabled=true;
		$('remove_admin').value='deleting...';
	    location.href="/portal/admin_users/DeleteAdminUsers.php?admin_id="+admin_id;
	}	
}
function OnSuccessRemoveAdmin(e){
	alert(e.responseText);
}
function OnFailRemoveAdmin(e){
	alert("Failed to delete admin");
}
function ResetAdminPassword(e){
	var admin_id = $('admin_id').value;
	var admin_password = $('admin_password').value;
	var query = queryString({'admin_id': admin_id, 'admin_password' : admin_password});
    $('reset_password').value = "resetting..";
	$('reset_password').disabled = true;	
	var result = doXHR(PATH + 'rsadmin/ResetAdminPassword/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessResetAdminPassword, OnFailResetAdminPassword);
}

function OnSuccessResetAdminPassword(e){
	if(isNaN(e.responseText)){
	    alert(e.responseText);
	}else{
		alert("Password successfully reset. An email notification was sent.");
		location.href=PATH + "rsadmin/profile/"+e.responseText;
	}
	$('reset_password').value = "Reset Password";
	$('reset_password').disabled = false;
}

function OnFailResetAdminPassword(e){
	alert("Failed to reset password");
	$('reset_password').value = "Reset Password";
	$('reset_password').disabled = false;
}

function Search(e){
	var search = $('search').value;
    var status = $('status').value;	
	var query = queryString({'search' : search, 'status': status});
	//alert(query);
    var result = doXHR(PATH + 'rsadmin/Search/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSearch, OnFailSearch);
}
function OnSuccessSearch(e){
    $('admin_list').innerHTML = e.responseText;
}
function OnFailSearch(e){
	alert("Failed to search");
}
function UpdateAdminUser(e){
    var admin_id = $('admin_id').value;
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
	var view_staff_contract = $('view_staff_contract').value;
	
	var userid = $('userid').value;
	var update_client_invoice = $('update_client_invoice').value;
	var update_client_running_balance =$('update_client_running_balance').value;
	var export_staff_list = $('export_staff_list').value;
	var export_subconlist_reporting = $('export_subconlist_reporting').value;
	
	var update_prepaid_settings = $('update_prepaid_settings').value;
	var delete_staff_contracts = $('delete_staff_contracts').value;
	var activate_suspended_staff_contracts = $('activate_suspended_staff_contracts').value;
	var activate_inactive_staff_contracts = $('activate_inactive_staff_contracts').value;
	
	var rssc_dashboard_alerts = $('rssc_dashboard_alerts').value;
	
	var extension_number = $('extension_number').value;
	var local_number = $('local_number').value;
	var skype_id = $('skype_id').value;
	var work_schedule = $('work_schedule').value;
	
	var recruiter_type = $('recruiter_type').value;
	var view_workflow_task = $('view_workflow_task').value;
	var view_revenue = $('view_revenue').value;
	var timesheet_update_hrs_charged_to_client =  $('timesheet_update_hrs_charged_to_client').value;
	var lock_unlock_timesheet = $('lock_unlock_timesheet').value;
	var assign_recruiters = $('assign_recruiters').value;
	var update_platform = $('update_platform').value;
	var view_rssc_dashboard_inhouse = $('view_rssc_dashboard_inhouse').value;
	
	var facebook = $('facebook').value;
	var linked_in = $('linked_in').value;
	var tweeter = $('tweeter').value;
	
	var view_subcon_latest_updates = $('view_subcon_latest_updates').value;
	var view_statement_of_accounts = $('view_statement_of_accounts').value;
	
	var recruitment_support = $('recruitment_support').value;
	var prepaid_mass_gen = $('prepaid_mass_gen').value;
	var view_staff_daily_attendance = $('view_staff_daily_attendance').value;
	
	var currency_adjustment = $('currency_adjustment').value;
	
    if(admin_id == ""){
		alert("Admin ID is missing.");
		return false;
	}
	
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
	
	if(status == ""){
		alert("Please select Admin Restriction");
		return false;
	}
	
		
	var query = queryString({'admin_id' : admin_id, 'admin_fname': admin_fname, 'admin_lname': admin_lname, 'admin_email': (admin_email+domain) , 'status': status, 'adjust_time_sheet': adjust_time_sheet , 'force_logout': force_logout, 'notify_invoice_notes': notify_invoice_notes , 'notify_timesheet_notes' : notify_timesheet_notes , 'signature_notes': signature_notes , 'signature_company': signature_company, 'signature_websites': signature_websites, 'signature_contact_nos' : signature_contact_nos , 'csro' : csro, 'view_screen_shots' : view_screen_shots, 'view_camera_shots' : view_camera_shots, 'view_admin_calendar':view_admin_calendar, 'view_rssc_dashboard' : view_rssc_dashboard, 'edit_rssc_settings' : edit_rssc_settings, 'manage_staff_invoice' : manage_staff_invoice, 'hiring_coordinator' : hiring_coordinator, 'manage_recruiters' : manage_recruiters, 'view_inhouse_confidential' : view_inhouse_confidential, 'edit_admin_settings' : edit_admin_settings, 'userid' : userid, 'view_staff_contract' : view_staff_contract, 'update_client_invoice' : update_client_invoice, 'update_client_running_balance' : update_client_running_balance, 'export_staff_list' : export_staff_list, 'export_subconlist_reporting' : export_subconlist_reporting, 'update_prepaid_settings' : update_prepaid_settings, 'delete_staff_contracts' : delete_staff_contracts, 'activate_suspended_staff_contracts' : activate_suspended_staff_contracts, 'activate_inactive_staff_contracts' : activate_inactive_staff_contracts, 'rssc_dashboard_alerts' : rssc_dashboard_alerts, 'extension_number' : extension_number, 'local_number' : local_number, 'skype_id' : skype_id, 'work_schedule' : work_schedule, 'recruiter_type' : recruiter_type, 'view_workflow_task' : view_workflow_task, 'view_revenue' : view_revenue, 'timesheet_update_hrs_charged_to_client' : timesheet_update_hrs_charged_to_client, 'lock_unlock_timesheet' : lock_unlock_timesheet, 'assign_recruiters' : assign_recruiters, 'update_platform' : update_platform, 'view_rssc_dashboard_inhouse' : view_rssc_dashboard_inhouse, 'facebook' : facebook, 'linked_in' : linked_in, 'tweeter' : tweeter, 'view_subcon_latest_updates' : view_subcon_latest_updates, 'view_statement_of_accounts' : view_statement_of_accounts, 'recruitment_support' : recruitment_support, 'prepaid_mass_gen' : prepaid_mass_gen, 'view_staff_daily_attendance' : view_staff_daily_attendance, 'currency_adjustment' : currency_adjustment  });
	//alert(query);
	$('update_admin').value = "updating...";
	$('update_admin').disabled = true;
    var result = doXHR(PATH + 'rsadmin/UpdateAdminUser/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateAdminUser, OnFailUpdateAdminUser);
}
function OnSuccessUpdateAdminUser(e){
	if(isNaN(e.responseText)){
	    alert(e.responseText);
	}else{
		alert("Updated Successfully");
		location.href=PATH + "rsadmin/profile/"+e.responseText;
	}
	$('update_admin').value = "Save Details";
	$('update_admin').disabled = false;
}
function OnFailUpdateAdminUser(e){
	alert("Failed to update");
	$('update_admin').value = "Save Details";
	$('update_admin').disabled = false;
}

function AddNewAdminUser(e){

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
	var view_staff_contract = $('view_staff_contract').value;
	
	var userid = $('userid').value;
	var update_client_invoice = $('update_client_invoice').value;
	var update_client_running_balance =$('update_client_running_balance').value;
	var export_staff_list = $('export_staff_list').value;
	var export_subconlist_reporting = $('export_subconlist_reporting').value;
	
	var update_prepaid_settings = $('update_prepaid_settings').value;
	var delete_staff_contracts = $('delete_staff_contracts').value;
	var activate_suspended_staff_contracts = $('activate_suspended_staff_contracts').value;
	var activate_inactive_staff_contracts = $('activate_inactive_staff_contracts').value;
	
	var rssc_dashboard_alerts = $('rssc_dashboard_alerts').value;
	
	
	var extension_number = $('extension_number').value;
	var local_number = $('local_number').value;
	var skype_id = $('skype_id').value;
	var work_schedule = $('work_schedule').value;
	
	var recruiter_type = $('recruiter_type').value;
	var view_workflow_task = $('view_workflow_task').value;
	var view_revenue = $('view_revenue').value;
	var timesheet_update_hrs_charged_to_client =  $('timesheet_update_hrs_charged_to_client').value;
	var lock_unlock_timesheet = $('lock_unlock_timesheet').value;
	var assign_recruiters = $('assign_recruiters').value;
	var update_platform = $('update_platform').value;
	var view_rssc_dashboard_inhouse = $('view_rssc_dashboard_inhouse').value;
	
	var facebook = $('facebook').value;
	var linked_in = $('linked_in').value;
	var tweeter = $('tweeter').value;
	
	var view_subcon_latest_updates = $('view_subcon_latest_updates').value;
	var view_statement_of_accounts = $('view_statement_of_accounts').value;
	
	var recruitment_support = $('view_statement_of_accounts').value;
	var prepaid_mass_gen = $('prepaid_mass_gen').value;
	var view_staff_daily_attendance = $('view_staff_daily_attendance').value;
	
	var currency_adjustment = $('currency_adjustment').value;
	
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
	
	if(status == ""){
		alert("Please select Admin Restriction");
		return false;
	}
	
	
	
	var query = queryString({'admin_fname': admin_fname, 'admin_lname': admin_lname, 'admin_email': (admin_email+domain) ,  'status': status, 'adjust_time_sheet': adjust_time_sheet , 'force_logout': force_logout, 'notify_invoice_notes': notify_invoice_notes , 'notify_timesheet_notes' : notify_timesheet_notes , 'signature_notes': signature_notes , 'signature_company': signature_company, 'signature_websites': signature_websites, 'signature_contact_nos' : signature_contact_nos , 'csro' : csro, 'view_screen_shots' : view_screen_shots, 'view_camera_shots' : view_camera_shots, 'view_admin_calendar':view_admin_calendar, 'view_rssc_dashboard' : view_rssc_dashboard, 'edit_rssc_settings' : edit_rssc_settings, 'manage_staff_invoice' : manage_staff_invoice, 'hiring_coordinator' : hiring_coordinator, 'manage_recruiters' : manage_recruiters, 'view_inhouse_confidential' : view_inhouse_confidential, 'edit_admin_settings' : edit_admin_settings, 'userid' : userid, 'view_staff_contract' : view_staff_contract, 'update_client_invoice' : update_client_invoice, 'update_client_running_balance' : update_client_running_balance, 'export_staff_list' : export_staff_list, 'export_subconlist_reporting' : export_subconlist_reporting, 'update_prepaid_settings' : update_prepaid_settings, 'delete_staff_contracts' : delete_staff_contracts, 'activate_suspended_staff_contracts' : activate_suspended_staff_contracts, 'activate_inactive_staff_contracts' : activate_inactive_staff_contracts, 'rssc_dashboard_alerts' : rssc_dashboard_alerts, 'extension_number' : extension_number, 'local_number' : local_number, 'skype_id' : skype_id, 'work_schedule' : work_schedule, 'recruiter_type' : recruiter_type, 'view_workflow_task' : view_workflow_task , 'view_revenue' : view_revenue, 'timesheet_update_hrs_charged_to_client' : timesheet_update_hrs_charged_to_client, 'lock_unlock_timesheet' : lock_unlock_timesheet, 'assign_recruiters' : assign_recruiters, 'update_platform' : update_platform, 'view_rssc_dashboard_inhouse' : view_rssc_dashboard_inhouse, 'facebook' : facebook, 'linked_in' : linked_in, 'tweeter' : tweeter, 'view_subcon_latest_updates' : view_subcon_latest_updates, 'view_statement_of_accounts' : view_statement_of_accounts, 'recruitment_support' : recruitment_support, 'prepaid_mass_gen' : prepaid_mass_gen, 'view_staff_daily_attendance' : view_staff_daily_attendance, 'currency_adjustment' : currency_adjustment });
	//alert(query);return false;
	$('add_admin').value = "saving...";
	$('add_admin').disabled = true;
    var result = doXHR(PATH + 'rsadmin/AddNewAdminUser/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessAddNewAdminUser, OnFailAddNewAdminUser);
}

function OnSuccessAddNewAdminUser(e){
	if(isNaN(e.responseText)){
	    alert(e.responseText);
	}else{
		alert("New Admin Created");
		location.href=PATH + "rsadmin/profile/"+e.responseText;
	}
	$('add_admin').value = "Save Details";
	$('add_admin').disabled = false;
}

function OnFailAddNewAdminUser(e){
	alert("Failed to add new Admin User");
	$('add_admin').value = "Save Details";
	$('add_admin').disabled = false;
}

function ShowInhouseStaffDetails(e){
	var userid = $('userid').value;
	var admin_id = $('admin_id').value;
	//alert(admin_id);
	if(admin_id == ""){
		if(userid == "0"){
			$('admin_fname').disabled = true;
			$('admin_lname').disabled = true;
			$('admin_email').disabled = true;
			$('domain').disabled = true;
			$('status').disabled = true;
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
		}
	}
	if(userid != "0"){
		var query = queryString({'userid': userid});		
	    var result = doXHR(PATH + 'rsadmin/ShowInhouseStaffDetails/'+userid, {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessShowInhouseStaffDetails, OnFailShowInhouseStaffDetails);
	}else{
		$('inhouse_details').innerHTML="";
	}
}
function OnSuccessShowInhouseStaffDetails(e){
	$('inhouse_details').innerHTML=e.responseText;

    if($('admin_id').value == ""){	
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

}
function OnFailShowInhouseStaffDetails(e){
	alert("Failed to show inhouse staff details.");
}