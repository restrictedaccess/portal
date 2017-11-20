jQuery(document).ready(function() {
	jQuery(window).load(function (e) {
		console.log('Client Portal Leave Request Management');
		StaffLeaveRequestSearch();
	});
	
	
});


function StaffLeaveRequestSearch(){
	var userid = jQuery('#userid').val();
    var year = jQuery('#year').val();	
	var url = 'StaffLeaveRequestSearch.php';
	var result = jQuery.post( url, { 'userid' : userid, 'year' : year} );
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

function ShowLeaveRequest(leave_request_id, status){
	//var leave_request_id = jQuery(e).attr('leave_request_id');
	var year = jQuery('#year').val();
	//var status = jQuery(e).attr('status');
	
	jQuery('#leave_request_result').html("Loading...");
	var url = 'ShowLeaveRequest.php';
	var result = jQuery.post( url, { 'leave_request_id' : leave_request_id, 'year' : year, 'status' : status} );
	result.done(function( data ) {
		jQuery('#leave_request_result').html(data);
		EnableDisableButton();
		jQuery('#close_btn').click(function(){
            //alert("Please submit form");
			jQuery("#form").submit()
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
	}else{
		jQuery('.action_btn').attr('disabled', 'disabled');
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
	
	
	var url = 'UpdateLeaveRequestDate.php';
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
				ShowLeaveRequest(jsonObject.leave_request_id, jsonObject.status);
				StaffLeaveRequestSearch();
			}else{
				alert("Error Detected : "+jsonObject.msg);
				ShowLeaveRequest(jsonObject.leave_request_id, jsonObject.status);
				StaffLeaveRequestSearch();
			}
		},
		error: function(jsonObject) {
			alert("There's a problem in updating leave request dates.");
		}
	});
}