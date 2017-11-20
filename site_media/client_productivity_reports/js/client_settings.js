//var rsscRPC = "http://test.remotestaff.com.au/portal/django/client_subcon_management/jsonrpc/";
//var activityNotesRPC = "http://test.remotestaff.com.au/portal/client/ClientSubconManagementService.php";
//var ping = "http://test.remotestaff.com.au/portal/client/ClientSubconManagement20110902/ClientSubconManagement.html";
//var clientRPC = "http://test.remotestaff.com.au/portal/django/client_service/jsonrpc/"
var rsscRPC = "/portal/django/client_subcon_management/jsonrpc/";
var activityNotesRPC = "/portal/client/ClientSubconManagementService.php";
var ping = "/portal/client/ClientSubconManagement20110902/ClientSubconManagement.html";
var clientRPC = "/portal/django/client_service/jsonrpc/"

var loadedTimezones = [];
var selectedActivityNoteStatus = "";

jQuery(document).ready(function(){
	
	CURRENT_PAGE = "client_settings";
	
	jQuery("#subcon_userid").on("change", function(){
		var userid = jQuery(this).val();
		refreshIntervals(userid);
	})
	
	refreshSettings();
	
	
	
});


function refreshIntervals(userid){
	var data = {id:"ID14", jsonrpc:"2.0", method:"get_intervals", params:[userid]}
	jQuery.ajax({
	    url: activityNotesRPC,
	    type: 'POST',
	    data: JSON.stringify(data),
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    success: function(response) {
	    	jQuery(".change_screen_shot").attr("data-screenshot_interval", response.result.screenshot_interval);
	    	jQuery(".change_screen_shot").attr("data-userid", userid);
	    	jQuery(".change_activity_note").attr("data-activity_note_interval", response.result.activity_note_interval);
	    	jQuery(".change_activity_note").attr("data-userid", userid);
	    	
	    	jQuery(".change_screen_shot").removeAttr("disabled");
	    	jQuery(".change_activity_note").removeAttr("disabled");
	    	var screenshot_interval_text = "";
	    	if (response.result.screenshot_interval==180){
	    		screenshot_interval_text = "3 Minutes";
	    	}else if (response.result.screenshot_interval==300){
	    		screenshot_interval_text = "5 Minutes";
	    	}else if (response.result.screenshot_interval==600){
	    		screenshot_interval_text = "10 Minutes";
	    	}
	    	jQuery(".screenshot_interval_staff").html(screenshot_interval_text);
	    	
	    	var activity_interval_text = "";
	    	if (response.result.activity_note_interval==0){
	    		activity_interval_text = "Off";
	    	}else if (response.result.activity_note_interval==1200){
	    		activity_interval_text = "20 Minutes";
	    	}else if (response.result.activity_note_interval==1800){
	    		activity_interval_text = "30 Minutes";
	    	}else if (response.result.activity_note_interval==2700){
	    		activity_interval_text = "45 Minutes";
	    	}else if (response.result.activity_note_interval==3600){
	    		activity_interval_text = "1 Hour";
	    	}else if (response.result.activity_note_interval==5400){
	    		activity_interval_text = "1.5 Hour";
	    	}else if (response.result.activity_note_interval==7200){
	    		activity_interval_text = "2 Hours";
	    	}
	    	
	    	jQuery(".activity_notes_interval_staff").html(activity_interval_text);
	    	
	    }
	});
}

