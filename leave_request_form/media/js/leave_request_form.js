// JavaScript Document
var PATH = '/portal/leave_request_form/';

//connect(window, "onload", ShowStaffList);

function UpdateStaffList(year , month , day){
	var query = queryString({'year' : year , 'month' : month , 'day' : day , 'search' : 'TRUE' });
	var result = doXHR(PATH + 'ShowStaffList.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowStaffList, OnFailShowStaffList);
}

function MarkedAbsent(){
		
	var leads = $('leads').value;
	var leave_type = $('leave_type').value;
	
	var start_date_of_leave = $('start_date_of_leave').value;
	var end_date_of_leave = $('end_date_of_leave').value;
	
	var leave_duration = $('leave_duration').value;
	var reason_for_leave = $('reason_for_leave').value;
	var userid = $('userid').value;
	
	if(!userid){
		alert("Please choose a staff");
		return false;
	}
	
	if(!leads){
		alert("Please choose a client");
		return false;
	}
	
	if(!start_date_of_leave){
		alert("Please select a date.");
		return false;
	}
	
	if(!reason_for_leave){
		alert("Please give a reason why you want to mark absent this staff");
		return false;
	}
	if(end_date_of_leave){
		if(end_date_of_leave < start_date_of_leave){
			alert("Invalid end date of leave");
			$('end_date_of_leave').value = "";
			return false;
		}
	}
	
	$('submit_btn').disabled = true;
	var query = queryString({'leads' : leads , 'leave_type' : leave_type , 'reason_for_leave' : reason_for_leave , 'start_date_of_leave' : start_date_of_leave , 'end_date_of_leave': end_date_of_leave , 'leave_duration' : leave_duration , 'userid' : userid });
	//alert(query);return false;
	var result = doXHR(PATH + 'MarkedAbsent.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessMarkedAbsent, OnFailMarkedAbsent);
	
}
function OnSuccessMarkedAbsent(e){
	//alert(e.responseText);
	$('right_panel').innerHTML = e.responseText;
	ShowStaffList();
	
}

function OnFailMarkedAbsent(e){
	alert("Failed to marked absent the staff.");
}

function ApproveDenyCancelAllRequest(mode){
	var leave_request_id = $('leave_request_id').value;
	var notes = $('notes').value;
	var user_type = $('user_type').value;
	
	if(user_type == 'personal'){
		$('cancel_btn').disabled = true;
		$('cancel_all_btn').disabled = true;
	}else{
		$('approve_btn').disabled = true;
		$('approve_all_btn').disabled = true;
		$('deny_btn').disabled = true;
		$('deny_all_btn').disabled = true;
	}
	var query = queryString({'leave_request_id' : leave_request_id , 'notes' : notes , 'mode' : mode });
	//alert(query);return false;
	var result = doXHR(PATH + 'ApproveDenyCancelAllRequest.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessCancelAllRequest, OnFailCancelAllRequest);
	
	function OnSuccessCancelAllRequest(e){
		if(isNaN(e.responseText)){
			alert(e.responseText);
			if(user_type == 'personal'){
				$('cancel_btn').disabled = false;
				$('cancel_all_btn').disabled = false;
			}else{
				$('approve_btn').disabled = false;
				$('approve_all_btn').disabled = false;
				$('deny_btn').disabled = false;
				$('deny_all_btn').disabled = false;
			}
		}else{
			ShowStaffCalendar(e.responseText)
			if(user_type == 'personal'){
				ShowStaffRequestedLeaveToClient();
			}else{
				ShowStaffList()
			}
		}
	}
	function OnFailCancelAllRequest(e){
		alert("Failed to cancel all request");
	}
}
function ApproveDenyCancelRequest(mode){
	var date = $('date').value; 
	var leave_request_id = $('leave_request_id').value;
	var notes = $('notes').value;
	var user_type = $('user_type').value;
	var mode_str ="";
	if(mode == 'approved'){
		mode_str = 'approve';
	}
	
	if(mode == 'cancelled'){
		mode_str = 'cancel';
	}
	
	if(mode == 'denied'){
		mode_str = 'deny';
	}
	
	if(!date){
		alert("Please select a date to "+mode_str);
		return false;
	}
	
	if(user_type == 'personal'){
		$('cancel_btn').disabled = true;
		$('cancel_all_btn').disabled = true;
	}else{
		$('approve_btn').disabled = true;
		$('approve_all_btn').disabled = true;
		$('deny_btn').disabled = true;
		$('deny_all_btn').disabled = true;
	}
	//return false;
	var query = queryString({ 'date' : date , 'leave_request_id' : leave_request_id , 'notes' : notes , 'mode' : mode});
	var result = doXHR(PATH + 'ApproveDenyCancelRequest.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessCancelRequest, OnFailCancelRequest);
	
	function OnSuccessCancelRequest(e){
		if(isNaN(e.responseText)){
			alert(e.responseText);
			if(user_type == 'personal'){
				$('cancel_btn').disabled = false;
				$('cancel_all_btn').disabled = false;
			}else{
				$('approve_btn').disabled = false;
				$('approve_all_btn').disabled = false;
				$('deny_btn').disabled = false;
				$('deny_all_btn').disabled = false;
			}
		}else{
			ShowStaffCalendar(e.responseText)
			if(user_type == 'personal'){
				ShowStaffRequestedLeaveToClient();
			}else{
				ShowStaffList()
			}
		}
		
	}
	function OnFailCancelRequest(e){
		alert("Failed to "+modde+" request");
		if(user_type == 'personal'){
			$('cancel_btn').disabled = false;
			$('cancel_all_btn').disabled = false;
		}else{
			$('approve_btn').disabled = false;
			$('approve_all_btn').disabled = false;
			$('deny_btn').disabled = false;
			$('deny_all_btn').disabled = false;
		}
	}
}


function GetDateId()
{
	var ins = document.getElementsByName('dates')
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
	$('date').value=(vals);
	
}


function SubmitRequest(){
	
	CheckInputDate('start_date_of_leave');
	CheckInputDate('end_date_of_leave');
	
	var leads = $('leads').value;
	var leave_type = $('leave_type').value;
	
	var start_date_of_leave = $('start_date_of_leave').value;
	var end_date_of_leave = $('end_date_of_leave').value;
	
	var leave_duration = $('leave_duration').value;
	var reason_for_leave = $('reason_for_leave').value;
	
	
	if(!leads){
		alert("Please choose a client");
		return false;
	}
	
	if(!start_date_of_leave){
		alert("Please select a date at least 7 days prior to leave date");
		return false;
	}
	
	if(!reason_for_leave){
		alert("Please give a reason why you want to take a leave");
		return false;
	}
	if(end_date_of_leave){
		if(end_date_of_leave < start_date_of_leave){
			alert("Invalid end date of leave");
			$('end_date_of_leave').value = "";
			return false;
		}
	}
	
	$('submit_btn').disabled = true;
	var query = queryString({'leads' : leads , 'leave_type' : leave_type , 'reason_for_leave' : reason_for_leave , 'start_date_of_leave' : start_date_of_leave , 'end_date_of_leave': end_date_of_leave , 'leave_duration' : leave_duration  });
	//alert(query);return false;
	var result = doXHR(PATH + 'SubmitRequest.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSubmitRequest, OnFailSubmitRequest);
	
	
}
function OnSuccessSubmitRequest(e){
	alert(e.responseText);
	ShowStaffRequestedLeaveToClient();
	ShowStaffAllRequestedLeave();
}

function OnFailSubmitRequest(e){
	alert("Failed to submit request for leave");
	$('submit_btn').disabled = false;
}



function suggest(){
	var inputString = $('inquiring_about').value;
	var query = queryString({'inputString' : inputString });	
	var result = doXHR(PATH + 'ShowStaff.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowStaff, OnFailShowStaff);
}

function OnSuccessShowStaff(e){
	appear('suggestions');
	$('suggestionsList').innerHTML = e.responseText;
}

function OnFailShowStaff(e){
	$('suggestionsList').innerHTML = e.responseText;
	fade('suggestions');
}

function fill(thisValue) {
	$('inquiring_about').value = thisValue;
	//toggle('suggestions');
	setTimeout(hideSuggestions, 1000);
	//$('#inquiring_about').removeClass('load');
}

function hideSuggestions(){
	fade('suggestions');
}


function FillID(userid){
	$('userid').value = userid;
	ShowStaffAllRequestedLeave();
}


function ShowStaffAllRequestedLeave(){
	$('right_panel').innerHTML = "Loading calendar...";
	var userid = $('userid').value;
	var query = queryString({'userid' : userid });	
	var result = doXHR(PATH + 'ShowStaffAllRequestedLeave.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
    result.addCallbacks(OnSuccessShowStaffAllRequestedLeave, OnFailShowStaffAllRequestedLeave);
}

function OnSuccessShowStaffAllRequestedLeave(e){
	$('right_panel').innerHTML = e.responseText;
}

function OnFailShowStaffAllRequestedLeave(e){
	alert("Failed to show calendar");
}

function CheckLeaveRequest(){
	var leads = $('leads').value;
	var leave_type = $('leave_type').value;
	var date_of_leave = $('date_of_leave').value;
	var reason_for_leave = $('reason_for_leave').value;
	
	
	if(!leads){
		alert("Please choose a client");
		return false;
	}
	
	if(!date_of_leave){
		alert("Please select a date at least 2 days prior to leave date");
		return false;
	}
	
	if(!reason_for_leave){
		alert("Please give a reason why you want to take a leave");
		return false;
	}
	
}

function check_val()
{
	var ins = document.getElementsByName('lead')
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
	$('leads').value=(vals);
	
}

function CheckInputDate(element_id){
	if(!element_id) element_id = 'start_date_of_leave';
	var date_of_leave = $(element_id).value;
	
	
	//get the current date
	var currentTime = new Date();
	currentTime.setDate(currentTime.getDate())
	var month = currentTime.getMonth() + 1;
	var day = currentTime.getDate();
	var year = currentTime.getFullYear();
	//alert(month + "-" + day + "-" + year);
	//return false;
	if(month < 10) month = "0"+month;
	if(day < 10) day = "0"+day;
	
	var current_date = year + "-" + month + "-" + day;
	//alert(date_of_leave+"\n"+current_date);	
	if(date_of_leave) {
		if(date_of_leave < current_date){
			alert("Invalid Date selection.");
			if(element_id == 'start_date_of_leave'){
				$(element_id).value = "";
				$('end_date_of_leave').value="";
			}else{
				$(element_id).value = "";
			}
			return false;
		}
	}
	
}

function ShowAddLeaveForm(year , month , day){
	
	var userid = $('userid').value;
	var query = queryString({'userid' : userid , 'year' : year , 'month' : month , 'day' : day});	
	$('right_panel').style.display = 'block';
	$('right_panel').innerHTML = "Loading...";
	//alert(query);
	var result = doXHR(PATH + 'ShowAddLeaveForm.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowAddLeaveForm, OnFailShowAddLeaveForm);
}

function OnSuccessShowAddLeaveForm(e){
	$('right_panel').innerHTML = e.responseText;
	Calendar.setup({
  		inputField     :    "start_date_of_leave",     // id of the input field
		ifFormat       :    "%Y-%m-%d",      // format of the input field
		button         :    "bd",          // trigger for the calendar (button ID)
		align          :    "Tl",           // alignment (defaults to "Bl")
		showsTime	   :    false, 
		singleClick    :    true
	});
	
	Calendar.setup({
  		inputField     :    "start_date_of_leave",     // id of the input field
		ifFormat       :    "%Y-%m-%d",      // format of the input field
		button         :    "start_date_of_leave",          // trigger for the calendar (button ID)
		align          :    "Tl",           // alignment (defaults to "Bl")
		showsTime	   :    false, 
		singleClick    :    true
	});
	
	Calendar.setup({
  		inputField     :    "end_date_of_leave",     // id of the input field
		ifFormat       :    "%Y-%m-%d",      // format of the input field
		button         :    "bd2",          // trigger for the calendar (button ID)
		align          :    "Tl",           // alignment (defaults to "Bl")
		showsTime	   :    false, 
		singleClick    :    true
	});
	
	Calendar.setup({
  		inputField     :    "end_date_of_leave",     // id of the input field
		ifFormat       :    "%Y-%m-%d",      // format of the input field
		button         :    "end_date_of_leave",          // trigger for the calendar (button ID)
		align          :    "Tl",           // alignment (defaults to "Bl")
		showsTime	   :    false, 
		singleClick    :    true
	});
	check_val();
	$('submit_btn').disabled = false;
	
}

function OnFailShowAddLeaveForm(e){
	alert("Failed to show form");
}

function RequestLeave(year , month , day){
	var leads_id = $('leads_id').value;
	//alert(leads_id);

	var query = queryString({'leads_id' : leads_id , 'year' : year , 'month' : month , 'day' : day});	
	$('right_panel').style.display = 'block';
	$('right_panel').innerHTML = "Loading...";
	//alert(query);
	
	
	var result = doXHR(PATH + 'RequestLeave.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessRequestLeave, OnFailRequestLeave);
}

function OnSuccessRequestLeave(e){
	$('right_panel').innerHTML = e.responseText;
	Calendar.setup({
  		inputField     :    "start_date_of_leave",     // id of the input field
		ifFormat       :    "%Y-%m-%d",      // format of the input field
		button         :    "bd",          // trigger for the calendar (button ID)
		align          :    "Tl",           // alignment (defaults to "Bl")
		showsTime	   :    false, 
		singleClick    :    true
	});
	
	Calendar.setup({
  		inputField     :    "start_date_of_leave",     // id of the input field
		ifFormat       :    "%Y-%m-%d",      // format of the input field
		button         :    "start_date_of_leave",          // trigger for the calendar (button ID)
		align          :    "Tl",           // alignment (defaults to "Bl")
		showsTime	   :    false, 
		singleClick    :    true
	});
	
	Calendar.setup({
  		inputField     :    "end_date_of_leave",     // id of the input field
		ifFormat       :    "%Y-%m-%d",      // format of the input field
		button         :    "bd2",          // trigger for the calendar (button ID)
		align          :    "Tl",           // alignment (defaults to "Bl")
		showsTime	   :    false, 
		singleClick    :    true
	});
	
	Calendar.setup({
  		inputField     :    "end_date_of_leave",     // id of the input field
		ifFormat       :    "%Y-%m-%d",      // format of the input field
		button         :    "end_date_of_leave",          // trigger for the calendar (button ID)
		align          :    "Tl",           // alignment (defaults to "Bl")
		showsTime	   :    false, 
		singleClick    :    true
	});
	check_val();
	CheckInputDate()
	$('submit_btn').disabled = false;
	
}
function OnFailRequestLeave(e){
	alert("Failed to show Request Leave Form"); 
}


function ShowStaffRequestedLeaveToClient(){
	var leads_id = $('leads_id').value;
	//alert(leads_id);
	$('staff_list').innerHTML = "Loading...";
	
	var query = queryString({'leads_id' : leads_id});
	//alert(query);
	var result = doXHR(PATH + 'ShowStaffRequestedLeaveToClient.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowStaffRequestedLeaveToClient, OnFailShowStaffRequestedLeaveToClient);
}

function OnSuccessShowStaffRequestedLeaveToClient(e){
	$('staff_list').innerHTML =	e.responseText;
}


function OnFailShowStaffRequestedLeaveToClient(e){
	alert("Failed to show all staff requested leave");	
}


function ShowStaffList(){
	$('staff_list').innerHTML = "Loading...";
	var result = doSimpleXMLHttpRequest(PATH + 'ShowStaffList.php');
    result.addCallbacks(OnSuccessShowStaffList, OnFailShowStaffList);
}

function OnSuccessShowStaffList(e){
	$('staff_list').innerHTML =	e.responseText;
}
function OnFailShowStaffList(e){
	alert("Failed to show staff list");
}

function CheckCheckboxes(){
	
		var comment_by_type = $('comment_by_type').value;
		var ins = document.getElementsByName('dates')

		if(ins.length>0){
			if(comment_by_type == 'personal'){
				$('cancel_btn').disabled = false;
				$('cancel_all_btn').disabled = false;
			}else{
				$('approve_btn').disabled = false;
				$('approve_all_btn').disabled = false;
				$('deny_btn').disabled = false;
				$('deny_all_btn').disabled = false;
				$('cancel_btn').disabled = false;
			}
			$('notes').disabled = false;
		}else{
			if(comment_by_type == 'personal'){
				$('cancel_btn').disabled = true;
				$('cancel_all_btn').disabled = true;
			}else{
				$('approve_btn').disabled = true;
				$('approve_all_btn').disabled = true;
				$('deny_btn').disabled = true;
				$('deny_all_btn').disabled = true;
				$('cancel_btn').disabled = true;
			}
			$('notes').disabled = true;
		}
	
	
}



function ShowStaffCalendar(id){
	
	
	var a_selected = $('a_selected').value;
	if(a_selected){
		$('a_'+a_selected).style.background = '';
		$('a_'+a_selected).style.color = '';
	}
	$('a_selected').value = id;
	var query = queryString({'id' : id});
	//alert(query);
	$('right_panel').style.display = 'block';
	$('right_panel').innerHTML = "Loading...";
	
	
	$('a_'+id).style.background = '#006699';
	$('a_'+id).style.color = '#FFFFFF';
	
	var result = doXHR(PATH + 'ShowStaffCalendar.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowStaffCalendar, OnFailShowStaffCalendar);

}

function OnSuccessShowStaffCalendar(e){
	$('right_panel').innerHTML = e.responseText;
	CheckCheckboxes();
	GetDateId();
}

function OnFailShowStaffCalendar(e){
	alert("Failed to show staff calendar leave request details");	
}


function ShowLeaveRequest(year , month , day , id){
	
	var userid = "";
	if($('userid') != null){
		userid = $('userid').value;	
	}
	//popup_win(PATH + 'ShowLeaveRequest.php?year='+year+'&month='+month+'&day='+day+'&id='+id+'&userid='+userid, 600 , 510);
	var file = PATH + 'ShowLeaveRequest.php?year='+year+'&month='+month+'&day='+day+'&id='+id+'&userid='+userid;
	var window = 'win'+id;
	var wd = 600;
	var hg = 520;
	
	var xpos = screen.availWidth/2 - wd/2; 
   	var ypos = screen.availHeight/2 - hg/2; 

	
	childWindow=open(file,window,'width=' + wd + ',height=' + hg + ',resizable=no,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no,screenX=0,screenY=0,top='+ypos+',left='+xpos);
    if (childWindow.opener == null) childWindow.opener = self;
	childWindow.focus();

}
function UpdateLeaveRequest(id , leave_status){
	var response_note = $('response_note').value;
	var query = queryString({'id' : id , 'leave_status' : leave_status , 'response_note' : response_note});
	//alert(query);
	//return false;
	
	//disable button
	$('cancelled_btn').disabled = true;
	$('update_result').innerHTML = 'Processing...';
	
	//return false;
	var result = doXHR(PATH+'UpdateLeaveRequest.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateLeaveRequest, OnFailUpdateLeaveRequest);
	
	function OnSuccessUpdateLeaveRequest(e){
		alert(e.responseText);
		ShowStaffCalendar(id);
		ShowStaffRequestedLeaveToClient();
		
	}
	
	function OnFailUpdateLeaveRequest(e){
		alert("Failed to update staff leave request id #" +id);
		$('cancelled_btn').disabled = false;
		$('update_result').innerHTML = '';
	}
}
function UpdateStaffLeaveRequest(id , leave_status){
	var response_note = $('response_note').value;
	var query = queryString({'id' : id , 'leave_status' : leave_status , 'response_note' : response_note});
	//alert(query);
	//return false;
	
	//disable button
	$('approved_btn').disabled = true;
	$('denied_btn').disabled = true;
	$('update_result').innerHTML = 'Processing...';
	
	//return false;
	var result = doXHR(PATH+'UpdateStaffLeaveRequest.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateStaffLeaveRequest, OnFailUpdateStaffLeaveRequest);
	
	function OnSuccessUpdateStaffLeaveRequest(e){
		alert(e.responseText);
		//updateParent(id);
		ShowStaffCalendar(id);
		ShowStaffList()
	}
	
	function OnFailUpdateStaffLeaveRequest(e){
		alert("Failed to update staff leave request id #" +id);
		$('approved_btn').disabled = false;
		$('denied_btn').disabled = false;
		$('update_result').innerHTML = '';
	}
}




function updateParent(id) {
	opener.updatemyarray(id);
	self.close();
    //return false;
}


function updatemyarray(id) {
 	//document.parentForm.submit();
	//$('right_panel').innerHTML = id;
	ShowStaffCalendar(id);
	ShowStaffList()
}