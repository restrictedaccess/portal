jQuery(document).ready(function(){
	jQuery(".popup").click(function(e){
		popup_win7(jQuery(this).attr("href"), 950, 600);
		e.preventDefault();
	})
	
	jQuery("#language-form").validate({
		errorElement:"span",
		errorPlacement:function(error, element){
			error.addClass("help-inline").appendTo(element.parent(".controls")).parent().parent().removeClass("error").removeClass("success").addClass("error");
		},
		success:function(label){
			label.parent().parent().removeClass("error").removeClass("success").addClass("success");
		},
		rules:{
			language:{
				required:true
			},
			spoken:{
				required:true
			},
			written:{
				required:true
			}
			
			
		}, 
		submitHandler: function(form) {
			var formData = jQuery("#language-form").serialize();
			jQuery.post("/portal/jobseeker/update_language.php", formData, function(data){
				data = jQuery.parseJSON(data);
				if (data.success){
					alert("Language has been updated")
					window.location.href = "/portal/jobseeker/languages.php"
				}else{
					alert(data.error);
				}
			})
		}
	});
});