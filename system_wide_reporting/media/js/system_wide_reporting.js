// JavaScript Document
var PATH = 'system_wide_reporting/';

function updateParent(e) {
	var page = getNodeAttribute(e.src(), 'page');
	//opener.updatemyarray(page);
	//self.close();
	//location.href=page;
	popup_win(page ,600 , 500);
}


function updatemyarray(page) {
	location.href=page;
}

function OnClickHighlightRow(e){
	var items = getElementsByTagAndClassName('tr', 'staff_list', parent=document);
	for (var item in items){
		removeElementClass(items[item], 'staff_list_highlighted');
	}
	
    addElementClass(e.src(), 'staff_list_highlighted');
	//var staff = getNodeAttribute(e.src(), 'staff');
	//var client = getNodeAttribute(e.src(), 'client');
	//var regular_time_in = getNodeAttribute(e.src(), 'regular_time_in');
	//var status = getNodeAttribute(e.src(), 'status');
	//var time_in = getNodeAttribute(e.src(), 'time_in');
	//alert("Staff : "+staff+"\nClient : "+client+"\nExpected Login : "+regular_time_in+"\nStatus : "+status+"\nTime in :  "+time_in);
	
}
function ViewAnniStaff(anni,list){
	var mode = $('view_anni_staff_mode').value;
	var month = $('month').value;
	var year = $('year').value;
	var from = $('from').value;
	var to = $('to').value;
	
	if(mode == 'month_year'){
		popup_win("./system_wide_reporting/ViewAnniStaff.php?mode="+ mode +"&year="+ year + "&month="+month+"&anni="+anni+"&list="+list ,600 , 500)
	}else{
		
		popup_win("./system_wide_reporting/ViewAnniStaff.php?mode="+ mode +"&from="+ from + "&to="+to+"&anni="+anni+"&list="+list ,600 , 500)
	}
}

