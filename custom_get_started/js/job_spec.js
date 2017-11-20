jQuery(document).ready(function(){
	jQuery("#save_changes").on("click", function(e){
		var data = jQuery("#update_js_form").serialize();
		var me = jQuery(this);
		jQuery(this).text("Saving Changes...").attr("disabled", "disabled");
		
		jQuery.post("/portal/custom_get_started/update_js.php", data, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				alert("Job specification form has been updated");
				me.text("Save Changes").removeAttr("disabled");
		
				window.location.reload();
			}
		});
		
		
		e.preventDefault();
		e.stopPropagation();
	})
	
	jQuery("#edit_basic_jo").on("click", function(e){
		
		jQuery("#update_job_spec_form").modal({backdrop:"static", "keyboard":false});
		e.stopPropagation();
		e.preventDefault();
	});
	jQuery("#edit-ad").on("click", function(e){
		var gs_job_titles_id = $('#gs_job_titles_details_id').val();
		showLoader();
		window.location.href="/portal/convert_ads/convert_to_ads.php?gs_job_titles_details_id="+gs_job_titles_id;
		e.stopPropagation();
		e.preventDefault();
	}); 
});