function refreshSettings(){
	var data = {id:"ID6", jsonrpc:"2.0", method:"get_activity_report_settings", params:[]}
	jQuery.ajax({
	    url: activityNotesRPC,
	    type: 'POST',
	    data: JSON.stringify(data),
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    success: function(response) {
	    	var output = "";
	    	
	    	var timezones = "";
	    	jQuery.each(response.result.timezone_lookup, function(i, item){
	    		timezones += "<option value='"+item.timezone+"'>"+item.timezone+"</option>";
	    	});
	    	loadedTimezones = response.result.timezone_lookup;
	    	
	    	jQuery("#updateActivityTimeSettingsTimezone").html(timezones);
	    	jQuery("#addActivityTimeSettings select[name=timezone]").html(timezones);
	    	
	    	
	    	selectedActivityNoteStatus = response.result.status;
	    	
	    	if (response.result.status == "ONE"){
		    	output = '<p>* Click <btn class="btn btn-xs btn-default add_individual_setting_change_recipient">HERE</btn> to add recipient.</p>';
	    		output += "<div class='col-lg-8 col-md-8'><table class='table table-bordered table-condensed table-hover'>";
	    		output += "<thead><tr><th>Email To</th><th>CC</th><th>Actions</th></tr></thead>";
	    		output += "<tbody>";
	    		jQuery.each(response.result.data, function(i, item){
	    			output += "<tr>";
	    			output += "<td>"+item.email+"</td>";
	    			if (item.cc&&item.cc!=undefined){
	    				output += "<td>"+item.cc+"</td>";
	    			}else{
		    			output += "<td>&nbsp;</td>";	    
		    			item.cc = "";				
	    			}
	    			
	    			output += "<td><button class='btn btn-xs btn-primary launch_edit_time_one' data-cc='"+item.cc+"' data-email='"+item.email+"' data-id='"+item.id+"'>Edit</button>&nbsp;<button class='btn btn-danger btn-xs delete_individual_setting' data-id='"+item.id+"'>Remove</button></td>";
	    			
	    			output += "</tr>";
	    		});
	    		output += "</tbody>";
	    		output += "</table></div>";
	    	
	    	}else if (response.result.status == "ALL"){
	    		output = '<p>* Click <btn class="btn btn-xs btn-default add_group_setting_change_recipient">HERE</btn> to add recipient.</p>';
	    		output += "<div class='col-lg-8 col-md-8'><table class='table table-bordered table-condensed table-hover'>";
	    		output += "<thead><tr><th>Email To</th><th>CC</th><th>Timezone</th><th>Time</th><th>Actions</th></tr></thead>";
	    		output += "<tbody>";
	    		jQuery.each(response.result.data, function(i, item){
	    			output += "<tr>";
	    			output += "<td>"+item.email+"</td>";
	    			if (item.cc&&item.cc!=undefined){
	    				output += "<td>"+item.cc+"</td>";
	    			}else{
		    			output += "<td>&nbsp;</td>";	    
		    			item.cc = "";				
	    			}
	    			output += "<td>"+item.client_timezone+"</td>";
	    			var hour = parseInt(item.hour);
	    			var minute = parseInt(item.minute);
	    			var ampm = "AM"
	    			if (hour>12){
	    				ampm = "PM";
	    				hour = hour%12;
	    			}else if (hour == 12){
	    				ampm = "PM";
	    			}else if (hour == 0){
	    				ampm = "AM";
	    				hour = 12;
	    			}
	    			
	    			if (hour < 12){
	    				hour = "0"+hour;
	    				
	    			}
	    			if (minute < 12){
	    				minute = "0"+minute;
	    			}
	    			
	    			output += "<td>"+hour+":"+minute+ampm+"</td>";
	    			output += "<td><button class='btn btn-xs btn-primary launch_edit_time_all' data-hour='"+item.hour+"' data-minute='"+item.minute+"' data-client_timezone='"+item.client_timezone+"' data-cc='"+item.cc+"' data-email='"+item.email+"' data-id='"+item.id+"'>Edit</button></td>";
	    			
	    			output += "</tr>";
	    		});
	    		output += "</tbody>";
	    		
	    		output += "</table></div>";

	    	}
	    	jQuery("#update_activity_note_div").html(output);
	    	jQuery("input[name=activity_note_report_settings]").each(function(){
	    		if (jQuery(this).val()==response.result.status){
	    			jQuery(this).attr("checked", "checked");	
	    		}
	    	});
	    }
	});
	
}

jQuery(document).on("click", ".delete_individual_setting", function(e){
	var id = jQuery(this).attr("data-id");
	var ans = confirm("Are you sure you want to delete this setting?");
	if (ans){
		var data = {id:"ID11", jsonrpc:"2.0", method:"del_activity_note_setting", params:[id]}
		jQuery.ajax({
		    url: activityNotesRPC,
		    type: 'POST',
		    data: JSON.stringify(data),
		    contentType: 'application/json; charset=utf-8',
		    dataType: 'json',
		    success: function(response) {
		    	alert("Settings has been successfully deleted.");
		    	refreshSettings();
		    }
	    });
	}
});

