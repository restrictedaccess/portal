jQuery(document).ready(function(){
	jQuery(".withdraw_job_application").live("click", function(e){
		var href = jQuery(this).attr("href");
		var me = jQuery(this);
		var ans = confirm("Do you want to withdraw this application?")
		if (ans){
		
			jQuery.get(href, function(response){
				response = jQuery.parseJSON(response);
				if (response.success){
					alert("Application successfully withdrawn.");
					me.parent().parent().fadeOut(100, function(){
						jQuery(this).remove();
						window.location.reload();
					})
				}
			})	
		}
		e.preventDefault();
	});
})
