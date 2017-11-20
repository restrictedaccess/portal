var loadedTimesheets = [];

jQuery(document).ready(function(){
	console.log(window.location.pathname);
	CURRENT_PAGE = "leave_request";
	
	getStaffLeaveRequest();
	getLeaveRequestCalendar();	
	
	jQuery("#year").on("change", function(){
		getStaffLeaveRequest();
		getLeaveRequestCalendar();
	});
	
	
	jQuery(".add_leave_request_btn").on("click", function(e){
		var obj = jQuery(this);
		var year = obj.attr("year");
		var month = obj.attr("month");
		var day = obj.attr("day");
		RequestLeave(year, month, day);
	});
})

function getStaffLeaveRequest(){
	var year = jQuery('#year').val();
	//jQuery('#staff_leave_request_container').html("Loading...");
	var data = {json_rpc:"2.0", id:"ID1", method:"get_staff_leave_request", params:[year]};
	jQuery.ajax({
		url: URL_STAFF_API,
		type: 'POST',
		data: JSON.stringify(data),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json',
		success: function(response) {
			var pending="";
			var approved="";
			var absent="";
			var denied="";
			var cancelled="";
			if(response.result.pending){
				jQuery.each(response.result.pending, function(i, item){						  
						pending +="<li>";
						pending +="<a href='#' class='leave_request' leave_request_id='"+item.id+"'>";
						pending +=item.id;
						pending +=" Request ~ "+item.leave_type;
						pending +="</a>";
						pending +="</li>";			
				});
			}
			
			if(response.result.approved){
				jQuery.each(response.result.approved, function(i, item){							  
						approved +="<li>";
						approved +="<a href='#' class='leave_request' leave_request_id='"+item.id+"'>";
						approved +=item.id;
						approved +=" Request ~ "+item.leave_type;
						approved +="</a>";
						approved +="</li>";
				});
			}
			
			if(response.result.absent){
				jQuery.each(response.result.absent, function(i, item){							  
						absent +="<li>";
						absent +="<a href='#' class='leave_request' leave_request_id='"+item.id+"'>";
						absent +=item.id;
						absent +=" Request ~ "+item.leave_type;
						absent +="</a>";
						absent +="</li>";
				});
			}
			
			if(response.result.denied){
				jQuery.each(response.result.denied, function(i, item){							  
						denied +="<li>";
						denied +="<a href='#' class='leave_request' leave_request_id='"+item.id+"'>";
						denied +=item.id;
						denied +=" Request ~ "+item.leave_type;
						denied +="</a>";
						denied +="</li>";
				});
			}
			
			if(response.result.cancelled){
				jQuery.each(response.result.cancelled, function(i, item){							  
						cancelled +="<li>";
						cancelled +="<a href='#' class='leave_request' leave_request_id='"+item.id+"'>";
						cancelled +=item.id;
						cancelled +=" Request ~ "+item.leave_type;
						cancelled +="</a>";
						cancelled +="</li>";
				});
			}
			jQuery('#pending_status ol').html(pending);
			jQuery('#approved_status ol').html(approved);
			jQuery('#absent_status ol').html(absent);
			jQuery('#denied_status ol').html(denied);
			jQuery('#cancelled_status ol').html(cancelled);
			
			
			jQuery(".leave_request").on("click", function(e){
				var obj = jQuery(this);
				var leave_request_id = obj.attr("leave_request_id");
				show_leave_request_by_id(leave_request_id);
			});
			

			
		}		
	});
}
function getLeaveRequestCalendar(){
	
	var year = jQuery('#year').val();
	jQuery('#staff_calendat_container').html("Loading "+ year +" calendar. Please wait...");
	var data = {json_rpc:"2.0", id:"ID1", method:"get_leave_request_calendar", params:[year]};
	jQuery.ajax({
		url: URL_STAFF_API,
		type: 'POST',
		data: JSON.stringify(data),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json',
		success: function(response) {
			//console.log(response.result);
			jQuery('#staff_calendat_container').html(response.result);
			
			jQuery(".show_leave_request_by_date").on("click", function(e){
				var obj = jQuery(this);
				var year = obj.attr("year");
				var month = obj.attr("month");
				var day = obj.attr("day");
				ShowLeaveRequestByDate(year, month, day)
			});
			jQuery(".request_a_leave").on("click", function(e){
				var obj = jQuery(this);
				var year = obj.attr("year");
				var month = obj.attr("month");
				var day = obj.attr("day");
				RequestLeave(year, month, day)
			});
			
		}		
	});
}

