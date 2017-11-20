function AddStaffSettings(e){
	//var staff_setting='';
    var leads_id = $('client_id').value;
	var userid = $('client_staff_userid').value;
	var staff_setting = get_obj_settings('staff_setting');
	var staff_other_email = '';
	
	
	if(leads_id == ""){
		alert("No client selected");
		return false;
	}
	
	

	if(!staff_setting){
	   alert("There is no staff settings selected");
	   return false;
	}
	if(staff_setting == 'other'){
	    staff_other_email = $('staff_other_email').value;
	    if(staff_other_email == ""){
	        alert("Please enter an email address");
		    $('staff_other_email').focus();
		    return false;
		}
	}
		
	
	
	var query = queryString({ 'leads_id' : leads_id, 'userid' : userid, 'staff_setting' : staff_setting, 'staff_other_email' : staff_other_email});
    //alert(query);
	//return false;
	var result = doXHR('/portal/django/workflow/AddStaffSettings/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessAddStaffSettings, OnFailAddClientSettings);

}
function OnSuccessAddStaffSettings(e){
	if(e.responseText == 'ok'){
		alert('Saved Settings');
		GetStaffSettings();
	}else{
		alert(e.responseText);
	}
}
function AddClientSettings(e){
	//var staff_setting='';
    var leads_id = $('client_id').value;
	var client_setting = get_obj_settings('client_setting');
	var client_other_email ='';
	
	
	if(leads_id == ""){
		alert("No client selected");
		return false;
	}
	if(!client_setting){
	    alert("There is no client settings selected");
		return false;
	}
	
	if(client_setting == 'other'){
	    client_other_email = $('client_other_email').value;
		if(client_other_email == ""){
			alert("Please enter an email address");
			$('client_other_email').focus();
			return false;
		}
	}
	
	
	
	var query = queryString({ 'leads_id' : leads_id, 'client_setting' : client_setting, 'client_other_email' : client_other_email});
    //alert(query);
	//return false;
	var result = doXHR('/portal/django/workflow/AddClientSettings/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessAddClientSettings, OnFailAddClientSettings);

}
function OnSuccessAddClientSettings(e){
    if(e.responseText == 'ok'){
		alert('Saved Settings');
		GetClientStaff2();
	}else{
		alert(e.responseText);
	}
}

function OnFailAddClientSettings(e){
    alert('There is a problem in saving settings');
}

function get_obj_settings(elem){	
	var ins = document.getElementsByName(elem)
	var i;
	for(i=0;i<ins.length;i++){
		if(ins[i].checked==true) {
			return ins[i].value;
			breal;
		}
    }
}

function GetClientStaff2(e){
	var client_id = $('client_id').value;
	if(client_id == ""){
		$('staff_selection_list').innerHTML = '<em>Please select a client</em>';
		return false;
	}
	$('staff_selection_list').innerHTML = 'Loading client staff...';
	var query = queryString({ 'client_id' : client_id});
	//var result = doXHR('/portal/django/workflow/GetClientStaff/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	var result = doSimpleXMLHttpRequest('/portal/django/workflow/GetClientStaff2/'+client_id);
	result.addCallbacks(OnSuccessGetClientStaff2, OnFailGetClientStaff);
}
function OnSuccessGetClientStaff2(e){
	$('staff_selection_list').innerHTML = e.responseText;
	connect('add_client_settings', 'onclick', AddClientSettings);
	connect('client_staff_userid', 'onchange', GetStaffSettings);
}

function GetStaffSettings(e){
	var userid = $('client_staff_userid').value;
	var leads_id = $('client_id').value;
	if(userid!=""){
	    var query = queryString({ 'userid' : userid ,'leads_id' : leads_id});
	    var result = doXHR('/portal/django/workflow/GetStaffSettings/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessGetStaffSettings, OnFailGetStaffSettings);
	}else{
		$('staff_email_settings_form').innerHTML = '<input type="radio" name="staff_setting" value="email" disabled="disabled" >Default Settings : <br /><input type="radio" name="staff_setting" value="other_email" disabled="disabled" >Send to this Email : <input type="text" id="staff_other_email" name="staff_other_email" disabled="disabled" size="40" /><br /><input type="radio" name="staff_setting" value="do not send" disabled="disabled" >Do not send.<br /><p><input type="button"  disabled="disabled" value="Add Staff Settings" /></p>';
	}
}

function OnSuccessGetStaffSettings(e){
	$('staff_email_settings_form').innerHTML =e.responseText;
	connect('add_staff_settings', 'onclick', AddStaffSettings);
}
function OnFailGetStaffSettings(e){
	alert("Failed to retrieve staff autoresponder settings.");
}

function SetFinished(e){
	var percentage = $('percentage').value;
	var status = getNodeAttribute($('wf_status'), 'status');
	if(percentage == '100%'){
		$('wf_status').value = "finished";
	}else{
		$('wf_status').value = status;
	}
	
}

function SetPercentage(e){
	var status = $('wf_status').value;
	var percentage = getNodeAttribute($('percentage'), 'percentage');
	if(status == 'finished'){
		$('percentage').value = "100%";
	}else{
		$('percentage').value = percentage;
	}
	//alert(percentage+" "+status);
}

function SelectAllStaff(e){
    //alert('clicked');
	var select_all_staff = document.getElementsByName('select_all_staff');
	var staff = document.getElementsByName('staff');
	var items = getElementsByTagAndClassName('li', 'staff_list');
	
	if(select_all_staff[0].checked == true){
	    for(i=0;i<staff.length;i++){
		    staff[i].checked=true;
			staff[i].disabled=false;
	    }
		
		
        for (var item in items){
            addElementClass(items[item], 'staff_list_selected');
        }
	
	}else{
		for(i=0;i<staff.length;i++){
		    staff[i].checked=false;
			//staff[i].disabled=true;
	    }
		
		for (var item in items){
            removeElementClass(items[item], 'staff_list_selected');
        }
	}
	check_staff_val();
}

function client_tasks(e){
    var leads_id = $('leads_id').value;
	if(leads_id !=""){
	    location.href="/portal/django/workflow/client_task/"+leads_id;
	}
}

function staff_tasks(e){
    var userid = $('userid').value;
	var selected_status = $('selected_status').value;
	if (selected_status == ""){
		selected_status = 'all';
	}
	if(userid != ""){
		location.href="/portal/django/workflow/staff_task/"+userid+"?status="+selected_status;
	}
}

function RemoveLabel(e){
	var selected_tasks = $('selected_tasks').value;
	if(selected_tasks == ""){
		alert("No tasks selected.");
		return false;
	}
	var query = queryString({ 'selected_tasks' : selected_tasks});
	var result = doXHR('/portal/django/workflow/RemoveLabel/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessRemoveLabel, OnFailRemoveLabel);
}

function OnSuccessRemoveLabel(e){
	if (e.responseText == 'ok'){
	    alert('Successfully removed');
		var url = $('url').value;
	    location.href="/portal/django/workflow/"+url;
	}
}
function OnFailRemoveLabel(e){
	alert("Failed in removing label");
}

function MoveToUserLabel(){
	var labels = document.getElementsByName('labels');
	var label='';
	for(i=0;i<labels.length;i++){
		if(labels[i].checked==true) {
			label=labels[i].value;
		}
	}
	
	var selected_tasks = $('selected_tasks').value;
	
	if(label ==''){
		alert("No label selected.");
		return false;
	}
	
	if(selected_tasks == ""){
		alert("No tasks selected.");
		return false;
	}
	
	var query = queryString({ 'selected_tasks' : selected_tasks, 'label' : label});
	//alert(query);
	var result = doXHR('/portal/django/workflow/MoveToUserLabel/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessMoveToUserLabel, OnFailMoveToUserLabel);
	
}
function OnSuccessMoveToUserLabel(e){
	if (e.responseText == 'ok'){
	    alert('Successfully moved');
		var url = $('url').value;
	    location.href="/portal/django/workflow/"+url;
	}
}
function OnFailMoveToUserLabel(e){
	alert("Failed in moving a task");
}

function HideMenuChild(){
	
	//document.getElementById('sample_attach_menu_child').style.visibility = 'hidden';
	setTimeout("document.getElementById('sample_attach_menu_child').style.visibility = 'hidden'", 333)
}




function GetClientStaff(e){
	var client_id = $('client_id').value;
	if(client_id == ""){
		$('staff_selection_list').innerHTML = '<em>Please select a client</em>';
		return false;
	}
	$('staff_selection_list').innerHTML = 'Loading client staff...';
	var query = queryString({ 'client_id' : client_id});
	//var result = doXHR('/portal/django/workflow/GetClientStaff/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	var result = doSimpleXMLHttpRequest('/portal/django/workflow/GetClientStaff/'+client_id);
	result.addCallbacks(OnSuccessGetClientStaff, OnFailGetClientStaff);
}
function OnSuccessGetClientStaff(e){
	$('staff_selection_list').innerHTML = e.responseText;
	
	var items = getElementsByTagAndClassName('input', 'staff');
    for (var item in items){
        connect(items[item], 'onclick', CheckUnCheckStaff);
    }

    check_staff_val();
	
	if($('select_all_staff')){
		connect('select_all_staff', 'onclick', SelectAllStaff);
	}

}
function OnFailGetClientStaff(e){
	$('staff_selection_list').innerHTML = '<b style="color:red;">Failed to load clients staff</b>';
}

function CheckUnCheckStaff(e){
	var staff_id = getNodeAttribute(e.src(), 'staff_id');
	var ins = document.getElementsByName('staff')
	var i;
	var j=0;
	var weekdays;
	var vals= new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].value==staff_id) {
		    if(ins[i].checked==true) {
			    ins[i].checked=false;
				ins[i].disabled=true;
				removeElementClass(staff_id+'_list', 'staff_list_selected');
			}else{
				ins[i].checked=true;
				ins[i].disabled=false;
				addElementClass(staff_id+'_list', 'staff_list_selected');
			}
		}
	}
	
	//addElementClass(items[item], 'selected_status');
	check_staff_val();
}

function check_staff_val(e){	
	var ins = document.getElementsByName('staff')
	var i;
	var j=0;
	var weekdays;
	var vals= new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			vals[j]=ins[i].value;
			ins[i].disabled=false;
			j++;
			addElementClass(ins[i].value+'_list', 'staff_list_selected');
		}else{
			//ins[i].disabled=true;
			removeElementClass(ins[i].value+'_list', 'staff_list_selected');
		}
	}
	$('userids').value=(vals);
}

