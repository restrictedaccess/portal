jQuery(document).ready(function(){
	
	jQuery(".add-general").on("click", function(e){
		var src = jQuery("#general-row").html();
		jQuery(src).appendTo(jQuery(this).parent().parent().find("tbody"));
		e.preventDefault();
		e.stopPropagation();
	});
	
	jQuery(".add-accounts_clerk").on("click", function(e){
		var src = jQuery("#accounts_clerk-row").html();
		jQuery(src).appendTo(jQuery(this).parent().parent().find("tbody"));
		e.preventDefault();
		e.stopPropagation();
	});
	
	jQuery(".add-accounts_payable").on("click", function(e){
		var src = jQuery("#accounts_payable-row").html();
		jQuery(src).appendTo(jQuery(this).parent().parent().find("tbody"));
		e.preventDefault();
		e.stopPropagation();
	});
	
	jQuery(".add-accounts_receivable").on("click", function(e){
		var src = jQuery("#accounts_receivable-row").html();
		jQuery(src).appendTo(jQuery(this).parent().parent().find("tbody"));
		e.preventDefault();
		e.stopPropagation();
	});
	
	jQuery(".add-accounting_package").on("click", function(e){
		var src = jQuery("#accounting_package-row").html();
		jQuery(src).appendTo(jQuery(this).parent().parent().find("tbody"));
		e.preventDefault();
		e.stopPropagation();
	});
	jQuery(".add-bookkeeper").on("click", function(e){
		var src = jQuery("#bookkeeper-row").html();
		jQuery(src).appendTo(jQuery(this).parent().parent().find("tbody"));
		e.preventDefault();
		e.stopPropagation();
	});
	jQuery(".add-payroll").on("click", function(e){
		var src = jQuery("#payroll-row").html();
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
		jQuery.post("/portal/custom_get_started/update_office_js.php", data, function(response){
			var gs_job_titles_details_id = jQuery("input[name=gs_job_titles_details_id]").val();
			alert("Updated successfully");
			window.location.href = "/portal/custom_get_started/job_spec.php?gs_job_titles_details_id="+gs_job_titles_details_id
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
