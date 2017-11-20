var MODES = Array('update', 'approved', 'cancelled', 'deleted', 'invoiced', 'paid_by_client', 'paid_to_staff');
var BUTTONS_ID = Array('update_btn', 'approve_btn', 'cancel_btn', 'delete_btn', 'invoice_btn', 'paid_by_client_btn', 'paid_to_staff_btn');
var BUTTONS_ID_STR_DISPLAY = Array('Save Changes', 'Approve', 'Cancel', 'Delete', 'Invoiced', 'Paid By Client', 'Paid To Staff');
var BUTTONS_ID_STR_DISPLAY_PROCESS = Array('saving changes...', 'approving...', 'cancelling...', 'deleting...', 'processing...', 'processing...', 'processing...');


function DisabledButtons(mode){
	for(var i=0; i<MODES.length; i++){
		if(MODES[i] == mode){
			$(BUTTONS_ID[i]).value=BUTTONS_ID_STR_DISPLAY_PROCESS[i];
		}
		$(BUTTONS_ID[i]).disabled=true;
	}
	
}

function EnabledButtons(mode){

	for(var i=0; i<MODES.length; i++){
		if(MODES[i] == mode){			
			$(BUTTONS_ID[i]).value=BUTTONS_ID_STR_DISPLAY[i];
		}
		$(BUTTONS_ID[i]).disabled=false;		
	}
	DisabledSpecificButtons();
}

function DisabledSpecificButtons(){
    var status = $('status').value;
	var invoiced = $('invoiced').value;
	var paid_by_client = $('paid_by_client').value;
	var paid_to_staff= $('paid_to_staff').value;
	
	
	if(status == 'cancelled' || status == 'deleted'){
		for(var i=0; i<MODES.length; i++){
		    $(BUTTONS_ID[i]).disabled=true;		
	    }
	}
	
	if (status == 'pending'){
		$('invoice_btn').disabled=true;
	    $('paid_by_client_btn').disabled=true;
		$('paid_to_staff_btn').disabled=true;
	}
	
	if(status == 'approved'){
		$('approve_btn').disabled=true;
	}
	
	if(invoiced == 'y'){
		$('invoice_btn').disabled=true;
	}
	
	if(paid_by_client == 'y'){
		$('paid_by_client_btn').disabled=true;
	}
	
	if(paid_to_staff == 'y'){
		$('paid_to_staff_btn').disabled=true;
	}
	
	
}