function SearchTask(){
	var keyword = $('keyword').value;
	var query = queryString({ 'keyword' : keyword});
	var result = doXHR('/portal/django/workflow/SearchTask/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessGetWorkflow, OnFailSearchTask);
}

function OnSuccessSearchTask(e){
}
function OnFailSearchTask(e){
	alert("Failed to search");
}

function LoadPage(e){
	var status = getNodeAttribute(e.src(), 'status');
	var current_user = $('current_user').value;
	location.href="/portal/django/workflow/"+current_user+"/"+status;
}
function LoadCurrentStatus(){
	var selected_status = $('selected_status').value;
	if(selected_status == ''){
		selected_status = 'new';
	}
	var current_user = $('current_user').value;
	//$('right_panel').innerHTML = 'Loading...';
	//var query = queryString({ 'status' : selected_status });
	//var result = doXHR('GetWorkflow/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	//var result = doSimpleXMLHttpRequest('GetWorkflow/'+selected_status);
	//result.addCallbacks(OnSuccessGetWorkflow, OnFailGetWorkflow);
	location.href="/portal/django/workflow/"+current_user+"/"+selected_status;
}
function ChangeStatus(e){
	var status = getNodeAttribute(e.src(), 'status');
	var selected_tasks = $('selected_tasks').value;
	
	if(selected_tasks == ''){
		alert("Please select workflow tasks");
		return false;
	}
	var query = queryString({ 'status' : status, 'selected_tasks' : selected_tasks});
	var result = doXHR('/portal/django/workflow/ChangeStatus/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessChangeStatus, OnFailChangeStatus);
}

function OnSuccessChangeStatus(e){
	if(e.responseText == 'ok'){
		LoadCurrentStatus();
	}else{
		alert(e.responseText);
	}
}
function OnFailChangeStatus(e){
	alert("There's a problem in transferring");
}
function SelectUnSelectCheckBox(e){
	var select_all = document.getElementsByName('select_all');
	var task = document.getElementsByName('task');
	
	var i=0;
	if (select_all[0].checked==true){
		for(i=0;i<task.length;i++){
			task[i].checked=true;
		}
	}else{
		for(i=0;i<task.length;i++){
			task[i].checked=false;
		}
	}
	check_val();
}
function check_val(e){	
	//alert('hello');
	
	var ins = document.getElementsByName('task')
	var i;
	var j=0;
	var weekdays;
	var vals= new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			vals[j]=ins[i].value;
			j++;
		}
	}
	$('selected_tasks').value=(vals);
	//check_val2();
}


