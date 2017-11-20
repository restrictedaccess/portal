// JavaScript Document
var PATH = './';

function showCommHistory(created_by_type){
	var leads_id = $('leads_id').value;
	var query = queryString({'leads_id' : leads_id , 'created_by_type' : created_by_type });
	//alert(query);
	$('comm_hist').innerHTML = "Loading...";
	var result = doXHR(PATH + 'showCommHistory.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowCommHistory, OnFailShowCommHistory);
}

function OnSuccessShowCommHistory(e){
	$('comm_hist').innerHTML = e.responseText;
}

function OnFailShowCommHistory(e){
	alert("Failed to show Communication History");
}