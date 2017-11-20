// JavaScript Document
var PATH = 'get_started/';
//connect(window, "onload", OnLoadGetAllHireAStaffOrders);

function editJobPostion2(gs_job_titles_details_id){
	//alert(gs_job_titles_details_id);
	//toggle('div_edit_job_position_form');
	
	$('div_edit_job_position_form2').style.display = "block";
	$('div_edit_job_position_form2').innerHTML= "Loading...";
	var query = queryString({'gs_job_titles_details_id' : gs_job_titles_details_id});
	var result = doXHR(PATH + 'editJobPostion.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
    result.addCallbacks(OnSuccessEditJobPosition2, OnFailEditJobPosition2);
}
function OnSuccessEditJobPosition2(e){
	//alert(e.responseText);
	$('div_edit_job_position_form2').innerHTML=e.responseText;
	
	var xpos = screen.availWidth/2 - 500/2; 
    var ypos = screen.availHeight/2 - 350/2; 
	$('editJobPositionForm2').style.top = ypos+"px";
	$('editJobPositionForm2').style.left = xpos+"px";
	//connect('updateOrderListbtn' ,'onclick' ,updateOrderList);
}

function OnFailEditJobPosition2(e){
	alert("Failed to show Edit Job Position Form");
}


function showAmount2(){
	var selected_job_title = $('selected_job_title').value;
	var level =  $('level').value;
	var work_status = $('work_status1').value;
	var currency = $('jr_currency').value;

	//var gs_job_titles_details_id = $('gs_job_titles_details_id').value;
	//selected_job_title = selected_job_title.replace("-", " ");
	if(level == ""){
		//alert("Please select expertise level");
		return false;
	}
	
	if(work_status == ""){
		//alert("Please select Staff working status");
		return false;
	}
	
	
	$('amount_str').innerHTML = "Processing...";
	var query = queryString({'selected_job_title' : selected_job_title , 'level' : level , 'work_status' : work_status , 'currency' : currency });
	//alert(query);
	var result = doXHR(PATH + 'showAmount.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
    result.addCallbacks(OnSuccessShowAmount2, OnFailShowAmount2);
	

	function OnSuccessShowAmount2(e){
		//$('amount_str').innerHTML = e.responseText;
		//configureTimeSettings2(1 , 'plus');
		if(e.responseText == 'no currency'){
		    var s = $('selected_job_title');
		    var job_title = s.options[s.selectedIndex].text
			alert("ALERT: Updates could not be made "+job_title+" has no available price for "+currency+" currency.");
		    //alert($('jr_list_id').value);
			s.value = $('jr_list_id').value;
			//fade('div_edit_job_position_form');
		}else{		
			$('amount_str').innerHTML = e.responseText;
			configureTimeSettings(1 , 'plus');
		}
	}
	function OnFailShowAmount2(e){
		alert("Error in configuring the amount");
	}
}
function configureTimeSettings2(num , mode){
	
	
	
	var work_status = $('work_status'+num).value;
	var client_start_work_hour = $('client_start_work_hour'+num).value; 
	var client_finish_work_hour = $('client_finish_work_hour'+num).value; 
	var hours =0;
	
	if(work_status == "Part-Time"){
		hour = 4;
	}else{
		hour = 9;
	}
	
	//alert(client_finish_work_hour);
	client_start_work_hour = client_start_work_hour.replace(/:30/i, ".5");
	client_finish_work_hour = client_finish_work_hour.replace(/:30/i, ".5");
	
	//alert(client_finish_work_hour);
	
	if(mode == "plus"){
		hours = (parseFloat(client_start_work_hour) + hour)
		//alert(hours);
		if(hours > 24){
			hours = hours - 24;
		}
		if(hours < 10 ){
			hours = "0"+hours;
		}
		hours = hours+'';
		hours = hours.replace(/.5/i, ":30");
		$('client_finish_work_hour'+num).value =(hours);
	}
	
	if(mode == "minus"){
		//alert(hours);
		hours = (parseFloat(client_finish_work_hour) - hour)
		//alert(hours);
		if(hours < 0){
			hours = hours + 24;
		}
		if(hours < 10 ){
			hours = "0"+hours;
		}
		//alert(hours);
		hours = hours+'';
		//alert(hours);
		hours = hours.replace(".5", ":30");
		//alert(hours);
		$('client_start_work_hour'+num).value = (hours);
	}
	
}


function updateOrderListPortal(){
	var gs_job_role_selection_id = $('gs_job_role_selection_id').value;
	var jr_list_id = $('jr_list_id').value;
	var jr_cat_id = $('jr_cat_id').value;
	var level =  $('level').value;
	var work_status = $('work_status1').value;
	var gs_job_titles_details_id = $('gs_job_titles_details_id').value;
	
	var working_timezone = $('working_timezone').value;
	var start_work = $('client_start_work_hour1').value;
	var finish_work = $('client_finish_work_hour1').value;
	var no_of_staff_needed = $('no_of_staff_needed').value;
	
	if(no_of_staff_needed == "" || no_of_staff_needed =="0"){
		alert("Please enter number of staff.");
		return false;
	}
	
	var query = queryString({'gs_job_role_selection_id' : gs_job_role_selection_id , 'jr_list_id' : jr_list_id , 'level' : level , 'work_status' : work_status , 'gs_job_titles_details_id' : gs_job_titles_details_id , 'jr_cat_id' : jr_cat_id , 'working_timezone' : working_timezone , 'start_work' : start_work , 'finish_work' : finish_work , 'no_of_staff_needed' : no_of_staff_needed });
	//alert(query);
	var result = doXHR(PATH + 'updateOrderList.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
    result.addCallbacks(OnSuccessUpdateOrderList2, OnFailUpdateOrderList2);


	function OnSuccessUpdateOrderList2(e){
		alert(e.responseText);
		//http://test.remotestaff.com.au/portal/get_started/job_spec.php?gs_job_titles_details_id=509&jr_cat_id=3&jr_list_id=64&gs_job_role_selection_id=620
		location.href="job_spec.php?gs_job_titles_details_id="+gs_job_titles_details_id+"&jr_cat_id="+jr_cat_id+"&jr_list_id="+jr_list_id+"&gs_job_role_selection_id="+gs_job_role_selection_id;
	}
	
	function OnFailUpdateOrderList2(e){
		alert("Failed to update order list");
	}

}

/////////////
function onclickCloseUpdateJobSpecOtherDetails(gs_job_titles_details_id , jr_list_id , gs_job_role_selection_id, jr_cat_id){
	location.href="job_spec.php?gs_job_titles_details_id="+gs_job_titles_details_id+"&jr_cat_id="+jr_cat_id+"&jr_list_id="+jr_list_id+"&gs_job_role_selection_id="+gs_job_role_selection_id;
}
function onclickUpdateJobSpecOtherDetails(gs_job_titles_details_id , jr_list_id , gs_job_role_selection_id, jr_cat_id){
	//alert(gs_job_titles_details_id +" , "+ jr_list_id +" , "+ gs_job_role_selection_id + " , "+jr_cat_id);
	//return false;
	var campaign_type="";
	if($('campaign_type'+gs_job_titles_details_id) != null){
		campaign_type = $('campaign_type'+gs_job_titles_details_id).value;
	}
	
	var call_type="";
	if($('call_type'+gs_job_titles_details_id) != null){
		call_type = $('call_type'+gs_job_titles_details_id).value;
	}
	
	var q1 = "";
	if($('q1'+gs_job_titles_details_id) != null){
		q1 = $('q1'+gs_job_titles_details_id).value;
	}
	var q2 = "";
	if($('q2'+gs_job_titles_details_id) != null){
		q2 = $('q2'+gs_job_titles_details_id).value;
	}
	var q3 = "";
	if($('q3'+gs_job_titles_details_id) != null){
		q3 = $('q3'+gs_job_titles_details_id).value;
	}
	var q4 = "";
	if($('q4'+gs_job_titles_details_id) != null){
		q4 = $('q4'+gs_job_titles_details_id).value;
	}
	var lead_generation = "";
	if($('lead_generation'+gs_job_titles_details_id) != null){
		lead_generation = $('lead_generation'+gs_job_titles_details_id).value;
	}
	var telemarketer_hrs = "";
	if($('telemarketer_hrs'+gs_job_titles_details_id) != null){
		telemarketer_hrs = $('telemarketer_hrs'+gs_job_titles_details_id).value;
	}
	var onshore = "";
	if($('onshore'+gs_job_titles_details_id) != null){
		onshore = $('onshore'+gs_job_titles_details_id).value;
	}
	
	var writer_type = getWriterType('writer_type'+gs_job_titles_details_id);

	var staff_phone ="";
	if($('staff_phone'+gs_job_titles_details_id) != null){
		staff_phone = $('staff_phone'+gs_job_titles_details_id).value;
	}
	
	var require_graphic ="";
	if($('require_graphic'+gs_job_titles_details_id) != null){
		require_graphic = $('require_graphic'+gs_job_titles_details_id).value;
	}
	
	var requirement = getRequirement('requirement'+gs_job_titles_details_id);
	var others = $('others'+gs_job_titles_details_id).value;
	var notes = $('notes'+gs_job_titles_details_id).value;
	//$('save_update_status_'+gs_job_titles_details_id).innerHTML = "";
	
	var query = queryString({'gs_job_titles_details_id' : gs_job_titles_details_id , 'gs_job_role_selection_id' : gs_job_role_selection_id ,'campaign_type' : campaign_type, 'others' : others , 'notes' : notes , 'call_type' : call_type , 'requirement' : requirement , 'q1' : q1, 'q2' : q2, 'q3' : q3, 'q4' : q4 , 'lead_generation' : lead_generation , 'telemarketer_hrs' : telemarketer_hrs , 'onshore' : onshore , 'writer_type' : writer_type , 'staff_phone' : staff_phone , 'require_graphic' : require_graphic});
 //alert(requirement);
 
  var result = doXHR(PATH + 'saveJobSpecOtherDetails.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
  result.addCallbacks(OnSuccessSaveJobSpecOtherDetails, OnFailSaveJobSpecOtherDetails);
  
  
	function OnSuccessSaveJobSpecOtherDetails(e){
		if(e.responseText == 'Successfully Updated'){
		    alert(e.responseText);
			location.href="job_spec.php?gs_job_titles_details_id="+gs_job_titles_details_id+"&jr_cat_id="+jr_cat_id+"&jr_list_id="+jr_list_id+"&gs_job_role_selection_id="+gs_job_role_selection_id;
		}else{
		    alert(e.responseText);
		}
	}
	function OnFailSaveJobSpecOtherDetails(e){
		alert("Failed to save other details. Please try again later.");
	}
	
}


function EditJobSpec(e){
	var jr_cat_id = getNodeAttribute(e.src(), 'jr_cat_id');
	var gs_job_titles_details_id = getNodeAttribute(e.src(), 'gs_job_titles_details_id');
	var jr_list_id = getNodeAttribute(e.src(), 'jr_list_id');
	var gs_job_role_selection_id = getNodeAttribute(e.src(), 'gs_job_role_selection_id');
	var query = queryString({'jr_cat_id' : jr_cat_id, 'gs_job_titles_details_id' : gs_job_titles_details_id, 'jr_list_id' : jr_list_id, 'gs_job_role_selection_id' : gs_job_role_selection_id});
	var result = doXHR('showJobSpecificationForm.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowJobSpecificationForm, OnFailShowJobSpecificationForm);
	
	
}


function OnSuccessShowJobSpecificationForm(e){
	$('container').innerHTML = e.responseText;
}
function OnFailShowJobSpecificationForm(e){
	alert("Failed to fetch Job Specification form");
}
	
	
function OnClickShowClientOrder(e){
	e.preventDefault();
	var order_id = getNodeAttribute(e.src(), 'id');
	if(order_id == ""){
		alert("Order id is missing");
		return false;
	}
	//var query = queryString({'order_id' : order_id });
	//var result = doXHR(PATH + 'showClientOrder.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	//result.addCallbacks(OnSuccessShowClientOrder, OnFailShowClientOrder);
	popup_win('custom_get_started/job_spec.php?gs_job_titles_details_id='+order_id+'&disabled=1',950,600);
}
/*
function OnSuccessShowClientOrder(e){
		
}
function OnFailShowClientOrder(e){
	alert("Failed to show client order");
}
*/
function showIncompleteOrder(order_id){
	if(order_id == ""){
		alert("Order id is missing");
		return false;
	}
	$('right_pane').innerHTML = "Loading...";
	var query = queryString({'order_id' : order_id });
	var result = doXHR(PATH + 'showIncompleteOrder.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowOrder, OnFailShowOrder);
	
}

function addComments(){
	var gs_job_role_selection_id = $('gs_job_role_selection_id').value;
	var invoice_id = $('invoice_id').value;
	var message = $('message').value;
	
	if(message==""){
		alert("There is no message to be save.");
		return false;
	}
	var query = queryString({'gs_job_role_selection_id' : gs_job_role_selection_id , 'invoice_id' : invoice_id , 'message' : message });
	var result = doXHR(PATH + 'addComments.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessAddComments, OnFailAddComments);
}
function OnSuccessAddComments(e){
	$('message').value = "";
	$('notes_list').innerHTML = "Successfully saved. Refresing list...";
	showComments();
}
function OnFailAddComments(e){
	alert("Failed to Add comments / notes");
}

function showComments(){
	var gs_job_role_selection_id = $('gs_job_role_selection_id').value;
	var invoice_id = $('invoice_id').value;
	
	var query = queryString({'gs_job_role_selection_id' : gs_job_role_selection_id , 'invoice_id' : invoice_id });
	var result = doXHR(PATH + 'showComments.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowComments, OnFailShowComments);
}

function OnSuccessShowComments(e){
	$('notes_list').innerHTML = e.responseText;
}
function OnFailShowComments(e){
	alert("Failed to show comments and notes");
}

function showOrder(order_id){
	
	if(order_id == ""){
		alert("Order id is missing");
		return false;
	}
	$('right_pane').innerHTML = "Loading...";
	var query = queryString({'order_id' : order_id });
	var result = doXHR(PATH + 'showOrder.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowOrder, OnFailShowOrder);
}
function OnSuccessShowOrder(e){
	$('right_pane').innerHTML = e.responseText;
}
function OnFailShowOrder(e){
	alert("Failed to show order details. Please try again");
	$('right_pane').innerHTML = e.responseText;
}

function OnLoadGetAllHireAStaffOrders(){
	$('left_pane').innerHTML = "Loading...";
	var result = doSimpleXMLHttpRequest(PATH + 'OnLoadGetAllHireAStaffOrders.php');
    result.addCallbacks(OnSuccessOnLoadGetAllHireAStaffOrders, OnFailOnLoadGetAllHireAStaffOrders);
}
function OnSuccessOnLoadGetAllHireAStaffOrders(e){
	$('left_pane').innerHTML = e.responseText;
}
function OnFailOnLoadGetAllHireAStaffOrders(e){
	alert("Failed to parse all Hire A Staff Orders");
}
