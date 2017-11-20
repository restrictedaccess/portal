// JavaScript Document
var PATH="./";

function GetClientType(){
	var ins = document.getElementsByName('client_type')
	var i;
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			return ins[i].value;
			break;
		}
	}

}

function check_leads_val(e){	
	var ins = document.getElementsByName('lead');
	var i;
	var j=0;
	var vals= new Array();
	for(i=0;i<ins.length;i++){
		if(ins[i].value!=""){
			vals[j]=ins[i].value;
		}
	}
	$('leads_id').value=(vals);
}
function CheckFilter(e){
	var elem = getNodeAttribute(e.src(), 'rel');
	//log(e.src().value);
	if(e.src().value == 'leads_id'){
		$(elem).disabled=false;
		//$('csro_id').disabled = true;
	}else{
		$(elem).disabled=true;
		$(elem).value="";
		//$('csro_id').disabled = false;
	}
}

function CheckCSRO(e){
	var active_client_filter = $('active_client_filter').value;
	var inactive_client_filter = $('inactive_client_filter').value;
	$('csro_id').disabled = false;
	$('csro_id').value = "";
	if(active_client_filter == 'leads_id' || inactive_client_filter == 'leads_id'){
		$('csro_id').disabled = true;
	}
	log(active_client_filter +' '+inactive_client_filter);
}
function GetClientHistory(e){
	var from = $('from').value;
	var to = $('to').value;
	
	var leads_id=$('leads_id').value;
	if(leads_id == ""){
		alert("Please choose a client");
		return false;
	}
	
	var query = queryString({'from' : from, 'to' : to, 'leads_id' : leads_id});
    //alert(query);
	//return false;
	$('search_client_btn').disabled = true;
	$('results').innerHTML = 'Rendering results please wait...';

    var result = doXHR(PATH + 'clients_csro_name_changed_history.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessGetClientHistory, OnFailGetClientHistory);
	
}

function OnSuccessGetClientHistory(e){
	$('search_client_btn').disabled = false;
	$('results').innerHTML = e.responseText;
}
function OnFailGetClientHistory(e){
	$('search_client_btn').disabled = false;
	$('results').innerHTML = e.responseText;
}


function GenerateCouchDocId(e){
	var from = $('from').value;
	var to = $('to').value;
	
	var active_client = $('active_client').value;
	var inactive_client = $('inactive_client').value;
	
	
	
	var active_client_filter = $('active_client_filter').value;
	var inactive_client_filter = $('inactive_client_filter').value;
	var filter = GetClientType();
	//alert(client_type);
	
	var csro_id = $('csro_id').value;

	if(active_client_filter == 'leads_id'){
		if(active_client == ""){
			alert("No Active Client Selected.");
			return false;
		}
	}
	
	if(inactive_client_filter == 'leads_id'){
		if(inactive_client == ""){
			alert("No Inactive Client Selected.");
			return false;
		}
	}
	
	
	
	
	var query = queryString({'from' : from, 'to' : to, 'active_client_filter' : active_client_filter, 'inactive_client_filter' : inactive_client_filter, 'active_client' : active_client, 'inactive_client' : inactive_client, 'filter' : filter, 'csro_id' : csro_id});
    log(query);
	//return false;
	$('search_btn').disabled = true;
	$('search_btn').value = 'processing...';
	$('results').innerHTML = 'Generating CouchDB Document ID...';

    var result = doXHR(PATH + 'GenerateCouchDocId.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessGenerateCouchDocId, OnFailGenerateCouchDocId);
}


function OnSuccessGenerateCouchDocId(e){
	$('results').innerHTML = e.responseText;
	if($('doc_id')){
		var doc_id =  $('doc_id').value;
		RunTimerForRendering(doc_id);
	}else{
		$('search_btn').disabled = false;
		$('search_btn').value = 'Search';
	}
	
}

function OnFailGenerateCouchDocId(e){
	$('results').innerHTML = e.responseText;
	$('search_btn').disabled = false;
	$('search_btn').value = 'Search';
}

function RunTimerForRendering(doc_id){    
	$('results').innerHTML = 'Rendering results. Please wait...';
	setTimeout(function(){RenderCouchDocument(doc_id)},5000);
	
}

function RenderCouchDocument(doc_id){
	var from = $('from').value;
	var to = $('to').value;
	var result = doSimpleXMLHttpRequest(PATH + 'RenderCouchDocument.php?doc_id='+doc_id+"&from="+from+"&to="+to);
	result.addCallbacks(OnSuccessRenderCouchDocument, OnFailRenderCouchDocument);


    function OnSuccessRenderCouchDocument(e){
	    if(e.responseText == 'continue'){
		    //RenderCouchDocument(doc_id);
			RunTimerForRendering(doc_id);
			//setInterval(function(){RenderCouchDocument(doc_id)},3000);
	    }else{
		    $('results').innerHTML = e.responseText;
			$('search_btn').disabled = false;
	        $('search_btn').value = 'Search';
			connect('export_btn', 'onclick', ExportCouchDocument);
	    }
    }

    function OnFailRenderCouchDocument(e){
	    $('results').innerHTML = e.responseText;
    }

}

function ExportCouchDocument(e){
	var doc_id = getNodeAttribute(e.src(), 'doc_id');
	var from = $('from').value;
	var to = $('to').value;
	location.href=PATH + "ExportCouchDocument.php?doc_id="+doc_id+"&from="+from+"&to="+to;
}