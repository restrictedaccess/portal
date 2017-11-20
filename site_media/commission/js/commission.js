// JavaScript Document
function CheckPaymentType(){
	var payment_type = $('payment_type').value;
	//alert(payment_type);
	if(payment_type == 'one time payment'){
		$('end_date').value = $('start_date').value;
		//$('end_date').disabled = true;
	}else{
		$('end_date').value = "";
		//$('end_date').disabled = false;
	}
}
function TagAsPaidToStaff(e){
	var commission_id = $('commission_id').value;
	var invoice_id = $('invoice_id').value;
	if(invoice_id == ""){
		alert("Please add Tax Invoice Number.");
		$('invoice_id').focus();
		return false;
	}
	
	if(confirm('Tagged As "Paid To Staff" ?')){
		DisabledButtons('paid_to_staff');
	    var result = doSimpleXMLHttpRequest(PATH + 'TagAsPaidToStaff/'+commission_id);
	    result.addCallbacks(OnSuccessTagAsPaidToStaff, OnFailTagAsPaidToStaff);
	}
}

function OnSuccessTagAsPaidToStaff(e){
	//alert(e.responseText);
	if(isNaN(e.responseText)){
		alert(e.responseText);
	}else{
		var commission_id = e.responseText;
		alert('Successfully tagged as "Paid To Staff"');
		location.href=PATH + 'view/'+commission_id;
	}
	EnabledButtons('paid_to_staff');
}

function OnFailTagAsPaidToStaff(e){
	alert("There's a problem in tagging commissions.");
	EnabledButtons('paid_to_staff');
}


function TagAsPaidByClient(e){
	var commission_id = $('commission_id').value;
	var invoice_id = $('invoice_id').value;
	
	if(invoice_id == ""){
		alert("Please add Tax Invoice Number.");
		$('invoice_id').focus();
		return false;
	}
	
	if(confirm('Tagged As "Paid By Client" ?')){
		DisabledButtons('paid_by_client');
	    var result = doSimpleXMLHttpRequest(PATH + 'TagAsPaidByClient/'+commission_id);
	    result.addCallbacks(OnSuccessTagAsPaidByClient, OnFailTagAsPaidByClient);
	}
}

function OnSuccessTagAsPaidByClient(e){
	if(e.responseText == 'ok'){
		var commission_id = $('commission_id').value;
		alert('Successfully tagged as "Paid By Client"');
		location.href=PATH + 'view/'+commission_id;
	}else{
	    alert(e.responseText);
	}
	EnabledButtons('paid_by_client');
}

function OnFailTagAsPaidByClient(e){
	alert("There's a problem in tagging commissions.");
	EnabledButtons('paid_by_client');
}

function TagAsInvoiced(e){
	var commission_id = $('commission_id').value;
	var invoice_id = $('invoice_id').value;
	
	if(invoice_id == ""){
		alert("Please add Tax Invoice Number.");
		$('invoice_id').focus();
		return false;
	}
	
	if(confirm('Tagged As "Invoiced" ?')){
		DisabledButtons('invoiced');
	    var result = doSimpleXMLHttpRequest(PATH + 'TagAsInvoiced/'+commission_id);
	    result.addCallbacks(OnSuccessTagAsInvoiced, OnFailTagAsInvoiced);
	}
}

function OnSuccessTagAsInvoiced(e){
	if(e.responseText == 'ok'){
		var commission_id = $('commission_id').value;
		alert('Successfully tagged as "Invoiced"');
		location.href=PATH + 'view/'+commission_id;
	}else{
	    alert(e.responseText);
	}
	EnabledButtons('invoiced');
}
function OnFailTagAsInvoiced(e){
	alert("There's a problem in tagging commissions.");
	EnabledButtons('invoiced');
}


