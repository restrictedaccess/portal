jQuery(document).ready(function(){
	jQuery(".popup").click(function(e){
		popup_win7(jQuery(this).attr("href"), 950, 600);
		e.preventDefault();
	})
	
	jQuery.validator.messages.required = "";
	jQuery.validator.addMethod("uniqueEmail", function(value, element){
		var result = false;
		jQuery.ajax({
			type:"GET",
			url:"/portal/candidates/email-existing.php",
			data:"email="+value+"&userid="+jQuery("#userid").val(),
			dataType:"html",
			async:false,
			success:function(msg){
				msg = jQuery.parseJSON(msg);
				result = !msg.success;
			
			}
		});
		return result;
	}, "Email is already taken");
	
	/*
	function updateStatus(){
		jQuery("input[type=text]").each(function(){
			if (jQuery(this).hasClass("error")){
				jQuery(this).parent().parent().removeClass("success").addClass("error");
			}else if (jQuery(this).hasClass("success")){
				jQuery(this).parent().parent().removeClass("error").addClass("success");
			}
		})
	}
	
	setInterval(updateStatus, 1);
	*/
	
	var stateSelect = jQuery("#state");
	var stateInput = "<input type='text' name='state' id='state' class='span2'/>";
	
	function transformFields(){
		if (jQuery("#country_id").val()=="PH"){
			jQuery("#state_container").html("").append(stateSelect);
		}else{
			jQuery("#state_container").html(stateInput);
		}
	}
	
	transformFields();
	jQuery("#country_id").change(transformFields)
	
	jQuery("#register-form").validate({
		/*
		errorElement:"span",
		errorPlacement:function(error, element){
			error.addClass("help-inline").appendTo(element.parent(".controls")).parent().removeClass("error").removeClass("success").addClass("error");
		},
		success:function(label){
			label.parent().removeClass("error").removeClass("success").addClass("success");
		},
		*/
		rules:{
			fname:{
				required:true,
				minlength:2
			},
			lname:{
				required:true,
				minlength:2,
			},
			bmonth:{
				required:true
			},
			bday:{
				required:true
			},
			byear:{
				required:true,
				number : true,
				maxlength : 4,
				minlength : 4
			},
			email:{
				required:true,
				email:true,
				uniqueEmail:true
			},
			handphone_country_code:{
				required:true
			},
			handphone_no:{
				required:true
			},
			gender:{
				required:true
			}
		},
		submitHandler: function(form) {
		   var serialize = jQuery(form).serialize();
		  	jQuery.post("/portal/jobseeker/update_personal_information.php", serialize, function(data){
		  		data = jQuery.parseJSON(data);
		  		if (data.success){
		  			jQuery(".alert-success").fadeIn(200);
		  			 $('html, body').animate({
		  			 	scrollTop:jQuery(".jobseeker-header").offset().top
		  			 }, 500);
		  		}else{
		  			if (data.error!=undefined){
						alert(data.error);	  				
		  			}else{
			  			alert("There were some errors. Please review the data and try again");
		  				
		  			}
		  		}
		  	})
		   return false;
		 }
	})
	
	jQuery("#external_source_select").change(function(){
		if (jQuery(this).val()=="Others"){
			jQuery("#external_source_others_div").show();
		}else{
			jQuery("#external_source_others_div").hide();
		}
	}).trigger("change");
	
})
