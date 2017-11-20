function UpdateStaffSalary(){

	var work_status = jQuery('#work_status').val();
	var php_monthly = jQuery('#php_monthly').val();
	var scheduled_date = jQuery('#scheduled_date').val();
	var subcon_id = jQuery('#update_rates_btn').attr("subcon_id");
	
	php_monthly = php_monthly.replace(/\s+/g, '');
	
	if(php_monthly == "" || php_monthly == " "){
		alert('Please enter staff salary.');
		jQuery('#php_monthly').focus();
		return false;
	}
	
	if(isNaN(php_monthly)){
		alert('Please enter a valid amount of staff salary.');
		jQuery('#php_monthly').focus();
		return false;
	}
	
	if(scheduled_date == ""){
		alert("Please select a date.");
		return false;
	}
	if(confirm("Update staff salary?")){
		var query = {"subcon_id": subcon_id, "work_status" : work_status, "php_monthly" : php_monthly, "scheduled_date" : scheduled_date};
		//console.log(query);return false;
		jQuery('#update_rates_btn').html("scheduling...");
		jQuery('#update_rates_btn').attr('disabled', 'disabled');
		var url = CLIENT_PATH + 'UpdateStaffSalary/';
		jQuery.ajax({
			type: "POST",
			url: url,
			// The key needs to match your method's input parameter (case-sensitive).
			data: JSON.stringify({ Query: query }),
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(data){
				//console.log(data.msg);
				alert(data.msg);
				jQuery('#update_rates_btn').html('Save Changes');
				jQuery('#update_rates_btn').removeAttr('disabled', 'disabled');
			},
			error: function(data) {
				alert("There's a problem in updating staff salary.");
				jQuery('#update_rates_btn').html('Save Changes');
				jQuery('#update_rates_btn').removeAttr('disabled', 'disabled');
			}
		});
	}
}

