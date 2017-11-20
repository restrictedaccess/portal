jQuery(document).ready(function() {
	CURRENT_PAGE = "accepted_service_agreement";
	jQuery(window).load(function (e) {
		console.log('Load clients accepted service agreements');
		var leads_id = jQuery('#leads_id').val();
		GetClientServiceAgreements(leads_id);
	});
});

function GetClientServiceAgreements(leads_id){
	console.log('django process starts here...');
    var clientRPC = "/portal/django/client_service/jsonrpc/"
	//console.log(clientRPC);
	var data = {"jsonrpc":"2.0","id":"ID1","method":"client_service_agreements","params":[leads_id]}
	jQuery.ajax({
		url: clientRPC,
		type: 'POST',
		data: JSON.stringify(data),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json',
		success: function(response) {
			var output = "";
			//console.log(response.result);			
			var attachments = response.result.attachments;
			jQuery.each(attachments, function(i, item){
				//console.log(item.service_agreement_id+' '+item.filename+' '+item.att_id+' '+item.date_time);			
				output += "<li>";					
				output += '<a target="_blank" href="/portal/django/client_service/get_sample_couch/'+item.att_id+'">'+item.filename+'</a><br>';	
				output += 'Date Accepted : '+item.date_time+' Asia/Manila<br>';
				output += 'Date Version   : '+item.date_time+' Asia/Manila<br>';
				output += 'Service Agreement Id : '+item.service_agreement_id;
				output += "</li>";
			});
			
			jQuery("#accepted_service_agreements ol").html(output);
		}
	});
}