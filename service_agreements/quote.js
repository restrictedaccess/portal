// page usage by apply_action.php
// Created By Normaneil Macutay 
// Feb.4,2009
// 2009-09-30 Lawrence Sunglao
//  -   updated UK Rate from 82 to 77

// 2010-04-29 Normaneil Macutay
//  -   updated UK Rate from 77 to 71


var xmlHttp
PATH ="service_agreements/";

//alert("he");


function highlight(obj) {
   obj.style.backgroundColor='yellow';
   obj.style.cursor='pointer';
}
function unhighlight(obj) {
   obj.style.backgroundColor='';
   obj.style.cursor='default';
}
function show_hide(sid) 
{
   obj = document.getElementById(sid);
   obj.style.display = (obj.style.display == "block") ? "none" : "block";
}
function hide(sid) 
{
   obj = document.getElementById(sid);
   obj.style.display = "none";
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


function checkInputs(){
	leads_id = document.getElementById("leads_id").value;
	leads_name = document.getElementById("leads_name").value;
	leads_email = document.getElementById("leads_email").value;
	
	if(leads_id!="0" && leads_name !="" && leads_email!=""){
		document.getElementById("leads_name").value = "";
		document.getElementById("leads_email").value = "";
	}
}

function checkInputs2(){
	leads_id = document.getElementById("leads_id").value;
	leads_name = document.getElementById("leads_name").value;
	leads_email = document.getElementById("leads_email").value;
	
	if(leads_id!="0" && (leads_name !="" || leads_email!="")){
		//dropdown.options[myindex].value
		var selObj = document.getElementById("leads_id");
			selObj.selectedIndex = 0;

	}
}

function doCheck(value) {
	if (isNaN(value)) {
		alert('This is not a number! Please enter a valid number before submitting the form.');
		return false;
	}
	return value;
}


function setQuote(){
	var salary = doCheck(document.getElementById("salary").value);
	var hour = document.getElementById("hour").value;
	//var hour = 8;
	var work_status = document.getElementById("work_status").value;
	var day = document.getElementById("days").value;

	if(work_status == "Part-Time"){
		hour = 4;
	}
	//document.getElementById("hour").value = hour;

	//PESO
	pesoYearly = (parseInt(salary) * 12);
	pesoWeekly = (pesoYearly / 52);
	pesoDaily = (pesoWeekly / parseInt(day));
	pesoHourly = (pesoDaily / parseInt(hour));
	
	var str = "<p><label>Yearly : </label>P " + Math.round(pesoYearly*100)/100+"</p>";
	str=str+"<p><b><label>Monthly : </label>P " + Math.round(salary*100)/100+"</b></p>";
	str=str+"<p><label>Weekly : </label>P " + Math.round(pesoWeekly*100)/100+"</p>";
	str=str+"<p><label>Daily : </label>P " + Math.round(pesoDaily*100)/100+"</p>";
	str=str+"<p><label>Hourly : </label>P " + Math.round(pesoHourly*100)/100+"</p>";
	document.getElementById("peso").innerHTML = str;
	
	
	// AUD
	audSalary = salary / 41;
	audYearly = (audSalary * 12);
	audWeekly = (audYearly / 52);
	audDaily = (audWeekly / day);
	audHourly = (audDaily / hour);
	
	var str2 = "<p><label>Yearly : </label>$ " + Math.round(audYearly*100)/100+"</p>";
	str2=str2+"<p><b><label>Monthly : </label>$ " + Math.round(audSalary*100)/100+"</b></p>";
	str2=str2+"<p><label>Weekly : </label>$ " + Math.round(audWeekly*100)/100+"</p>";
	str2=str2+"<p><label>Daily : </label>$ " + Math.round(audDaily*100)/100+"</p>";
	str2=str2+"<p><label>Hourly : </label>$ " + Math.round(audHourly*100)/100+"</p>";
	str2=str2+"<p><b>"+ salary +" / 41.00</b></p>";
	document.getElementById("aud").innerHTML = str2;
	
	//USD	
	usdSalary = salary / 43;
	usdYearly = (usdSalary * 12);
	usdWeekly = (usdYearly / 52);
	usdDaily = (usdWeekly / day);
	usdHourly = (usdDaily / hour);
	
	var str3 = "<p><label>Yearly : </label>$ " + Math.round(usdYearly*100)/100+"</p>";
	str3=str3+"<p><b><label>Monthly : </label>$ " + Math.round(usdSalary*100)/100+"</b></p>";
	str3=str3+"<p><label>Weekly : </label>$ " + Math.round(usdWeekly*100)/100+"</p>";
	str3=str3+"<p><label>Daily : </label>$ " + Math.round(usdDaily*100)/100+"</p>";
	str3=str3+"<p><label>Hourly : </label>$ " + Math.round(usdHourly*100)/100+"</p>";
	str3=str3+"<p><b>"+ salary +" / 43.00</b></p>";
	document.getElementById("usd").innerHTML = str3;
	
	
	//POUNDS
	//USD	
	ukSalary = salary / 69;
	ukYearly = (ukSalary * 12);
	ukWeekly = (ukYearly / 52);
	ukDaily = (ukWeekly / day);
	ukHourly = (ukDaily / hour);
	
	var str4 = "<p><label>Yearly : </label>&pound; " + Math.round(ukYearly*100)/100+"</p>";
	str4=str4+"<p><b><label>Monthly : </label>&pound; " + Math.round(ukSalary*100)/100+"</b></p>";
	str4=str4+"<p><label>Weekly : </label>&pound; " + Math.round(ukWeekly*100)/100+"</p>";
	str4=str4+"<p><label>Daily : </label>&pound; " + Math.round(ukDaily*100)/100+"</p>";
	str4=str4+"<p><label>Hourly : </label>&pound; " + Math.round(ukHourly*100)/100+"</p>";
	str4=str4+"<p><b>"+ salary +" / 69.00</b></p>";
	document.getElementById("uk").innerHTML = str4;
	
	
	// Total Price
	no_of_staff = document.getElementById("no_of_staff").value;
	document.getElementById("total_price").innerHTML = "No.of Staff [ "+ no_of_staff +" ] x "+ salary + " =  " + Math.round((salary * no_of_staff)*100)/100;
	
	
	
}

function setTotalPrice(){
	salary = document.getElementById("salary").value;
	no_of_staff = document.getElementById("no_of_staff").value;
	document.getElementById("total_price").innerHTML = "No.of Staff [ "+ no_of_staff +" ] x "+ salary + " =  " + Math.round((salary * no_of_staff)*100)/100;
}

function setQuoteForClient(){
	salary = doCheck(document.getElementById("quoted_price").value);
	hour = document.getElementById("hour").value;
	day = document.getElementById("days").value;
	currency = document.getElementById("currency").value;
	gst_value = document.getElementById("gst_value").value;
	ukSalary = salary;// / 82;
	ukYearly = (ukSalary * 12);
	ukWeekly = (ukYearly / 52);
	ukDaily = (ukWeekly / day);
	ukHourly = (ukDaily / hour);
	var quoted_price_hdr;
	
	
	if(currency == "AUD"){
		var quoted_price_hdr = "AUSTRALIAN DOLLAR";
		var currency_symbol = "$ ";
		var tax_str = "GST";
		var tax_input_div;
		if(gst_value > 0){
			tax_input_div = "<input type=\"checkbox\" id=\"gst\" name=\"gst\" checked=\"checked\" />";	
		}else{
			tax_input_div = "<input type=\"checkbox\" id=\"gst\" name=\"gst\" />";	
		}
		document.getElementById("tax_str").innerHTML = tax_str;
		document.getElementById("tax_input_div").innerHTML = tax_input_div;
		
	}
	if(currency == "USD"){
		quoted_price_hdr = "US DOLLAR";
		currency_symbol = "$ ";
		tax_str = "TAX";
		tax_input_div = "<input type=\"checkbox\" id=\"gst\" name=\"gst\" disabled /> Not available";
		document.getElementById("tax_str").innerHTML = tax_str;
		document.getElementById("tax_input_div").innerHTML = tax_input_div;
	}
	if(currency == "POUND"){
		quoted_price_hdr = "GBP";
		currency_symbol = "&pound; ";
		tax_str = "VAT";
		if(gst_value > 0){
			tax_input_div = "<input type=\"checkbox\" id=\"gst\" name=\"gst\" checked=\"checked\" />";
		}else{
			tax_input_div = "<input type=\"checkbox\" id=\"gst\" name=\"gst\" />";
		}
		document.getElementById("tax_str").innerHTML = tax_str;
		document.getElementById("tax_input_div").innerHTML = tax_input_div;
	}
	document.getElementById("quoted_price_hdr").innerHTML =quoted_price_hdr;
	
	var str4 = "<p><label>Yearly : </label>"+currency_symbol+ Math.round(ukYearly*100)/100+"</p>";
	str4=str4+"<p><label>Monthly : </label>"+currency_symbol + Math.round(ukSalary*100)/100+"</p>";
	str4=str4+"<p><label>Weekly : </label>"+currency_symbol + Math.round(ukWeekly*100)/100+"</p>";
	str4=str4+"<p><label>Daily : </label>"+currency_symbol + Math.round(ukDaily*100)/100+"</p>";
	str4=str4+"<p><label>Hourly : </label>"+currency_symbol + Math.round(ukHourly*100)/100+"</p>";
	document.getElementById("quoted_price_div").innerHTML = str4;
	
	//
	no_of_staff = document.getElementById("no_of_staff").value;
	document.getElementById("client_total_price").innerHTML ="No.of Staff [ "+ no_of_staff +" ] x "+ salary + " =  " + Math.round((salary * no_of_staff)*100)/100;
	
}
///AJAX
function deleteServiceAgreement(){
	service_agreement_id = document.getElementById("service_agreement_id").value;
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"deleteServiceAgreement.php";
	url=url+"?ran="+Math.random();
	url=url+"&service_agreement_id="+service_agreement_id;
	xmlHttp.onreadystatechange=onSuccessDeleteServiceAgreement;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessDeleteServiceAgreement(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("right_panel").innerHTML = xmlHttp.responseText ;
		showLeadQuotes();
	}
}
function deleteServiceAgreementDetails(service_agreement_details_id){
	service_agreement_id = document.getElementById("service_agreement_id").value;
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"deleteServiceAgreementDetails.php";
	url=url+"?ran="+Math.random();
	url=url+"&service_agreement_details_id="+service_agreement_details_id;
	url=url+"&service_agreement_id="+service_agreement_id;
	xmlHttp.onreadystatechange=onSuccessUpdateServiceAgreementDetails;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function updateServiceAgreementDetails(service_agreement_details_id){
	
	document.getElementById("service_agreement_details_edit_form").style.display="none";
	//service_agreement_detail = document.getElementById("service_agreement_detail").value;
	service_agreement_detail = URLEncode(document.getElementById("service_agreement_detail").value);
	service_agreement_id = document.getElementById("service_agreement_id").value;
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"updateServiceAgreementDetails.php";
	url=url+"?ran="+Math.random();
	url=url+"&service_agreement_id="+service_agreement_id;
	url=url+"&service_agreement_details_id="+service_agreement_details_id;
	url=url+"&service_agreement_detail="+service_agreement_detail;
	xmlHttp.onreadystatechange=onSuccessUpdateServiceAgreementDetails;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
	
	//alert(service_agreement_detail);
}
function onSuccessUpdateServiceAgreementDetails(){
	if (xmlHttp.readyState==4)
	{
		
		document.getElementById("service_agreement_details").innerHTML = xmlHttp.responseText ; 
	}
}
function editServiceAgreementDetails(service_agreement_details_id){
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"editServiceAgreementDetails.php";
	url=url+"?ran="+Math.random();
	url=url+"&service_agreement_details_id="+service_agreement_details_id;
	xmlHttp.onreadystatechange=onSuccessShowServiceAgreementDetailsEditForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessShowServiceAgreementDetailsEditForm(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("service_agreement_details_edit_form").style.display="block";
		document.getElementById("service_agreement_details_edit_form").innerHTML = xmlHttp.responseText ; 
	}
}
function showServiceAgreement(service_agreement_id){
	document.getElementById("right_panel").innerHTML = "Loading";
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showServiceAgreement.php";
	url=url+"?ran="+Math.random();
	url=url+"&service_agreement_id="+service_agreement_id;
	xmlHttp.onreadystatechange=onSuccessShowQuote;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function createServiceAgreement(){
	quote_id =document.getElementById("quote_id").value;
	//leads_id =document.getElementById("leads_id").value;
	//alert(leads_id);
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"createServiceAgreement.php";
	url=url+"?ran="+Math.random();
	url=url+"&quote_id="+quote_id;
	//url=url+"&leads_id="+leads_id;
	xmlHttp.onreadystatechange=onSuccessCreateServiceAgreement;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessCreateServiceAgreement(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("right_panel").style.display="block";	
		document.getElementById("right_panel").innerHTML = xmlHttp.responseText ; 
		showLeadQuotes();
		//var service_agreement_id = xmlHttp.responseText ; 
		//showServiceAgreement(service_agreement_id);
		
		
	}
	
}
function showQuote(quote_id){
	//alert(quote_id);
	document.getElementById("right_panel").innerHTML = "Loading";
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showQuote.php";
	url=url+"?ran="+Math.random();
	url=url+"&quote_id="+quote_id;
	xmlHttp.onreadystatechange=onSuccessShowQuote;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);

}

function onSuccessShowQuote(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("right_panel").style.display="block";	
		document.getElementById("right_panel").innerHTML = xmlHttp.responseText ; 
	}
}




function showLeadQuotes(){
	leads = document.getElementById("leads_id").value;
	//alert(leads);
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showLeadQuotes.php";
	url=url+"?ran="+Math.random();
	url=url+"&leads="+leads;
	xmlHttp.onreadystatechange=onSuccessShowLeadQuotes;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function onSuccessShowLeadQuotes(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("quote_list").innerHTML=xmlHttp.responseText;
	}
}

function postQuote(){
	xmlHttp=GetXmlHttpObject();
	quote_id = document.getElementById("id").value;
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	
	var url=PATH+"updateQuoteStatus.php";
	url=url+"?ran="+Math.random();
	url=url+"&quote_id="+quote_id;
	xmlHttp.onreadystatechange=onSuccessUpdateQuoteStatus;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	//alert(url);
}
function onSuccessUpdateQuoteStatus(){
	if (xmlHttp.readyState==4)
	{
		id = xmlHttp.responseText;	
		if(id!=null){
			showAllQuotes();
			alert("Quote Posted!");
			showTemplate(id);
		}
		//document.getElementById("right_panel").innerHTML = xmlHttp.responseText ; 
		
	}
}

function deleteNote(id){
	xmlHttp=GetXmlHttpObject();
	quote_id = document.getElementById("id").value;
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	
	var url=PATH+"deleteNote.php";
	url=url+"?ran="+Math.random();
	url=url+"&id="+id;
	url=url+"&quote_id="+quote_id;
	xmlHttp.onreadystatechange=onSuccessDeleteNote;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function onSuccessDeleteNote(){
	if (xmlHttp.readyState==4)
	{
		//document.getElementById("notes_list").innerHTML=xmlHttp.responseText;	
		//document.getElementById("message").value ="";
		id = xmlHttp.responseText;
		showTemplate(id);
	}
}


function updateQuote(quote_details_id){
	//alert(quote_details_id);
	id = document.getElementById("id").value;
	salary = document.getElementById("salary").value; 
	client_timezone = document.getElementById("client_timezone").value;
	client_start_work_hour = document.getElementById("client_start_work_hour").value;
	client_finish_work_hour = document.getElementById("client_finish_work_hour").value;
	lunch_start = document.getElementById("lunch_start").value;
	lunch_out = document.getElementById("lunch_out").value;
	lunch_hour = document.getElementById("lunch_hour").value;
	start = document.getElementById("start").value;
	out = document.getElementById("out").value;
	hour = document.getElementById("hour").value;
	days = document.getElementById("days").value;
	quoted_price = document.getElementById("quoted_price").value;
	
	currency = document.getElementById("currency").value;
	work_status = document.getElementById("work_status").value;
	
	work_position = document.getElementById("work_position").value;
	work_description = document.getElementById("work_description").value;
	
	currency_rate = document.getElementById("currency_rate").value;
	gst = document.getElementsByName("gst");
	//var gstlen = gst.length;
	
	no_of_staff = document.getElementById("no_of_staff").value;
	
	quoted_quote_range = URLEncode(document.getElementById("quoted_quote_range").value);
	
	if(gst[0].checked==true){
		gst = "with";
	
	}else{
		gst = "without";
	}
	
	if (isNaN(salary)) {
		alert('Staff Salary is not a number! Please enter a valid number before submitting the form.');
		return false;
	}
	
	if (isNaN(quoted_price)) {
		alert('Quoted Price is not a number! Please enter a valid number before submitting the form.');
		return false;
	}
	
	
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"updateQuote.php";
	url=url+"?ran="+Math.random();
	url=url+"&id="+id;
	url=url+"&salary="+salary;
	url=url+"&client_timezone="+client_timezone;
	url=url+"&client_start_work_hour="+client_start_work_hour;
	url=url+"&client_finish_work_hour="+client_finish_work_hour;
	url=url+"&lunch_start="+lunch_start;
	url=url+"&lunch_out="+lunch_out;
	url=url+"&lunch_hour="+lunch_hour;
	url=url+"&start="+start;
	url=url+"&out="+out;
	url=url+"&hour="+hour;
	url=url+"&days="+days;
	url=url+"&quoted_price="+quoted_price;
	
	url=url+"&currency="+currency;
	url=url+"&work_status="+work_status;
	url=url+"&quote_details_id="+quote_details_id;
	
	url=url+"&work_position="+work_position;
	url=url+"&work_description="+work_description;

	url=url+"&currency_rate="+currency_rate;
	url=url+"&gst="+gst;
	url=url+"&no_of_staff="+no_of_staff;
	url=url+"&quoted_quote_range="+quoted_quote_range;
	//alert(url);
	xmlHttp.onreadystatechange=onSuccessUpdateQuote;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function onSuccessUpdateQuote(){
	if (xmlHttp.readyState==4)
	{
		
		id = innerHTML=xmlHttp.responseText;	
		showTemplate(id);
		document.getElementById("quote_status").style.display="block";
		document.getElementById("quote_status").innerHTML="Quote Updated!";	
		//document.getElementById("right_panel").innerHTML=xmlHttp.responseText;	
	}
}


function saveQuote(){
	
	id = document.getElementById("id").value;
	salary = document.getElementById("salary").value; 
	client_timezone = document.getElementById("client_timezone").value;
	client_start_work_hour = document.getElementById("client_start_work_hour").value;
	client_finish_work_hour = document.getElementById("client_finish_work_hour").value;
	lunch_start = document.getElementById("lunch_start").value;
	lunch_out = document.getElementById("lunch_out").value;
	lunch_hour = document.getElementById("lunch_hour").value;
	start = document.getElementById("start").value;
	out = document.getElementById("out").value;
	hour = document.getElementById("hour").value;
	day_work = document.getElementById("days").value;
	quoted_price = document.getElementById("quoted_price").value;
	
	currency = document.getElementById("currency").value;
	work_status = document.getElementById("work_status").value;
	
	work_position = document.getElementById("work_position").value;
	work_description = document.getElementById("work_description").value;
	
	
	currency_rate = document.getElementById("currency_rate").value;
	gst = document.getElementsByName("gst");
	
	no_of_staff = document.getElementById("no_of_staff").value;
	
	quoted_quote_range = URLEncode(document.getElementById("quoted_quote_range").value);
	
	//var gstlen = gst.length;
	//alert(gstlen);
	if(gst[0].checked==true){
		gst = "with";
	
	}else{
		gst = "without";
	}
	
	if (isNaN(salary)) {
		alert('Staff Salary is not a number! Please enter a valid number before submitting the form.');
		return false;
	}
	
	if (isNaN(quoted_price)) {
		alert('Quoted Price is not a number! Please enter a valid number before submitting the form.');
		return false;
	}
	
	
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"saveQuote.php";
	
	url=url+"?id="+id;
	url=url+"&salary="+salary;
	url=url+"&client_timezone="+client_timezone;
	url=url+"&client_start_work_hour="+client_start_work_hour;
	url=url+"&client_finish_work_hour="+client_finish_work_hour;
	url=url+"&lunch_start="+lunch_start;
	url=url+"&lunch_out="+lunch_out;
	url=url+"&lunch_hour="+lunch_hour;
	url=url+"&start="+start;
	url=url+"&out="+out;
	url=url+"&hour="+hour;
	url=url+"&days="+day_work;
	url=url+"&quoted_price="+quoted_price;
	url=url+"&currency="+currency;
	url=url+"&work_status="+work_status;
	url=url+"&work_position="+work_position;
	url=url+"&work_description="+work_description;
	url=url+"&currency_rate="+currency_rate;
	url=url+"&gst="+gst;
	url=url+"&no_of_staff="+no_of_staff;
	url=url+"&quoted_quote_range="+quoted_quote_range;
	url=url+"&ran="+Math.random();
	
	//alert(url);
	xmlHttp.onreadystatechange=onSuccessSaveQuote;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
	document.getElementById("right_panel").innerHTML = "Loading...";
	
}
function onSuccessSaveQuote(){
	if (xmlHttp.readyState==4)
	{
		
		//id = innerHTML=xmlHttp.responseText;	
		//showTemplate(id);
		document.getElementById("right_panel").innerHTML=xmlHttp.responseText;	
		document.getElementById("quote_status").style.display="block";
		document.getElementById("quote_status").innerHTML="New Quote Created!";	
		
	}
}

//agent = document.getElementById("agent").value;
//leads = document.getElementById("leads").value;
//month = document.getElementById("month").value;
//quote_no = document.getElementById("quote_no").value;
function searchByLeads(){
	
	document.getElementById("quote_no").value = "";
	leads = document.getElementById("client").value;
	//alert(leads);
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"showAllQuotes.php";
	url=url+"?ran="+Math.random();
	url=url+"&leads="+leads;
	xmlHttp.onreadystatechange=onSuccessShowAllQuotes;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function searchByMonth(){
	document.getElementById("quote_no").value = "";
	month = document.getElementById("month").value;
	year =  document.getElementById("year").value;
	
	//if(month==null){
	//	alert("Please choose a Month!");
	//	return false;
	//}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"showAllQuotes.php";
	url=url+"?ran="+Math.random();
	url=url+"&month="+month;
	url=url+"&year="+year;
	xmlHttp.onreadystatechange=onSuccessShowAllQuotes;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}

function searchByAgent(agent_id){
	document.getElementById("quote_no").value = "";
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"showAllQuotes.php";
	url=url+"?ran="+Math.random();
	url=url+"&agent_id="+agent_id;
	xmlHttp.onreadystatechange=onSuccessShowAllQuotes;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function searchByQuoteNo(quote_no){
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"showAllQuotes.php";
	url=url+"?ran="+Math.random();
	url=url+"&quote_no="+quote_no;
	xmlHttp.onreadystatechange=onSuccessShowAllQuotes;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}



function deleteQuote(){
	id = document.getElementById("id").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	
	var url=PATH+"deleteQuote.php";
	url=url+"?ran="+Math.random();
	url=url+"&id="+id;
	xmlHttp.onreadystatechange=onSuccessDeleteQuote;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function onSuccessDeleteQuote(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("right_panel").innerHTML=xmlHttp.responseText;	
		showAllQuotes();
	}
	
}

function ShowMessageForm(quote_details_id){
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"showMessageForm.php";
	url=url+"?quote_details_id="+quote_details_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessShowMessageForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function onSuccessShowMessageForm()
{
	if (xmlHttp.readyState==4)
	{
		document.getElementById("message_form").style.display="block";
		document.getElementById("message_form").innerHTML=xmlHttp.responseText;	
	}
}

function saveMessage(quote_details_id){
	xmlHttp=GetXmlHttpObject();
	message = document.getElementById("message").value;
	id = document.getElementById("id").value;
	message = URLEncode(message);
	
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	
	var url=PATH+"saveMessage.php";
	url=url+"?ran="+Math.random();
	url=url+"&id="+id;
	url=url+"&quote_details_id="+quote_details_id;
	url=url+"&message="+message;
	xmlHttp.onreadystatechange=onSuccessSaveMessage;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	//alert(url);
}
function onSuccessSaveMessage(){
	if (xmlHttp.readyState==4)
	{
		//document.getElementById("notes_list").innerHTML=xmlHttp.responseText;
		id = innerHTML=xmlHttp.responseText;
		showTemplate(id);
		//document.getElementById("message").value ="";
	}
}

function generateQuote(mode){
	var url;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	url=PATH+"generateQuote.php";
	url=url+"?mode="+mode;
	url=url+"&ran="+Math.random();
	
	if(mode=="manual"){
		leads_fname = document.getElementById("leads_fname").value;
		leads_lname = document.getElementById("leads_lname").value;
		leads_email= document.getElementById("leads_email").value;
		leads_company= document.getElementById("leads_company").value;
		leads_address= document.getElementById("leads_address").value;
		url=url+"&leads_fname="+leads_fname;
		url=url+"&leads_lname="+leads_lname;
		url=url+"&leads_email="+leads_email;
		url=url+"&leads_company="+leads_company;
		url=url+"&leads_address="+leads_address;
	}
	
	if(mode=="leads"){
		leads_id = document.getElementById("leads_id").value;
		url=url+"&leads_id="+leads_id;
	}
	//alert(url);
	xmlHttp.onreadystatechange=onSuccessGenerateQuote;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function onSuccessGenerateQuote(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("right_panel").innerHTML=xmlHttp.responseText;	
		//id = xmlHttp.responseText;	
		//showTemplate(id)
		showAllQuotes()
		//
		
		
	}
}
function showTemplate(id){
	
	document.getElementById("quote_status").innerHTML="";
	document.getElementById("quote_status").style.display="none";
	if(id=="" || id == null){
		alert("Id is Missing");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	
	var url=PATH+"template.php";
	url=url+"?id="+id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessShowTemplate;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}

function onSuccessShowTemplate(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("right_panel").innerHTML=xmlHttp.responseText;	
		
	}
}
function deleteQuoteDetails(id,quote_details_id){
	if(id=="" || id == null){
		alert("Id is Missing");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"deleteQuoteDetails.php";
	url=url+"?id="+id;
	url=url+"&quote_details_id="+quote_details_id;
	url=url+"&ran="+Math.random();
	
	xmlHttp.onreadystatechange=onSuccessDeleteQuoteDetails;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);

}
function onSuccessDeleteQuoteDetails(){
	if (xmlHttp.readyState==4)
	{
		
		id = innerHTML=xmlHttp.responseText;	
		showTemplate(id);
		document.getElementById("quote_status").style.display="block";
		document.getElementById("quote_status").innerHTML="Quote Details Deleted!";	
	}
}

function showQuoteForm(id,quote_details_id){
	
	document.getElementById("quote_status").style.display="none";
	document.getElementById("quote_status").innerHTML="";
	
	if(id=="" || id == null){
		alert("Id is Missing");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	
	var url=PATH+"showQuoteForm.php";
	url=url+"?id="+id;
	url=url+"&quote_details_id="+quote_details_id;
	url=url+"&ran="+Math.random();
	
	xmlHttp.onreadystatechange=onSuccessShowQuoteForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function onSuccessShowQuoteForm(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("right_panel").innerHTML=xmlHttp.responseText;	
		setQuote();
		setQuoteForClient();
		//setTimeZoneHour();
		//setWorkHour();
		//showAllQuotes();
	}
}



function showAllQuotes(){
	//document.getElementById("quote_status").innerHTML="";
	/*
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	
	var url=PATH+"showAllQuotes.php";
	url=url+"?ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessShowAllQuotes;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	*/
	searchQuote();
}
function onSuccessShowAllQuotes(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("quote_list").innerHTML=xmlHttp.responseText;	
		//showSearchForm()
	}
}

function searchQuote(){
	keyword = document.getElementById("keyword").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	
	document.getElementById("quote_list").innerHTML ="Searching...";
	var url=PATH+"searchQuote.php";
	url=url+"?keyword="+keyword;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function onSuccessSearchQuote(){
		if (xmlHttp.readyState==4)
			{
				document.getElementById("quote_list").innerHTML=xmlHttp.responseText;	
			}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function showSearchForm(){
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"showSearchForm.php";
	url=url+"?ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessShowSearchForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessShowSearchForm(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("search_div").innerHTML=xmlHttp.responseText;	
	}
}



function showForm(mode){
	document.getElementById("quote_status").innerHTML="";
	document.getElementById("quote_status").style.display="none";
	leads = document.getElementById("leads").value;
	
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	
	var url=PATH+"showForm.php";
	url=url+"?mode="+mode;
	url=url+"&ran="+Math.random();
	//if(leads_id!=""){
	url=url+"&leads_id="+leads;
	//}
	xmlHttp.onreadystatechange=onSuccessShowForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessShowForm()
{
	if (xmlHttp.readyState==4)
	{
		document.getElementById("right_panel").innerHTML=xmlHttp.responseText;	
	}
}



function setTimeZoneHour(){
	client_start_work_hour = document.getElementById("client_start_work_hour").value;
	client_finish_work_hour = document.getElementById("client_finish_work_hour").value;
	client_timezone = document.getElementById("client_timezone").value; 
	lunch_hour = document.getElementById("lunch_hour").value
	
	
	
	
	if(client_timezone!="" && client_start_work_hour!="" && client_finish_work_hour!="") {
		
		// calculate working hours
		hour = (client_finish_work_hour - client_start_work_hour);
		document.getElementById("hour").value = hour;
	
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
		  alert ("Your browser does not support AJAX!");
		  return;
		}
		var url=PATH+"convertTimeZone.php";
		url=url+"?client_start_work_hour="+client_start_work_hour;
		url=url+"&client_finish_work_hour="+client_finish_work_hour;
		url=url+"&client_timezone="+client_timezone;
		url=url+"&lunch_hour="+lunch_hour;
		url=url+"&ran="+Math.random();
		xmlHttp.onreadystatechange=onSuccessConfigureTimeZone;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}
	

}



function onSuccessConfigureTimeZone(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("staff_tz").innerHTML=xmlHttp.responseText;
		//setWorkHour();
		setQuote();
		
	}
}


function setWorkHour(){
	//alert(amount);
	//setLunchHour();
	var start =document.getElementById("start").value;
	var out =document.getElementById("out").value;
	//var lunch_hour = document.getElementById("lunch_hour").value
	lunch_start = document.getElementById("lunch_start").value;
	lunch_out = document.getElementById("lunch_out").value;
	
	//if(lunch_start!="" && lunch_out!=""){
	lunch_hour = (lunch_out - lunch_start);	
	document.getElementById("lunch_hour").value = lunch_hour;
	
	var total_hours = (out - start);
	if(total_hours < 0){
	//	total_hours = ((out + 24) - start);
	//alert(total_hours);
		total_hours = total_hours + 24 ;
	}
	//alert(lunch_hour);
	document.getElementById("hour").value = (total_hours - lunch_hour);
	setQuote();
}
















function quoteAgentForm(){
	leads_id = document.getElementById("leads_id").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	
	var url=PATH+"showAgentQuoteForm.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessShowQuoteAgentForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function onSuccessShowQuoteAgentForm(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("quote_form").innerHTML=xmlHttp.responseText;	
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
