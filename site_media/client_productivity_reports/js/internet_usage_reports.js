//var rsscRPC = "http://test.remotestaff.com.au/portal/django/client_subcon_management/jsonrpc/";
//var activityNotesRPC = "https://remotestaff.com.au/portal/client/ClientSubconManagementService.php";
//var ping = "https://remotestaff.com.au/portal/client/ClientSubconManagement20110902/ClientSubconManagement.html";
//var clientRPC = "http://test.remotestaff.com.au/portal/django/client_service/jsonrpc/"
var rsscRPC = "/portal/django/client_subcon_management/jsonrpc/";
var activityNotesRPC = "/portal/client/ClientSubconManagementService.php";
var ping = "/portal/client/ClientSubconManagement20110902/ClientSubconManagement.html";
var clientRPC = "/portal/django/client_service/jsonrpc/"

jQuery(document).ready(function(){
	  var today = jQuery("#subcon_date_picker_from").val();
	  jQuery("#subcon_date_picker_from").datepicker();
	  jQuery("#subcon_date_picker_from").datepicker("option", "dateFormat", "yy-mm-dd");
	  jQuery("#subcon_date_picker_from").datepicker("setDate", jQuery.datepicker.parseDate("yy-mm-dd", today));
	  jQuery("#subcon_date_picker_to").datepicker();
	  jQuery("#subcon_date_picker_to").datepicker("option", "dateFormat", "yy-mm-dd");
	  jQuery("#subcon_date_picker_to").datepicker("setDate", jQuery.datepicker.parseDate("yy-mm-dd", today));

	jQuery("#load_form").on("submit", function(){
		refreshInternetUsageReport();
		return false;
	});

	
});

function refreshInternetUsageReport(){
	
	var userid = jQuery("#subcon_userid").val();
	var from = jQuery("#subcon_date_picker_from").val();
	var to = jQuery("#subcon_date_picker_to").val();
	
	var data = {json_rpc:"2.0", id:"ID5", method:"get_average_speed_test", params:[userid, from, to]};
	jQuery("#internet_usage_reports_body").html('<div class="alert alert-info">Loading Internet Usage Reports</div>');	  
	
	if (userid){
		jQuery.ajax({
		    url: rsscRPC,
		    type: 'POST',
		    data: JSON.stringify(data),
		    contentType: 'application/json; charset=utf-8',
		    dataType: 'json',
		    success: function(response) {
		    	var output = '<div class="row regular_productivity_header"><h4>Average Speed Test</h4></div>';
		    	output += '<div class="row"><strong>Average Download</strong> '+response.result.average_download+" Mbps<br/>";
		    	output += '<strong>Average Upload</strong> '+response.result.average_upload+" Mbps</div>";
		    	if (typeof response.result.data != "undefined" && response.result.data.length > 0){
			    	output += '<div class="row table-responsive"><table class="table table-bordered table-condensed" style="border-color:#000;border-collapse:collapse"><thead><tr><th>Date/Time</th><th>Direction</th><th>Speed</th></tr></thead><tbody>';
			    	jQuery.each(response.result.data, function(i, item){
			    		output += "<tr>";
			    		output += "<td>"+item[0]+"</td>";
			    		output += "<td>"+item[1]+"</td>";
			    		output += "<td>"+item[2]+"</td>";
			    		output += "</tr>";
			    	});
			    	output += "</tbody></table></div>";	
		    	}
		    	
		    	jQuery("#internet_usage_reports_body").html(output);
		    }
		 });
	}else{
		alert("Please select staff to view internet usage.");
	}
}