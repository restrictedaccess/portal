jQuery(document).ready(function(){
	jQuery(".add-system").on("click", function(e){
		var src = jQuery("#system-row").html();
		jQuery(src).appendTo(jQuery(this).parent().parent().find("tbody"));
		e.preventDefault();
		e.stopPropagation();
	});
	jQuery(".add-database").on("click", function(e){
		var src = jQuery("#database-row").html();
		jQuery(src).appendTo(jQuery(this).parent().parent().find("tbody"));
		e.preventDefault();
		e.stopPropagation();
	});
	jQuery(".add-pc_products").on("click", function(e){
		var src = jQuery("#pc_products-row").html();
		jQuery(src).appendTo(jQuery(this).parent().parent().find("tbody"));
		e.preventDefault();
		e.stopPropagation();
	});
	jQuery(".add-platforms").on("click", function(e){
		var src = jQuery("#platforms-row").html();
		jQuery(src).appendTo(jQuery(this).parent().parent().find("tbody"));
		e.preventDefault();
		e.stopPropagation();
	});
	jQuery(".add-programming").on("click", function(e){
		var src = jQuery("#app_programming-row").html();
		jQuery(src).appendTo(jQuery(this).parent().parent().find("tbody"));
		e.preventDefault();
		e.stopPropagation();
	});
	jQuery(".add-multimedia").on("click", function(e){
		var src = jQuery("#multimedia-row").html();
		jQuery(src).appendTo(jQuery(this).parent().parent().find("tbody"));
		e.preventDefault();
		e.stopPropagation();
	});
	jQuery(".add-open_source").on("click", function(e){
		var src = jQuery("#open_source-row").html();
		jQuery(src).appendTo(jQuery(this).parent().parent().find("tbody"));
		e.preventDefault();
		e.stopPropagation();
	});
	
	jQuery(".add-duties").on("click", function(e){
		var src = jQuery("#responsibility-row").html();
		jQuery(src).appendTo(jQuery("#responsibilities-div"));
		e.preventDefault();
		e.stopPropagation();
	});
	
	jQuery(".add-other-preferred-skills").on("click", function(e){
		var src = jQuery("#preferred-skill-row").html();
		jQuery(src).appendTo(jQuery("#preferred-skill-div"));
		e.preventDefault();
		e.stopPropagation();
	});
	
	
	jQuery("#main-form").on("submit", function(){
		var data = jQuery(this).serialize();
		jQuery.post("/portal/custom_get_started/update_it_js.php", data, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				var gs_job_titles_details_id = jQuery("input[name=gs_job_titles_details_id]").val();
				alert("Updated successfully");
				window.location.href = "/portal/custom_get_started/job_spec.php?gs_job_titles_details_id="+gs_job_titles_details_id
			}
		})
		
		return false;
	});
	jQuery(".back-js").on("click", function(e){
		var id = jQuery("input[name=gs_job_titles_details_id]").val();
		window.location.href = "/portal/custom_get_started/job_spec.php?gs_job_titles_details_id="+id;
		e.preventDefault();
		e.stopPropagation();
	})
});

jQuery(document).on("click", ".delete-creds",function(e){
	jQuery(this).parent().parent().remove();
	e.preventDefault();
	e.stopPropagation();
})
