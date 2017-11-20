var WEEKDAYS = new Array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');
var AFF_COMM = 5;
var BP_COMM = 15;

function ScheduleUpdatedRates(){
	var client_price = jQuery('#client_price').val();
	var work_status = jQuery('#work_status').val();
	var php_monthly = jQuery('#php_monthly').val();
	var scheduled_date = jQuery('#scheduled_date').val();
	var subcon_id = jQuery('#subcon_id').val();
	
	if(scheduled_date == ""){
		alert('Please select a date.');
		return false;
	}
	if(confirm("Save changes?")){
		var query = {"subcon_id": subcon_id, "client_price" : client_price, "work_status" : work_status, "php_monthly" : php_monthly, "scheduled_date" : scheduled_date};
		console.log(query);
		jQuery('#update_rates_btn').html("scheduling...");
		jQuery('#update_rates_btn').attr('disabled', 'disabled');
		var url = PATH + 'ScheduleUpdatedRates/';
		jQuery.ajax({
			type: "POST",
			url: url,
			// The key needs to match your method's input parameter (case-sensitive).
			data: JSON.stringify({ Query: query }),
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(data){
				console.log(data.msg);
				jQuery('#windowTitleDialog').modal({ 
					backdrop: 'static',
					keyboard: false
				});
				jQuery('#contract_result').html(data.msg);
				
				if(data.success == true){
					jQuery('#ok_btn').removeClass("hide");
					jQuery('#modal_body').removeClass("alert-danger");
					jQuery('#modal_body').addClass("alert-success");
					jQuery('#close_btn').addClass("hide");
					jQuery('#ok_btn').attr("href", PATH+'staff/'+subcon_id);
				}else{
					jQuery('#modal_body').removeClass("alert-success");
					jQuery('#modal_body').addClass("alert-danger");
					jQuery('#close_btn').removeClass("hide");
					jQuery('#ok_btn').addClass("hide");
				}
				jQuery('#update_rates_btn').html('Save Changes');
				jQuery('#update_rates_btn').removeAttr('disabled', 'disabled');
			},
			error: function(data) {
				alert("There's a problem in scheduling update rates.");
				jQuery('#update_rates_btn').html('Save Changes');
				jQuery('#update_rates_btn').removeAttr('disabled', 'disabled');
			}
		});
	}
}
function AddComment(){
	var comment_str = jQuery('#comment_str').val();
	var subcon_id = jQuery('#comment_btn').attr('subcon_id')
	var query = {"subcon_id": subcon_id, "comment_str" : comment_str};
	
	if(comment_str == ""){
		alert("Please type in your comment.");
		return false;
	}
	
	jQuery('#comment_btn').html("adding...");
	jQuery('#comment_btn').attr('disabled', 'disabled');
	var url = PATH + 'AddComment/';
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
function GetHistory(){
	
	var subcon_id = jQuery('#subcon_id').val();
	var query = {"subcon_id": subcon_id};
	//jQuery.get(PATH+"get_history/"+subcon_id, function(response){
	//	jQuery('#history').html(response);		
	//});
	var url = LOCALHOST +'admin_subcon/get_history.php';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			console.log(data);
			var output = "";		
			var histories = data.histories;
			jQuery.each(histories, function(i, item){	
				output += "<li>";					
				output += '<a data-toggle="collapse" data-target="#viewdetails_'+item.id+'" class="history_link" >'+item.change_by+" - "+item.date_changes+'</a>';
				output += '<div class="history_details collapse" id="viewdetails_'+item.id+'">';
				output += '<div>Change Status : <strong><u>'+item.changes_status+'</u></strong></div>';
				
					var changes = item.changes;
					jQuery.each(changes, function(i, item){
						output += '<div>'+item+'</div>';						
					});
				output += '</div>';
				output += "</li>";
			});
			jQuery("#history ol").html(output);
		},
		error: function(data) {
			console.log("There's an error in parsing "+subcon_id+" history.")
		}
	});
	
}

function GetComments(){
	var subcon_id = jQuery('#subcon_id').val();
	jQuery.get(PATH+"get_comments/"+subcon_id, function(response){
		jQuery('#comments_box ol').html(response);		
	});
}
function CancelNewStaffContract(){
	var temp_id = jQuery('#temp_id').val();
	var admin_notes = jQuery('#admin_notes').val();
    if(confirm("Cancel New Staff Contract?")){	
		var query = {'temp_id' : temp_id , 'admin_notes' : admin_notes};
		jQuery('#cancel_new_contract_btn').html("cancelling...");
		jQuery('.action_btns').removeAttr('disabled', 'disabled');
		 var url = PATH + 'CancelNewStaffContract/';
		jQuery.ajax({
			type: "POST",
			url: url,
			// The key needs to match your method's input parameter (case-sensitive).
			data: JSON.stringify({ Query: query }),
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(data){
				jQuery('#windowTitleDialog').modal({ 
					backdrop: 'static',
					keyboard: false
				});
				jQuery('#contract_result').html(data.msg);
				
				if(data.success == true){
					jQuery('#ok_btn').removeClass("hide");
					jQuery('#modal_body').removeClass("alert-danger");
					jQuery('#modal_body').addClass("alert-success");
					jQuery('#close_btn').addClass("hide");
					
					jQuery('#ok_btn').attr("href", PATH+'temp_contracts/');
				}else{
					jQuery('#modal_body').removeClass("alert-success");
					jQuery('#modal_body').addClass("alert-danger");
					jQuery('#close_btn').removeClass("hide");
					jQuery('#ok_btn').addClass("hide");
				}
				
				jQuery('#cancel_new_contract_btn').html('Cancel Contract');
				jQuery('.action_btns').removeAttr('disabled', 'disabled');
				
			},
			error: function(data) {
				alert("There's a problem in cancelling new staff temp contract.");
				jQuery('#cancel_new_contract_btn').html('Cancel Contract');
				jQuery('.action_btns').removeAttr('disabled', 'disabled');
			}
		});
	}
}
function ApproveNewStaffContract(){
	var temp_id = jQuery('#temp_id').val();

	
	var query = {'temp_id' : temp_id };
	jQuery('#approve_new_contract_btn').html("approving...");
	jQuery('.action_btns').removeAttr('disabled', 'disabled');
	 var url = PATH + 'ApproveNewStaffContract/';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			jQuery('#windowTitleDialog').modal({ 
				backdrop: 'static',
				keyboard: false
			});
			jQuery('#contract_result').html(data.msg);
			
			if(data.success == true){
				jQuery('#ok_btn').removeClass("hide");
				jQuery('#modal_body').removeClass("alert-danger");
				jQuery('#modal_body').addClass("alert-success");
				jQuery('#close_btn').addClass("hide");
				
				jQuery('#ok_btn').attr("href", PATH+'temp_contracts/');
			}else{
				jQuery('#modal_body').removeClass("alert-success");
				jQuery('#modal_body').addClass("alert-danger");
				jQuery('#close_btn').removeClass("hide");
				jQuery('#ok_btn').addClass("hide");
			}
			
			jQuery('#approve_new_contract_btn').html('Approve Contract');
			jQuery('.action_btns').removeAttr('disabled', 'disabled');
			
		},
		error: function(data) {
			alert("There's a problem in sending message to MQ System.");
			jQuery('#approve_new_contract_btn').html('Approve Contract');
			jQuery('.action_btns').removeAttr('disabled', 'disabled');
		}
	});
	
}
function UpdateReason(){
	var subcon_id =  jQuery('#subcon_id').val();
	var reason = jQuery('#admin_notes').val();
	var reason_type =  jQuery('#reason_type').val();
    var service_type =  jQuery('#service_type').val();	
	var replacement_request =  jQuery('#replacement_request').val();
	var status =  jQuery('#status').val();
	var admin_notes = jQuery('#admin_notes').val();
	
	jQuery('#update_reason_btn').html("saving changes...");
	jQuery('#update_reason_btn').attr("disabled", "disabled");
	var query = {'subcon_id' : subcon_id , 'reason' : reason, 'reason_type' : reason_type, 'replacement_request' : replacement_request, 'service_type' : service_type, 'status' : status, 'admin_notes' : admin_notes};
	//console.log(query);return false;
	
	
    var url = PATH + 'UpdateReason/';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			jQuery('#windowTitleDialog').modal({ 
				backdrop: 'static',
				keyboard: false
			});
			jQuery('#contract_result').html(data.msg);
			
			if(data.success == true){
				jQuery('#ok_btn').removeClass("hide");
				jQuery('#modal_body').removeClass("alert-danger");
				jQuery('#modal_body').addClass("alert-success");
				jQuery('#close_btn').addClass("hide");
				
				jQuery('#ok_btn').attr("href", PATH+'staff/'+subcon_id);
			}else{
				jQuery('#modal_body').removeClass("alert-success");
				jQuery('#modal_body').addClass("alert-danger");
				jQuery('#close_btn').removeClass("hide");
				jQuery('#ok_btn').addClass("hide");
			}
			
			jQuery('#update_reason_btn').html('Save Changes');
			jQuery('.action_btns').removeAttr('disabled', 'disabled');
			
		},
		error: function(data) {
			alert("There's a problem in saving your changes.");
			jQuery('#update_reason_btn').html('Save Changes');
			jQuery('.action_btns').removeAttr('disabled', 'disabled');
		}
	});
}

