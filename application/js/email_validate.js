
jQuery(document).ready(function(){
	function postOnFeed(){
		FB.api('/me/feed', 'post',
			{
			message     : "Registered as a Work From Home Professional with RemoteStaff.com.ph - Apply Now",
			link        : 'http://remotestaff.com.ph',
			picture     : 'http://www.remotestaff.com.ph/images/remote-staff-logo.jpg',
			name        : 'Remote Staff',
			description : 'Work for foreign companies in a relaxed and more flexible workplace - your own home and get the salary you deserve'
			},
			function(response) {
				if (!response || response.error) {
				} else {
				}
			}
		);
		
	}
	
	
	function login(response, info){
	    if (response.authResponse) {
	        var accessToken = response.authResponse.accessToken;
			FB.api("/me", function(info){
				
			})
	    }
	}
 
	
	
	function updateButton(response){
		var button = document.getElementById('fb-auth');
		var userInfo = document.getElementById('user-info');
		if (response.authResponse){
			FB.api("/me", function(info){
				login(response, info);
			})
		}else{
			//user is not connected to your app or logged out
		}
	}
	window.fbAsyncInit = function(){
		FB.init({
			appId:'423675957728278',
			status:true,
			cookie:true,
			xfbml:true,
			oauth:true,
		})
		
		FB.getLoginStatus(updateButton);
		FB.Event.subscribe('auth.statusChange', updateButton);
	}
	
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

