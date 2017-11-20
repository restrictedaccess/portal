jQuery(document).ready(function(){
	
	jQuery.get("/portal/django_mongo_session_transfer_generate.php", function(response){
		response = jQuery.parseJSON(response);
		jQuery.get("/portal/v2/session-manager/session-transfer/", {session_hash:response.session_hash}, function(response){
			
		});
	});
	
	jQuery("#full-text-search-button").click(function(e){
		var q=jQuery("#full-text-search").val();
		window.location.href=jQuery("#api_url").val()+"?q="+q;
		//e.preventDefault();
		//e.stopPropagation();
	});	
});