jQuery(document).on("click", "input[name=activity_note_report_settings]", function(e){
	var selected = jQuery(this).val();
	var ans = "";
	if (selected=="ONE"){
		ans = confirm("This will change your settings to 'Send Individual Activity\nTracker Notes when Sub-Contractor finishes work'.\nAre you sure you want to continue?")
	}else if (selected=="NONE"){
		ans = confirm("This will change your settings to 'Send Group Activity Notes Daily'.\nAre you sure you want to continue?")
	}else{
		ans = confirm("This will remove all your settings on 'Send Group Activity Notes Daily'.\nAre you sure you want to continue?")
	}
	if (ans){
		var data = {id:"ID19", jsonrpc:"2.0", method:"set_activity_note_setting", params:[selected]}
		jQuery.ajax({
		    url: activityNotesRPC,
		    type: 'POST',
		    data: JSON.stringify(data),
		    contentType: 'application/json; charset=utf-8',
		    dataType: 'json',
		    success: function(response) {
		    	alert("Settings has been successfully updated.");
		    	refreshSettings();
		    }
	    });
	}else{
		e.preventDefault();
	}
})

jQuery(document).on("click", ".launch_edit_time_all", function(e){
	var hour = jQuery(this).attr("data-hour");
	var minute = jQuery(this).attr("data-minute");
	var ampm = "am"
	if (hour>12){
		ampm = "pm";
		hour = hour%12;
	}else if (hour == 12){
		ampm = "pm";
	}else if (hour == 0){
		ampm = "am";
		hour = 12;
	}
	
	if (hour < 12){
		hour = "0"+hour;
	}
	if (minute < 12){
		minute = "0"+minute;
	}
	
	
	jQuery("#updateActivityTimeSettingsID").val(jQuery(this).attr("data-id"));
	jQuery("#updateActivityTimeSettingsHour").val(hour);
	jQuery("#updateActivityTimeSettingsMinute").val(minute);
	jQuery("#updateActivityTimeSettingsAMPM").val(ampm);
	jQuery("#updateActivityTimeSettingsTimezone").val(jQuery(this).attr("data-client_timezone"));
	jQuery("#updateActivityTimeSettingsCC").val(jQuery(this).attr("data-cc"));
	jQuery("#updateActivityTimeSettingsEmail").val(jQuery(this).attr("data-email"));
	jQuery("#updateActivityTimeSettingsID").val(jQuery(this).attr("data-id"));
	jQuery("#updateActivityTimeSettings").modal({keyboard:false, backdrop:"static"})
	
})
jQuery(document).on("click", ".launch_edit_time_one", function(e){
	jQuery("#updateActivityTimeSettingsONECC").val(jQuery(this).attr("data-cc"));
	jQuery("#updateActivityTimeSettingsONEEmail").val(jQuery(this).attr("data-email"));
	jQuery("#updateActivityTimeSettingsONEID").val(jQuery(this).attr("data-id"));
	jQuery("#updateActivityTimeSettingsONE").modal({keyboard:false, backdrop:"static"});
});

jQuery(document).on("click", ".add_group_setting_change_recipient", function(e){
	jQuery("#addActivityTimeSettings").modal({keyboard:false, backdrop:"static"})
	jQuery("#addActivityTimeSettings input, #addActivityTimeSettings select[name=timezone]").val("");
	jQuery("#addActivityTimeSettings select[name=timezone]").val("Australia/Sydney");
	
});

jQuery(document).on("click", ".add_individual_setting_change_recipient", function(e){
	jQuery("#addActivityTimeSettingsONE").modal({keyboard:false, backdrop:"static"})
	jQuery("#addActivityTimeSettingsONE input").val("");
})

