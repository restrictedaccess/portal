jQuery(document).ready(function() {
	jQuery(window).load(function (e) {
		console.log('promotional codes monitoring');
		
		var n=0
		jQuery('.tracking_id').each(function(e){

			var tracking_id = jQuery(this).attr('tracking_id');
			jQuery.ajaxq ("testqueue", {
				url: 'get_hits.php',
				type: 'post',
				cache: false,
				data: {tracking_id: tracking_id},
				success: function(data){
					response = jQuery.parseJSON(data);
					jQuery('#'+tracking_id+'_td').html(response.hits);
				}
			});
			
		});
		
	});
	
	
});