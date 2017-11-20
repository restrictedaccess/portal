// JavaScript Document
var PATH = 'leads_information/';

function CheckAddUpdateLeadsEmail(){
	var fname = $('fname').value;
	var lname = $('lname').value;
	var email = $('email').value;
	var leads_id = $('leads_id').value;
	
	var supervisor_email = $('supervisor_email').value;
	var sec_email = $('sec_email').value;
	var acct_dept_email1 = $('acct_dept_email1').value;
	var acct_dept_email2 = $('acct_dept_email2').value;
	
	if(fname == ""){
		alert("First name is a required field");
		return false;
	}
	
	if(lname == ""){
		alert("Last name is a required field");
		return false;
	}
	
	if(email == ""){
		alert("Please enter an email address");
		return false;
	}
	
	
	
	var query = queryString({'email' : email, 'leads_id' : leads_id, 'supervisor_email' : supervisor_email, 'sec_email' : sec_email, 'acct_dept_email1' : acct_dept_email1, 'acct_dept_email2' : acct_dept_email2  });
	var result = doXHR(PATH + 'CheckValidExistingEmail.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessCheckValidExistingEmail, OnFailCheckValidExistingEmail);	
}

function OnSuccessCheckValidExistingEmail(e){
	if(e.responseText == 'ok'){
		//alert(e.responseText);
	    document.form.submit();
		//document.getElementById('add_update_form').submit();
	}else{
		alert(e.responseText);
	}
	
}
function OnFailCheckValidExistingEmail(){
	alert("Failed to validate primary email.");	
}

function SetJoComment(obj){
	var leads_id = $('leads_id').value;
	var gs_job_titles_details_id = getNodeAttribute(obj, 'gs_job_titles_details_id');
	var comment = getNodeAttribute(obj, 'comment');
	//alert(gs_job_titles_details_id+" \n "+comment);
	//document.form.submit();
	var query = queryString({'leads_id' : leads_id, 'gs_job_titles_details_id' : gs_job_titles_details_id , 'comment' : comment  });
	//alert(query);
	
	var result = doXHR(PATH + 'set_jo_comment.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSetJoComment, OnFailSetJoComment);
	
}

function OnSuccessSetJoComment(e){
    if(e.responseText == 'ok'){
		alert("Successfully updated");
		document.form.submit();
	}else{
		alert(e.responseText);
	}
}

function OnFailSetJoComment(e){
    alert("Failed to set action");
}

function checkCcIfSelected(){
	var ins = document.getElementsByName('cc')
	var i;
	var j=0;
	var vals=new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			var obj = ins[i].value;
			if(obj == 'email'){
		        field = $('email').innerHTML;
	        }else{
		        field = $(obj).value;
	        }
			if(field){
			    vals[j]=obj;
			    j++;
			}
		}
	}
	
	$('cc_emails').value = (vals);
}
function checkAccountIfSelected(){
	
	var ins = document.getElementsByName('accounts_name');
	var i;
	var j=0;
	for(i=0;i<ins.length;i++){
		if(ins[i].checked==true) {
			j = j + 1;
		}
	}
	if (j > 0){
		document.getElementsByName('invoice_address_to')[3].checked=true;
	}
}

function get_val(obj)
{
	var ins = document.getElementsByName(obj)
	var i;
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			return ins[i].value;
			break;
		}
	}
    
}

function SelectCcEmail(e){
	
	//check if the selected cc email has value
	if(e.src().checked == true){
		var obj = getNodeAttribute(e.src(), 'value');
		if(obj == 'email'){
		    field = $('email').innerHTML;
	    }else{
		    field = $(obj).value;
	    }
		if(field == ""){
			alert("There is no email address in this selected option");
		    e.src().checked = false;
		    return false;
		}
	}
	
	
	
	var ins = document.getElementsByName('cc')
	var i;
	var j=0;
	var vals=new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			var obj = ins[i].value;
			if(obj == 'email'){
		        field = $('email').innerHTML;
	        }else{
		        field = $(obj).value;
	        }
			if(field){
			    vals[j]=obj;
			    j++;
			}
		}
	}
	
	$('cc_emails').value = (vals);
}

function SelectDefaultEmail(e){
     var obj = getNodeAttribute(e.src(), 'value');
	 var field = '';
	 if(obj == 'email'){
		 field = $('email').innerHTML;
	 }else{
		 field = $(obj).value;
	 }
	 
	 if(field == ''){
		 alert("There is no email address in this selected option");
		 e.src().checked = false;
		 return false;
	 }
}

function SelectASLDefaultEmail(e){
     var obj = getNodeAttribute(e.src(), 'value');
	 var field = '';
	 if(obj == 'email'){
		 field = $('email').innerHTML;
	 }else{
		 field = $(obj).value;
	 }
	 
	 if(field == ''){
		 alert("There is no email address in this selected option");
		 e.src().checked = false;
		 return false;
	 }
}

function SelectASLCcEmail(e){
	
	//check if the selected cc email has value
	if(e.src().checked == true){
		var obj = getNodeAttribute(e.src(), 'value');
		if(obj == 'email'){
		    field = $('email').innerHTML;
	    }else{
		    field = $(obj).value;
	    }
		if(field == ""){
			alert("There is no email address in this selected option");
		    e.src().checked = false;
		    return false;
		}
	}
	
	
	
	var ins = document.getElementsByName('asl_cc')
	var i;
	var j=0;
	var vals=new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			var obj = ins[i].value;
			if(obj == 'email'){
		        field = $('email').innerHTML;
	        }else{
		        field = $(obj).value;
	        }
			if(field){
			    vals[j]=obj;
			    j++;
			}
		}
	}
	
	$('asl_cc_emails').value = (vals);
}

function SelectAccountsTo(e){
    
	var ins = document.getElementsByName('invoice_address_to');
	var i;
	for(i=0;i<ins.length;i++){
	    ins[i].checked=false;
	}
	ins[3].checked=true;
	
	var obj = getNodeAttribute(e.src(), 'value');
    field = $(obj).value;
	if(field == ""){
	    alert("There is no name in this selected option");
		e.src().checked = false;
		//ins[3].checked=false;
		return false;
	}
}

