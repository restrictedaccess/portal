// JavaScript Document
var xmlHttp
PATH ="testimonials/";

function highlight(obj) {
   obj.style.backgroundColor='yellow';
   obj.style.fontWeight="700";
   obj.style.cursor='pointer';
}
function unhighlight(obj) {
   obj.style.backgroundColor='';
   obj.style.fontWeight="";
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

function show_hide_blog_request_form(id){
	obj = document.getElementById(id);
	obj.style.display = (obj.style.display == "block") ? "none" : "block";
	div = document.getElementById('close_form');
	div.innerHTML = (div.innerHTML == "[close]") ? "[open]" : "[close]";
	
}

// Detect if the browser is IE or not.
// If it is not IE, we assume that the browser is NS.
var IE = document.all?true:false

// If NS -- that is, !IE -- then set up for mouse capture
if (!IE) document.captureEvents(Event.MOUSEMOVE)

// Set-up to use getMouseXY function onMouseMove
document.onmousemove = getMouseXY;
// Temporary variables to hold mouse x-y pos.s
var tempX = 0
var tempY = 0

// Main function to retrieve mouse x-y pos.s
function getMouseXY(e) {
  if (IE) { // grab the x-y pos.s if browser is IE
    tempX = event.clientX + document.body.scrollLeft
    tempY = event.clientY + document.body.scrollTop
  } else {  // grab the x-y pos.s if browser is NS
    tempX = e.pageX
    tempY = e.pageY
  }  
  // catch possible negative values in NS4
  if (tempX < 0){tempX = 0}
  if (tempY < 0){tempY = 0}  
  // show the position values in the form named Show
  // in the text fields named MouseX and MouseY
  document.form.MouseX.value = tempX
  document.form.MouseY.value = tempY
  return true;
}
function URLEncode (clearString) {
	//return clearString;
	var output = '';
	  var x = 0;
	  clearString = clearString.toString();
	  var regex = /(^[a-zA-Z0-9_.]*)'-/;
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





///AJAX
/*
New function created July 9, 2009
*/
function deleteStaffTestimonial(leads_id,testimony_id){
	if(confirm("Are you sure want to delete this Testimonial?")){
		userid = document.getElementById("userid").value;
		obj = document.getElementById("staff_testimonial_for_"+leads_id);
		
		xmlHttp=GetXmlHttpObject();
		var url=PATH+"deleteStaffTestimonial.php";
		url=url+"?userid="+userid;
		url=url+"&leads_id="+leads_id;
		url=url+"&testimony_id="+testimony_id;
		url=url+"&ran="+Math.random();
		xmlHttp.onreadystatechange=function OnSuccessDeleteTestimonials(){
			if (xmlHttp.readyState==4)
			{
				obj.innerHTML = xmlHttp.responseText;	
			}
		}
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		
	}
}

function updateStaffTestimonialForClient(leads_id,testimony_id){

	userid = document.getElementById("userid").value;
	testimony = URLEncode(document.getElementById("staff_tetimony_for_"+leads_id).value);
	if(testimony=="" || testimony == " "){
		alert("Please enter a Message!");
		return false;
	}
	
	obj = document.getElementById("staff_testimonial_for_"+leads_id);
	document.getElementById("show_testimonial_form_for_"+leads_id).style.display="none";
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"updateStaffTestimonialForClient.php";
	url=url+"?userid="+userid;
	url=url+"&leads_id="+leads_id;
	url=url+"&testimony_id="+testimony_id;
	url=url+"&testimony="+testimony;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessUpdateClientTestimonialForStaff() {
		if (xmlHttp.readyState==4)
		{
			obj.innerHTML=xmlHttp.responseText;
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}

function saveStaffTestimonialForClient(leads_id){
	userid = document.getElementById("userid").value;
	
	testimony = URLEncode(document.getElementById("staff_tetimony_for_"+leads_id).value);
	if(testimony=="" || testimony == " "){
		alert("Please enter a Message!");
		return false;
	}
	
	obj = document.getElementById("staff_testimonial_for_"+leads_id);
	document.getElementById("show_testimonial_form_for_"+leads_id).style.display="none";
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"saveStaffTestimonialForClient.php";
	url=url+"?userid="+userid;
	url=url+"&leads_id="+leads_id;
	url=url+"&testimony="+testimony;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessSaveStaffTestimonialForClient() {
		if (xmlHttp.readyState==4)
		{
			obj.innerHTML=xmlHttp.responseText;
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function showTestimonialClientForm(leads_id, testimony_id){
	obj = document.getElementById("show_testimonial_form_for_"+leads_id);
	obj.style.display="block";
	obj.innerHTML = "Loading...";	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showTestimonialClientForm.php";
	url=url+"?leads_id="+leads_id;
	if(testimony_id > 0) {
	url=url+"&testimony_id="+testimony_id;
	}
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessDeleteTestimonials(){
		if (xmlHttp.readyState==4)
		{
			obj.innerHTML=xmlHttp.responseText;	
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function updateStaffInfoDisplay(leads_id,staff_display_id){
	userid = document.getElementById("userid").value;
	obj = document.getElementById("staff_info_details_id_"+leads_id);
	obj.style.display="none";
	display_name = document.getElementById("staff_display_name_"+leads_id).value;
	display_company_name = document.getElementById("staff_display_company_name_"+leads_id).value;
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"updateStaffInfoDisplay.php";
	url=url+"?id="+staff_display_id;
	url=url+"&leads_id="+leads_id;
	url=url+"&userid="+userid;
	url=url+"&display_name="+display_name;
	url=url+"&display_company_name="+display_company_name;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessUpdateStaffInfoDisplay() {
		if (xmlHttp.readyState==4)
		{
			alert(xmlHttp.responseText);
			getStaffClient();
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function editStaffInfoDisplay(leads_id,staff_display_id){
	userid = document.getElementById("userid").value;
	obj = document.getElementById("staff_info_details_id_"+leads_id);
	obj.style.display="block";
	obj.innerHTML = "Loading...";	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"editStaffInfoDisplay.php";
	url=url+"?id="+staff_display_id;
	url=url+"&userid="+userid;
	url=url+"&leads_id="+leads_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessEditStaffInfoDisplay() {
		if (xmlHttp.readyState==4)
		{
			obj.innerHTML=xmlHttp.responseText;
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function updateClientInfoDisplay(userid,client_display_id){
	obj = document.getElementById("client_info_details_id_"+userid);
	obj.style.display="none";
	leads_id = document.getElementById("leads_id").value;
	display_name = document.getElementById("client_display_name_"+userid).value;
	display_company_name = document.getElementById("client_display_company_name_"+userid).value;
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"updateClientInfoDisplay.php";
	url=url+"?id="+client_display_id;
	url=url+"&leads_id="+leads_id;
	url=url+"&userid="+userid;
	url=url+"&display_name="+display_name;
	url=url+"&display_company_name="+display_company_name;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessUpdateClientInfoDisplay() {
		if (xmlHttp.readyState==4)
		{
			
			alert(xmlHttp.responseText);
			getClientStaff();
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
	
}
function editClientInfoDisplay(userid ,client_display_id){
	leads_id = document.getElementById("leads_id").value;
	obj = document.getElementById("client_info_details_id_"+userid);
	obj.style.display="block";
	obj.innerHTML = "Loading...";	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"editClientInfoDisplay.php";
	url=url+"?id="+client_display_id;
	url=url+"&leads_id="+leads_id;
	url=url+"&userid="+userid;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessEditClientInfoDisplay() {
		if (xmlHttp.readyState==4)
		{
			obj.innerHTML=xmlHttp.responseText;
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function getStaffClient(){
	userid = document.getElementById("userid").value;
	obj = document.getElementById("staff_testimonial_section");
	obj.innerHTML = "Loading...";	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"getStaffClient.php";
	url=url+"?userid="+userid;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessShowImageUploadForm() {
		if (xmlHttp.readyState==4)
		{
			obj.innerHTML=xmlHttp.responseText;
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}


function showImageUploadForm(userid){
	leads_id = document.getElementById("leads_id").value;
	obj = document.getElementById("image_form_"+userid);
	obj.style.display="block";
	obj.innerHTML = "Loading...";	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showImageUploadForm.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&userid="+userid;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessShowImageUploadForm() {
		if (xmlHttp.readyState==4)
		{
			obj.innerHTML=xmlHttp.responseText;
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}

function deleteTestimonial(userid,testimony_id){
	if(confirm("Are you sure want to delete this Testimonial?")){
		leads_id = document.getElementById("leads_id").value;	
		obj = document.getElementById("client_testimonial_for_"+userid);
		xmlHttp=GetXmlHttpObject();
		var url=PATH+"deleteTestimonial.php";
		url=url+"?leads_id="+leads_id;
		url=url+"&userid="+userid;
		url=url+"&testimony_id="+testimony_id;
		url=url+"&ran="+Math.random();
		xmlHttp.onreadystatechange=function OnSuccessDeleteTestimonials(){
			if (xmlHttp.readyState==4)
			{
				obj.innerHTML = xmlHttp.responseText;	
			}
		}
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
		
	}
}

function updateClientTestimonialForStaff(userid,testimony_id){
	//alert(testimony_id);
	leads_id = document.getElementById("leads_id").value;
	testimony = URLEncode(document.getElementById("client_tetimony_for_"+userid).value);
	if(testimony=="" || testimony == " "){
		alert("Please enter a Message!");
		return false;
	}
	document.getElementById("show_testimonial_form_for_"+userid).style.display="none";
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"updateClientTestimonialForStaff.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&userid="+userid;
	
	url=url+"&testimony_id="+testimony_id;
	url=url+"&testimony="+testimony;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessUpdateClientTestimonialForStaff() {
		if (xmlHttp.readyState==4)
		{
			//document.getElementById("client_testimonial_for_"+userid).style.display="block";
			document.getElementById("client_testimonial_for_"+userid).innerHTML=xmlHttp.responseText;
			//alert(xmlHttp.responseText);
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function saveClientTestimonialForStaff(userid){
	leads_id = document.getElementById("leads_id").value;
	testimony = URLEncode(document.getElementById("client_tetimony_for_"+userid).value);
	if(testimony=="" || testimony == " "){
		alert("Please enter a Message!");
		return false;
	}
	
	obj = document.getElementById("client_testimonial_for_"+userid);
	document.getElementById("show_testimonial_form_for_"+userid).style.display="none";
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"saveClientTestimonialForStaff.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&userid="+userid;
	url=url+"&testimony="+testimony;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessSaveClientTestimonialForStaff() {
		if (xmlHttp.readyState==4)
		{
			//document.getElementById("client_testimonial_for_"+userid).style.display="block";
			document.getElementById("client_testimonial_for_"+userid).innerHTML=xmlHttp.responseText;
			//alert(xmlHttp.responseText);
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}



function showTestimonialForm(userid, testimony_id){
	
	obj = document.getElementById("show_testimonial_form_for_"+userid);
	topPos = document.getElementById("MouseX").value;
	leftPos =document.getElementById("MouseY").value;
	
	obj.style.top = (topPos);
	obj.style.top = (leftPos);
	obj.style.display="block";
	obj.innerHTML = "Loading...";	
	
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showTestimonialForm.php";
	url=url+"?userid="+userid;
	if(testimony_id > 0) {
	url=url+"&testimony_id="+testimony_id;
	}
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessDeleteTestimonials(){
		if (xmlHttp.readyState==4)
		{
			obj.innerHTML=xmlHttp.responseText;	
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
	
}


function getClientStaff(){
	leads_id = document.getElementById("leads_id").value;
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"getClientStaff.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessGetClientStaff;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function OnSuccessGetClientStaff(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("client_testimonial_section").innerHTML = xmlHttp.responseText;	
	}
}






////



















function showStaffClientCreateTestimonialsForm(value){
	document.getElementById("result").innerHTML = "Loading....";
	testimony_id = document.getElementById("testimony_id").value;
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showStaffClientCreateTestimonialsForm.php";
	url=url+"?value="+value;
	url=url+"&testimony_id="+testimony_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessShowStaffClientCreateTestimonialsForm(){
		if (xmlHttp.readyState==4)
		{
			document.getElementById("result").innerHTML=xmlHttp.responseText;	
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);

	
}
function updateAdminReply(testimony_reply_id, mode){
	obj = document.getElementById("testimony_reply_id_"+testimony_reply_id);
	//obj2 = document.getElementById(mode+"_reply_form_"+testimony_id);
	//reply = URLEncode(document.getElementById("reply").value);
	reply = URLEncode(document.getElementById("reply_update_"+testimony_reply_id).value);
	status = document.getElementById("testimony_status_update_"+testimony_reply_id).value;
	
	if(reply == "" || reply == " " || reply == null){
		alert("There is no message");
		return false;
	}
	if(mode == ""){
		alert("Check the mode...");
		return false;
	}
	
	//if(status == "delete"){
	//	if(confirm("This will permanently delete the Testimony from the System ?")){
			
	//	}
	//}
	
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"updateAdminReply.php";
	url=url+"?testimony_reply_id="+testimony_reply_id;
	url=url+"&mode="+mode;
	url=url+"&reply="+reply;
	url=url+"&status="+status;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessShowAddNotesForm(){
		if (xmlHttp.readyState==4)
		{
			obj.innerHTML=xmlHttp.responseText;	
			//obj2.style.display = "none";
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);

}

function saveAdminReply(testimony_id, mode){
	obj = document.getElementById(testimony_id+"_testimony_replies");
	obj2 = document.getElementById(mode+"_reply_form_"+testimony_id);
	reply = URLEncode(document.getElementById("reply_save_"+testimony_id).value);
	status = document.getElementById("testimony_status_save_"+testimony_id).value;
	
	if(reply == "" || reply == " " || reply == null){
		alert("There is no message");
		return false;
	}
	if(mode == ""){
		alert("Check the mode...");
		return false;
	}
	
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"saveAdminReply.php";
	url=url+"?id="+testimony_id;
	url=url+"&mode="+mode;
	url=url+"&reply="+reply;
	url=url+"&status="+status;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessShowAddNotesForm(){
		if (xmlHttp.readyState==4)
		{
			obj.innerHTML=xmlHttp.responseText;	
			obj2.style.display = "none";
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function showAdminReplyForm(id , mode){

	topPos = document.getElementById("MouseX").value;
	leftPos =document.getElementById("MouseY").value;
	obj = document.getElementById(mode+"_reply_form_"+id);
	obj.style.top = (topPos);
	obj.style.top = (leftPos);
	obj.style.display="block";
	obj.innerHTML = "Loading...";
	
	if(mode == ""){
		alert("Check the mode...");
		return false;
	}
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showAdminReplyForm.php";
	url=url+"?id="+id;
	url=url+"&mode="+mode;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessShowAddNotesForm(){
		if (xmlHttp.readyState==4)
		{
			obj.innerHTML=xmlHttp.responseText;	
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}

function saveReply(id , mode){
	obj = document.getElementById(mode+"_reply_form_"+id);
	reply = URLEncode(document.getElementById("reply").value);
	//alert(reply);
	if(mode == ""){
		alert("Check the mode...");
		return false;
	}
	
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"saveReply.php";
	url=url+"?id="+id;
	url=url+"&mode="+mode;
	url=url+"&reply="+reply;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessShowAddNotesForm(){
		if (xmlHttp.readyState==4)
		{
			obj.innerHTML=xmlHttp.responseText;	
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}

function showReplyForm(id , mode){

	topPos = document.getElementById("MouseX").value;
	leftPos =document.getElementById("MouseY").value;
	obj = document.getElementById(mode+"_reply_form_"+id);
	obj.style.top = (topPos);
	obj.style.top = (leftPos);
	obj.style.display="block";
	obj.innerHTML = "Loading...";
	
	if(mode == ""){
		alert("Check the mode...");
		return false;
	}
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showReplyForm.php";
	url=url+"?id="+id;
	url=url+"&mode="+mode;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessShowAddNotesForm(){
		if (xmlHttp.readyState==4)
		{
			obj.innerHTML=xmlHttp.responseText;	
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}





function showImage(userid){
	document.getElementById("show_image").innerHTML = "Loading staff image...";
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showImage.php";
	url=url+"?userid="+userid;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessShowImage;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function OnSuccessShowImage(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("show_image").innerHTML=xmlHttp.responseText;	
	}
}

function getAllTestimonials(){
	document.getElementById("testimonials").innerHTML="Loading...";
	xmlHttp=GetXmlHttpObject();
	
	var url=PATH+"getAllTestimonials.php";
	
	url=url+"?ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessGetAllApprovedTestimonials;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function getAllApprovedTestimonials(){
	document.getElementById("testimonials").innerHTML="Loading...";
	xmlHttp=GetXmlHttpObject();
	
	var url=PATH+"getAllApprovedTestimonials.php";
	
	url=url+"?ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessGetAllApprovedTestimonials;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function OnSuccessGetAllApprovedTestimonials()
{
	if (xmlHttp.readyState==4)
	{
		document.getElementById("testimonials").innerHTML=xmlHttp.responseText;	
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