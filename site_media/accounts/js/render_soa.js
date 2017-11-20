jQuery(document).ready(function() {			   
	jQuery(window).load(function (e) {
		console.log(window.location.pathname);	
		
	});
	jQuery(".cal-input").each(function () {
		var id = jQuery(this).attr("id");
		var target = jQuery(this).attr("id");
		Calendar.setup({
		   inputField : target,
		   trigger    : id,
		   onSelect   : function() { this.hide();   },
		   fdow  : 0,
		   dateFormat : "%Y-%m-%d"
		});
	});
	jQuery('.others-btn').removeAttr('disabled', 'disabled');
	
	jQuery('.delete-others').click(function(e) {
		e.preventDefault();
		delete_other_charges(this);
	});
	
	
	
	
	jQuery("#other-charges-form").on( "submit", function( event ) {
		event.preventDefault();	
		
		jQuery('#error-msg').addClass("hide");
		var formData = jQuery(this).serialize();
		var amount = jQuery('#other-charges-amount').val().replace(/\s+/g, '');
		var description = jQuery("#other-charged-description").val().replace(/\s+/g, '');
		//console.log(formData);
		
		var error_msg="";
		
		if(amount == "" || parseFloat(amount) <= 0){
			error_msg += "<p>Amount cannot be empty.</p>";
		}
		
		if(isNaN(amount)){
			error_msg += "<p>Amount ["+amount+"] is not a valid number.</p>";
		}
		
		if(description == ""){
			error_msg += "<p>Please type other charges description.</p>";
		}
		
		
		if(error_msg){
			jQuery('#error-msg').removeClass("alert-info");
			jQuery('#error-msg').addClass("alert-danger");
			jQuery('#error-msg').html(error_msg);
			jQuery('#error-msg').removeClass("hide");			
			return false;
		}
				
		jQuery('#add-other-charges-btn').html('adding...');
		jQuery('.others-btn').attr('disabled', 'disabled');
		
		jQuery.post(PORTAL_DJANGO + "accounts/add_other_charges/", formData, function(data){
			data = jQuery.parseJSON(data);
			console.log(data);
			if(data.success){
				jQuery('#error-msg').html("Successfuly added.");
				jQuery('#error-msg').addClass("alert-info");
				jQuery('#error-msg').removeClass("hide");
				jQuery("#other-charges-form").trigger('reset'); //jquery
				
				getOtherCharges();
			}
			jQuery('#add-other-charges-btn').html('Add');
			jQuery('.others-btn').removeAttr('disabled', 'disabled');
		});
		
		
	});
	
});


function delete_other_charges(obj){
	var index = jQuery(obj).attr("data-index");
	var doc_id = jQuery(obj).attr("data-doc-id");
	
	jQuery.post(PORTAL_DJANGO + "accounts/delete_other_charges/", { doc_id : doc_id, index : index }, function(data){
		data = jQuery.parseJSON(data);
		//console.log(data);
		//if(data.success){
		getOtherCharges();
		//}
	});
}


function getOtherCharges(){
	var doc_id = jQuery('#doc_id').val();
	//console.log(doc_id);
	var url = 	PORTAL_DJANGO + "accounts/get_other_charges/";
	jQuery.ajax({
		url : url,
		type : "POST",
		data: { doc_id : doc_id },
		dataType : 'json',
		success : function(response) {
			var output="";
			if(response.success){
				if(response.data.length > 0){
					var output="<tr><td colspan='11'><strong>Other Charges</strong></td></tr>";
				}
				jQuery.each(response.data, function(i, other) {
					output += "<tr>";
						output += "<td>";
							output += other.charged_date;
						output += "</td>";
						output += "<td colspan='9'>";
							output += "<span class='pull-right'><a href='#' class='delete-others' data-index='"+other.counter+"' data-doc-id='"+ doc_id+"'>delete</a></span>";
							output += other.charged_description;
							
						output += "</td>";
						output += "<td class='numeric'>";
							output += other.charged_amount;
						output += "</td>";
					output += "</tr>";
				});
				if(response.data.length > 0){
					output +="<tr><td>&nbsp;</td><td colspan='9'>&nbsp;</td><td class='numeric total_charges'>"+response.total_other_charges_amount+"</td></tr>";
				}
				jQuery('#soa_table tfoot').html(output);
			}
			jQuery('.delete-others').click(function(e) {
				e.preventDefault();
				delete_other_charges(this);
			});
			
		},
		error : function(response) {
			getOtherCharges()
		}
	});
}