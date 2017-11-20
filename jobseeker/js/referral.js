function validateEmail(email){
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

jQuery(document).ready(function(){
	
	jQuery(".delete_referral").live("click", function(e){
		var answer = confirm("Do you want to delete this referral?")
		var me = jQuery(this);
		if (answer){
			jQuery.get(jQuery(this).attr("href"), function(response){
				response = jQuery.parseJSON(response);
				if (response.success){
					me.parent().parent().fadeOut(500, function(){
						jQuery(this).remove();
					});
				}
			})
		}
		e.preventDefault();
	})
	
	jQuery(".text-dropdown > li > a").click(function(e){
		jQuery(this).parent().parent().parent().children(".position").val(jQuery(this).attr("data-value"));
		e.preventDefault();
	})
	
	
	jQuery("#refer-friend").submit(function(e){
		var firstnames = jQuery(".first-name");
		var lastnames = jQuery(".lastname");
		var positions = jQuery(".position");
		var emailaddresses = jQuery(".emailaddress");
		var contactnumbers = jQuery(".contactnumber");
		var error = "";
		jQuery.each(firstnames, function(i, item){
			var firstname = jQuery(item).val();
			var lastname = jQuery(lastnames[i]).val();
			var position = jQuery(positions[i]).val();
			var emailaddress = jQuery(emailaddresses[i]).val();
			var contactnumber = jQuery(contactnumbers[i]).val();
			var errorFields = [];
			if ((jQuery.trim(firstname)!=""||jQuery.trim(lastname)!=""||jQuery.trim(position)!=""||(jQuery.trim(emailaddress)!=""||jQuery.trim(contactnumber)!=""))){
							
				if (!(jQuery.trim(firstname)!=""&&jQuery.trim(lastname)!=""&&jQuery.trim(position)!=""&&(jQuery.trim(emailaddress)!=""||jQuery.trim(contactnumber)!=""))){
					if (jQuery.trim(firstname)==""){
						errorFields.push("First Name");
					}
					if (jQuery.trim(lastname)==""){
						errorFields.push("Last Name");
					}
					if (jQuery.trim(position)==""){
						errorFields.push("Position");
					}
					if (jQuery.trim(emailaddress)==""){
						errorFields.push("Email Address");
					}
					if (jQuery.trim(contactnumber)==""){
						errorFields.push("Contact Number");
					}	
				}
			}
			

			if (errorFields.length>0){
				error+="Your referral for row "+(i+1)+" has missing required values: ["+errorFields.join(",")+"]\n\n";
			}
			
			if (jQuery.trim(emailaddress)!=""){
				if (!validateEmail(emailaddress)){
					error+="The email address you entered for row "+(i+1)+" is an invalid email.\n\n";
				}
			}
			
			
			
		})
		if (error!=""){	
			alert(error);
			e.preventDefault();	
			e.stopPropagation();
			return false;
		}else{
			var data = jQuery(this).serialize();
			jQuery.post("/portal/jobseeker/add_referral.php", data, function(response){
				response = jQuery.parseJSON(response);
				if (response.success){
					window.location.href = "/portal/jobseeker/refer_a_friend.php?success=1"
				}else{
					if (response.error!=undefined){
						alert(response.error);
					}
				}
			});
		}
		
		return false;
	})
})