function SelectAddressTo(e){
    var address_to = get_val('invoice_address_to');
	var name_to_be_in_invoice='';
	
	if(address_to !='accounts'){
		if(address_to == 'main_acct_holder'){
			name_to_be_in_invoice =$(address_to).innerHTML;
		}else{
		    name_to_be_in_invoice =$(address_to).value;
		}
		var ins = document.getElementsByName('accounts_name');
	    var i;
	    for(i=0;i<ins.length;i++){
			ins[i].checked=false;
	    }
		if(name_to_be_in_invoice == ''){
			alert('Please enter a name for this option');
			e.src().checked = false;
			return false;
		}
	}
}

function SaveClientSendInvoiceSettingSetup(e){
	var leads_id = $('leads_id').value;
	var address_to = get_val('invoice_address_to');
	var name_to_be_in_invoice='';
	var default_email_field = get_val('default_email');
	var default_email='';
	var cc_emails = $('cc_emails').value;
	//
	var supervisor_staff_name = $('supervisor_staff_name').value;
	var secondary_contact_person = $('secondary_contact_person').value;
	var acct_dept_name1 = $('acct_dept_name1').value;
	var acct_dept_name2 = $('acct_dept_name2').value;
	
	var supervisor_email = $('supervisor_email').value;
	var sec_email = $('sec_email').value;
	var acct_dept_email1 = $('acct_dept_email1').value;
	var acct_dept_email2 = $('acct_dept_email2').value;
	
	//ASL settings
	var asl_default_email = get_val('asl_default_email');
	var asl_cc_emails = $('asl_cc_emails').value;
	// 
	
	
	if(!address_to){
		alert("Please select an option to be display in client invoice");
		return false;
	}
	
	if(!default_email_field){
		alert("Please select a default email");
		return false;
	}
	
	if(address_to == 'main_acct_holder'){
		name_to_be_in_invoice =$('main_acct_holder').innerHTML;
		
	}else if(address_to == 'supervisor_staff_name'){
		if($('supervisor_staff_name').value == ""){
		    alert('Please enter a name for the person directly working with staff ');
			return false;
		}
		name_to_be_in_invoice =$('supervisor_staff_name').value;
	}else if(address_to == 'secondary_contact_person'){
		if($('secondary_contact_person').value == ""){
		    alert('Please enter a name for secondary contact person.');
			return false;
		}
		name_to_be_in_invoice =$('secondary_contact_person').value;
	}else{
		var account_field_id = get_val('accounts_name');
		
		if(!account_field_id){
		    alert("Please choose an accounts department");
			return false;
		}
		
		if($(account_field_id).value == ""){
		    alert('Please enter a name for accounts department.');
		    return false;
		}
		address_to = account_field_id;
		name_to_be_in_invoice =$(account_field_id).value;
	}
	
	if(default_email_field == 'email'){
	    default_email = $('email').innerHTML;
	}else{
		default_email = $(default_email_field).value;
	}
	//log(default_email_field+" => " +default_email);
	//return false;
	
	var query = queryString({'address_to' : address_to , 'name_to_be_in_invoice' : name_to_be_in_invoice, 'default_email_field' : default_email_field , 'default_email' : default_email, 'supervisor_staff_name' : supervisor_staff_name, 'secondary_contact_person' : secondary_contact_person, 'acct_dept_name1' : acct_dept_name1, 'acct_dept_name2' : acct_dept_name2, 'supervisor_email' : supervisor_email, 'sec_email' : sec_email, 'acct_dept_email1' : acct_dept_email1, 'acct_dept_email2' : acct_dept_email2, 'leads_id' : leads_id , 'cc_emails' : cc_emails, 'asl_default_email' :  asl_default_email, 'asl_cc_emails' : asl_cc_emails  });
	//alert(query); return false;
	$('setup_btn').disabled=true;
	$('setup_btn').value='saving settings...';
	var result = doXHR(PATH + 'save_client_send_invoice_settings.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSaveClientSendInvoiceSettingSetup, OnFailSaveClientSendInvoiceSettingSetup);
}

function OnSuccessSaveClientSendInvoiceSettingSetup(e){
	$('setup_btn').disabled=false;
	$('setup_btn').value='Save';
	alert(e.responseText);
}
function OnFailSaveClientSendInvoiceSettingSetup(e){
	$('setup_btn').disabled=false;
	$('setup_btn').value='Save';
	alert("Failed to save settings");
}


function UpdateQuestionStatus(status, id){
	var query = queryString({'id' : id , 'status' : status  });
	//alert(query);
	var result = doXHR(PATH + 'UpdateQuestionStatus.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateQuestionStatus, OnFailUpdateQuestionStatus);
}

function OnSuccessUpdateQuestionStatus(e){
	if(e.responseText == 'ok'){
		opener.UpdateQuestionList();
	    self.close();
	}else{
		alert(e.responseText);
	}
}

function CloseViewQuestion(){
	opener.UpdateQuestionList();
	self.close();
}
function OnFailUpdateQuestionStatus(e){
	alert("Failed to update Booking Question status");
}
function UpdateQuestionList(){
	$('question_div').innerHTML='Loading...';
	var leads_id = $('leads_id').value;
	var booking_method = $('booking_method').value;
	var result = doSimpleXMLHttpRequest(PATH + 'UpdateQuestionList.php?leads_id=' + leads_id + '&booking_method='+ booking_method);
    result.addCallbacks(OnSuccessUpdateQuestionList, OnFailUpdateQuestionList);
}
function OnSuccessUpdateQuestionList(e){
	$('question_div').innerHTML=e.responseText;
}
function OnFailUpdateQuestionList(e){
	alert('Failed to update Booking Question List...');
}
function ActivateMemberAccount(){
	var leads_id = $('leads_id').value;
	var url = PATH +'admin_activate_member.php?leads_id='+leads_id;
	//if(leads_id){
	//	popup_win(PATH +'admin_activate_member.php?leads_id='+leads_id , 500 , 380);
	//}	
	window.open(url);
}

function updatemyarray(page) {
	location.href=page;
}
function GetLeadsCountryState(mode){
	var leads_country = $('leads_country').value;
	var leads_id = $('leads_id').value;
	var query = queryString({'leads_id' : leads_id , 'leads_country' : leads_country , 'mode' : mode });
	var result = doXHR(PATH + 'GetLeadsCountryState.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessGetLeadsCountryState, OnFailGetLeadsCountryState);
}

function OnSuccessGetLeadsCountryState(e){
	$('state_div').innerHTML = e.responseText;
}
function OnFailGetLeadsCountryState(e){
	alert("Failed to get the leads country state");
}

function DeleteAlternativeEmail(id){
	var leads_id = $('leads_id').value;
	var query = queryString({'leads_id' : leads_id , 'id' : id });
	var result = doXHR(PATH + 'DeleteAlternativeEmail.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessDeleteAlternativeEmail, OnFailDeleteAlternativeEmail);
}
function OnSuccessDeleteAlternativeEmail(e){
	if(e.responseText == 'delete'){
		alert("Successfully deleted");
		ShowLeadsAlternativeEmails();
	}else{
		alert("ERROR : \n"+e.responseText);
	}
}

function OnFailDeleteAlternativeEmail(e){
	alert("Failed to delete alternative email");
}
function ShowLeadsAlternativeEmails(){
	var leads_id = $('leads_id').value;
	var query = queryString({'leads_id' : leads_id });
	var result = doXHR(PATH + 'ShowLeadsAlternativeEmails.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowLeadsAlternativeEmails, OnFailShowLeadsAlternativeEmails);
}

function OnSuccessShowLeadsAlternativeEmails(e){
	$('alternative_emails_list').innerHTML =  e.responseText;
}
function OnFailShowLeadsAlternativeEmails(){
	alert("Failed to show leads alternative emails");
}
function AddAlternativeEmail(){
	var leads_id = $('leads_id').value;
	var alternative_email = $('alternative_email').value;
	
	if(!alternative_email){
		alert("Please enter an email address");
		return false;
	}
	
	var query = queryString({'leads_id' : leads_id  , 'alternative_email' : alternative_email });
	var result = doXHR(PATH + 'AddAlternativeEmail.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessAddAlternativeEmail, OnFailAddAlternativeEmail);
}
function OnSuccessAddAlternativeEmail(e){
	if(e.responseText == 'save'){
		alert("Successfully Added");
		toggle('alternative_email_form');
		ShowLeadsAlternativeEmails();
	}else{
		alert("ERROR : \n"+e.responseText);
	}
}

function OnFailAddAlternativeEmail(e){
	alert("Failed to add the alternative email");
}

function ShowAddAlternativeEmailsForm(){
	var result = doSimpleXMLHttpRequest(PATH + 'ShowAddAlternativeEmailsForm.php');
    result.addCallbacks(OnSuccessShowAddAlternativeEmailsForm, OnFailShowAddAlternativeEmailsForm);
}
function OnSuccessShowAddAlternativeEmailsForm(e){
	toggle('alternative_email_form');
	$('alternative_email_form').innerHTML =e.responseText;
}
function OnFailShowAddAlternativeEmailsForm(e){
	alert("Failed to show the form");
}

function Acknowledge(){
	var leads_new_info_id = $('leads_new_info_id').value;
	var leads_id = $('leads_id').value;
	var lead_status = $('lead_status').value;
	
	var query = queryString({'leads_id' : leads_id , 'leads_new_info_id' : leads_new_info_id });
	//alert(query);return false;
	var result = doXHR(PATH + 'Acknowledge.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessAcknowledge, OnFailAcknowledge);
	
	function OnSuccessAcknowledge(e){
		if(e.responseText == 'acknowledged'){
			//alert(e.responseText);
			alert('Successfully Acknowledged');
			location.href = "leads_information.php?id="+leads_id+"&lead_status="+lead_status;
		}else{
			alert("ERROR\n\n"+e.responseText);	
		}
	}
	function OnFailAcknowledge(e){
		alert("Failed to acknowledged");
	}
	
}

function Separate(){
	var leads_new_info_id = $('leads_new_info_id').value;
	var leads_id = $('leads_id').value;
	var leads_new_info_status = $('leads_new_info_status').value;
	var email = $('email').value;
	
	if(email == ""){
		alert("Please enter an email address");
		return false;
	}
	
	var query = queryString({'leads_id' : leads_id , 'leads_new_info_id' : leads_new_info_id , 'email' : email });
	//alert(query);return false;
	var result = doXHR(PATH + 'Separate.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSeparate, OnFailSeparate);
	
	function OnSuccessSeparate(e){
		//alert(e.responseText);
		
		if(isNaN(e.responseText)){
			alert("ERROR : \n\n"+e.responseText);
		}else{
			//alert(e.responseText);
			alert('Succesfully Separated');
			location.href = "leads_information.php?id="+e.responseText+"&lead_status="+leads_new_info_status;	
		}
		
	}
	
	function OnFailSeparate(e){
		alert("Failed to separate the lead");
	}
	
}
function Merge(){
	var leads_new_info_id = $('leads_new_info_id').value;
	var leads_id = $('leads_id').value;
	var lead_status = $('lead_status').value;
	$('merge_fields_'+leads_id).value = CheckLeadsInfo(leads_new_info_id);
	var merge_fields = $('merge_fields_'+leads_id).value;
	
	
	var query = queryString({'leads_id' : leads_id , 'leads_new_info_id' : leads_new_info_id , 'merge_fields' : merge_fields});
	//alert(query);return false;
	var result = doXHR(PATH + 'Merge.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessMerge, OnFailMerge);
	
	
	function OnSuccessMerge(e){
		if(e.responseText == 'merged'){
			//alert(e.responseText);
			alert('Succesfully Merged');
			location.href = "leads_information.php?id="+leads_id+"&lead_status="+lead_status;
		}else{
			alert("ERROR\n\n"+e.responseText);	
		}
	}
	function OnFailMerge(e){
		alert("Failed to Merge");
	}

}

function DeleteJobPosition(id){
	var leads_id = $('leads_id').value;
	var query = queryString({'id' : id , 'leads_id' : leads_id});
	var result = doXHR(PATH + 'DeleteJobPosition.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessDeleteJobPosition, OnFailDeleteJobPosition);
}

function OnSuccessDeleteJobPosition(e){
	ShowLeadInquiryPositions();
}

function OnFailDeleteJobPosition(e){
	alert("Failed to delete job position");
}
function ShowLeadInquiryPositions(){
	var leads_id = $('leads_id').value;
	var query = queryString({'leads_id' : leads_id});
	var result = doXHR(PATH + 'ShowLeadInquiryPositions.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowLeadInquiryPositions, OnFailShowLeadInquiryPositions);
}

function OnSuccessShowLeadInquiryPositions(e){
	$('job_positions').innerHTML = e.responseText;
}
function OnFailShowLeadInquiryPositions(e){
	alert("Failed to show leads inquiry");
}
function AddPosition(){
	var leads_id = $('leads_id').value;
	var category_ids = $('category_ids').value;
	if(!category_ids){
		alert("Please select Job Positions to add");
		return false;
	}
	var query = queryString({'leads_id' : leads_id , 'category_ids' : category_ids});
	var result = doXHR(PATH + 'AddPosition.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessAddPosition, OnFailAddPosition);
}

function OnSuccessAddPosition(e){
	toggle('add_position');
	$('job_positions').innerHTML = e.responseText;
	$('add_position_link').innerHTML = 'Add Position';
	ShowLeadInquiryPositions();
}

function OnFailAddPosition(e){
	alert("Failed to add job position");
}

function check_position()
{
	var ins = document.getElementsByName('category_ids')
	var i;
	var j=0;
	var vals = new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			vals[j]=ins[i].value;
			j++;
			
		}
	}
	$('category_ids').value=(vals);
	
}
function ShowPosition(){
	var link_str = $('add_position_link').innerHTML;
	if(link_str == 'Add Position'){
		$('add_position_link').innerHTML = 'Close Add Position';
	}else{
		$('add_position_link').innerHTML = 'Add Position';
	}
	var result = doSimpleXMLHttpRequest(PATH + 'ShowPosition.php');
    result.addCallbacks(OnSuccessShowPosition, OnFailShowPosition);
}

function OnSuccessShowPosition(e){
	toggle('add_position');
	$('add_position').innerHTML = e.responseText;
}

function OnFailShowPosition(e){
	alert("Failed to show job positions");
}
function SeparateLead(){
	
	var leads_id = $('leads_id').value;
	var lead_status = $('lead_status').value;
	
	if(confirm("This will separate this Lead.")) {
		var query = queryString({'leads_id' : leads_id , 'lead_status' : lead_status });
		var result = doXHR(PATH + 'SeparateLead.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
		result.addCallbacks(OnSuccessSeparateLead, OnFailSeparateLead);
	}
	
	function OnSuccessSeparateLead(e){
		if(e.responseText == 'separated'){
				//alert(e.responseText);
				alert('Succesfully Separated');
				location.href = "leads_information.php?id="+leads_id+"&lead_status="+lead_status;
		}else{
			alert("ERROR\n\n"+e.responseText);	
		}
	}
	function OnFailSeparateLead(e){
		alert("Failed to separate lead");
	}

}



function MergeLeadsInfo(){
	//alert(leads_id);
	var leads_id = $('leads_id').value;
	
	$('merge_fields_'+leads_id).value = CheckLeadsInfo(leads_id);
	var merge_fields = $('merge_fields_'+leads_id).value;
	var identical_id = GetIdenticalId();
	var lead_status = $('lead_status').value;
	
	var email_use = CheckEmailToMerge();
	if(!email_use){
		alert("Please choose an option on how to save the leads email.");
		return false;
	}
	//alert(email_use);return false;
	
	
	//if(merge_fields == ""){
	//	alert("Please select what information should be merge.");
	//	return false;
	//}
	if(identical_id == ""){
		alert("Please select to whom lead you want to merge.");
		return false;
	}
	
	var id = $('identical_leads_id_'+identical_id).value;
	var lead_status = $('identical_lead_status_'+identical_id).value;
	
	//alert(id+" \n" +lead_status);return false;
	
	
	if(confirm("This lead will be remove from the Leads list.")) {
		var query = queryString({'leads_id' : leads_id , 'merge_fields' : merge_fields , 'lead_status' : lead_status , 'identical_id' : identical_id , 'email_use' : email_use});
		//alert(query);return false;
		var result = doXHR(PATH + 'MergeLeadsInfo.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
		result.addCallbacks(OnSuccessMergeLeadsInfo, OnFailMergeLeadsInfo);
	}
	
	function OnSuccessMergeLeadsInfo(e){
			if(e.responseText == 'merged'){
				alert('Succesfully Merged');
				location.href = "leads_information.php?id="+id+"&lead_status="+lead_status;
			}else{
				alert("ERROR\n\n"+e.responseText);	
			}
	}
	
	function OnFailMergeLeadsInfo(e){
		alert("Failed to merge leads info");
	}
	
}
function CheckEmailToMerge(){
	var ins = document.getElementsByName('email_use')
	var i;
	var j=0;
	var val = "";
	for(i=0;i<ins.length;i++){
		
		if(ins[i].checked==true) {
			val=ins[i].value;
			break;
		}
	}
	return val;
}
function GetIdenticalId()
{
	var ins = document.getElementsByName('identical_id')
	var i;
	var j=0;
	var val = "";
	for(i=0;i<ins.length;i++){
		
		if(ins[i].checked==true) {
			val=ins[i].value;
			break;
		}
	}
	return val;
	
}
function CheckLeadsInfo(leads_id)
{
	var ins = document.getElementsByName('merge_'+leads_id)
	var i;
	var j=0;
	var vals = new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			vals[j]=ins[i].value;
			j++;
			
		}
	}
	//$('merge_fields_'+leads_id).value=(vals);
	return (vals);
	
}
function ShowIdentical(){
	//alert("Hello World");	
	toggle('identical');
	var xpos = screen.availWidth/2 - 500/2; 
	var ypos = screen.availHeight/2 - 200/2; 
	//$('comment_div').style.top = xpos+"px";
	$('identical').style.left = xpos+"px";
}

function ConfirmRemoved(){
	var leads_id = $('leads_id').value;
	var lead_status = $('lead_status').value;
	var query = queryString({'leads_id' : leads_id });
	var result = doXHR(PATH + 'ConfirmRemoved.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessConfirmRemoved, OnFailConfirmRemoved);

	function OnSuccessConfirmRemoved(e){
		var orders = e.responseText;
		//alert(orders);
		if(orders > 0){
			//location.href='leads_merge_order.php?id='+leads_id+"&lead_status="+lead_status;
			alert('Cannot be deleted. Lead has existing orders');
			
		}else{
			//NO ORDERS DETECTED JUST REMOVE IT
			alert('Deleted Successfully.');
			ChangeLeadStatus('REMOVED');	
		}
	}
	function OnFailConfirmRemoved(e){
		alert("Failed in confirming");
	}
}

function MergePerOrder(leads_transactions_id){
	var query = queryString({'leads_transactions_id' : leads_transactions_id });
	var result = doXHR(PATH + 'MergePerOrder.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessMergePerOrder, OnFailMergePerOrder);
}

function OnSuccessMergePerOrder(e){
	alert(e.responseText);
	document.form.submit();
}
function OnFailMergePerOrder(e){
	alert("Failed to merge");
}
function configureMode(mode){
	$('mode').value = mode;
	var leads_id = $('leads_id').value;
	var lead_status = $('lead_status').value;
	document.form.action ="leads_information2.php?id="+leads_id+"&lead_status="+lead_status+"#P";
}
function MergePerColumn(field_name){
	var column_value = "";
	var leads_id = $('leads_id').value;
	var leads_new_info_id = $('leads_new_info_id').value;
	
	if(field_name != 'leads_message') {
		column_value = $(field_name).value;
	}else{
		column_value = "leads_message";
	}
	/*
	if(column_value == "" ){
		alert('There is no value to be merged.');
		return false;
	}
	*/
	var query = queryString({'leads_id' : leads_id , 'leads_new_info_id' : leads_new_info_id , 'field_name' : field_name , 'column_value' : column_value });
	//alert(query)
	var result = doXHR(PATH + 'MergePerColumn.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessMergePerColumn, OnFailMergePerColumn);
	
	
	function OnSuccessMergePerColumn(e){
		alert(e.responseText);
		if(field_name != 'leads_message') {
			$(field_name+'_span').innerHTML = '<img src="images/icon-merge.gif" class="shadow" title="cannot be merge" />';
		}else{
			$(field_name+'_span').innerHTML = '<img src="images/icon-merge.gif" class="shadow" title="cannot be merge" />';
			$('leads_temp_message').innerHTML = "";
		}
		
	}
	function OnFailMergePerColumn(e){
		alert("Failed to merge");
	}

}

function checkAddUpdateForm(){
	/*
	//var email = $('email').value;
	var fname = $('fname').value;
	var lname = $('lname').value;
	
	//emailReg = "^[\\w-_\.]*[\\w-_\.]\@[\\w]\.+[\\w]+[a-zA-Z]$"
	//var regex = new RegExp(emailReg);
	
	if(fname == ""){
		alert("First name is a required field");
		return false;
	}
	
	if(lname == ""){
		alert("Last name is a required field");
		return false;
	}
	
	
	
	//if(regex(email) == false){
	//	alert('Please enter a valid email address and try again!');
	//	return false;
	//}	
	
	*/
	return true;
}
function UpdateHistory(id){
	if(id == "" || id == null){
		alert("ID is missing");
		return false;
	}
	
	var message = $('content').value;
	if(message == "" || message == " " || message == null ){
		alert("There is no message to be updated");
		return false;
	}
	//var query = queryString({'id' : id , 'message' : message });
	//var result = doXHR(PATH + 'UpdateHistory.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	//result.addCallbacks(OnSuccessEditHistory, OnFailEditHistory);
	
}
var result = "";
function EditHistory(id , mode){
	if(id == "" || id == null){
		alert("ID is missing");
		return false;
	}
	toggle('history_edit_div');
	//$('history_edit_div_'+id).style.display='block';
	$('history_edit_div').innerHTML = "<img src='images/loading.gif'/>";
	//$('history_edit_div').innerHTML = id;
	var result = "";
	var query = queryString({'id' : id , 'mode' :mode });
	result = doXHR(PATH + 'EditHistory.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessEditHistory, OnFailEditHistory);

}
function OnSuccessEditHistory(e){
	$('history_edit_div').innerHTML = e.responseText;	
	//tinyMCE.execCommand("mceAddControl", true, 'content');
	//alert("hello world");
}
function OnFailEditHistory(e){
	alert("Failed to show edit form");
}


function ShowAddComments2(id){
	if(id == "" || id == null){
		alert("ID is missing");
		return false;
	}
	$('comment_div2').style.display='block';
	$('comment_div2').innerHTML = "<img src='images/loading.gif'/> Loading comments...";
	
	var xpos = screen.availWidth/2 - 500/2; 
	var ypos = screen.availHeight/2 - 200/2; 
	//$('comment_div').style.top = xpos+"px";
	$('comment_div2').style.left = ypos+"px";
	
	
	var query = queryString({'id' : id });
	var result = doXHR(PATH + 'ShowAddComments2.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowAddComments2, OnFailShowAddComments2);
	
}

function OnSuccessShowAddComments2(e){
	$('comment_div2').innerHTML = e.responseText;
}

function OnFailShowAddComments2(e){
	alert("Failed to show comments");
	$('comment_div2').innerHTML = "Failed to show comments";
}

function AddComment2(id){
	if(id == "" || id == null){
		alert("ID is missing");
		return false;
	}
	var message = $('message2').value;
	
	if(message == "" || message == null){
		alert("There is no message to be added");
		return false;
	}
	
	var query = queryString({'id' : id , 'message' : message});
	//alert(query);
	var result = doXHR(PATH + 'AddComment2.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessAddComment2, OnFailAddComment2);
	
	function OnSuccessAddComment2(e){
		alert(e.responseText);
		//ShowAddComments2(id);
		ShowNewComment2(id);
	}
	function OnFailAddComment2(e){
		alert("Failed to add comment");
	}
}


function ShowNewComment2(id){
	if(id == "" || id == null){
		alert("ID is missing");
		return false;
	}
	$('sent_note_'+id).innerHTML = "<img src='images/loading.gif'/>";
	var query = queryString({'id' : id });
	//alert(query);
	var result = doXHR(PATH + 'ShowNewComment2.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowNewComment2, OnFailShowNewComment2);
	
	function OnSuccessShowNewComment2(e){
		//alert(e.responseText);
		$('sent_note_'+id).innerHTML = e.responseText;
	}
	function OnFailShowNewComment2(e){
		alert("Failed to refresh");
	}
}




function ShowNewComment(invoice_id){
	if(invoice_id == "" || invoice_id == null){
		alert("Invoice ID is missing");
		return false;
	}
	$('note_'+invoice_id).innerHTML = "<img src='images/loading.gif'/>";
	var query = queryString({'invoice_id' : invoice_id });
	var result = doXHR(PATH + 'ShowNewComment.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowNewComment, OnFailShowNewComment);
	
	function OnSuccessShowNewComment(e){
		$('note_'+invoice_id).innerHTML = e.responseText;
	}
	function OnFailShowNewComment(e){
		alert("Failed to refresh");
	}
}
function AddComment(invoice_id){
	if(invoice_id == "" || invoice_id == null){
		alert("Invoice ID is missing");
		return false;
	}
	var message = $('message').value;
	
	if(message == "" || message == null){
		alert("There is no message to be added");
		return false;
	}
	
	var query = queryString({'invoice_id' : invoice_id , 'message' : message});
	//alert(query);
	var result = doXHR(PATH + 'AddComment.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessAddComment, OnFailAddComment);
	
	function OnSuccessAddComment(e){
		alert(e.responseText);
		ShowAddComments(invoice_id);
		ShowNewComment(invoice_id);
	}
	function OnFailAddComment(e){
		alert("Failed to add comment");
	}
}
function ShowAddComments(invoice_id){
	if(invoice_id == "" || invoice_id == null){
		alert("Invoice ID is missing");
		return false;
	}
	$('comment_div').innerHTML = "<img src='images/loading.gif'/> Loading comments of invoice id "+invoice_id;
	$('comment_div').style.display='block';
	
	
	var xpos = screen.availWidth/2 - 500/2; 
	var ypos = screen.availHeight/2 - 200/2; 
	//$('comment_div').style.top = xpos+"px";
	$('comment_div').style.left = ypos+"px";

	
	var query = queryString({'invoice_id' : invoice_id });
	var result = doXHR(PATH + 'ShowAddComments.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowAddComments, OnFailShowAddComments);
	
}

function OnSuccessShowAddComments(e){
	$('comment_div').innerHTML = e.responseText;
}

function OnFailShowAddComments(e){
	alert("Failed to show comments");
	$('comment_div').innerHTML = "Failed to show comments";
}



function checkMessage(){
	//var message = $('message').value;
	//if(message == ""){
	//	alert("Please enter a message to be sent");
	//	return false;
	//}
}
function checkEmailMessage(){
	var email = $('email').value;
	var cc = $('cc').value;
	var bcc = $('bcc').value;
	var subject = $('subject').value;
	
	if(subject == "" || subject ==" "){
		alert("Hi ! You've forgotten the subject line. Please key in subject line then press send..");
		return false;
	}
	
	var query = queryString({'email' : email, 'cc' : cc, 'bcc' : bcc });
	//alert(query);
	//return false;
	
	var result = doXHR(PATH + 'validate_emails.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessValidateEmails, OnFailValidateEmails);	
	
	
}
function OnSuccessValidateEmails(e){
    if(e.responseText == 'ok'){
	    $('send_save').value = "1";
	    document.form.submit();
	}else{
		alert(e.responseText);
	}
}
function OnFailValidateEmails(e){
    alert("Failed to validate emails");
	//return false;
}




var result = "";
function showHideActions(actions){
	var leads_id = $('leads_id').value;	
	$('action_record').innerHTML = "<img src='images/loading.gif'/>";
	
	var query = queryString({'leads_id' : leads_id , 'actions' : actions });
	//alert(query);
	var result = "";
	result = doXHR(PATH + 'ShowHideActions.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowHideActions, OnFailShowHideActions);
	
	
	function OnSuccessShowHideActions(e){
		$('action_record').innerHTML = e.responseText;
		if(actions=='Feedback') {
			console.log('feedback!!!');
			(function($) {
				//$.noConflict();
				$('#linkdiv').append( $('<div/>').attr({'id':'linkattachticket'})
									  .addClass('attach_ticket')
									  .jqm({ajax: '@href', trigger: 'a#attach1'}) );
				
				$('#emaildiv').append( $('<div/>').attr({'id':'emailattachticket'})
									  .addClass('attach_ticket')
									  .jqm({ajax: '@href', trigger: 'a#attach2'}) );
				$('button#confirmfeedback').click(function(e) {
					var genfback = $("input[name=genfback]:checked").val();
					//console.log(genfback +':'+'#'+genfback+'divtid'+' - '+ $('#'+genfback+'divtid').text());
					if(genfback != undefined) {
						var tid = $('#'+genfback+'divtid').text();
						if(tid != '') {
							var leads_id = $('input#leads_id').val();
							var leads_email = $('input[name=leads_email]').val();
							var leads_name = $('input[name=leads_name]').val();
							if(genfback == 'link') {
								$('#linkdiv').append( $('<div/>').attr({'id':'linkgenerate'})
									  //.addClass('generate_link').css('display','block')
									  .jqm({ajax: '/portal/client_feedback/?/create_feedback/link/&leads_id='+leads_id+'&email='+leads_email+'&ticket_id='+tid.split('#')[1], overlay:0, modal: false, trigger: false}).jqmShow() );
									  //.jqm({ajax: '@href', trigger: 'a#attach1'}) );
							} else {
								$('#linkdiv').append( $('<div/>').attr({'id':'linkgenerate'})
									  .addClass('attach_to_email').css('display','block')
									  .jqm({ajax: '/portal/client_feedback/?/create_feedback/email/&leads_id='+leads_id+'&email='+leads_email+'&name='+encodeURIComponent(leads_name)+'&ticket_id='+tid.split('#')[1], overlay: 50, modal: true, trigger: false}).jqmShow() );
							}
						} else {
							alert("Please attach ticket id");
						}
					} else {
						alert("Select option on how you want to create the form");
					}
					e.preventDefault();
				});
			})(jQuery);
			$.noConflict();
			
		}
	}
	
	function OnFailShowHideActions(e){
		alert("Failed to show action form");
	}
}




function ChangeLeadsRating(){
	var leads_id = $('leads_id').value;
	var rating = $('star').value;
	
	var query = queryString({'leads_id' : leads_id , 'rating' : rating });
	//alert(query);
	$('ratings').innerHTML = "<img src='images/loading.gif' width=17 height=17/>";
	var result = doXHR(PATH + 'ChangeLeadsRating.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessChangeLeadsRating, OnFailChangeLeadsRating);
	
}
function OnSuccessChangeLeadsRating(e){
	$('ratings').innerHTML = e.responseText;
}

function OnFailChangeLeadsRating(e){
	$('ratings').innerHTML = "Failed to rate this lead";
}


function ChangeLeadStatus(status){
	var leads_id = $('leads_id').value;
	
	if(status == ""){
		alert("Status is Missing. Please contact Development Team");
		return false;
	}
	
	if(leads_id == ""){
		alert("Leads ID is missing");
		return false;
	}
	//if(status == 'Client'){
	//	alert("Please contact Admin to make this Lead a certified Client");
	//	return false;
	//}
	location.href = PATH + "ChangeLeadStatus.php?id="+leads_id+"&lead_status="+status;
	
}

function leadsNavigation(direction){
	var lead_status = $('lead_status').value;
	
	//alert(lead_status);
	var selObj = document.getElementById("leads");
	current_index = selObj.selectedIndex;
	
	if(direction!="direct"){
		if(direction == "back"){
			if(current_index >0){
				current_index = current_index-1;
			}else{
				current_index =0 ;
			}	
		}
		if(direction == "forward"){
			current_index = current_index+1;
		}
		value = selObj.options[current_index].value;
	}else{
		value = selObj.value;
	}
	location.href = "leads_information.php?id="+value+"&lead_status="+lead_status;
	
}

function selectLeads(value){
	var lead_status = $('lead_status').value;
	location.href = "leads_information.php?id="+value+"&lead_status="+lead_status;
}


function getValue(element_name){

	//element_name : quote_id , service_agreement_id , setup_fee_id setup_fee
	//alert(element_name);
	if(element_name == "quote_id") {
		var ins = document.getElementsByName(element_name);
		var i;
		var j=0;
		var vals = new Array();
		for(i=0;i<ins.length;i++)
		{
			if(ins[i].checked==true) {
				vals[j]=ins[i].value;
				j++;
				//vals="with";
			}
		}
			$('quote').value=(vals);
	}
	if(element_name == "service_agreement_id") {
		var ins = document.getElementsByName(element_name);
		var i;
		var j=0;
		var vals= new Array();
		for(i=0;i<ins.length;i++)
		{
			if(ins[i].checked==true) {
				vals[j]=ins[i].value;
				j++;
				//vals="with";
			}
		}
			$('service_agreement').value=(vals);
	}
	if(element_name == "setup_fee_id") {
		var ins = document.getElementsByName(element_name);
		var i;
		var j=0;
		var vals= new Array();
		for(i=0;i<ins.length;i++)
		{
			if(ins[i].checked==true) {
				vals[j]=ins[i].value;
				j++;
				//vals="with";
			}
		}
			$('setup_fee').value=(vals);
	}
	
}

function check_val()
{
	var ins = document.getElementsByName('recruitment_job_order_form')
	var i;
	var j=0;
	var vals="without"; //= new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			//vals[j]=ins[i].value;
			//j++;
			vals="with";
		}
	}
	$('job_order').value=(vals);
}


jQuery(document).ready(function(){
	jQuery("#template_selector").live("change", function(e){
		var id = jQuery("#leads_id").val();
		if (jQuery(this).val()=="blank"){
			jQuery("#message").val("").removeAttr("readonly");
			jQuery("#subject").val("").removeAttr("readonly");
			
		}else if (jQuery(this).val()=="dst_start"){
			jQuery.get("/portal/leads_dst_start.php?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("Daylight Saving Time").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="dst_end"){
			jQuery.get("/portal/leads_dst_update.php?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("End of Daylight Saving Time on April 2, 2017").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="anzac"){
			jQuery.get("/portal/email_templates/au_anzac_day/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("Anzac Day Staff Attendance").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="queens"){
			jQuery.get("/portal/email_templates/au_queens_day/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("Queen's Birthday Staff Attendance").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="us_labor_day"){
			jQuery.get("/portal/email_templates/us_labor_day/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("US Labor Day Staff Attendance").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="columbus_day"){
			jQuery.get("/portal/email_templates/columbus_day/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("Columbus Day").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="au_labour_day"){
			jQuery.get("/portal/email_templates/au_labour_day/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("Labour Day").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="us_veterans_day"){
			jQuery.get("/portal/email_templates/us_veterans_day/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("US Veterans Day").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="au_melbourne_cup_day"){
			jQuery.get("/portal/email_templates/au_melbourne_cup_day/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("AU Melbourne Cup Day").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="us_thanks_giving"){
			jQuery.get("/portal/email_templates/us_thanks_giving/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("US Thanks Giving").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="au_christmas_day"){
			jQuery.get("/portal/email_templates/au_christmas_day/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("Happy Holidays").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="us_christmas_day"){
			jQuery.get("/portal/email_templates/us_christmas_day/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("Christmas Day").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="uk_christmas_day"){
			jQuery.get("/portal/email_templates/uk_christmas_day/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("Christmas Day").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="us_new_year"){
			jQuery.get("/portal/email_templates/au_new_year/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("New Year's Eve").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="uk_new_year"){
			jQuery.get("/portal/email_templates/uk_new_year/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("New Year's Eve").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="au_australia_day"){
			jQuery.get("/portal/email_templates/au_australia_day/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("Australia Day 2017").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="christmas_day_2014"){
			jQuery.get("/portal/email_templates/christmas_day_2014/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("Remote Staff Service Agreement Update").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="au_dst_start_update_2014"){
			jQuery.get("/portal/email_templates/au_dst_start_update_2014/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("Australian Daylight Saving Time Adjustment").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="ukus_christmas_day_2014"){
			jQuery.get("/portal/email_templates/ukus_christmas_day_2014/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("Remote Staff Service Agreement Update").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="au_melbourne_cup_day_2014"){
			jQuery.get("/portal/email_templates/au_melbourne_cup_day_2014/", function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("AU Melbourne Cup Day").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="us_veterans_day_2014"){
			jQuery.get("/portal/email_templates/us_veterans_day_2014/", function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("US Veterans Day").attr("readonly","true");
			});
		}else if (jQuery(this).val()=="au_holy_week_2016"){
			jQuery.get("/portal/email_templates/au_holy_week_2016/?id="+id, function(response){
				jQuery("#message").val(response).attr("readonly","true");
				jQuery("#subject").val("Australia Holy Week").attr("readonly","true");
			});
		}
		
	}); 
	
	jQuery(".unreject-endorsement").live("click", function(e){
		var ans = confirm("Do you want to revert the rejection of this endorsement?");
		if (ans){
			var id = jQuery(this).attr("data-id");
			var me = jQuery(this);
			jQuery.get("/portal/endorsement/unreject_endorsement.php?id="+id, function(response){
				response = jQuery.parseJSON(response);
				if (response.success){
					alert("Endorsement's rejection has been successfully reverted");
					me.parent().parent().css("background-color", "#fff").css("color:#000");
					me.addClass("reject-endorsement").removeClass("unreject-endorsement").text("Reject");
				}else{
					alert(response.error);
				}
			});
		}
		e.preventDefault();
		e.stopPropagation();
		return false;
	});
	
	jQuery(".reject-endorsement").live("click", function(e){
		var id = jQuery(this).attr("data-id");
		var me = jQuery(this);
		jQuery.get("/portal/endorsement/get_endorsement_details.php?id="+id, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				jQuery("#endorsement_id").val(response.endorsement.id);
				jQuery("#feedback_client_name").text(response.endorsement.client);
				jQuery("#feedback_staff_name").text(response.endorsement.staff_name);
				
				jQuery( "#add-feedback-dialog" ).dialog(
				{height: 350,
				width:590,
				modal: true,
				title:'Add feedback for Endorsement Rejection',
				buttons: {
			        "Save Feedback": function() {
			        	var data = jQuery(".add_feedback_form").serialize();
						jQuery.post("/portal/endorsement/reject_endorsement.php",data, function(response){
							response = jQuery.parseJSON(response);
							if (response.success){
								alert("Endorsement has been successfully rejected.");
								
								
								me.parent().parent().css("background-color", "#ff0000").css("color:#fff");
								me.removeClass("reject-endorsement").addClass("unreject-endorsement").text("Unreject");
								jQuery(  "#add-feedback-dialog"  ).dialog( "close" );
								window.location.reload();
							}else{
								alert(response.error);
							}
						})
						
			        },
			        Cancel: function() {
			          jQuery(  "#add-feedback-dialog"  ).dialog( "close" );
			        }
			      }
				});
			}else{
				alert(response.error);
			}
		});
		e.preventDefault();
		e.stopPropagation();
		return false;
	});
});

jQuery(".view_hm_notes").live("click", function(e){
	var tracking_code = jQuery('#leads_tracking_code').val();
	if(tracking_code != ''){
		jQuery("#ui-datepicker-div").css("display", "none");
		jQuery("#details-dialog").html("");
		jQuery("#dialog:ui-dialog").dialog( "destroy" );
		jQuery("#details-dialog").dialog({
			height: 430,
			width:840,
			modal: true,
			title:"View HM Notes"
		});
		jQuery.get('/portal/recruiter/load_comments.php?tracking_code='+tracking_code, function(data){
			jQuery("#details-dialog").html(data);
		});
	} else {
		alert( 'Please select tracking code!' );
		jQuery('#leads_tracking_code').focus();
	}
	e.preventDefault();
});

jQuery(".add_new_comment").live("submit", function(e){
	var data = jQuery(this).serialize();
	jQuery.post("/portal/recruiter/add_new_jo_comments.php", data, function(response){
		response = jQuery.parseJSON(response);
		if (response.success){
			var comment = response.comment;
			var template = '<li style="border-bottom:1px dotted #312E27;width:431px;word-wrap:break-word">';
			template += '<strong>By: </strong>'+comment.admin_fname+' '+comment.admin_lname+'<br/>';
			template += '<strong>Date Created: </strong>'+comment.date_created+'<br/>';
			template += '<strong>Subject:</strong>'+comment.subject+'<br/>';
			template += '<strong>Note:</strong><p style="margin-top:0">'+comment.comment+'</p></li>'; 
			jQuery(template).appendTo(jQuery(".notes_list ul"));
			jQuery("input[name=subject]").val("");
			jQuery("textarea[name=comment]").val("");
			jQuery.get('/portal/leads_information/update_job_order_notes.php?leads_id='+jQuery('#leads_id').val(), function(data){
				jQuery('#job_order_notes_container').html(data);
			});
		}else{
			alert(response.error);
		}
	});
	return false;
});
