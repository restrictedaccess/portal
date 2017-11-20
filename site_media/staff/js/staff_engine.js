var current;
var CURRENT_PAGE = "";
var baseUrl = ""

jQuery(document).ready(function(){
	
	
	current = new Date();
	check_php_session();
	
	jQuery(window).on('beforeunload', function(){
		logTimeOfStay();
	});
	
	jQuery('.popup').click(function (event) {
		event.preventDefault();
		window.open($(this).attr("href"), "popupWindow", "width=600,height=600,scrollbars=yes");
	});
	
});


function logTimeOfStay(){
	var logout_current = new Date();
	var diff = logout_current.getTime() - current.getTime();
	CURRENT_PAGE = window.location.pathname;
	var data = {
		p:CURRENT_PAGE,
		ms:diff
	};
	jQuery.ajax({
		url: baseUrl+"/portal/client_api_service/ltime.php",
		type: 'POST',
		data: JSON.stringify(data),
		contentType: 'application/json; charset=utf-8',
		dataType: 'json',
		async:false,
		success: function(response) {
		
		}
	});
	
}

function check_php_session(){
	var data = {json_rpc:"2.0", id:"ID2", method:"check_php_session", params:["2011-09-02 17:04:00"]};
	jQuery.ajax({
	    url: URL_STAFF_API,
	    type: 'POST',
	    data: JSON.stringify(data),
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    async:false,
	    success: function(response) {
			//console.log(response)
			
	    	if (response.result!=undefined){
	    		var update_data = {json_rpc:"2.0", id:"ID3", method:"update_django_session", params:[response.result]};
	    		jQuery.ajax({
	    			url: STAFF_SERVICE_RPC,
	    			type: 'POST',
	    			data: JSON.stringify(update_data),
	    			contentType: 'application/json; charset=utf-8',
				    dataType: 'json',
				    async:false,
				    success:function(result){
				    	if (result.result=="ok"){
				    		
				    	}else{
				    		window.location.href = "/portal/";
				    	}
				    }
	    		});
	    	}else{
	    		window.location.href = "/portal/";
	    	}
			
	    }
	})
	
}
