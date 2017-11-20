jQuery(document).ready(function(){
	jQuery(".finish-and-chat").click(function(e){
		var formData = jQuery("#refer-a-friend").serialize();
		jQuery.post("/portal/application_form/refer-friends.php", formData, function(data){
			data = jQuery.parseJSON(data);
			if (data.result){
				var userid = jQuery("#refer-a-friend-userid").val();
				var email = jQuery("#refer-a-friend-email").val();			
				location.href = "register-and-chat.php?userid="+userid+"&email="+email;
			}
		});
		e.preventDefault();
	});
	jQuery(".finish-4-days").click(function(e){
		var formData = jQuery("#refer-a-friend").serialize();
		jQuery.post("/portal/application_form/refer-friends.php", formData, function(data){
			data = jQuery.parseJSON(data);
			if (data.result){
				location.href = "registernow-finish.php";
			}
		});
		e.preventDefault();
	});
	jQuery(".shodow_out").removeClass("shodow_out").addClass("shodow_out_8").height(800);
});