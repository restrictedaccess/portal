var timerId = 0;

jQuery(document).ready(function() {
	jQuery(window).load(function (e) {
		console.log(window.location.pathname);		
	});
	timeoutReference = null;
	Calendar.setup({
		inputField : "date_start",
		trigger    : "date_start_icon",
		onSelect   : function() { this.hide()  },
		//showTime   : 12,
		fdow  : 0,
		dateFormat : "%Y-%m-%d"
	});	
	jQuery("#search_btn").click(function(e){
		generate_couch_doccument_for_running_late_report();								 
		e.preventDefault();				
	});
	
});

function generate_couch_doccument_for_running_late_report(){
	//alert(window.location.pathname);
	clearInterval(timerId);
	jQuery('#timer').text("");
	
	var date_start = jQuery('#date_start').val();
	var start_time = jQuery('#start_time').val();
	var userid = jQuery('#userid').val();
	var leads_id = jQuery('#leads_id').val();
	var csro_id = jQuery('#csro_id').val();
	var work_status = jQuery('#work_status').val();
	var flexi = jQuery('#flexi').val();
    var login_type = jQuery('#login_type').val();
	
	var url = SYSTEM_WIDE_REPORTING_PATH + "generate_couch_doccument_for_running_late_report/";
	var result = jQuery.post(
		url,{
			'date_start' : date_start,
			'start_time' : start_time,
			'userid' : userid,
			'leads_id' : leads_id,
			'csro_id' : csro_id,
			'work_status' : work_status,
			'flexi' : flexi,
			'login_type' : login_type
		}
	);
	
	
	jQuery("#search_btn").attr("disabled", "disabled");
	jQuery("#search_btn").html("searching...");
	jQuery("#export_btn").addClass("hide");
	jQuery("#export_btn").attr("href", "#");
	
	result.done(function( data ) {
        jsonObject = jQuery.parseJSON(data);	
		console.log(jsonObject)		
		if(jsonObject.success){
			render_running_late_result(jsonObject.doc_id, jsonObject.rev_id)
		}else{
			jQuery("#search_result").html("There is a problem in getting subcontractors ids");
			//jQuery("#search_btn").removeAttr("disabled", "disabled");
			//jQuery("#search_btn").html("Search");
			//jQuery("#export_btn").addClass("hide");
			//jQuery("#export_btn").attr("href", "#");
		}
		
	});
	result.fail(function( data ) {
		jQuery("#search_result").html("There is a problem in getting subcontractors ids");
	});
	
}

function RunTimerForRendering(doc_id, rev_id){    
	jQuery("#search_result").html("rendering result. please wait...");
	jQuery("#search_btn").attr("disabled", "disabled");
	jQuery("#export_btn").addClass("hide");
	jQuery("#export_btn").attr("href", "#");
	setTimeout(function(){render_running_late_result(doc_id, rev_id)},5000);
	
}

function render_running_late_result(doc_id, rev_id){
	//console.log(doc_id);
    				
	var url = SYSTEM_WIDE_REPORTING_PATH + "render_running_late_result/";
	var result = jQuery.post(
		url,{
			'doc_id' : doc_id,
			'rev_id' : rev_id,
		}
	);
	result.done(function(response) {
        if(response == 'continue'){
			RunTimerForRendering(doc_id, rev_id);
		}else{
			jQuery("#search_result").html(response);
			var current_date = jQuery('#date_start').attr("current_date");
			var date_search = jQuery('#date_start').val();
			
			jQuery("#search_btn").html("Search");
			jQuery("#search_btn").removeAttr("disabled");
			jQuery("#export_btn").removeClass("hide");
			jQuery("#export_btn").attr("href", SYSTEM_WIDE_REPORTING_PATH+"export_running_late/"+doc_id);
			
			/*
			if(current_date == date_search){
				jQuery('#timer').text("");
				var elapsed_seconds = 0;
				timerId = setInterval(function() {
					elapsed_seconds = elapsed_seconds + 1;
					jQuery('#timer').text(get_elapsed_time_string(elapsed_seconds));
				}, 1000);
				setTimeout(function(){update_couch_doccument_for_running_late_report(doc_id)},300000);	//300000 = 5mins, 10000 = 1min
			}
			*/
			
		}
	});
	result.fail(function( data ) {
		jQuery("#search_result").html("There is a problem in rendering result.");
	});
}

function update_couch_doccument_for_running_late_report(doc_id){
	
	jQuery("#search_result").html("Updating list.. Please wait");
	var url = SYSTEM_WIDE_REPORTING_PATH + "update_couch_doccument_for_running_late_report/";
	var result = jQuery.post(
		url,{
			'doc_id' : doc_id,
		}
	);
	result.done(function( data ) {
        jsonObject = jQuery.parseJSON(data);	
		console.log(jsonObject)		
		if(jsonObject.success){
			clearInterval(timerId);
			jQuery('#timer').text("");
			render_running_late_result(jsonObject.doc_id, jsonObject.rev_id)
		}else{
			jQuery("#search_result").html("There is a problem in updating couch document "+ doc_id);
		}
		
	});
	result.fail(function( data ) {
		jQuery("#search_result").html("There is a problem in updating couch document "+ doc_id);
	});
}

function get_elapsed_time_string(total_seconds) {
	function pretty_time_string(num) {
		return ( num < 10 ? "0" : "" ) + num;
	}
	
	var hours = Math.floor(total_seconds / 3600);
	total_seconds = total_seconds % 3600;
	
	var minutes = Math.floor(total_seconds / 60);
	total_seconds = total_seconds % 60;
	
	var seconds = Math.floor(total_seconds);
	
	// Pad the minutes and seconds with leading zeros, if required
	hours = pretty_time_string(hours);
	minutes = pretty_time_string(minutes);
	seconds = pretty_time_string(seconds);
	
	// Compose the string for display
	//var currentTimeString = hours + ":" + minutes + ":" + seconds;
	var currentTimeString = minutes + ":" + seconds; 
	return currentTimeString;
}