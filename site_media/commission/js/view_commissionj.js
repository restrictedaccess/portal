jQuery(document).ready(function() {			   
	jQuery(window).load(function (e) {
		console.log(window.location.pathname);			
	});
	
	jQuery(".cal-input").each(function () {
		var id = jQuery(this).attr("id");
		var target = jQuery(this).attr("id");
		var min_date = jQuery("#min-date").val();
		Calendar.setup({
		   inputField : target,
		   trigger    : id,
		   onSelect   : function() { this.hide(); CheckPaymentType();  },
		   fdow  : 0,
		   dateFormat : "%Y-%m-%d",
		   min: parseInt(min_date)
		});
	});
	
	
	getHistories();
	highlightElem();
	enabledDisabledButton();
	checkPaymentStatus();
	jQuery('#invoice_id').removeClass("input-focus");
	var status = jQuery('#status').val().toLowerCase();
	var commission_id = jQuery('#commission_id').val();
	
	jQuery('#payment_type').change(function () {
        CheckPaymentType();
    });
	
	jQuery("#back-btn").attr('href', PORTAL_DJANGO + 'commission/show/'+status);
	
	jQuery('#selectall').click(function () {
        jQuery('input[name=subcons]').prop('checked', this.checked);
		highlightElem();
    });

    jQuery('input[name=subcons]').change(function () {
        var check = (jQuery('input[name=subcons]').filter(":checked").length == jQuery('input[name=subcons]').length);
        jQuery('#selectall').prop("checked", check);
		highlightElem();
    });
	

	
	jQuery('.status-btn').click(function(e) {
		e.preventDefault();
		var commission_status = jQuery(this).attr('data-status');
		var status_str = jQuery(this).html();
		
		
		if(confirm("Do you want to "+status_str.toLowerCase()+ " this commission?" )){
			//console.log(commission_status);
			jQuery(this).attr('disabled', 'disabled');
			update_commission_status(commission_id, commission_status);
		}
	});
	
	
	jQuery('.tag-btn').click(function(e) {
		e.preventDefault();
		var payment_status = jQuery(this).attr('data-payment-status');
		update_payment_status(commission_id, payment_status);
	});
	
	
	
	jQuery('input.cleanup').blur(function() {
		var value = jQuery.trim( jQuery(this).val() );
		jQuery(this).val( value.replace(/\s+/g, '') );
	});
	
	
	
	jQuery("#commission-form").on( "submit", function( event ) {
		event.preventDefault();			
		var formData = jQuery(this).serialize();
		var amount = jQuery('#commission_amount').val().replace(/\s+/g, '');
		var number_of_selected_staffs = jQuery('input[name=subcons]:checked').length ;
		var error_msg="";
		
		if(amount == "" || parseFloat(amount) <= 0){
			error_msg += "Amount cannot be empty.<br>";
		}
		
		if(isNaN(amount)){
			error_msg += "Amount ["+amount+"] is not a valid number.<br>";
		}
		
		if(number_of_selected_staffs == 0){
			error_msg += "Please select staff.<br>";
		}
		if(error_msg){
			jQuery('#windowTitleDialog').modal({ 
				backdrop: 'static',
				keyboard: false
			});
			jQuery('.modal-body').html(error_msg);
			jQuery('.modal-title').html('Error');
			jQuery('.modal-body').removeClass("alert-success");
			jQuery('.modal-body').addClass("alert-danger");
			jQuery('#modal-close-btn').removeClass("hide");
			jQuery('#modal-ok-btn').addClass("hide");
			return false;
		}
		
		jQuery('#create-btn').html('submitting changes...');
		jQuery('#create-btn').attr('disabled', 'disabled');
		
		jQuery.post(PORTAL_DJANGO + "commission/update_commission/", formData, function(data){
			data = jQuery.parseJSON(data);
			//console.log(data);
			jQuery('#windowTitleDialog').modal({ 
				backdrop: 'static',
				keyboard: false
			});
			jQuery('.modal-body').html(data.msg);
			if(data.success == true){
				jQuery('.modal-title').html('Success');
				jQuery('.modal-body').removeClass("alert-danger");
				jQuery('.modal-body').addClass("alert-success");
				jQuery('#modal-ok-btn').addClass("hide");
				jQuery('#modal-close-btn').removeClass("hide");
				
			}else{
				jQuery('.modal-title').html('Warning');
				jQuery('.modal-body').removeClass("alert-success");
				jQuery('.modal-body').addClass("alert-danger");
				jQuery('#modal-close-btn').removeClass("hide");
				jQuery('#modal-ok-btn').addClass("hide");
			}
			checkPaymentStatus();
			getHistories();
		});
		jQuery('#create-btn').html('Submit Changes');
		jQuery('#create-btn').removeAttr('disabled', 'disabled');
		
	});
	
});