jQuery(document).ready(function(){
	jQuery("#password_form").submit(function(){
		jQuery.post("/portal/application/set_password.php", jQuery(this).serialize(), function(response){
			response = jQuery.parseJSON(response);
			
			if (response.success){
				if (response.redirect!=null){
					window.location.href = response.redirect;					
				}else{
					window.location.href = "/portal/jobseeker/";
				}
			
			}else{
				alert(response.error)
			}
		});
		return false;
	})
});

