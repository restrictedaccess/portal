jQuery(document).ready(function() {
	jQuery(window).load(function (e) {
		//console.log(window.location.pathname);									  
	});
	
	AdminHomeQuickView();
	
});

function get_leave_request_summary_report(){
	
	var url = "/portal/system_wide_reporting/get_leave_request_summary_report.php"
	var url_link = "/portal/leave_request/admin/show_leave_request_summary_details.php"
	jQuery.ajax({
		url: url,
		type: 'GET',
		//data: JSON.stringify(data),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json',
		success: function(response) {
			//console.log(response)
			/*
			var output = "<p>Total no. of request per year</p><ul>";	
			jQuery.each(response.data, function(i, item){
				//console.log(i+' => '+item.year);
				output += "<li>";					
				output += item.year;
				output += ' : ';
				output += "<a target='_blank' href='"+url_link+"?summary_type=total per year&year="+item.year+"'>";
				output += item.total;
				output += "</a>";
				output += "</li>";
			});
			output += "</ul>";
			
			output += "<p>Received Today : <a target='_blank' href='"+url_link+"?summary_type=current'>"+response.current_day_total+"</a></p>";
			output += "<p>On Leave Today : <a target='_blank' href='"+url_link+"?summary_type=on leave today'>"+response.on_leave_today_total+"</a></p>";
			jQuery("#leave_request_summary_container").html(output);
			*/
			
			var output = "";
			output += "<p>Approve Leave for Today (excluding inhouse staff) : <a target='_blank' href='"+url_link+"?summary_type=today&status=approved&inhouse=no'>"+response.total_no_approved_leave_excluding_inhouse_staff+"</a></p>";
			output += "<p>Approve Leave for Today Inhouse : <a target='_blank' href='"+url_link+"?summary_type=today&status=approved&inhouse=yes'>"+response.total_no_approved_leave_inhouse_staff+"</a></p>";
			output += "<p>Marked Absent Today : <a target='_blank' href='"+url_link+"?summary_type=today&status=absent'>"+response.total_no_approved_marked_absent+"</a></p>";
			jQuery("#leave_request_summary_container").html(output);
			
		}
	});
	
}
function AdminHomeQuickView(){
	
	var url = "/portal/django/system_wide_reporting/rssc_working_staff/"
	//console.log(clientRPC);
	var data = "admin home";
	jQuery.ajax({
		url: url,
		type: 'POST',
		data: JSON.stringify(data),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json',
		success: function(response) {
			var output = "";
			//console.log(response.counter.working);	
			jQuery.each(response.counter, function(i, item){
				//console.log(i+' => '+item);			
				output += "<li>";					
				output += i.replace("_"," ");
				output += ' : ';
				output += '<a target="_blank" href="/portal/django/system_wide_reporting/view_status/'+i+'">';
				output += item;
				output += '</a>';
				output += "</li>";
			});
			jQuery("#rssc_working_staff ul").html(output);
			get_leave_request_summary_report();
		}
	});
	
}