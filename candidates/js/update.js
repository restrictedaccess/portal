jQuery(document).ready(function(){
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
	
	jQuery(".add_more_work_skype").live("click", function(e){
		var template = "<div class=\"control-group\">";
		template += "<label class=\"control-label\">Work Skype: </label>";
		template += "<div class=\"controls\">"
		template += "<input type=\"hidden\" name=\"skypes_userids[]\"/>"
		template += "<input type=\"hidden\" name=\"skypes_subcontractors_ids[]\"/>"
		template += "<input type=\"text\" class=\"span4\" name=\"skypes_skype_ids[]\"/>"
		template += "</div>"
		template += "</div>";
		
		jQuery(template).appendTo(jQuery("#skype_list"));
		e.preventDefault();
		e.stopPropagation();
	})
	
	jQuery("#country_id").change(transformFields)
	
	jQuery("#register-form").validate({
		errorElement:"span",
		errorPlacement:function(error, element){
			error.addClass("help-inline").appendTo(element.parent(".controls")).parent().parent().removeClass("error").removeClass("success").addClass("error");
		},
		success:function(label){
			label.parent().parent().removeClass("error").removeClass("success").addClass("success");
		},
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
			alt_email:{
				email:true
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
			if (!((jQuery.trim(tel_no)!=""&&jQuery.trim(tel_area_code)!="")||(jQuery.trim(handphone_code)!=""&&jQuery.trim(handphone)!=""))){
		   	alert("At least one contact number is required.")
		   	return false;
		   }
		   
			
		   var serialize = jQuery(form).serialize();
                 
		  	jQuery.post("/portal/candidates/update.php", serialize, function(data){
		  		var theData = jQuery.parseJSON(data);
                               
		  		if (theData.success){
		  			alert("Profile has been updated");
		  			window.opener.location.reload();
		  			window.close();
		  		}else{
		  			if (theData.error!=undefined){
		  				alert(theData.error);
		  			}else{
		  				alert("There were some errors. Please review the data and try again");
		  			}
		  		}
		  	})
                        
		   return false;
		 }
	})
})
