// JavaScript Document
/*
A script for Admin use only in the maintenance of Testimonials both for Staff and Client
Data Created : July 21, 2009

*/


var xmlHttp
PATH ="testimonials/admin/";

function highlight(id) {
   obj = document.getElementById("wrapper_id_"+id);	
   obj.style.backgroundColor='yellow';
   obj.style.fontWeight="700";
   obj.style.cursor='pointer';
}
function unhighlight(id) {
   obj = document.getElementById("wrapper_id_"+id);
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
  var regex = /(^[a-zA-Z0-9_.]*)-'/;
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
function showStatusTxt(recipient_id){
	status = document.getElementById("testimonial_status_for_"+recipient_id).value;
	obj = document.getElementById("testimonial_status_txt_for_"+recipient_id);
	//button = document.getElementById("button_for_"+recipient_id);
	// 'posted','cancel'
	if(status=='posted'){
		obj.innerHTML = " Approved and Post (Display) this Testimonial.";
	}
	if(status=='cancel'){
		obj.innerHTML = " Cancel this Testimonial";
	}
	if(status==''){
		obj.innerHTML = " ";
	}
}
function ApproveCancelTestimonial(created_by_id,created_by_type,recipient_id,recipient_type,testimony_id){
	status = document.getElementById("testimonial_status_for_"+recipient_id).value;
	testimony_status = status;
	// 'posted','cancel'
	if(status == 'posted') {
		stat_txt = "Approved and Post";
	}
	if(status == 'cancel') {
		stat_txt = "Cancel";
	}
	if(confirm(stat_txt+" this Testimonial")) {
		if(created_by_type == "subcon"){
		obj = document.getElementById("show_testimonial_form_for_"+recipient_id);
		}
		if(created_by_type == "leads"){
		obj = document.getElementById("show_testi_form_for_"+created_by_id);
		}
		obj.style.display="none";
		
		status = document.getElementById("testimonial_status_for_"+recipient_id).value;
		xmlHttp=GetXmlHttpObject();
		var url=PATH+"approvedAdminTestimonial.php";
		url=url+"?created_by_id="+created_by_id;
		url=url+"&created_by_type="+created_by_type;
		url=url+"&recipient_id="+recipient_id;
		url=url+"&recipient_type="+recipient_type;
		url=url+"&testimony_id="+testimony_id;
		url=url+"&testimony_status="+status;
		
		url=url+"&ran="+Math.random();
		xmlHttp.onreadystatechange=function OnSuccessDeleteTestimonials(){
			if (xmlHttp.readyState==4)
			{
				if(recipient_type=="leads"){	
					obj = document.getElementById("staff_testimonial_for_"+recipient_id);
				}
				if(recipient_type=="subcon"){	
					obj = document.getElementById("client_testimonial_"+created_by_id);
				}
				obj.innerHTML=xmlHttp.responseText;	
			}
		}
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}
}

function approvedAdminTestimonial(created_by_id,created_by_type,recipient_id,recipient_type,testimony_id){
	if(created_by_type == "subcon"){
	obj = document.getElementById("show_testimonial_form_for_"+recipient_id);
	}
	if(created_by_type == "leads"){
	obj = document.getElementById("show_testi_form_for_"+created_by_id);
	}
	obj.style.display="block";
	obj.innerHTML = "Loading...";	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showAdminApproveCancelTestimonialForm.php";
	url=url+"?created_by_id="+created_by_id;
	url=url+"&created_by_type="+created_by_type;
	url=url+"&recipient_id="+recipient_id;
	url=url+"&recipient_type="+recipient_type;
	url=url+"&testimony_id="+testimony_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessDeleteTestimonials(){
		if (xmlHttp.readyState==4)
		{
			obj.innerHTML=xmlHttp.responseText;	
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
	/*
	if(confirm("Approved and Post this Testimonial")) {
		xmlHttp=GetXmlHttpObject();
		var url=PATH+"approvedAdminTestimonial.php";
		url=url+"?created_by_id="+created_by_id;
		url=url+"&created_by_type="+created_by_type;
		url=url+"&recipient_id="+recipient_id;
		url=url+"&recipient_type="+recipient_type;
		url=url+"&testimony_id="+testimony_id;
		url=url+"&ran="+Math.random();
		xmlHttp.onreadystatechange=function OnSuccessDeleteTestimonials(){
			if (xmlHttp.readyState==4)
			{
				if(recipient_type=="leads"){	
					obj = document.getElementById("staff_testimonial_for_"+recipient_id);
				}
				if(recipient_type=="subcon"){	
					obj = document.getElementById("client_testimonial_"+created_by_id);
				}
				obj.innerHTML=xmlHttp.responseText;	
			}
		}
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}
	*/
	
}


function deleteAdminTestimonial(created_by_id,created_by_type,recipient_id,recipient_type,testimony_id){
	
	if(confirm("Are you sure you want delete this ?")) {
		xmlHttp=GetXmlHttpObject();
		var url=PATH+"deleteAdminTestimonial.php";
		url=url+"?created_by_id="+created_by_id;
		url=url+"&created_by_type="+created_by_type;
		url=url+"&recipient_id="+recipient_id;
		url=url+"&recipient_type="+recipient_type;
		url=url+"&testimony_id="+testimony_id;
		url=url+"&ran="+Math.random();
		xmlHttp.onreadystatechange=function OnSuccessDeleteTestimonials(){
			if (xmlHttp.readyState==4)
			{
				if(recipient_type=="leads"){	
					obj = document.getElementById("staff_testimonial_for_"+recipient_id);
				}
				if(recipient_type=="subcon"){	
					obj = document.getElementById("client_testimonial_"+created_by_id);
				}
				obj.innerHTML=xmlHttp.responseText;	
			}
		}
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}
	
}
function saveupdateAdminTestimonial(created_by_id,created_by_type,recipient_id,recipient_type,testimony_id){

	admin_testimony = URLEncode(document.getElementById("admin_tetimony_for_"+recipient_id).value);
	if(admin_testimony==""){
		alert("Please enter a Message!");
		return false;
	}
	
	if(created_by_type == "subcon"){
	obj = document.getElementById("show_testimonial_form_for_"+recipient_id);
	}
	if(created_by_type == "leads"){
	obj = document.getElementById("show_testi_form_for_"+created_by_id);
	}
	obj.style.display="none";
	
	
	
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"saveupdateAdminTestimonial.php";
	url=url+"?created_by_id="+created_by_id;
	url=url+"&created_by_type="+created_by_type;
	url=url+"&recipient_id="+recipient_id;
	url=url+"&recipient_type="+recipient_type;
	url=url+"&testimony_id="+testimony_id;
	url=url+"&admin_testimony="+admin_testimony;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessDeleteTestimonials(){
		if (xmlHttp.readyState==4)
		{
			if(recipient_type=="leads"){	
				obj = document.getElementById("staff_testimonial_for_"+recipient_id);
			}
			if(recipient_type=="subcon"){	
				obj = document.getElementById("client_testimonial_"+created_by_id);
			}
			obj.innerHTML=xmlHttp.responseText;	
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function showAdminTestimonialForm(created_by_id,created_by_type,recipient_id,recipient_type,testimony_id){
	if(created_by_type == "subcon"){
	obj = document.getElementById("show_testimonial_form_for_"+recipient_id);
	}
	if(created_by_type == "leads"){
	obj = document.getElementById("show_testi_form_for_"+created_by_id);
	}
	obj.style.display="block";
	obj.innerHTML = "Loading...";	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showAdminTestimonialForm.php";
	url=url+"?created_by_id="+created_by_id;
	url=url+"&created_by_type="+created_by_type;
	url=url+"&recipient_id="+recipient_id;
	url=url+"&recipient_type="+recipient_type;
	url=url+"&testimony_id="+testimony_id;
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


function updateClientInfoDisplay(leads_id,userid,client_display_id){
	obj = document.getElementById("client_info_details_id_"+userid);
	obj.style.display="none";
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
			getTestimonialListFrom(userid,'staff');
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function editClientInfoDisplay(leads_id,userid,client_display_id){
	
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
function updateStaffInfoDisplay(leads_id,userid,staff_display_id){
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
			getTestimonialListFrom(userid,'staff');
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function editStaffInfoDisplay(leads_id,userid,staff_display_id){
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


function getTestimonialListFrom(id,section){
	//alert(id+"\n"+section);
	obj = document.getElementById("testimonials");
	obj.innerHTML = "Loading...";
	xmlHttp=GetXmlHttpObject();
	
	if(section=="staff"){
		var url=PATH+"getTestimonialListFromStaff.php";
	}
	if(section=="clients"){
		var url=PATH+"getTestimonialListFromClient.php";
	}
	url=url+"?id="+id;
	url=url+"&section="+section;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessGetTestimonialListFrom;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function OnSuccessGetTestimonialListFrom(){
	if (xmlHttp.readyState==4)
	{
		obj = document.getElementById("testimonials");
		obj.innerHTML = xmlHttp.responseText;	
	}
}

function getTestimonialsFromSearch(keyword){
	section = "search"
	document.getElementById("section_txt").innerHTML ="Search Result";
	obj = document.getElementById("sections");
	obj.innerHTML = "Loading...";
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"getTestimonialsFrom.php";
	url=url+"?section="+section;
	url=url+"&keyword="+keyword;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessGetUsersType;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function getTestimonialsFrom(){
	section = document.getElementById("section").value;
	document.getElementById("section_txt").innerHTML = section.toUpperCase() + " LIST ";
	obj = document.getElementById("sections");
	obj.innerHTML = "Loading...";
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"getTestimonialsFrom.php";
	url=url+"?section="+section;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessGetUsersType;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function OnSuccessGetUsersType(){
	if (xmlHttp.readyState==4)
	{
		obj = document.getElementById("sections");
		obj.innerHTML = "Loading...";
		obj.innerHTML = xmlHttp.responseText;	
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