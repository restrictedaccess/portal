jQuery(document).ready(function() {
	jQuery(window).load(function (e) {
								  
		var leads_id = jQuery('#leads_id').val();
		jQuery.get(PATH+"filled_jos.php?leads_id="+leads_id, function(response){
			//response = jQuery.parseJSON(response);
			//console.log(response);
			jQuery('#filled_jos').html(response);
			//if (response.success){
			//	jQuery('#filled_jos').html(response);
			//}
		})
		
		GetClientServiceAgreements(leads_id);
		get_leads_skill_assessment_request(leads_id);
	});
	

});

function get_leads_skill_assessment_request(leads_id){
	var APIURL = jQuery("#API-URL").val();
	console.log(APIURL);
	//return false;
	jQuery.ajax({
		url : APIURL+"/skill-assessment/get-leads-skill-assessment-request?id="+leads_id,
		type : "GET",
		dataType : 'json',
		success : function(response) {
			console.log(response);
				output = "";
			jQuery.each(response.data, function(i, item){
						
				output += "<tr bgColor='#FFF'>";	
				output += "<td>"+item.date_created+"</td>";
				output += "<td>";
				jQuery.each(item.selected_skills, function(s, skill){
					output += skill+", ";
				});
				output += "</td>";				
				output += "<td>"+item.candidate_id+"</td>";				
				output += "</tr>";
			});
			
			jQuery("#requested_skill_assessment table tbody").html(output);
		},
		error : function() {
			get_leads_skill_assessment_request(leads_id);
		}
	});
	
}

function GetClientServiceAgreements(leads_id){
	console.log('django backend process starts...');
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
				output += 'Service Agreement Id : '+item.service_agreement_id+'<br>';
				output += 'Quote Id : '+item.quote_id+'<br>';
				output += 'Date Accepted : '+item.date_time+' Asia/Manila<br>';
				output += 'Date Created : '+item.date_created+' Asia/Manila<br>';
				output += "</li>";
			});
			
			jQuery("#service_agreements ol").html(output);
		}
	});
}