function CheckContractStatus(){
	var status = jQuery('#contract_status').val();
	console.log(status);
	
	if(status != 'ACTIVE'){
		jQuery('input').attr("disabled", "disabled");
		jQuery('select').attr("disabled", "disabled");
	}
	
	if(status == 'resigned' || status == 'terminated'){
		jQuery('.cancel_contract').removeAttr("disabled", "disabled");
	}
	
	if(status == 'suspended'){
		jQuery('#comment_str').removeAttr("disabled", "disabled");
	}
}
function ReActivate(){
	var subcon_id = jQuery('#subcon_id').val();
	var query = {'subcon_id': subcon_id};
	if(confirm("Activate staff contract ?")){	
		console.log(query);
		jQuery('#reactivate_contract_btn').html("activating...");
		jQuery('.action_btns').attr('disabled', 'disabled');
		var url = PATH + 'ReActivate/';
		jQuery.ajax({
			type: "POST",
			url: url,
			// The key needs to match your method's input parameter (case-sensitive).
			data: JSON.stringify({ Query: query }),
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(data){
				jQuery('#windowTitleDialog').modal({ 
					backdrop: 'static',
					keyboard: false
				});
				jQuery('#contract_result').html(data.msg);
				
				if(data.success == true){
					jQuery('#ok_btn').removeClass("hide");
					jQuery('#modal_body').removeClass("alert-danger");
					jQuery('#modal_body').addClass("alert-success");
					jQuery('#close_btn').addClass("hide");
					
					jQuery('#ok_btn').attr("href", PATH+'staff/'+subcon_id);
				}else{
					jQuery('#modal_body').removeClass("alert-success");
					jQuery('#modal_body').addClass("alert-danger");
					jQuery('#close_btn').removeClass("hide");
					jQuery('#ok_btn').addClass("hide");
				}
				
				jQuery('#reactivate_contract_btn').html('Reactivate');
				jQuery('.action_btns').removeAttr('disabled', 'disabled');
				
			},
			error: function(data) {
				alert("There's a problem in activating suspended staff contract.");
				jQuery('#reactivate_contract_btn').html('Reactivate');
				jQuery('.action_btns').removeAttr('disabled', 'disabled');
			}
		});
	}
	
}
function GetTimeDifference(obj){
	//console.log(jQuery(obj).attr('mode'));
	var mode = jQuery(obj).attr('mode');
	var weekday = jQuery(obj).attr('weekday');
    var work_status = jQuery('#work_status').val();
	
	if(mode=='regular'){
	    var start_time = jQuery('#'+weekday+'_start').val();
	    var finish_time = jQuery('#'+weekday+'_finish').val();
		var number_hrs = jQuery('#'+weekday+'_number_hrs');
	}else{
		var start_time = jQuery('#'+weekday+'_start_lunch').val();
	    var finish_time = jQuery('#'+weekday+'_finish_lunch').val();
		var number_hrs = jQuery('#'+weekday+'_lunch_number_hrs');
	}
	var query = {'mode': mode, 'weekday' : weekday, 'start_time' : start_time, 'finish_time' : finish_time, 'work_status' : work_status};
	console.log(query);
	if(start_time && finish_time){
	    var url = PATH + 'GetTimeDifference/';
		jQuery.ajax({
			type: "POST",
			url: url,
			// The key needs to match your method's input parameter (case-sensitive).
			data: JSON.stringify({ Query: query }),
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(data){
				//jsonObject = jQuery.parseJSON(data);
			    console.log(data);
				number_hrs.val(data.time_difference);
			},
			error: function(data) {
				console.log("There's an error in calculating time difference.");			
			}
		});
	}else{
		number_hrs.val("0.00");
	}
}

function DeleteStaffContract(){
	var subcon_id = jQuery('#subcon_id').val();
	var query = {'subcon_id': subcon_id};
	if(confirm("Delete staff contract ?")){	
		console.log(query);
		
		jQuery('#delete_contract_btn').html("deleting...");
		jQuery('.action_btns').attr('disabled', 'disabled');
		var url = PATH + 'DeleteStaffContract/';
		jQuery.ajax({
			type: "POST",
			url: url,
			// The key needs to match your method's input parameter (case-sensitive).
			data: JSON.stringify({ Query: query }),
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(data){
				jQuery('#windowTitleDialog').modal({ 
					backdrop: 'static',
					keyboard: false
				});
				jQuery('#contract_result').html(data.msg);
				
				if(data.success == true){
					jQuery('#ok_btn').removeClass("hide");
					jQuery('#modal_body').removeClass("alert-danger");
					jQuery('#modal_body').addClass("alert-success");
					jQuery('#close_btn').addClass("hide");
					
					jQuery('#ok_btn').attr("href", PATH+'subcons/active');
				}else{
					jQuery('#modal_body').removeClass("alert-success");
					jQuery('#modal_body').addClass("alert-danger");
					jQuery('#close_btn').removeClass("hide");
					jQuery('#ok_btn').addClass("hide");
				}
				
				jQuery('#delete_contract_btn').html('Delete Staff Contract');
				jQuery('.action_btns').removeAttr('disabled', 'disabled');
				
			},
			error: function(data) {
				alert("There's a problem in deleting staff contract.");
				jQuery('#delete_contract_btn').html('Delete Staff Contract');
				jQuery('.action_btns').removeAttr('disabled', 'disabled');
			}
		});
	}
	
}