function CheckCommissionStatus(){
	
	var status = $('status').value;
	var invoiced = $('invoiced').value;
	var paid_by_client = $('paid_by_client').value;
	var paid_to_staff= $('paid_to_staff').value;
	log('BUG ' + status);


	if (status == 'pending'){
		
		$('approve_btn').disabled=false;
		$('cancel_btn').disabled=false;
		$('delete_btn').disabled=false;
		
		$('invoice_btn').disabled=true;
	    $('paid_by_client_btn').disabled=true;
		$('paid_to_staff_btn').disabled=true;
		
		
		if($('start_date').value == ""){
			$('approve_btn').disabled=true;
		    $('cancel_btn').disabled=true;		    
		}
	}else if (status == 'approved'){
		$('approve_btn').disabled=true;
		$('start_date').disabled=true;
	    $('end_date').disabled=false;
		
		$('cancel_btn').disabled=false;
		$('delete_btn').disabled=false;
		
		$('invoice_btn').disabled=false;
	    $('paid_by_client_btn').disabled=false;
		$('paid_to_staff_btn').disabled=false;
		
		if(invoiced == 'y'){
		    $('invoice_btn').disabled=true;
	    }
	
	    if(paid_by_client == 'y'){
		    $('paid_by_client_btn').disabled=true;
	    }
	
	    if(paid_to_staff == 'y'){
		    $('paid_to_staff_btn').disabled=true;
	    }
	}else if (status == 'finished'){
		/*
		var inputs=document.getElementsByTagName('input');
        for(i=0;i<inputs.length;i++){
            inputs[i].disabled=true;
        }
		var selects=document.getElementsByTagName('select');
        for(i=0;i<selects.length;i++){
            selects[i].disabled=true;
        }
		
		var textareas=document.getElementsByTagName('textarea');
        for(i=0;i<textareas.length;i++){
            textareas[i].disabled=true;
        }
		*/
		if(invoiced == 'n'){
		    $('invoice_btn').disabled=false;
	    }
	
	    if(paid_by_client == 'n'){
		    $('paid_by_client_btn').disabled=false;
	    }
	
	    if(paid_to_staff == 'n'){
		    $('paid_to_staff_btn').disabled=false;
	    }	
	}else{
		var inputs=document.getElementsByTagName('input');
        for(i=0;i<inputs.length;i++){
            inputs[i].disabled=true;
        }
		var selects=document.getElementsByTagName('select');
        for(i=0;i<selects.length;i++){
            selects[i].disabled=true;
        }
		
		var textareas=document.getElementsByTagName('textarea');
        for(i=0;i<textareas.length;i++){
            textareas[i].disabled=true;
        }
	}
	
    //$('payment_type').disabled=true;
	$('leads_id').disabled=true;
}

