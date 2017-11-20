jQuery(document).ready(function(){
	jQuery(".popup").click(function(e){
		popup_win7(jQuery(this).attr("href"), 950, 600);
		e.preventDefault();
	})
	
	jQuery("#register-form").validate({
		errorElement:"span",
		errorPlacement:function(error, element){
			error.addClass("help-inline").appendTo(element.parent(".controls")).parent().parent().removeClass("error").removeClass("success").addClass("error");
		},
		success:function(label){
			label.parent().parent().removeClass("error").removeClass("success").addClass("success");
		},
		rules:{
			educationallevel:{
				required:true
			},
			fieldstudy:{
				required:true
			},
			grade:{
				required:true
			},
			college_name:{
				required:true
			},
			college_country:{
				required:true
			},
			graduate_month:{
				required:true
			},
			graduation_year:{
				required:true
			}
		},
		submitHandler: function(form) {
		   var serialize = jQuery(form).serialize();
		  	jQuery.post("/portal/jobseeker/update_education_process.php", serialize, function(data){
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
		   return false;
		 }
	})
});
