jQuery(document).ready(function(){

	jQuery.validator.messages.required = "";
	jQuery.validator.addMethod("uniqueEmail", function(value, element){
		var result = false;
		jQuery.ajax({
			type:"GET",
			url:"/portal/candidates/email-existing.php",
			data:"email="+value,
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
	*/
	
	jQuery("#external_source_select").change(function(){
		if (jQuery(this).val()=="Others"){
			jQuery("#external_source_others_div").show();
		}else{
			jQuery("#external_source_others_div").hide();
		}
	});

	//setInterval(updateStatus, 1);
	
	var stateSelect = jQuery("#state");
	var stateInput = "<input type='text' name='state' id='state' class='span4'/>";
	
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
			error.addClass("help-inline").appendTo(element.parent(".controls")).parent().parent().removeClass("error").removeClass("success").addClass("error");
		},
		success:function(label){
			label.parent().parent().removeClass("error").removeClass("success").addClass("success");
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
			/*bmonth:{sdsds
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
			},*/
			email:{
				required:true,
				email:true,
				uniqueEmail:true
			},
			gender:{
				required:true
			}
		},
		submitHandler: function(form) {
			var handphone_code = jQuery("#handphone_country_code").val();
			var handphone = jQuery("#handphone_no").val();
			var tel_area_code = jQuery("#tel_area_code").val();
			var tel_no = jQuery("#tel_no").val();
			
		   
		   var serialize = jQuery(form).serialize();
		  	jQuery.post("/portal/candidates/add.php", serialize, function(data){
		  		data = jQuery.parseJSON(data);
		  		if (data.success){
		  			alert("You have successfully registered a job seeker account");
		  			if (jQuery("#referral_id").val()!=""){
		  				window.opener.location.reload();
		  				window.close();
		  			}else{	  			
			  			location.href="/portal/recruiter/staff_information.php?userid="+data.userid;	
		  			}
		  			
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
	if (jQuery("#referral_id").val()!=""){
		jQuery("#applicationsleftnav").parent().hide();
	}
})
