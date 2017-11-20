// JavaScript Document
var PATH = 'BD/';
 
function ShowMonthlyYearlyBDSummaryReport(){
	var month = $('month').value;
	var year = $('year').value;
	if(!year && !month ){
		ShowBDSummaryReport('current');
	}else{
		$('summary').innerHTML = "Loading...";
		var query = queryString({'month' : month , 'year' : year});
		var result = doXHR(PATH + 'ShowMonthlyYearlyBDSummaryReport.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
		result.addCallbacks(OnSuccessShowBDSummary, OnFailShowBDSummary);
	}
}
function ShowBDSummaryReport(mode){
	if(mode == 'event_date'){
		var current_date = $('event_date').value;
	}else{
		$('event_date').value = "";
		var current_date = $('current_date').value;
	}
	
	$('summary').innerHTML = "Loading...";
	var query = queryString({'current_date' : current_date , 'mode' : mode});
	var result = doXHR(PATH + 'ShowBDSummaryReport.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowBDSummary, OnFailShowBDSummary);
}

function OnSuccessShowBDSummary(e){
	$('summary').innerHTML =  e.responseText;
}
function OnFailShowBDSummary(e){
	alert("Failed to show Business Developers Summary Report.");
}