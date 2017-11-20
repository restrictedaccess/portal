//2011-09-20 Normaneil E. Macutay <normanm@remotestaff.com.au>

PATH ="invoice/client/";
function ShowInvoiceDetails(e){
	var id = getNodeAttribute(e.src(), 'invoice_id');
	//appear('overlay');
	var query = queryString({ 'id' : id});
	var result = doXHR(PATH +'ShowInvoiceDetails.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowInvoiceDetails, OnFailShowInvoiceDetails);
}
function OnSuccessShowInvoiceDetails(e){
	appear('overlay');
	
	$('invoice_form').innerHTML = e.responseText;
	
	//place the div in the center of the screen
	//var wd = 620;
	//var hg = 500;
	//var xpos = screen.availWidth/2 - wd/2; 
    //var ypos = screen.availHeight/2 - hg/2;
    //$('invoice_form').style.left = xpos+"px";
	//$('invoice_form').style.top = ypos+"px";
	//log(hg);
	connect('close_link', 'onclick', CloseInvoiceForm);
}
function OnFailShowInvoiceDetails(e){
	alert("Failed to show invoice details");
}

function CloseInvoiceForm(e){
	fade('overlay');
}
function exportToCSV(status){
	month = document.getElementById("month").value;
	year = document.getElementById("year").value;
	client = document.getElementById("client_id").value;
	
	
	
	var url="invoice/adminExportClientInvoiceToCSV.php";
	url=url+"?month="+month;
	url=url+"&year="+year;
	url=url+"&client="+client;
	url=url+"&status="+status;
	//alert(url);return false;
	
	
	
    location.href =url;
   
}

function MoveInvoiceToPaidSection(e){
	var id = getNodeAttribute(e.src(), 'invoice_id');
	var paid_date = $('invoice_paid_date_str').value;
	var query = queryString({ 'id' : id, 'paid_date' : paid_date });
	//alert(query);
	if(paid_date == ""){
		alert("Paid Date is required");
		return false;
	}
	var result = doXHR(PATH +'MoveInvoiceToPaidSection.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessMoveInvoiceToPaidSection, OnFailMoveInvoiceToPaidSection);
}
function OnSuccessMoveInvoiceToPaidSection(e){
	if(isNaN(e.responseText)){
	    alert(e.responseText);
	}else{
		$('right_panel').innerHTML = "Loading...";
	    var id = e.responseText;
	    var query = queryString({ 'id' : id });
	    var result = doXHR(PATH +'ShowClientInvoiceDetails.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessShowClientInvoiceDetails2, OnFailShowClientInvoiceDetails);
	}
}
function OnFailMoveInvoiceToPaidSection(e){
	alert("Failed to move invoice to Paid section");
}

function ShowPaidDateForm(e){
	var id = getNodeAttribute(e.src(), 'invoice_id');
	var query = queryString({ 'id' : id });
	//alert(query);
	var result = doXHR(PATH +'ShowPaidDateForm.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowPaidDateForm, OnFailShowPaidDateForm);
}
function OnSuccessShowPaidDateForm(e){
	appear('invoice_paid_date_form');
    $('invoice_paid_date_form').innerHTML = e.responseText;
	Calendar.setup({
            inputField : "invoice_paid_date_str",
            trigger    : "invoice_invoice_paid_date_btn",
            onSelect   : function() { this.hide()  },
            //showTime   : 12,
			fdow  : 0,
            dateFormat : "%Y-%m-%d"

    });
	
	connect('update_paid_date', 'onclick', MoveInvoiceToPaidSection);
}
function OnFailShowPaidDateForm(e){
	alert("Failed to show Paid Date Form");
}
function SearchInvoiceNumber(e){
	var invoice_no_str = $('invoice_no_str').value;
	if(invoice_no_str !=""){
        if(!isNaN(invoice_no_str)){
		    $('invoice_no_loading').innerHTML = "<img align='top' src='images/loading.gif' WIDTH='15' HEIGHT ='15'>";
		}else{
			$('invoice_no_loading').innerHTML = "Invalid number!";
			return false;
		}
	}else{
		$('invoice_no_loading').innerHTML = "";
		showAllClientInvoiceList();
		return false;
	}
	var query = queryString({ 'invoice_no_str' : invoice_no_str});
	var result = doXHR(PATH +'searchInvoiceNumber.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowAllClientInvoiceList, OnFailSearchInvoiceNumber);
}

function OnFailSearchInvoiceNumber(e){
	alert("Failed to search invoice number");
}
function UpdateClientInvoiceStatus(e){
	var id = getNodeAttribute(e.src(), 'invoice_id');
	var status = getNodeAttribute(e.src(), 'status');
	var query = queryString({ 'id' : id, 'status' : status });
	var result = doXHR(PATH +'UpdateClientInvoiceStatus.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateClientInvoiceStatus, OnFailUpdateClientInvoiceStatus);
}

function OnSuccessUpdateClientInvoiceStatus(e){
	if(isNaN(e.responseText)){
	    alert(e.responseText);
	}else{
		$('right_panel').innerHTML = "Loading...";
	    var id = e.responseText;
	    var query = queryString({ 'id' : id });
	    var result = doXHR(PATH +'ShowClientInvoiceDetails.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessShowClientInvoiceDetails2, OnFailShowClientInvoiceDetails);
	}
}

function OnSuccessShowClientInvoiceDetails2(e){
	$('right_panel').innerHTML = e.responseText;
	connect('add_invoice_item', 'onclick', AddInvoiceItem);
	/*
	var invoice_status = $('invoice_status').value;
	if(invoice_status != 'paid'){
	    var items = getElementsByTagAndClassName('img', 'edit_delete_invoice_item', 'invoice_items_box');
	    for (var item in items){
            connect(items[item], 'onclick', EditDeleteInvoiceItem);
        }
		
		connect('edit_due_date', 'onclick', ShowDueDateForm);
		
	}
	*/
	connect('add_remove_gst', 'onclick', AddRemoveGST);
	connect('move_to_paid_btn', 'onclick', ShowPaidDateForm);
	connect('remove_btn', 'onclick', UpdateClientInvoiceStatus);
	
	showAllClientInvoiceList();
}

function OnFailUpdateClientInvoiceStatus(e){
	alert("Failed to update client invoice status");
}

function CreateBlankClientInvoice(e){
	var leads_id = $('leads_id').value;
	var description = $('description').value;
	var currency = $('currency').value;
	var invoice_month = $('invoice_month').value;
	var invoice_year = $('invoice_year').value;
	
	if(leads_id == '0'){
		alert("Please select a client");
		return false;
	}
	if(description == ""){
		alert("Please enter Invoice Description");
		return false;
	}
	
	var query = queryString({ 'leads_id' : leads_id, 'description' : description, 'currency' : currency, 'invoice_month' : invoice_month, 'invoice_year' : invoice_year });
	var result = doXHR(PATH +'CreateBlankClientInvoice.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateClientInvoiceStatus, OnFailCreateBlankClientInvoice);
	
}

function OnSuccessCreateBlankClientInvoice(e){
	$('blank_invoice_result').innerHTML = e.responseText;
}
function OnFailCreateBlankClientInvoice(e){
	$('right_panel').innerHTML = "Failed to create Client blank invoice";
}
function ShowBlankFormInvoice(){
	$('right_panel').innerHTML = "Loading...";
	var result = doSimpleXMLHttpRequest(PATH + 'adminGetBlankClientInvoiceForm.php');
	result.addCallbacks(OnSuccessShowBlankFormInvoice, OnFailShowBlankFormInvoice);
	
	var items = getElementsByTagAndClassName('div', 'invoice_row');
	for (var item in items){
        removeElementClass(items[item], 'invoice_row_highlighted');
    }
}
function OnSuccessShowBlankFormInvoice(e){
	$('right_panel').innerHTML = e.responseText;
	connect('create_black_invoice_btn', 'onclick', CreateBlankClientInvoice);
}

function OnFailShowBlankFormInvoice(e){
	$('right_panel').innerHTML = "Failed to load  Blank Invoice Form";
}

function AddRemoveGST(e){
	var id = getNodeAttribute(e.src(), 'invoice_id');
	var method = getNodeAttribute(e.src(), 'method');
	var query = queryString({ 'id' : id, 'method' : method });
	var result = doXHR(PATH +'AddRemoveGST.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSaveInvoiceItem, OnFailAddRemoveGST);
}

function OnFailAddRemoveGST(e){
	alert("Failed to update GST");
}
function UpdateDueDate(e){
	var id = getNodeAttribute(e.src(), 'invoice_id');
	var due_date = $('invoice_payment_due_date_edit').value;
	
	
	if(id==""){
		alert("Invoice ID is missing");
		return false;
	}
	
	if(due_date==""){
		alert("Due Date is required");
		return false;
	}
	var query = queryString({ 'id' : id, 'due_date' : due_date });
	var result = doXHR(PATH +'updateDueDate.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateDueDate, OnFailUpdateDueDate);
}

function OnSuccessUpdateDueDate(e){
	fade('invoice_due_date_box');
	$('invoice_payment_due_date').innerHTML =e.responseText;
}

function OnFailUpdateDueDate(e){
	alert("Failed to update due date");
}

function ShowDueDateForm(e){
	var id = getNodeAttribute(e.src(), 'invoice_id');
	var query = queryString({ 'id' : id });
	var result = doXHR(PATH +'ShowDueDateForm.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowDueDateForm, OnFailShowDueDateForm);
}

function OnSuccessShowDueDateForm(e){
	appear('invoice_due_date_box');
	$('invoice_due_date_box').innerHTML = e.responseText;
	Calendar.setup({
            inputField : "invoice_payment_due_date_edit",
            trigger    : "invoice_payment_due_date_btn",
            onSelect   : function() { this.hide()  },
            //showTime   : 12,
			fdow  : 0,
            dateFormat : "%Y-%m-%d"

    });
	
	connect('update_due_date', 'onclick', UpdateDueDate);
}
function OnFailShowDueDateForm(e){
	alert("Failed to show Invoice Payment Due Date Edit Form");
}

function UpdateInvoiceItem(e){
	var id = getNodeAttribute(e.src(), 'invoice_id');
	var item_id = getNodeAttribute(e.src(), 'item_id');
	var start_date = $('start_date').value;
	var end_date = $('end_date').value;
	var description = $('description').value;
	var amount = $('amount').value;
	
	if(id==""){
		alert("Invoice ID is missing");
		return false;
	}
	
	if(item_id==""){
		alert("Invoice Detail ID is missing");
		return false;
	}
	
	if(description == ""){
		alert("Item description is required");
		return false;
	}
	
	if(amount ==""){
		alert("Please enter an amount");
		return false;
	}
	
	if(isNaN(amount)){
		alert("Please enter a valid amount");
		return false;
	}
	var query = queryString({ 'id' : id, 'item_id' : item_id, 'start_date' : start_date, 'end_date' : end_date, 'description' : description, 'amount' : amount  });
	//alert(query);
	var result = doXHR(PATH +'UpdateInvoiceItem.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSaveInvoiceItem, OnFailUpdateInvoiceItem);
}

function OnFailUpdateInvoiceItem(e){
	alert("Failed to update invoice item");
}
function EditDeleteInvoiceItem(e){
	 var id = getNodeAttribute(e.src(), 'invoice_id');
	 var item_id = getNodeAttribute(e.src(), 'item_id');
	 var method = getNodeAttribute(e.src(), 'method');
	 var description = getNodeAttribute(e.src(), 'description');
	 //log(item_id+" "+method);
	 if(method == 'edit'){
		 var query = queryString({ 'id' : id, 'item_id' : item_id  });
	     var result = doXHR(PATH +'EditInvoiceItemForm.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	     result.addCallbacks(OnSuccessEditInvoiceItemForm, OnFailEditInvoiceItemForm);
	 }
	 if(method == 'delete'){
		 if(confirm("Are you sure you want to delete \n'"+description+"'")){
		     var query = queryString({ 'id' : id, 'item_id' : item_id  });
	         var result = doXHR(PATH +'DeleteInvoiceItem.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	         result.addCallbacks(OnSuccessSaveInvoiceItem, OnFailDeleteInvoiceItem);
		 }
	 }
}

function OnFailDeleteInvoiceItem(e){
	alert("Failed to delete Invoice item");
}
function OnSuccessEditInvoiceItemForm(e){
	appear('edit_div');
	$('edit_div').innerHTML = e.responseText;
	
	Calendar.setup({
            inputField : "start_date",
            trigger    : "cal_start_date",
            onSelect   : function() { this.hide()  },
            //showTime   : 12,
			fdow  : 0,
            dateFormat : "%Y-%m-%d"

    });
		
	Calendar.setup({
            inputField : "end_date",
            trigger    : "cal_end_date",
            onSelect   : function() { this.hide() },
            fdow  : 0,
            dateFormat : "%Y-%m-%d"
    });
	
	connect('update_invoice_item', 'onclick', UpdateInvoiceItem);
}
function OnFailEditInvoiceItemForm(e){
	alert("Failed to show Edit Invoice Item Form");
}

function SaveInvoiceItem(e){
	var id = getNodeAttribute(e.src(), 'invoice_id');
	var start_date = $('start_date').value;
	var end_date = $('end_date').value;
	var description = $('description').value;
	var amount = $('amount').value;
	
	if(id==""){
		alert("Invoice ID is missing");
		return false;
	}
	
	if(description == ""){
		alert("Item description is required");
		return false;
	}
	
	if(amount ==""){
		alert("Please enter an amount");
		return false;
	}
	
	if(isNaN(amount)){
		alert("Please enter a valid amount");
		return false;
	}
	var query = queryString({ 'id' : id, 'start_date' : start_date, 'end_date' : end_date, 'description' : description, 'amount' : amount  });
	var result = doXHR(PATH +'SaveInvoiceItem.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSaveInvoiceItem, OnFailSaveInvoiceItem);
}
function OnSuccessSaveInvoiceItem(e){
	if(isNaN(e.responseText)){
	    alert(e.responseText);
	}else{
		$('right_panel').innerHTML = "Loading...";
	    var id = e.responseText;
	    var query = queryString({ 'id' : id });
	    var result = doXHR(PATH +'ShowClientInvoiceDetails.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessShowClientInvoiceDetails, OnFailShowClientInvoiceDetails);
	}
}
function OnFailSaveInvoiceItem(e){
	alert("Failed to add new invoice item");
}
function AddInvoiceItem(e){
	var id = getNodeAttribute(e.src(), 'invoice_id');
	var query = queryString({ 'id' : id });
	var result = doXHR(PATH +'AddInvoiceItemForm.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessAddInvoiceItem, OnFailAddInvoiceItem);
}
function OnSuccessAddInvoiceItem(e){
	appear('edit_div');
	$('edit_div').innerHTML = e.responseText;
	
	Calendar.setup({
            inputField : "start_date",
            trigger    : "cal_start_date",
            onSelect   : function() { this.hide()  },
            //showTime   : 12,
			fdow  : 0,
            dateFormat : "%Y-%m-%d"

    });
		
	Calendar.setup({
            inputField : "end_date",
            trigger    : "cal_end_date",
            onSelect   : function() { this.hide() },
            fdow  : 0,
            dateFormat : "%Y-%m-%d"
    });
	
	connect('save_invoice_item', 'onclick', SaveInvoiceItem);
	
}
function OnFailAddInvoiceItem(e){
	alert("Failed to show Invoice Add Item Form");
}
function ShowClientInvoiceDetails(e){
	var items = getElementsByTagAndClassName('div', 'invoice_row');
	for (var item in items){
        removeElementClass(items[item], 'invoice_row_highlighted');
    }
    addElementClass(e.src(), 'invoice_row_highlighted');
	var id = getNodeAttribute(e.src(), 'value');
    var status = getNodeAttribute(e.src(), 'status');
	$('invoice_status').value= status;
    $('right_panel').innerHTML = "Loading...";
	var query = queryString({ 'id' : id });
	var result = doXHR(PATH +'ShowClientInvoiceDetails.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowClientInvoiceDetails, OnFailShowClientInvoiceDetails);
}

function OnSuccessShowClientInvoiceDetails(e){
	$('right_panel').innerHTML = e.responseText;
	connect('add_invoice_item', 'onclick', AddInvoiceItem);
	
	var invoice_status = $('invoice_status').value;
	if(invoice_status == 'draft' || invoice_status == 'posted' ){
	    var items = getElementsByTagAndClassName('img', 'edit_delete_invoice_item', 'invoice_items_box');
	    for (var item in items){
            connect(items[item], 'onclick', EditDeleteInvoiceItem);
        }
		
		connect('edit_due_date', 'onclick', ShowDueDateForm);
		
	}
	
	connect('add_remove_gst', 'onclick', AddRemoveGST);
	connect('move_to_paid_btn', 'onclick', ShowPaidDateForm);
	connect('remove_btn', 'onclick', UpdateClientInvoiceStatus);
	
	
}

function OnFailShowClientInvoiceDetails(e){
	$('right_panel').innerHTML = "Failed to show client invoice details";
}

function showAllClientInvoiceList(){
	
	var month = $("month").value;
	var year = $("year").value;
	var client = $("client_id").value;
	
	var query = queryString({ 'month' : month, 'year' : year, 'client' : client });
	var result = doXHR(PATH +'ShowAllClientInvoiceList.php', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowAllClientInvoiceList, OnFailShowAllClientInvoiceList);
	
}

function OnSuccessShowAllClientInvoiceList(e){
	$('invoice_list').innerHTML = e.responseText;
	$('invoice_no_loading').innerHTML = "";
	var items = getElementsByTagAndClassName('div', 'invoice_row');
    for (var item in items){
        connect(items[item], 'onclick', ShowClientInvoiceDetails);
    }
}

function OnFailShowAllClientInvoiceList(e){
	$('invoice_list').innerHTML = "Failed to parse Client Invoices";
}


function hideInvoiceForm(){
	var str = "<div>Click the &quot;Create Blank Invoice&quot; to generate a blank invoice.</div>";
	str+="<div>Click the &quot;Create Invoice From Subcon Invoice&quot; to generate invoice base from Subcontractors Paid Invoices Section .</div>";
	str+="<div>Select an Invoice on the left to view its details.</div>";
	document.getElementById("right_panel").innerHTML=str;
}
