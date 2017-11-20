var GUI_VERSION = '2013-06-27 06:49:00';
var CLIENT_PORTAL_TOPUP_RPC = "/portal/django/client_topup_prepaid_v2/jsonrpc/";

jQuery(document).ready(function(){   	
    console.log(window.location.pathname);
    check_version();
    
    //get_timesheet_auto_adjustment_details();    
    jQuery("#ts-auto-adj").on( "submit", function( event ) {
		event.preventDefault();
        saveChanges(this);
	});
});


function saveChanges(data){

    var formData = jQuery( data ).serialize();
    var base_api_url = jQuery("#BASE_API_URL").val();
    var url = base_api_url + "/timesheet-auto-adjustment/save-changes-by-client";
    //console.log(formData);
    jQuery.ajax({
		url : url,
		type : "POST",
		data: formData,
		dataType : 'json',
		success : function(response) {	
            if(response.success){
            	alert(response.msg);	
            }else{
            	alert(response.error);
            }
            
		},
		error : function(response) {
           alert("There's a problem in saving your changes. Please try again later.");
		}
	});
}
   

function get_timesheet_auto_adjustment_details(){
	var doc_id = jQuery("#doc_id").val();
	var BASE_API_URL = jQuery("#BASE_API_URL").val();
	
	var url = BASE_API_URL + '/timesheet-auto-adjustment/get-timesheet-auto-adjustment-details/';
	
	var formData = {
		'doc_id' : doc_id,
	};
	
	jQuery.ajax({
        url : url,
        type : "POST",
        data: formData,
        dataType : 'json',
        success : function(data) {	
            
        },
        error : function(data) {
            alert("There's a problem in retrieving timesheet auto adjustment details.");
			
        }
    });	
}


function check_version(){	
	
	var data = {json_rpc:"2.0", id:"ID9", method:"check_session", params:[GUI_VERSION]};
	jQuery.ajax({
		url: CLIENT_PORTAL_TOPUP_RPC,
		type: 'POST',
		data: JSON.stringify(data),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json',
		success: function(response) {
			//console.log(response);
			if(response.error){
				jQuery("#ts-result").addClass("alert alert-danger");
				jQuery("#ts-result").html("<h3>Error in page</h3> <br> Message : "+response.error.message);
			}else{
				
			}
		}		
	});
}
