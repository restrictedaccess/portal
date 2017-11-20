jQuery(document).ready(function() {
	jQuery(window).load(function (e) {
		console.log('Admin Portal Leave Request Management');
		//StaffLeaveRequestSearch();
		
		
		Calendar.setup({
		   inputField : "start_date",
		   trigger    : "start_date",
		   onSelect   : function() { this.hide()  },
		   fdow  : 0,
		   dateFormat : "%Y-%m-%d"
		});
		
		Calendar.setup({
		   inputField : "end_date",
		   trigger    : "end_date",
		   onSelect   : function() { this.hide()  },
		   fdow  : 0,
		   dateFormat : "%Y-%m-%d"
		});
		
		searchLeaveRequest();
	});
	
	$("#form").submit(function(e){
        searchLeaveRequest();
        e.preventDefault(e);
    });
	
	jQuery('#userid').change(function(){		
		//console.log(jQuery('#userid').val());
		var userid =jQuery('#userid').val();
		var useridStaffName = jQuery('#userid').find(":selected").text();
		if(userid != ""){
        	console.log(useridStaffName);
        	jQuery("#add-leave-btn").removeClass("hide");
        	jQuery("#add-leave-btn").html("Add Leave for "+ useridStaffName );
        }else{
        	jQuery("#add-leave-btn").addClass("hide");
        	jQuery("#add-leave-btn").html("Add Leave");
        }
	});
	
	jQuery('#add-leave-btn').click(function(e) {
    	e.preventDefault(e);        	
		ShowAddLeaveForm(); 
	});
	
});


function searchLeaveRequest(){
	var userid = jQuery('#userid').val();
	
	
    var start_date = jQuery('#start_date').val();
    var end_date = jQuery('#end_date').val();
	var csro_id = jQuery('#csro_id').val();
	var NODEJS_API = jQuery("#nodejs_api").val();
	var url = NODEJS_API+'/leave-request/search';
	
	
	jQuery("#search-btn").html("searching...");
    jQuery("#search-btn").attr("disabled", true);
    jQuery("#leave-request-tb tbody").html("Loading...");
        
	var result = jQuery.post( url, { 'userid' : userid, 'start_date' : start_date, 'end_date' : end_date, 'csro_id' : csro_id} );
	result.done(function( response ) {
		//console.log(response);
		var records="";
		for(var i=0; i<response.result.length; i++){
			var record = response.result[i];
			records +="<tr>";
				records +="<td>";
					records += "<a href='#' class='leave_request_id'>";
						records += record.id;
					records += "</a>";
				records +="</td>";
				records +="<td>";
					records += record.staff;
				records +="</td>";
				records +="<td>";
					records += record.client;
				records +="</td>";
				records +="<td>";
					records += record.admin;
				records +="</td>";		
				records +="<td>";
					records += record.date_requested;
				records +="</td>";		
				records +="<td>";
					records += record.leave_type;
				records +="</td>";
				records +="<td>";
					records += record.date_of_leave;
				records +="</td>";
				records +="<td>";
					records += record.status;
				records +="</td>";
			records +="</tr>";
		}
		
		//console.log(records);
		jQuery("#leave-request-tb tbody").html(records);
		jQuery("#search-btn").html("Search");
        jQuery("#search-btn").removeAttr("disabled");
        
        
        
        
        jQuery('.leave_request_id').click(function(e) {
        	e.preventDefault(e);
        	var object = jQuery(this);
			//console.log(object.text());
			var leave_request_id = object.text();
			//var status = object.attr("status");
			ShowLeaveRequest(leave_request_id); 
		});
		
		
        
	});
	result.fail(function( response ) {
		console.log("There's something wrong in "+url+". Please try again later.");	
		jQuery("#search-btn").html("Search");
        jQuery("#search-btn").removeAttr("disabled");
	});
	
}

