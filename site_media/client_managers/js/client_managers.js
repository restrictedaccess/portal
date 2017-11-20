// JavaScript Document
function UpdateManager(e){
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
	
	if(status == 'removed'){
		if(confirm("Remove Manager?")){
			$('update_manager').disabled = true;
	        $('update_manager').value = "removing...";
			var result = doXHR(PATH + '/client_managers/update_manager/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	        result.addCallbacks(OnSuccessRemoveClientManager, OnFailShowUpdateManager);
		}
	}else{
		$('update_manager').disabled = true;
	    $('update_manager').value = "udpating...";
	    var result = doXHR(PATH + '/client_managers/update_manager/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessUpdateManager, OnFailShowUpdateManager);
	}
}

function OnSuccessRemoveClientManager(e){
	if(isNaN(e.responseText)){
	    alert(e.responseText);		
	}else{
		alert("Successfully removed");	
		location.href=PATH + '/client_managers/';
	}
	$('update_manager').disabled = false;
	$('update_manager').value = "Save Details";
}

function OnSuccessUpdateManager(e){
	if(isNaN(e.responseText)){
	    $('debug').innerHTML = e.responseText;		
	}else{
		alert("Successfully updated");
        location.href=PATH + "/client_managers/manager/"+e.responseText;		
	}
	$('update_manager').disabled = false;
	$('update_manager').value = "Save Details";
}
function OnFailShowUpdateManager(e){
	alert("Failed to update manager");
	$('update_manager').disabled = false;
	$('update_manager').value = "Save Details";
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
	    var result = doXHR(PATH + '/client_managers/ShowSelectedSubcons/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
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

function add_manager(e){
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
	
	var query = queryString({ 'fname' : fname, 'lname' : lname, 'email' : email, 'selected_subcons' : selected_subcons, 'status' : status, 'view_staff' : view_staff, 'view_screen_shots' : view_screen_shots, 'view_camera_shots' : view_camera_shots, 'active_apps' : active_apps, 'view_timesheets' : view_timesheets, 'view_activity_notes' : view_activity_notes, 'receive_activity_notes_email' : receive_activity_notes_email, 'manage_workflow' : manage_workflow, 'manage_client_invoices' : manage_client_invoices, 'manage_leave_request' : manage_leave_request, 'post_ads' : post_ads });
	
	//alert(query);
	
	$('create_manager').disabled = true;
	$('create_manager').value = "creating...";
	$('cancel_btn').disabled = true;
	var result = doXHR(PATH + '/client_managers/add_manager/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessadd_manager, OnFailShowadd_manager);
	
}
function OnSuccessadd_manager(e){
	if(isNaN(e.responseText)){
	    alert(e.responseText);
		$('create_manager').disabled = false;
	    $('create_manager').value = "Save Details";
	    $('cancel_btn').disabled = false;
	}else{
		location.href=PATH + "/client_managers/create_result/"+e.responseText;
	}
}

function OnFailShowadd_manager(e){
	alert("Failed to Add new manager");
	$('create_manager').disabled = false;
	$('create_manager').value = "Save Details";
	$('cancel_btn').disabled = false;
}

function ValidateForm(){
	var fname = $('fname').value;
	var lname = $('lname').value;
	var email = $('email').value;
	
	var selected_subcons = $('selected_subcons');
	
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
	
	$('selected_subcons_str').value = selected_subcons.toString();
}