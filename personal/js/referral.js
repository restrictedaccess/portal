function validateEmail(email){
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

jQuery(document).ready(function(){
	jQuery(".add-referral").click(function(e){
		var firstnames = jQuery(".first-name");
		var lastnames = jQuery(".lastname");
		var positions = jQuery(".currentposition");
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
		}
	});
	
	
	jQuery(".delete-referral").live("click", function(e){
		var answer = confirm("Do you want to delete this referral?");
		if (answer){
			var id  = jQuery(this).attr("data-id");
			var me = jQuery(this);
			jQuery.post("/portal/personal/processreferrals.php", {action:"delete", id:id}, function(data){
				data = jQuery.parseJSON(data);
				me.parent().parent("tr").fadeOut(200, function(){
					jQuery(this).remove();
				});
				e.preventDefault();
			});			
		}

		
		e.preventDefault();
	});
});

