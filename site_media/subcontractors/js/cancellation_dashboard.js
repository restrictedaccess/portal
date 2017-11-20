function get_cancellation_dashboard_results(){
	var n=0
	jQuery('#cancellation_report tr').each(function(e){

		var start_date = jQuery(this).attr('start_date');
		var end_date = jQuery(this).attr('end_date');
		var counter = jQuery(this).attr('counter');
		var business_partner_id = jQuery('#business_partner_id').val();
		var hiring_coordinator_id = jQuery('#hiring_coordinator_id').val();
		var csro_id = jQuery('#csro_id').val();
		var recruiter_id = jQuery('#recruiter_id').val();
		var work_status = jQuery('#work_status').val();
		var reason_type = jQuery('#reason_type').val();
		var service_type = jQuery('#service_type').val();
		var include_inhouse_staff = jQuery('#include_inhouse_staff').val();
			 
			 
			 
		if(start_date){
			jQuery.ajaxq ("testqueue", {
				url: PATH + 'get_cancellation_dashboard_results/',
				type: 'post',
				cache: false,
				data: {start_date: start_date, end_date: end_date, business_partner_id: business_partner_id, hiring_coordinator_id:hiring_coordinator_id, csro_id:csro_id, recruiter_id:recruiter_id, work_status:work_status, reason_type:reason_type, service_type:service_type, include_inhouse_staff:include_inhouse_staff},
                contentType: "application/json; charset=utf-8",
  		        dataType: "json",				
				success: function(response){
					jQuery('.num_count_resigned_'+counter).html(response.num_count_resigned);
					jQuery('.num_count_terminated_'+counter).html(response.num_count_terminated);
					jQuery('.num_count_replacement_request_'+counter).html(response.num_count_replacement_request);
					jQuery('.num_count_no_replacement_request_'+counter).html(response.num_count_no_replacement_request);
					jQuery('.total_contract_cancelled_'+counter).html(response.total_contract_cancelled);
					jQuery('.total_contract_ended_'+counter).html(response.total_contract_ended);
				}
			});
		}
	});
}

function DisableAcctStatus(e){
	var subcon_id = jQuery(e).attr('subcon_id');
	if(confirm("Disable account status?")){
		var query = {"subcon_id": subcon_id};
		console.log(query);
		jQuery(e).html("disabling...");
		jQuery(e).attr('disabled', 'disabled');
		var url = PATH + 'DisableAcctStatus/';
		jQuery.ajax({
			type: "POST",
			url: url,
			// The key needs to match your method's input parameter (case-sensitive).
			data: JSON.stringify({ Query: query }),
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(data){
				//console.log(data.msg);
				
				if(data.success){
					alert('Account status disabled.')
					jQuery(e).html("Account Disabled");
				    jQuery(e).attr('disabled', 'disabled');	
				}else{
					jQuery(e).html('Disable');
					jQuery(e).removeAttr('disabled', 'disabled');
				}
			},
			error: function(data) {
				alert("There's a problem in disabling account status.");
				jQuery(e).html('Disable');
				jQuery(e).removeAttr('disabled', 'disabled');
			}
		});
	}
}