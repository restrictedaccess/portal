jQuery(document).ready(function(){   
    console.log(window.location.pathname);  
    var today = formatDate();
    console.log(today);
    //jQuery("#starting_date").val(today.starting_date);
    
    
    Calendar.setup({
	   inputField : "starting_date",
	   trigger    : "btn-cal",
	   onSelect   : function() { this.hide();  },
	   fdow  : 0,
	   dateFormat : "%B %d, %Y",
	   min: parseInt(today.today)
	});
		
    jQuery(document).on( "click", "#accept-btn", function( event ) {
		event.preventDefault();		    
        
        jQuery('#myModal').modal({ 
			backdrop: 'static',
			keyboard: false
		});
	
	});
	
	jQuery(document).on( "submit", "#online-service-agreement", function( event ) {
		
		jQuery("#submit-btn").attr("disabled", "disabled");
    	jQuery("#submit-btn").html("Submitting...");	    
        var starting_date = jQuery("#starting_date").val();
        if(!starting_date){
        	//alert("Please specify starting date of staff");
        	jQuery("#myalert").removeClass("hide");
        	jQuery("#submit-btn").removeAttr("disabled");
    		jQuery("#submit-btn").html("Accept and Submit");
        	return false;	
        	
        }
	
	});
	
	
    //jQuery(document).on( "submit", "#online-service-agreement", function( event ) {
	//	event.preventDefault();		    
    //    acceptServiceAgreement();
	//});
	
});

function acceptServiceAgreement(){
	
}

function formatDate() {
    var d = new Date(),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
	return {today : [year, month, day].join(''), starting_date : [year, month, day].join('-')};
    //return [year, month, day].join('');
}