function ActivateSuspendedStaffContract(){
	var subcon_id = jQuery('#subcon_id').val();
	var query = {'subcon_id': subcon_id};
	if(confirm("Activate suspended staff contract ?")){	
		console.log(query);
		jQuery('#activate_suspended_contract_btn').html("activating...");
		jQuery('.action_btns').attr('disabled', 'disabled');
		var url = PATH + 'ActivateSuspendedStaffContract/';
		jQuery.ajax({
			type: "POST",
			url: url,
			// The key needs to match your method's input parameter (case-sensitive).
			data: JSON.stringify({ Query: query }),
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(data){
				jQuery('#windowTitleDialog').modal({ 
					backdrop: 'static',
					keyboard: false
				});
				jQuery('#contract_result').html(data.msg);
				
				if(data.success == true){
					jQuery('#ok_btn').removeClass("hide");
					jQuery('#modal_body').removeClass("alert-danger");
					jQuery('#modal_body').addClass("alert-success");
					jQuery('#close_btn').addClass("hide");
					
					jQuery('#ok_btn').attr("href", PATH+'staff/'+subcon_id);
				}else{
					jQuery('#modal_body').removeClass("alert-success");
					jQuery('#modal_body').addClass("alert-danger");
					jQuery('#close_btn').removeClass("hide");
					jQuery('#ok_btn').addClass("hide");
				}
				
				jQuery('#activate_suspended_contract_btn').html('Activate Suspended Contract');
				jQuery('.action_btns').removeAttr('disabled', 'disabled');
				
			},
			error: function(data) {
				alert("There's a problem in activating suspended staff contract.");
				jQuery('#activate_suspended_contract_btn').html('Activate Suspended Contract');
				jQuery('.action_btns').removeAttr('disabled', 'disabled');
			}
		});
	}
	
}
function CancelContract(e){
	var subcon_id = jQuery('#subcon_id').val();
	var status = jQuery('#status').val();
	var end_date = jQuery('#end_date').val();
	var service_type = jQuery('#service_type').val();
	var reason_type = jQuery('#reason_type').val();
	var replacement_request = jQuery('#replacement_request').val();
	var admin_notes = jQuery('#admin_notes').val();
	
	if(end_date == ""){
		alert('Please enter date of cancellation.');
		return false;
	}
	if(admin_notes == ""){
		alert('Please enter a reason in cancelling contract.');
		return false;
	}
	
	var query = {'subcon_id': subcon_id, 'status' : status, 'end_date' : end_date, 'service_type' : service_type, 'reason_type' : reason_type, 'replacement_request' : replacement_request, 'admin_notes' : admin_notes};
	console.log(query);
	
	if(confirm("Cancel contract?")){
	    jQuery('#cancel_contract_btn').html("Cancelling...");
	    jQuery('.action_btns').attr('disabled', 'disabled');
		var url = PATH + 'CancelContract/';
		jQuery.ajax({
			type: "POST",
			url: url,
			// The key needs to match your method's input parameter (case-sensitive).
			data: JSON.stringify({ Query: query }),
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(data){
				jQuery('#windowTitleDialog').modal({ 
					backdrop: 'static',
					keyboard: false
				});
				jQuery('#contract_result').html(data.msg);
				
				if(data.success == true){
					jQuery('#ok_btn').removeClass("hide");
					jQuery('#modal_body').removeClass("alert-danger");
					jQuery('#modal_body').addClass("alert-success");
					jQuery('#close_btn').addClass("hide");
					
					jQuery('#ok_btn').attr("href", PATH+'staff/'+subcon_id);
				}else{
					jQuery('#modal_body').removeClass("alert-success");
					jQuery('#modal_body').addClass("alert-danger");
					jQuery('#close_btn').removeClass("hide");
					jQuery('#ok_btn').addClass("hide");
				}
				
				jQuery('#cancel_contract_btn').html('Cancel Contract');
				jQuery('.action_btns').removeAttr('disabled', 'disabled');
				
			},
			error: function(data) {
				alert("There's a problem in updating staff contract.");
				jQuery('#cancel_contract_btn').html('Cancel Contract');
				jQuery('.action_btns').removeAttr('disabled', 'disabled');
			}
		});
		
		
	}
	
	
}
function UpdateStaffEmail(){
	var subcon_id = jQuery('#subcon_id').val();
	var staff_email = jQuery('#staff_email').val();
	var skype_id = jQuery('#skype_id').val();
	
	var query = {"subcon_id" : subcon_id, "staff_email" : staff_email, "skype_id" : skype_id};
	
	console.log(query);
}
function CancelUpdatedStaffContract(){
	var subcon_id = jQuery('#subcon_id').val();
	var temp_id = jQuery('#temp_id').val();
	
	var job_designation = jQuery('#job_designation').val();			
	var overtime = jQuery('#overtime').val();
	var overtime_monthly_limit = jQuery('#overtime_monthly_limit').val();
	var overtime_weekly_limit = jQuery('#overtime_weekly_limit').val();
	
	var starting_date = jQuery('#starting_date').val();
	var staff_working_timezone = jQuery('#staff_working_timezone').val();
	var client_timezone = jQuery('#client_timezone').val();
	var client_start_work_hour = jQuery('#client_start_work_hour').val();
	var client_finish_work_hour = jQuery('#client_finish_work_hour').val();
	var flexi = jQuery('#flexi').val();
	var service_type = jQuery('#service_type').val();
	var work_days = jQuery('#work_days').val();
	
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
		
	var with_bp_comm = jQuery('#with_bp_comm').val();
	var with_aff_comm = jQuery('#with_aff_comm').val();
	var current_rate = jQuery('#current_rate').val();
	
	var client_price_effective_date = starting_date;
	var working_days = jQuery('#no_of_working_days').html();
	var working_hours = jQuery('#total_working_hours').html();
	
	var service_agreement_id = jQuery('#service_agreement_id').val();
	var quote_details_id = jQuery('#quote_details_id').val();
	
	
	var query = {"temp_id" : temp_id, "subcon_id" : subcon_id, "job_designation" : job_designation, "overtime" : overtime, "overtime_monthly_limit" : overtime_monthly_limit, "overtime_weekly_limit" : overtime_weekly_limit, "starting_date" : starting_date, "staff_working_timezone" : staff_working_timezone, "client_timezone" : client_timezone, "client_start_work_hour" : client_start_work_hour, "client_finish_work_hour" : client_finish_work_hour, "flexi" : flexi, "service_type" : service_type, "work_days" : work_days, "with_bp_comm" : with_bp_comm, "with_aff_comm" : with_aff_comm, "current_rate" : current_rate, "working_days" : working_days, "working_hours" : working_hours, "mon_start" : mon_start , "mon_finish" : mon_finish , "mon_number_hrs" : mon_number_hrs , "mon_start_lunch" : mon_start_lunch , "mon_finish_lunch" : mon_finish_lunch , "mon_lunch_number_hrs" : mon_lunch_number_hrs, "tue_start" : tue_start , "tue_finish" : tue_finish , "tue_number_hrs" : tue_number_hrs , "tue_start_lunch" : tue_start_lunch , "tue_finish_lunch" : tue_finish_lunch , "tue_lunch_number_hrs" : tue_lunch_number_hrs , "wed_start" : wed_start , "wed_finish" : wed_finish , "wed_number_hrs" : wed_number_hrs , "wed_start_lunch" : wed_start_lunch , "wed_finish_lunch" : wed_finish_lunch , "wed_lunch_number_hrs" : wed_lunch_number_hrs, "thu_start" : thu_start , "thu_finish" : thu_finish , "thu_number_hrs" : thu_number_hrs , "thu_start_lunch" : thu_start_lunch , "thu_finish_lunch" : thu_finish_lunch , "thu_lunch_number_hrs" : thu_lunch_number_hrs, "fri_start" : fri_start , "fri_finish" : fri_finish , "fri_number_hrs" : fri_number_hrs , "fri_start_lunch" : fri_start_lunch , "fri_finish_lunch" : fri_finish_lunch , "fri_lunch_number_hrs" : fri_lunch_number_hrs, "sat_start" : sat_start , "sat_finish" : sat_finish , "sat_number_hrs" : sat_number_hrs , "sat_start_lunch" : sat_start_lunch , "sat_finish_lunch" : sat_finish_lunch , "sat_lunch_number_hrs" : sat_lunch_number_hrs, "sun_start" : sun_start , "sun_finish" : sun_finish , "sun_number_hrs" : sun_number_hrs , "sun_start_lunch" : sun_start_lunch , "sun_finish_lunch" : sun_finish_lunch , "sun_lunch_number_hrs" : sun_lunch_number_hrs, 'service_agreement_id' : service_agreement_id, 'quote_details_id' : quote_details_id};
	
	//console.log(query);
	jQuery('#cancel_modified_btn').html('cancelling changes...');
	jQuery('.action_btns').attr('disabled', 'disabled');
	var url = PATH + 'DeleteUpdatedStaffContract/';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			jQuery('#windowTitleDialog').modal({ 
				backdrop: 'static',
				keyboard: false
			});
			jQuery('#contract_result').html(data.msg);
			
			if(data.success == true){
				jQuery('#ok_btn').removeClass("hide");
				jQuery('#modal_body').removeClass("alert-danger");
				jQuery('#modal_body').addClass("alert-success");
				jQuery('#close_btn').addClass("hide");
				
				jQuery('#ok_btn').attr("href", PATH+'staff/'+subcon_id);
			}else{
				jQuery('#modal_body').removeClass("alert-success");
				jQuery('#modal_body').addClass("alert-danger");
				jQuery('#close_btn').removeClass("hide");
				jQuery('#ok_btn').addClass("hide");
			}
			
			jQuery('#cancel_modified_btn').html('Cancel Changes');
			jQuery('.action_btns').removeAttr('disabled', 'disabled');
			
		},
		error: function(data) {
			alert("There's a problem in updating staff contract.");
			jQuery('#cancel_modified_btn').html('Cancel Changes');
			jQuery('.action_btns').removeAttr('disabled', 'disabled');
		}
	});
	
}
function ApproveUpdatedStaffContract(){
	var subcon_id = jQuery('#subcon_id').val();
	var temp_id = jQuery('#temp_id').val();
	var staff_email = jQuery('#staff_email').val();
	var skype_id = jQuery('#skype_id').val();
	var initial_email_password = jQuery('#initial_email_password').val();
	var initial_skype_password = jQuery('#initial_skype_password').val(); 
	
	var job_designation = jQuery('#job_designation').val();			
	var overtime = jQuery('#overtime').val();
	var overtime_monthly_limit = jQuery('#overtime_monthly_limit').val();
	var overtime_weekly_limit = jQuery('#overtime_weekly_limit').val();
	
	var starting_date = jQuery('#starting_date').val();
	var prepaid_start_date = jQuery('#prepaid_start_date').val();
	var staff_working_timezone = jQuery('#staff_working_timezone').val();
	var client_timezone = jQuery('#client_timezone').val();
	var client_start_work_hour = jQuery('#client_start_work_hour').val();
	var client_finish_work_hour = jQuery('#client_finish_work_hour').val();
	var flexi = jQuery('#flexi').val();
	var service_type = jQuery('#service_type').val();
	var work_days = jQuery('#work_days').val();
	
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
		
	var with_bp_comm = jQuery('#with_bp_comm').val();
	var with_aff_comm = jQuery('#with_aff_comm').val();
	var current_rate = jQuery('#current_rate').val();
	
	var client_price_effective_date = starting_date;
	var working_days = jQuery('#no_of_working_days').html();
	var working_hours = jQuery('#total_working_hours').html();
	
	var service_agreement_id = jQuery('#service_agreement_id').val();
	var quote_details_id = jQuery('#quote_details_id').val();
	
	if(job_designation == ""){
		alert('Job Designation is a required field.');
		jQuery('#job_designation').focus();
		return false;
	}
	
	if(staff_email == ""){
		alert('Staff Email is a required field.');
		jQuery('#staff_email').focus();
		return false;
	}
		
	if(skype_id == ""){
		alert('Staff Skype Id is a required field.');
		jQuery('#skype_id').focus();
		return false;
	}
	
	if(leads_id == ""){
		alert('Please select a client.');
		jQuery('#leads_id').focus();
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
	
	if(starting_date == ""){
		alert('Please select staff starting date.');
		jQuery('#starting_date').focus();
		return false;
	}
	
	// 
	var query = {"temp_id" : temp_id, "subcon_id" : subcon_id, "staff_email" : staff_email, "skype_id" : skype_id, "initial_email_password" : initial_email_password, "initial_skype_password" : initial_skype_password,  "job_designation" : job_designation, "overtime" : overtime, "overtime_monthly_limit" : overtime_monthly_limit, "overtime_weekly_limit" : overtime_weekly_limit, "starting_date" : starting_date, "prepaid_start_date" : prepaid_start_date, "staff_working_timezone" : staff_working_timezone, "client_timezone" : client_timezone, "client_start_work_hour" : client_start_work_hour, "client_finish_work_hour" : client_finish_work_hour, "flexi" : flexi, "service_type" : service_type, "work_days" : work_days, "with_bp_comm" : with_bp_comm, "with_aff_comm" : with_aff_comm, "current_rate" : current_rate, "working_days" : working_days, "working_hours" : working_hours, "mon_start" : mon_start , "mon_finish" : mon_finish , "mon_number_hrs" : mon_number_hrs , "mon_start_lunch" : mon_start_lunch , "mon_finish_lunch" : mon_finish_lunch , "mon_lunch_number_hrs" : mon_lunch_number_hrs, "tue_start" : tue_start , "tue_finish" : tue_finish , "tue_number_hrs" : tue_number_hrs , "tue_start_lunch" : tue_start_lunch , "tue_finish_lunch" : tue_finish_lunch , "tue_lunch_number_hrs" : tue_lunch_number_hrs , "wed_start" : wed_start , "wed_finish" : wed_finish , "wed_number_hrs" : wed_number_hrs , "wed_start_lunch" : wed_start_lunch , "wed_finish_lunch" : wed_finish_lunch , "wed_lunch_number_hrs" : wed_lunch_number_hrs, "thu_start" : thu_start , "thu_finish" : thu_finish , "thu_number_hrs" : thu_number_hrs , "thu_start_lunch" : thu_start_lunch , "thu_finish_lunch" : thu_finish_lunch , "thu_lunch_number_hrs" : thu_lunch_number_hrs, "fri_start" : fri_start , "fri_finish" : fri_finish , "fri_number_hrs" : fri_number_hrs , "fri_start_lunch" : fri_start_lunch , "fri_finish_lunch" : fri_finish_lunch , "fri_lunch_number_hrs" : fri_lunch_number_hrs, "sat_start" : sat_start , "sat_finish" : sat_finish , "sat_number_hrs" : sat_number_hrs , "sat_start_lunch" : sat_start_lunch , "sat_finish_lunch" : sat_finish_lunch , "sat_lunch_number_hrs" : sat_lunch_number_hrs, "sun_start" : sun_start , "sun_finish" : sun_finish , "sun_number_hrs" : sun_number_hrs , "sun_start_lunch" : sun_start_lunch , "sun_finish_lunch" : sun_finish_lunch , "sun_lunch_number_hrs" : sun_lunch_number_hrs, 'service_agreement_id' : service_agreement_id, 'quote_details_id' : quote_details_id};
	
	//console.log(query);
	//return false;
	jQuery('#approve_modified_btn').html('approving changes...');
	jQuery('.action_btns').attr('disabled', 'disabled');
	var url = PATH + 'ApproveUpdatedStaffContract/';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			jQuery('#windowTitleDialog').modal({ 
				backdrop: 'static',
				keyboard: false
			});
			jQuery('#contract_result').html(data.msg);
			
			if(data.success == true){
				jQuery('#ok_btn').removeClass("hide");
				jQuery('#modal_body').removeClass("alert-danger");
				jQuery('#modal_body').addClass("alert-success");
				jQuery('#close_btn').addClass("hide");
				
				jQuery('#ok_btn').attr("href", PATH+'staff/'+subcon_id);
			}else{
				jQuery('#modal_body').removeClass("alert-success");
				jQuery('#modal_body').addClass("alert-danger");
				jQuery('#close_btn').removeClass("hide");
				jQuery('#ok_btn').addClass("hide");
			}
			
			jQuery('#approve_modified_btn').html('Approve Changes');
			jQuery('.action_btns').removeAttr('disabled', 'disabled');
			
		},
		error: function(data) {
			alert("There's a problem in updating staff contract.");
			jQuery('#approve_modified_btn').html('Approve Changes');
			jQuery('.action_btns').removeAttr('disabled', 'disabled');
		}
	});
}

