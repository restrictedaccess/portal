// JavaScript Document
function CheckPaymentType(){
	var payment_type = $('payment_type').value;
	if(payment_type == 'one time payment'){
		$('end_date').value = $('start_date').value;
		//$('end_date').disabled = true;
	}else{
		$('end_date').value = "";
		//$('end_date').disabled = false;
	}
}
function CheckCommissionStatus(){
	var status = $('status').value;
	if (status == 'deleted' || status== 'cancelled' || status == 'approved'){
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
	
	if (status == 'approved' || status == 'finished'){
		
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
		
		var start_date = $('start_date').value;
		var end_date = $('end_date').value;
		
		
		if(start_date == "" || end_date == ""){
			$('start_date').disabled=false;
			$('end_date').disabled=false;
			$('update_btn').disabled=false;
		}else{
		    $('update_btn').disabled=true;
		}
		$('approve_btn').disabled=true;
	}
}

function DeleteCommission(e){
	var commission_id = $('commission_id').value;
	var query = queryString({'commission_id' : commission_id });
	if(confirm("Delete Commission?")){
	    $('delete_btn').value="deleting...";
	    $('delete_btn').disabled=true;
		
		if($('update_btn')){
	        $('update_btn').disabled=true;
        }
		
		if($('approve_btn')){
	        $('approve_btn').disabled=true;
        }

        if($('cancel_btn')){
	        $('cancel_btn').disabled=true;
        }


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
	$('delete_btn').value="Delete";
	$('delete_btn').disabled=false;
		
	if($('update_btn')){
	    $('update_btn').disabled=false;
    }
		
	if($('approve_btn')){
	   $('approve_btn').disabled=false;
    }
	
    if($('cancel_btn')){
       $('cancel_btn').disabled=false;
    }
}

function OnFailDeleteCommission(e){
	alert("There's a problem in deleting commission.");
	$('delete_btn').value="Cancel";
	$('delete_btn').disabled=false;
		
	if($('update_btn')){
	    $('update_btn').disabled=false;
    }
		
	if($('approve_btn')){
	   $('approve_btn').disabled=false;
    }
	
    if($('cancel_btn')){
       $('cancel_btn').disabled=false;
    }
}

function CancelCommission(e){
	var commission_id = $('commission_id').value;
	var query = queryString({'commission_id' : commission_id });
	if(confirm("Cancel Commission?")){
	    $('cancel_btn').value="cancelling...";
	    $('cancel_btn').disabled=true;
		
		if($('update_btn')){
	        $('update_btn').disabled=true;
        }
		
		if($('approve_btn')){
	        $('approve_btn').disabled=true;
        }

        if($('delete_btn')){
	        $('delete_btn').disabled=true;
        }


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
	$('cancel_btn').value="Cancel";
	$('cancel_btn').disabled=false;
		
	if($('update_btn')){
	    $('update_btn').disabled=false;
    }
		
	if($('approve_btn')){
	   $('approve_btn').disabled=false;
    }
	
    if($('delete_btn')){
       $('delete_btn').disabled=false;
    }
}

function OnFailCancelCommission(e){
	alert("There's a problem in cancelling commission.");
	$('cancel_btn').value="Cancel";
	$('cancel_btn').disabled=false;
		
	if($('update_btn')){
	    $('update_btn').disabled=false;
    }
		
	if($('approve_btn')){
	   $('approve_btn').disabled=false;
    }
	
    if($('delete_btn')){
       $('delete_btn').disabled=false;
    }
}

function ApproveCommission(e){
	var commission_id = $('commission_id').value;
	
	
	var query = queryString({'commission_id' : commission_id });
	if(confirm("Approve Commission?")){
	    $('approve_btn').value="approving...";
	    $('approve_btn').disabled=true;
		
		if($('update_btn')){
	        $('update_btn').disabled=true;
        }
		
		if($('cancel_btn')){
	        $('cancel_btn').disabled=true;
        }

        if($('delete_btn')){
	        $('delete_btn').disabled=true;
        }


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
	$('approve_btn').value="Approve";
	$('approve_btn').disabled=false;
		
	if($('update_btn')){
	    $('update_btn').disabled=false;
    }
		
	if($('cancel_btn')){
	   $('cancel_btn').disabled=false;
    }
	
    if($('delete_btn')){
       $('delete_btn').disabled=false;
    }
}

function OnFailApproveCommission(e){
	alert("There's a problem in approving commission.");
	$('approve_btn').value="Approve";
	$('approve_btn').disabled=false;
		
	if($('update_btn')){
	    $('update_btn').disabled=false;
    }
		
	if($('cancel_btn')){
	   $('cancel_btn').disabled=false;
    }
	
    if($('delete_btn')){
       $('delete_btn').disabled=false;
    }
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
	//var show_to_client = $('show_to_client').value;
	//var show_to_staff = $('show_to_staff').value;
	
	

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
		alert('Please start date of commission.');
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
	    $('update_btn').value="saving changes...";
	    $('update_btn').disabled=true;
		$('approve_btn').disabled=true;
		$('cancel_btn').disabled=true;
		$('delete_btn').disabled=true;
		
		var query = queryString({'commission_id' : commission_id, 'leads_id': leads_id, 'commission_amount' : commission_amount, 'commission_title' : commission_title, 'commission_desc' : commission_desc, 'selected_staffs' : selected_staffs, 'payment_type' : payment_type, 'start_date' : start_date, 'end_date' : end_date });
		
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
	$('update_btn').value="Save Changes";
	$('update_btn').disabled=false;
	$('approve_btn').disabled=false;
	$('cancel_btn').disabled=false;
    $('delete_btn').disabled=false;
}

function OnFailUpdateCommission(e){
	alert("There's a problem in updating commission.");
	$('update_btn').value="Save Changes";
	$('approve_btn').disabled=false;
	$('update_btn').disabled=false;
	$('cancel_btn').disabled=false;
    $('delete_btn').disabled=false;
}

function CSVExport(e){
	var start_date = $('start_date').value;
	var end_date = $('end_date').value;
	var status = $('status').value;
	
	if(start_date == ""){
		start_date="0";
	}
	if(end_date == ""){
		end_date="0"; 
	}
	//var query = queryString({'start_date': start_date, 'end_date' : end_date, 'status' : status });	
    location.href=PATH +  'csv_export/'+start_date+'/'+end_date+'/'+status;	
}

function SearchCommissions(e){
	$('commission_list').innerHTML="Loading all commissions...";
	var start_date = $('start_date').value;
	var end_date = $('end_date').value;
	//var date_created = $('date_created').value;
	var status = $('status').value;
	/*
	if(start_date == ""){
		start_date="0";
	}
	if(end_date == ""){
		end_date="0"; 
	}
	*/
	var query = queryString({'start_date': start_date, 'end_date' : end_date, 'status' : status });
	//var query = queryString({'date_created': date_created, 'status' : status });
	
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
	
    if(commission_amount == "" || commission_amount == 0){
		alert("Please enter amount.");
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
		alert('Please start date of commission.');
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
		var query = queryString({'leads_id': leads_id, 'commission_amount' : commission_amount, 'commission_title' : commission_title, 'commission_desc' : commission_desc, 'selected_staffs' : selected_staffs, 'payment_type' : payment_type, 'start_date' : start_date, 'end_date' : end_date, 'show_to_client' : show_to_client, 'show_to_staff' : show_to_staff });
		//log(query);return false;
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