function UpdateStaffContract(){
	var subcon_id = jQuery('#subcon_id').val();
	var fname = jQuery('#fname').val();
	var lname = jQuery('#lname').val();
	var staff_email = jQuery('#staff_email').val();
	var starting_date = jQuery('#starting_date').val();
	
	var job_designation = jQuery('#job_designation').val();
	
	var client_timezone = jQuery('#client_timezone').val();
	var staff_working_timezone = jQuery('#staff_working_timezone').val();
	var client_start_work_hour = jQuery('#client_start_work_hour').val();
	var client_finish_work_hour = jQuery('#client_finish_work_hour').val();
	
	var mon_start = jQuery('#mon_start').val();
	var mon_finish = jQuery('#mon_finish').val();
	var mon_number_hrs = jQuery('#mon_number_hrs').val();
	var mon_start_lunch = jQuery('#mon_start_lunch').val();
	var mon_finish_lunch = jQuery('#mon_finish_lunch').val();
	var mon_lunch_number_hrs = jQuery('#mon_lunch_number_hrs').val();
	
	var tue_start = jQuery('#tue_start').val();
	var tue_finish = jQuery('#tue_finish').val();
	var tue_number_hrs = jQuery('#tue_number_hrs').val();
	var tue_start_lunch = jQuery('#tue_start_lunch').val();
	var tue_finish_lunch = jQuery('#tue_finish_lunch').val();
	var tue_lunch_number_hrs = jQuery('#tue_lunch_number_hrs').val();
	
	var wed_start = jQuery('#wed_start').val();
	var wed_finish = jQuery('#wed_finish').val();
	var wed_number_hrs = jQuery('#wed_number_hrs').val();
	var wed_start_lunch = jQuery('#wed_start_lunch').val();
	var wed_finish_lunch = jQuery('#wed_finish_lunch').val();
	var wed_lunch_number_hrs = jQuery('#wed_lunch_number_hrs').val();
	
	var thu_start = jQuery('#thu_start').val();
	var thu_finish = jQuery('#thu_finish').val();
	var thu_number_hrs = jQuery('#thu_number_hrs').val();
	var thu_start_lunch = jQuery('#thu_start_lunch').val();
	var thu_finish_lunch = jQuery('#thu_finish_lunch').val();
	var thu_lunch_number_hrs = jQuery('#thu_lunch_number_hrs').val();
	
	var fri_start = jQuery('#fri_start').val();
	var fri_finish = jQuery('#fri_finish').val();
	var fri_number_hrs = jQuery('#fri_number_hrs').val();
	var fri_start_lunch = jQuery('#fri_start_lunch').val();
	var fri_finish_lunch = jQuery('#fri_finish_lunch').val();
	var fri_lunch_number_hrs = jQuery('#fri_lunch_number_hrs').val();
	
	var sat_start = jQuery('#sat_start').val();
	var sat_finish = jQuery('#sat_finish').val();
	var sat_number_hrs = jQuery('#sat_number_hrs').val();
	var sat_start_lunch = jQuery('#sat_start_lunch').val();
	var sat_finish_lunch = jQuery('#sat_finish_lunch').val();
	var sat_lunch_number_hrs = jQuery('#sat_lunch_number_hrs').val();
	
	var sun_start = jQuery('#sun_start').val();
	var sun_finish = jQuery('#sun_finish').val();
	var sun_number_hrs = jQuery('#sun_number_hrs').val();
	var sun_start_lunch = jQuery('#sun_start_lunch').val();
	var sun_finish_lunch = jQuery('#sun_finish_lunch').val();
	var sun_lunch_number_hrs = jQuery('#sun_lunch_number_hrs').val();
	
	var client_price_effective_date = starting_date;
	var working_days = jQuery('#no_of_working_days').html();
	var working_hours = jQuery('#total_working_hours').html();
	var work_days = jQuery('#work_days').val();
	
	if(fname == ""){
		alert('Please enter staff first name');
		jQuery('#fname').focus();
		return false;
	}
	if(lname == ""){
		alert('Please enter staff last name.');
		jQuery('#lname').focus();
		return false;
	}
	
	if(staff_email == ""){
		alert('Staff Email is a required field.');
		jQuery('#staff_email').focus();
		return false;
	}
	
	if(starting_date == ""){
		alert('Please select staff starting date.');
		jQuery('#starting_date').focus();
		return false;
	}
	
	if(job_designation == ""){
		alert('Job Designation is a required field.');
		jQuery('#job_designation').focus();
		return false;
	}
			
	
	if(staff_working_timezone == ""){
		alert('Please select staff timezone.');
		jQuery('#staff_working_timezone').focus();
		return false;
	}
	
	if(client_timezone == ""){
		alert('Please select client timezone.');
		jQuery('#client_timezone').focus();
		return false;
	}
	
	
	var query = {'subcon_id' : subcon_id, 'fname' : fname , 'lname' : lname, 'staff_email' : staff_email, 'starting_date' : starting_date, 'job_designation' : job_designation, 'client_timezone' : client_timezone, 'staff_working_timezone' : staff_working_timezone, 'client_start_work_hour' : client_start_work_hour, 'client_finish_work_hour' : client_finish_work_hour , 'client_price_effective_date' : client_price_effective_date, 'working_days' : working_days, 'working_hours' : working_hours, 'work_days' : work_days, 'mon_start' : mon_start , 'mon_finish' : mon_finish , 'mon_number_hrs' : mon_number_hrs , 'mon_start_lunch' : mon_start_lunch , 'mon_finish_lunch' : mon_finish_lunch , 'mon_lunch_number_hrs' : mon_lunch_number_hrs, 'tue_start' : tue_start , 'tue_finish' : tue_finish , 'tue_number_hrs' : tue_number_hrs , 'tue_start_lunch' : tue_start_lunch , 'tue_finish_lunch' : tue_finish_lunch , 'tue_lunch_number_hrs' : tue_lunch_number_hrs , 'wed_start' : wed_start , 'wed_finish' : wed_finish , 'wed_number_hrs' : wed_number_hrs , 'wed_start_lunch' : wed_start_lunch , 'wed_finish_lunch' : wed_finish_lunch , 'wed_lunch_number_hrs' : wed_lunch_number_hrs, 'thu_start' : thu_start , 'thu_finish' : thu_finish , 'thu_number_hrs' : thu_number_hrs , 'thu_start_lunch' : thu_start_lunch , 'thu_finish_lunch' : thu_finish_lunch , 'thu_lunch_number_hrs' : thu_lunch_number_hrs, 'fri_start' : fri_start , 'fri_finish' : fri_finish , 'fri_number_hrs' : fri_number_hrs , 'fri_start_lunch' : fri_start_lunch , 'fri_finish_lunch' : fri_finish_lunch , 'fri_lunch_number_hrs' : fri_lunch_number_hrs, 'sat_start' : sat_start , 'sat_finish' : sat_finish , 'sat_number_hrs' : sat_number_hrs , 'sat_start_lunch' : sat_start_lunch , 'sat_finish_lunch' : sat_finish_lunch , 'sat_lunch_number_hrs' : sat_lunch_number_hrs, 'sun_start' : sun_start , 'sun_finish' : sun_finish , 'sun_number_hrs' : sun_number_hrs , 'sun_start_lunch' : sun_start_lunch , 'sun_finish_lunch' : sun_finish_lunch , 'sun_lunch_number_hrs' : sun_lunch_number_hrs};
	
	console.log(query);
	jQuery('#update_btn').html('saving changes...');
	jQuery('#update_btn').attr("disabled", "disabled");
	var url = CLIENT_PATH + 'UpdateStaffContract';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			console.log(data);
			alert(data.msg);
			jQuery('#update_btn').html('Save Changes');
			jQuery('#update_btn').removeAttr("disabled");
			if(data.success){
				location.href=CLIENT_PATH+'staff/'+subcon_id;	
			}
			
		},
		error: function(data) {
			alert("There's a problem in updating staff cotnract.");
			jQuery('#update_btn').html('Save Changes');
			jQuery('#update_btn').removeAttr("disabled");
		}
	});	
}

