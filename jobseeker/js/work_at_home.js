/**
 * @version 0.1 - New jobseeker portal
 */
jQuery(document).ready(function(){
	jQuery(".popup").click(function(e){
		popup_win7(jQuery(this).attr("href"), 950, 600);
		e.preventDefault();
	})
	
	jQuery("#register-form").submit(function(e){
		jQuery.post("/portal/jobseeker/update_working_at_home_capabilities.php", jQuery(this).serialize(), function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
		  			jQuery(".alert-success").fadeIn(200);
		  			 $('html, body').animate({
		  			 	scrollTop:jQuery(".jobseeker-header").offset().top
		  			 }, 500);
		  		}else{
		  			alert("There were some errors. Please review the data and try again");
		  		}
		})
		e.preventDefault();
	})
});
