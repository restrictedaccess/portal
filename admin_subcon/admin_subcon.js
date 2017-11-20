/* 
Used in Admin Section Add Subcontractors
- Normaneil Macutay <normanm@remotestaff.com.au>
- 2010-02-02 Date Started
*/
var PATH = 'admin_subcon/';

function ReActivate(){
	var id = $('id').value;
	if(confirm("Reactivate Staff Contract?")){		
		$('activate_inactive_staff_contracts').value = "reactivating...";
	    $('activate_inactive_staff_contracts').disabled = true;
		$('update_reason_btn').disabled = true;
		
		if($('delete_contract_btn')){
		    $('delete_contract_btn').disabled = true;
		}
		
	    var query = queryString({'id' : id });
        var result = doXHR(PATH + 'ReActivate.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessReActivate, OnFailReActivate);
	}
}

function OnSuccessReActivate(e){
	if(e.responseText == 'ok'){
		alert("Staff Contract Reactivated.");
		document.form.submit();
	}else{
		alert(e.responseText);
		$('activate_inactive_staff_contracts').value = "Reactivate";
	    $('activate_inactive_staff_contracts').disabled = false;
	    $('update_reason_btn').disabled = false;
		
	    if($('delete_contract_btn')){
	        $('delete_contract_btn').disabled = false;
	    }
	}
}
function OnFailReActivate(e){
	alert("There's a problem in reactivating staff contract.");
	$('activate_inactive_staff_contracts').value = "Reactivate";
	$('activate_inactive_staff_contracts').disabled = false;
	$('update_reason_btn').disabled = false;
		
	if($('delete_contract_btn')){
	    $('delete_contract_btn').disabled = false;
	}
}
function DeleteContract(){
	var id = $('id').value;
	if(confirm("Are you sure you want to delete this contract?")){
		
		$('delete_contract_btn').value = "Deleting...";
	    $('delete_contract_btn').disabled = true;
	    var query = queryString({'id' : id });
        var result = doXHR(PATH + 'DeleteContract.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessDeleteContract, OnFailDeleteContract);
	}
}

function OnSuccessDeleteContract(e){
	if(e.responseText == 'ok'){
		alert("Staff Contract Deleted.");
		document.form.submit();
	}else{
		alert(e.responseText);
		$('delete_contract_btn').value = "Delete Contract";
	    $('delete_contract_btn').disabled = false;
	}
}
function OnFailDeleteContract(e){
	alert("Failed to delete contract.");
	$('delete_contract_btn').value = "Delete Contract";
	$('delete_contract_btn').disabled = false;
}
function UpdateReason(){
	var id = $('id').value;
	var reason = $('admin_notes').value;
	var reason_type = $('reason_type').value;
    var service_type = $('service_type').value;	
	var replacement_request = $('replacement_request').value;
	var contract_status = $('contract_status').value;
	
	$('update_reason_btn').value = "Updating...";
	$('update_reason_btn').disabled = true;
	var query = queryString({'id' : id , 'reason' : reason, 'reason_type' : reason_type, 'replacement_request' : replacement_request, 'service_type' : service_type, 'contract_status' : contract_status});
    var result = doXHR(PATH + 'UpdateReason.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateReason, OnFailUpdateReason);
}

function OnSuccessUpdateReason(e){
	if(e.responseText == 'ok'){
		alert("Successfully updated.");
		document.form.submit();
	}else{
		alert(e.responseText);
		$('update_reason_btn').value = "Update Reason";
	    $('update_reason_btn').disabled = false;
	}
	
}
function OnFailUpdateReason(e){
	alert("Failed to update reason");
	$('update_reason_btn').value = "Update Reason";
	$('update_reason_btn').disabled = false;
}

function UpdateComment(){
	var id = $('id').value;
	var reason = $('admin_notes').value;
	
	var query = queryString({'id' : id , 'reason' : reason});
    //alert(query);
	
	//$('update_comment_btn').value = "";
	//$('update_comment_btn').disabled = true;
	var result = doXHR(PATH + 'UpdateComment.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateComment, OnFailUpdateComment);
	
}

function OnSuccessUpdateComment(e){
	if(e.responseText == 'ok'){
		document.form.submit();
	}else{
		alert(e.responseText);
	}
	
}

function OnFailUpdateComment(e){
	alert("There is a problem in updating comments in this contract.");
}

function ActivateSuspendedStaffContract(subcontractors_id){
	var admin_notes = $('admin_notes').value;
	var query = queryString({'subcontractors_id' : subcontractors_id, 'admin_notes' : admin_notes});
    //alert(query);
	$('activate').disabled = true;
	$('activate').value = 'activating...';
	
	var result = doXHR(PATH + 'ActivateSuspendedStaffContract.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessActivateSuspendedStaffContract, OnFailActivateSuspendedStaffContract);
}
function OnFailActivateSuspendedStaffContract(e){
	alert("There was a problem in activating staff contract.");
}
function OnSuccessActivateSuspendedStaffContract(e){
    $('applicant_info').innerHTML = e.responseText;	
}


function LoadApplicantDetails(userid){
	//alert(userid);
	if(userid){
		showApplicantDetails(userid);
	}
	
}
function showClientRateEffectiveDate(){
   
    var mode = $('mode').value;
	if(mode != 'new' && mode != 'add'){
	    //appear('client_rate_div');
	    //appear('client_rate_effective_date_str');
	    //appear('client_rate_effective_date_c');
		//$('client_price_effective_date').value="";
	}
	
	
	
}

function CloseContractDetails(e){
	appear('staff_contract_list_holder');
	fade('close_button');
	$('drag_handle').innerHTML ='Staff Contract';
	$('applicant_info').innerHTML = 'Select staff name to show contract details...';
}

function send_invoice(leads_id, mode){
	var query = queryString({'leads_id' : leads_id });
	$('send_btn_'+leads_id).value = 'sending...';
	$('send_btn_'+leads_id).disabled = true;
	if(mode == "") mode = 'new';
	if(mode == 'new'){
	    var result = doSimpleXMLHttpRequest(PATH + 'send_invoice.php?leads_id='+leads_id);
	}else{
		var result = doSimpleXMLHttpRequest(PATH + 'resend_invoice.php?leads_id='+leads_id);
	}
	//alert(mode);
	result.addCallbacks(OnSuccessSendInvoice, OnFailSendInvoice);
}
function OnSuccessSendInvoice(e){
    showAllStaffContractList();
}
function OnFailSendInvoice(e){
    alert("There's a problem in setting up invoice.");
}
function EnabledDisabledMonthlyLimit(){
	var overtime = $('overtime').value;
	var overtime_monthly_limit = getNodeAttribute('overtime_monthly_limit', 'overtime_monthly_limit');
	
	if(overtime == 'YES'){
		$('overtime_monthly_limit').disabled = false;
		$('overtime_monthly_limit').value = overtime_monthly_limit;
	}else{
		$('overtime_monthly_limit').disabled = true;
		$('overtime_monthly_limit').value= '';
	}
}

function CheckIfNumeric(obj){
	
	if(isNaN(obj.value)){
		alert('Must be a number');
		obj.value = '';
		obj.focus();
		return false;
	}
}
function EnabledDisabledWeekDdays(flexi){
	//alert(flexi);
	var weekdays = document.getElementsByName('weekdays');
	var days_name ="";
	for(i=0;i<weekdays.length;i++)
	{
		day_name = weekdays[i].value;
		if(flexi == 'yes'){	
			weekdays[i].disabled = true;
			weekdays[i].checked = false;
			//setWeekDaysTime(day_name,true);

		}else{
			weekdays[i].disabled = false;
			//alert(day_name);
			if(day_name == 'sat' || day_name == 'sun'){
				weekdays[i].checked = false;
			}else{
				weekdays[i].checked = true;
			}
			//setWeekDaysTime(day_name,false);
			
		}
	}
	if($('flexi').value == 'no'){
		setTimeZone();
	}
	check_val()
	//alert(days_str);
}
function SetUpFlexi(){
	
	var flexi = document.getElementsByName('flexi');
	if(flexi[0].checked == true){
		flexi[0].value = 'yes';
		EnabledDisabledWeekDdays('no');
	}else{
		flexi[0].value = 'no';
		EnabledDisabledWeekDdays('no');
	}
}

function checkSearch(){
	var keyword = $('keyword').value;
	var serch = getRadioButtonValue('search');
	//alert(keyword+" \n "+serch);
	if(!keyword){
		alert("No keyword to be found!");
		return false;		
	}
	
	if(serch == 'userid'){
		if(isNaN(keyword)){
			alert("Invalid userid!");
			return false;		
		}
	}
	
	return true;
}

function SetDefault(obj){
	$(obj).value = "";
}

function ShowCloseContractCalendarForm(status){
    var admin_notes = $('admin_notes').value;
	if(status == "resigned"){
		str = "Are you sure that this staff resigned to this client?";
	}
	
	if(status == "terminated"){
		str = "Are you sure you want to terminate this staff contract?";
	}
    
	if(admin_notes =="" ||  admin_notes==" " || admin_notes == null){
		alert("Please state a reason why this staff "+status);
		return false;
	}
	
	if(confirm(str)){
		appear('overlay');
		$('close_contract_status').value = status;
	}
}

function CloseContract(){
	
	var status = $('close_contract_status').value;
	var id = $('id').value;
	var userid = $('userid').value;
	var leads_id = $('leads_id').value;
	var admin_notes = $('admin_notes').value;
	var str ="";
	var end_date_str = $('end_date_str').value;
	var scheduled_close_contract_id = $('scheduled_close_contract_id').value;
	var reason_type = $('reason_type').value;
	var replacement_request = $('replacement_request').value;
	if(end_date_str == ""){
	    alert("Please enter staff contract finish date");
		return false;
	}
	
	var service_type = $('service_type').value;
	
	var query = queryString({'id' : id , 'userid' : userid, 'leads_id' : leads_id, 'admin_notes' : admin_notes ,'status' : status, 'end_date_str' : end_date_str, 'scheduled_close_contract_id' : scheduled_close_contract_id, 'reason_type' : reason_type, 'replacement_request': replacement_request, 'service_type' : service_type });
    //alert(query);
	//return false;
	$('close_contract_btn').value = "Processing...";
	$('close_contract_btn').disabled = true;
	var result = doXHR(PATH + 'closeContract.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessCloseContract, OnFailCloseContract);
	
}

function OnSuccessCloseContract(e){
	fade('overlay');
	$('applicant_info').innerHTML = e.responseText;
	//alert(e.responseText);
}

function OnFailCloseContract(e){
	alert("Failed to process staff contract status");
}

function showResume(userid){
	
	//var loc = "application_apply_action_popup.php?userid="+userid;
	var loc = "resume4.php?userid="+userid;
	var wd = 800;
	var hg = 600;
	var remote = null;
	var xpos = screen.availWidth/2 - wd/2; 
	var ypos = screen.availHeight/2 - hg/2; 
	remote = window.open('','','width=' + wd + ',height=' + hg + ',resizable=0,scrollbars=1,screenX=0,screenY=0,top='+ypos+',left='+xpos);
	if (remote != null) {
		if (remote.opener == null) {
		 	remote.opener = self;
		}
		remote.location.href = loc;
		remote.focus();
	} 
	else { 
		self.close(); 
	}
}

function checkClientHistory(){
	var leads_id = $('leads_id').value;
	if(leads_id == 0)return false;
	$('client_history').innerHTML = "Loading client's history...";
	var query = queryString({'leads_id' : leads_id });
	var result = doXHR(PATH + 'showClientHistory.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowHistory, OnFailShowHistory);
}

function OnSuccessShowHistory(e){
	$('client_history').innerHTML = e.responseText;
	setClientChargeOutRate();
}
function OnFailShowHistory(e){
	alert("Failed to get client's history");
}

function searchSubcon2(mode,status){
	//mode :select , keyword , null (all)
	var userid = $('userid').value;
	var keyword = $('keyword').value;
	if(status == null){
		status = "ACTIVE";
	}
	
	if(mode == "select"){
		if(userid == 0){
			alert("Please choose a subcontractor");
			return false;
		}
	}
	
	if(mode == "keyword"){
		if(keyword == "" || keyword == " "){
			alert("Please enter a keyword");
			return false;
		}
	}

	var query = queryString({'userid' : userid , 'keyword' : keyword , 'mode' : mode , 'status' : status});	
	var result = doXHR(PATH + 'getInactiveSubcontractors.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessGetSubcon, OnFailGetSubcon);
}

function searchSubcon(mode,status){
	//mode :select , keyword , null (all)
	var userid = $('userid').value;
	var keyword = $('keyword').value;
	if(status == null){
		status = "ACTIVE";
	}
	
	if(mode == "select"){
		if(userid == 0){
			alert("Please choose a subcontractor");
			return false;
		}
	}
	
	if(mode == "keyword"){
		if(keyword == "" || keyword == " "){
			alert("Please enter a keyword");
			return false;
		}
	}
	
	var query = queryString({'userid' : userid , 'keyword' : keyword , 'mode' : mode , 'status' : status});	
	var result = doXHR(PATH + 'getSubcontractors.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessGetSubcon, OnFailGetSubcon);
}

function OnSuccessGetSubcon(e){
	$('subcon_listings').innerHTML = e.responseText;
}

function OnFailGetSubcon(e){
	alert("Failed to parse subcontractors list");
}

function showClosedContractDetails(id){
	$('applicant_info').innerHTML = "Loading ...";
	var query = queryString({'id' : id });
	var result = doXHR(PATH + 'showContractDetails.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessClosedContractDetails, OnFailClosedContractDetails);	
	//alert(query);
}
function OnSuccessClosedContractDetails(e){
	$('applicant_info').innerHTML = e.responseText;
	
}
function OnFailClosedContractDetails(e){
	alert("Failed to show Staff Closed Contract");
}

function showContractDetails(id , mode ){
	$('applicant_info').innerHTML = "Loading ...";
	var query = queryString({'id' : id , 'mode' : mode});
	var result = doXHR(PATH + 'showContractDetails.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowContractDetails, OnFailShowContractDetails);	
	//alert(query);
}
function showStaffContractDetails(e){
	
	var id = getNodeAttribute(e.src(), 'subcon_id');
	var mode = getNodeAttribute(e.src(), 'mode');
	var staff_name = getNodeAttribute(e.src(), 'staff_name');
	$('applicant_info').innerHTML = "Loading "+staff_name+" ...";
	$('drag_handle').innerHTML = staff_name;
	var items = getElementsByTagAndClassName('div', 'show_contract_details');
	for (var item in items){
        removeElementClass(items[item], 'selected_subcon');
		var subcon_id = getNodeAttribute(items[item], 'subcon_id');
		if(subcon_id == id){
			addElementClass(items[item], 'selected_subcon');
		}
    }
	
	var query = queryString({'id' : id , 'mode' : mode});
	var result = doXHR(PATH + 'showContractDetails.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowContractDetails2, OnFailShowContractDetails);	
	//alert(query);
}
function OnSuccessShowContractDetails2(e){
	
    fade('staff_contract_list_holder');
	appear('close_button');
	connect('close_button', 'onclick', CloseContractDetails);
	//var inlinewin=dhtmlwindow.open("broadcastbox", "inline", e.responseText, "Staff Contract", "width=1200px,height=1502px,left=90px,top=10px,resize=1,scrolling=1", "recal")
	$('applicant_info').innerHTML = e.responseText;
	
	if($('id')){
	var h = $('staff_details_holder').offsetHeight;
	//$('overlay').innerHTML=h+"px;";
	document.getElementById("overlay2").style.height=(h)+"px";
	var min_date=$('min_date').value;
	
	Calendar.setup({
            inputField : "starting_date",
            trigger    : "bd",
            onSelect   : function() { this.hide()  },
            //showTime   : 12,
			fdow  : 0,
            dateFormat : "%Y-%m-%d"

    });
	
	/*
	Calendar.setup({
            inputField : "client_price_effective_date",
            trigger    : "client_rate_effective_date_cal",
            onSelect   : function() { this.hide()  },
            //showTime   : 12,
			fdow  : 0,
            dateFormat : "%Y-%m-%d",
			min: parseInt(min_date)

    });
	
	
	if($('prepaid_start_date_cal')){
		Calendar.setup({
            inputField : "prepaid_start_date",
            trigger    : "prepaid_start_date_cal",
            onSelect   : function() { this.hide()  },
            //showTime   : 12,
			fdow  : 0,
            dateFormat : "%Y-%m-%d",
			min: parseInt(min_date)
		});	
	}
	*/	 
	
	
	showClientAds();
	//autoPopulate();
	autoPopulate2()
	setClientChargeOutRate();
	check_val();
	}
}
function OnSuccessShowContractDetails(e){
	$('applicant_info').innerHTML = e.responseText;
	
	var h = $('staff_details_holder').offsetHeight;
	document.getElementById("overlay2").style.height=(h)+"px";
	//document.getElementById("overlay2").style.textAlign="justify";
	
	var min_date=$('min_date').value;
	Calendar.setup({
            inputField : "starting_date",
            trigger    : "bd",
            onSelect   : function() { this.hide()  },
            //showTime   : 12,
			fdow  : 0,
            dateFormat : "%Y-%m-%d"

    });
	/*
	Calendar.setup({
            inputField : "client_price_effective_date",
            trigger    : "client_rate_effective_date_cal",
            onSelect   : function() { this.hide()  },
            //showTime   : 12,
			fdow  : 0,
            dateFormat : "%Y-%m-%d",
			min: parseInt(min_date)

    });
	
	if($('prepaid_start_date_cal')){
		Calendar.setup({
            inputField : "prepaid_start_date",
            trigger    : "prepaid_start_date_cal",
            onSelect   : function() { this.hide()  },
            //showTime   : 12,
			fdow  : 0,
            dateFormat : "%Y-%m-%d",
			min: parseInt(min_date)
		});	
	}
	*/
	showClientAds();
	//autoPopulate();
	autoPopulate2()
	setClientChargeOutRate();
	check_val();
}
function OnFailShowContractDetails(e){
	alert("Failed to show contract details");
}



function showAllStaffContractList(){
	$('staff_contract_list').innerHTML = "Loading...";
	var result = doSimpleXMLHttpRequest(PATH + 'showAllStaffContractList.php');
    result.addCallbacks(OnSuccessShowAllStaffContractList, OnFailShowAllStaffContractList);
}

function OnSuccessShowAllStaffContractList(e){
	$('staff_contract_list').innerHTML = e.responseText;
	var items = getElementsByTagAndClassName('div', 'show_contract_details');
    for (var item in items){
        connect(items[item], 'onclick', showStaffContractDetails);
    }
	
	//if a staff contract is currently selected.
	if($('id')){
		var id = $('id').value;
		var items = getElementsByTagAndClassName('div', 'show_contract_details');
		for (var item in items){
			removeElementClass(items[item], 'selected_subcon');
			var subcon_id = getNodeAttribute(items[item], 'subcon_id');
			if(subcon_id == id){
				addElementClass(items[item], 'selected_subcon');
			}
		}
		var id = $('id').value;
		var mode = $('mode').value;
		//alert(subcon_id+' '+mode);
		var query = queryString({'id' : id , 'mode' : mode});
	    var result = doXHR(PATH + 'showContractDetails.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessShowContractDetails2, OnFailShowContractDetails);
	}
}
function OnFailShowAllStaffContractList(e){
	alert("Failed to parse new and updated staff contract details");
}

function getRadioButtonValue(obj){
	var radio_bttn = document.getElementsByName(obj);
	var radio_bttn_value = 0;
	var i;
	for(i=0;i<radio_bttn.length;i++)
	{
		if(radio_bttn[i].checked==true) {
			radio_bttn_value = radio_bttn[i].value;
			return radio_bttn_value;
			break;
		}
	}
}

function ApprovedEditUpdateCancelContract(mode){
	//alert(mode);
	
	
	var id = $('id').value;
	var userid = $('userid').value;
	var leads_id = $('leads_id').value;
	var posting_id = getRadioButtonValue('ads');
	var work_status = $('work_status').value;
	var staff_monthly = $('staff_monthly').value; // staff monthly
	var client_timezone = $('client_timezone').value;
	var client_start_work_hour = $('client_start_work_hour').value;
	var client_finish_work_hour = $('client_finish_work_hour').value;
	var starting_date = $('starting_date').value;
	var job_designation = $('job_designation').value;

	var work_days = $('work_days').value;
	var days = $('days').value;
	var total_weekly_hrs = $('total_weekly_hrs').value;
	var total_lunch_hrs = $('total_lunch_hrs').value;

	//weekdays : mon,tue,wed,thu,fri,sat,sun
	//_start , _finish ,_number_hrs , _start_lunch , _finish_lunch _lunch_number_hrs
	var mon_start = $('mon_start').value;
	var mon_finish = $('mon_finish').value;
	var mon_number_hrs = $('mon_number_hrs').value;
	var mon_start_lunch = $('mon_start_lunch').value;
	var mon_finish_lunch = $('mon_finish_lunch').value;
	var mon_lunch_number_hrs = $('mon_lunch_number_hrs').value;
	
	var tue_start = $('tue_start').value;
	var tue_finish = $('tue_finish').value;
	var tue_number_hrs = $('tue_number_hrs').value;
	var tue_start_lunch = $('tue_start_lunch').value;
	var tue_finish_lunch = $('tue_finish_lunch').value;
	var tue_lunch_number_hrs = $('tue_lunch_number_hrs').value;
	
	var wed_start = $('wed_start').value;
	var wed_finish = $('wed_finish').value;
	var wed_number_hrs = $('wed_number_hrs').value;
	var wed_start_lunch = $('wed_start_lunch').value;
	var wed_finish_lunch = $('wed_finish_lunch').value;
	var wed_lunch_number_hrs = $('wed_lunch_number_hrs').value;
	
	var thu_start = $('thu_start').value;
	var thu_finish = $('thu_finish').value;
	var thu_number_hrs = $('thu_number_hrs').value;
	var thu_start_lunch = $('thu_start_lunch').value;
	var thu_finish_lunch = $('thu_finish_lunch').value;
	var thu_lunch_number_hrs = $('thu_lunch_number_hrs').value;
	
	var fri_start = $('fri_start').value;
	var fri_finish = $('fri_finish').value;
	var fri_number_hrs = $('fri_number_hrs').value;
	var fri_start_lunch = $('fri_start_lunch').value;
	var fri_finish_lunch = $('fri_finish_lunch').value;
	var fri_lunch_number_hrs = $('fri_lunch_number_hrs').value;
	
	var sat_start = $('sat_start').value;
	var sat_finish = $('sat_finish').value;
	var sat_number_hrs = $('sat_number_hrs').value;
	var sat_start_lunch = $('sat_start_lunch').value;
	var sat_finish_lunch = $('sat_finish_lunch').value;
	var sat_lunch_number_hrs = $('sat_lunch_number_hrs').value;
	
	var sun_start = $('sun_start').value;
	var sun_finish = $('sun_finish').value;
	var sun_number_hrs = $('sun_number_hrs').value;
	var sun_start_lunch = $('sun_start_lunch').value;
	var sun_finish_lunch = $('sun_finish_lunch').value;
	var sun_lunch_number_hrs = $('sun_lunch_number_hrs').value;
	
	
	
	var currency = $('currency').value;
	var client_price = $('client_price').value; //client price monthly
	var fix_currency_rate = $('fix_currency_rate').value;
	var current_rate = $('current_rate').value;
	var with_tax = $('with_tax').value;
	var total_charge_out_rate =$('total_charge_out_rate').value;
	var with_bp_comm = $('with_bp_comm').value;
	var with_aff_comm = $('with_aff_comm').value;
	
	
	var admin_notes = $('admin_notes').value;
	
	var email = $('email').value;
	var staff_registered_email = $('staff_registered_email').value;
	var skype = $('skype').value;
	
	var payment_type = $('payment_type').value;
	
	var initial_email_password = $('initial_email_password').value;
	var initial_skype_password = $('initial_skype_password').value;
	
	var staff_currency_id = $('staff_currency_id').value;
	var staff_timezone = $('staff_timezone').value;
	
	var flexi = $('flexi').value;
	
	var overtime = $('overtime').value;
	var overtime_monthly_limit = $('overtime_monthly_limit').value;
	
	//var orig_client_price = $('orig_client_price').value;
	//client_price
	//var client_price_effective_date = $('client_price_effective_date').value;
	//var orig_client_price_effective_date = $('orig_client_price_effective_date').value;
	//var staff_is_prepaid =
	
	
	var prepaid_start_date = $('prepaid_start_date').value;
	var staff_other_client_email = $('staff_other_client_email').value;
	var staff_other_client_email_password = $('staff_other_client_email_password').value;
	var service_type = $('service_type').value;
	
	if(userid==""){
		alert("Staff userid is missing.");
		return false;
	}
	if(leads_id =="0"){
		alert("Please choose a Remotestaff Client");
		return false;
	}
	if(work_status =="0"){
		alert("Staff working status is a required field");
		return false;
	}
	if(staff_monthly ==""){
		alert("Please enter staff monthly salary");
		return false;
	}
	
	if(client_timezone =="0"){
		alert("Please choose Client timezone");
		return false;
	}
	if(client_start_work_hour =="0"){
		alert("Please choose Client preferred working time");
		return false;
	}
	if(starting_date ==""){
		alert("Please specify staff work start date");
		return false;
	}
	
	
	if(flexi == 'no') {
		if(work_days ==""){
			alert("Please choose staff working days");
			return false;
		}
		if(total_weekly_hrs =="0"){
			alert("Staff total weekly hours is zero");
			return false;
		}
	}
	if(currency =="0"){
		alert("Please choose currency");
		return false;
	}
	
	if(client_price ==""){
		alert("Please enter an amount charge to client");
		return false;
	}
	
	if(isNaN(client_price)){
		alert("Please enter a valid amount!");
		$('client_price').value ="";
		return false;
	}
	
	if(isNaN(staff_monthly)){
		alert("Please enter a valid amount!");
		$('staff_monthly').value ="";
		return false;
	}
	
	if(posting_id == null){
		posting_id = 0;
	}
	
	if(email =="" || email ==" "){
		alert("Please enter staff email address");
		return false;
	}
	
	if(skype =="" || skype ==" "){
		alert("Please enter staff skype id");
		return false;
	}

	if(initial_email_password == ""){
		alert("Please enter initial password for the email address of staff");
		return false;
	}
	
	if(initial_skype_password == ""){
		alert("Please enter initial password for the skype id of staff");
		return false;
	}

	if(staff_currency_id == ""){
		alert("Please select staff currency");
		return false;
	}
	
	if(staff_timezone == ""){
		alert("Please select staff working timezone");
		return false;
	}
	
	/*
	if(formatNumber(client_price) != formatNumber(orig_client_price)){
		if(client_price_effective_date == ""){
			alert("Please enter effective date of the new client price");
			$('client_price_effective_date').focus();
			return false;
		}
		if(mode != 'update2'){
		    if(orig_client_price_effective_date == client_price_effective_date){
			    $('client_price_effective_date').value = "";
			    $('client_price_effective_date').focus();
			    alert("Please enter effective date of the new client price");
			    return false;
		    }
		}
		
	}
	*/
	
	var query = queryString({'id' : id , 'userid' : userid, 'leads_id' : leads_id , 'posting_id' : posting_id , 'work_status' : work_status , 'staff_monthly' : staff_monthly, 'client_timezone' : client_timezone , 'client_start_work_hour' : client_start_work_hour , 'client_finish_work_hour' : client_finish_work_hour , 'starting_date' : starting_date , 'work_days' : work_days , 'days' : days , 'total_weekly_hrs' : total_weekly_hrs, 'total_lunch_hrs' : total_lunch_hrs , 'currency' : currency , 'fix_currency_rate': fix_currency_rate , 'current_rate' : current_rate , 'with_tax' : with_tax , 'total_charge_out_rate' : total_charge_out_rate , 'with_bp_comm' : with_bp_comm  , 'with_aff_comm' : with_aff_comm , 'mon_start' : mon_start , 'mon_finish' : mon_finish , 'mon_number_hrs' : mon_number_hrs , 'mon_start_lunch' : mon_start_lunch , 'mon_finish_lunch' : mon_finish_lunch , 'mon_lunch_number_hrs' : mon_lunch_number_hrs, 'tue_start' : tue_start , 'tue_finish' : tue_finish , 'tue_number_hrs' : tue_number_hrs , 'tue_start_lunch' : tue_start_lunch , 'tue_finish_lunch' : tue_finish_lunch , 'tue_lunch_number_hrs' : tue_lunch_number_hrs , 'wed_start' : wed_start , 'wed_finish' : wed_finish , 'wed_number_hrs' : wed_number_hrs , 'wed_start_lunch' : wed_start_lunch , 'wed_finish_lunch' : wed_finish_lunch , 'wed_lunch_number_hrs' : wed_lunch_number_hrs, 'thu_start' : thu_start , 'thu_finish' : thu_finish , 'thu_number_hrs' : thu_number_hrs , 'thu_start_lunch' : thu_start_lunch , 'thu_finish_lunch' : thu_finish_lunch , 'thu_lunch_number_hrs' : thu_lunch_number_hrs, 'fri_start' : fri_start , 'fri_finish' : fri_finish , 'fri_number_hrs' : fri_number_hrs , 'fri_start_lunch' : fri_start_lunch , 'fri_finish_lunch' : fri_finish_lunch , 'fri_lunch_number_hrs' : fri_lunch_number_hrs, 'sat_start' : sat_start , 'sat_finish' : sat_finish , 'sat_number_hrs' : sat_number_hrs , 'sat_start_lunch' : sat_start_lunch , 'sat_finish_lunch' : sat_finish_lunch , 'sat_lunch_number_hrs' : sat_lunch_number_hrs, 'sun_start' : sun_start , 'sun_finish' : sun_finish , 'sun_number_hrs' : sun_number_hrs , 'sun_start_lunch' : sun_start_lunch , 'sun_finish_lunch' : sun_finish_lunch , 'sun_lunch_number_hrs' : sun_lunch_number_hrs , 'admin_notes' : admin_notes , 'email' : email, 'skype' : skype , 'payment_type' : payment_type , 'job_designation' : job_designation , 'initial_email_password' : initial_email_password , 'initial_skype_password' : initial_skype_password , 'staff_registered_email' : staff_registered_email , 'staff_currency_id' : staff_currency_id , 'staff_timezone' : staff_timezone , 'flexi' : flexi , 'overtime' : overtime, 'overtime_monthly_limit' : overtime_monthly_limit, 'prepaid_start_date' : prepaid_start_date, 'staff_other_client_email' : staff_other_client_email, 'staff_other_client_email_password' : staff_other_client_email_password, 'service_type' : service_type, 'client_price' : client_price});
	//alert(query); return false;
	//approve
	if(mode == "approve"){
		if(confirm("Are you sure you want to approve this new staff contract?")){
			$('approve').value = "Processing...";
			$('approve').disabled = true;
			$('cancel').disabled = true;
			var result = doXHR(PATH + 'approveContract.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
			result.addCallbacks(OnSuccessApproveContract, OnFailApproveContract);
		}

	}
	//edit
	if(mode=="edit"){
		if(confirm("Are you sure you want to update this staff contract?")){
			$('update').value = "Processing...";
			$('update').disabled = true;
			$('resigned').disabled = true;
			$('terminated').disabled = true;
			var result = doXHR(PATH + 'updateContract.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
			result.addCallbacks(OnSuccessUpdateContract, OnFailUpdateContract);
		}
	}
	//update
	if(mode=="update"){
		if(confirm("Are you sure you want to approved this updated staff contract?")){
			$('approve_update').value = "Processing...";
			$('approve_update').disabled = true;
			$('cancel').disabled = true;
			var result = doXHR(PATH + 'approveUpdateContract.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
			result.addCallbacks(OnSuccessApproveUpdateContract, OnFailApproveUpdateContract);
		}
	}
	//cancel
	if(mode == "cancel"){
		if(confirm("Are you sure you want to cancel staff contract?")){
			$('cancel').value = "Cancelling...";
			$('cancel').disabled = true;
			var result = doXHR(PATH + 'cancelContract.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
			result.addCallbacks(OnSuccessCancelContract, OnFailCancelContract);
		}
	}
	//edit
	if(mode=="update2"){
		if(confirm("Are you sure you want to update this staff contract?")){
			$('update2').value = "Processing...";
			$('update2').disabled = true;
			//$('resigned').disabled = true;
			//$('terminated').disabled = true;
			var result = doXHR(PATH + 'updateContract2.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
			result.addCallbacks(OnSuccessUpdateContract, OnFailUpdateContract);
		}
	}
}
function OnSuccessApproveContract(e){
	$('applicant_info').innerHTML = e.responseText;
	showAllStaffContractList();
}
function OnFailApproveContract(e){
	alert("Failed to approve staff contract");
}
function OnSuccessUpdateContract(e){
	$('applicant_info').innerHTML = e.responseText;
}
function OnFailUpdateContract(e){
	alert("Failed in updating staff contract");
}
function OnSuccessApproveUpdateContract(e){
	$('applicant_info').innerHTML = e.responseText;
	showAllStaffContractList();
}
function OnFailApproveUpdateContract(e){
	alert("Failed to approved updated staff contract.");
}
function OnSuccessCancelContract(e){
	$('applicant_info').innerHTML = e.responseText;
	showAllStaffContractList();
}
function OnFailCancelContract(e){
	alert("Failed to cancel contract!");
}


function processContract(){
	var userid = $('userid').value;
	var leads_id = $('leads_id').value;
	var posting_id = getRadioButtonValue('ads');
	var work_status = $('work_status').value;
	var staff_monthly = $('staff_monthly').value; // staff monthly
	var client_timezone = $('client_timezone').value;
	var client_start_work_hour = $('client_start_work_hour').value;
	var client_finish_work_hour = $('client_finish_work_hour').value;
	var starting_date = $('starting_date').value;

	var work_days = $('work_days').value;
	var days = $('days').value;
	var total_weekly_hrs = $('total_weekly_hrs').value;
	var total_lunch_hrs = $('total_lunch_hrs').value;

	var mon_start = $('mon_start').value;
	var mon_finish = $('mon_finish').value;
	var mon_number_hrs = $('mon_number_hrs').value;
	var mon_start_lunch = $('mon_start_lunch').value;
	var mon_finish_lunch = $('mon_finish_lunch').value;
	var mon_lunch_number_hrs = $('mon_lunch_number_hrs').value;
	
	var tue_start = $('tue_start').value;
	var tue_finish = $('tue_finish').value;
	var tue_number_hrs = $('tue_number_hrs').value;
	var tue_start_lunch = $('tue_start_lunch').value;
	var tue_finish_lunch = $('tue_finish_lunch').value;
	var tue_lunch_number_hrs = $('tue_lunch_number_hrs').value;
	
	var wed_start = $('wed_start').value;
	var wed_finish = $('wed_finish').value;
	var wed_number_hrs = $('wed_number_hrs').value;
	var wed_start_lunch = $('wed_start_lunch').value;
	var wed_finish_lunch = $('wed_finish_lunch').value;
	var wed_lunch_number_hrs = $('wed_lunch_number_hrs').value;
	
	var thu_start = $('thu_start').value;
	var thu_finish = $('thu_finish').value;
	var thu_number_hrs = $('thu_number_hrs').value;
	var thu_start_lunch = $('thu_start_lunch').value;
	var thu_finish_lunch = $('thu_finish_lunch').value;
	var thu_lunch_number_hrs = $('thu_lunch_number_hrs').value;
	
	var fri_start = $('fri_start').value;
	var fri_finish = $('fri_finish').value;
	var fri_number_hrs = $('fri_number_hrs').value;
	var fri_start_lunch = $('fri_start_lunch').value;
	var fri_finish_lunch = $('fri_finish_lunch').value;
	var fri_lunch_number_hrs = $('fri_lunch_number_hrs').value;
	
	var sat_start = $('sat_start').value;
	var sat_finish = $('sat_finish').value;
	var sat_number_hrs = $('sat_number_hrs').value;
	var sat_start_lunch = $('sat_start_lunch').value;
	var sat_finish_lunch = $('sat_finish_lunch').value;
	var sat_lunch_number_hrs = $('sat_lunch_number_hrs').value;
	
	var sun_start = $('sun_start').value;
	var sun_finish = $('sun_finish').value;
	var sun_number_hrs = $('sun_number_hrs').value;
	var sun_start_lunch = $('sun_start_lunch').value;
	var sun_finish_lunch = $('sun_finish_lunch').value;
	var sun_lunch_number_hrs = $('sun_lunch_number_hrs').value;
	
	
	
	var currency = $('currency').value;
	var client_price = $('client_price').value; //client price monthly
	var fix_currency_rate = $('fix_currency_rate').value;
	var current_rate = $('current_rate').value;
	var with_tax = $('with_tax').value;
	var total_charge_out_rate =$('total_charge_out_rate').value;
	var with_bp_comm = $('with_bp_comm').value;
	var with_aff_comm = $('with_aff_comm').value;
	
	
	var admin_notes = $('admin_notes').value;
	
	var email = $('email').value;
	var skype = $('skype').value;
	
	var payment_type = $('payment_type').value;
	var job_designation = $('job_designation').value;
	
	
	var initial_email_password = $('initial_email_password').value;
	var initial_skype_password = $('initial_skype_password').value;
	
	var staff_registered_email = $('staff_registered_email').value;
	var staff_currency_id = $('staff_currency_id').value;
	var staff_timezone = $('staff_timezone').value;
	var flexi = $('flexi').value;
	
	var overtime = $('overtime').value;
	var overtime_monthly_limit = $('overtime_monthly_limit').value;

	var staff_other_client_email = $('staff_other_client_email').value;
	var staff_other_client_email_password =$('staff_other_client_email_password').value;
	var service_type = $('service_type').value;
	
	if(userid==""){
		alert("Staff userid is missing.");
		return false;
	}
	if(leads_id =="0"){
		alert("Please choose a Remotestaff Client");
		return false;
	}
	if(work_status =="0"){
		alert("Staff working status is a required field");
		return false;
	}
	if(staff_monthly ==""){
		alert("Please enter staff monthly salary");
		return false;
	}
	
	if(client_timezone =="0"){
		alert("Please choose Client timezone");
		return false;
	}
	if(client_start_work_hour =="0"){
		alert("Please choose Client preferred working time");
		return false;
	}
	if(starting_date ==""){
		alert("Please specify staff work start date");
		return false;
	}
	if(flexi == 'no') {
		if(work_days ==""){
			alert("Please choose staff working days");
			return false;
		}
		if(total_weekly_hrs =="0"){
			alert("Staff total weekly hours is zero");
			return false;
		}
	}
	if(currency =="0"){
		alert("Please choose currency");
		return false;
	}
	if(client_price ==""){
		alert("Please enter an amount charge to client");
		return false;
	}
	
	if(isNaN(client_price)){
		alert("Please enter a valid amount!");
		$('client_price').value ="";
		return false;
	}
	
	if(isNaN(staff_monthly)){
		alert("Please enter a valid amount!");
		$('staff_monthly').value ="";
		return false;
	}
	
	if(posting_id == null){
		posting_id = 0;
	}
	
	if(email =="" || email ==" "){
		alert("Please enter staff email address");
		return false;
	}
	
	if(skype =="" || skype ==" "){
		alert("Please enter staff skype id");
		return false;
	}
	
	if(initial_email_password == ""){
		alert("Please enter initial password for the email address of staff");
		return false;
	}
	
	if(initial_skype_password == ""){
		alert("Please enter initial password for the skype id of staff");
		return false;
	}
	
	var query = queryString({'userid' : userid, 'leads_id' : leads_id , 'posting_id' : posting_id , 'work_status' : work_status , 'staff_monthly' : staff_monthly, 'client_timezone' : client_timezone , 'client_start_work_hour' : client_start_work_hour , 'client_finish_work_hour' : client_finish_work_hour , 'starting_date' : starting_date , 'work_days' : work_days , 'days' : days , 'total_weekly_hrs' : total_weekly_hrs, 'total_lunch_hrs' : total_lunch_hrs , 'currency' : currency , 'client_price' : client_price , 'fix_currency_rate': fix_currency_rate , 'current_rate' : current_rate , 'with_tax' : with_tax , 'total_charge_out_rate' : total_charge_out_rate , 'with_bp_comm' : with_bp_comm  , 'with_aff_comm' : with_aff_comm , 'mon_start' : mon_start , 'mon_finish' : mon_finish , 'mon_number_hrs' : mon_number_hrs , 'mon_start_lunch' : mon_start_lunch , 'mon_finish_lunch' : mon_finish_lunch , 'mon_lunch_number_hrs' : mon_lunch_number_hrs, 'tue_start' : tue_start , 'tue_finish' : tue_finish , 'tue_number_hrs' : tue_number_hrs , 'tue_start_lunch' : tue_start_lunch , 'tue_finish_lunch' : tue_finish_lunch , 'tue_lunch_number_hrs' : tue_lunch_number_hrs , 'wed_start' : wed_start , 'wed_finish' : wed_finish , 'wed_number_hrs' : wed_number_hrs , 'wed_start_lunch' : wed_start_lunch , 'wed_finish_lunch' : wed_finish_lunch , 'wed_lunch_number_hrs' : wed_lunch_number_hrs, 'thu_start' : thu_start , 'thu_finish' : thu_finish , 'thu_number_hrs' : thu_number_hrs , 'thu_start_lunch' : thu_start_lunch , 'thu_finish_lunch' : thu_finish_lunch , 'thu_lunch_number_hrs' : thu_lunch_number_hrs, 'fri_start' : fri_start , 'fri_finish' : fri_finish , 'fri_number_hrs' : fri_number_hrs , 'fri_start_lunch' : fri_start_lunch , 'fri_finish_lunch' : fri_finish_lunch , 'fri_lunch_number_hrs' : fri_lunch_number_hrs, 'sat_start' : sat_start , 'sat_finish' : sat_finish , 'sat_number_hrs' : sat_number_hrs , 'sat_start_lunch' : sat_start_lunch , 'sat_finish_lunch' : sat_finish_lunch , 'sat_lunch_number_hrs' : sat_lunch_number_hrs, 'sun_start' : sun_start , 'sun_finish' : sun_finish , 'sun_number_hrs' : sun_number_hrs , 'sun_start_lunch' : sun_start_lunch , 'sun_finish_lunch' : sun_finish_lunch , 'sun_lunch_number_hrs' : sun_lunch_number_hrs , 'admin_notes' : admin_notes , 'email' : email, 'skype' : skype , 'payment_type' : payment_type , 'job_designation' : job_designation , 'initial_email_password' : initial_email_password , 'initial_skype_password' : initial_skype_password ,  'staff_registered_email' : staff_registered_email , 'staff_currency_id' : staff_currency_id , 'staff_timezone' : staff_timezone , 'flexi' : flexi, 'overtime' : overtime, 'overtime_monthly_limit' : overtime_monthly_limit, 'staff_other_client_email' : staff_other_client_email, 'staff_other_client_email_password' : staff_other_client_email_password, 'service_type' : service_type });
	//alert(query);return false;
	
	$('process').value = "Processing...";
	$('process').disabled = true;
	var result = doXHR(PATH + 'processContract.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessProcessContract, OnFailProcessContract);
	
}

function OnSuccessProcessContract(e){
	//$('result_options').style.display="none";
	var str = e.responseText;
	var n=str.search("ERROR");
	if(n >= 0){
		alert(e.responseText);
		$('process').value = "Add New Contract";
		$('process').disabled = false;
	}else{	
		$('applicant_info').innerHTML = e.responseText;
	}
}
function OnFailProcessContract(e){
	alert("Failed to process staff contract");
	$('process').value = "Add New Contract";
	$('process').disabled = false;
}

function showPopWindow(){
	//alert("hello");
	new popUp(500, 500, 300, 175, "Div", "Put all of your content text in here.<br><br>You can also place HTML code in here too, such as a picture: <img src=\"max.gif\">. Notice how a backslash must proceed every quotation (\") that appears in your HTML content.", "white", "black", "bold 10pt sans-serif", "Title Bar", "navy", "white", "#dddddd", "gray", "black", true, true, true, true, false);
}

function setClientChargeOutRate(){
	var salary = $('staff_monthly').value; // staff monthly
	var currency = $('currency').value;
	var client_price = $('client_price').value; //client price monthly
	var day = 5;//$('days').value;
	//var hour = $('total_weekly_hrs').value;
	var flag = false; // default
	var total_charge_out_rate = 0;
	var with_tax = $('with_tax').value;
	var fix_rate = 0;
	var tax_str="";
	var percent=0;
	var tax =0;
	var curency_symbol ="";
	var fix_rate = 0;
	var difference =0;
	var current_rate =$('current_rate').value;
	var today_rate_salary =0;
	var fix_rate_salary =0;
	
    var leads_id = $('leads_id').value;
	var view_inhouse_confidential = $('view_inhouse_confidential').value;
	
	var work_status = $('work_status').value; // Full-Time Part-Time
	var hour = 8; //$('total_weekly_hrs').value;
	if(work_status == "Part-Time"){
		var hour = 4;
	}
	
	$('with_tax').disabled = true;
	
	if(currency == "0"){
		//alert("Please choose currency");
		return false;
	}
	
	if($('total_weekly_hrs').value==""){
		hour = 8;
		flag = false; // means no selected time yet
	}
	
	$('currency_txt').innerHTML = currency;
	var staff_currency_id = $('staff_currency_id').value;
	var fix_currency_rate_str='';
	if(staff_currency_id == 6){
		fix_currency_rate_str = 'PHP';
	}else if(staff_currency_id == 8){
		fix_currency_rate_str = 'INR';
	}else if(staff_currency_id == 7){
		fix_currency_rate_str = 'CNY';
	}else{
	    fix_currency_rate_str = '';
	}
	if(currency == "AUD"){
		if(staff_currency_id == 6){
		    fix_rate = 39;
		}else if(staff_currency_id == 7){ // RMB
			fix_rate = 5.8;	
		}else if(staff_currency_id == 8){ //rupee
			fix_rate = 40;
		
		}else{
			fix_rate = 0;
		}
		tax_str = "GST 10%";
		percent = 10;
		curency_symbol = "AUD";
		$('with_tax').disabled = false;
		
	}else if(currency == "USD"){
		if(staff_currency_id == 6){
		    fix_rate = 40;
		}else if(staff_currency_id == 7){//rmb
			fix_rate = 5;	
		}else if(staff_currency_id == 8){//rupee
			fix_rate = 70;
		}else{
			fix_rate = 0;
		}
		//fix_rate = 43;
		tax_str = "VAT 10%";
		percent = 10;
		curency_symbol = "USD";
		$('with_tax').disabled = false;
	}else if(currency == "GBP"){
		if(staff_currency_id == 6){
		    fix_rate = 61;
		}else if(staff_currency_id == 7){//rmb
			fix_rate = 10;	
		}else if(staff_currency_id == 8){//rupee
			fix_rate = 43;
		}else{
			fix_rate = 0;
		}
		//fix_rate = 61;
		tax_str = "VAT 17.5%";
		percent =17.5;
		curency_symbol = "GBP";
		$('with_tax').disabled = false;
	} else {
		fix_rate = 0;
		tax_str = "not available";
		percent =0;
		curency_symbol = "NA";
		$('with_tax').disabled = true;
	}
	
	$('fix_currency_rate').value = fix_rate;
	$('tax_str').innerHTML = tax_str;
	$('fix_currency_rate_str').innerHTML = fix_currency_rate_str;
	//alert(client_price);
	
	if(client_price != ""){
		if(isNaN(client_price)){
			alert("Please enter a valid amount!");
			$('client_price').value ="";
			return false;
		}
		
		if(isNaN(current_rate)){
			alert("Please enter a valid amount!");
			$('current_rate').value ="";
			return false;
		}
		
		//peso
		var weekly = ((parseFloat(client_price)*12)/52);
		var daily = (parseFloat(weekly) / day);
		if(flag == false){
			var hourly = (parseFloat(daily) / hour);
		}else{
			var hourly = (parseFloat(weekly) / hour);
		}
		//display it on the table
		if(leads_id == '11' && view_inhouse_confidential == 'N'){
			
			$('client_y').innerHTML = "***";
			$('client_m').innerHTML = "***";
			$('client_w').innerHTML = "***";
			$('client_d').innerHTML = "***";
			$('client_h').innerHTML = "***"; 
			
		}else{
			
			$('client_y').innerHTML = formatNumber(client_price * 12);
			$('client_m').innerHTML = formatNumber(client_price);
			$('client_w').innerHTML = formatNumber(weekly); 
			$('client_d').innerHTML = formatNumber(daily); 
			$('client_h').innerHTML = formatNumber(hourly); 
			
		}
		
		/*
		if(current_rate!=""){
			if(salary!=""){	
				//currency rate charge
				fix_rate_salary = salary / fix_rate ;
				today_rate_salary =  (parseFloat(salary)) / parseInt(current_rate);
				if(current_rate > fix_rate){ //the current_rate must be higher than the fix_rate
					difference = (parseFloat(fix_rate_salary) - parseFloat(today_rate_salary));
				}
			}else{
				alert("You must enter staff monthly salary");
				return false;
			}
			
		}
		//alert(fix_rate_salary + "\n" + today_rate_salary+"\n"+difference);
		*/
		
		//display the result
		if(with_tax=='YES'){
			tax = ((client_price/100) * percent);
			total_charge_out_rate = (parseFloat(client_price) + parseFloat(tax) + parseFloat(difference));	
			$('total_charge_out_rate').value = formatNumber(total_charge_out_rate);
		}
		
		if(with_tax=='NO'){
			tax = 0;//((client_price/100) * percent);
			total_charge_out_rate = (parseFloat(client_price) + parseFloat(tax)+ parseFloat(difference));	
			$('total_charge_out_rate').value = formatNumber(total_charge_out_rate);
		}
		
	}
	
	revenueMargin();
	//var mode = $('mode').value;
	//alert(mode);
}

function revenueMargin(){
	var salary = $('staff_monthly').value; // staff monthly
	var currency = $('currency').value;
	var client_price = $('client_price').value; //client price monthly
	var margin=0;
	var fix_rate=0;
	var with_bp_comm = $('with_bp_comm').value;
	var with_aff_comm = $('with_aff_comm').value;
	var sub_total =0;
	var aff_comm =0;
	var bp_comm =0;
	//var max_month_interval = 0
	var payment_type = $('payment_type').value;
	

	var	max_month_interval = $('max_month_interval').value;
	var current_rate =$('current_rate').value;

	//BARTERCARD CASH

	if(currency == "AUD"){
		fix_rate = 39;
		curency_symbol = " AUD";
	}else if(currency == "USD"){
		fix_rate = 40;
		curency_symbol = " USD";
	}else if(currency == "GBP"){
		fix_rate = 61;
		curency_symbol = " GBP";
	}else if(currency == "EURO"){
		fix_rate = 68;
		curency_symbol = " EURO";
	}else if(currency == "CAD"){
		fix_rate = 45;
		curency_symbol = " CAD";
	}else{
		fix_rate = 0;
		curency_symbol = " PHP";
	}
	
	if(current_rate!=""){
		fix_rate = current_rate;
	}
	
	if(fix_rate > 0) {
			margin = ( client_price - (parseFloat(salary) / fix_rate)) ; //get the difference
			
			//if(max_month_interval <= 3){ // 3 months
				if(payment_type == "CASH"){	
					if(with_aff_comm == "YES") { //the affiliate can have a 5% commission
						aff_comm = ((client_price/100) * 5);
					}
					if(with_bp_comm == "YES") { //the business partner can have a 15% commission
						bp_comm = (((margin - aff_comm)/100)*15);
					}
					$('bp_comm').innerHTML = formatNumber(bp_comm);
					$('aff_comm').innerHTML = formatNumber(aff_comm);
					//$('with_comm').innerHTML ="";
					$('bp_str').innerHTML = "";
					$('aff_str').innerHTML = "";
					$('salary_formula2').innerHTML = "";
				}
				
				if(payment_type == "BARTERCARD"){	
					$('bp_comm').innerHTML = "NA";
					$('aff_comm').innerHTML = "NA";
					$('bp_str').innerHTML = "NA";
					$('aff_str').innerHTML = "NA";
					
					$('with_bp_comm').selectedIndex =0;
					$('with_aff_comm').selectedIndex =0;
					$('salary_formula2').innerHTML = "Business Partner and Affiliate Commission is not applicable";
				}
				
			/*}else{
				$('salary_formula2').innerHTML = "Business Partner and Affiliate Commission is not applicable";
				$('with_bp_comm').selectedIndex =0;
				$('with_aff_comm').selectedIndex =0;
				$('bp_str').innerHTML = "NA";
				$('aff_str').innerHTML = "NA";
			}
			*/
			sub_total = (margin - aff_comm) - bp_comm;
			$('revenue').innerHTML = formatNumber(margin);
			$('net').innerHTML = formatNumber(sub_total)+curency_symbol;
		
	}else{
			$('bp_comm').innerHTML = "NA";
			$('aff_comm').innerHTML = "NA";
			$('bp_str').innerHTML = "NA";
			$('aff_str').innerHTML = "NA";
			
			$('with_bp_comm').selectedIndex =0;
			$('with_aff_comm').selectedIndex =0;
			$('salary_formula2').innerHTML = "NA";
			$('revenue').innerHTML = "NA";
			$('net').innerHTML = "NA";
	}
}

function autoPopulate2(){
	var work_status = $('work_status').value;
	var start_time = $("client_start_work_hour").value;
	if(work_status!="0" && start_time!="0"){
		var query = queryString({'start_time' :start_time, 'work_status' : work_status });
		var result = doXHR(PATH + 'autoPopulate.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
		result.addCallbacks(OnSuccessAutoPopulate2, OnFailAutoPopulate);
	}
}
function OnSuccessAutoPopulate2(e){
	$("finish_time_div").innerHTML = e.responseText;
	//check_val();
}


function autoPopulate(){
	var work_status = $('work_status').value;
	var start_time = $("client_start_work_hour").value;
	if(work_status!="0" && start_time!="0"){
		var query = queryString({'start_time' :start_time, 'work_status' : work_status });
		var result = doXHR(PATH + 'autoPopulate.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
		result.addCallbacks(OnSuccessAutoPopulate, OnFailAutoPopulate);
	}
}

function OnSuccessAutoPopulate(e){
	$("finish_time_div").innerHTML = e.responseText;
	setTimeZone();
}
function OnFailAutoPopulate(e){
	alert("Failed to populate . Please try again later");
}


function setTimeZone(){
	var client_timezone = $("client_timezone").value;
	var staff_timezone = $('staff_timezone').value;
	var start_time = $("client_start_work_hour").value;
	var finish_time = $("client_finish_work_hour").value;
	var work_status = $('work_status').value;
	var flexi = document.getElementsByName('flexi');
	
	
	if(client_timezone!="0" && start_time!="0" && finish_time!="0" && work_status !="0" && staff_timezone!="" ) {
		var query = queryString({'client_timezone' : client_timezone , 'staff_timezone' : staff_timezone, 'start_time' :start_time, 'finish_time' : finish_time , 'work_status' : work_status });
		//alert(query);
		var result = doXHR(PATH + 'setTimeZone.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
		result.addCallbacks(OnSuccessSetTimeZone, OnFailSetTimeZone);
	}
}

function OnSuccessSetTimeZone(e){
	$('working_days_div').innerHTML = e.responseText;
	check_val();
}
function OnFailSetTimeZone(e){
	alert("Failed to convert timezone");
}


function check_val()
{	
	var ins = document.getElementsByName('weekdays')
	var i;
	var j=0;
	var weekdays;
	var vals= new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			vals[j]=ins[i].value;
		  	weekdays=(ins[i].value);
			//determines if the day is selected the start and finish time also for the lunch time should not be disabled.		
			 setWeekDaysTime(weekdays,false);
			j++;
		}else{
			weekdays=(ins[i].value);
		  	setWeekDaysTime(weekdays,true);
		}
	}
	$('days').value=(vals.length);
	$('work_days').value=(vals);
	convertSalary();
}

function setWeekDaysTime(weekdays , flag){
	//determine first if the day is selected
	
	//weekdays start and finish time select box
	$(weekdays+'_start').disabled = flag;
	$(weekdays+'_finish').disabled = flag;
	//lunch 
	$(weekdays+'_start_lunch').disabled = flag;
	$(weekdays+'_finish_lunch').disabled = flag;

	//means the select box is NOT disabled we should get the value to get the working hours on that day default it to zero if selected box is disabled
	if(flag == false){ 
		var start =  $(weekdays+'_start').value;
		var finish = $(weekdays+'_finish').value;
		
		var start_lunch = $(weekdays+'_start_lunch').value;
		var finish_lunch = $(weekdays+'_finish_lunch').value;

		start = start.replace(":30", ".5");
		finish = finish.replace(":30", ".5");
		
		var work_hours = (finish - start);
		if(work_hours < 0){
			work_hours = work_hours + 24 ;
		}
		
		start_lunch = start_lunch.replace(/:30/g, ".5");
		finish_lunch = finish_lunch.replace(/:30/g, ".5");
		
		var lunch_hours = (finish_lunch - start_lunch);
		if(lunch_hours < 0){
			lunch_hours = lunch_hours + 24 ;
		}
		
		$(weekdays+'_number_hrs').value = (work_hours - lunch_hours);
		$(weekdays+'_lunch_number_hrs').value = lunch_hours;
		
		
		
	//	
	}else{
		$(weekdays+'_number_hrs').value = 0;
		$(weekdays+'_lunch_number_hrs').value = 0;
		$(weekdays+'_start').selectedIndex = 0;
		$(weekdays+'_finish').selectedIndex = 0;
		$(weekdays+'_start_lunch').selectedIndex = 0;
		$(weekdays+'_finish_lunch').selectedIndex = 0;
	}
	//update the total working hours and total lunch hours
	calculateTotalWorkingHours();
}

function calculateTotalWorkingHours(){
	//updating the total working hours and total lunch hours
	//alert("Hello World");
	var weekdays = new Array('mon','tue','wed','thu','fri','sat','sun');
	var hrs = 0;
	var total_hrs = 0;
	var lunch_hrs =0;
	var total_lunch_hrs = 0;
	for(var i=0; i<(weekdays.length);i++){
		hrs = $(weekdays[i]+'_number_hrs').value;
		lunch_hrs = $(weekdays[i]+'_lunch_number_hrs').value;
		if(hrs!=""){
			total_hrs = (parseFloat(total_hrs) + parseFloat(hrs));
		}
		if(lunch_hrs!=""){
			total_lunch_hrs = parseFloat(total_lunch_hrs) + parseFloat(lunch_hrs);
		}
	}
	$('total_weekly_hrs').value = total_hrs;
	$('total_lunch_hrs').value = total_lunch_hrs;
	
	convertSalary();
	setClientChargeOutRate();
}


function convertSalary(){
	//alert("hello world");
	var leads_id = $('leads_id').value;
	var view_inhouse_confidential = $('view_inhouse_confidential').value;
	var work_status = $('work_status').value; // Full-Time Part-Time
	
	
	var salary = $('staff_monthly').value;
	
	
	var flexi = $('flexi').value;
	if(flexi == 'yes'){
		//var day =  5;
	}else{
		//var day =  $('days').value;
	}
	var day =  5;
	var hour = 8; //$('total_weekly_hrs').value;
	var salary_formula = "";
	
	var flag = false; //default
	if(work_status == "Part-Time"){
		var hour = 4;
	}
	salary_formula = "Default Formula : ((((Monthly Salary * 12 months) / 52 weeks) / "+day+" days)/"+hour+" hrs)";
	$('salary_formula').innerHTML = salary_formula;
	$('salary_formula2').innerHTML = salary_formula;
	
	var weekly = ((parseFloat(salary)*12)/52);
	var daily = (parseFloat(weekly) / day);
	
	if(flag == false){
		var hourly = (parseFloat(daily) / hour);
	}else{
		var hourly = (parseFloat(weekly) / hour);
	}
	if(leads_id == '11' && view_inhouse_confidential == 'N'){
		$('staff_yearly').innerHTML = "<label>Yearly :</label>confidential";
	    $('staff_monthly').innerHTML = "<label>Monthly :</label>confidential";
	    $('staff_weekly').innerHTML = "<label>Weekly :</label>confidential"; 
	    $('staff_daily').innerHTML = "<label>Daily :</label>confidential"; 
	    $('staff_hourly').innerHTML = "<label>Hourly :</label>confidential";
	}else{
	    $('staff_yearly').innerHTML = "<label>Yearly :</label>"+formatNumber((parseFloat(salary)*12));
	    $('staff_monthly').innerHTML = "<label>Monthly :</label>"+formatNumber(salary);
	    $('staff_weekly').innerHTML = "<label>Weekly :</label>"+formatNumber(weekly); 
	    $('staff_daily').innerHTML = "<label>Daily :</label>"+formatNumber(daily); 
	    $('staff_hourly').innerHTML = "<label>Hourly :</label>"+formatNumber(hourly); 
	}
	
}

function createNewApplicant(){
	var fname = $('fname').value;
	var lname = $('lname').value;
	var email = $('email').value;
	var skype = $('skype').value;
	var phone = $('phone').value;
	
	if(fname == ""){
		alert("First name is a required field");
		return false;
	}
	
	if(lname == ""){
		alert("Lasst name is a required field");
		return false;
	}
	
	if(email == ""){
		alert("Email address is a required field");
		return false;
	}
	
	if(skype == ""){
		alert("Skype is a required field");
		return false;
	}
	
	$('create_btn').disabled = true;
	//$('create_btn').value = "Processing"
	var query = queryString({'fname' : fname , 'lname' : lname , 'email' : email , 'skype' : skype , 'phone' : phone });
	var result = doXHR(PATH + 'createNewApplicant.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessCreateNewApplicant, OnFailCreateNewApplicant);

}

function OnSuccessCreateNewApplicant(e){
	userid = e.responseText
	//alert(userid);
	$('result_options').innerHTML = "";
	$('result_options').innerHTML = "<p align =\"center\"><input type=\"hidden\" name=\"userid\" id=\"userid\" value="+userid+" /><b> New Applicant Successfully Added in the system database</b><p>";
	showApplicantDetails(userid);
}
function OnFailCreateNewApplicant(e){
	alert("Failed to Add new Applicant to the system database");
}

function showClientAds(){
	
	var leads_id = $('leads_id').value;
	var id = $('id').value;
	var table_used = $('table_used').value;
	if(leads_id=="0"){
		alert("Please choose a client");
		return false;
	}
	$('client_ads').innerHTML = "Loading client's advertisement...";
	var query = queryString({'leads_id' : leads_id , 'id' : id, 'table_used' : table_used });
	var result = doXHR(PATH + 'showClientAds.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowClientAds, OnFailShowClientAds);
}

function OnSuccessShowClientAds(e){
	$('client_ads').innerHTML =  e.responseText;
	$('prepaid').value = $('client_prepaid').value;
	var currency_code = $('currency_code').value;
	if(currency_code != ""){
		$('currency_box').innerHTML="<input type='text' name='currency' id='currency' value='"+currency_code+"' size='10' readonly />";
	}else{
		$('currency_box').innerHTML='<select onchange="setClientChargeOutRate();" class="select" id="currency" name="currency"><option value="0">Choose Currency</option><option value="AUD">AUD-Australian dollar</option><option value="GBP">GBP-Pound sterling</option><option value="USD">USD-United States dollar</option></select>';
	}
	checkClientHistory();
	
}

function OnFailShowClientAds(e){
	alert("Failed to parse client's Advertisement");
}


function checkEmail(email , mode){
	if(email == "" || email == " "){
		alert("Please enter an email address");
		return false;
	}
	var query = queryString({'email' : email });
	var result = doXHR(PATH + 'checkEmail.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessCheckEmail, OnFailCheckEmail);
	
	function OnSuccessCheckEmail(e){
		var flag = e.responseText;
		//alert(flag);
		
		if(flag == 1){
			alert("Invalid email address!");
			$('email').value = "";
			return false;
		}
		else if(flag == 2){
			
			if(mode == "new"){
				alert("The Email that you entered already Exists ! Please try to enter a different email.");
				$('email').value = "";
			}
			if(mode == "old"){
				alert("This email is already in used . If you want to change it , please try to enter a different email address.");
				$('email').value = $('orig_email').value;
			}

			return false;
		}
		else{
			email = flag.split(' ').join('');	
			$('email').value = email;
		}
		
			
	}
	
	function OnFailCheckEmail(e){
		alert("Failed to check this email " + email);
	}

	
}





function showApplicantDetails(userid){
	$('applicant_info').innerHTML = "Loading applicant's profile";
	var mode = 'update';
	if($('mode') != null){
		mode = $('mode').value;	
	}
	var query = queryString({'userid' : userid , 'mode' : mode });
	//alert(query);
	var result = doXHR(PATH + 'showApplicantDetails.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowApplicantDetails, OnFailShowApplicantDetails);
}

function OnSuccessShowApplicantDetails(e){
	
	$('applicant_info').innerHTML = e.responseText;
	toggle('result_options');
	var min_date=$('min_date').value;
	Calendar.setup({
            inputField : "starting_date",
            trigger    : "bd",
            onSelect   : function() { this.hide()  },
            //showTime   : 12,
			fdow  : 0,
            dateFormat : "%Y-%m-%d",
			min: parseInt(min_date)

        });
}

function OnFailShowApplicantDetails(e){
	alert("Failed to show Applicants Profile");
}


var search_result = doXHR();

function showOptionsResult(mode){
	//alert(mode);
	var keyword = "";
	$('result_options').innerHTML = "Loading...";
	$('applicant_info').innerHTML = "";

	$('result_options').style.height = "";
	$('result_options').style.borderBottom = "";
	if(mode == "keyword"){
		keyword = $('keyword').value;
		//if(keyword =="" || keyword ==" "){
		//	alert("There is no keyword to be search");
		//	return false;
		//}
		
		$('result_options').style.height = "250px";
		$('result_options').style.borderBottom = "#000 solid 1px";
	}
	
	//1 create new , 2 select from applicants list , 3 select from marked applicant list, 4 keyword search
	
	//var result ="";
	//result.cancel();
	var query = queryString({'mode' : mode , 'keyword' : keyword});
	search_result.cancel();
	search_result = doXHR(PATH + 'showAddOptions.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	search_result.addCallbacks(OnSuccessShowAddOptions, OnFailShowAddOptions);

}

function OnSuccessShowAddOptions(e){
	$('result_options').style.display="block";
	$('result_options').innerHTML = e.responseText;
}

function OnFailShowAddOptions(e){
	$('result_options').innerHTML = 'Loading';
}


function formatNumber(num){
	var num = Math.round(num*100)/100;
	return num;
}