function GetClientHistory(){
	var subcon_id = jQuery('#subcon_id').val();
	jQuery.get(CLIENT_PATH+"get_history/"+subcon_id, function(response){
		jQuery('#history').html(response);		
	});
}

function AddClientComment(){
	var comment_str = jQuery('#comment_str').val();
	var subcon_id = jQuery('#comment_btn').attr('subcon_id')
	var query = {"subcon_id": subcon_id, "comment_str" : comment_str};
	
	if(comment_str == ""){
		alert("Please type in your comment.");
		return false;
	}
	
	jQuery('#comment_btn').html("adding...");
	jQuery('#comment_btn').attr('disabled', 'disabled');
	var url = CLIENT_PATH + 'AddComment/';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			console.log(data.msg);
			if(data.success){
				//var output = "<li>"+data.msg+"</li>";
				//jQuery('#comments_box ol').append(output);
				GetComments();
				jQuery('#comment_str').val("");
			}else{
				alert(data.msg);
			}
			jQuery('#comment_btn').html('Add Comment');
			jQuery('#comment_btn').removeAttr('disabled', 'disabled');
		},
		error: function(data) {
			alert("There's a problem in adding comment.");
			jQuery('#comment_btn').html('Add Comment');
			jQuery('#comment_btn').removeAttr('disabled', 'disabled');
		}
	});
}
function AddClientSettings(){
	var currency = jQuery('#currency').val();
	var apply_gst = jQuery('#apply_gst').val();
	
	var query = {'currency' : currency, 'apply_gst' : apply_gst};
	
	if(confirm("Save this setting?")){
		jQuery('#add_settings_btn').html('saving...');
		jQuery('#add_settings_btn').attr("disabled", "disabled");
	 
		
		var url = CLIENT_PATH + 'AddClientSettings';
		jQuery.ajax({
			type: "POST",
			url: url,
			// The key needs to match your method's input parameter (case-sensitive).
			data: JSON.stringify({ Query: query }),
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(data){
				console.log(data);
				alert(data.msg);
				if(data.success){
					 location.href=CLIENT_PATH+'create_staff';	
				}
				jQuery('#add_settings_btn').html('Add Settings');
				jQuery('#add_settings_btn').removeAttr("disabled");
			},
			error: function(data) {
				alert("There's a problem in saving your currency setting.");
				jQuery('#add_settings_btn').html('Add Settings');
				jQuery('#add_settings_btn').removeAttr("disabled");
			}
		});
	}
}


function CheckCurrencyAndGST(){
	var currency = jQuery('#currency').val();
	var apply_gst = jQuery('#apply_gst').val();
	
	console.log(currency+' '+apply_gst);
	if(apply_gst == 'Y'){
		jQuery('#currency').val('AUD');
		jQuery('#currency').attr("disabled", "disabled");
	}else{
		jQuery('#currency').removeAttr("disabled");
	}
	//if(currency == 'AUD'){
	//	jQuery('#apply_gst').val('Y');
	//}else{
	//	jQuery('#apply_gst').val('N');
	//}
}

