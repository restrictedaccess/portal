function SaveCurrencyRate(){
	var currency = jQuery("#currency").val();
	var currency_rate_in = jQuery("#currency_rate_in").val();
	var rate = jQuery("#rate").val();
	
	var query = {"currency": currency, "currency_rate_in" : currency_rate_in, "rate" : rate  };
	
	if(rate == ""){
		alert("Please enter "+currency+" to "+currency_rate_in+" rate.");
		return false;
	}
	
	if(isNaN(rate)){
		alert("Invalid rate: "+rate);
		return false;
	}
		
	if(rate <=0){
		alert("Rate must not be or below zero");
		return false;
	}
	//console.log(query);
	//return false;
	
	jQuery('#save_btn').html('saving...');
	jQuery('#save_btn').attr('disabled', 'disabled');
	
	var url = PORTAL_DJANGO + 'accounts/SaveCurrencyRate/';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			console.log(data);
			jQuery('#windowTitleDialog').modal({ 
				backdrop: 'static',
				keyboard: false
			});
			jQuery('#contract_result').html(data.msg);
			
			if(data.success == true){
				jQuery('#ok_btn').removeClass("hide");
				jQuery('#modal_body').removeClass("alert-danger");
				jQuery('#modal_body').addClass("alert-success");
				jQuery('#close_btn').removeClass("hide");
				//jQuery('#ok_btn').addClass("hide");
				
				//jQuery("#rate_"+data.currency).html(data.currency_rate_in+" "+data.rate);
				//jQuery("#rate").val("");
				jQuery('#close_btn').addClass("hide");
				jQuery('#ok_btn').attr("href", PORTAL_DJANGO+'accounts/currency_rates');
			}else{
				jQuery('#modal_body').removeClass("alert-success");
				jQuery('#modal_body').addClass("alert-danger");
				jQuery('#close_btn').removeClass("hide");
				jQuery('#ok_btn').addClass("hide");
			}
			jQuery('#save_btn').html('Save Changes');
			jQuery('#save_btn').removeAttr('disabled', 'disabled');
		},
		error: function(data) {
			alert("There's a problem in updating staff working schedule.");
			jQuery('#save_btn').html('Save Changes');
			jQuery('#save_btn').removeAttr('disabled', 'disabled');
		}
	});
}


function create_soa(){
	var leads_id = jQuery("#leads_id").val();
	var start_date = jQuery('#start_date').val();
	var end_date = jQuery('#end_date').val();
	
	if(!leads_id){
		alert("Please select a client.");
		return false;
	}
	
	var query = {"start_date": start_date, "end_date" : end_date, "leads_id" : leads_id  };
	console.log(query);
	//return false;
	jQuery('#search_btn').html("searching...");
	jQuery('#search_btn').attr('disabled', 'disabled');
	jQuery('#export_soa_btn').addClass("hide");
	
	var url = PORTAL_DJANGO + 'accounts/generate_soa/';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response){
			console.log(response);
			if(response.success){
				jQuery("#search_result").html(response.msg);
				render_soa_result(response);
			}else{
				jQuery("#search_result").html("<p class='alert alert-danger'>"+response.msg+"</p>");
				jQuery('#search_btn').html('Search');
				jQuery('#search_btn').removeAttr('disabled', 'disabled');	
			}
			
		},
		error: function(response) {
			alert("There's a problem in searching subconlist reporting.");
			jQuery('#search_btn').html('Search');
			jQuery('#search_btn').removeAttr('disabled', 'disabled');
		}
	});	
	
	
}




function RunTimerForRenderingSOA(obj){    
	setTimeout(function(){render_soa_result(obj)},5000);	
}

function render_soa_result(obj){
	jQuery.get(PORTAL_DJANGO + "accounts/render_soa/"+obj.doc_id, function(response){
		if(response == 'total_adj_hrs'){
			jQuery("#search_result").html("<pre>"+obj.msg + "<br>calculating total adjustment hours. please wait...</pre>");
			RunTimerForRenderingSOA(obj);
		}else{			
			jQuery("#search_result").html(response);
			jQuery("#search_btn").html("Search");
			jQuery("#search_btn").removeAttr("disabled");
			//jQuery('#export_soa_btn').removeClass("hide");
			//jQuery('#export_soa_btn').attr("href", "export_soa/"+doc_id);
		}
	})
}



function create_mass_soa(){

	var start_date = jQuery('#start_date').val();
	var end_date = jQuery('#end_date').val();
	

	var query = {"start_date": start_date, "end_date" : end_date  };
	//console.log(query);
	//return false;
	jQuery('#create_mass_soa_btn').html("generating...");
	jQuery('#create_mass_soa_btn').attr('disabled', 'disabled');
	jQuery("#search_result").html("Generating mongodb document for mass soa. Please wait.");
	
	var url = PORTAL_DJANGO + 'accounts/generate_mass_soa/';
	jQuery.ajax({
		type: "POST",
		url: url,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({ Query: query }),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(response){
			//console.log(response.success);
			
			if(response.success){
				jQuery("#search_result").html(response.msg);
				render_mass_soa_result(response.doc_id);	
			}else{
				jQuery("#search_result").html("<p class='alert alert-danger'>"+response.msg+"</p>");
				jQuery('#create_mass_soa_btn').html('Create');
				jQuery('#create_mass_soa_btn').removeAttr('disabled', 'disabled');	
			}
			
		},
		error: function(response) {
			alert("There's a problem in searching subconlist reporting.");
			jQuery('#create_mass_soa_btn').html('Create');
			jQuery('#create_mass_soa_btn').removeAttr('disabled', 'disabled');
		}
	});	
	
	
}


function RunTimerForRenderMassSoaResule(doc_id){    
	setTimeout(function(){render_mass_soa_result(doc_id)},5000);	
}


function render_mass_soa_result(doc_id){
	jQuery.get(PORTAL_DJANGO + "accounts/render_mass_soa_result/"+doc_id, function(response){
		response = jQuery.parseJSON(response);
		//console.log(response);
		if(response.status=='pending'){
			jQuery("#search_result").html(response.msg);
			RunTimerForRenderMassSoaResule(doc_id);
		}else{
			//check_busy();
			jQuery("#search_result").html(response.msg);
			jQuery('#create_mass_soa_btn').html('Create');
			jQuery('#create_mass_soa_btn').removeAttr('disabled', 'disabled');
		}
	})
}


function RunTimerForCheckBusy(){    
	setTimeout(function(){check_busy()},5000);	
}

function check_busy(){
	jQuery.get(PORTAL_DJANGO + "accounts/check_busy/", function(response){
		//console.log(response);
		response = jQuery.parseJSON(response);
		
		if(response.success){
			jQuery("#search_result").html(response.msg);
			jQuery('#create_mass_soa_btn').html("generating...");
			jQuery('#create_mass_soa_btn').attr('disabled', 'disabled');
			RunTimerForCheckBusy();
		}else{
			jQuery("#search_result").html(response.msg);
			jQuery('#create_mass_soa_btn').html("Create");
			jQuery('#create_mass_soa_btn').removeAttr('disabled', 'disabled');
		}
		
		
	})
}



