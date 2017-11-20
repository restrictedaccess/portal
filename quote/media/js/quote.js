// JavaScript Document
var PATH = 'quote/';

function GetApplicantRates(e){
    var userid = $('userid').value;
	var work_status = $('work_status').value;
	var currency = $('currency').value;
	//log(userid);
	if(userid){
	    var result = doSimpleXMLHttpRequest(PATH + 'get_applicant_rates.php?userid='+userid+'&work_status='+work_status+'&currency='+currency);
	    result.addCallbacks(OnSuccessGetApplicantRates, OnFailGetApplicantRates);
	}else{
		var quoted_price = getNodeAttribute('quoted_price', 'quoted_price');
		if(quoted_price > 0){
		    $('quoted_price').value = getNodeAttribute('quoted_price', 'quoted_price');
		}
		ConfigureClientQuotedPrice();
	}
}

function OnSuccessGetApplicantRates(e){
	if(isNaN(e.responseText)){
		alert(e.responseText);
	}else{
		$('quoted_price').value = e.responseText;
		ConfigureClientQuotedPrice();
	}
}
function OnFailGetApplicantRates(e){
	alert("Failed to parse selected applicant price rate");
}
function ShowLeadQuote(e){
	var quote_id = getNodeAttribute(e.src(), 'quote_id');
	//log(quote_id);
	var query = queryString({'quote_id' : quote_id});
	var items = getElementsByTagAndClassName('div', 'quote_list');
	for (var item in items){
		
		 var item_quote_id = getNodeAttribute(items[item], 'quote_id');
		 if(quote_id == item_quote_id){
		     addElementClass(items[item], 'quote_list_selected');
		 }
    }
	var result = doXHR(PATH + 'show_lead_quote.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowLeadQuote, OnFailShowLeadQuote);
}

function OnSuccessShowLeadQuote(e){
	$('quote_details').innerHTML = e.responseText;
}

function OnFailShowLeadQuote(e){
	$('quote_details').innerHTML = "There was a problem in showing the Lead Quote.";
}

function ShowAllLeadQuotes(e){
	var leads_id = $('leads_id').value;
	var result = doSimpleXMLHttpRequest(PATH + 'show_all_lead_quotes.php?leads_id='+leads_id);
	result.addCallbacks(OnSuccessShowAllLeadQuotes, OnFailShowAllLeadQuotes);
}
function OnSuccessShowAllLeadQuotes(e){
	$('quote_list').innerHTML = e.responseText;
	if ($('quote_id')){
	   var quote_id = $('quote_id').value; 
	}
	var items = getElementsByTagAndClassName('div', 'quote_list');
	for (var item in items){
        connect(items[item], 'onclick', ShowLeadQuote);
		
		 //var item_quote_id = getNodeAttribute(items[item], 'quote_id');
		 //if(quote_id == item_quote_id){
		 //    addElementClass(items[item], 'quote_list_selected');
		 //}
    }
}

function OnFailShowAllLeadQuotes(e){
	$('quote_list').innerHTML = "There was a problem in parsing lead Quotes & Service Agreements.";
}

function AddUpdateQuoteDetail(e){
	var quote_id = getNodeAttribute(e.src(), 'quote_id');
	var mode = getNodeAttribute(e.src(), 'mode');
	var quote_detail_id = $('quote_detail_id').value;
	
	var work_position = $('work_position').value;
	var staff_country = $('staff_country').value;
	var staff_timezone = $('staff_timezone').value;
	var work_start = $('work_start').value;
	var work_finish = $('work_finish').value;
	var working_hours = $('working_hours').value;
	var days = $('days').value;
	var work_status = $('work_status').value;
	var staff_currency = $('staff_currency').value;
	var salary = $('salary').value;
	var no_of_staff = $('no_of_staff').value;
	var work_description = $('work_description').value;
	var client_timezone = $('client_timezone').value;
	var client_start_work_hour = $('client_start_work_hour').value;
	var client_finish_work_hour = $('client_finish_work_hour').value;
	var currency = $('currency').value;
	var quoted_price = $('quoted_price').value;
	var quoted_quote_range = $('quoted_quote_range').value;
	var userid = $('userid').value;
	
	if(work_position == ""){
		alert("Please enter a Job Position title");
		$('work_position').focus();
		return false;
	}
	
	if(salary == "" || salary == 0){
		alert("Please enter staff monthly salary");
		$('salary').focus();
		return false;
	}
	
	if(no_of_staff == "" || no_of_staff == 0){
		alert("Please enter number of staff needed");
		$('no_of_staff').focus();
		return false;
	}
	
	if(quoted_price == "" || quoted_price == 0){
		alert("Please enter Client Quoted Price");
		$('quoted_price').focus();
		return false;
	}
	
	
	if($('gst').checked == true){
		var gst = 'yes';
	}else{
		var gst = 'no';
	}
	
	if(mode == 'insert'){
		$('quote_detail_form_button').value = 'adding...';
		var msg_str = "Successfully added";
	}else{
		$('quote_detail_form_button').value = 'updating...';
		var msg_str = "Successfully updated";
	}
	$('quote_detail_form_cancel_button').disabled = true;
	$('quote_detail_form_button').disabled = true;
	
	var query = queryString({'quote_id' : quote_id, 'mode' : mode, 'quote_detail_id' : quote_detail_id, 'work_position' : work_position, 'staff_country' : staff_country, 'staff_timezone' : staff_timezone, 'work_start' : work_start, 'work_finish' : work_finish, 'working_hours' : working_hours, 'days' : days, 'work_status' : work_status, 'staff_currency' : staff_currency, 'salary' : salary, 'no_of_staff' : no_of_staff, 'work_description' : work_description, 'client_timezone' : client_timezone, 'client_start_work_hour' : client_start_work_hour, 'client_finish_work_hour' : client_finish_work_hour, 'currency' : currency, 'quoted_price' : quoted_price, 'quoted_quote_range' : quoted_quote_range, 'gst' : gst, 'userid' : userid});
	//log(query);
	//return false;
	var result = doXHR(PATH + 'add_update_quote_detail.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessAddUpdateQuoteDetail, OnFailAddUpdateQuoteDetail);


    function OnSuccessAddUpdateQuoteDetail(e){
        if(isNaN(e.responseText)){
	        alert(e.responseText);
	    }else{
			alert(msg_str);
		    var query = queryString({'quote_id' : e.responseText});
	        var result = doXHR(PATH + 'show_quote_details.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	        result.addCallbacks(OnSuccessShowQuote, OnFailShowQuote);
	    }
    }

}

function OnFailAddUpdateQuoteDetail(e){
	alert('Failed to execute script');
}


function ConfigureClientQuotedPrice(e){
    var currency = $('currency').value;
	var quoted_price = $('quoted_price').value;
	var working_hours = $('working_hours').value;
	var days = $('days').value;
	
	if(isNaN(quoted_price)){
	    alert("Please enter a valid amount for Quoted Price. Must be a number.");
		$('quoted_price').value = 0;
		$('quoted_price').focus();
		return false;
	}
	
	if(quoted_price == "") quoted_price = 0;
	if(currency != 'AUD'){
		$('gst').disabled = true;
		$('gst').checked = false;
	}else{
		$('gst').disabled = false;
		var gst_value = getNodeAttribute($('gst'), 'gst');
		if(gst_value > 0){
			$('gst').checked = true;
		}
	}
	//GetApplicantRates();
	var query = queryString({'currency' : currency, 'quoted_price' : quoted_price, 'working_hours' : working_hours, 'days' : days});
	if(quoted_price > 0){
		//log(query);
	    var result = doXHR(PATH + 'configure_client_quoted_price.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessConfigureClientQuotedPrice, OnFailConfigureClientQuotedPrice);
	}else{
		$('client_quoted_price_str').innerHTML = '&nbsp;';
	}
}

function OnSuccessConfigureClientQuotedPrice(e){
	$('client_quoted_price_str').innerHTML = e.responseText;
	//var userid = $('userid').value;
	//if(userid){
	//	log(userid);
	//}
}
function OnFailConfigureClientQuotedPrice(e){
	$('client_quoted_price_str').innerHTML = 'Configuring...';
}

function ConfigureQuotePricing(e){
    var staff_country = $('staff_country').value;
	var currency = $('currency').value;
	var salary = $('salary').value;
	//var currency_rate = 0;
	var working_hours = $('working_hours').value;
	var days = $('days').value;
	
	var work_status = $('work_status').value;
	//if(work_status == 'Full-Time'){
	//   var minus =  1;
	//}else{
	//   var minus =  0;
	//}

	//$('working_hours').value = (parseInt($('work_finish').value) - parseInt($('work_start').value)) - minus;
	//var working_hours = (parseInt($('work_finish').value) - parseInt($('work_start').value)) - minus;
	
	
	if(isNaN(salary)){
	    alert("Please enter a valid amount for staff salary. Must be a number.");
		$('salary').value = 0;
		$('salary').focus();
		return false;
	}
	if(salary == "") salary = 0;
	
	if(staff_country == 'Philippines'){
		$('staff_currency').value = 'PHP';
	}else{
		$('staff_currency').value = 'INR';
	}
	
	var query = queryString({'staff_country' : staff_country, 'currency' : currency, 'salary' : salary, 'working_hours' : working_hours, 'days' : days, 'work_status' : work_status});
	if(salary > 0){
	    var result = doXHR(PATH + 'configure_quote_price.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessConfigureQuotePricing, OnFailConfigureQuotePricing);
	}else{
		$('quote_pricing_div').innerHTML = '&nbsp;';
	}
}

function OnSuccessConfigureQuotePricing(e){
	$('quote_pricing_div').innerHTML = e.responseText;
}

function OnFailConfigureQuotePricing(e){
	$('quote_pricing_div').innerHTML = "Configuring...";
}

function ConfigureWorkingHours(e){
	var staff_timezone = $('staff_timezone').value;
	var work_status = $('work_status').value;
	var client_timezone = $('client_timezone').value;
	var client_start_work_hour = $('client_start_work_hour').value;
	var query = queryString({'staff_timezone' : staff_timezone, 'work_status' : work_status, 'client_timezone' : client_timezone, 'client_start_work_hour' : client_start_work_hour});
    if(work_status == 'Full-Time'){
	    $('working_hours').value = 8;
	}else{
		$('working_hours').value = 4;
	}
	
	var result = doXHR(PATH + 'configure_working_hours.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessConfigureWorkingHours, OnFailConfigureWorkingHours);
}

function OnSuccessConfigureWorkingHours(e){
	$('configure_working_hours_box').innerHTML = e.responseText;
	$('client_finish_work_hour').value  = getNodeAttribute($('configure_working_hours'), 'client_finish_work_hour');
	$('client_finish_work_hour_str').value = getNodeAttribute($('configure_working_hours'), 'client_finish_work_hour_str');
	
	$('work_start').value  = getNodeAttribute($('configure_working_hours'), 'work_start');
	//$('staff_start_work_hour_str').value  = getNodeAttribute($('configure_working_hours'), 'staff_start_work_hour_str');
	$('work_finish').value  = getNodeAttribute($('configure_working_hours'), 'work_finish');
	//$('staff_finish_work_hour_str').value  = getNodeAttribute($('configure_working_hours'), 'staff_finish_work_hour_str');
	
	//$('work_start_select').value=getNodeAttribute($('configure_working_hours'), 'work_start');
	//var work_status = $('work_status').value;
	//if(work_status == 'Full-Time'){
	//   var minus =  1;
	//}else{
	//   var minus =  0;
	//}

	//$('working_hours').value = 0;//parseInt($('work_finish').value);//(parseInt($('work_finish').value) - parseInt($('work_start').value) - parseInt(minus) ) ;
}

function OnFailConfigureWorkingHours(e){
	alert("Failed to configure working hours");
}

function QuoteDetails(e){
	var quote_id = getNodeAttribute(e.src(), 'quote_id');
	//alert('Add Quote Details => ' + quote_id);
	var query = queryString({'quote_id' : quote_id});
	//log(query);
	var result = doXHR(PATH + 'quote_details.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessQuoteDetails, OnFailQuoteDetails);
}

function OnSuccessQuoteDetails(e){
	$('quote_details').innerHTML = e.responseText;
	var quote_detail_id = $('quote_detail_id').value;
	if(quote_detail_id ==""){
		//auto set the working hours per timezone
		ConfigureWorkingHours();
	}
	ConfigureQuotePricing();
	ConfigureClientQuotedPrice();
	connect('client_start_work_hour', 'onchange', ConfigureWorkingHours);
	connect('staff_timezone', 'onchange', ConfigureWorkingHours);
	connect('client_timezone', 'onchange', ConfigureWorkingHours);
	
	connect('work_status', 'onchange', ConfigureWorkingHours);
	connect('work_status', 'onchange', ConfigureQuotePricing);
	connect('work_status', 'onchange', GetApplicantRates);
	
	
	connect('staff_country', 'onchange', ConfigureQuotePricing);
	connect('currency', 'onchange', GetApplicantRates);
	connect('quoted_price', 'onkeyup', ConfigureClientQuotedPrice);
	connect('salary', 'onkeyup', ConfigureQuotePricing);
	
	
	connect('quote_detail_form_cancel_button', 'onclick', ShowQuote);
	connect('quote_detail_form_button', 'onclick', AddUpdateQuoteDetail);
	
	connect('work_start', 'onchange', ConfigureQuotePricing);
	connect('work_finish', 'onchange', ConfigureQuotePricing);
	
	connect('userid', 'onchange', GetApplicantRates);
}

function OnFailQuoteDetails(e){
    $('quote_details').innerHTML = 'Failed to show Quote Details Form';
}

function DeleteQuote(e){
	var quote_id = getNodeAttribute(e.src(), 'quote_id');
	var query = queryString({'quote_id' : quote_id});
	var result = doXHR(PATH + 'delete_quote.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessDeleteQuote, OnFailDeleteQuote);
}

function OnSuccessDeleteQuote(e){
	$('quote_details').innerHTML = e.responseText;
	ShowAllQuotes();
}
function OnFailDeleteQuote(e){
	alert("There was a problem in deleting a Quote.");
}


function CloseQuote(e){
    $('quote_details').innerHTML = "Select a Quote on the list to view details.";
	var items = getElementsByTagAndClassName('div', 'quote_list');
	for (var item in items){
        removeElementClass(items[item], 'quote_list_selected');
    }
	$('leads_id').value="";
}
function SelectLead(e){
    var leads_id = getNodeAttribute(e.src(), 'value');
	$('leads_id').value = leads_id;
	CreateNewQuote();
}

function SearchLead(e){
    var str = $('str').value;
	var search_by = $('search_by').value;
	var query = queryString({'str' : str, 'search_by' : search_by});
	//log(query);
	if(str != ""){
	    var result = doXHR(PATH + 'search_lead.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessSearchLead, OnFailSearchLead);
	}
}

function OnSuccessSearchLead(e){
    $('create_new_quote').innerHTML = e.responseText;
	var items = getElementsByTagAndClassName('input', 'leads_selection');
	for (var item in items){
        connect(items[item], 'onclick', SelectLead);
    }
	connect('close_btn', 'onclick', CloseQuote);
}
function OnFailSearchLead(e){
	$('create_new_quote').innerHTML = "There's a problem in search leads";
}

function GenerateQuote(e){
    var id = $('id').value;
	//var currency = $('currency').value;
	var query = queryString({'id' : id});
	//log(query);
	$('generate_btn').value = 'generating...';
	$('generate_btn').disabled = true;
	var result = doXHR(PATH + 'generate_quote.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessGenerateQuote, OnFailGenerateQuote);
}

function OnSuccessGenerateQuote(e){
	var quote_id = e.responseText;
	if(isNaN(quote_id)){
	    alert(e.responseText);
		$('generate_btn').value = 'Generate Quote';
	    $('generate_btn').disabled = false;
		return false;
	}
	$('leads_id').value = "";
	$('quote_details').innerHTML = "Loading Quote Details...";
	var query = queryString({'quote_id' : quote_id});
	var result = doXHR(PATH + 'show_quote_details.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowQuote, OnFailShowQuote);
	ShowAllQuotes(e);
}

function OnFailGenerateQuote(e){
    alert("There's a problem in creating a quote");
}

function CreateNewQuote(e){
	var leads_id = $('leads_id').value;
	var items = getElementsByTagAndClassName('div', 'quote_list');
	for (var item in items){
        removeElementClass(items[item], 'quote_list_selected');
    }
		
	var result = doSimpleXMLHttpRequest(PATH + 'create_new_quote.php?leads_id='+leads_id);
	result.addCallbacks(OnSuccessCreateNewQuote, OnFailCreateNewQuote);
}

function OnSuccessCreateNewQuote(e){
    $('quote_details').innerHTML = e.responseText;
	connect('search_lead_btn', 'onclick', SearchLead);
	if($('generate_btn')){
	    connect('generate_btn', 'onclick', GenerateQuote);
		connect('close_btn', 'onclick', CloseQuote);
	}
}
function OnFailCreateNewQuote(e){
	$('quote_details').innerHTML = "There's a problem in showing Create Quote Form.";
}


function ShowAllQuotes(e){
	var keyword = $('keyword').value;
	var result = doSimpleXMLHttpRequest(PATH + 'show_all_quotes.php?keyword='+keyword);
	result.addCallbacks(OnSuccessShowAllQuotes, OnFailShowAllQuotes);
}

function OnSuccessShowAllQuotes(e){
	$('quote_list').innerHTML = e.responseText;
	
	//var quote_id = $('quote_id').value;
	if ($('quote_id')){
	   var quote_id = $('quote_id').value; 
	}
	var items = getElementsByTagAndClassName('div', 'quote_list');
	for (var item in items){
        connect(items[item], 'onclick', ShowQuote);
		
		 var item_quote_id = getNodeAttribute(items[item], 'quote_id');
		 if(quote_id == item_quote_id){
		     addElementClass(items[item], 'quote_list_selected');
		 }
    }
	
}
function OnFailShowAllQuotes(e){
	$('quote_list').innerHTML = "There's a problem in parsing all quote list.";
}

function ShowQuote(e){
    var quote_id  = getNodeAttribute(e.src(), 'quote_id');
	$('quote_details').innerHTML = "Loading Quote Details...";
	var query = queryString({'quote_id' : quote_id});
	var items = getElementsByTagAndClassName('div', 'quote_list');
	for (var item in items){
        removeElementClass(items[item], 'quote_list_selected');
		
		 var item_quote_id = getNodeAttribute(items[item], 'quote_id');
		 if(quote_id == item_quote_id){
		     addElementClass(items[item], 'quote_list_selected');
		 }
    }
	
	var result = doXHR(PATH + 'show_quote_details.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowQuote, OnFailShowQuote);
}

function OnSuccessShowQuote(e){
	$('quote_details').innerHTML = e.responseText;
	connect('close_btn', 'onclick', CloseQuote);
	connect('add_quote_details_btn', 'onclick', QuoteDetails);
	connect('delete_quote_btn', 'onclick', DeleteQuote);
	
	var status = $('status').value;
	if(status == 'new'){
		
		var items = getElementsByTagAndClassName('span', 'q_details_control_edit_link');
	    for (var item in items){
		    connect(items[item], 'onclick', EditQuoteDetails);
        }
		
		var items = getElementsByTagAndClassName('span', 'q_details_control_delete_link');
	    for (var item in items){
		    connect(items[item], 'onclick', DeleteQuoteDetails);
        }
		
		//var items = getElementsByTagAndClassName('span', 'q_details_control_note_link');
	    //for (var item in items){
		//    connect(items[item], 'onclick', AddNote);
        //}
		
	}
}
function OnFailShowQuote(e){
	$('quote_details').innerHTML = "Problem in parsing Quote Details";
}

function EditQuoteDetails(e){
	var quote_id = getNodeAttribute(e.src(), 'quote_id');
	var quote_detail_id = getNodeAttribute(e.src(), 'detail_id');
	var query = queryString({'quote_id' : quote_id, 'quote_detail_id' : quote_detail_id});
	var result = doXHR(PATH + 'quote_details.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessQuoteDetails, OnFailQuoteDetails);
}

function DeleteQuoteDetails(e){
	var quote_id = getNodeAttribute(e.src(), 'quote_id');
	var quote_detail_id = getNodeAttribute(e.src(), 'detail_id');
	var query = queryString({'quote_id' : quote_id, 'quote_detail_id' : quote_detail_id});
	var result = doXHR(PATH + 'delete_quote_details.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessDeleteQuoteDetails, OnFailDeleteQuoteDetails);
}

function OnSuccessDeleteQuoteDetails(e){
	if(isNaN(e.responseText)){
	    alert(e.responseText);
	}else{
	    alert("Successfully removed.");
		$('quote_details').innerHTML = "Loading...";
	    var query = queryString({'quote_id' : e.responseText});
	    var result = doXHR(PATH + 'show_quote_details.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessShowQuote, OnFailShowQuote);
	}
}
function OnFailDeleteQuoteDetails(e){
	alert("There was a problem in removing Quote details");
}
function AddNote(e){
	var quote_id = getNodeAttribute(e.src(), 'quote_id');
	var quote_detail_id = getNodeAttribute(e.src(), 'detail_id');
	var query = queryString({'quote_id' : quote_id, 'quote_detail_id' : quote_detail_id});
	alert(query);
}