function CreateTask(e){
	var work_details = $('work_details').value;
	var client_id = $('client_id').value;
	var userids = $('userids').value;
	var date_start = $('date_start').value;
	var date_finished = $('date_finished').value;
	var priority = $('priority').value;
	var percentage = $('percentage').value;
	var notes = $('notes').value;
	var query = queryString({ 'work_details' : work_details, 'userids' : userids, 'date_start' : date_start, 'date_finished' : date_finished , 'priority' : priority, 'percentage' : percentage, 'notes' : notes, 'client_id' : client_id});
	
	if(client_id == ""){
		alert("Please select a client");
		return false;
	}
	if(userids == ""){
		alert("Please select a staff");
		return false;
	}
	if(work_details == ""){
		alert("Please add a summary of this task");
		return false;
	}
	if(notes == ""){
		alert("Please add a description of this task");
		return false;
	}
	//log(query);return false;
	
	$('create_task').disabled = true;
	$('create_task').value = 'Creating...';
	var result = doXHR('/portal/django/workflow/CreateTask/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessCreateTask, OnFailCreateTask);
}
function OnSuccessCreateTask(e){
	//alert(e.responseText);
	location.href='/portal/django/workflow/ShowWorkflow/' + e.responseText;
}
function OnFailCreateTask(e){
	alert("There's a problem in creating this task");
	$('create_task').disabled = false;
	$('create_task').value = 'Create Task';
}

function UpdateTask(e){
	var task_id = getNodeAttribute(e.src(), 'task_id');
	var comment = $('comment').value;
	var work_details = $('work_details').value;
	var userids = $('userids').value;
	var date_start = $('date_start').value;
	var date_finished = $('date_finished').value;
	var priority = $('priority').value;
	var percentage = $('percentage').value;
	var notes = $('notes').value;
	var status = $('wf_status').value;
	var query = queryString({ 'task_id' : task_id, 'comment' : comment, 'work_details' : work_details, 'userids' : userids, 'date_start' : date_start, 'date_finished' : date_finished , 'priority' : priority, 'percentage' : percentage, 'notes' : notes, 'status' : status});
	//alert(query);return false;
	
	if(userids == ""){
		alert("Please select a staff");
		return false;
	}
	/*
	if(notes == ""){
		alert("Please add a description of this task");
		return false;
	}
	*/
	$('update_task').disabled = true;
	$('update_task').value = 'Submitting changes...';
	
	var result = doXHR('UpdateTask/', {method:'POST', sendContent:query, headers:{"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateTask, OnFailUpdateTask);
}

function OnSuccessUpdateTask(e){
    //$('show_workflow').innerHTML =e.responseText;
	location.href='/portal/django/workflow/ShowWorkflow/' + e.responseText;
}
function OnFailUpdateTask(e){
	alert('There is a problem in updating this task');
	$('update_task').disabled = false;
	$('update_task').value = 'Submit Changes';
}
function ShowWorkflow(e){
    var task_id = getNodeAttribute(e.src(), 'task_id');
	location.href='/portal/django/workflow/ShowWorkflow/' + task_id;
}
function OnSuccessShowWorkflow(e){
	$('right_panel').innerHTML = e.responseText;
	//addElementClass('right_panel', 'show_workflow');
}
function OnFailShowWorkflow(e){
	$('right_panel').innerHTML = 'Failed to load...';
}

function URLEncode (clearString) {
  var output = '';
  var x = 0;
  clearString = clearString.toString();
  var regex = /(^[a-zA-Z0-9_.]*)/;
  //var regex = /(%[^%]{2})/;
  while (x < clearString.length) {
    var match = regex.exec(clearString.substr(x));
    if (match != null && match.length > 1 && match[1] != '') {
    	output += match[1];
      x += match[1].length;
    } else {
      if (clearString[x] == ' ')
        output += '+';
      else {
        var charCode = clearString.charCodeAt(x);
        var hexVal = charCode.toString(16);
        output += '%' + ( hexVal.length < 2 ? '0' : '' ) + hexVal.toUpperCase();
      }
      x++;
    }
  }
  return output;
}
function LoadLabel(e){
	var label = getNodeAttribute(e.src(), 'label');
	var current_user = $('current_user').value;
	var new_label_str = label.split(' ').join('_');
	location.href="/portal/django/workflow/user_label/?q="+new_label_str;
}
function GetLabelWorkflows(id){
	$('right_panel').innerHTML = 'Loading...';
	var items = getElementsByTagAndClassName('div', 'label', 'left_panel');
	for (var item in items){
		var label_id = getNodeAttribute(items[item], 'label_id');
		if(id == label_id){
			addElementClass(items[item], 'selected_status');
		}
    }

	var result = doSimpleXMLHttpRequest('/portal/django/workflow/GetLabelWorkflows/'+id);
	result.addCallbacks(OnSuccessGetWorkflow, OnFailGetWorkflow);
}
function GetWorkflow(){
    //alert(flag);return false;	
	$('right_panel').innerHTML = "<img src='/portal/images/ajax-loader.gif' >Loading...";
	var current_user = $('current_user').value;
	var status = $('selected_status').value;
	var page = $('page').value;
	var items = getElementsByTagAndClassName('div', 'statuses', 'left_panel');
	for (var item in items){
         //removeElementClass(items[item], 'selected_status');addElementClass(items[item], 'selected_status');
		var stat = getNodeAttribute(items[item], 'status');
		if(status == stat){
			addElementClass(items[item], 'selected_status');
		}
    }
	$('selected_status').value = status;
	
	if(page == "")page = 1;
	
	if(current_user == 'staff'){
		var result = doSimpleXMLHttpRequest('/portal/django/workflow/StaffGetWorkflow/'+status);
	}else if(current_user == 'client'){
		var result = doSimpleXMLHttpRequest('/portal/django/workflow/GetWorkflow/'+status);
	}else if(current_user == 'manager'){
		var result = doSimpleXMLHttpRequest('/portal/django/workflow/GetManagerWorkflow/'+status);	
	}else{
		var result = doSimpleXMLHttpRequest('/portal/django/workflow/listing/'+status+'/'+page);
	}
	result.addCallbacks(OnSuccessGetWorkflow, OnFailGetWorkflow);
}

function OnSuccessGetWorkflow(e){
	$('right_panel').innerHTML = e.responseText;
	sortableManager.initWithTable('workflow_tb');
	var items = getElementsByTagAndClassName('td', 'workflow', 'right_panel');
    for (var item in items){
        connect(items[item], 'onclick', ShowWorkflow);
    }
	
	var items = getElementsByTagAndClassName('input', 'task');
    for (var item in items){
        connect(items[item], 'onclick', check_val);
    }
	
}
function OnFailGetWorkflow(e){
	$('right_panel').innerHTML = "<img src='/portal/images/ajax-loader.gif' >";
}