function AddLeave(){
	
	var j=0;
	var vals= new Array();
	jQuery("input[name=lead]").each(function() {
		var obj = jQuery(this);
		if (jQuery(obj).is(':checked')) {
			vals[j]=jQuery(obj).val();
			j++;
		}
		
	});
	if(vals.length == 0){
		alert("Please select a client.");
		return false;
	}
	
	var userid = jQuery('#userid').val();
	var leave_type = jQuery('#leave_type').val();
	var start_date_of_leave = jQuery('#start_date_of_leave').val();
	var end_date_of_leave = jQuery('#end_date_of_leave').val();
	var leave_duration = jQuery('#leave_duration').val();
	var reason_for_leave = jQuery('#reason_for_leave').val();
	
	if(confirm("Add this leave?")){
		
		jQuery('#add_leave_btn').attr('disabled', 'disabled');
		jQuery('#cancel_btn').attr('disabled', 'disabled');
		jQuery('#add_leave_btn').html('saving...');
		
		var query = {"clients" : vals, "userid" : userid, 'leave_type' : leave_type, 'start_date_of_leave' : start_date_of_leave, 'end_date_of_leave' : end_date_of_leave, 'leave_duration' : leave_duration, 'reason_for_leave' : reason_for_leave};
		var url = 'add_a_leave_json.php';
		jQuery.ajax({
			type: "POST",
			url: url,
			// The key needs to match your method's input parameter (case-sensitive).
			data: JSON.stringify({ Query: query }),
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(jsonObject){
				if(jsonObject.success){
					alert(jsonObject.msg);					
					jQuery("#start_date").val(start_date_of_leave);
					jQuery("#end_date").val(end_date_of_leave);
					jQuery("#form").submit();

					//jQuery('#add_leave_form').addClass("hide");															
					jQuery('#windowTitleDialog').modal('toggle');
				}
				
				
				
				jQuery('#add_leave_btn').removeAttr('disabled', 'disabled');
				jQuery('#cancel_btn').removeAttr('disabled', 'disabled');
				jQuery('#add_leave_btn').html('Submit');
			},
			error: function(jsonObject) {
				alert("There's a problem in updating leave request dates.");
				jQuery('#add_leave_btn').removeAttr('disabled', 'disabled');
				jQuery('#cancel_btn').removeAttr('disabled', 'disabled');
				jQuery('#add_leave_btn').html('Submit');
			}
		});
	}
}
function ShowAddLeaveForm(){
	var userid = jQuery('#userid').val();
	if(userid == ""){
		alert("Please select a staff.");
		return false;
	}
	
	jQuery('#leave_request_result').html("Loading...");
	var url = 'ShowAddLeaveForm.php';
	var result = jQuery.post( url, { 'userid' : userid} );
	result.done(function( data ) {
		
		jQuery('#windowTitleDialog').modal({ 
			backdrop: 'static',
			keyboard: false
		});
		
		//jQuery('#add_leave_form').removeClass("hide");
		//jQuery('#add_leave_form').html(data);		
		//jQuery('#leave_request_result').addClass("hide");
		
		jQuery('#leave_request_result').html(data);
		
		jQuery('#add_leave_btn').click(function() {
			AddLeave();
		});
		
		jQuery('#cancel_btn').click(function() {
			jQuery('#add_leave_form').addClass("hide");
			jQuery('#leave_request_result').removeClass("hide");
		});
		
		Calendar.setup({
		   inputField : "start_date_of_leave",
		   trigger    : "bd",
		   onSelect   : function() { this.hide()  },
		   fdow  : 0,
		   dateFormat : "%Y-%m-%d"
		});
		
		Calendar.setup({
		   inputField : "end_date_of_leave",
		   trigger    : "bd2",
		   onSelect   : function() { this.hide()  },
		   fdow  : 0,
		   dateFormat : "%Y-%m-%d"
		});
		
				
		
	});
	result.fail(function( data ) {
		alert("There's a problem in displaying leave form.");
	});
}

function StaffLeaveRequestSearch(){
	var userid = jQuery('#userid').val();
    var year = jQuery('#year').val();
	var csro_id = jQuery('#csro_id').val();
	var url = 'StaffLeaveRequestSearch.php';
	var result = jQuery.post( url, { 'userid' : userid, 'year' : year, 'csro_id' : csro_id} );
	result.done(function( data ) {
		jQuery('#leave_reqeust_container').html(data);	
		jQuery('.lr_id').click(function(e) {
			var leave_request_id = jQuery(this).attr('leave_request_id');
			var status = jQuery(this).attr('status');
			ShowLeaveRequest(leave_request_id, status);
		});
	});
	result.fail(function( data ) {
		jQuery('#leave_reqeust_container').html("There is a problem in loading leave requests.");	
	});
	
}

