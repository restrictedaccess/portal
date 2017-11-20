//var rsscRPC = "https://remotestaff.com.au/portal/django/client_subcon_management/jsonrpc/";
//var activityNotesRPC = "https://remotestaff.com.au/portal/client/ClientSubconManagementService.php";
//var ping = "https://remotestaff.com.au/portal/client/ClientSubconManagement20110902/ClientSubconManagement.html";
//var clientRPC = "http://test.remotestaff.com.au/portal/django/client_service/jsonrpc/"
var rsscRPC = "/portal/django/client_subcon_management/jsonrpc/";
var activityNotesRPC = "/portal/client/ClientSubconManagementService.php";
var ping = "/portal/client/ClientSubconManagement20110902/ClientSubconManagement.html";
var clientRPC = "/portal/django/client_service/jsonrpc/"
jQuery(document).ready(function(){
	 //add highlight for productivity
    CURRENT_PAGE = "activity_notes";
    
    jQuery("#productivity_reports_top").addClass("active");
	
	var today = jQuery("#subcon_date_picker_from").val();
  jQuery("#subcon_date_picker_from").datepicker();
  jQuery("#subcon_date_picker_from").datepicker("option", "dateFormat", "yy-mm-dd");
  jQuery("#subcon_date_picker_from").datepicker("setDate", jQuery.datepicker.parseDate("yy-mm-dd", today));
  jQuery("#subcon_date_picker_to").datepicker();
  jQuery("#subcon_date_picker_to").datepicker("option", "dateFormat", "yy-mm-dd");
  jQuery("#subcon_date_picker_to").datepicker("setDate", jQuery.datepicker.parseDate("yy-mm-dd", today));

	
	jQuery("#load_form").on("submit", function(){
		return false;
	})
	jQuery("#view_activity_notes").on("click", function(e){
		refreshActivityNotes();
	//	e.preventDefault();
	});
	
	jQuery(".next_activity, .prev_activity").on("click", function(e){
		refreshActivityNotes(jQuery(this).attr("data-value"));
		e.preventDefault();
	})

	jQuery("#main_footer").hide();
	
	jQuery(".next_activity").hide();
	jQuery(".prev_activity").hide();
});

jQuery(document).on("click", ".send_selected_staff", function(e){
	var userid = jQuery("#subcon_userid").val();
	
	if (!userid){
		alert("Please select a staff");
		return;
	}
	
	var from = jQuery("#subcon_date_picker_from").val();
	var to = jQuery("#subcon_date_picker_to").val();
	var data = {json_rpc:"2.0", id:"ID10", method:"send_report", params:[from, to, userid]};
	
	jQuery.ajax({
	    url: activityNotesRPC,
	    type: 'POST',
	    data: JSON.stringify(data),
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    success: function(response) {
	    	alert("Activity Notes has been sent to your email.");
	    }
	 });
	
	e.preventDefault();
});

jQuery(document).on("click", ".send_all_staff", function(e){	
	var from = jQuery("#subcon_date_picker_from").val();
	var to = jQuery("#subcon_date_picker_to").val();
	var data = {json_rpc:"2.0", id:"ID10", method:"send_report", params:[from, to, "ALL"]};
	
	jQuery.ajax({
	    url: activityNotesRPC,
	    type: 'POST',
	    data: JSON.stringify(data),
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    success: function(response) {
	    	alert("Activity Notes has been sent to your email.");
	    }
	 });
	
	e.preventDefault();
});


function refreshActivityNotes(next_page){
	if (next_page==undefined||!next_page){
		next_page = 0;
	}
	
	var userid = jQuery("#subcon_userid").val();
	var from = jQuery("#subcon_date_picker_from").val();
	var to = jQuery("#subcon_date_picker_to").val();
	
	if (jQuery.trim(userid)==""){
		alert("Please select staff to view.");
		return;
	}
	
	if (jQuery.trim(from)==""){
		alert("Please select date from to view.");
		return;
	}

	if (jQuery.trim(to)==""){
		alert("Please select date to to view.");
		return;
	}
	
	var data = {json_rpc:"2.0", id:"ID10", method:"get_activity_notes", params:[from, to, next_page, userid]};
	jQuery("#activity_notes_body").html('<div class="alert alert-info">Loading Activity Notes</div>');	  
		    	
	if (userid){
		jQuery.ajax({
		    url: activityNotesRPC,
		    type: 'POST',
		    data: JSON.stringify(data),
		    contentType: 'application/json; charset=utf-8',
		    dataType: 'json',
		    success: function(response) {
		    	var output = "";
		    	var sender = "";
		    	if (response.result.return_notes.length > 0){
		    		
		    		sender = '<div class="row regular_sender"><button class="btn btn-primary send_selected_staff"><i class="glyphicon glyphicon-envelope"></i> Send Selected Staff Activity Notes</button> <button class="btn btn-primary send_all_staff"><i class="glyphicon glyphicon-envelope"></i> Send All Staff Activity Notes</button></div><div class="mobile_sender"><button class="btn btn-primary send_selected_staff"><i class="glyphicon glyphicon-envelope"></i> Send Selected Staff Activity Notes</button> <button class="btn btn-primary send_all_staff"><i class="glyphicon glyphicon-envelope"></i> Send All Staff Activity Notes</button></div>';
		    		
		    		
		    		output += "<table class='table table-bordered table-hover table-striped'>"
		    		output += "<thead><tr><th>Date/Time</th><th>Notes</th></tr></thead><tbody>"
		    		var notes = response.result.return_notes.reverse();
			    	jQuery.each(notes, function(i, item){
			    		output += "<tr>";
			    		output += "<td width='20%'>"+item.date+" "+item.time+"</td>";
			    		output += "<td>"+item.note+"</td>";
			    		output += "</tr>";
			    	});
			    	
			    	output += "</tbody></table>";
			    	jQuery("#activity_notes_body").html(output)	    	
			    	
			    	if (response.result.next){
			    		jQuery(".next_activity").attr("data-value", response.result.next).show();
			    	}else{
			    		jQuery(".next_activity").hide();
			    	}
			    	if (response.result.prev){
			    		jQuery(".prev_activity").attr("data-value", response.result.prev).show();
			    	}else{
			    		jQuery(".prev_activity").hide();
			    	}
			    	
		    	}else{
		    		jQuery("#activity_notes_body").html('<div class="alert alert-info">There is no activity notes for the staff.</div>');	  
		    		sender = '<div class="row regular_sender"><button class="btn btn-primary send_selected_staff"><i class="glyphicon glyphicon-envelope"></i> Send Selected Staff Activity Notes</button> <button class="btn btn-primary send_all_staff"><i class="glyphicon glyphicon-envelope"></i> Send All Staff Activity Notes</button></div><div class="mobile_sender"><button class="btn btn-primary send_selected_staff"><i class="glyphicon glyphicon-envelope"></i> Send Selected Staff Activity Notes</button> <button class="btn btn-primary send_all_staff"><i class="glyphicon glyphicon-envelope"></i> Send All Staff Activity Notes</button></div>';
		    		
		    	}
		    	
		    	jQuery("#activity_sender").html(sender);
		    	
		    }
		    
		})		
	}

	
}