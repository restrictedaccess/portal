// JavaScript Document
var PATH = 'job_title/';
connect(window, "onload", OnLoadGetAllJobTitles);


function loadJobPositionHistory(jr_name){
	$('job_title_list_history').innerHTML = "Loading Job Positions History....";
	var query = queryString({'jr_name' : jr_name});
	//alert(query);
	var result = doXHR(PATH + 'loadJobPositionHistory.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessLoadJobPositionHistory, OnFailLoadJobPositionHistory);

	function OnSuccessLoadJobPositionHistory(e){
		$('job_title_list_history').innerHTML = e.responseText;
		if(jr_name=='False'){
			$('his-info').innerHTML = "All Job Positions";
		}else{
			$('his-info').innerHTML = jr_name;	
		}
	}
	
	
	function OnFailLoadJobPositionHistory(e){
		$('job_title_list_history').innerHTML = e.responseText;
	}

}
function removeJobTitleName(){
	var jr_name = $('jr_name_spn').innerHTML;
		
	if(confirm("Remove Job title '"+jr_name+"' from the list?")){
		$('right_pane').innerHTML = "Removing "+jr_name+" from the list...";
		var query = queryString({'jr_name' : jr_name});
		var result = doXHR(PATH + 'removeJobTitleName.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
		result.addCallbacks(OnSuccessRemoveJobTitleName, OnFailRemoveJobTitleName);
	}
	
}
function OnSuccessRemoveJobTitleName(e){
	OnLoadGetAllJobTitles();
	$('right_pane').innerHTML = e.responseText;
	loadJobPositionHistory('False');
	
}
function OnFailRemoveJobTitleName(e){
	alert("Failed to removed job title. Please try again");	
}

function addJobTitle(){
	var jr_cat_id = $('category').value;
	var jr_name = $('jr_name').value;
	
	if(jr_cat_id == 0){
		alert("Please selecd Job Category");
		return false;
	}
	if(jr_name ==""){
		alert("Please add a Job title name");
		return false;
	}
		
	$('right_pane').innerHTML = "Processing...";
	var query = queryString({'jr_cat_id' : jr_cat_id , 'jr_name' : jr_name });
	var result = doXHR(PATH + 'addJobTitle.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessAddJobTitle, OnFailAddJobTitle);
	
	function OnSuccessAddJobTitle(e){
		var title = e.responseText;
		
		if(isNaN(title)){
			OnLoadGetAllJobTitles();
			alert(title + " successfully added.\n You can now add different level prices per currency");
			showJobTitlePrice(title);
		}else{
			alert(jr_name+" already exist. Please try to add a different job title name.")
			$('right_pane').innerHTML = "<strong>"+jr_name+"</strong> already exist.Please try to add a different job title name.";	
			//alert(title);
		}
	}
	
	function OnFailAddJobTitle(e){
		alert("Failed adding new Job Title. Please try again later");
	}

}

function showAddJobTitleForm(){
	$('right_pane').innerHTML = "Loading...";
	var result = doSimpleXMLHttpRequest(PATH + 'showAddJobTitleForm.php');
    result.addCallbacks(OnSuccessShowAddJobTitleForm, OnFailShowAddJobTitleForm);
}
function OnSuccessShowAddJobTitleForm(e){
	$('right_pane').innerHTML = e.responseText;
}
function OnFailShowAddJobTitleForm(e){
	alert("Failed to show Add Job Title Form");
}


function editJobTitleName(){
	toggle('edit_jr_name');
	$('title_name').value = $('jr_name_spn').innerHTML;
	
}
function updateJobTitleName(jr_name){
	var title_name = $('title_name').value;
	var jr_name = $('jr_name_spn').innerHTML;
	var query = queryString({'jr_name' : jr_name , 'title_name' : title_name});
	//alert(query);
	$('jr_name_spn').innerHTML = "Processing...";
	var result = doXHR(PATH + 'updateJobTitleName.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateJobTitleName, OnFailUpdateJobTitleName);
	
	function OnSuccessUpdateJobTitleName(e){
		OnLoadGetAllJobTitles();
		toggle('edit_jr_name');
		$('title_name').value = "";
		$('jr_name_spn').innerHTML = e.responseText;
		loadJobPositionHistory(e.responseText);
		//alert(e.responseText);
	}
	function OnFailUpdateJobTitleName(e){
		alert("Failed to Update Job Title name");
	}
	
}




function updateJobTitlePrices(jr_name , currency , jr_list_id){

	var entry_price = $('entry_price_'+currency).value;
	var mid_price = $('mid_price_'+currency).value;
	var expert_price = $('expert_price_'+currency).value;
	
	
	$('currency_'+currency).innerHTML = "Processing changes...";
	
	var query = queryString({'jr_name' : jr_name , 'jr_list_id' : jr_list_id , 'currency' : currency , 'entry_price' : entry_price , 'mid_price' : mid_price , 'expert_price' : expert_price  });
	//alert(query);
	
	var result = doXHR(PATH + 'updateJobTitlePrices.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateJobTitlePrices, OnFailUpdateJobTitlePrices);

	function OnSuccessUpdateJobTitlePrices(e){
		$('currency_'+currency).innerHTML = "Loading...";
		alert(jr_name+" "+currency+" prices are updated");
		//showJobTitlePrice(jr_name);
		$('currency_'+currency).innerHTML = e.responseText;
		loadJobPositionHistory(jr_name);
	}
	function OnFailUpdateJobTitlePrices(e){
		alert("Failed to update "+ jr_name + " level prices.");
	}
}


function showJobTitlePrice(jr_name){
	//alert(jr_name);
	if(jr_name!="False"){
		$('right_pane').innerHTML = "Loading "+jr_name+" history";
	}else{
		$('right_pane').innerHTML = "Loading...";	
	}
	var query = queryString({'jr_name' : jr_name });
	var result = doXHR(PATH + 'showJobTitlePrice.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowJobTitlePrice, OnFailJobTitlePrice);


	function OnSuccessShowJobTitlePrice(e){
		$('right_pane').innerHTML = e.responseText;
		loadJobPositionHistory(jr_name);
	}
	function OnFailJobTitlePrice(e){
		alert("Failed to show Job Title Prices");
	}

}

function OnLoadGetAllJobTitles(){
	var result = doSimpleXMLHttpRequest(PATH + 'GetAllJobTitle.php');
    result.addCallbacks(OnSuccessGetAllJobTitle, OnFailGetAllJobTitle);
}

function OnSuccessGetAllJobTitle(e){
	$('job_title_list').innerHTML = e.responseText;
}

function OnFailGetAllJobTitle(e){
	alert("Failed to parse all Job Titles");
}


