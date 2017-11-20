// JavaScript Document

function UpdateClientManager(e){
	var manager_id = getNodeAttribute(e.src(), 'manager_id');
	var fname = $('fname').value;
	var lname = $('lname').value;
	var email = $('email').value;
	
	var selected_subcons = $('selected_subcons').value;
	
	var status = $('status').value;
	var view_staff = $('view_staff').value;
	var view_screen_shots = $('view_screen_shots').value;
	var view_camera_shots = $('view_camera_shots').value;
	var active_apps = $('active_apps').value;
	var view_timesheets = $('view_timesheets').value;
	var view_activity_notes = $('view_activity_notes').value;
	var receive_activity_notes_email = $('receive_activity_notes_email').value;
	var manage_workflow = $('manage_workflow').value;
	var manage_client_invoices = $('manage_client_invoices').value;
	var manage_leave_request = $('manage_leave_request').value;
	var post_ads = $('post_ads').value;
	
	
	
	if(fname == ""){
		alert("Please enter first name");
		$('fname').focus();
		return false;
	}
	
	if(lname == ""){
		alert("Please enter last name");
		$('lname').focus();
		return false;
	}
	
	if(email == ""){
		alert("Please enter email address");
		$('email').focus();
		return false;
	}
	
	var query = queryString({ 'manager_id' : manager_id, 'fname' : fname, 'lname' : lname, 'email' : email, 'selected_subcons' : selected_subcons, 'status' : status, 'view_staff' : view_staff, 'view_screen_shots' : view_screen_shots, 'view_camera_shots' : view_camera_shots, 'active_apps' : active_apps, 'view_timesheets' : view_timesheets, 'view_activity_notes' : view_activity_notes, 'receive_activity_notes_email' : receive_activity_notes_email, 'manage_workflow' : manage_workflow, 'manage_client_invoices' : manage_client_invoices, 'manage_leave_request' : manage_leave_request, 'post_ads' : post_ads });
	
	//alert(query);
	
	//alert(query);return false;
	if(status == 'removed'){
		if(confirm("Remove Client Manager?")){
			$('update_client_manager').disabled = true;
	        $('update_client_manager').value = "removing...";
			var result = doXHR(PATH + '/client_sub_accounts/update_manager/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	        result.addCallbacks(OnSuccessRemoveClientManager, OnFailUpdateClientManager);
		}
	}else{
		$('update_client_manager').disabled = true;
	    $('update_client_manager').value = "udpating...";
	    var result = doXHR(PATH + '/client_sub_accounts/update_manager/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessUpdateClientManager, OnFailUpdateClientManager);
	}
}

function OnSuccessRemoveClientManager(e){
	if(isNaN(e.responseText)){
	    alert(e.responseText);		
	}else{
		alert("Successfully removed");	
		location.href=PATH + '/client_sub_accounts/';
	}
	$('update_client_manager').disabled = false;
	$('update_client_manager').value = "Save Details";
}

function OnSuccessUpdateClientManager(e){
	if(isNaN(e.responseText)){
	    alert(e.responseText);		
	}else{
		alert("Successfully updated");		
	}
	$('update_client_manager').disabled = false;
	$('update_client_manager').value = "Save Details";
}
function OnFailUpdateClientManager(e){
	alert("Failed to update client manager")
}


function ShowClientStaff(e){
	var leads_id = $('leads_id').value;
	if (leads_id!=""){
		$('selected_box').innerHTML = "";
	    var result = doSimpleXMLHttpRequest(PATH + '/client_sub_accounts/ShowClientStaff/'+leads_id);
	    result.addCallbacks(OnSuccessShowClientStaff, OnFailShowClientStaff);
	}else{
		$('staff_list').innerHTML = "Please select a client";
		$('selected_subcons').value = "";
		$('selected_box').innerHTML = "";
		
	}
}
function OnSuccessShowClientStaff(e){
	$('staff_list').innerHTML = e.responseText;
}
function OnFailShowClientStaff(e){
	$('staff_list').innerHTML = 'Loading...';
}

function showStaff(e){
	var view_staff = $('view_staff').value;
	if(view_staff == 'specific'){
        $('show_staff_btn').style.visibility = "visible";
		appear('selected_box');
	}else{
		$('show_staff_btn').style.visibility = "hidden";
		$('staff_box').style.visibility = "hidden";
		$('show_staff_btn').value = "show";
		fade('selected_box');
	}
}

function showStaffBox(e){
	//alert('hello');
	var element = $('staff_box');
	element.style.visibility = (element.style.visibility == "hidden") ? "visible" : "hidden";
	
	var btn =  $('show_staff_btn');
	btn.value = (btn.value == "show") ? "hide" : "show";
}


function SelectSubcon()
{
	var ins = document.getElementsByName('staff')
	var i;
	var j=0;
	var vals = new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			vals[j]=ins[i].value;
			j++;
			
		}
	}
	
	$('selected_subcons').value = vals;
	//show the selected subcons info
	ShowSelectedSubcons();
}


