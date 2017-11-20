jQuery(document).ready(function(){
	jQuery("#save_add_more_promocodes").click(function(e){
		jQuery.post("/portal/jobseeker/add_promo_codes.php", jQuery("#promocode-form").serialize(), function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				alert("Promo Code has been successfully added");
				window.location.reload();
			}else{
				if (data.error!=undefined){
					alert("Promo code is existing")				
				}else{
					alert("Promo Code is blank. Please enter a value");					
				}

			}
		});
		e.stopPropagation();
		return false;
	})
	jQuery(".edit_promocode").click(function(e){
		jQuery.get("/portal/jobseeker/get_promo_code.php?id="+jQuery(this).attr("data-id"), function(response){
			response = jQuery.parseJSON(response);
			jQuery("#update_id").val(response.id);
			jQuery("#update_promocode").val(response.promocode);
			jQuery("#update_userid").val(response.userid);
			
			jQuery("#updatePromoCode").modal({backdrop: 'static',keyboard: true})
			
		})
		e.preventDefault();
	})
	
	jQuery(".delete_promo_code").click(function(e){
		var me = jQuery(this);
		var ans = confirm("Do you want to delete this promo code?");
		if (ans){
			jQuery.get("/portal/jobseeker/delete_promo_codes.php?id="+jQuery(this).attr("data-id"), function(response){
				response = jQuery.parseJSON(response);
				if (response.success){
					me.parent().parent().fadeOut(200, function(){
						jQuery(this).remove();
					})
				}else{
					alert(response.error);
				}
			})
		}
		
		e.preventDefault();
	})
	
	
	jQuery("#update_promocode_save").click(function(e){
		jQuery.post("/portal/jobseeker/update_promo_codes.php", jQuery("#update_promocode_form").serialize(), function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				alert("Promo Code has been successfully updated");
				window.location.reload();
			}else{
				if (data.error!=undefined){
					alert("Promo code is existing")				
				}else{
					alert("Promo Code is blank. Please enter a value");					
				}

			}
		});
		e.stopPropagation();
		return false;
	})
	
	jQuery("#myTab a").click(function(e){
		 e.preventDefault();
 		 jQuery(this).tab('show');
	})
});

