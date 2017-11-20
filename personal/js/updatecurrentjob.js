function validateEmail(email){
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}


jQuery(document).ready(function(){
	jQuery(".add-new-work").click(function(){
		if (jQuery(".applyform").length<=10){
			jQuery.get("/portal/personal/addworktemplate.php", function(data){
				jQuery(data).appendTo(jQuery("#resultarea")).hide().fadeIn(100);
			});	
		}else{
			alert("Only 10 work history is allowed");
		}
	})
	
	jQuery(".delete-character-reference").live("click", function(e){
		jQuery(this).parent().parent().parent().parent().parent().parent().fadeOut(200, function(){
			jQuery(this).remove();
		});
		e.preventDefault();
	})
	
	
	jQuery("#add-character-button").live("click", function(e){
		jQuery.get("/portal/personal/blank_character_reference.php", function(data){
			jQuery(data).appendTo(jQuery("#container"));
		})
		e.preventDefault();
	});
	
	jQuery("#currentjob_form").live("submit", function(e){
		var names = jQuery(".name");
		var contact_details = jQuery(".contact_details");
		var email_addresses = jQuery(".email_address");
		var contact_numbers = jQuery(".contact_number");
		var invalidFields = false;
		var completeFields = 0;
		var emailFieldInvalid = false;
		jQuery.each(names, function(i, item){
			if (jQuery(names[i]).val()!=""
				&&jQuery(contact_details[i]).val()!=""
				&&jQuery(email_addresses[i]).val()!=""
				&&jQuery(contact_numbers[i]).val()!=""){
				if (jQuery(email_addresses[i]).val()!=""&&!validateEmail(jQuery(email_addresses[i]).val())){
					emailFieldInvalid = true;
				}else{
					completeFields++;	
				}
				
			}else{
				if (!(jQuery(names[i]).val()==""
					&&jQuery(contact_details[i]).val()==""
					&&jQuery(email_addresses[i]).val()==""
					&&jQuery(contact_numbers[i]).val()=="")){
					invalidFields = true;
				}else{
					if (jQuery(email_addresses[i]).val()!=""&&!validateEmail(jQuery(email_addresses[i]).val())){
						emailFieldInvalid = true;
					}
				}
			}
		});
		if (emailFieldInvalid){
			alert("One of the character references' email is invalid.");
			e.preventDefault();			
			e.stopPropagation();
			return false;
		}
	
		
		if (invalidFields){
			alert("One of the character reference is not complete.");
			e.preventDefault();
			return false;
		}
		if (completeFields==0){
			alert("At least one character reference is required.");
			e.preventDefault();
			return false;
		}
		return true;
	});
	
});