function CheckTempContract(){
	console.log('approve modified contract');
	var subcon_id = jQuery('#subcon_id').val();
	var temp_id = jQuery('#temp_id').val();
	var query = {"subcon_id" : subcon_id, "temp_id" : temp_id};
	var url = PATH + 'CheckTempContract/';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(jsonObject){
			//console.log(jsonObject.fields)
			jQuery.each(jsonObject.fields, function(j, field){
				//console.log(field)
				jQuery('#'+field).addClass("modified_field");
			});
		},
		error: function(jsonObject) {
			alert("There's a problem in checking temp staff contract.");
		}
	});

}
function UpdateStaffContract(){
	console.log('update contract');
	
	var subcon_id = jQuery('#subcon_id').val();
	var staff_email = jQuery('#staff_email').val();
	var initial_email_password = jQuery('#initial_email_password').val();
	var initial_skype_password = jQuery('#initial_skype_password').val(); 
	var skype_id = jQuery('#skype_id').val();
	
	var job_designation = jQuery('#job_designation').val();			
	var overtime = jQuery('#overtime').val();
	var overtime_monthly_limit = jQuery('#overtime_monthly_limit').val();
	var overtime_weekly_limit = jQuery('#overtime_weekly_limit').val();
	
	var starting_date = jQuery('#starting_date').val();
	var prepaid_start_date = jQuery('#prepaid_start_date').val();
	var staff_working_timezone = jQuery('#staff_working_timezone').val();
	var client_timezone = jQuery('#client_timezone').val();
	var client_start_work_hour = jQuery('#client_start_work_hour').val();
	var client_finish_work_hour = jQuery('#client_finish_work_hour').val();
	var flexi = jQuery('#flexi').val();
	var service_type = jQuery('#service_type').val();
	var work_days = jQuery('#work_days').val();
	
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
		

	var with_bp_comm = jQuery('#with_bp_comm').val();
	var with_aff_comm = jQuery('#with_aff_comm').val();
	var current_rate = jQuery('#current_rate').val();
	
	var client_price_effective_date = starting_date;
	var working_days = jQuery('#no_of_working_days').html();
	var working_hours = jQuery('#total_working_hours').html();
	
	var service_agreement_id = jQuery('#service_agreement_id').val();
	var quote_details_id = jQuery('#quote_details_id').val();
	
	
	if(job_designation == ""){
		alert('Job Designation is a required field.');
		jQuery('#job_designation').focus();
		return false;
	}
	
	if(staff_email == ""){
		alert('Staff Email is a required field.');
		jQuery('#staff_email').focus();
		return false;
	}
	
	if(skype_id == ""){
		alert('Staff Skype Id is a required field.');
		jQuery('#skype_id').focus();
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
	
	if(starting_date == ""){
		alert('Please select staff starting date.');
		jQuery('#starting_date').focus();
		return false;
	}
	
	var query = {"subcon_id" : subcon_id, "staff_email" : staff_email, "skype_id" : skype_id, 'initial_email_password' : initial_email_password, 'initial_skype_password' : initial_skype_password,  "job_designation" : job_designation, "overtime" : overtime, "overtime_monthly_limit" : overtime_monthly_limit, "overtime_weekly_limit" : overtime_weekly_limit, "starting_date" : starting_date, "prepaid_start_date" : prepaid_start_date, "staff_working_timezone" : staff_working_timezone, "client_timezone" : client_timezone, "client_start_work_hour" : client_start_work_hour, "client_finish_work_hour" : client_finish_work_hour, "flexi" : flexi, "service_type" : service_type, "work_days" : work_days, "with_bp_comm" : with_bp_comm, "with_aff_comm" : with_aff_comm, "current_rate" : current_rate, "working_days" : working_days, "working_hours" : working_hours, "mon_start" : mon_start , "mon_finish" : mon_finish , "mon_number_hrs" : mon_number_hrs , "mon_start_lunch" : mon_start_lunch , "mon_finish_lunch" : mon_finish_lunch , "mon_lunch_number_hrs" : mon_lunch_number_hrs, "tue_start" : tue_start , "tue_finish" : tue_finish , "tue_number_hrs" : tue_number_hrs , "tue_start_lunch" : tue_start_lunch , "tue_finish_lunch" : tue_finish_lunch , "tue_lunch_number_hrs" : tue_lunch_number_hrs , "wed_start" : wed_start , "wed_finish" : wed_finish , "wed_number_hrs" : wed_number_hrs , "wed_start_lunch" : wed_start_lunch , "wed_finish_lunch" : wed_finish_lunch , "wed_lunch_number_hrs" : wed_lunch_number_hrs, "thu_start" : thu_start , "thu_finish" : thu_finish , "thu_number_hrs" : thu_number_hrs , "thu_start_lunch" : thu_start_lunch , "thu_finish_lunch" : thu_finish_lunch , "thu_lunch_number_hrs" : thu_lunch_number_hrs, "fri_start" : fri_start , "fri_finish" : fri_finish , "fri_number_hrs" : fri_number_hrs , "fri_start_lunch" : fri_start_lunch , "fri_finish_lunch" : fri_finish_lunch , "fri_lunch_number_hrs" : fri_lunch_number_hrs, "sat_start" : sat_start , "sat_finish" : sat_finish , "sat_number_hrs" : sat_number_hrs , "sat_start_lunch" : sat_start_lunch , "sat_finish_lunch" : sat_finish_lunch , "sat_lunch_number_hrs" : sat_lunch_number_hrs, "sun_start" : sun_start , "sun_finish" : sun_finish , "sun_number_hrs" : sun_number_hrs , "sun_start_lunch" : sun_start_lunch , "sun_finish_lunch" : sun_finish_lunch , "sun_lunch_number_hrs" : sun_lunch_number_hrs, 'service_agreement_id' : service_agreement_id, 'quote_details_id' : quote_details_id};
	
	console.log(query);//return false;
	jQuery('#update_btn').html('saving changes...');
	jQuery('.action_btns').attr('disabled', 'disabled');
	
	var url = PATH + 'UpdateStaffContract/';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			jQuery('#windowTitleDialog').modal({ 
				backdrop: 'static',
				keyboard: false
			});
			jQuery('#contract_result').html(data.msg);
			
			if(data.success == true){
				jQuery('#ok_btn').removeClass("hide");
				jQuery('#modal_body').removeClass("alert-danger");
				jQuery('#modal_body').addClass("alert-success");
				jQuery('#close_btn').addClass("hide");
				jQuery('#ok_btn').attr("href", PATH+"temp/"+data.temp_id);
			}else{
				jQuery('#modal_body').removeClass("alert-success");
				jQuery('#modal_body').addClass("alert-danger");
				jQuery('#close_btn').removeClass("hide");
				jQuery('#ok_btn').addClass("hide");
			}
			
			jQuery('#update_btn').html('Save Changes');
			jQuery('.action_btns').removeAttr('disabled', 'disabled');
			
		},
		error: function(data) {
			alert("There's a problem in updating staff contract.");
			jQuery('#update_btn').html('Save Changes');
			jQuery('.action_btns').removeAttr('disabled', 'disabled');
		}
	});
	
}
function CreateNewTempContract(){
	console.log('create new temp contract');
	var userid = jQuery('#userid').val();
	var staff_email = jQuery('#staff_email').val();
	var initial_email_password = jQuery('#initial_email_password').val();
	var initial_skype_password = jQuery('#initial_skype_password').val();
	var skype_id = jQuery('#skype_id').val();	
	
	
	var prepaid = jQuery('#prepaid').val();
	var leads_id = jQuery('#leads_id').val();
	var staff_currency_id = jQuery('#staff_currency_id').val();
	
	var job_designation = jQuery('#job_designation').val();			
	var work_status = jQuery('#work_status').val();
	
	var php_monthly = jQuery('#php_monthly').val();
	var currency = jQuery('#currency').val();
	var client_price = jQuery('#client_price').val();
	
	var overtime = jQuery('#overtime').val();
	var overtime_monthly_limit = jQuery('#overtime_monthly_limit').val();
	var overtime_weekly_limit = jQuery('#overtime_weekly_limit').val();
	var starting_date = jQuery('#starting_date').val();
	var staff_working_timezone = jQuery('#staff_working_timezone').val();
	var client_timezone = jQuery('#client_timezone').val();
	var client_start_work_hour = jQuery('#client_start_work_hour').val();
	var client_finish_work_hour = jQuery('#client_finish_work_hour').val();
	var flexi = jQuery('#flexi').val();
	var service_type = jQuery('#service_type').val();
	var work_days = jQuery('#work_days').val();
	
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
		
	var with_bp_comm = jQuery('#with_bp_comm').val();
	var with_aff_comm = jQuery('#with_aff_comm').val();
	var current_rate = jQuery('#current_rate').val();
	
	var client_price_effective_date = starting_date;
	var working_days = jQuery('#no_of_working_days').html();
	var working_hours = jQuery('#total_working_hours').html();
	
	var service_agreement_id = jQuery('#service_agreement_id').val();
	var quote_details_id = jQuery('#quote_details_id').val();
	
	var package_id = jQuery('#package_id').val();
    var staff_type_id = jQuery('#staff_type_id').val();
	
	//verify required fields
	//job_designation, staff_email, leads_id, staff_working_timezone,client_timezone
	if(job_designation == ""){
		alert('Job Designation is a required field.');
		jQuery('#job_designation').focus();
		return false;
	}
	
	if(staff_email == ""){
		alert('Staff Email is a required field.');
		jQuery('#staff_email').focus();
		return false;
	}
	
	if(skype_id == ""){
		alert('Staff Skype Id is a required field.');
		jQuery('#skype_id').focus();
		return false;
	}
		
	
	if(leads_id == ""){
		alert('Please select a client.');
		jQuery('#leads_id').focus();
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
	
	if(starting_date == ""){
		alert('Please select staff starting date.');
		jQuery('#starting_date').focus();
		return false;
	}
	
	
	
	var query = {"userid" : userid, "prepaid" : prepaid, "job_designation" : job_designation, "staff_email" : staff_email, "leads_id" : leads_id, "initial_email_password" : initial_email_password, "work_status" : work_status, "staff_currency_id" : staff_currency_id, "php_monthly" : php_monthly, "currency" : currency, "client_price" : client_price, "client_price_effective_date" : client_price_effective_date,  "skype_id" : skype_id, "initial_skype_password" : initial_skype_password, "overtime" : overtime, "overtime_monthly_limit" : overtime_monthly_limit, "overtime_weekly_limit" : overtime_weekly_limit, "starting_date" : starting_date, "staff_working_timezone" : staff_working_timezone, "client_timezone" : client_timezone, "client_start_work_hour" : client_start_work_hour, "client_finish_work_hour" : client_finish_work_hour, "flexi" : flexi, "service_type" : service_type, "work_days" : work_days, "with_bp_comm" : with_bp_comm, "with_aff_comm" : with_aff_comm, "current_rate" : current_rate, "working_days" : working_days, "working_hours" : working_hours, "mon_start" : mon_start , "mon_finish" : mon_finish , "mon_number_hrs" : mon_number_hrs , "mon_start_lunch" : mon_start_lunch , "mon_finish_lunch" : mon_finish_lunch , "mon_lunch_number_hrs" : mon_lunch_number_hrs, "tue_start" : tue_start , "tue_finish" : tue_finish , "tue_number_hrs" : tue_number_hrs , "tue_start_lunch" : tue_start_lunch , "tue_finish_lunch" : tue_finish_lunch , "tue_lunch_number_hrs" : tue_lunch_number_hrs , "wed_start" : wed_start , "wed_finish" : wed_finish , "wed_number_hrs" : wed_number_hrs , "wed_start_lunch" : wed_start_lunch , "wed_finish_lunch" : wed_finish_lunch , "wed_lunch_number_hrs" : wed_lunch_number_hrs, "thu_start" : thu_start , "thu_finish" : thu_finish , "thu_number_hrs" : thu_number_hrs , "thu_start_lunch" : thu_start_lunch , "thu_finish_lunch" : thu_finish_lunch , "thu_lunch_number_hrs" : thu_lunch_number_hrs, "fri_start" : fri_start , "fri_finish" : fri_finish , "fri_number_hrs" : fri_number_hrs , "fri_start_lunch" : fri_start_lunch , "fri_finish_lunch" : fri_finish_lunch , "fri_lunch_number_hrs" : fri_lunch_number_hrs, "sat_start" : sat_start , "sat_finish" : sat_finish , "sat_number_hrs" : sat_number_hrs , "sat_start_lunch" : sat_start_lunch , "sat_finish_lunch" : sat_finish_lunch , "sat_lunch_number_hrs" : sat_lunch_number_hrs, "sun_start" : sun_start , "sun_finish" : sun_finish , "sun_number_hrs" : sun_number_hrs , "sun_start_lunch" : sun_start_lunch , "sun_finish_lunch" : sun_finish_lunch , "sun_lunch_number_hrs" : sun_lunch_number_hrs, 'service_agreement_id' : service_agreement_id, 'quote_details_id' : quote_details_id, 'package_id' : package_id, 'staff_type_id' : staff_type_id};
	
	//console.log(query);
	jQuery('#create_btn').html('creating...');
	//jQuery('#create_btn').attr("disabled", "disabled");
    jQuery('#windowTitleDialog').modal({ 
		backdrop: 'static',
		keyboard: false
	});
	jQuery('#contract_result').html("Processing.. please wait");
	jQuery('#modal_body').addClass("alert-info")
    jQuery('#close_btn').addClass("hide");
	jQuery('#ok_btn').addClass("hide");
	
	var url = PATH + 'CreateNewTempContract/';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			//jQuery('#windowTitleDialog').modal({ 
			//	backdrop: 'static',
			//	keyboard: false
			//});
			jQuery('#contract_result').html(data.msg);
			
			if(data.success == true){
				jQuery('#ok_btn').removeClass("hide");
				jQuery('#modal_body').removeClass("alert-danger");
				jQuery('#modal_body').addClass("alert-success");
				jQuery('#close_btn').addClass("hide");
				
			}else{
				jQuery('#modal_body').removeClass("alert-success");
				jQuery('#modal_body').addClass("alert-danger");
				jQuery('#close_btn').removeClass("hide");
				jQuery('#ok_btn').addClass("hide");
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

function SendMessageToMQ(temp_id){
	console.log('send message to mq =>' +temp_id);
	var query = {"temp_id" : temp_id};
	console.log(query)
	var url = LOCALHOST + 'admin_subcon/process_new_staff_contract.php';
	/*
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(result){
			console.log(result)			
		},
		error: function(result) {
			console.log(result)	
		}
	});
	*/
	//var url = LOCALHOST + 'CreateMessage/';
	var result = jQuery.post( url, { 'temp_id' : temp_id} );
	result.done(function( data ) {	
		console.log(data);
	});
	result.fail(function( data ) {
		alert("There is a problem in saving message.");	
	});
}

function formatNumber(num){
	var num = Math.round(num*100)/100;
	return num;
}

function GetHourlyRate(obj){
	var obj_name = jQuery(obj).attr("id");
	ConfigurePrice(obj_name);
}

function ConfigurePrice(obj){
	
	var work_status = jQuery('#work_status').val();
	var price = jQuery('#'+obj).val();

	if(work_status == 'Part-Time'){
	    var hour = 4;
    }else{
		var hour = 8;
	}
	if(price !=""){
		
		jQuery('#'+obj+'_str').removeClass('hide');
		var yearly = parseFloat(price)*12;
		var weekly = (parseFloat(price)*12)/52;
		var daily =  ((parseFloat(price)*12)/52)/5;
		var hourly = (((parseFloat(price)*12)/52)/5)/hour;
		jQuery('#'+obj+'_str').html("<span class='badge'>Yearly : "+formatNumber(yearly)+"</span> <span class='badge'>Monthly : "+ formatNumber(price)+ "</span> <span class='badge'>Weekly : " + formatNumber(weekly)+ "</span> <span class='badge'>Daily : "+ formatNumber(daily) +"</span> <span class='badge'>Hourly : "+formatNumber(hourly)+"</span>");
		
	}else{
		jQuery('#'+obj+'_str').html("");
		jQuery('#'+obj+'_str').addClass("hide");
	}
	
	GetRevenue();
}

function GetRevenue(){
	var client_price = jQuery('#client_price').val();
	var php_monthly = jQuery('#php_monthly').val();
	var current_rate = jQuery('#current_rate').val();
	var with_bp_comm = jQuery('#with_bp_comm').val();
	var with_aff_comm = jQuery('#with_aff_comm').val();
	
	var aff_commission = 0;
	var with_bp_commission=0;
	var net = 0;
	var margin=0;
	if(client_price > 0){	
		var margin = ( client_price - (parseFloat(php_monthly) / current_rate )) ;
	}
	console.log(client_price);
	
	if(with_aff_comm == "YES") { //the affiliate can have a 5% commission
		aff_commission = ((client_price/100) * AFF_COMM);
	}
	if(with_bp_comm == "YES") { //the business partner can have a 15% commission
		with_bp_commission = (((margin - aff_commission)/100)*BP_COMM);
	}
	
	net = (margin - aff_commission) - with_bp_commission;
	//log(formatNumber(margin));
	
	jQuery('#rev').html(formatNumber(margin));
	jQuery('#bp_percent').html(formatNumber(with_bp_commission));
	jQuery('#aff_percent').html(formatNumber(aff_commission));
	jQuery('#net').html(formatNumber(net));
	
}

function GetClientCurrencySetting(){
	var leads_id = jQuery('#leads_id').val();
	var staff_currency_id = jQuery('#staff_currency_id').val();
	
	if(leads_id){
	    
		var url = PATH + 'GetClientCurrencySetting/';
		var result = jQuery.post(
			url,{
				'leads_id' : leads_id,
				'staff_currency_id' :  staff_currency_id
			}
		);

		result.done(function( data ) {
			jsonObject = jQuery.parseJSON(data);
			console.log(jsonObject);
			if(jsonObject.success){
				jQuery('#prepaid').val(jsonObject.prepaid);
				jQuery('#currency').val(jsonObject.currency);
				jQuery('#current_rate').val(jsonObject.currency_rate);
			
				if(jsonObject.client_docs_count > 0){
					jQuery('#currency').attr('disabled', 'disabled');
					jQuery('#current_rate').attr('disabled', 'disabled');
				}
			}else{
				
				//alert("Client selected has no existing currency settings detected.");
				jQuery('#leads_id').val("");
				jQuery('#windowTitleDialog').modal({ 
					backdrop: 'static',
					keyboard: false
				});
				jQuery('#contract_result').html("Client selected has no existing currency settings detected.");
				jQuery('#modal_body').removeClass("alert-success");
				jQuery('#modal_body').addClass("alert-danger");
				jQuery('#close_btn').addClass("hide");
				jQuery('#ok_btn').attr("href", '/portal/AdminRunningBalance/RunningBalance.html?client_id='+leads_id);
			}
		});
		result.fail(function( data ) {
			console.log(data)	
		});
	}
	
}
function DisplayWorkingHoursDaysBreakTime(){
   	var work_days = jQuery('#work_days').val();
	var work_status = jQuery('#work_status').val();
	work_days = work_days.split(',')
	
	var total_working_hours=0;
	var total_break_time_hours=0;
	
	jQuery.each(work_days, function(j, work_day){
		total_working_hours = total_working_hours + parseFloat(jQuery('#'+work_day+'_number_hrs').val());	
	    total_break_time_hours = total_break_time_hours + parseFloat(jQuery('#'+work_day+'_lunch_number_hrs').val());
	});
	
	jQuery('#no_of_working_days').html(work_days.length);
	jQuery('#total_working_hours').html(total_working_hours.toFixed(2));
	jQuery('#total_break_time_hours').html(total_break_time_hours.toFixed(2));
}
function CheckUncheck(obj){
	var weekday = jQuery(obj).val();
	if (jQuery(obj).is(':checked')) {
		console.log('the checkbox was checked') ;
		ConfigureStaffSelectedDaySchedule(obj);
		jQuery('#'+weekday+'_start').removeAttr('disabled');
		jQuery('#'+weekday+'_finish').removeAttr('disabled');
			
		jQuery('#'+weekday+'_start_lunch').removeAttr('disabled');
	    jQuery('#'+weekday+'_finish_lunch').removeAttr('disabled');

	} else {
		console.log('the checkbox was unchecked');
		jQuery('#'+weekday+'_start').val("");
		jQuery('#'+weekday+'_finish').val("")
	    jQuery('#'+weekday+'_number_hrs').val("0.00");
		
		jQuery('#'+weekday+'_start_lunch').val("");
	    jQuery('#'+weekday+'_finish_lunch').val("");
	    jQuery('#'+weekday+'_lunch_number_hrs').val("0.00");
		
		jQuery('#'+weekday+'_start').attr('disabled', 'disabled');
		jQuery('#'+weekday+'_finish').attr('disabled', 'disabled');
	    jQuery('#'+weekday+'_start_lunch').attr('disabled', 'disabled');
	    jQuery('#'+weekday+'_finish_lunch').attr('disabled', 'disabled');
		
		DisplayWorkingHoursDaysBreakTime();
	}
	
}

function CheckedUncheckedWeekday(obj){
	/*
	var ins = document.getElementsByName('weekday')
	var i;
	var j=0;
	var vals= new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			vals[j]=ins[i].val();
			j++;
		}
	}
	jQuery('#work_days').val(vals);
	*/
	
	
	var j=0;
	var vals= new Array();
	jQuery("input[name=weekday]").each(function() {
		var obj = jQuery(this);
		if (jQuery(obj).is(':checked')) {
			vals[j]=jQuery(obj).val();
			j++;
		}
		
	});
	jQuery('#work_days').val(vals);
	CheckUncheck(obj);
	
}

function ConfigureStaffSelectedDaySchedule(obj){
	var given_day = jQuery(obj).val();
	var work_status = jQuery('#work_status').val();
	var staff_working_timezone = jQuery('#staff_working_timezone').val();
	var client_timezone = jQuery('#client_timezone').val();
	var client_start_work_hour = jQuery('#client_start_work_hour').val();
	var flexi = jQuery('#flexi').val();
	var url = PATH + 'ConfigureStaffSchedule/';
	var result = jQuery.post(
		url,{
			'work_status' : work_status,
			'staff_working_timezone' :  staff_working_timezone,
			'client_timezone' : client_timezone,
			'client_start_work_hour' : client_start_work_hour,
			'flexi' : flexi
		}
	);

	result.done(function( data ) {
        jsonObject = jQuery.parseJSON(data);						 
		//console.log(jsonObject);
		
		jQuery('#'+given_day+'_start').val(jsonObject.staff_start_work_hour);
		jQuery('#'+given_day+'_finish').val(jsonObject.staff_finish_work_hour);
		jQuery('#'+given_day+'_number_hrs').val(jsonObject.time_difference);
		
		jQuery('#'+given_day+'_start_lunch').val(jsonObject.staff_start_lunch);
		jQuery('#'+given_day+'_finish_lunch').val(jsonObject.staff_finish_lunch);
		jQuery('#'+given_day+'_lunch_number_hrs').val(jsonObject.lunch_time_difference);
		
		
		if(work_status == 'Full-Time' ){
			jQuery('#'+given_day+'_start_lunch').removeAttr('disabled');
			jQuery('#'+given_day+'_finish_lunch').removeAttr('disabled');
			jQuery('#'+given_day+'_lunch_number_hrs').removeAttr('disabled');

		}else{
			jQuery('#'+given_day+'_start_lunch').attr('disabled','disabled');
			jQuery('#'+given_day+'_finish_lunch').attr('disabled','disabled');
			jQuery('#'+given_day+'_lunch_number_hrs').attr('disabled','disabled');
		}
		DisplayWorkingHoursDaysBreakTime();
	});
	result.fail(function( data ) {
		console.log(data)	
	});
}

function ConfigureStaffSchedule(e){
	var work_status = jQuery('#work_status').val();
	var staff_working_timezone = jQuery('#staff_working_timezone').val();
	var client_timezone = jQuery('#client_timezone').val();
	var client_start_work_hour = jQuery('#client_start_work_hour').val();
	var flexi = jQuery('#flexi').val();
	
	if(work_status!="" && staff_working_timezone!="" && client_timezone!="" && client_start_work_hour !=""){
		var url = PATH + 'ConfigureStaffSchedule/';
		var result = jQuery.post(
			url,{
				'work_status' : work_status,
				'staff_working_timezone' :  staff_working_timezone,
				'client_timezone' : client_timezone,
				'client_start_work_hour' : client_start_work_hour,
				'flexi' : flexi
			}
		);
	
		result.done(function( data ) {
			jsonObject = jQuery.parseJSON(data);						 
			//console.log(jsonObject);
			SetWorkingSchedule(jsonObject);
		});
		result.fail(function( data ) {
			console.log(data)	
		});
	}
}

function SetWorkingSchedule(jsonObject){
	var work_days = jQuery('#work_days').val();
	var work_status = jQuery('#work_status').val();
	work_days = work_days.split(',')
	
	jQuery('#client_finish_work_hour').val(jsonObject.client_finish_work_hour)
	
	jQuery.each(WEEKDAYS, function(i, given_day){
		jQuery('#'+given_day+'_start').attr('disabled','disabled');
		jQuery('#'+given_day+'_finish').attr('disabled','disabled');
		jQuery('#'+given_day+'_number_hrs').val("0.00");
		
		jQuery('#'+given_day+'_lunch_number_hrs').val("0.00");
		jQuery('#'+given_day+'_start_lunch').attr('disabled','disabled');
		jQuery('#'+given_day+'_finish_lunch').attr('disabled','disabled');
		
		jQuery('#'+given_day+'_start').val("");
		jQuery('#'+given_day+'_finish').val("");
		
		jQuery('#'+given_day+'_start_lunch').val("");
		jQuery('#'+given_day+'_finish_lunch').val("");
		
		//jQuery.each(work_days, function(j, work_day){
			if(jQuery.inArray(given_day, work_days ) >= 0 ){
				//console.log(given_day);
				jQuery('#'+given_day+'_start').removeAttr('disabled');
				jQuery('#'+given_day+'_finish').removeAttr('disabled');
		
				jQuery('#'+given_day+'_start').val(jsonObject.staff_start_work_hour);
				jQuery('#'+given_day+'_finish').val(jsonObject.staff_finish_work_hour);
				jQuery('#'+given_day+'_number_hrs').val(jsonObject.time_difference);
				
				jQuery('#'+given_day+'_start_lunch').removeAttr('disabled');
				jQuery('#'+given_day+'_finish_lunch').removeAttr('disabled');
		
				jQuery('#'+given_day+'_start_lunch').val(jsonObject.staff_start_lunch);
				jQuery('#'+given_day+'_finish_lunch').val(jsonObject.staff_finish_lunch);
				jQuery('#'+given_day+'_lunch_number_hrs').val(jsonObject.lunch_time_difference);
				
				
				if(work_status == 'Full-Time' ){
					jQuery('#'+given_day+'_start_lunch').removeAttr('disabled');
					jQuery('#'+given_day+'_finish_lunch').removeAttr('disabled');
					jQuery('#'+given_day+'_lunch_number_hrs').removeAttr('disabled');

				}else{
					jQuery('#'+given_day+'_start_lunch').attr('disabled','disabled');
					jQuery('#'+given_day+'_finish_lunch').attr('disabled','disabled');
					jQuery('#'+given_day+'_lunch_number_hrs').attr('disabled','disabled');
				}
			} 
		//});
	});
	
	
	DisplayWorkingHoursDaysBreakTime();
	
}


function CheckWeekDays(){
	var work_days = jQuery('#work_days').val();
	work_days = work_days.split(',')
	//console.log(work_days);
	//console.log(jQuery.inArray("sat", work_days ));
	
	jQuery("input[name=weekday]").each(function() {
		var obj = jQuery(this);
		var given_day = jQuery(this).val();
		if(jQuery.inArray(given_day, work_days ) >= 0 ){
			obj.attr('checked', 'checked');
		}else{
			//console.log(given_day)
			jQuery('#'+given_day+'_start').attr('disabled','disabled');
			jQuery('#'+given_day+'_finish').attr('disabled','disabled');
			jQuery('#'+given_day+'_number_hrs').val("0.00");
			
			jQuery('#'+given_day+'_start_lunch').attr('disabled','disabled');
			jQuery('#'+given_day+'_finish_lunch').attr('disabled','disabled');
			jQuery('#'+given_day+'_lunch_number_hrs').val("0.00");
			
			jQuery('#'+given_day+'_start').val("");
			jQuery('#'+given_day+'_finish').val("");
			
			jQuery('#'+given_day+'_start_lunch').val("");
			jQuery('#'+given_day+'_finish_lunch').val("");
		}
		//console.log();
		/*
		jQuery.each(work_days, function(j, work_day){
			if (work_day==given_day){
				obj.attr('checked', 'checked');
			}
		});
		*/
	});
	
		
}
function SearchApplicant(e){
	var search_str = jQuery('#search_str').val();
	var search_type = jQuery('#search_type').val();
	var service_agreement_id = jQuery('#service_agreement_id').val();
	var quote_details_id = jQuery('#quote_details_id').val();
	
	
	var url = PATH + 'SearchApplicant/';
	var result = jQuery.post(
		url,{
			'search_str' : search_str,
			'search_type' :  search_type, 
			'service_agreement_id' : service_agreement_id,
			'quote_details_id' : quote_details_id
		}
	);
	
	jQuery("#search_btn").html("searching...");
	result.done(function( data ) {				 
		jQuery("#applicants_list").html(data);
		jQuery("#search_btn").html("Search");
		//jQuery('search_btn').disabled=false;
	});
	result.fail(function( data ) {
		jQuery("#search_btn").html("Search");				 
		alert("There is a problem in showing "+ status +" list of subcontractors.");	
	});
}

function SearchSubcons(){
	
	var status = jQuery('#status').val();
	var keyword = jQuery('#keyword').val();
	var leads_id = jQuery('#leads_id').val();	
	var page = jQuery('#page').val();
	
	
	var userid = jQuery('#userid').val();
	var hiring_coordinator_id = jQuery('#hiring_coordinator_id').val();
	var csro_id = jQuery('#csro_id').val();
	var recruiter_id = jQuery('#recruiter_id').val();
	var client_timezone = jQuery('#client_timezone').val();
	var work_status = jQuery('#work_status').val();
	var flexi = jQuery('#flexi').val();
	
	
		
	var url = PATH + 'SearchSubcons/';
	var result = jQuery.post(
				   		url,{
							'page' : page,
							'status' :  status, 
							'keyword' : keyword, 
							'leads_id' : leads_id,
							'userid' : userid,
							'hiring_coordinator_id' : hiring_coordinator_id,
							'csro_id' : csro_id,
							'recruiter_id' : recruiter_id,
							'client_timezone' : client_timezone,
							'work_status' : work_status,
							'flexi' : flexi
							}
						);
	
	
	result.done(function( data ) {				 
		jQuery("#subconlist").html(data);
	});
	result.fail(function( data ) {
		alert("There is a problem in showing "+ status +" list of subcontractors.");	
	});
		
	
}

function search_subconlist_reporting(){
	var start_date = jQuery('#start_date').val();
	var end_date = jQuery('#end_date').val();
	var active_client = jQuery('#active_client').val();
    var inactive_client = jQuery('#inactive_client').val();
	var csro_id = jQuery('#csro_id').val();
    var optionValues = [];	
	
	//For active clients filter
	if(active_client == 'all'){
		$('#active_client option').each(function() {
			var client_id = jQuery(this).val();									 
			if(client_id != 'all' && client_id != 'none' ){
				optionValues.push(client_id);
			}
			
		});
	}else if(active_client == 'none'){
		//do nothing
	}else{
		optionValues.push(active_client);
	}
	
	//For inactive clients filter
	if(inactive_client == 'all'){
		$('#inactive_client option').each(function() {
			var client_id = jQuery(this).val();									 
			if(client_id != 'all' && client_id != 'none' ){
				optionValues.push(client_id);
			}
			
		});
	}else if(inactive_client == 'none'){
		//do nothing
	}else{
		optionValues.push(inactive_client);
	}
	
	if(optionValues == ""){
		alert("Please select at least a client.");
		return false;
	}
	//console.log(optionValues);
	//return false;
	var query = {"csro_id" : csro_id, "start_date": start_date, "end_date" : end_date, "clients" : optionValues  };
	console.log(query);
	jQuery('#search_btn').html("searching...");
	jQuery('#search_btn').attr('disabled', 'disabled');
	jQuery('#export_subconlist_reporting_btn').addClass("hide");
	jQuery("#search_result").html("generating couch document. please wait...");
	var url = PATH + 'search_subconlist_reporting/';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response){
			doc_id = response.doc_id
			render_subconlist_reporting_result(doc_id)
		},
		error: function(response) {
			alert("There's a problem in searching subconlist reporting.");
			jQuery('#search_btn').html('Search');
			jQuery('#search_btn').removeAttr('disabled', 'disabled');
		}
	});	
	
}

