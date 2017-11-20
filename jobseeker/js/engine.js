var current;
var CURRENT_PAGE;
var baseUrl = "";
jQuery(document).ready(function(){
	CURRENT_PAGE = window.location.pathname;
	current = new Date();
	
	jQuery(window).on('beforeunload', function(){
		logTimeOfStay();
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
