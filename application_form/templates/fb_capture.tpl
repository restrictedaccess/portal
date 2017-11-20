<!DOCTYPE html>
<html>
	<head>
		<script src="../js/jquery.js" type="text/javascript"></script>
	</head>
	<body>
		Loading... Please wait...
	<input type="hidden" name="mobile_number" id="mobile_number" value="{$mobile_number}"/>
	<input type="hidden" name="email" id="email" value="{$email}"/>
	
	{if $TEST}
		{literal}
			<script type="text/javascript">
				var baseUrl = "http://test.remotestaff.com.au";
			</script>
		{/literal}
	{else}
			<script type="text/javascript">
				var baseUrl = "http://remotestaff.com.au";
			</script>
	{/if}
	
	{literal}
	<div id="fb-root"></div>
	<script type="text/javascript">
		(function() {
		var e = document.createElement('script'); e.async = true;
		e.src = document.location.protocol
		+ '//connect.facebook.net/en_US/all.js';
		document.getElementById('fb-root').appendChild(e);
		}());
		
		function updateButton(response){
			FB.login(function(response) {
				if (response.authResponse) {
					FB.api('/me', function(info) {
						login(response, info);
					});
				} else {
					//user cancelled login or did not grant authorization
						
				}
			}, {scope:'email,user_birthday,status_update,publish_stream,user_about_me'});
				
				
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
		
		function login(response, info){
		    if (response.authResponse) {
		        var accessToken = response.authResponse.accessToken;
		        var picture = "https://graph.facebook.com/"+info.id+"/picture?type=large";
		     
				FB.api("/me", function(info){
					info.picture = picture
					info.mobile_number = jQuery("#mobile_number").val();
					info.email = jQuery("#email").val();
					var query = FB.Data.query('select current_location, work, relationship_status,education from user where uid={0}', info.id);
		            query.wait(function(rows) {
		            	row = rows[0];
		            	info.current_location = row.current_location
		            	info.work = row.work
		            	info.relationship_status = row.relationship_status
		            	info.education = row.education
		            	jQuery.post("/portal/application/fb_grab_data.php", info, function(response){
		            		console.log(info);
		            		response = jQuery.parseJSON(response);
		            		if (response.success){
			            		postOnFeed();
			            		window.location.href = response.redirect;	
		            		}					
						})
		            })
					
				})
		    }
		}
		function postOnFeed(){
			FB.api('/me/feed', 'post',
				{
				message     : "Registered as a Work From Home Professional with RemoteStaff.com.ph - Apply Now",
				link        : 'http://remotestaff.com.ph',
				picture     : baseUrl+'/portal/application_form/images/rs_logo.png',
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
		
	</script>
	
	{/literal}


		
	</body>
</html>