jQuery(document).on("click", "#addActivityTimeSettingsButton", function(e){
	var hour = jQuery("#addActivityTimeSettingsHour").val();
	var minute = jQuery("#addActivityTimeSettingsMinute").val();
	var ampm = jQuery("#addActivityTimeSettingsAMPM").val();
	
	var timezone = jQuery("#addActivityTimeSettingsTimezone").val();
	var timezone_id = 0;
	jQuery.each(loadedTimezones, function(i, item){
		if (item.timezone==timezone){
			timezone_id = item.id;
		}
	});
	
	if (hour.charAt(0)=="0"&&hour.length==2){
		hour = parseInt(hour.charAt(1));
	}else{
		hour = parseInt(hour);
	}
	
	if (minute.charAt(0)=="0"&&minute.length==2){
		minute = parseInt(minute.charAt(1));
	}else{
		minute = parseInt(minute);
	}
	
	
	if (hour==12&&ampm=="am"){
		hour = 0;
	}else if (ampm=="pm"){
		hour = hour + 12;
	}
	
	
	var email = jQuery("#addActivityTimeSettingsEmail").val();
	var cc = jQuery("#addActivityTimeSettingsCC").val();
	
	var me = jQuery(this);
	me.attr("disabled", "disabled");
	var data = {id:"ID9", jsonrpc:"2.0", method:"add_recepient_all", params:[email, cc, timezone_id, hour, minute]}
	jQuery.ajax({
	    url: activityNotesRPC,
	    type: 'POST',
	    data: JSON.stringify(data),
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    success: function(response) {
	   		me.removeAttr("disabled");
	   		alert("Recipient has been successfully added.");
	   		jQuery("#addActivityTimeSettings").modal("hide");
	   		refreshSettings();
	    }
	});
	   
});

jQuery(document).on("click", "#updateActivityTimeSettingsButton", function(e){
	var hour = jQuery("#updateActivityTimeSettingsHour").val();
	var minute = jQuery("#updateActivityTimeSettingsMinute").val();
	var ampm = jQuery("#updateActivityTimeSettingsAMPM").val();
	
	var timezone = jQuery("#updateActivityTimeSettingsTimezone").val();
	var timezone_id = 0;
	jQuery.each(loadedTimezones, function(i, item){
		if (item.timezone==timezone){
			timezone_id = item.id;
		}
	});
	
	if (hour.charAt(0)=="0"&&hour.length==2){
		hour = parseInt(hour.charAt(1));
	}else{
		hour = parseInt(hour);
	}
	
	if (minute.charAt(0)=="0"&&minute.length==2){
		minute = parseInt(minute.charAt(1));
	}else{
		minute = parseInt(minute);
	}
	
	
	if (hour==12&&ampm=="am"){
		hour = 0;
	}else if (ampm=="pm"){
		hour = hour + 12;
	}
	
	
	var email = jQuery("#updateActivityTimeSettingsEmail").val();
	var cc = jQuery("#updateActivityTimeSettingsCC").val();
	var id = jQuery("#updateActivityTimeSettingsID").val();
	
	var me = jQuery(this);
	me.attr("disabled", "disabled");
	var data = {id:"ID9", jsonrpc:"2.0", method:"edit_recepient_all", params:[id, email, cc, timezone_id, hour, minute]}
	jQuery.ajax({
	    url: activityNotesRPC,
	    type: 'POST',
	    data: JSON.stringify(data),
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    success: function(response) {
	   		me.removeAttr("disabled");
	   		alert("Recipient has been successfully updated.");
	   		jQuery("#updateActivityTimeSettings").modal("hide");
	   		refreshSettings();
	    }
	});
	   
	
});

jQuery(document).on("click", "#addActivityTimeSettingsONEButton", function(e){
	
	var email = jQuery("#addActivityTimeSettingsONEEmail").val();
	var cc = jQuery("#addActivityTimeSettingsONECC").val();
	
	var me = jQuery(this);
	me.attr("disabled", "disabled");
	var data = {id:"ID23", jsonrpc:"2.0", method:"add_recepient_one", params:[email, cc]}
	jQuery.ajax({
	    url: activityNotesRPC,
	    type: 'POST',
	    data: JSON.stringify(data),
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    success: function(response) {
	   		me.removeAttr("disabled");
	   		alert("Recipient has been successfully added.");
	   		jQuery("#addActivityTimeSettingsONE").modal("hide");
	   		refreshSettings();
	    }
	});
	   
	
});