function ClientCreateStaffContract(){
	console.log('create new staff contract');
	var leads_id = jQuery('#leads_id').val();
	var fname = jQuery('#fname').val();
	var lname = jQuery('#lname').val();
	var staff_email = jQuery('#staff_email').val();
	var starting_date = jQuery('#starting_date').val();
	var package_id = jQuery('#package_id').val();
	var staff_type_id = jQuery('#staff_type_id').val();
	var job_designation = jQuery('#job_designation').val();
	var work_status = jQuery('#work_status').val();
	var client_timezone = jQuery('#client_timezone').val();
	var staff_working_timezone = jQuery('#staff_working_timezone').val();
	var client_start_work_hour = jQuery('#client_start_work_hour').val();
	var client_finish_work_hour = jQuery('#client_finish_work_hour').val();
	
	var staff_currency_id = jQuery('#staff_currency_id').val();
	var php_monthly = jQuery('#php_monthly').val();
    	
	var mon_start = jQuery('#mon_start').val();
	var mon_finish = jQuery('#mon_finish').val();
	var mon_number_hrs = jQuery('#mon_number_hrs').val();
	var mon_start_lunch = jQuery('#mon_start_lunch').val();
	var mon_finish_lunch = jQuery('#mon_finish_lunch').val();
	var mon_lunch_number_hrs = jQuery('#mon_lunch_number_hrs').val();
	
	var tue_start = jQuery('#tue_start').val();
	var tue_finish = jQuery('#tue_finish').val();
	var tue_number_hrs = jQuery('#tue_number_hrs').val();
	var tue_start_lunch = jQuery('#tue_start_lunch').val();
	var tue_finish_lunch = jQuery('#tue_finish_lunch').val();
	var tue_lunch_number_hrs = jQuery('#tue_lunch_number_hrs').val();
	
	var wed_start = jQuery('#wed_start').val();
	var wed_finish = jQuery('#wed_finish').val();
	var wed_number_hrs = jQuery('#wed_number_hrs').val();
	var wed_start_lunch = jQuery('#wed_start_lunch').val();
	var wed_finish_lunch = jQuery('#wed_finish_lunch').val();
	var wed_lunch_number_hrs = jQuery('#wed_lunch_number_hrs').val();
	
	var thu_start = jQuery('#thu_start').val();
	var thu_finish = jQuery('#thu_finish').val();
	var thu_number_hrs = jQuery('#thu_number_hrs').val();
	var thu_start_lunch = jQuery('#thu_start_lunch').val();
	var thu_finish_lunch = jQuery('#thu_finish_lunch').val();
	var thu_lunch_number_hrs = jQuery('#thu_lunch_number_hrs').val();
	
	var fri_start = jQuery('#fri_start').val();
	var fri_finish = jQuery('#fri_finish').val();
	var fri_number_hrs = jQuery('#fri_number_hrs').val();
	var fri_start_lunch = jQuery('#fri_start_lunch').val();
	var fri_finish_lunch = jQuery('#fri_finish_lunch').val();
	var fri_lunch_number_hrs = jQuery('#fri_lunch_number_hrs').val();
	
	var sat_start = jQuery('#sat_start').val();
	var sat_finish = jQuery('#sat_finish').val();
	var sat_number_hrs = jQuery('#sat_number_hrs').val();
	var sat_start_lunch = jQuery('#sat_start_lunch').val();
	var sat_finish_lunch = jQuery('#sat_finish_lunch').val();
	var sat_lunch_number_hrs = jQuery('#sat_lunch_number_hrs').val();
	
	var sun_start = jQuery('#sun_start').val();
	var sun_finish = jQuery('#sun_finish').val();
	var sun_number_hrs = jQuery('#sun_number_hrs').val();
	var sun_start_lunch = jQuery('#sun_start_lunch').val();
	var sun_finish_lunch = jQuery('#sun_finish_lunch').val();
	var sun_lunch_number_hrs = jQuery('#sun_lunch_number_hrs').val();
	
	var client_price_effective_date = starting_date;
	var working_days = jQuery('#no_of_working_days').html();
	var working_hours = jQuery('#total_working_hours').html();
	var work_days = jQuery('#work_days').val();
	
    php_monthly = php_monthly.replace(/\s+/g, '');	
	
	if(fname == ""){
		alert('Please enter staff first name');
		jQuery('#fname').focus();
		return false;
	}
	if(lname == ""){
		alert('Please enter staff last name.');
		jQuery('#lname').focus();
		return false;
	}
	
	if(staff_email == ""){
		alert('Staff Email is a required field.');
		jQuery('#staff_email').focus();
		return false;
	}
	
	if(starting_date == ""){
		alert('Please select staff starting date.');
		jQuery('#starting_date').focus();
		return false;
	}
	
	if(job_designation == ""){
		alert('Job Designation is a required field.');
		jQuery('#job_designation').focus();
		return false;
	}
			
	
	if(staff_working_timezone == ""){
		alert('Please select staff timezone.');
		jQuery('#staff_working_timezone').focus();
		return false;
	}
	
	if(client_timezone == ""){
		alert('Please select client timezone.');
		jQuery('#client_timezone').focus();
		return false;
	}
	
	if(php_monthly == "" || php_monthly == " "){
		alert('Please enter staff salary.');
		jQuery('#php_monthly').focus();
		return false;
	}
	
	if(isNaN(php_monthly)){
		alert('Please enter a valid amount of staff salary.');
		jQuery('#php_monthly').focus();
		return false;
	}
	
	
	var query = {'leads_id' : leads_id, 'fname' : fname , 'lname' : lname, 'staff_email' : staff_email, 'starting_date' : starting_date, 'package_id' : package_id, 'staff_type_id' : staff_type_id, 'job_designation' : job_designation, 'work_status' : work_status, 'client_timezone' : client_timezone, 'staff_working_timezone' : staff_working_timezone, 'client_start_work_hour' : client_start_work_hour, 'client_finish_work_hour' : client_finish_work_hour , 'staff_currency_id' : staff_currency_id, 'php_monthly' : php_monthly, 'client_price_effective_date' : client_price_effective_date, 'working_days' : working_days, 'working_hours' : working_hours, 'work_days' : work_days, 'mon_start' : mon_start , 'mon_finish' : mon_finish , 'mon_number_hrs' : mon_number_hrs , 'mon_start_lunch' : mon_start_lunch , 'mon_finish_lunch' : mon_finish_lunch , 'mon_lunch_number_hrs' : mon_lunch_number_hrs, 'tue_start' : tue_start , 'tue_finish' : tue_finish , 'tue_number_hrs' : tue_number_hrs , 'tue_start_lunch' : tue_start_lunch , 'tue_finish_lunch' : tue_finish_lunch , 'tue_lunch_number_hrs' : tue_lunch_number_hrs , 'wed_start' : wed_start , 'wed_finish' : wed_finish , 'wed_number_hrs' : wed_number_hrs , 'wed_start_lunch' : wed_start_lunch , 'wed_finish_lunch' : wed_finish_lunch , 'wed_lunch_number_hrs' : wed_lunch_number_hrs, 'thu_start' : thu_start , 'thu_finish' : thu_finish , 'thu_number_hrs' : thu_number_hrs , 'thu_start_lunch' : thu_start_lunch , 'thu_finish_lunch' : thu_finish_lunch , 'thu_lunch_number_hrs' : thu_lunch_number_hrs, 'fri_start' : fri_start , 'fri_finish' : fri_finish , 'fri_number_hrs' : fri_number_hrs , 'fri_start_lunch' : fri_start_lunch , 'fri_finish_lunch' : fri_finish_lunch , 'fri_lunch_number_hrs' : fri_lunch_number_hrs, 'sat_start' : sat_start , 'sat_finish' : sat_finish , 'sat_number_hrs' : sat_number_hrs , 'sat_start_lunch' : sat_start_lunch , 'sat_finish_lunch' : sat_finish_lunch , 'sat_lunch_number_hrs' : sat_lunch_number_hrs, 'sun_start' : sun_start , 'sun_finish' : sun_finish , 'sun_number_hrs' : sun_number_hrs , 'sun_start_lunch' : sun_start_lunch , 'sun_finish_lunch' : sun_finish_lunch , 'sun_lunch_number_hrs' : sun_lunch_number_hrs};
	
	//console.log(query);
	//return false;
	jQuery('#create_btn').html('creating...');
	jQuery('#create_btn').attr("disabled", "disabled");
 
	
	var url = CLIENT_PATH + 'ClientCreateStaffContract/';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			var output="<a href='"+CLIENT_PATH+"' ><strong>here</strong></a>";
			if(data.success){
				jQuery('#contract_result').html(data.msg+"<br>Click "+output+" to view list.");
			}else{
				alert(data.msg);
			}
			
			jQuery('#create_btn').html('Create New Staff Contract');
			jQuery('#create_btn').removeAttr("disabled");
		},
		error: function(data) {
			alert("There's a problem in creating new staff contract.");
			jQuery('#create_btn').html('Create New Staff Contract');
			jQuery('#create_btn').removeAttr("disabled");
		}
	});
	
	
}