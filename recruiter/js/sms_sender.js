var hasRequest = false;
jQuery(document).ready(function(){
	jQuery("#sms_messenger").submit(function(e) {
		if (!hasRequest){
			hasRequest = true;
			jQuery.post("/portal/recruiter/sms_send.php", jQuery(this).serialize(), function(response){
				response = jQuery.parseJSON(response);
				if (response.success){
					alert("Message Sent");
					window.close();
				}else{
					alert(response.error);
				}
			});
			return false;			
		}

	});
	

});
