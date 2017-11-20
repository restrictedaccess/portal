
jQuery(document).ready(function() {
	jQuery(".form-leads").on( "submit", function(e) {
		e.preventDefault();
		validateForm(this);		
	});
});
function validateForm(e){
	var form = jQuery(e);
	//console.log(form);
	var formData = form.serialize();	
	//console.log(formData);
	
	var name = form.find('input[name=name]').val();
	// var fname = form.find('input[name=fname]').val();
	// var lname = form.find('input[name=lname]').val();
	var email = form.find('input[name=email]').val();
	var mobile= form.find('input[name=mobile]').val();
	
	name.split(' ');
	var fname = name.split(' ').slice(0, -1).join(' ');
	var lname = name.split(' ').slice(-1).join(' ');
	
	var response_field = form.find('input[name=response_field]').val();
	var registered_in = form.find('input[name=registered_in]').val();
	var error_msg = "";
	
	
	// if(fname == ""){
		// error_msg += "First name is required.\n";
	// }
// 	
	// if(lname == ""){
		// error_msg += "Last name is required.\n";
	// }
	
	
	// if(email == ""){
		// error_msg += "Email address is required.\n";
	// }
	
	if(mobile == ""){
		error_msg += "Your contact number is required.\n";
	}
	
	if(response_field == ""){
		error_msg += "Please verify the number inside the form.\n";
	}
	
	if(registered_in == "skill assessment"){
		var num = jQuery('.selected-skills').length;
		if(num == 0){
			error_msg += "Please select at least one category skill.\n";
		}
	}
	
	if(error_msg){
		alert(error_msg);
		return false;
	}
	
	form.find('button[name=btn-save]').attr('disabled', 'disabled');
	
	jQuery.post("/remotestaff_2015/request_callback/validate-form.php", formData, function(data){
		response = jQuery.parseJSON(data);
		if(response.success){
			console.log(response);
			save_leads(e);
		}else{
			form.find('button[name=btn-save]').removeAttr('disabled');
			var output="";
			jQuery.each(response.errors, function(i, error){
				output += error+"\n";
			});			
			alert(output);
		}
	});
	
}


function save_leads(e){
	
	var form = jQuery(e);
	var formData = form.serialize();
	var API_BASE_URL = jQuery("#base_api_url").val();
	var url_site = jQuery("#url_link").val();
	jQuery.ajax({
		url : API_BASE_URL+"/registration/save-leads-info-from-home-site",
		type : "POST",
		data : formData,
		dataType : 'json',
		success : function(response) {
			console.log(response);
			if(response.success){
				//location.href="";
				jQuery.post("/remotestaff_2015/request_callback/session-config.php", {leads_id : response.leads_id, leads_new_info_id : response.leads_new_info_id, leads_name: response.name, leads_email: response.email, leads_mobile: response.mobile, is_generated_email: response.is_generated_email}, function(data){
					data = jQuery.parseJSON(data);
					//console.log(data);
					if(data.success){
						var ref = document.referrer;
						if (window.location.href.indexOf("asl") > -1) { 
							window.top.location.href = url_site+"/../thankyou.php";
							location.href=url_site+"/../thankyou.php";
						}else{
							window.top.location.href =url_site+"/thankyou.php"; 
							location.href=url_site+"/thankyou.php";
						}
						
						
					}
				});
				
			}else{
				alert("There's a problem in processing registration.");
				
			}
		},
		error : function() {
			//save_leads(e);
		}
	});
	
}
