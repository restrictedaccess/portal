var staff_api_php_rpc = "http://localhost/portal-local/staff_api_service/staff_api_service.php";
var loadedTimesheets = [];

jQuery(document).ready(function(){
	console.log(window.location.pathname);
	CURRENT_PAGE = "timesheet";
	getTimesheets();
	
	jQuery("#timesheet_month").on("change", function(){
		refreshTimesheetStaff();
	});
})

function getTimesheets(){
	var data = {json_rpc:"2.0", id:"ID1", method:"get_timesheets", params:[]};
	jQuery.ajax({
		url: staff_api_php_rpc,
		type: 'POST',
		data: JSON.stringify(data),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json',
		success: function(response) {
			loadedTimesheets = response.result;
			var options = [];
			var me = jQuery(this);
			jQuery.each(loadedTimesheets, function(i, item){
					options.push(item);
			});
			var output = "";
			jQuery.each(options, function(j, item){
				output += "<option value='"+item.id+"'>"+item.item+"</option>";
			})
			jQuery("#timesheet_month").html(output);
			var lastItem = options[options.length-1];
			jQuery("#timesheet_month").val(lastItem.id);
			refreshTimesheetStaff();
		}
		
		
	});
}


function refreshTimesheetStaff(){
	var id = jQuery("#timesheet_month").val();
	var data = {json_rpc:"2.0", id:"ID9", method:"get_timesheet_by_id", params:[id]};
	jQuery("#timesheet_table tbody").html('<tr><td colspan=\'13\' align="center"><small>Loading Timesheet</small></td></tr>')
	jQuery("#grand_total_hrs").html("0");
	jQuery("#grand_total_adj_hrs").html("0");
	jQuery("#grand_total_hrs_charged_to_client").html("0");
	jQuery("#grand_total_reg_ros_hrs").html("0");
	jQuery("#grand_total_diff_charged_to_client").html("0");
	jQuery("#grand_total_lunch_hrs").html("0");
	
	jQuery.ajax({
		    url: rsscRPC,
		    type: 'POST',
		    data: JSON.stringify(data),
		    contentType: 'application/json; charset=utf-8',
		    dataType: 'json',
		    success: function(response) {
		    	var output = "";
		    	jQuery.each(response.result.timesheet_details, function(i, item){
		    		output += "<tr>";
		    			output += "<td>"+item.day+"</td>";
		    			output += "<td>"+item.date+"</td>";
		    			output += "<td>";
		    			jQuery.each(item.time_in, function(j, time){
		    				output+=time+"<br/>";
		    			});
		    			output += "</td>";
		    			output += "<td>";
		    			
		    			jQuery.each(item.time_out, function(j, time){
		    				output+=time+"<br/>";
		    			});
		    			output += "</td>";
		    			output += "<td>"+item.total_hrs+"</td>";
		    			output += "<td>"+item.adjusted_hrs+"</td>";
		    			output += "<td>"+item.regular_rostered_hrs+"</td>";
		    			output += "<td>"+item.hrs_charged_to_client+"</td>";
		    			output += "<td>"+item.diff_charged_to_client+"</td>";
		    			output += "<td>"+item.lunch_hours+"</td>";
		    			output += "<td>";
		    			jQuery.each(item.lunch_in, function(j, time){
		    				output+=time+"<br/>";
		    			});
		    			output += "</td>";
		    			output += "<td>";
		    			jQuery.each(item.lunch_out, function(j, time){
		    				output+=time+"<br/>";
		    			});
		    			output += "</td>";
		    			output += "<td>";
		    			jQuery.each(item.notes, function(j, note){
		    				output+=note.note+"<br/>";
		    			});
		    			output += "</td>";
		    			
		    		output += "</tr>";
		    	});
		    	jQuery("#timesheet_table tbody").html(output);
		    	jQuery("#assigned_timezone").html(response.result.timezone);
		    	jQuery("#grand_total_hrs").html(response.result.timesheet_totals.grand_total_hrs);
				jQuery("#grand_total_adj_hrs").html(response.result.timesheet_totals.grand_total_adj_hrs);
				jQuery("#grand_total_hrs_charged_to_client").html(response.result.timesheet_totals.grand_total_hrs_charged_to_client);
				jQuery("#grand_total_reg_ros_hrs").html(response.result.timesheet_totals.grand_total_reg_ros_hrs);
				jQuery("#grand_total_diff_charged_to_client").html(response.result.timesheet_totals.grand_total_diff_charged_to_client);
				jQuery("#grand_total_lunch_hrs").html(response.result.timesheet_totals.grand_total_lunch_hrs);
	
		    	
			}
	});
}
