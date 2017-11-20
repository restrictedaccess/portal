//2009-09-01    Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  disable the blanking of the invoice when a line is updated.

//2009-09-07 Normaneil E. Macutay <normanm@remotestaff.com.au>

var xmlHttp;
PATH ="invoice/client/";


function highlight(obj , clicked) {
 
   obj.style.backgroundColor='yellow';
   obj.style.cursor='pointer';
}
function unhighlight(obj , clicked) {
   obj.style.backgroundColor='';
   obj.style.cursor='default';
}

function show_hide(id) 
{
	obj = document.getElementById(id);
	obj.style.display = (obj.style.display == "block") ? "none" : "block";
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


function calculateChargeOutRate() { 

	currency =  document.getElementById("currency").value;
	var currency_desc;
	if(currency == "AUD"){
		fix_rate = '38.00';
		currency_desc = "Invoice to be paid in Australian Dollar";
	}
	if(currency == "USD"){
		fix_rate = '45.00';
		currency_desc = "Invoice to be paid in United States Dollar";
	}
	if(currency == "POUND"){
		fix_rate = '77.00';
		currency_desc = "Invoice to be paid in United Kingdom Pounds";
	}
	if(currency == ""){
		fix_rate = '0.00';
		currency_desc = "";
	}
	
	document.getElementById("fix_currency_rate").value = fix_rate;
	document.getElementById("currency_desc").innerHTML = currency_desc;

	
	
}
///AJAX
function exportToCSV(status){
	month = document.getElementById("month").value;
	year = document.getElementById("year").value;
	client = document.getElementById("client_id").value;
	var leads_name;
	var mess;
	var month_fullname;

	if(client > 0){
		leads_name =  document.getElementById('client_id')[document.getElementById('client_id').selectedIndex].innerHTML;
		client_name = "client " + leads_name +"'s";	 	
	}else{
		client_name = "";	
	}
	
	if(month > 0){
		month_fullname = document.getElementById('month')[document.getElementById('month').selectedIndex].innerHTML;
		month_name = " \nMonth :" + month_fullname;	
	}else{
		month_name = "";
	}
	
	if(year > 0){
		year_name = " \nYear :" + document.getElementById('year')[document.getElementById('year').selectedIndex].innerHTML;	
	}else{
		year_name = "";
	}

	
	
	
	if(month == 0 && year == 0 && client == 0) {
		mess = "Are you sure you want to export all client invoice "+status.toUpperCase()+ " section  to CSV?"
	}else{
		mess = "Are you sure you want to export "+ client_name.toUpperCase()+" all client invoice "+status.toUpperCase()+ " section  to CSV? "+ month_name + year_name ; 
	}
	
	
	var url="invoice/adminExportClientInvoiceToCSV.php";
	url=url+"?month="+month;
	url=url+"&year="+year;
	url=url+"&client="+client;
	url=url+"&status="+status;
	url=url+"&leads_name="+leads_name;
	url=url+"&month_fullname="+month_fullname;
	url=url+"&sid="+Math.random();
	//alert(url);
	
	
	if (confirm(mess)) {
        location.href =url;
    }
}



function searchInvoiceBySubCon(userid){
	if(userid==null){
		alert("Sub-Contractor ID is Missing..");	
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	document.getElementById("searching2").innerHTML="<img src='images/loading.gif' WIDTH='16' HEIGHT ='16'>";
	var url=PATH+"searchInvoiceNumberBySubCon.php";
	url=url+"?userid="+userid;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessSearchInvoiceNumber;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}


function searchInvoice(keyword){
	//document.getElementById("searching").innerHTML="<img src='images/loading.gif' WIDTH='16' HEIGHT ='16'>";
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"searchInvoiceNumber.php";
	url=url+"?keyword="+keyword;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessSearchInvoiceNumber;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function searchInvoiceBySubTotal(){
	range1 = document.getElementById("range1").value;
	range2 = document.getElementById("range2").value;
	
	if(isNaN(range1) && isNaN(range2)){
		alert("Please Enter a Valid Number");
		return false;
	}
	
	if(range1!="" && range2!=""){
	
		document.getElementById("searching2").innerHTML="<img src='images/loading.gif' WIDTH='16' HEIGHT ='16'>";
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
		  alert ("Your browser does not support AJAX!");
		  return;
		}
		var url=PATH+"searchInvoiceBySubTotal.php";
		url=url+"?range1="+range1;
		url=url+"&range2="+range2;
		url=url+"&sid="+Math.random();
		xmlHttp.onreadystatechange=onSuccessSearchInvoiceNumber;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}
}


function onSuccessSearchInvoiceNumber(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("invoice_list").innerHTML=xmlHttp.responseText;	
		//document.getElementById("searching").innerHTML="";
		//document.getElementById("searching2").innerHTML="";
	}
}
function setGst(id){
	gst=document.getElementById("gst");
	if(gst.checked==true){
		tax = true;
	}else{
		tax = false;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"setGst.php";
	url=url+"?id="+id;
	url=url+"&tax="+tax;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=ShowUpdates;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}

function updateTotalDayswork(num){
	if(isNaN(num)){
		alert ("Days work is not a number !");
		return false;
	}
	rate = document.getElementById("rate").value;
	amount = document.getElementById("amount_hidden").value;
	document.getElementById("amount").value = (parseFloat(rate) * parseFloat(num));
	
}
function getRegularWorkingDays()
{
	month =document.getElementById("invoice_month").value;
	year = document.getElementById("invoice_year").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"getMonthWorkingDays.php";
	url=url+"?month="+month;
	url=url+"&year="+year;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessGetMonthWorkingDays;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function onSuccessGetMonthWorkingDays()
{
	if (xmlHttp.readyState==4)
	{
		document.getElementById("regular_working_days").innerHTML=xmlHttp.responseText;	
	}
}

function showFormInvoice(){
	document.getElementById("right_panel").innerHTML="Loading...";
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url=PATH+"adminGetNewClientInvoiceForm.php";
	url=url+"?mode=subcon_invoice";
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange = function OnSuccessShowFormInvoice()
	{
		if (xmlHttp.readyState==4)
		{ 
			document.getElementById("right_panel").innerHTML=xmlHttp.responseText;
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function editDueDate(client_invoice_id){
	
	obj=document.getElementById("due_date_div");
	obj.innerHTML="Loading...";
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url=PATH+"getDueDateEditForm.php";
	url=url+"?client_invoice_id="+client_invoice_id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=showDueDateEditForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function showDueDateEditForm(){
	obj=document.getElementById("due_date_div");
	obj.style.display='block';
	if (xmlHttp.readyState==4)
	{
		obj.innerHTML=xmlHttp.responseText;
		Calendar.setup( {
		  inputField  : "invoice_payment_due_date",         // ID of the input field
		  ifFormat    : "%Y-%m-%d",    // the date format
		  button      : "cal_due_date"       // ID of the button
		});
	}
		
	
}
function updateDueDate(client_invoice_id){
	//alert(client_invoice_id);
	invoice_payment_due_date = document.getElementById("invoice_payment_due_date").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url=PATH+"updateDueDate.php";
	url=url+"?client_invoice_id="+client_invoice_id;
	url=url+"&invoice_payment_due_date="+invoice_payment_due_date;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessUpdateDueDate;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	//alert(url);
	
}
function OnSuccessUpdateDueDate(){
	obj=document.getElementById("due_date_div");
	obj.style.display='none';
	if (xmlHttp.readyState==4)
	{
		document.getElementById("payment_due_date").innerHTML=xmlHttp.responseText;
	}
}
function editInvoiceDetails(id,client_invoice_id){
	
	obj=document.getElementById("edit_div");
	obj.innerHTML="Loading...";
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url=PATH+"getInvoiceDetailsEditForm.php";
	url=url+"?id="+id;
	url=url+"&client_invoice_id="+client_invoice_id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=showEditForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function showEditForm(){
	if (xmlHttp.readyState==4)
	{ 
		obj=document.getElementById("edit_div");
		obj.innerHTML="Loading...";
		obj.style.display='block';
		obj.innerHTML=xmlHttp.responseText;
		Calendar.setup( {
		  inputField  : "start_date",         // ID of the input field
		  ifFormat    : "%Y-%m-%d",    // the date format
		  button      : "cal_start_date"       // ID of the button
		});
		Calendar.setup( {
		  inputField  : "end_date",         // ID of the input field
		  ifFormat    : "%Y-%m-%d",    // the date format
		  button      : "cal_end_date"       // ID of the button
		});
	}
	
}
function HideEditDiv(div){
	
	obj=document.getElementById(div);
	obj.style.display='none';

}
function updateInvoiceDetail(id){
	
	//xmlHttp=GetXmlHttpObject();
	//if (xmlHttp==null)
  	//{
	// alert ("Your browser does not support AJAX!");
	//  return;
  	//}
	gst=document.getElementById("gst");
	if(gst.checked==true){
		tax = true;
	}else{
		tax = false;
	}
	start_date = document.getElementById("start_date").value;
	end_date = document.getElementById("end_date").value;
	description = document.getElementById("description").value;
	total_days_work = document.getElementById("total_days_work").value;
	rate = document.getElementById("rate").value;
	amount = document.getElementById("amount").value;
	client_invoice_id = document.getElementById("client_invoice_id").value;
	
	if(rate==""){
		rate=0;
	}
	if(total_days_work==""){
		total_days_work=0;
	}
	if(amount==""){
		alert("Please enter a amount");
		return false;
	}
	//alert(id +" "+start_date+" "+end_date+" "+description+" "+total_days_work+" "+rate+" "+amount);
	
	
	/*
	
	var url=PATH+"updateInvoiceDetails.php";
	url=url+"?id="+id;
	url=url+"&start_date="+start_date;
	url=url+"&end_date="+end_date;
	url=url+"&description="+description;
	url=url+"&total_days_work="+total_days_work;
	url=url+"&rate="+rate;
	url=url+"&amount="+amount;
	url=url+"&client_invoice_id="+client_invoice_id;
	url=url+"&tax="+tax;
	url=url+"&sid="+Math.random();
	alert(url);
	xmlHttp.onreadystatechange=ShowUpdates;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	*/
	
	var query = queryString({'id' : id , 'start_date' : start_date , 'end_date' : end_date, 'description' : description, 'total_days_work' : total_days_work, 'rate' : rate , 'amount' : amount, 'client_invoice_id' : client_invoice_id , 'tax' : tax  });
	var result = doXHR(PATH + 'updateInvoiceDetails.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowUpdates, OnFailUpdateInvoiceDetail);
	
}
function OnSuccessShowUpdates(e){
	document.getElementById("right_panel").innerHTML=e.responseText;	
	client_invoice_id = document.getElementById("client_invoice_id").value;
	showClientInvoiceDetail(client_invoice_id);
}
	
function ShowUpdates(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("right_panel").innerHTML=xmlHttp.responseText;
		client_invoice_id = document.getElementById("client_invoice_id").value;
		showClientInvoiceDetail(client_invoice_id);
	}
		
}

function OnFailUpdateInvoiceDetail(e){
	alert("Fail to update client invoice details.");	
}

function deleteInvoiceDetails(id,client_invoice_id){
	gst=document.getElementById("gst");
	if(gst.checked==true){
		tax = true;
	}else{
		tax = false;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url=PATH+"deleteInvoiceDetails.php";
	url=url+"?id="+id;
	url=url+"&client_invoice_id="+client_invoice_id;
	url=url+"&tax="+tax;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=ShowUpdates;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function addItem(client_invoice_id){
	obj=document.getElementById("edit_div");
	obj.innerHTML="Loading...";
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url=PATH+"getInvoiceDetailsAddForm.php";
	url=url+"?client_invoice_id="+client_invoice_id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=showEditForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function addInvoiceDetail(client_invoice_id){
	gst=document.getElementById("gst");
	if(gst.checked==true){
		tax = true;
	}else{
		tax = false;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	
	start_date = document.getElementById("start_date").value;
	end_date = document.getElementById("end_date").value;
	description = document.getElementById("description").value;
	total_days_work = document.getElementById("total_days_work").value;
	rate = document.getElementById("rate").value;
	amount = document.getElementById("amount").value;
	
	if(rate==""){
		rate=0;
	}
	if(total_days_work==""){
		total_days_work=0;
	}
	if(amount==""){
		alert("Please enter a amount");
		return false;
	}
		
	var url=PATH+"addInvoiceDetails.php";
	url=url+"?client_invoice_id="+client_invoice_id;
	url=url+"&start_date="+start_date;
	url=url+"&end_date="+end_date;
	url=url+"&description="+description;
	url=url+"&total_days_work="+total_days_work;
	url=url+"&rate="+rate;
	url=url+"&amount="+amount;
	url=url+"&tax="+tax;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=ShowUpdates;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function postInvoice(client_invoice_id){
	leads_email = document.getElementById("leads_email").value;
	cc = document.getElementById("cc").value;
	message = URLEncode(document.getElementById("message").value);
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	if(confirm("A copy of this invoice will be email to " + leads_email)){
		var url=PATH+"updateStatusInvoice.php";
		url=url+"?client_invoice_id="+client_invoice_id;
		url=url+"&status=posted";
		url=url+"&leads_email="+leads_email;
		url=url+"&cc="+cc;
		url=url+"&message="+message;
		url=url+"&sid="+Math.random();
		xmlHttp.onreadystatechange=ShowUpdates;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		//alert(url);
	}else{
		return false;
	}
	
	
}
function deleteInvoice(client_invoice_id){
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	if(confirm("Are you sure you want to Delete this Invoice ?")){
		var url=PATH+"deleteInvoice.php";
		url=url+"?client_invoice_id="+client_invoice_id;
		url=url+"&sid="+Math.random();
		xmlHttp.onreadystatechange=ShowUpdatedInvoiceList;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}else{
		return false;
	}
}
function ShowUpdatedInvoiceList(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("right_panel").innerHTML=xmlHttp.responseText;
		showAllClientInvoiceList();
	}
}



function paidInvoice(client_invoice_id){
	//alert(client_invoice_id);
	show_hide('paid_div');
	/*
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url=PATH+"updateStatusInvoice.php";
	url=url+"?client_invoice_id="+client_invoice_id;
	url=url+"&status=paid";
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=ShowUpdates;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	*/
}
function moveToPaidSection(client_invoice_id){
	xmlHttp=GetXmlHttpObject();
	event_date = document.getElementById("event_date").value;
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url=PATH+"updateStatusInvoice.php";
	url=url+"?client_invoice_id="+client_invoice_id;
	url=url+"&status=paid";
	url=url+"&event_date="+event_date;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=ShowUpdates;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	//alert(url);
}

function refreshList(){
	showAllClientInvoiceList();
}

function showClientInvoiceDetail(id){
	document.getElementById("right_panel").innerHTML="Loading...";
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url=PATH+"getClientInvoiceDetails.php";
	url=url+"?id="+id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function createClientBlankInvoice(){
	month = document.getElementById("invoice_month").value;
	client = document.getElementById("client").value;
	description = document.getElementById("description").value;
	year = document.getElementById("invoice_year").value;
	currency  = document.getElementById("currency").value;
	
	if(client=="0"){
		alert("Please choose a Client!");
		return false;
	}
	if(month=="0"){
		alert("Please select Month Invoice");
		return false;
	}
	if(currency==""){
		alert("Please select a Currency");
		return false;
	}
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	
	var url=PATH+"createClientBlankInvoice.php";
	url=url+"?mode=blank";
	url=url+"&month="+month;
	url=url+"&year="+year;
	url=url+"&client="+client;
	url=url+"&description="+description;
	url=url+"&currency="+currency;
	url=url+"&sid="+Math.random();
	//alert(url);
	xmlHttp.onreadystatechange=stateChanged2;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	document.getElementById("right_panel").innerHTML="Loading...";
}
function createClientInvoiceFromSubconInvoice() 
{
	
	month = document.getElementById("invoice_month").value;
	year = document.getElementById("invoice_year").value;
	client = document.getElementById("client").value;
	description = document.getElementById("description").value;
	
	currency  = document.getElementById("currency").value;
	fix_currency_rate = document.getElementById("fix_currency_rate").value;
	current_rate = document.getElementById("current_rate").value;
	
	if(client=="0"){
		alert("Please choose a Client!");
		return false;
	}
	if(month=="0"){
		alert("Please select Month Invoice");
		return false;
	}
	if(currency==""){
		alert("Please select a Currency");
		return false;
	}
	//if(section_status==""){
	//	alert("Subcon Section is Missing..Please try again");
	//	return false;
	//}
	
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url=PATH+"createClientInvoice.php";
	url=url+"?mode=subcon_invoice";
	url=url+"&month="+month;
	url=url+"&year="+year;
	url=url+"&client="+client;
	url=url+"&description="+description;
	url=url+"&currency="+currency;
	url=url+"&fix_currency_rate="+fix_currency_rate;
	url=url+"&current_rate="+current_rate;
	url=url+"&sid="+Math.random();
	//alert(url);
	document.getElementById("right_panel").innerHTML="Loading...";
	xmlHttp.onreadystatechange=stateChanged2;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function stateChanged2() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("right_panel").innerHTML=xmlHttp.responseText;
		showAllClientInvoiceList();
	}
}


function stateChanged3() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("invoice_list").innerHTML=xmlHttp.responseText;
	}
}




function hideInvoiceForm(){
	var str = "<div>Click the &quot;Create Blank Invoice&quot; to generate a blank invoice.</div>";
	str+="<div>Click the &quot;Create Invoice From Subcon Invoice&quot; to generate invoice base from Subcontractors Paid Invoices Section .</div>";
	str+="<div>Select an Invoice on the left to view its details.</div>";
	document.getElementById("right_panel").innerHTML=str;
}



function stateChanged() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("right_panel").innerHTML=xmlHttp.responseText;
		//showAllClientInvoiceList();
	Calendar.setup( {
	  inputField  : "event_date",         // ID of the input field
	  ifFormat    : "%Y-%m-%d",    // the date format
	  button      : "bd"       // ID of the button
	});

	}
	
}

function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
	  {
  		// Firefox, Opera 8.0+, Safari
		  xmlHttp=new XMLHttpRequest();
	  }
	catch (e)
	  {
		  // Internet Explorer
		  try
	      {
		    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
	      }
         catch (e)
    	 {
		    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
         }
      }
return xmlHttp;
}


