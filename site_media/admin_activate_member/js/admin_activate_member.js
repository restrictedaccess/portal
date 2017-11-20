// JavaScript Document
function ActivateMember(e){
	var leads_id = getNodeAttribute(e.src(), 'leads_id');
	var client_setting =  getNodeAttribute(e.src(), 'client_setting');
	var currency = $('currency').value;
	var australian_company = $('australian_company').value;
	var query = queryString({'leads_id' : leads_id , 'client_setting' : client_setting, 'currency' : currency, 'australian_company' : australian_company });
	alert(query);
	$('activate').disabled = true;
	$('activate').value = 'Activating';
	var result = doXHR('/portal/django/admin_activate_member/Activate/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessActivateMember, OnFailActivateMember);
}
function OnSuccessActivateMember(e){
	
	alert("Membership activated");
	location.href = '/portal/django/admin_activate_member/'+e.responseText;
}
function OnFailActivateMember(e){
	alert("Failed to activate member");
}

function CheckAustralianCompany(e){
	var australian_company = $('australian_company').value;
	var client_setting =  $('client_setting').value;
	if (client_setting == 'no') {
		if(australian_company == 'Y'){
			$('currency').value = 'AUD';
			$('currency').disabled = true;
		}else{
			$('currency').disabled = false;
		}
	}
}