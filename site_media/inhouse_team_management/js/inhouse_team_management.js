function Search(e){
	var search = $('search').value;
    var pay_type = $('pay_type').value;
	var paying_company = $('paying_company').value;
	var query = queryString({'search' : search, 'pay_type': pay_type, 'paying_company' : paying_company});
	//alert(query);
    var result = doXHR('/portal/django/inhouse/Search/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSearch, OnFailSearch);
}
function OnSuccessSearch(e){
    $('inhouse_list').innerHTML = e.responseText;
}
function OnFailSearch(e){
	alert("Failed to search");
}

function SavePaymentSettings(e){
	var pay_type = $('pay_type').value;
	var paying_company = $('paying_company').value;
	var userid = $('userid').value;
		
	if(pay_type == ""){
		alert("Staff Payment Type is required.");
		$('pay_type').focus();
		return false;
	}
	
	if(paying_company == ""){
		alert("Staff Company is required.");
		$('paying_company').focus();
		return false;
	}
	
	
	$('save_payment_settings').value = "Saving...";
	$('save_payment_settings').disabled = true;
	var query = queryString({ 'userid' : userid, 'pay_type' : pay_type, 'paying_company' : paying_company });
	var result = doXHR('/portal/django/inhouse/SavePaymentSettings/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSavePaymentSettings, OnFailSavePaymentSettings);
}

function OnSuccessSavePaymentSettings(e){
	alert(e.responseText);
	$('save_payment_settings').value = "Save Settings";
	$('save_payment_settings').disabled = false;
}
function OnFailSavePaymentSettings(e){
	alert("Failed to Save settings");
	$('save_payment_settings').value = "Save Settings";
	$('save_payment_settings').disabled = false;
}