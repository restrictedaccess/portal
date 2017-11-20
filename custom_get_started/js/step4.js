jQuery(document).ready(function(){
	jQuery(".navigation a").on("click", function(e){
		e.preventDefault();
	});
	jQuery("#skip").on("click", function(e){
		window.location.href = "/portal/custom_get_started/congrats.php";
		e.preventDefault();
		e.stopPropagation();
	});
	jQuery("#continue-step-4").on("click", function(e){
		var data = jQuery("#register-form").serialize();
		jQuery.post("/portal/custom_get_started/process_step4.php", data, function(response){
			response = jQuery.parseJSON(response);
			window.location.href = "/portal/custom_get_started/congrats.php";
		});
		e.preventDefault();
		e.stopPropagation();
	});
});
