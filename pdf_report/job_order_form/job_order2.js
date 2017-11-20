// JavaScript Document

function SaveDetails(job_order_id,job_order_form_id,job_requirement,rating,groupings,width,div,form){
	
	var query = queryString({'job_order_id' : job_order_id , 'job_order_form_id' : job_order_form_id, 'job_requirement' : job_requirement, 'rating' : rating, 'groupings' : groupings, 'width' : width });
	//alert(query);return false;
	var result = doXHR('saveJobOrderDetails.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSaveDetails, OnFailSaveDetails);
	
	function OnSuccessSaveDetails(e){
	    hide(form);
		$(div).innerHTML=e.responseText;
	}
	
	function OnFailSaveDetails(e){
		alert("Failed to add");
	}
}


