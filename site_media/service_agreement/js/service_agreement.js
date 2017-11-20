jQuery(document).ready(function() {
	jQuery(window).load(function (e) {
		console.log(window.location.pathname);
	});	
});

function remove_service_agreement(obj){
	var service_agreement_id = jQuery(obj).attr('service_agreement_id');
	
	if(confirm("Remove this?")){
		
		var url = PORTAL_DJANGO + 'service_agreement/remove_service_agreement/';
		var result = jQuery.post(
			url,{
				'service_agreement_id' : service_agreement_id,
			}
		);
		result.done(function( data ) {
			jsonObject = jQuery.parseJSON(data)
			//console.log(jsonObject);
			jQuery("#sa_quote_display").html(jsonObject.msg);
			get_leads_service_agreements()
			
		});
		result.fail(function( data ) {
			alert("There is a problem in removing service agreement. Please contact devs team.");
		});
	}
}

function delete_service_agreement_details(details_id){
	if(confirm("Remove this detail ?")){
		
		var url = PORTAL_DJANGO + 'service_agreement/delete_service_agreement_details/';
		var result = jQuery.post(
			url,{
				'details_id' : details_id,
			}
		);
		result.done(function( data ) {
			jsonObject = jQuery.parseJSON(data)
			console.log(jsonObject);
			if(jsonObject.msg == 'ok'){
				show_service_agreement(jsonObject.id)
			}else{
				alert("There is a problem in removing service agreement details. Please contact devs team.");
			}
			
		});
		result.fail(function( data ) {
			alert("There is a problem in removing service agreement details. Please contact devs team.");
		});
	}
	
}
function update_service_agreement_details(){
	var details_id = jQuery('#details_id').val();
	var details = jQuery('#sa_details').val();
	
	jQuery("#btn_update").attr("disabled", "disabled");
	jQuery("#btn_update").html("updating...");
	
	var url = PORTAL_DJANGO + 'service_agreement/update_service_agreement_details/';
	var result = jQuery.post(
		url,{
			'details_id' : details_id,
			'details' : details
		}
	);
	
	result.done(function( data ) {
	 	jsonObject = jQuery.parseJSON(data)
		console.log(jsonObject);
		if(jsonObject.msg == 'ok'){
			show_service_agreement(jsonObject.id)
		}else{
			alert("There is a problem in updating service agreement details. Please contact devs team.");
		}
		
	});
	result.fail(function( data ) {
		alert("There is a problem in updating service agreement details. Please contact devs team.");
	});
	
}
function get_service_agreement_details(details_id){
	jQuery('#service_agreement_details_edit_form').addClass('hide');
	var url = PORTAL_DJANGO + "service_agreement/get_service_agreement_details/"+details_id;
	var result = jQuery.get(url);
	result.done(function( data ) {
		jQuery('#service_agreement_details_edit_form').removeClass('hide');				 
		//console.log(data);				 
		jQuery('#service_agreement_details_edit_form').html(data);
		
		
		jQuery("#btn_update").click(function(e){		
			update_service_agreement_details();
		});
		
		jQuery("#btn_cancel").click(function(e){		
			jQuery('#service_agreement_details_edit_form').addClass('hide');
		});
		
	});
	result.fail(function( data ) {
		console.log(data);
	});
}
function create_service_agreement(obj){
	var quote_id = jQuery(obj).attr('quote_id');
	var query = {"quote_id" : quote_id};
	
	//console.log(query);
	
	jQuery(".set_as_sa").attr("disabled", "disabled");
	jQuery(".set_as_sa").html("creating...");
	
	var url = PORTAL_DJANGO + 'service_agreement/create_service_agreement/';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			//console.log(data)
			if(data.msg == 'ok'){
				show_service_agreement(data.service_agreement_id);
				get_leads_service_agreements();
			}else{
				alert("There's a problem in creating service agreement. Please contact devs team.");	
			}
		},
		error: function(data) {
			alert("There's a problem in creating service agreement. Please contact devs team.");
		}
	});
	
}

function show_quote(id){
	var url = PORTAL_DJANGO + "service_agreement/show_quote/"+id;
	var result = jQuery.get(url);
	result.done(function( data ) {
		jQuery("#sa_quote_display").html(data);
		jQuery(".set_as_sa").click(function(e){				  
			create_service_agreement(this);
		});		
	});
	result.fail(function( data ) {
		jQuery("#sa_quote_display").html(data);
	});
}

function show_service_agreement(id){
	var url = PORTAL_DJANGO + "service_agreement/show_service_agreement/"+id;
	var result = jQuery.get(url);
	result.done(function( data ) {
		jQuery("#sa_quote_display").html(data);
		
		jQuery('.remove_sa').click(function(e){
			remove_service_agreement(this);										 
		});
		jQuery(".btn_edit").click(function(e){		
			var details_id = jQuery(this).attr("details_id");										   
			get_service_agreement_details(details_id);
		});
		
		jQuery(".btn_delete").click(function(e){		
			var details_id = jQuery(this).attr("details_id");										   
			delete_service_agreement_details(details_id);
		});		
	});
	result.fail(function( data ) {
		jQuery("#sa_quote_display").html(data);
	});
}

function show_quote_service_agreement(obj){
	var mode = jQuery(obj).attr('mode');
	if(mode == 'quote'){
		var id= jQuery(obj).attr('quote_id');
		show_quote(id);
	}else if(mode == 'service_agreement'){
		var id= jQuery(obj).attr('service_agreement_id');
		show_service_agreement(id)
	}else{
		console.log("Unknown mode");
		return false;
	}
}
function search_leads(){
	var keyword = jQuery("#keyword").val();
	var url = PORTAL_DJANGO + "service_agreement/search_leads/";
	var result = jQuery.post(
		url,{
			'keyword' : keyword,
		}
	);
	
	result.done(function( data ) {
		jQuery("#search_result").html(data);
	});
	result.fail(function( data ) {
		jQuery("#search_result").html(data);
	});
}
function get_leads_service_agreements(){
	var leads_id= jQuery("#leads_id").val();
	console.log("get_leads_service_agreement => " + leads_id);
	
	var url = PORTAL_DJANGO + "service_agreement/get_leads_service_agreements/"+leads_id;
	var result = jQuery.get(url);
	
	result.done(function( data ) {
		jQuery("#sa_quote_container").html(data);
		jQuery(".details").click(function(e){				  
			show_quote_service_agreement(this);
		});
		
		
	});
	result.fail(function( data ) {
		jQuery("#sa_quote_container").html(data);
	});
}