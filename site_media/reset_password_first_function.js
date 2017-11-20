//registered_date should be a string
function init_reset_password_first(login_type, registered_date){
	
	
	var date_comparison = new Date(Date.parse("2016/05/04"));
	
	var formatted_registered_date = new Date(Date.parse(registered_date));
	
	
	// if(formatted_registered_date < date_comparison){
	// 	$.ajax({
	// 		type: 'POST',
	// 		url: jQuery("#base_api_url").val() + '/secure/check-reset-password-status/',
	// 		data: {email:jQuery("#reset-password-first-email").val(), login_type:login_type},
	// 		dataType: 'json',
	// 		success : function(response){
	// 			if(!response.success){
	// 				jQuery("#reset_password_first").modal({
	// 					keyboard : false,
	// 					backdrop : "static"
	// 				});
	//
	// 				jQuery("#reset-password-first-form").on("submit", function(e){
	// 					e.preventDefault();
	//
	// 					var action = jQuery(this).attr("action");
	//
	// 					var me = this;
	//
	// 					var data = jQuery(this).serializeArray();
	//
	// 					var real_data = {};
	// 					jQuery.each(data, function(key, value){
	// 						real_data[value["name"]] = value["value"];
	// 					});
	//
	// 					jQuery.ajax({
	// 						type: 'POST',
	// 						url: action + "?" + jQuery(me).serialize(),
	// 						data: real_data
	// 					});
	//
	// 					/*
	// 					jQuery("#reset_password_first").modal("hide");
	//
	// 					jQuery("#forgot_password_success_modal").modal({
	// 						keyboard : false,
	// 						backdrop : "static"
	// 					});
	// 					*/
	//
	// 					window.location.replace("/portal/logout.php");
	//
	// 				});
	// 			}
	//
	// 		}
	// 	});
	// }
	
}