jQuery(document).on("click", "#updateActivityTimeSettingsONEButton", function(e){
	
	var email = jQuery("#updateActivityTimeSettingsONEEmail").val();
	var cc = jQuery("#updateActivityTimeSettingsONECC").val();
	var id = jQuery("#updateActivityTimeSettingsONEID").val();
	
	var me = jQuery(this);
	me.attr("disabled", "disabled");
	var data = {id:"ID7", jsonrpc:"2.0", method:"edit_recepient_one", params:[id, email, cc]}
	jQuery.ajax({
	    url: activityNotesRPC,
	    type: 'POST',
	    data: JSON.stringify(data),
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    success: function(response) {
	   		me.removeAttr("disabled");
	   		alert("Recipient has been successfully updated.");
	   		jQuery("#updateActivityTimeSettingsONE").modal("hide");
	   		refreshSettings();
	    }
	});
});


jQuery(document).on("click", ".change_activity_note", function(e){
	jQuery("#updateActivityNoteIndividual").modal({keyboard:false, backdrop:"static"});
	jQuery("#selectActivityNotesInterval").val(jQuery(this).attr('data-activity_note_interval'));
	jQuery("#selectActivityNotesID").val(jQuery(this).attr('data-userid'));
	e.preventDefault();
});

jQuery(document).on("click", ".change_screen_shot", function(e){
	jQuery("#updateScreenshotIndividual").modal({keyboard:false, backdrop:"static"});
	jQuery("#updateScreenshotIndividualInterval").val(jQuery(this).attr('data-screenshot_interval'));
	jQuery("#updateScreenshotIndividualID").val(jQuery(this).attr('data-userid'));
	e.preventDefault();
});

jQuery(document).on("click", ".unified_settings_launcher", function(e){
	jQuery("#setUnifiedSettings").modal({keyboard:false, backdrop:"static"});
	jQuery("#setUnifiedSettingsScreenshotInterval").val("180");
	jQuery("#setUnifiedSettingsActivityNotesInterval").val("1200");
	jQuery("#")
	e.preventDefault();
});

jQuery(document).on("click", "#updateScreenshotIndividualButton", function(e){
	var userid = jQuery("#updateScreenshotIndividualID").val();
	var interval = jQuery("#updateScreenshotIndividualInterval").val();
	var data = {id:"ID15", jsonrpc:"2.0", method:"set_screenshot_interval", params:[userid, interval]}
	var me = jQuery(this);
	me.attr('disabled', "disabled")
	jQuery.ajax({
	    url: activityNotesRPC,
	    type: 'POST',
	    data: JSON.stringify(data),
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    success: function(response) {
	   		me.removeAttr("disabled");
	   		alert("Settings has been updated");
	   		jQuery("#updateScreenshotIndividual").modal("hide");
	   		refreshIntervals(userid);
	    }
	});
});

jQuery(document).on("click", "#updateActivityNoteIndividualButton", function(e){
	var userid = jQuery("#selectActivityNotesID").val();
	var interval = jQuery("#selectActivityNotesInterval").val();
	var data = {id:"ID17", jsonrpc:"2.0", method:"set_activity_note_interval", params:[userid, interval]}
	var me = jQuery(this);
	me.attr('disabled', "disabled")
	jQuery.ajax({
	    url: activityNotesRPC,
	    type: 'POST',
	    data: JSON.stringify(data),
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    success: function(response) {
	   		me.removeAttr("disabled");
	   		alert("Settings has been updated");
	   		jQuery("#updateActivityNoteIndividual").modal("hide");
	   		refreshIntervals(userid);
	    }
	});
});

jQuery(document).on("click", "#setUnifiedSettingsButton", function(e){
	var interval1 = jQuery("#setUnifiedSettingsActivityNotesInterval").val();
	var interval2 = jQuery("#setUnifiedSettingsScreenshotInterval").val();
	
	var data = {id:"ID19", jsonrpc:"2.0", method:"set_unified_intervals", params:[interval2, interval1]}
	var me = jQuery(this);
	me.attr('disabled', "disabled")
	jQuery.ajax({
	    url: activityNotesRPC,
	    type: 'POST',
	    data: JSON.stringify(data),
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    success: function(response) {
	   		me.removeAttr("disabled");
	   		alert("Settings has been updated");
	   		jQuery("#setUnifiedSettings").modal("hide");
	   		window.location.reload();
	    }
	});
});