function ShowLeaveRequest(leave_request_id){
	//var leave_request_id = jQuery(e).attr('leave_request_id');
	var year = jQuery('#year').val();
	//var status = jQuery(e).attr('status');
	
	jQuery('#windowTitleDialog').modal({ 
		backdrop: 'static',
		keyboard: false
	});
	
	jQuery('#leave_request_result').html("Loading...");
	var url = 'ShowLeaveRequest.php';
	var result = jQuery.post( url, { 'leave_request_id' : leave_request_id} );
	result.done(function( data ) {
		jQuery('#leave_request_result').html(data);
		EnableDisableButton();
		jQuery('#close_btn').click(function(){
            //alert("Please submit form");
			jQuery("#form").submit()
		});
		
		jQuery('#checkall').click(function(){
			  var checked = !jQuery(this).data('checked');
			  jQuery('input:checkbox').prop('checked', checked);
			  jQuery(this).html(checked ? 'uncheck all' : 'check all' )
			  jQuery(this).data('checked', checked);
		});
		
		jQuery('.action_btn').click(function(e){
			UpdateLeaveRequestDate(this);								 
		});
		
		
		
		
	});
	result.fail(function( data ) {
		alert("There's an error in showing leave request #"+leave_request_id+" details");
	});
}
function EnableDisableButton(){
	var no_of_dates = jQuery("input[name=dates]" ).length;
	if (no_of_dates > 0){
		jQuery('.action_btn').removeAttr('disabled', 'disabled');
		jQuery('#checkall').removeAttr('disabled', 'disabled');
		
	}else{
		jQuery('.action_btn').attr('disabled', 'disabled');
		jQuery('#checkall').attr('disabled', 'disabled');
	}
}

function UpdateStaffList(year,month,day){
	console.log(year+' '+month+' '+day);
	var userid = jQuery('#userid').val();
	var url = 'StaffLeaveRequestSearch.php';
	var result = jQuery.post( url, { 'userid' : userid, 'year' : year, 'month' : month, 'day' : day} );
	result.done(function( data ) {
		jQuery('#leave_reqeust_container').html(data);	
		jQuery('.lr_id').click(function(e) {							
			//ShowLeaveRequest(this);
			var leave_request_id = jQuery(this).attr('leave_request_id');
			var status = jQuery(this).attr('status');
			ShowLeaveRequest(leave_request_id, status);
		});
	});
	result.fail(function( data ) {
		jQuery('#leave_reqeust_container').html("There is a problem in loading leave requests.");	
	});
}

function UpdateLeaveRequestDate(e){
	var j=0;
	var vals= new Array();
	jQuery("input[name=dates]").each(function() {
		var obj = jQuery(this);
		if (jQuery(obj).is(':checked')) {
			vals[j]=jQuery(obj).val();
			j++;
		}
		
	});
	if(vals.length == 0){
		alert("Please select a date.");
		return false;
	}
	
	var status = jQuery(e).attr('status');
	var leave_request_id = jQuery('#leave_request_id').val();
	var notes = jQuery('#notes').val();
	
	

	var query = {"dates" : vals, "leave_request_id" : leave_request_id, 'status' : status, 'notes' : notes};
	var url = 'UpdateLeaveRequestDate.php';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(jsonObject){
			console.log(jsonObject.success)
			if(jsonObject.success == true){
				alert("Leave request dates has been "+jsonObject.status);
				ShowLeaveRequest(jsonObject.leave_request_id);
				//StaffLeaveRequestSearch();
			}else{
				alert("Error Detected : "+jsonObject.msg);
				ShowLeaveRequest(jsonObject.leave_request_id);
				//StaffLeaveRequestSearch();
			}
		},
		error: function(jsonObject) {
			alert("There's a problem in updating leave request dates.");
		}
	});
}