function show_leave_request_by_id(leave_request_id){
	
	jQuery('#calendar_result').addClass("hide");
	jQuery('#leave_request_result').removeClass("hide");	
	jQuery('#leave_request_result').html("Loading...");
	
	var url = DJANGO_APP_URL +'show_leave_request_by_id/';
	var result = jQuery.post( url, { 'leave_request_id' : leave_request_id} );
	result.done(function( data ) {
		jQuery('#leave_request_result').html(data);
		jQuery('#cancel_btn').on("click", function(e){
			var obj = jQuery(this);
			update_leave_request(obj);
		});
		
		jQuery('#close_btn').on("click", function(e){
			jQuery('#calendar_result').removeClass("hide");
			jQuery('#leave_request_result').addClass("hide");	
			jQuery('#leave_request_result').html("");
		});
		
	});
	result.fail(function( data ) {
		jQuery('#leave_request_result').html("There is a problem in showing #"+leave_request_id+" leave request details.");	
	});
	
	
}

function update_leave_request(obj){
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
	
	var leave_request_id = obj.attr("leave_request_id");
	var status = obj.attr("status");
	var notes = jQuery('#notes').val();
	
	//console.log(leave_request_id+" => "+status);

	var query = {"dates" : vals, "leave_request_id" : leave_request_id, 'status' : status, 'notes' : notes};
	
	var data = {json_rpc:"2.0", id:"ID1", method:"update_leave_request", params:[query]};
	jQuery.ajax({
		url: URL_STAFF_API,
		type: 'POST',
		data: JSON.stringify(data),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json',
		success: function(response) {
			alert(response.result);
			show_leave_request_by_id(leave_request_id);
			getStaffLeaveRequest();
		}		
	});
	
}

function ShowLeaveRequestByDate(year, month, day){
	//console.log(year+" "+month+" "+day);
	var url = DJANGO_APP_URL +'ShowLeaveRequestByDate/';
	var result = jQuery.post( url, { 'year' : year, 'month' : month, 'day' : day} );
	result.done(function( data ) {
		jQuery('#calendar_result').addClass("hide");
		jQuery('#leave_request_result').removeClass("hide");	
		jQuery('#leave_request_result').html("Loading...");		
		jQuery('#leave_request_result').html(data);
		
		jQuery('#close_btn').on("click", function(e){
			jQuery('#calendar_result').removeClass("hide");
			jQuery('#leave_request_result').addClass("hide");	
			jQuery('#leave_request_result').html("");
		});
		
		jQuery('.leave_request_dates').on("click", function(e){
			var obj = jQuery(this);
			var leave_request_id = obj.attr("leave_request_id");
			show_leave_request_by_id(leave_request_id);
		});
		
		
	});
	result.fail(function( data ) {
		jQuery('#leave_request_result').html("There is a problem in rendering leave requests.");	
	});
}

function RequestLeave(year, month, day){
	//console.log(year+" "+month+" "+day);
	var url = DJANGO_APP_URL +'RequestLeave/';
	var result = jQuery.post( url, { 'year' : year, 'month' : month, 'day' : day} );
	result.done(function( data ) {
		jQuery('#calendar_result').addClass("hide");
		jQuery('#leave_request_result').removeClass("hide");	
		jQuery('#leave_request_result').html("Loading...");		
		jQuery('#leave_request_result').html(data);
		
		jQuery('#close_btn').on("click", function(e){
			jQuery('#calendar_result').removeClass("hide");
			jQuery('#leave_request_result').addClass("hide");	
			jQuery('#leave_request_result').html("");
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
		
		jQuery('#add_leave_btn').on("click", function(e){
			add_leave_request();
		});
		
		
	});
	result.fail(function( data ) {
		jQuery('#leave_request_result').html("There is a problem in showing leave request form.");	
	});
}

function add_leave_request(){
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
		jQuery('#close_btn').attr('disabled', 'disabled');
		jQuery('#add_leave_btn').html('saving...');
		
		var query = {"clients" : vals, "leave_type" : leave_type, "start_date_of_leave" : start_date_of_leave, "end_date_of_leave" : end_date_of_leave, "leave_duration" : leave_duration, "reason_for_leave" : reason_for_leave};
	
		var data = {json_rpc:"2.0", id:"ID1", method:"add_leave_request", params:[query]};
		jQuery.ajax({
			url: URL_STAFF_API,
			type: 'POST',
			data: JSON.stringify(data),
			contentType: 'application/json; charset=utf-8',
			dataType: 'json',
			success: function(response) {
				if(response.result.success){
					alert(response.result.msg);
					show_leave_request_by_id(response.result.leave_request_id);
					getStaffLeaveRequest();
					getLeaveRequestCalendar();
				}
			}		
		});
	}
}