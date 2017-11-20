// used by agent_set_up_fee_invoice.php
// Created By: NOrmaneil Macutay
// Jan . 29. 2009

var xmlHttp
PATH ="invoice/set_up_fee_invoice/";

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
function hide(sid) 
{
   obj = document.getElementById(sid);
   obj.style.display = "none";
}

function addCancelVAT(set_fee_invoice_id,flag){
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"AddCancelVAT.php";
	url=url+"?set_fee_invoice_id="+set_fee_invoice_id;
	url=url+"&flag="+flag;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessAddCancelGSTInvoice;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function searchSetupFeeTaxInvoice(keyword){
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"searchSetupFeeTaxInvoice.php";
	url=url+"?keyword="+keyword;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessShowAllSetUpFeeInvoice;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function editSetUpFeeDetails(id){
	if(id==null){
		alert("Set Up Fee Tax Invoice Details ID is missing.");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"editSetUpFeeInvoiceDetails.php";
	url=url+"?id="+id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessEditSetUpFeeDetails;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function OnSuccessEditSetUpFeeDetails(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("edit_div").style.display="block";
		document.getElementById("edit_div").innerHTML=xmlHttp.responseText;
	}
}

function editLeadsInfo(){
	set_fee_invoice_id = document.getElementById("set_fee_invoice_id").value;
	//alert(set_fee_invoice_id);
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"editLeadsInfo.php";
	url=url+"?set_fee_invoice_id="+set_fee_invoice_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessEditLeadsInfo;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function OnSuccessEditLeadsInfo()
{
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("leads_info_edit_div").style.display="block";
		document.getElementById("leads_info_edit_div").innerHTML=xmlHttp.responseText;
	}
}
function updateLeadsInfo(id){
	
	edit_leads_email = document.getElementById("edit_leads_email").value;
	edit_leads_company = document.getElementById("edit_leads_company").value;
	edit_leads_address = document.getElementById("edit_leads_address").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"updateLeadsInfo.php";
	url=url+"?id="+id;
	url=url+"&edit_leads_email="+edit_leads_email;
	url=url+"&edit_leads_company="+edit_leads_company;
	url=url+"&edit_leads_address="+edit_leads_address;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessUpdateLeadsInfo;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function OnSuccessUpdateLeadsInfo()
{
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("leads_info_edit_div").style.display="none";
		document.getElementById("leads_info").innerHTML=xmlHttp.responseText;
	}
}
function updateSetUpFeeDetails(id){
	if(id==null){
		alert("Set Up Fee Tax Invoice Details ID is missing.");
		return false;
	}
	set_fee_invoice_id = document.getElementById("set_fee_invoice_id").value;
	currency = document.getElementById("currency_rate").value;
	description = document.getElementById("description").value;
	amount = document.getElementById("amount").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"updateSetUpFeeInvoiceDetails.php";
	url=url+"?id="+id;
	url=url+"&description="+description;
	url=url+"&amount="+amount;
	url=url+"&currency="+currency;
	url=url+"&set_fee_invoice_id="+set_fee_invoice_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessUpdateSetUpFeeDetails;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	//alert(url);
}
function OnSuccessUpdateSetUpFeeDetails(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("edit_div").style.display="none";	
		document.getElementById("set_up_fee_invoice_details").innerHTML=xmlHttp.responseText;
		getInvoiceTotal();
	}
}
function deleteSetUpFeeDetails(id){
	set_fee_invoice_id = document.getElementById("set_fee_invoice_id").value;
	if(id==null){
		alert("Set Up Fee Tax Invoice Details ID is missing.");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"deleteSetUpFeeDetails.php";
	url=url+"?id="+id;
	url=url+"&set_fee_invoice_id="+set_fee_invoice_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessUpdateSetUpFeeDetails;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}

function calculateChargeOutRate() { 

	currency =  document.getElementById("currency").value;
	var currency_desc;
	if(currency == "AUD"){
		currency_desc = "Invoice to be paid in Australian Dollar";
	}
	if(currency == "USD"){
		
		currency_desc = "Invoice to be paid in United States Dollar";
	}
	if(currency == "POUND"){
		
		currency_desc = "Invoice to be paid in United Kingdom Pounds";
	}
	if(currency == ""){
		
		currency_desc = "";
	}
	

	document.getElementById("currency_desc").innerHTML = currency_desc;

	
	
}

// Check the Inputs
// If the Dropdown box is chosen the 2 textboxes must be null or if the user type data in the 2 textboxes the dropdon must be seleceted to 0;
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
function createJobRoleQuote(){
	currency = document.getElementById("currency_rate").value;
	
	if(currency == "AUD"){
		initial_charge = 200;
		extra_charge = 150;
		currency_symbol = "$";
	}
	if(currency == "USD"){
		
		initial_charge = 200;
		extra_charge = 150;
		currency_symbol = "$";
	}
	if(currency == "POUND"){
		
		initial_charge = 130;
		extra_charge = 80;
		currency_symbol = "&pound;";
	}
	
	
	job_roles = document.getElementById("job_roles").value;
	no_of_staff = document.getElementById("no_of_staff").value;
	if(isNaN(no_of_staff)){
		alert("Please enter a valid number!");
		document.getElementById("no_of_staff").value = "";
		document.getElementById("steps_taken_quote").innerHTML="";
		return false;
	}
	if(job_roles!="" && no_of_staff!=""){
		if(no_of_staff==1){
			price = parseInt(no_of_staff) * initial_charge;
			str = job_roles + ". No. of Staff "+ no_of_staff + ". Set-up price is "+ currency_symbol+price;
		}
		if(no_of_staff>1){
			price = initial_charge + ((parseInt(no_of_staff)-1) * extra_charge);
			str = job_roles + ". Initial (1) Staff = "+currency_symbol+Math.round(initial_charge*100)/100+" .<br>";
			str+= "Additional Staff "+ (no_of_staff-1) + " x "+ currency_symbol+Math.round(extra_charge*100)/100 +" = " + currency_symbol+((no_of_staff-1)*extra_charge) + ". Set-up price is "+ currency_symbol+ Math.round(price*100)/100;
		}
		document.getElementById("steps_taken_quote").innerHTML=str;
	}else{
		document.getElementById("steps_taken_quote").innerHTML="";
	}
}
// show the form
function addJobRole(set_fee_invoice_id){
	currency = document.getElementById("currency_rate").value;
	job_roles = document.getElementById("job_roles").value;
	no_of_staff = document.getElementById("no_of_staff").value;
	if(set_fee_invoice_id==""){
		alert("Set-Up Fee Invoice ID is Missing");
		return false;
	}
	if(job_roles==""){
		alert("Please Enter a Job Role");
		return false;
	}
	if(no_of_staff=="" ){
		alert("Please Enter number of Staff needed");
		return false;
	}
	if (isNaN(no_of_staff)==true){
		alert("Please Enter a valid number of Staff ");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"addSetUpFeeInvoiceDetails.php";
	url=url+"?set_fee_invoice_id="+set_fee_invoice_id;
	url=url+"&job_roles="+job_roles;
	url=url+"&no_of_staff="+no_of_staff;
	url=url+"&currency="+currency;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessAddJobRole;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
	
}
function OnSuccessAddJobRole(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("job_roles").value = "";
		document.getElementById("no_of_staff").value = "";
		document.getElementById("set_up_fee_invoice_details").innerHTML=xmlHttp.responseText;
		getInvoiceTotal();
	}
}
function getInvoiceTotal(){
	set_fee_invoice_id = document.getElementById("set_fee_invoice_id").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"getInvoiceTotal.php";
	url=url+"?set_fee_invoice_id="+set_fee_invoice_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessGetInvoiceTotal;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function OnSuccessGetInvoiceTotal(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("payment_details").innerHTML=xmlHttp.responseText;
	}
}

function addGST(set_fee_invoice_id,flag){
	set_fee_invoice_id = document.getElementById("set_fee_invoice_id").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"AddCancelGstInvoice.php";
	url=url+"?set_fee_invoice_id="+set_fee_invoice_id;
	url=url+"&flag="+flag;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessAddCancelGSTInvoice;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function OnSuccessAddCancelGSTInvoice(){
	if (xmlHttp.readyState==4)
	{ 
		id = document.getElementById("set_fee_invoice_id").value;
		showRightPanelDisplay(id)	
	}
}

function updateSetUpFeeInvoiceStatus(status){
	id = document.getElementById("set_fee_invoice_id").value;
	//alert(id +" "+status);
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	if(status == "posted") {
		if(confirm("Send this Set-Up Fee Invoice via Email.")){
			//alert("Sent Email");
			
			var url=PATH+"updateStatusInvoice.php";
			url=url+"?set_fee_invoice_id="+id;
			url=url+"&status="+status;
			url=url+"&ran="+Math.random();
			xmlHttp.onreadystatechange=OnSuccessUpdateSetUpFeeInvoiceStatus;
			xmlHttp.open("GET",url,true);
			xmlHttp.send(null);
			
			
		}else{
			return false;
		}
		
	}
	if(status == "paid") {
		var url=PATH+"updateStatusInvoice.php";
		url=url+"?set_fee_invoice_id="+id;
		url=url+"&status="+status;
		url=url+"&ran="+Math.random();
		xmlHttp.onreadystatechange=OnSuccessUpdateSetUpFeeInvoiceStatus;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		
	}
	
	
}
function OnSuccessUpdateSetUpFeeInvoiceStatus(){
	if (xmlHttp.readyState==4)
	{ 
		//date_invoice_details
		//document.getElementById("right_panel").innerHTML = xmlHttp.responseText;
		id = document.getElementById("set_fee_invoice_id").value;
		showRightPanelDisplay(id)	
	}
}
// Delete Set-Fee Invoice
function deleteSetUpFeeInvoice(set_fee_invoice_id){
	//set_fee_invoice_id = document.getElementById("set_fee_invoice_id").value;
	if(confirm("Are you sure you want to delete this Set-Up Fee Invoice")){
		document.getElementById("create").disabled="";
		document.getElementById("create_box").style.display="none";
		
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
		  alert ("Your browser does not support AJAX!");
		  return;
		}
		var url=PATH+"deleteSetUpFeeInvoice.php";
		url=url+"?set_fee_invoice_id="+set_fee_invoice_id;
		url=url+"&sid="+Math.random();
		xmlHttp.onreadystatechange=OnSuccessDeleteSetUpFeeInvoice;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}else{
		return false;
	}
}
function OnSuccessDeleteSetUpFeeInvoice(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("right_panel").innerHTML=xmlHttp.responseText;
		showAllSetUpFeeInvoice();
	}
}

// Add Set-Up Fee Invoice Details
function addSetUpFeeInvoiceDetails(){
	set_fee_invoice_id = document.getElementById("set_fee_invoice_id").value;
	alert(set_fee_invoice_id);	
}
// Show all Set-Up Fee Invoice
function showAllSetUpFeeInvoice(){
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url=PATH+"showAllSetUpFeeInvoiceList.php";
	url=url+"?sid="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessShowAllSetUpFeeInvoice;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function OnSuccessShowAllSetUpFeeInvoice(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("set_up_fee_invoice_list").innerHTML=xmlHttp.responseText;
	}
}

// show the Set-Up Fee Invoice to the right_panel div
function showRightPanelDisplay(id){
	if(id==""){
		document.getElementById("right_panel").innerHTML = "Set-Up Fee Invoice Id is Missing...";
		return false;
	}
	document.getElementById("right_panel").innerHTML = "Loading Set-Up Fee Invoice...";
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url=PATH+"showSetUpFeeInvoice.php";
	url=url+"?set_fee_invoice_id="+id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessShowSetUpFeeInvoice;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function OnSuccessShowSetUpFeeInvoice(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("right_panel").innerHTML=xmlHttp.responseText;
		//showAllSetUpFeeInvoice();
	}
}

// Create new Set-Fee Invoice
function createNewInvoiceSetUpFee(){
	document.getElementById("create_box").style.display = "block";
	//document.getElementById("create_box").innerHTML="Loading....";
	
	leads_id = document.getElementById("leads_id").value;
	//leads_name = document.getElementById("leads_name").value;
	//leads_email = document.getElementById("leads_email").value;
	//leads_company = document.getElementById("leads_company").value;
	//leads_address = document.getElementById("leads_address").value;
	currency =  document.getElementById("currency").value;
	
	if(currency==""){
		alert("Please Choose Invoice Currency");
		return false;
	}
	//if(leads_id=="0" && leads_name =="" && leads_email==""){
	if(leads_id=="0"){	
		alert("Please enter Leads or Prospect Name or Email or select from the leads list !");
		return false;
	}
	
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
	  alert ("Your browser does not support AJAX!");
	  return;
  	}
	var url=PATH+"createSetUpFeeInvoice.php";
	url=url+"?sid="+Math.random();
	url=url+"&leads_id="+leads_id;
	//url=url+"&leads_name="+leads_name;
	//url=url+"&leads_email="+leads_email;
	url=url+"&currency="+currency;
	//url=url+"&leads_company="+leads_company;
	//url=url+"&leads_address="+leads_address;
	xmlHttp.onreadystatechange=OnSuccessCreateSetUpFeeInvoice;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function OnSuccessCreateSetUpFeeInvoice() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("create_box").innerHTML=xmlHttp.responseText;
		document.getElementById("create_new_div").style.display = "none";
		set_fee_invoice_id = document.getElementById("set_fee_invoice_id").value;
		showRightPanelDisplay(set_fee_invoice_id);
		
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
