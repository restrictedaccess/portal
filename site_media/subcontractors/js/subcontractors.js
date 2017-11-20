// JavaScript Document

var STAFF_DEFAULT_WORK_DAYS = new Array('mon', 'tue', 'wed', 'thu', 'fri');
var WEEKDAYS = new Array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');
var AFF_COMM = 5;
var BP_COMM = 15;


var someDate = new Date();
var numberOfDaysToAdd = 2;
someDate.setDate(someDate.getDate() + numberOfDaysToAdd);

var dd = someDate.getDate();
var mm = someDate.getMonth()+1;
var y = someDate.getFullYear();


if (mm < 10){
	mm='0'+mm;
}
if (dd < 10){
	dd='0'+dd;
}

var CLIENT_PRICE_EFFECTIVE_DATE_ADVANCED =y + ''+ mm + ''+ dd;


function UpdateStaffEmail(e){
	var email = $('email').value;
	var subcon_id = $('subcon_id').value;
	
	var query = queryString({'subcon_id' : subcon_id, 'email': email });
	
	if(confirm("Save Changes")){
	    $('update_staff_email_btn').value="saving changes...";
	    $('update_staff_email_btn').disabled=true;
	    var result = doXHR(PATH + 'UpdateStaffEmail/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessUpdateStaffEmail, OnFailUpdateStaffEmail);
	}
}
function OnSuccessUpdateStaffEmail(e){
	var subcon_id = $('subcon_id').value;
	if(e.responseText == 'ok'){
	    alert("Updated Successfully.");
		location.href=PATH + 'staff_email/'+subcon_id;
	}else{
		alert(e.responseText);
	}
	$('update_staff_email_btn').value="Save Changes";
	$('update_staff_email_btn').disabled=false;
}
function OnFailUpdateStaffEmail(e){
	alert("There's a problem in updating staff email");
	$('update_staff_email_btn').value="Save Changes";
	$('update_staff_email_btn').disabled=false;
}

function ScheduleUpdatedRates(e){
	var client_price = $('client_price').value;
	var work_status = $('work_status').value;
	var php_monthly = $('php_monthly').value;
	var scheduled_date = $('scheduled_date').value;
	var subcon_id = $('subcon_id').value;
	
	if(client_price == ""){
		alert('Please enter amount.');
		return false;
	}
	
	if(isNaN(client_price)){
		alert("Client price amount is invalid.");
		return false;
	}
	
	
	if(php_monthly == ""){
		alert("Please enter staff salary.");
		return false;
	}

	
	if(isNaN(php_monthly)){
		alert("Invalid staff salary.");
		return false;
	}
	
	if(scheduled_date == ""){
		alert("Please enter scheduled date.");
		return false;
	}
	
	var query = queryString({'subcon_id' : subcon_id, 'work_status': work_status, 'php_monthly' : php_monthly, 'scheduled_date' : scheduled_date, 'client_price' : client_price });
	
	if(confirm("Update Rates")){
	    $('update_rates_btn').value="scheduling...";
	    $('update_rates_btn').disabled=true;
	    var result = doXHR(PATH + 'ScheduleUpdatedRates/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessScheduleUpdatedRates, OnFailScheduleUpdatedRates);
	}
	
}

function OnSuccessScheduleUpdatedRates(e){
	var subcon_id = $('subcon_id').value;
	if(e.responseText == 'ok'){
	    alert("Scheduled successfully.");
		location.href=PATH + 'update_rates/'+subcon_id;
	}else{
		alert(e.responseText);
	}
	$('update_rates_btn').value="Save Changes";
	$('update_rates_btn').disabled=false;
}
function OnFailScheduleUpdatedRates(e){
	alert("There's a problem in schedulling updated rates.");
	$('update_rates_btn').value="Save Changes";
	$('update_rates_btn').disabled=false;
}

function SubmitThisForm(e){
	$('submit_btn').value = 'searching';
	$('submit_btn').disabled = true;
	$('form1').submit();
}
function ResetPage(e){
	$('page').value = 1;
	$('page').disabled=true;
}

function ScheduledUpdateClientPrice(e){
	var client_price = $('client_price').value;
	var client_price_effective_date = $('client_price_effective_date').value;
	
	var subcon_id = $('subcon_id').value;
	
	if(client_price == ""){
		alert('Please enter amount.');
		return false;
	}
	
	if(client_price_effective_date ==""){
		alert("Please enter client price effective date.");
		return false;
	}
	
	if(isNaN(client_price)){
		alert("Client price amount is invalid.");
		return false;
	}
	
	
	
	if(confirm("Schedule Update Client Price?")){
		$('update_client_price_btn').value = "Saving changes...";
	    $('update_client_price_btn').disabled = true;
	
	    var query = queryString({'subcon_id' : subcon_id, 'client_price' : client_price, 'client_price_effective_date' : client_price_effective_date });
	    log(query);
        var result = doXHR(PATH + 'schedule_update_client_price/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessScheduledUpdateClientPrice, OnFailScheduledUpdateClientPrice);
	}
}

function OnSuccessScheduledUpdateClientPrice(e){
	var subcon_id = $('subcon_id').value;
	if(e.responseText == 'ok'){
	    alert("Client Price was scheduled successfully.");
		location.href=PATH + 'client_rate/'+subcon_id;
	}else{
		alert(e.responseText);
	}
	$('update_client_price_btn').value = "Save Changes";
	$('update_client_price_btn').disabled = false;
}

function OnFailScheduledUpdateClientPrice(e){
	alert("There's a problem in schedulling client price update");
	$('update_client_price_btn').value = "Save Changes";
	$('update_client_price_btn').disabled = false;
}
function UpdateClientPrice(e){
	var client_price = $('client_price').value;
	var client_price_effective_date = $('client_price_effective_date').value;
	
	var subcon_id = $('subcon_id').value;
	
	if(client_price == ""){
		alert('Please enter amount.');
		return false;
	}
	
	if(client_price_effective_date ==""){
		alert("Please enter client price effective date.");
		return false;
	}
	
	if(isNaN(client_price)){
		alert("Client price amount is invalid.");
		return false;
	}
	
	
	
	if(confirm("Update Client Price?")){
		$('update_client_price_btn').value = "Saving changes...";
	    $('update_client_price_btn').disabled = true;
	
	    var query = queryString({'subcon_id' : subcon_id, 'client_price' : client_price, 'client_price_effective_date' : client_price_effective_date });
	    log(query);
        var result = doXHR(PATH + 'UpdateClientPrice/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessUpdateClientPrice, OnFailUpdateClientPrice);
	}
}

function  OnSuccessUpdateClientPrice(e){
	var subcon_id = $('subcon_id').value;
	if(e.responseText == 'ok'){
	    alert("Client Price updated");
		location.href=PATH + 'client_rate/'+subcon_id;
	}else{
		alert(e.responseText);
	}
	$('update_client_price_btn').value = "Save Changes";
	$('update_client_price_btn').disabled = false;
}
function OnFailUpdateClientPrice(e){
	alert("There's a problem in updating client rate");
	$('update_client_price_btn').value = "Save Changes";
	$('update_client_price_btn').disabled = false;
}

function SearchSubcons(e){
	var search_all = true;
	
	var status = $('status').value;
	var keyword = $('keyword').value;
	var leads_id = $('leads_id').value;
	var userid = $('userid').value;
	
	var hiring_coordinator_id = $('hiring_coordinator_id').value;
	var csro_id = $('csro_id').value;
	var recruiter_id = $('recruiter_id').value;
	var client_timezone = $('client_timezone').value;
	var work_status = $('work_status').value;
	var flexi = $('flexi').value;
	
	if(keyword){
		search_all =false;
	}
	if (leads_id){
		search_all =false;
	}
	
	if(userid){
		search_all =false;
	}
	
	if(hiring_coordinator_id){
		search_all=false;
	}
	
	if(csro_id){
		search_all=false;
	}
	
	if(client_timezone){
		search_all=false;
	}
	
	if(work_status){
		search_all=false;
	}
	
	if(flexi){
		search_all=false;
	}
	
	if(recruiter_id){
		search_all=false;
	}
	
    $('search_btn').disabled=true;
	$('search_btn').value='searching...';
	if(search_all){
		$('page').value = 1;
		ShowAllSubcons();
	}else{
		$('page').value = 1;
	    var query = queryString({'keyword' : keyword, 'status' : status, 'leads_id' : leads_id, 'userid' : userid, 'hiring_coordinator_id' : hiring_coordinator_id, 'csro_id' : csro_id, 'client_timezone' : client_timezone, 'work_status' : work_status, 'flexi' : flexi, 'recruiter_id' : recruiter_id });	
	    log(query);
		var result = doXHR(PATH + 'SearchSubcons/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessSearchSubcons, OnFailSearchSubcons);
	}
}

function OnSuccessSearchSubcons(e){
	$('subconlist').innerHTML=e.responseText;
	$('search_btn').disabled=false;
	$('search_btn').value='search';
}

function OnFailSearchSubcons(e){
	$('subconlist').innerHTML="There's a problem in searching staffs.";
	$('search_btn').disabled=false;
	$('search_btn').value='search';
}
function ShowAllSubcons(){
	var status = $('status').value;
	var page = $('page').value;
    log(status,page);	
	$('search_btn').disabled=true;
	$('search_btn').value='searching...';
	var result = doSimpleXMLHttpRequest(PATH + 'show_all_subcons/'+status+'/'+page);	
	result.addCallbacks(OnSuccessShowAllSubcons, OnFailShowAllSubcons);
}

function OnSuccessShowAllSubcons(e){
	$('subconlist').innerHTML=e.responseText;
	$('search_btn').disabled=false;
	$('search_btn').value='search';
}
function OnFailShowAllSubcons(e){
	$('subconlist').innerHTML="There's a problem in loading staffs.";
	$('search_btn').disabled=false;
	$('search_btn').value='search';
}
function DisplayWorkingHoursDaysBreakTime(){
    var work_status = $('work_status').value;
	var work_days = $('work_days').value;
	work_days = work_days.split(',')
	log(work_days.length);
	
	var total_working_hours=0;
	var total_break_time_hours=0;
	for(i=0;i<work_days.length;i++){
        total_working_hours = total_working_hours + parseFloat($(work_days[i]+'_number_hrs').value);	
	    total_break_time_hours = total_break_time_hours + parseFloat($(work_days[i]+'_lunch_number_hrs').value);
	}
	
	$('no_of_working_days').innerHTML=work_days.length;
	$('total_working_hours').innerHTML=total_working_hours.toFixed(2);
	$('total_break_time_hours').innerHTML=total_break_time_hours.toFixed(2);
}
function ScheduledUpdateSalary(e){
	var subcon_id = $('subcon_id').value;
	var work_status = $('work_status').value;
	var php_monthly = $('php_monthly').value;
	var scheduled_date = $('scheduled_date').value;
	
	
	if(php_monthly == ""){
		alert("Please enter staff salary.");
		return false;
	}
	
	if(scheduled_date == ""){
		alert("Please enter scheduled date.");
		return false;
	}
	
	if(isNaN(php_monthly)){
		alert("Invalid staff salary.");
		return false;
	}
	
	var query = queryString({'subcon_id' : subcon_id, 'work_status': work_status, 'php_monthly' : php_monthly, 'scheduled_date' : scheduled_date });	
	//log(query);
	if(confirm("Schedule updated salary?")){
	    $('schedule_btn').value="scheduling...";
	    $('schedule_btn').disabled=true;
	    var result = doXHR(PATH + 'ScheduledUpdateSalary/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessScheduledUpdateSalary, OnFailScheduledUpdateSalary);
	}
}

function OnSuccessScheduledUpdateSalary(e){
	if(e.responseText == 'ok'){
		alert('Successfully Scheduled.');
		var subcon_id = $('subcon_id').value;
		location.href=PATH + 'subcon_rate/'+subcon_id;
	}else{
	    alert(e.responseText);
	}
	$('schedule_btn').value="Save Changes";
	$('schedule_btn').disabled=false;
}
function OnFailScheduledUpdateSalary(e){
	alert("There's a problem in schedulling.");
	$('schedule_btn').value="Save Changes";
	$('schedule_btn').disabled=false;
}
function SearchApplicant(e){
	var search_str = $('search_str').value;
	var search_type = $('search_type').value;
	
	var query = queryString({'search_str': search_str, 'search_type' : search_type });	
	log(query);
	
	if(search_str != "" && search_type !=""){
	    $('search_btn').value="searching...";
	    $('search_btn').disabled=true;
	    var result = doXHR(PATH + 'SearchApplicant/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessSearchApplicant, OnFailSearchApplicant);
	}
}

function OnSuccessSearchApplicant(e){
	$('applicants_list').innerHTML = e.responseText;
	$('search_btn').value="Search";
	$('search_btn').disabled=false;
}

function OnFailSearchApplicant(e){
	alert("There's a problem in searching applicants.");
	$('search_btn').value="Search";
	$('search_btn').disabled=false;
}

function ApproveNewStaffContract(e){
	var subcon_id = $('subcon_id').value;
	var email = $('email').value;
	var initial_email_password = $('initial_email_password').value;
	var initial_skype_password = $('initial_skype_password').value;
	var skype_id = $('skype_id').value;	
	
	
	var prepaid = $('prepaid').value;
	var leads_id = $('leads_id').value;
	var staff_currency_id = $('staff_currency_id').value;
	
	var job_designation = $('job_designation').value;			
	var work_status = $('work_status').value;
	
	var php_monthly = $('php_monthly').value;
	var currency = $('currency').value;
	var client_price = $('client_price').value;
	var client_price_effective_date = $('client_price_effective_date').value;
	
	var staff_other_client_email = $('staff_other_client_email').value;
	var staff_other_client_email_password = $('staff_other_client_email_password').value;
	var overtime = $('overtime').value;
	var overtime_monthly_limit = $('overtime_monthly_limit').value;
	var starting_date = $('starting_date').value;
	var staff_working_timezone = $('staff_working_timezone').value;
	var client_timezone = $('client_timezone').value;
	var client_start_work_hour = $('client_start_work_hour').value;
	var client_finish_work_hour = $('client_finish_work_hour').value;
	var flexi = $('flexi').value;
	var service_type = $('service_type').value;
	var work_days = $('work_days').value;
	
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
		
	var admin_notes = $('admin_notes').value;
	var with_bp_comm = $('with_bp_comm').value;
	var with_aff_comm = $('with_aff_comm').value;
	var current_rate = $('current_rate').value;
	
	if (overtime_monthly_limit == ""){
		overtime_monthly_limit = 0;
	}
	
	var query = queryString({'subcon_id': subcon_id, 'prepaid' : prepaid, 'job_designation' : job_designation, 'email' : email, 'leads_id' : leads_id, 'initial_email_password' : initial_email_password, 'work_status' : work_status, 'staff_currency_id' : staff_currency_id, 'php_monthly' : php_monthly, 'currency' : currency, 'client_price' : client_price, 'client_price_effective_date' : client_price_effective_date,  'skype_id' : skype_id, 'initial_skype_password' : initial_skype_password, 'staff_other_client_email' : staff_other_client_email, 'staff_other_client_email_password' : staff_other_client_email_password, 'overtime' : overtime, 'overtime_monthly_limit' : overtime_monthly_limit, 'starting_date' : starting_date, 'staff_working_timezone' : staff_working_timezone, 'client_timezone' : client_timezone, 'client_start_work_hour' : client_start_work_hour, 'client_finish_work_hour' : client_finish_work_hour, 'flexi' : flexi, 'service_type' : service_type, 'admin_notes' : admin_notes, 'work_days' : work_days, 'with_bp_comm' : with_bp_comm, 'with_aff_comm' : with_aff_comm, 'current_rate' : current_rate, 'mon_start' : mon_start , 'mon_finish' : mon_finish , 'mon_number_hrs' : mon_number_hrs , 'mon_start_lunch' : mon_start_lunch , 'mon_finish_lunch' : mon_finish_lunch , 'mon_lunch_number_hrs' : mon_lunch_number_hrs, 'tue_start' : tue_start , 'tue_finish' : tue_finish , 'tue_number_hrs' : tue_number_hrs , 'tue_start_lunch' : tue_start_lunch , 'tue_finish_lunch' : tue_finish_lunch , 'tue_lunch_number_hrs' : tue_lunch_number_hrs , 'wed_start' : wed_start , 'wed_finish' : wed_finish , 'wed_number_hrs' : wed_number_hrs , 'wed_start_lunch' : wed_start_lunch , 'wed_finish_lunch' : wed_finish_lunch , 'wed_lunch_number_hrs' : wed_lunch_number_hrs, 'thu_start' : thu_start , 'thu_finish' : thu_finish , 'thu_number_hrs' : thu_number_hrs , 'thu_start_lunch' : thu_start_lunch , 'thu_finish_lunch' : thu_finish_lunch , 'thu_lunch_number_hrs' : thu_lunch_number_hrs, 'fri_start' : fri_start , 'fri_finish' : fri_finish , 'fri_number_hrs' : fri_number_hrs , 'fri_start_lunch' : fri_start_lunch , 'fri_finish_lunch' : fri_finish_lunch , 'fri_lunch_number_hrs' : fri_lunch_number_hrs, 'sat_start' : sat_start , 'sat_finish' : sat_finish , 'sat_number_hrs' : sat_number_hrs , 'sat_start_lunch' : sat_start_lunch , 'sat_finish_lunch' : sat_finish_lunch , 'sat_lunch_number_hrs' : sat_lunch_number_hrs, 'sun_start' : sun_start , 'sun_finish' : sun_finish , 'sun_number_hrs' : sun_number_hrs , 'sun_start_lunch' : sun_start_lunch , 'sun_finish_lunch' : sun_finish_lunch , 'sun_lunch_number_hrs' : sun_lunch_number_hrs});
	
	//log(query);
	
	if(confirm("Approve new staff contract?")){
	    $('approve_new_contract_btn').value="Approving...";
	    $('approve_new_contract_btn').disabled=true;
	    $('delete_new_contract_btn').disabled=true;
	    var result = doXHR(PATH + 'ApproveNewStaffContract/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessApproveNewStaffContract, OnFailApproveNewStaffContract);
	}
}

function OnSuccessApproveNewStaffContract(e){
	if(isNaN(e.responseText)==true){
		alert(e.responseText);
		$('approve_new_contract_btn').value="Approve New Contract";
	    $('approve_new_contract_btn').disabled=false;
	    $('delete_new_contract_btn').disabled=false;
	}else{
		alert("Staff Contract Approved.");
		var subcon_id = e.responseText;
	    location.href=PATH +'subcon/'+subcon_id;
	}
}
function OnFailApproveNewStaffContract(e){
	alert("There's a problem in approving new staff contract.");
	$('approve_new_contract_btn').value="Approve New Contract";
	$('approve_new_contract_btn').disabled=false;
	$('delete_new_contract_btn').disabled=false;
}

function CreateNewTempContract(e){
	var userid = getNodeAttribute(e.src(),'userid');
	var email = $('email').value;
	var initial_email_password = $('initial_email_password').value;
	var initial_skype_password = $('initial_skype_password').value;
	var skype_id = $('skype_id').value;	
	
	
	var prepaid = $('prepaid').value;
	var leads_id = $('leads_id').value;
	var staff_currency_id = $('staff_currency_id').value;
	
	var job_designation = $('job_designation').value;			
	var work_status = $('work_status').value;
	
	var php_monthly = $('php_monthly').value;
	var currency = $('currency').value;
	var client_price = $('client_price').value;
	//var client_price_effective_date = $('client_price_effective_date').value;
	
	var staff_other_client_email = $('staff_other_client_email').value;
	var staff_other_client_email_password = $('staff_other_client_email_password').value;
	var overtime = $('overtime').value;
	var overtime_monthly_limit = $('overtime_monthly_limit').value;
	var starting_date = $('starting_date').value;
	var staff_working_timezone = $('staff_working_timezone').value;
	var client_timezone = $('client_timezone').value;
	var client_start_work_hour = $('client_start_work_hour').value;
	var client_finish_work_hour = $('client_finish_work_hour').value;
	var flexi = $('flexi').value;
	var service_type = $('service_type').value;
	var work_days = $('work_days').value;
	
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
		
	var admin_notes = $('admin_notes').value;
	var with_bp_comm = $('with_bp_comm').value;
	var with_aff_comm = $('with_aff_comm').value;
	var current_rate = $('current_rate').value;
	
	if (overtime_monthly_limit == ""){
		overtime_monthly_limit = 0;
	}
	
	if (leads_id == ""){
		alert("Please select a client");
		return false;
	}
	
	var client_price_effective_date = starting_date;
	
	var query = queryString({'userid' : userid, 'prepaid' : prepaid, 'job_designation' : job_designation, 'email' : email, 'leads_id' : leads_id, 'initial_email_password' : initial_email_password, 'work_status' : work_status, 'staff_currency_id' : staff_currency_id, 'php_monthly' : php_monthly, 'currency' : currency, 'client_price' : client_price, 'client_price_effective_date' : client_price_effective_date,  'skype_id' : skype_id, 'initial_skype_password' : initial_skype_password, 'staff_other_client_email' : staff_other_client_email, 'staff_other_client_email_password' : staff_other_client_email_password, 'overtime' : overtime, 'overtime_monthly_limit' : overtime_monthly_limit, 'starting_date' : starting_date, 'staff_working_timezone' : staff_working_timezone, 'client_timezone' : client_timezone, 'client_start_work_hour' : client_start_work_hour, 'client_finish_work_hour' : client_finish_work_hour, 'flexi' : flexi, 'service_type' : service_type, 'admin_notes' : admin_notes, 'work_days' : work_days, 'with_bp_comm' : with_bp_comm, 'with_aff_comm' : with_aff_comm, 'current_rate' : current_rate, 'mon_start' : mon_start , 'mon_finish' : mon_finish , 'mon_number_hrs' : mon_number_hrs , 'mon_start_lunch' : mon_start_lunch , 'mon_finish_lunch' : mon_finish_lunch , 'mon_lunch_number_hrs' : mon_lunch_number_hrs, 'tue_start' : tue_start , 'tue_finish' : tue_finish , 'tue_number_hrs' : tue_number_hrs , 'tue_start_lunch' : tue_start_lunch , 'tue_finish_lunch' : tue_finish_lunch , 'tue_lunch_number_hrs' : tue_lunch_number_hrs , 'wed_start' : wed_start , 'wed_finish' : wed_finish , 'wed_number_hrs' : wed_number_hrs , 'wed_start_lunch' : wed_start_lunch , 'wed_finish_lunch' : wed_finish_lunch , 'wed_lunch_number_hrs' : wed_lunch_number_hrs, 'thu_start' : thu_start , 'thu_finish' : thu_finish , 'thu_number_hrs' : thu_number_hrs , 'thu_start_lunch' : thu_start_lunch , 'thu_finish_lunch' : thu_finish_lunch , 'thu_lunch_number_hrs' : thu_lunch_number_hrs, 'fri_start' : fri_start , 'fri_finish' : fri_finish , 'fri_number_hrs' : fri_number_hrs , 'fri_start_lunch' : fri_start_lunch , 'fri_finish_lunch' : fri_finish_lunch , 'fri_lunch_number_hrs' : fri_lunch_number_hrs, 'sat_start' : sat_start , 'sat_finish' : sat_finish , 'sat_number_hrs' : sat_number_hrs , 'sat_start_lunch' : sat_start_lunch , 'sat_finish_lunch' : sat_finish_lunch , 'sat_lunch_number_hrs' : sat_lunch_number_hrs, 'sun_start' : sun_start , 'sun_finish' : sun_finish , 'sun_number_hrs' : sun_number_hrs , 'sun_start_lunch' : sun_start_lunch , 'sun_finish_lunch' : sun_finish_lunch , 'sun_lunch_number_hrs' : sun_lunch_number_hrs});
	
	//log(query);
	$('create_btn').value = 'Creating...';
	$('create_btn').disabled = true;
	var result = doXHR(PATH + 'CreateNewTempContract/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessCreateNewTempContract, OnFailCreateNewTempContract);
}

function OnSuccessCreateNewTempContract(e){
	if(e.responseText == 'ok'){
		alert('New Temp Staff contract created.');
		location.href=PATH +"/temp_contracts";
	}else{
	    alert(e.responseText);
	    $('create_btn').value = 'Create New';
	    $('create_btn').disabled = false;
	}
}
function OnFailCreateNewTempContract(e){
	alert("There's a problem in creating new temp contract.");
	$('create_btn').value = 'Create New';
	$('create_btn').disabled = false;
}


function GetClientCurrencySetting(e){
	var leads_id = $('leads_id').value;
	var staff_currency_id = $('staff_currency_id').value;
	
	if(leads_id != ""){
	    var query = queryString({'leads_id': leads_id, 'staff_currency_id' : staff_currency_id});
	    //log(query);
	    var result = doXHR(PATH + 'GetClientCurrencySetting/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessGetClientCurrencySetting, OnFailGetClientCurrencySetting);
	}
	
}

function OnSuccessGetClientCurrencySetting(e){
	//log(e.responseText);
	$('staff_working_schedules_result').innerHTML=e.responseText;
	var currency = getNodeAttribute($('currency_settings_result'), 'currency');
	var prepaid = getNodeAttribute($('currency_settings_result'), 'prepaid');
	var currency_rate = getNodeAttribute($('currency_settings_result'), 'currency_rate');
	var client_docs_count = getNodeAttribute($('currency_settings_result'), 'client_docs_count');
	
	$('prepaid').value = prepaid;
	$('prepaid_str').innerHTML = prepaid;
	$('currency').value = currency;
	$('current_rate').value = currency_rate;
	
	$('currency').disabled = false;
	if(client_docs_count > 0){
		$('currency').disabled = true;
	}

    
}
function OnFailGetClientCurrencySetting(e){
	alert("There's a problem in parsing client's currency setting.");
}

function UpdateReason(e){
	var subcon_id = $('subcon_id').value;
	var status = $('status').value;
	var service_type = $('service_type').value;
	var reason_type = $('reason_type').value;
	var replacement_request = $('replacement_request').value;
	var admin_notes = $('admin_notes').value;
	
	
	if(admin_notes == ""){
		alert('Please enter a reason in cancelling contract.');
		return false;
	}
	
	var query = queryString({'subcon_id': subcon_id, 'status' : status, 'service_type' : service_type, 'reason_type' : reason_type, 'replacement_request' : replacement_request, 'reason' : admin_notes});
	log(query);
	
	$('update_reason_btn').value='Updating...';
	$('update_reason_btn').disabled=true;
	$('delete_btn').disabled=true;
	
	var result = doXHR(PATH + 'UpdateReason/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateReason, OnFailUpdateReason);
}

function OnSuccessUpdateReason(e){
	if(isNaN(e.responseText)==true){
		alert(e.responseText);
		//alert("Failed in updating.");
		$('update_reason_btn').value='Update Reason';
	    $('update_reason_btn').disabled=false;
	    $('delete_btn').disabled=false;
	}else{
		//alert("Staff Contract Cancelled.");
		var subcon_id = e.responseText;
	    location.href=PATH +'subcon/'+subcon_id;
	}
}
function OnFailUpdateReason(e){
	alert("There's a problem in updating reason.");
	$('update_reason_btn').value='Update Reason';
	$('update_reason_btn').disabled=false;
	$('delete_btn').disabled=false;
}



function ActivateSuspendedStaffContract(e){
	var subcon_id = $('subcon_id').value;
	var admin_notes = $('admin_notes').value;
	
	var query = queryString({'subcon_id': subcon_id, 'admin_notes' : admin_notes});
	log(query);
	
	if(confirm("Activate contract?")){
	    $('activate_contract_btn').value="Activating...";
	    $('activate_contract_btn').disabled=true;
		$('delete_btn').disabled=true;
	    var result = doXHR(PATH + 'ActivateSuspendedStaffContract/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessActivateSuspendedStaffContract, OnFailActivateSuspendedStaffContract);
	}
}

function OnSuccessActivateSuspendedStaffContract(e){
	if(isNaN(e.responseText)==true){
		alert(e.responseText);
		$('activate_contract_btn').value="Activate Contract";
	    $('activate_contract_btn').disabled=false;
		$('delete_btn').disabled=false;
	}else{
		alert("Staff Contract Activated.");
		var subcon_id = e.responseText;
	    location.href=PATH +'subcon/'+subcon_id;
	}
}
function OnFailActivateSuspendedStaffContract(e){
	alert("There's a problem in activating suspended staff contract.");
	$('activate_contract_btn').value="Activate Contract";
	$('activate_contract_btn').disabled=false;
	$('delete_btn').disabled=false;
}

function TerminateResignStaffContract(e){
	var subcon_id = $('subcon_id').value;
	location.href=PATH+'contract_cancellation/'+subcon_id;
}

function CancelContract(e){
	var subcon_id = $('subcon_id').value;
	var status = $('status').value;
	var end_date = $('end_date').value;
	var service_type = $('service_type').value;
	var reason_type = $('reason_type').value;
	var replacement_request = $('replacement_request').value;
	var admin_notes = $('admin_notes').value;
	
	
	if(admin_notes == ""){
		alert('Please enter a reason in cancelling contract.');
		return false;
	}
	
	var query = queryString({'subcon_id': subcon_id, 'status' : status, 'end_date' : end_date, 'service_type' : service_type, 'reason_type' : reason_type, 'replacement_request' : replacement_request, 'admin_notes' : admin_notes});
	//log(query);
	
	if(confirm("Cancel contract?")){
	    $('cancel_contract_btn').value="Cancelling...";
	    $('cancel_contract_btn').disabled=true;
	    var result = doXHR(PATH + 'CancelContract/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessCancelContract, OnFailCancelContract);
	}
	
	
}

function OnSuccessCancelContract(e){
	if(isNaN(e.responseText)==true){
		alert(e.responseText);
		$('cancel_contract_btn').value="Cancel Contract";
	    $('cancel_contract_btn').disabled=false;
	}else{
		alert("Staff Contract Cancelled.");
		var subcon_id = e.responseText;
	    location.href=PATH +'subcon/'+subcon_id;
	}
}

function OnFailCancelContract(e){
	alert("There's a problem in cancelling staff contract");
	$('cancel_contract_btn').value="Cancel Contract";
	$('cancel_contract_btn').disabled=false;
}


function CheckContractStatus(){
	var contract_status = $('contract_status').value;
	if (contract_status == 'deleted'){
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
	
	if (contract_status == 'resigned' || contract_status == 'terminated'){
		var inputs=document.getElementsByTagName('input');
        for(i=0;i<inputs.length;i++){
            inputs[i].disabled=true;
        }
		var selects=document.getElementsByTagName('select');
        for(i=0;i<selects.length;i++){
            selects[i].disabled=true;
        }
		
		$('service_type').disabled=false;
		$('status').disabled=false;
		$('reason_type').disabled=false;
		$('replacement_request').disabled=false;
		$('update_reason_btn').disabled=false;
		$('delete_btn').disabled=false;
	}
	
	if (contract_status == 'suspended'){
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
		
		$('activate_contract_btn').disabled=false;
		$('delete_btn').disabled=false;
		$('admin_notes').disabled=false;
		
	}
	
	if (contract_status == 'create'){
		ConfigureStaffSchedule();
	}
	
	if (contract_status == 'new'){
		var work_status = $('work_status').value;
		var work_days = $('work_days').value;
	    work_days = work_days.split(',')
	
	    for(i=0;i<WEEKDAYS.length;i++){
		    if(inArray(WEEKDAYS[i], work_days)){
				/*
		        $(WEEKDAYS[i]+'_start').value = staff_start_work_hour;
		        $(WEEKDAYS[i]+'_finish').value = staff_finish_work_hour;
	            $(WEEKDAYS[i]+'_number_hrs').value =  time_difference;
			
			    $(WEEKDAYS[i]+'_start_lunch').value = staff_start_lunch;
	            $(WEEKDAYS[i]+'_finish_lunch').value = staff_finish_lunch;
	            $(WEEKDAYS[i]+'_lunch_number_hrs').value =  lunch_time_difference;
			    */
			    if(work_status == 'Full-Time' ){
				    $(WEEKDAYS[i]+'_start_lunch').disabled = false;
	                $(WEEKDAYS[i]+'_finish_lunch').disabled = false;
	                $(WEEKDAYS[i]+'_lunch_number_hrs').disabled = false;
			    }else{
				    $(WEEKDAYS[i]+'_start_lunch').disabled = true;
	                $(WEEKDAYS[i]+'_finish_lunch').disabled = true;
	                $(WEEKDAYS[i]+'_lunch_number_hrs').disabled = true;
			    }
		    }
	    }
	}
	
	if (contract_status == 'ACTIVE' || contract_status == 'updated'){
		var work_status = $('work_status').value;
		var work_days = $('work_days').value;
	    work_days = work_days.split(',')
	
	    for(i=0;i<WEEKDAYS.length;i++){
		    if(inArray(WEEKDAYS[i], work_days)){
			    if(work_status == 'Full-Time' ){
				    $(WEEKDAYS[i]+'_start_lunch').disabled = false;
	                $(WEEKDAYS[i]+'_finish_lunch').disabled = false;
	                $(WEEKDAYS[i]+'_lunch_number_hrs').disabled = false;
			    }else{
				    $(WEEKDAYS[i]+'_start_lunch').disabled = true;
	                $(WEEKDAYS[i]+'_finish_lunch').disabled = true;
	                $(WEEKDAYS[i]+'_lunch_number_hrs').disabled = true;
			    }
		    }
	    }
	}
	
	log(contract_status);
}
function ApproveUpdatedStaffContract(e){
	var subcon_id = $('subcon_id').value;
	var email = $('email').value;
	var initial_email_password = $('initial_email_password').value;
	var initial_skype_password = $('initial_skype_password').value;
	var skype_id = $('skype_id').value;	
	
	
	var prepaid = $('prepaid').value;
	var leads_id = $('leads_id').value;
	var staff_currency_id = $('staff_currency_id').value;
	
	var job_designation = $('job_designation').value;			
	var work_status = $('work_status').value;
	
	var php_monthly = $('php_monthly').value;
	var currency = $('currency').value;
	var client_price = $('client_price').value;
	var client_price_effective_date = $('client_price_effective_date').value;
	
	var staff_other_client_email = $('staff_other_client_email').value;
	var staff_other_client_email_password = $('staff_other_client_email_password').value;
	var overtime = $('overtime').value;
	var overtime_monthly_limit = $('overtime_monthly_limit').value;
	var starting_date = $('starting_date').value;
	var staff_working_timezone = $('staff_working_timezone').value;
	var client_timezone = $('client_timezone').value;
	var client_start_work_hour = $('client_start_work_hour').value;
	var client_finish_work_hour = $('client_finish_work_hour').value;
	var flexi = $('flexi').value;
	var service_type = $('service_type').value;
	var work_days = $('work_days').value;
	
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
		
	var admin_notes = $('admin_notes').value;
	var with_bp_comm = $('with_bp_comm').value;
	var with_aff_comm = $('with_aff_comm').value;
	var current_rate = $('current_rate').value;
	
	if (overtime_monthly_limit == ""){
		overtime_monthly_limit = 0;
	}
	
	var query = queryString({'subcon_id': subcon_id, 'prepaid' : prepaid, 'job_designation' : job_designation, 'email' : email, 'leads_id' : leads_id, 'initial_email_password' : initial_email_password, 'work_status' : work_status, 'staff_currency_id' : staff_currency_id, 'php_monthly' : php_monthly, 'currency' : currency, 'client_price' : client_price, 'client_price_effective_date' : client_price_effective_date,  'skype_id' : skype_id, 'initial_skype_password' : initial_skype_password, 'staff_other_client_email' : staff_other_client_email, 'staff_other_client_email_password' : staff_other_client_email_password, 'overtime' : overtime, 'overtime_monthly_limit' : overtime_monthly_limit, 'starting_date' : starting_date, 'staff_working_timezone' : staff_working_timezone, 'client_timezone' : client_timezone, 'client_start_work_hour' : client_start_work_hour, 'client_finish_work_hour' : client_finish_work_hour, 'flexi' : flexi, 'service_type' : service_type, 'admin_notes' : admin_notes, 'work_days' : work_days, 'with_bp_comm' : with_bp_comm, 'with_aff_comm' : with_aff_comm, 'current_rate' : current_rate, 'mon_start' : mon_start , 'mon_finish' : mon_finish , 'mon_number_hrs' : mon_number_hrs , 'mon_start_lunch' : mon_start_lunch , 'mon_finish_lunch' : mon_finish_lunch , 'mon_lunch_number_hrs' : mon_lunch_number_hrs, 'tue_start' : tue_start , 'tue_finish' : tue_finish , 'tue_number_hrs' : tue_number_hrs , 'tue_start_lunch' : tue_start_lunch , 'tue_finish_lunch' : tue_finish_lunch , 'tue_lunch_number_hrs' : tue_lunch_number_hrs , 'wed_start' : wed_start , 'wed_finish' : wed_finish , 'wed_number_hrs' : wed_number_hrs , 'wed_start_lunch' : wed_start_lunch , 'wed_finish_lunch' : wed_finish_lunch , 'wed_lunch_number_hrs' : wed_lunch_number_hrs, 'thu_start' : thu_start , 'thu_finish' : thu_finish , 'thu_number_hrs' : thu_number_hrs , 'thu_start_lunch' : thu_start_lunch , 'thu_finish_lunch' : thu_finish_lunch , 'thu_lunch_number_hrs' : thu_lunch_number_hrs, 'fri_start' : fri_start , 'fri_finish' : fri_finish , 'fri_number_hrs' : fri_number_hrs , 'fri_start_lunch' : fri_start_lunch , 'fri_finish_lunch' : fri_finish_lunch , 'fri_lunch_number_hrs' : fri_lunch_number_hrs, 'sat_start' : sat_start , 'sat_finish' : sat_finish , 'sat_number_hrs' : sat_number_hrs , 'sat_start_lunch' : sat_start_lunch , 'sat_finish_lunch' : sat_finish_lunch , 'sat_lunch_number_hrs' : sat_lunch_number_hrs, 'sun_start' : sun_start , 'sun_finish' : sun_finish , 'sun_number_hrs' : sun_number_hrs , 'sun_start_lunch' : sun_start_lunch , 'sun_finish_lunch' : sun_finish_lunch , 'sun_lunch_number_hrs' : sun_lunch_number_hrs});
	
	//log(query);
	
	if(confirm("Approve updated staff contract?")){
	    $('approve_updated_contract_btn').value="Approving...";
	    $('approve_updated_contract_btn').disabled=true;
	    $('delete_updated_contract_btn').disabled=true;
	    var result = doXHR(PATH + 'ApproveUpdatedStaffContract/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessApproveUpdatedStaffContract, OnFailApproveUpdatedStaffContract);
	}
}

function OnSuccessApproveUpdatedStaffContract(e){
	
	
	if(isNaN(e.responseText)==true){
		//alert("Failed in approving updated staff contract.");
		alert(e.responseText);
		$('approve_updated_contract_btn').value="Approve Updated Contract";
	    $('approve_updated_contract_btn').disabled=false;
	    $('delete_updated_contract_btn').disabled=false;
	}else{
		alert("Updated Successfully.");
		var subcon_id = e.responseText;
	    location.href=PATH +'subcon/'+subcon_id;
	}
	
}

function OnFailApproveUpdatedStaffContract(e){
	alert("There's a problem in updating modified staff contract.");
	$('approve_updated_contract_btn').value="Approve Updated Contract";
	$('approve_updated_contract_btn').disabled=false;
	$('delete_updated_contract_btn').disabled=false;
}

function DeleteUpdatedStaffContract(e){
	var subcon_id = $('subcon_id').value;
	var email = $('email').value;
	var initial_email_password = $('initial_email_password').value;
	var initial_skype_password = $('initial_skype_password').value;
	var skype_id = $('skype_id').value;	
	
	
	var prepaid = $('prepaid').value;
	var leads_id = $('leads_id').value;
	var staff_currency_id = $('staff_currency_id').value;
	
	var job_designation = $('job_designation').value;			
	var work_status = $('work_status').value;
	
	var php_monthly = $('php_monthly').value;
	var currency = $('currency').value;
	var client_price = $('client_price').value;
	var client_price_effective_date = $('client_price_effective_date').value;
	
	var staff_other_client_email = $('staff_other_client_email').value;
	var staff_other_client_email_password = $('staff_other_client_email_password').value;
	var overtime = $('overtime').value;
	var overtime_monthly_limit = $('overtime_monthly_limit').value;
	var starting_date = $('starting_date').value;
	var staff_working_timezone = $('staff_working_timezone').value;
	var client_timezone = $('client_timezone').value;
	var client_start_work_hour = $('client_start_work_hour').value;
	var client_finish_work_hour = $('client_finish_work_hour').value;
	var flexi = $('flexi').value;
	var service_type = $('service_type').value;
	var work_days = $('work_days').value;
	
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
		
	var admin_notes = $('admin_notes').value;
	var with_bp_comm = $('with_bp_comm').value;
	var with_aff_comm = $('with_aff_comm').value;
	var current_rate = $('current_rate').value;
	
	if (overtime_monthly_limit == ""){
		overtime_monthly_limit = 0;
	}
	
	
	var query = queryString({'subcon_id': subcon_id, 'prepaid' : prepaid, 'job_designation' : job_designation, 'email' : email, 'leads_id' : leads_id, 'initial_email_password' : initial_email_password, 'work_status' : work_status, 'staff_currency_id' : staff_currency_id, 'php_monthly' : php_monthly, 'currency' : currency, 'client_price' : client_price, 'client_price_effective_date' : client_price_effective_date,  'skype_id' : skype_id, 'initial_skype_password' : initial_skype_password, 'staff_other_client_email' : staff_other_client_email, 'staff_other_client_email_password' : staff_other_client_email_password, 'overtime' : overtime, 'overtime_monthly_limit' : overtime_monthly_limit, 'starting_date' : starting_date, 'staff_working_timezone' : staff_working_timezone, 'client_timezone' : client_timezone, 'client_start_work_hour' : client_start_work_hour, 'client_finish_work_hour' : client_finish_work_hour, 'flexi' : flexi, 'service_type' : service_type, 'admin_notes' : admin_notes, 'work_days' : work_days, 'with_bp_comm' : with_bp_comm, 'with_aff_comm' : with_aff_comm, 'current_rate' : current_rate, 'mon_start' : mon_start , 'mon_finish' : mon_finish , 'mon_number_hrs' : mon_number_hrs , 'mon_start_lunch' : mon_start_lunch , 'mon_finish_lunch' : mon_finish_lunch , 'mon_lunch_number_hrs' : mon_lunch_number_hrs, 'tue_start' : tue_start , 'tue_finish' : tue_finish , 'tue_number_hrs' : tue_number_hrs , 'tue_start_lunch' : tue_start_lunch , 'tue_finish_lunch' : tue_finish_lunch , 'tue_lunch_number_hrs' : tue_lunch_number_hrs , 'wed_start' : wed_start , 'wed_finish' : wed_finish , 'wed_number_hrs' : wed_number_hrs , 'wed_start_lunch' : wed_start_lunch , 'wed_finish_lunch' : wed_finish_lunch , 'wed_lunch_number_hrs' : wed_lunch_number_hrs, 'thu_start' : thu_start , 'thu_finish' : thu_finish , 'thu_number_hrs' : thu_number_hrs , 'thu_start_lunch' : thu_start_lunch , 'thu_finish_lunch' : thu_finish_lunch , 'thu_lunch_number_hrs' : thu_lunch_number_hrs, 'fri_start' : fri_start , 'fri_finish' : fri_finish , 'fri_number_hrs' : fri_number_hrs , 'fri_start_lunch' : fri_start_lunch , 'fri_finish_lunch' : fri_finish_lunch , 'fri_lunch_number_hrs' : fri_lunch_number_hrs, 'sat_start' : sat_start , 'sat_finish' : sat_finish , 'sat_number_hrs' : sat_number_hrs , 'sat_start_lunch' : sat_start_lunch , 'sat_finish_lunch' : sat_finish_lunch , 'sat_lunch_number_hrs' : sat_lunch_number_hrs, 'sun_start' : sun_start , 'sun_finish' : sun_finish , 'sun_number_hrs' : sun_number_hrs , 'sun_start_lunch' : sun_start_lunch , 'sun_finish_lunch' : sun_finish_lunch , 'sun_lunch_number_hrs' : sun_lunch_number_hrs});
	
	log(query)
	//return false;
	if(confirm("Cancel updates?")){
	    $('delete_updated_contract_btn').value="Cancelling updates...";
	    $('delete_updated_contract_btn').disabled=true;
	    $('approve_updated_contract_btn').disabled=true;	
	    var result = doXHR(PATH + 'DeleteUpdatedStaffContract/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessDeleteUpdatedStaffContract, OnFailDeleteUpdatedStaffContract);
	}
}

function OnSuccessDeleteUpdatedStaffContract(e){
    //alert(e.responseText);
	
	if(isNaN(e.responseText)==true){
		alert("Failed in cancelling updated staff contract.");
		$('delete_updated_contract_btn').value="Cancel Updated Contract";
	    $('approve_updated_contract_btn').disabled=false;
	    $('delete_updated_contract_btn').disabled=false;
	}else{
		alert("Staff Contract changes cancelled.");
		var subcon_id = e.responseText;
	    location.href=PATH +'subcon/'+subcon_id;
	}
	
}

function OnFailDeleteUpdatedStaffContract(e){
	alert("There's a problem in cancelling updated staff contract.");
	$('delete_updated_contract_btn').value="Cancel Updated Contract";
	$('approve_updated_contract_btn').disabled=false;
	$('delete_updated_contract_btn').disabled=false;
}

function UpdateStaffContract(e){
	
	var subcon_id = $('subcon_id').value;
	var email = $('email').value;
	var initial_email_password = $('initial_email_password').value;
	var initial_skype_password = $('initial_skype_password').value;
	var skype_id = $('skype_id').value;	
	
	
	var prepaid = $('prepaid').value;
	var leads_id = $('leads_id').value;
	var staff_currency_id = $('staff_currency_id').value;
	
	var job_designation = $('job_designation').value;			
	var work_status = $('work_status').value;
	
	var php_monthly = $('php_monthly').value;
	var currency = $('currency').value;
	var client_price = $('client_price').value;
	var client_price_effective_date = $('client_price_effective_date').value;
	
	var staff_other_client_email = $('staff_other_client_email').value;
	var staff_other_client_email_password = $('staff_other_client_email_password').value;
	var overtime = $('overtime').value;
	var overtime_monthly_limit = $('overtime_monthly_limit').value;
	var starting_date = $('starting_date').value;
	var staff_working_timezone = $('staff_working_timezone').value;
	var client_timezone = $('client_timezone').value;
	var client_start_work_hour = $('client_start_work_hour').value;
	var client_finish_work_hour = $('client_finish_work_hour').value;
	var flexi = $('flexi').value;
	var service_type = $('service_type').value;
	var work_days = $('work_days').value;
	
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
		
	var admin_notes = $('admin_notes').value;
	var with_bp_comm = $('with_bp_comm').value;
	var with_aff_comm = $('with_aff_comm').value;
	var current_rate = $('current_rate').value;
	
	if (overtime_monthly_limit == ""){
		overtime_monthly_limit = 0;
	}
	
	var query = queryString({'subcon_id': subcon_id, 'prepaid' : prepaid, 'job_designation' : job_designation, 'email' : email, 'leads_id' : leads_id, 'initial_email_password' : initial_email_password, 'work_status' : work_status, 'staff_currency_id' : staff_currency_id, 'php_monthly' : php_monthly, 'currency' : currency, 'client_price' : client_price, 'client_price_effective_date' : client_price_effective_date,  'skype_id' : skype_id, 'initial_skype_password' : initial_skype_password, 'staff_other_client_email' : staff_other_client_email, 'staff_other_client_email_password' : staff_other_client_email_password, 'overtime' : overtime, 'overtime_monthly_limit' : overtime_monthly_limit, 'starting_date' : starting_date, 'staff_working_timezone' : staff_working_timezone, 'client_timezone' : client_timezone, 'client_start_work_hour' : client_start_work_hour, 'client_finish_work_hour' : client_finish_work_hour, 'flexi' : flexi, 'service_type' : service_type, 'admin_notes' : admin_notes, 'work_days' : work_days, 'with_bp_comm' : with_bp_comm, 'with_aff_comm' : with_aff_comm, 'current_rate' : current_rate, 'mon_start' : mon_start , 'mon_finish' : mon_finish , 'mon_number_hrs' : mon_number_hrs , 'mon_start_lunch' : mon_start_lunch , 'mon_finish_lunch' : mon_finish_lunch , 'mon_lunch_number_hrs' : mon_lunch_number_hrs, 'tue_start' : tue_start , 'tue_finish' : tue_finish , 'tue_number_hrs' : tue_number_hrs , 'tue_start_lunch' : tue_start_lunch , 'tue_finish_lunch' : tue_finish_lunch , 'tue_lunch_number_hrs' : tue_lunch_number_hrs , 'wed_start' : wed_start , 'wed_finish' : wed_finish , 'wed_number_hrs' : wed_number_hrs , 'wed_start_lunch' : wed_start_lunch , 'wed_finish_lunch' : wed_finish_lunch , 'wed_lunch_number_hrs' : wed_lunch_number_hrs, 'thu_start' : thu_start , 'thu_finish' : thu_finish , 'thu_number_hrs' : thu_number_hrs , 'thu_start_lunch' : thu_start_lunch , 'thu_finish_lunch' : thu_finish_lunch , 'thu_lunch_number_hrs' : thu_lunch_number_hrs, 'fri_start' : fri_start , 'fri_finish' : fri_finish , 'fri_number_hrs' : fri_number_hrs , 'fri_start_lunch' : fri_start_lunch , 'fri_finish_lunch' : fri_finish_lunch , 'fri_lunch_number_hrs' : fri_lunch_number_hrs, 'sat_start' : sat_start , 'sat_finish' : sat_finish , 'sat_number_hrs' : sat_number_hrs , 'sat_start_lunch' : sat_start_lunch , 'sat_finish_lunch' : sat_finish_lunch , 'sat_lunch_number_hrs' : sat_lunch_number_hrs, 'sun_start' : sun_start , 'sun_finish' : sun_finish , 'sun_number_hrs' : sun_number_hrs , 'sun_start_lunch' : sun_start_lunch , 'sun_finish_lunch' : sun_finish_lunch , 'sun_lunch_number_hrs' : sun_lunch_number_hrs});

	log(query);
	//return false;
	$('update_btn').value="Updating...";
	$('update_btn').disabled=true;
	$('cancel_btn').disabled=true;
	$('delete_btn').disabled=true;
	
	var result = doXHR(PATH + 'UpdateStaffContract/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateStaffContract, OnFailUpdateStaffContract);
	
}
function OnSuccessUpdateStaffContract(e){
	if(e.responseText == 'ok'){
		alert("Successfully modified.\nAll modified staff contracts are subject for Admin approval.");
		var subcon_id = $('subcon_id').value;
	    location.href=PATH +'subcon/'+subcon_id; 
	}else{
	    //$('debug').innerHTML=e.responseText;
		alert(e.responseText);
		$('update_btn').value="Update Contract";
	    $('update_btn').disabled=false;
	    $('cancel_btn').disabled=false;
	    $('delete_btn').disabled=false;
	}
}

function OnFailUpdateStaffContract(e){
	alert("Failed to update staff contract.");
	$('update_btn').value="Update Contract";
	$('update_btn').disabled=false;
	$('cancel_btn').disabled=false;
	$('delete_btn').disabled=false;
}

function DeleteStaffContract(e){
	var subcon_id = $('subcon_id').value;
	var admin_notes = $('admin_notes').value;
		
	var query = queryString({'subcon_id': subcon_id, 'admin_notes' : admin_notes});
    //log(query);
	

    if(confirm('Delete contract?')){
		$('delete_btn').value="Deleting contract...";
	    $('delete_btn').disabled=true;
		if($('update_btn')){
	        $('update_btn').disabled=true;
		}
		if($('cancel_btn')){
	        $('cancel_btn').disabled=true;
		}
		if($('update_reason_btn')){
	        $('update_reason_btn').disabled=true;
		}
		if($('activate_contract_btn')){
	        $('activate_contract_btn').disabled=true;
		}
		
		var result = doXHR(PATH + 'DeleteStaffContract/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessDeleteStaffContract, OnFailDeleteStaffContract);
	}
}

function OnSuccessDeleteStaffContract(e){
	//alert(e.responseText);
	if(isNaN(e.responseText)==true){
		alert(e.responseText);
		$('delete_btn').value="Delete Contract";
	    $('delete_btn').disabled=false;
		if($('update_btn')){
	        $('update_btn').disabled=false;
		}
		if($('cancel_btn')){
	        $('cancel_btn').disabled=false;
		}
		if($('update_reason_btn')){
	        $('update_reason_btn').disabled=false;
		}
		
		if($('activate_contract_btn')){
	        $('activate_contract_btn').disabled=false;
		}
	    
	}else{
		alert("Staff Contract deleted.");
		var subcon_id = e.responseText;
	    location.href=PATH +'subcon/'+subcon_id;
	}
}
function OnFailDeleteStaffContract(e){
	alert("There's a problem in deleting staff contract.");
	$('delete_btn').value="Delete Contract";
	$('delete_btn').disabled=false;
	if($('update_btn')){
	    $('update_btn').disabled=false;
    }
	if($('cancel_btn')){
	    $('cancel_btn').disabled=false;
	}
	if($('update_reason_btn')){
	    $('update_reason_btn').disabled=false;
	}
}




function ShowHideHistory(e){
	var history_id =getNodeAttribute(e.src(), 'history_id');
	toggle(history_id+"_hist_details");
}
function formatNumber(num){
	var num = Math.round(num*100)/100;
	return num;
}

function GetHourlyRate(e){
	var obj = getNodeAttribute(e.src(), 'id');
	ConfigurePrice(obj);
}
function ConfigurePrice(obj){
	
	var work_status = $('work_status').value;
	var price = $(obj).value;

	if(work_status == 'Part-Time'){
	    var hour = 4;
    }else{
		var hour = 8;
	}

    var yearly = parseFloat(price)*12;
    var weekly = (parseFloat(price)*12)/52;
	var daily =  ((parseFloat(price)*12)/52)/5;
	var hourly = (((parseFloat(price)*12)/52)/5)/hour;
	$(obj+'_str').innerHTML = "<span class='y'>Yearly : "+formatNumber(yearly)+"</span><span class='m'>Monthly : "+ formatNumber(price)+ "</span><span class='w'>Weekly : " + formatNumber(weekly)+ "</span><span class='d'>Daily : "+ formatNumber(daily) +"</span><span class='h'>Hourly : "+formatNumber(hourly)+"</span>";
		
}

function GetRevenue(){
	var client_price = $('client_price').value;
	var php_monthly = $('php_monthly').value;
	var current_rate = $('current_rate').value;
	var with_bp_comm = $('with_bp_comm').value;
	var with_aff_comm = $('with_aff_comm').value;
	
	var aff_commission = 0;
	var with_bp_commission=0;
	var net = 0;
	var margin=0;
	var margin = ( client_price - (parseFloat(php_monthly) / current_rate )) ;
	
	
	if(with_aff_comm == "YES") { //the affiliate can have a 5% commission
		aff_commission = ((client_price/100) * AFF_COMM);
	}
	if(with_bp_comm == "YES") { //the business partner can have a 15% commission
		with_bp_commission = (((margin - aff_commission)/100)*BP_COMM);
	}
	
	net = (margin - aff_commission) - with_bp_commission;
	//log(formatNumber(margin));
	
	$('rev').innerHTML = formatNumber(margin);
	$('bp_percent').innerHTML = formatNumber(with_bp_commission);
	$('aff_percent').innerHTML = formatNumber(aff_commission);
	$('net').innerHTML = formatNumber(net);
	
}

function GetTimeDifference(e){
	var mode = getNodeAttribute(e.src(), 'mode');
	var weekday = getNodeAttribute(e.src(), 'weekday');
    var work_status = $('work_status').value;
	
	if(mode=='regular'){
	    var start_time = $(weekday+'_start').value;
	    var finish_time = $(weekday+'_finish').value;
		var number_hrs = $(weekday+'_number_hrs');
	}else{
		var start_time = $(weekday+'_start_lunch').value;
	    var finish_time = $(weekday+'_finish_lunch').value;
		var number_hrs = $(weekday+'_lunch_number_hrs');
	}
	var query = queryString({'mode': mode, 'weekday' : weekday, 'start_time' : start_time, 'finish_time' : finish_time, 'work_status' : work_status});
	//log(query);
	if(start_time && finish_time){
	    var result = doXHR(PATH + 'GetTimeDifference/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	    result.addCallbacks(OnSuccessGetTimeDifference, OnFailGetTimeDifference);
	}else{
		number_hrs.value="0.00";
	}
	
}
function OnSuccessGetTimeDifference(e){
	$('staff_working_schedules_result').innerHTML=e.responseText;
	
	var time_difference = getNodeAttribute($('staff_working_schedules_result_value'), 'time_difference');
	var mode = getNodeAttribute($('staff_working_schedules_result_value'), 'mode');
	var weekday = getNodeAttribute($('staff_working_schedules_result_value'), 'weekday');
	
	if(mode=='regular'){
		var number_hrs = $(weekday+'_number_hrs');
	}else{
		var number_hrs = $(weekday+'_lunch_number_hrs');
	}
	number_hrs.value=time_difference;
	
	DisplayWorkingHoursDaysBreakTime();
}
function OnFailGetTimeDifference(e){
	alert(e.responseText);
}

function CheckUncheck(obj){
	var weekday = obj.value;
	if(obj.checked==true) {
		ConfigureStaffSelectedDaySchedule(weekday);
		$(weekday+'_start').disabled=false;
		$(weekday+'_finish').disabled=false;
	    $(weekday+'_number_hrs').disabled=false;
			
		$(weekday+'_start_lunch').disabled=false;
	    $(weekday+'_finish_lunch').disabled=false;
	    $(weekday+'_lunch_number_hrs').disabled=false;
	}else{
		$(weekday+'_start').value="";
		$(weekday+'_finish').value="";
	    $(weekday+'_number_hrs').value="0.00";
		
		$(weekday+'_start_lunch').value="";
	    $(weekday+'_finish_lunch').value="";
	    $(weekday+'_lunch_number_hrs').value="0.00";
		
		$(weekday+'_start').disabled=true;
		$(weekday+'_finish').disabled=true;
	    $(weekday+'_number_hrs').disabled=true;
			
		$(weekday+'_start_lunch').disabled=true;
	    $(weekday+'_finish_lunch').disabled=true;
	    $(weekday+'_lunch_number_hrs').disabled=true;
	}
	DisplayWorkingHoursDaysBreakTime();
}
function CheckedUncheckedWeekday(e){
	var ins = document.getElementsByName('weekday')
	var i;
	var j=0;
	var vals= new Array();
	for(i=0;i<ins.length;i++)
	{
		if(ins[i].checked==true) {
			vals[j]=ins[i].value;
			j++;
		}
	}
	$('work_days').value=(vals);
	//ConfigureStaffSchedule();
}
function CheckIfFlexi(){
	//if staff contract is in flexi disable weekdays and time select boxes
	var work_days = $('work_days').value;
	var flexi = $('flexi').value;
	work_days = work_days.split(',')
	
	var ins = document.getElementsByName('weekday');
	var i;
	/*
	if(flexi == 'yes'){
		//disable and uncheck checkboxes
		for(i=0;i<ins.length;i++){
			ins[i].disabled=true;
			ins[i].checked=false;
	    }
		
		//disable time select boxes
		for(i=0;i<WEEKDAYS.length;i++){
		    $(WEEKDAYS[i]+'_start').disabled=true;
		    $(WEEKDAYS[i]+'_finish').disabled=true;
	        $(WEEKDAYS[i]+'_number_hrs').disabled=true;
			
			$(WEEKDAYS[i]+'_start_lunch').disabled=true;
	        $(WEEKDAYS[i]+'_finish_lunch').disabled=true;
	        $(WEEKDAYS[i]+'_lunch_number_hrs').disabled=true;
			
			$(WEEKDAYS[i]+'_start').value="";
		    $(WEEKDAYS[i]+'_finish').value="";
	        $(WEEKDAYS[i]+'_number_hrs').value="";
			
			$(WEEKDAYS[i]+'_start_lunch').value="";
	        $(WEEKDAYS[i]+'_finish_lunch').value="";
	        $(WEEKDAYS[i]+'_lunch_number_hrs').value="";
	    }
	}else{
	*/	
		//disable and uncheck checkboxes
		for(i=0;i<ins.length;i++){
			ins[i].disabled=false;
			if(inArray(ins[i].value, work_days)){
			    ins[i].checked=true;
			}else{
				ins[i].checked=false;
			}
	    }
		
		//enable time select boxes
		for(i=0;i<WEEKDAYS.length;i++){
			
			
			if(inArray(WEEKDAYS[i], work_days)){
				$(WEEKDAYS[i]+'_start').disabled=false;
		        $(WEEKDAYS[i]+'_finish').disabled=false;
	            $(WEEKDAYS[i]+'_number_hrs').disabled=false;
			
			    $(WEEKDAYS[i]+'_start_lunch').disabled=false;
	            $(WEEKDAYS[i]+'_finish_lunch').disabled=false;
	            $(WEEKDAYS[i]+'_lunch_number_hrs').disabled=false;
			
			}else{
				$(WEEKDAYS[i]+'_start').value="";
		        $(WEEKDAYS[i]+'_finish').value="";
	            $(WEEKDAYS[i]+'_number_hrs').value="0.00";
			
			    $(WEEKDAYS[i]+'_start_lunch').value="";
	            $(WEEKDAYS[i]+'_finish_lunch').value="";
	            $(WEEKDAYS[i]+'_lunch_number_hrs').value="0.00";
				
				$(WEEKDAYS[i]+'_start').disabled=true;
		        $(WEEKDAYS[i]+'_finish').disabled=true;
	            $(WEEKDAYS[i]+'_number_hrs').disabled=true;
			
			    $(WEEKDAYS[i]+'_start_lunch').disabled=true;
	            $(WEEKDAYS[i]+'_finish_lunch').disabled=true;
	            $(WEEKDAYS[i]+'_lunch_number_hrs').disabled=true;
			}
	    }
		
		
	//}
}

function ConfigureStaffSelectedDaySchedule(weekday){
	var client_start_work_hour = $('client_start_work_hour').value;
	var client_finish_work_hour = $('client_finish_work_hour').value;
	var work_status = $('work_status').value;
	var staff_working_timezone = $('staff_working_timezone').value;
	var client_timezone = $('client_timezone').value;
	
	var query = queryString({'work_status': work_status, 'staff_working_timezone' : staff_working_timezone, 'client_timezone' : client_timezone, 'client_start_work_hour' : client_start_work_hour, 'client_finish_work_hour' : client_finish_work_hour, 'weekday' : weekday});
	//log(query);
	var result = doXHR(PATH + 'ConfigureStaffSelectedDaySchedule/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessConfigureStaffSelectedDaySchedule, OnFailConfigureStaffSelectedDaySchedule);
}

function OnSuccessConfigureStaffSelectedDaySchedule(e){
	$('staff_working_schedules_result').innerHTML=e.responseText;
	
	var staff_start_work_hour = getNodeAttribute($('staff_working_schedules_result_value'), 'staff_start_work_hour')
	var staff_finish_work_hour = getNodeAttribute($('staff_working_schedules_result_value'), 'staff_finish_work_hour');
	var time_difference = getNodeAttribute($('staff_working_schedules_result_value'), 'time_difference');
	
	var staff_start_lunch = getNodeAttribute($('staff_working_schedules_result_value'), 'staff_start_lunch');
	var staff_finish_lunch = getNodeAttribute($('staff_working_schedules_result_value'), 'staff_finish_lunch');
	var lunch_time_difference = getNodeAttribute($('staff_working_schedules_result_value'), 'lunch_time_difference');
	
	var weekday = getNodeAttribute($('staff_working_schedules_result_value'), 'weekday');
	var work_status = getNodeAttribute($('staff_working_schedules_result_value'), 'work_status');
	
	$(weekday+'_start').value = staff_start_work_hour;
    $(weekday+'_finish').value = staff_finish_work_hour;
	$(weekday+'_number_hrs').value =  time_difference;
		
	$(weekday+'_start_lunch').value = staff_start_lunch;
	$(weekday+'_finish_lunch').value = staff_finish_lunch;
	$(weekday+'_lunch_number_hrs').value =  lunch_time_difference;
	
	if(work_status == 'Full-Time' ){
		$(weekday+'_start_lunch').disabled = false;
	    $(weekday+'_finish_lunch').disabled = false;
	    $(weekday+'_lunch_number_hrs').disabled = false;
	}else{
		$(weekday+'_start_lunch').disabled = true;
	    $(weekday+'_finish_lunch').disabled = true;
	    $(weekday+'_lunch_number_hrs').disabled = true;
	}
	DisplayWorkingHoursDaysBreakTime();
}
function OnFailConfigureStaffSelectedDaySchedule(e){
	alert(e.responseText);
}
function ConfigureStaffSchedule(e){
	var work_status = $('work_status').value;
	var staff_working_timezone = $('staff_working_timezone').value;
	var client_timezone = $('client_timezone').value;
	var client_start_work_hour = $('client_start_work_hour').value;
	var flexi = $('flexi').value;
	var query = queryString({'work_status': work_status, 'staff_working_timezone' : staff_working_timezone, 'client_timezone' : client_timezone, 'client_start_work_hour' : client_start_work_hour, 'flexi' : flexi});
	//log(query);
	var result = doXHR(PATH + 'ConfigureStaffSchedule/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessConfigureStaffSchedule, OnFailConfigureStaffSchedule);
}

function OnSuccessConfigureStaffSchedule(e){
	$('staff_working_schedules_result').innerHTML=e.responseText;
	$('client_finish_work_hour').value = getNodeAttribute($('staff_working_schedules_result_value'), 'client_finish_work_hour');
	
	var staff_start_work_hour = getNodeAttribute($('staff_working_schedules_result_value'), 'staff_start_work_hour')
	var staff_finish_work_hour = getNodeAttribute($('staff_working_schedules_result_value'), 'staff_finish_work_hour');
	var time_difference = getNodeAttribute($('staff_working_schedules_result_value'), 'time_difference');
	
	var staff_start_lunch = getNodeAttribute($('staff_working_schedules_result_value'), 'staff_start_lunch');
	var staff_finish_lunch = getNodeAttribute($('staff_working_schedules_result_value'), 'staff_finish_lunch');
	var lunch_time_difference = getNodeAttribute($('staff_working_schedules_result_value'), 'lunch_time_difference');
	
	var work_status = getNodeAttribute($('staff_working_schedules_result_value'), 'work_status');
	
	var flexi = $('flexi').value;
	var work_days = $('work_days').value;
	work_days = work_days.split(',')
	
	for(i=0;i<WEEKDAYS.length;i++){
		if(inArray(WEEKDAYS[i], work_days)){
		    $(WEEKDAYS[i]+'_start').value = staff_start_work_hour;
		    $(WEEKDAYS[i]+'_finish').value = staff_finish_work_hour;
	        $(WEEKDAYS[i]+'_number_hrs').value =  time_difference;
			
			$(WEEKDAYS[i]+'_start_lunch').value = staff_start_lunch;
	        $(WEEKDAYS[i]+'_finish_lunch').value = staff_finish_lunch;
	        $(WEEKDAYS[i]+'_lunch_number_hrs').value =  lunch_time_difference;
			
			if(work_status == 'Full-Time' ){
				$(WEEKDAYS[i]+'_start_lunch').disabled = false;
	            $(WEEKDAYS[i]+'_finish_lunch').disabled = false;
	            $(WEEKDAYS[i]+'_lunch_number_hrs').disabled = false;
			}else{
				$(WEEKDAYS[i]+'_start_lunch').disabled = true;
	            $(WEEKDAYS[i]+'_finish_lunch').disabled = true;
	            $(WEEKDAYS[i]+'_lunch_number_hrs').disabled = true;
			}
		}
	}
	
	//CheckIfFlexi();
	ConfigurePrice('php_monthly');
	ConfigurePrice('client_price');
	DisplayWorkingHoursDaysBreakTime();
}

function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}
function OnFailConfigureStaffSchedule(e){
	alert("Failed to configure staff schedule.");
}

function SendMessageToSendInvoice(e){
	var leads_id = getNodeAttribute(e.src(), 'leads_id');
	var mode = getNodeAttribute(e.src(), 'mode');
	
	var query = queryString({'mode': mode, 'leads_id' : leads_id});
	if(mode=='send'){
	    var result = doXHR(PATH + 'SendMessageToSendInvoice/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	}else{
		var result = doXHR(PATH + 'SendMessageToReSendInvoice/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	}
	result.addCallbacks(OnSuccessSendMessageToSendInvoice, OnFailSendMessageToSendInvoice);
}

function OnSuccessSendMessageToSendInvoice(e){
	if(e.responseText == 'ok'){
	    alert('Invoice Sent.');
		location.href=PATH + 'new';
	}else{
	    alert(e.responseText);
	}
}

function OnFailSendMessageToSendInvoice(e){
	alert(e.responseText);
}


function SearchSubconPaymentDetails(e){
	$('subcon_payment_details_list').innerHTML="Loading...";

	var status = $('status').value;
    var csro_id = $('csro_id').value;
	var keyword = $('keyword').value;
	
	var query = queryString({'keyword': keyword, 'status' : status, 'csro_id' : csro_id });
	log(query);
	$('search_btn').value="searching...";
	$('search_btn').disabled=true;
	$('export_btn').disabled=true;
	
	var result = doXHR(PATH + 'SearchSubconPaymentDetails/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSearchSubconPaymentDetails, OnFailSearchSubconPaymentDetails);
	
}

function OnSuccessSearchSubconPaymentDetails(e){
	$('subcon_payment_details_list').innerHTML = e.responseText;
	$('search_btn').value="Search";
	$('search_btn').disabled=false;
	$('export_btn').disabled=false;
}

function OnFailSearchSubconPaymentDetails(e){
	alert("There's a problem in loading subcon payment details.");
	$('search_btn').value="Search";
	$('search_btn').disabled=false;
	$('export_btn').disabled=false;
}

function UpdateStaffPaymentDetails(e){
	var userid = getNodeAttribute(e.src(), 'userid');
	var card_number = $('card_number').value;
	var account_holders_name = $('account_holders_name').value;
	var bank_name = $('bank_name').value;
	var bank_branch = $('bank_branch').value;
	var swift_address = $('swift_address').value;
	var bank_account_number = $('bank_account_number').value;
	var bank_account_holders_name = $('bank_account_holders_name').value;
		
	var query = queryString({'userid' : userid, 'card_number': card_number, 'account_holders_name' : account_holders_name, 'bank_name' : bank_name, 'bank_branch' : bank_branch, 'swift_address' : swift_address, 'bank_account_number' : bank_account_number, 'bank_account_holders_name' : bank_account_holders_name });
	
	log(query);
	
	$('update_btn').value="saving...";
	$('update_btn').disabled=true;

	
	var result = doXHR(PATH + 'UpdateStaffPaymentDetails/', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateStaffPaymentDetails, OnFailUpdateStaffPaymentDetails);


	function OnSuccessUpdateStaffPaymentDetails(e){
		if(e.responseText == 'updated'){
			alert(e.responseText);
			location.href = PATH + 'staff_payment_details/'+userid;
		}else{	
			alert(e.responseText);
		}
		$('update_btn').value="Save Changes";
		$('update_btn').disabled=false;
	}
	
	function OnFailUpdateStaffPaymentDetails(e){
		alert("There's a problem in updating staff payment details");
		$('update_btn').value="Save Changes";
		$('update_btn').disabled=false;
	}

}