function ShowSelectedSubcons(){
	var selected_subcons = $('selected_subcons').value;
	if(selected_subcons !=""){
	    appear('selected_box');
	    var query = queryString({ 'selected_subcons' : selected_subcons});
	    var result = doXHR(PATH + '/client_sub_accounts/ShowSelectedSubcons/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessShowSelectedSubcons, OnFailShowSelectedSubcons);
	}else{
		$('selected_box').innerHTML = "";
		fade('selected_box');
	}
}

function OnSuccessShowSelectedSubcons(e){
	$('selected_box').innerHTML = e.responseText;	
}
function OnFailShowSelectedSubcons(e){
	$('selected_box').innerHTML = "Loading...";
}

function AddClientManager(e){
	var leads_id = $('leads_id').value;
	var fname = $('fname').value;
	var lname = $('lname').value;
	var email = $('email').value;
	
	var selected_subcons = $('selected_subcons').value;
	
	var status = $('status').value;
	var view_staff = $('view_staff').value;
	var view_screen_shots = $('view_screen_shots').value;
	var view_camera_shots = $('view_camera_shots').value;
	var active_apps = $('active_apps').value;
	var view_timesheets = $('view_timesheets').value;
	var view_activity_notes = $('view_activity_notes').value;
	var receive_activity_notes_email = $('receive_activity_notes_email').value;
	var manage_workflow = $('manage_workflow').value;
	var manage_client_invoices = $('manage_client_invoices').value;
	var manage_leave_request = $('manage_leave_request').value;
	var post_ads = $('post_ads').value;
	
	
	if(leads_id ==""){
		alert("Please select a client.");
		$('leads_id').focus();
		return false;
	}
	if(fname == ""){
		alert("Please enter first name");
		$('fname').focus();
		return false;
	}
	
	if(lname == ""){
		alert("Please enter last name");
		$('lname').focus();
		return false;
	}
	
	if(email == ""){
		alert("Please enter email address");
		$('email').focus();
		return false;
	}
	
	var query = queryString({ 'leads_id' : leads_id, 'fname' : fname, 'lname' : lname, 'email' : email, 'selected_subcons' : selected_subcons, 'status' : status, 'view_staff' : view_staff, 'view_screen_shots' : view_screen_shots, 'view_camera_shots' : view_camera_shots, 'active_apps' : active_apps, 'view_timesheets' : view_timesheets, 'view_activity_notes' : view_activity_notes, 'receive_activity_notes_email' : receive_activity_notes_email, 'manage_workflow' : manage_workflow, 'manage_client_invoices' : manage_client_invoices, 'manage_leave_request' : manage_leave_request, 'post_ads' : post_ads });
	$('create_client_manager').disabled = true;
	$('create_client_manager').value = "adding...";
	//alert(query);return false;
	var result = doXHR(PATH + '/client_sub_accounts/AddClientManager/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessAddClientManager, OnFailAddClientManager);
}

function OnSuccessAddClientManager(e){
	if(isNaN(e.responseText)){
	    alert(e.responseText);		
	}else{
		alert("Successfully Added");
        location.href= PATH + "/client_sub_accounts/manager/"+e.responseText;		
	}
	$('create_client_manager').disabled = false;
	$('create_client_manager').value = "Save Details";
	
}
function OnFailAddClientManager(e){
	alert("Failed to add new Client sub accounts");
}