function DeleteCommission(e){
	var commission_id = $('commission_id').value;
	var query = queryString({'commission_id' : commission_id });
	if(confirm("Delete Commission?")){
		DisabledButtons('deleted');
	    var result = doXHR(PATH + 'DeleteCommission/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessDeleteCommission, OnFailDeleteCommission);
		
	}
}

function OnSuccessDeleteCommission(e){
	if(e.responseText == 'ok'){
		var commission_id = $('commission_id').value;
		alert("Commission Deleted");
		location.href=PATH + 'view/'+commission_id;
	}else{
	    alert(e.responseText);
	}
	EnabledButtons('deleted');
}

function OnFailDeleteCommission(e){
	alert("There's a problem in deleting commission.");
	EnabledButtons('deleted');
}

function CancelCommission(e){
	var commission_id = $('commission_id').value;
	var query = queryString({'commission_id' : commission_id });
	if(confirm("Cancel Commission?")){
		DisabledButtons('cancelled');
	    var result = doXHR(PATH + 'CancelCommission/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessCancelCommission, OnFailCancelCommission);
	}
}

function OnSuccessCancelCommission(e){
	if(e.responseText == 'ok'){
		var commission_id = $('commission_id').value;
		alert("Commission Cancelled");
		location.href=PATH + 'view/'+commission_id;
	}else{
	    alert(e.responseText);
	}
	EnabledButtons('cancelled');
}

function OnFailCancelCommission(e){
	alert("There's a problem in cancelling commission.");
	EnabledButtons('cancelled');
}

function ApproveCommission(e){
	var commission_id = $('commission_id').value;
	
	
	var query = queryString({'commission_id' : commission_id });
	if(confirm("Approve Commission?")){
		DisabledButtons('approved');

	    var result = doXHR(PATH + 'ApproveCommission/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessApproveCommission, OnFailApproveCommission);
		
	}
}

function OnSuccessApproveCommission(e){
	if(e.responseText == 'ok'){
		var commission_id = $('commission_id').value;
		alert("Commission Approved");
		location.href=PATH + 'view/'+commission_id;
	}else{
	    alert(e.responseText);
	}
	EnabledButtons('approved');	
}

function OnFailApproveCommission(e){
	alert("There's a problem in approving commission.");
	EnabledButtons('approved');	
}

function UpdateCommission(e){
	var commission_id = $('commission_id').value;
	var leads_id = $('leads_id').value;
	var commission_amount = $('commission_amount').value;
	var commission_title = $('commission_title').value;
	var commission_desc = $('commission_desc').value;
    var selected_staffs = $('selected_staffs').value;
	var payment_type = $('payment_type').value;
	var start_date = $('start_date').value;
	var end_date = $('end_date').value;
	var invoice_id = $('invoice_id').value;
	var show_to_client = $('show_to_client').value;
	var show_to_staff = $('show_to_staff').value;
	
	
	var query = queryString({'commission_id' : commission_id, 'leads_id': leads_id, 'commission_amount' : commission_amount, 'commission_title' : commission_title, 'commission_desc' : commission_desc, 'selected_staffs' : selected_staffs, 'payment_type' : payment_type, 'start_date' : start_date, 'end_date' : end_date, 'invoice_id' : invoice_id, 'show_to_client': show_to_client, 'show_to_staff' : show_to_staff });

    if(commission_amount == "" || commission_amount == 0){
		alert("Please enter an amount.");
		return false;
	}
	
	if(isNaN(commission_amount)){
		alert("Not a valid amount =>" + commission_amount);
		return false;
	}

    if(commission_title == ""){
		alert("Plese enter Commission Title.");
		return false;
	}
	
	if(selected_staffs == ""){
		alert("Please select staff.");
		return false;
	}
	//log(query);
	
	if(start_date == ""){
		alert('Please enter Start Date');
		return false;
	}
	
	if(payment_type == 'one time payment'){
		if(end_date == ""){
		    $('end_date').value = start_date;
	    }
	}
	
	if (compareDates(start_date, "y-M-d", end_date, "y-M-d")==1){
		alert("Start Date must not be higher than End Date");
		return false;
    }
	
	if(confirm("Save changes?")){
		DisabledButtons('update');
	    var result = doXHR(PATH + 'UpdateCommission/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessUpdateCommission, OnFailUpdateCommission);

	}
}

function OnSuccessUpdateCommission(e){
	if(e.responseText == 'ok'){
		var commission_id = $('commission_id').value;
		alert("Changes Saved.");
		location.href=PATH + 'view/'+commission_id;
	}else{
	    alert(e.responseText);
	    //$('debug').innerHTML=e.responseText;
	}
	EnabledButtons('update');
}

function OnFailUpdateCommission(e){
	alert("There's a problem in updating commission.");
	EnabledButtons('update');
}


function CSVExport(e){
    location.href=PATH +  'csv_export/';	
}

function SearchCommissions(e){
	$('commission_list').innerHTML="Loading all commissions...";
	var start_date = $('start_date').value;
	var end_date = $('end_date').value;
	var status = $('status').value;
	var payment_status = $('payment_status').value;
    var csro_id = $('csro_id').value;
	var payment_type = $('payment_type').value;
	var date_created_from = $('date_created_from').value;
	var date_created_to = $('date_created_to').value;
	
	
	
	var query = queryString({'start_date': start_date, 'end_date' : end_date, 'status' : status, 'payment_status' : payment_status, 'csro_id' : csro_id, 'payment_type' : payment_type, 'date_created_from' : date_created_from, 'date_created_to' : date_created_to });
	
	$('search_btn').value="searching...";
	$('search_btn').disabled=true;
	var result = doXHR(PATH + 'SearchCommissions/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSearchCommissions, OnFailSearchCommissions);
	
}

function OnSuccessSearchCommissions(e){
	$('commission_list').innerHTML = e.responseText;
	$('search_btn').value="Search";
	$('search_btn').disabled=false;
}

function OnFailSearchCommissions(e){
	alert("There's a problem in searching commissions.");
	$('search_btn').value="Search";
	$('search_btn').disabled=false;
}

function CreateCommission(e){
	var leads_id = $('leads_id').value;
	var commission_amount = $('commission_amount').value;
	var commission_title = $('commission_title').value;
	var commission_desc = $('commission_desc').value;
    var selected_staffs = $('selected_staffs').value;
	var payment_type = $('payment_type').value;
	var start_date = $('start_date').value;
	var end_date = $('end_date').value;
	var show_to_client = $('show_to_client').value;
	var show_to_staff = $('show_to_staff').value;
	
	var query = queryString({'leads_id': leads_id, 'commission_amount' : commission_amount, 'commission_title' : commission_title, 'commission_desc' : commission_desc, 'selected_staffs' : selected_staffs, 'payment_type' : payment_type, 'start_date' : start_date, 'end_date' : end_date, 'show_to_client' : show_to_client, 'show_to_staff' : show_to_staff });

    if(commission_amount == "" || commission_amount == 0){
		alert("Please enter an amount.");
		return false;
	}
	
	if(isNaN(commission_amount)){
		alert("Not a valid amount =>" + commission_amount);
		return false;
	}

    if(commission_title == ""){
		alert("Plese enter Commission Title.");
		return false;
	}
	
	if(selected_staffs == ""){
		alert("Please select staff.");
		return false;
	}
	 	
	if(start_date == ""){
		alert('Please enter Start Date.');
		return false;
	}
	
	if(payment_type == 'one time payment'){
		if(end_date == ""){
		    $('end_date').value = start_date;
	    }
	}
	
	if (compareDates(start_date, "y-M-d", end_date, "y-M-d")==1){
		alert("Start Date must not be higher than End Date");
		return false;
    }
	
	if(confirm("Create new commission?")){
	    $('create_btn').value="creating...";
	    $('create_btn').disabled=true;
	    var result = doXHR(PATH + 'CreateCommission/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessCreateCommission, OnFailCreateCommission);
	}
}

function OnSuccessCreateCommission(e){
	if(isNaN(e.responseText) == false){
		alert("New Commission Created.");
		location.href=PATH + 'view/'+e.responseText;
	}
	$('debug').innerHTML = e.responseText;
	$('create_btn').value="Create";
	$('create_btn').disabled=false;
}
function OnFailCreateCommission(e){
	alert("There's a problem in creating new oommission.");
	$('create_btn').value="Create";
	$('create_btn').disabled=false;
}

function GetClientStaff(e){
	var leads_id = $('leads_id').value;
    var commission_id = $('commission_id').value;	
	$('currency_str').innerHTML="";
	$('staffs').innerHTML="";
	$('currency_str').innerHTML="&nbsp;";
	$('selected_staffs').value="";
	if(leads_id){
		$('staffs').innerHTML="Loading staffs...";
	    var result = doSimpleXMLHttpRequest(PATH + 'GetClientStaff/'+leads_id+'/'+commission_id);
	    result.addCallbacks(OnSuccessGetClientStaff, OnFailGetClientStaff);
	}
}

function OnSuccessGetClientStaff(e){
	$('staffs').innerHTML =e.responseText;
	$('currency_str').innerHTML=$('currency').value;
	var commission_id = $('commission_id').value;
	if(commission_id > 0){
		 CheckUncheckStaff();
		 CheckCommissionStatus();
	}
}
function OnFailGetClientStaff(e){
	alert("There's a problem in parsing client's staff.")
}

function CheckUncheckStaff(e){
    //log('CheckUncheckStaff');	
	var ins = document.getElementsByName('staff')
	var i;
	var j=0;
	var vals= new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			vals[j]=ins[i].value;
			j++;
			addElementClass(ins[i].value+'_list', 'staff_list_selected');
		}else{
			removeElementClass(ins[i].value+'_list', 'staff_list_selected');
		}
	}
	$('selected_staffs').value=(vals);
}

function SelectAllStaff(e){
	var select_all_staff = document.getElementsByName('select_all_staff');
	var staff = document.getElementsByName('staff');
	
	if(select_all_staff[0].checked == true){
	    for(i=0;i<staff.length;i++){
		    staff[i].checked=true;
	    }	
	}else{
		for(i=0;i<staff.length;i++){
		    staff[i].checked=false;
	    }
	}
	CheckUncheckStaff();
}