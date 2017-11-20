function validateEmail(email){
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

jQuery(document).ready(function(){
	jQuery(".popup").click(function(e){
		popup_win7(jQuery(this).attr("href"), 950, 600);
		e.preventDefault();
	})
	
	
	jQuery(".remove_character_reference").live("click", function(e){
		jQuery(this).parent().parent().fadeOut(100, function(){
			jQuery(this).remove();
		})
		e.preventDefault();
		e.stopPropagation();
	})
	
	jQuery("#add_new_character_reference").click(function(e){
		jQuery.get("/portal/jobseeker/empty_character_reference.php", function(data){
			jQuery(data).appendTo(jQuery("#character_references"));
		})
		e.preventDefault();
		e.stopPropagation();
	})
	
	jQuery("#current-job-form").submit(function(e){
		var names = jQuery(".name");
		var contact_details = jQuery(".contact_details");
		var email_addresses = jQuery(".email_address");
		var contact_numbers = jQuery(".contact_number");
		var invalidFields = false;
		var completeFields = 0;
		var emailFieldInvalid = false;
		jQuery.each(names, function(i, item){
			if (jQuery(names[i]).val()!=""
				&&jQuery(email_addresses[i]).val()!=""
				&&jQuery(contact_numbers[i]).val()!=""){
				if (jQuery(email_addresses[i]).val()!=""&&!validateEmail(jQuery(email_addresses[i]).val())){
					emailFieldInvalid = true;
				}else{
					completeFields++;	
				}
				
			}else{
				if (!(jQuery(names[i]).val()!=""
					&&jQuery(email_addresses[i]).val()!=""
					&&jQuery(contact_numbers[i]).val()!="")){
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
	
	jQuery(".industry").on("change", function(){
		var me = jQuery(this);
		if (me.val()=="10"){
			jQuery("#campaign_"+jQuery(this).attr("data-index")).show().find("input").val("");
		}else{
			jQuery("#campaign_"+jQuery(this).attr("data-index")).hide().find("input").val("");
			
		}
	});
	
	$('textarea').summernote({
	  toolbar: [
	    //[groupname, [button list]]
	    ['style', ['bold', 'italic', 'underline']],
	    ['fontsize', ['fontsize']],
	    ['para', ['ul', 'ol', 'paragraph']],
	  ],
	  height:200
	});
	
});
