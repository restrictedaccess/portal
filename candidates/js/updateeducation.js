jQuery(document).ready(function(){
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
		  	jQuery.post("/portal/candidates/update_education_process.php", serialize, function(data){
		  		data = jQuery.parseJSON(data);
		  		if (data.success){
		  			alert("Profile has been updated");
		  			window.opener.location.reload();
		  			window.close();
		  		}else{
		  			alert("There were some errors. Please review the data and try again");
		  		}
		  	})
		   return false;
		 }
	})
});