function ShowBDSummaryReport(mode){
	if(mode == 'event_date'){
		var current_date = $('event_date').value;
	}else{
		$('event_date').value = "";
		var current_date = $('current_date').value;
	}
	
	$('summary').innerHTML = "Loading...";
	var query = queryString({'current_date' : current_date , 'mode' : mode});
	var result = doXHR(PATH + 'ShowBDSummaryReport.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowBDSummary, OnFailShowBDSummary);
}

function OnSuccessShowBDSummary(e){
	$('summary').innerHTML =  e.responseText;
}
function OnFailShowBDSummary(e){
	alert("Failed to show Business Developers Summary Report.");
}

function AccountRenderInvoices(){
	var from = $('from_str').value;
	var to = $('to_str').value;
	var query = queryString({'from' : from , 'to' : to});
	var result = doXHR(PATH + 'AccountRenderInvoices.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessAccountRenderInvoices, OnFailAccountRenderInvoices);
}

//invoice_result
function OnSuccessAccountRenderInvoices(e){
	$('invoice_result').innerHTML = e.responseText;
	var items = getElementsByTagAndClassName('span', 'invoice_result', 'admin_tab'); //parent=document
	for (var item in items){
		connect(items[item], 'onclick', ShowInvoiceResult);
	}
}
function OnFailAccountRenderInvoices(e){
	alert("Failed to show invoice results");
}

function ShowInvoiceResult(e){
	var table = getNodeAttribute(e.src(), 'table');
	var status = getNodeAttribute(e.src(), 'status');
	var from = $('from_str').value;
	var to = $('to_str').value;
	//alert(table+" \n "+status);
	popup_win("./system_wide_reporting/ViewInvoice.php?table="+ table +"&status="+ status + "&from="+from+"&to="+to ,700 , 500)
}

function SearchSubconQuickViewByFromTo(){
	var from = $('from').value;
	var to = $('to').value;
	var query = queryString({'from' : from , 'to' : to});
	//alert(query);
	//popup_win('./system_wide_reporting/StaffAttendanceSheet.php' ,400 , 300)
	var result = doXHR(PATH + 'SearchSubconQuickViewByFromTo.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSearchSubconQuickViewByDate, OnFailSearchSubconQuickViewByDate);
}

function ClearSelectMonthYear(){
	$('month').value = "";
	$('year').value = "";
}
function ClearFromToFields(){
	$('from').value ="";
	$('to').value ="";
}
function SearchSubconQuickViewByDate(){
	var month = $('month').value;
	var year = $('year').value;
	
	if(month != "" && year != ""){
		$('subcons_quick_view_filter_result').innerHTML = "Loading...";
		var query = queryString({'month' : month , 'year' : year});
		
		var result = doXHR(PATH + 'SearchSubconQuickViewByDate.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
		result.addCallbacks(OnSuccessSearchSubconQuickViewByDate, OnFailSearchSubconQuickViewByDate);
	}
}
function OnSuccessSearchSubconQuickViewByDate(e){
	
	$('subcons_quick_view_filter_result').innerHTML = e.responseText;
}

function OnFailSearchSubconQuickViewByDate(e){
	alert("Failed to load");
}








var tabberOptions = {

		'onClick': function(argsObj) {
		
				var t = argsObj.tabber; /* Tabber object */
				var i = argsObj.index; /* Which tab was clicked (0..n) */
				var div = this.tabs[i].div; /* The tab content div */
				
				/* Display a loading message */
				div.innerHTML = "<p>Loading...<\/p>";
				
				/* Fetch some html depending on which tab was clicked */
				//var url = 'example-ajax-' + i + '.html';
				//var pars = "";//'foo=bar&foo2=bar2'; /* just for example */
				//var myAjax = new Ajax.Updater(div, url, {method:'get',parameters:pars});
				FetchPage(i , div );
		},

		'onLoad': function(argsObj) {
				/* Load the first tab */
				argsObj.index = 0;
				this.onClick(argsObj);
		}


}

function FetchPage(i , div ){
		//alert(i);
		/*
		0 = Admin
		1 = Accounts
		2 = Recruitment
		3 = Sales
		4 = ASL
		*/
		//var tab_str = new Array('Admin','Accounts','Recruitment','Sales','ASL');
		//var filenames = new Array('Admin.php' , 'Accounts.php', 'Recruitment.php' , 'Sales.php' , 'ASL.php');
		var tab_str = new Array('Admin', 'Sales');
		var filenames = new Array('Admin.php', 'Sales.php');
		
		var result = doSimpleXMLHttpRequest(PATH + filenames[i]);
		result.addCallbacks(OnSuccessFetchPage, OnFailFetchPage);
		
		function OnSuccessFetchPage(e){
			div.innerHTML = e.responseText;
			if(i==0 ){
				Calendar.setup({
					inputField     :    "from",     // id of the input field
					ifFormat       :    "%Y-%m-%d",      // format of the input field
					button         :    "bd",          // trigger for the calendar (button ID)
					align          :    "Tl",           // alignment (defaults to "Bl")
					showsTime	   :    false, 
					singleClick    :    true
				});  
				Calendar.setup({
					inputField     :    "to",     // id of the input field
					ifFormat       :    "%Y-%m-%d",      // format of the input field
					button         :    "bd2",          // trigger for the calendar (button ID)
					align          :    "Tl",           // alignment (defaults to "Bl")
					showsTime	   :    false, 
					singleClick    :    true
				});
				SearchSubconQuickViewByDate();
			}
			/*
			if(i==1 ){
				Calendar.setup({
					inputField     :    "from_str",     // id of the input field
					ifFormat       :    "%Y-%m-%d",      // format of the input field
					button         :    "bd_str",          // trigger for the calendar (button ID)
					align          :    "Tl",           // alignment (defaults to "Bl")
					showsTime	   :    false, 
					singleClick    :    true
				});  
				Calendar.setup({
					inputField     :    "to_str",     // id of the input field
					ifFormat       :    "%Y-%m-%d",      // format of the input field
					button         :    "bd2_str",          // trigger for the calendar (button ID)
					align          :    "Tl",           // alignment (defaults to "Bl")
					showsTime	   :    false, 
					singleClick    :    true
				});
				
				AccountRenderInvoices();
				
				
			}*/
			if(i==1){
				Calendar.setup({
					inputField     :    "event_date",     // id of the input field
					ifFormat       :    "%Y-%m-%d",      // format of the input field
					button         :    "bd_event_date",          // trigger for the calendar (button ID)
					align          :    "Tl",           // alignment (defaults to "Bl")
					showsTime	   :    false, 
					singleClick    :    true
				});	
				
				ShowBDSummaryReport('current');
			}
			
		}
		function OnFailFetchPage(e){
			alert("Failed to load [ "+tab_str[i]+" ] tab contents.");
		}
		
		
}