function RunTimerForRendering(doc_id){    
	setTimeout(function(){render_subconlist_reporting_result(doc_id)},5000);
	
}

function render_subconlist_reporting_result(doc_id){
	jQuery.get(PATH + "render_subconlist_reporting_result/"+doc_id, function(response){
		if(response == 'total_adj_hrs'){
			jQuery("#search_result").html("calculating total adjustment hours. please wait...");
			RunTimerForRendering(doc_id);
		}else if(response == 'total_log_hrs'){
			jQuery("#search_result").html("calculating total log hours. please wait...");
			RunTimerForRendering(doc_id);
		}else{			
			jQuery("#search_result").html(response);
			jQuery("#search_btn").html("Search");
			jQuery("#search_btn").removeAttr("disabled");
			jQuery('#export_subconlist_reporting_btn').removeClass("hide");
			jQuery('#export_subconlist_reporting_btn').attr("href", "export_subconlist_reporting/"+doc_id);
		}
	})
}

function CheckCSRO(){
	var active_client = jQuery('#active_client').val();
    var inactive_client = jQuery('#inactive_client').val();
	var csro_id = jQuery('#csro_id').val();
	
	jQuery('#csro_id').removeAttr("disabled", "disabled");
	
	if((!isNaN(active_client) ) || (!isNaN(inactive_client) )){
		jQuery('#csro_id').attr("disabled", "disabled");
		jQuery('#csro_id').val("");
	}
	console.log(active_client +' '+inactive_client+' '+csro_id);
}