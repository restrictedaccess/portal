

jQuery(document).ready(function(){
	
	jQuery("#sign_in_via_fb").click(function(e){
		FB.login(function(response) {
			if (response.authResponse) {
				FB.api('/me', function(info) {
					login(response, info);
				});
			} else {
				//user cancelled login or did not grant authorization
					
			}
		}, {scope:'email,user_birthday,status_update,publish_stream,user_about_me'});
		e.preventDefault();
	})
})

