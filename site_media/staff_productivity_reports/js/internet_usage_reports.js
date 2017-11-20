jQuery(document).ready(function(){
	Calendar.setup({
		   inputField : "subcon_date_picker_from",
		   trigger    : "subcon_date_picker_from",
		   onSelect   : function() { this.hide()  },
		   fdow  : 0,
		   dateFormat : "%Y-%m-%d"
 	});
	
	Calendar.setup({
		   inputField : "subcon_date_picker_to",
		   trigger    : "subcon_date_picker_to",
		   onSelect   : function() { this.hide()  },
		   fdow  : 0,
		   dateFormat : "%Y-%m-%d"
 	});
	
	jQuery("#view_activity_notes").on("click", function(e){
		refreshInternetUsageReport();
	});


	
});

function refreshInternetUsageReport(){
	
	var from = jQuery("#subcon_date_picker_from").val();
	var to = jQuery("#subcon_date_picker_to").val();
	
	var from_timestamp = new Date(from).getTime();
	var to_timestamp = new Date(to).getTime();
	
	if (from_timestamp>to_timestamp){
		alert("Date From should be less than or equal to Date To");
		return false;
	}
	
	
	var data = {json_rpc:"2.0", id:"ID5", method:"get_average_speed_test", params:[from, to]};
	jQuery("#internet_usage_reports_body").html('<div class="alert alert-info">Loading Internet Usage Reports</div>');	  
	

	jQuery.ajax({
		url: STAFF_SERVICE_RPC,
		type: 'POST',
		data: JSON.stringify(data),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json',
		success: function(response) {
			var output = '<p>&nbsp;</p><div class="row table-responsive"><table class="table table-bordered table-condensed" style="border-color:#000;border-collapse:collapse"><thead><tr><th>Date/Time</th><th>Direction</th><th>Speed</th></tr></thead><tbody>';
			
			jQuery.each(response.result, function(i, item){
				output += "<tr>";
				output += "<td>"+item.date_speed+"</td>";
				output += "<td>"+item.mode+"</td>";
				output += "<td>"+item.speed+"</td>";
				output += "</tr>";
			});
			output += "</tbody></table></div>";	
			jQuery("#internet_usage_reports_body").html(output);		
		}
	 });
	 
	 return false;
	
}