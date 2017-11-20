
jQuery(document).ready(function() {
	jQuery(window).load(function (e) {
		console.log(window.location.pathname);
		jQuery("#export_btn").attr("disabled", "disabled");
		
		check_search_options();
		
		
	});
	Calendar.setup({
			inputField : "date_start",
			trigger    : "date_start_icon",
			onSelect   : function() { this.hide()  },
			//showTime   : 12,
			fdow  : 0,
			dateFormat : "%Y-%m-%d"

	});
	
	Calendar.setup({
			inputField : "date_finished",
			trigger    : "date_finished_icon",
			onSelect   : function() { this.hide()  },
			//showTime   : 12,
			fdow  : 0,
			dateFormat : "%Y-%m-%d"

	});
	
	jQuery("#search_btn").click(function(e){
		e.preventDefault();	
		search_attendance_report();
		
	});
	
	jQuery("#search_option").change(function(){
		check_search_options();		
	});
	
});

function check_search_options(){
	jQuery("#userid").addClass("hide");
	jQuery("#leads_id").addClass("hide");
	jQuery("#csro_id").addClass("hide");
	
	var search_option = jQuery('#search_option').val();
    //var result = new Array();	
	if(search_option == 'client'){
		jQuery("#leads_id").removeClass("hide");
		var search_by = 'client';
		var search_id = jQuery("#leads_id").val();
	}
	
	if(search_option == 'csro'){
		jQuery("#csro_id").removeClass("hide");
		var search_by = 'csro';
		var search_id = jQuery("#csro_id").val();
	}
	
	if(search_option == 'staff'){
		jQuery("#userid").removeClass("hide");
		var search_by = 'userid';
		var search_id = jQuery("#userid").val();
	}
	var result = {'search_by' : search_by , 'search_id' : search_id}
	return result;
}


function search_attendance_report(){
	var date_start = jQuery('#date_start').val();
	var date_finished = jQuery('#date_finished').val();
	var userid = 0;
	var leads_id = 0;
	var csro_id = 0;
	
	var search_options = check_search_options();
	console.log(search_options.search_by);
	//return false;
	if(search_options.search_by == 'client'){
		var leads_id = search_options.search_id;
	}
	
	if(search_options.search_by == 'csro'){
		var csro_id = search_options.search_id;
	}
	
	
	if(search_options.search_by == 'userid'){
		var userid = search_options.search_id;
	}
	
		
	var work_status = jQuery('#work_status').val();
	var flexi = jQuery('#flexi').val();
	var login_type = jQuery('#login_type').val();
	
	
	var url = SYSTEM_WIDE_REPORTING_PATH + "search_attendance_report/";
	var result = jQuery.post(
		url,{
			'date_start' : date_start,
			'date_finished' :  date_finished, 
			'userid' : userid,
			'leads_id' : leads_id,
			'csro_id' : csro_id,
			'work_status' : work_status,
			'flexi' : flexi,
			'login_type' : login_type,
		}
	);
	
	jQuery("#search_btn").html("searching...");
	jQuery("#search_result").html("searching...");
	jQuery("#search_btn").attr("disabled", "disabled");
	jQuery("#export_btn").attr("disabled", "disabled");
	jQuery("#export_btn").attr("href", "#");
	result.done(function( data ) {
        jsonObject = jQuery.parseJSON(data);	
		console.log(jsonObject)
		
		if(jsonObject.success){
			render_search_result(jsonObject.doc_id)
		}else{
			jQuery("#search_btn").html("Search");
			jQuery("#search_btn").removeAttr("disabled");
			jQuery("#search_result").html("There is a problem in getting subcontractors ids");
			jQuery("#export_btn").attr("disabled", "disabled");
			jQuery("#export_btn").attr("href", "#");
		}
		
	});
	result.fail(function( data ) {
		jQuery("#search_btn").html("Search");
		jQuery("#search_btn").removeAttr("disabled");
		jQuery("#search_result").html("There is a problem in getting subcontractors ids");
		jQuery("#export_btn").attr("disabled", "disabled");
		jQuery("#export_btn").attr("href", "#");
	});
}




function RunTimerForRendering(doc_id){   
	//jQuery("#search_result").html("rendering result. please wait...");
	setTimeout(function(){render_search_result(doc_id)},5000);
}

function render_search_result(doc_id){
	//console.log(doc_id);
	//var arr = ["compliance", "Pete", 8, "John" ];
	jQuery.get(SYSTEM_WIDE_REPORTING_PATH + "render_attendance_report_search_result/"+doc_id, function(response){
		if(response == 'compliance'){
			jQuery("#search_result").html("generating compliance result...");
			RunTimerForRendering(doc_id);
		}else if(response == 'subcon_adj_hrs_result'){
			jQuery("#search_result").html("calculating adjusted hours result...");
			RunTimerForRendering(doc_id);
		}else if(response == 'subcon_log_hrs_result'){
			jQuery("#search_result").html("calculating log hours result...");
			RunTimerForRendering(doc_id);
		}else if(response == 'result'){
			jQuery("#search_result").html("generating attendance report...");
			RunTimerForRendering(doc_id);	
		}else{
			jQuery("#search_result").html(response);
			jQuery("#search_btn").html("Search");
			jQuery("#search_btn").removeAttr("disabled");
			jQuery("#export_btn").removeAttr("disabled");
			jQuery("#export_btn").attr("href", SYSTEM_WIDE_REPORTING_PATH+"export_attendance_report/"+doc_id);
		}
	})
}