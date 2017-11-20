jQuery(document).ready(function(){
	jQuery("#add_redirect").on("click", function(e){
		jQuery("#add_redirect_modal").modal(
			{backdrop: 'static',keyboard: true}
		)
		jQuery("#add_redirect_modal input[type=text]").val("");
		e.preventDefault();
	})
	
	
	jQuery("#save_redirect").on("click", function(e){
		var data = jQuery("#add_redirect_form").serialize();
		jQuery.post("/portal/seo/add_redirect.php", data, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				alert("Redirect has been added")
				window.location.reload();
			}else{
				alert(response.error);
			}
		})
	});
	
	
	jQuery(".delete_redirect").on("click", function(e){
		var id = jQuery(this).attr("data-id");
		var ans = confirm("Do you want to delete this redirect?");
		if (ans){
			jQuery.get("/portal/seo/delete_redirect.php?id="+id, function(response){
				response = jQuery.parseJSON(response);
				if (response.success){
					alert("Redirect has been succesfully deleted");
					window.location.reload();
				}else{
					alert(response.error);
				}
			})
		}	
	});
});
