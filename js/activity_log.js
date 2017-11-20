var CURRENT_PAGE = "";
var current_date_time;
jQuery(document).ready(function(){
	CURRENT_PAGE = window.location.pathname;
	current_date_time = new Date();
	
	jQuery(window).on('beforeunload', function(){
		logTimeOfStay();
	});
});

function logTimeOfStay(){
	var logout_current = new Date();
	var diff = logout_current.getTime() - current_date_time.getTime();
	CURRENT_PAGE = window.location.pathname;
	if (c_id){
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
}
