function GenerateSOA(){
	var leads_id = jQuery('#leads_id').val();
	var date_str = jQuery('#date_str').val();
	var query = {"leads_id": leads_id, "date_str" : date_str};
	console.log(query);
	jQuery('#generate_btn').html("generating...");
	jQuery('#generate_btn').attr('disabled', 'disabled');
		var url = 'generate_soa.php';
		jQuery.ajax({
			type: "POST",
			url: url,
			// The key needs to match your method's input parameter (case-sensitive).
			data: JSON.stringify({ Query: query }),
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			success: function(data){
				if(data.success){
					RunTimerForRendering(data.doc_id);
				}else{
					console.log(data.msg);
					jQuery('#generate_btn').html('Generate');
					jQuery('#generate_btn').removeAttr('disabled', 'disabled');
				}
				
			},
			error: function(data) {
				alert("There's a problem in generating client statement of account.");
				jQuery('#generate_btn').html('Generate');
				jQuery('#generate_btn').removeAttr('disabled', 'disabled');
			}
		});
	
}


function RunTimerForRendering(doc_id){    
	jQuery('#results').html('Rendering results. Please wait...');
	setTimeout(function(){RenderCouchDocument(doc_id)},5000);	
}

function RenderCouchDocument(doc_id){

	var url = 'RenderCouchDocument.php';
	var result = jQuery.post( url, { 'doc_id' : doc_id} );
	result.done(function( data ) {	
		if(data == 'continue'){
			RunTimerForRendering(doc_id);
	    }else{
		    jQuery('#results').html(data);
			jQuery('#generate_btn').html('Generate');
			jQuery('#generate_btn').removeAttr('disabled', 'disabled');
			jQuery('#generate_btn').html('Generate');
			jQuery('#generate_btn').removeAttr('disabled', 'disabled');
	    }
	});
	result.fail(function( data ) {
		jQuery('#results').html(data);
	});

}