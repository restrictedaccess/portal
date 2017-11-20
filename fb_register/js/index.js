jQuery(document).ready(function(){
	jQuery("#main_form").validate({rules: {
	    number: {
	      required: true,
	      number: true
	    },
	    errorClass:"alert alert-danger",
	    errorPlacement: function(error, element) {
		    if (element.is(':checkbox')) {
		        $(element).parent('div').addClass('checkbox-error');
		
		    }else{
		    	$(element).parent('div').find("error").addClass("alert alert-danger");
		    }
		    
		    return true;
		},
		highlight:function(error, element){
			if (element.is(':checkbox')) {
		        $(element).parent('div').addClass('checkbox-error');
		
		    }else{
		    	$(element).parent('div').find("error").addClass("alert alert-danger");
		    }
		    return true;
		}
	    
  	}});
  	jQuery("input, select").on("focus", function(){
  		jQuery(".alert").hide();
  	});
  	jQuery("#idNumber").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
})
