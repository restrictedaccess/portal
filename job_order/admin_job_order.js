// JavaScript Document

var xmlHttp
PATH ="job_order/";
//PATH ="";

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

function showStar(value){
	var str="";
	for(var i = 0 ; i<value ; i++){
		str+= "<img src=\"images/star.png\">";
	}
	
	document.getElementById("star").innerHTML = str;
	
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

////////// AJAX 
function saveRecruitmentDetails(){
	recruitment_details_id = document.getElementById("recruitment_details_id").value;
	leads_id =  document.getElementById("leads_id").value;
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id =  document.getElementById("job_order_form_id").value;
	job_order_list_id =  document.getElementById("job_order_list_id").value;
	
	recruitment_start_date =  document.getElementById("recruitment_start_date").value;
	budget =  document.getElementById("budget").value;
	set_up_fee_payment =  document.getElementById("set_up_fee_payment").value;
	jd_link =  document.getElementById("jd_link").value;
	
	comments =  URLEncode(document.getElementById("comments").value);
	
	if(job_order_list_id==null){
		alert("job_order_list_id is null");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"saveRecruitmentDetails.php";
	url=url+"?recruitment_details_id="+recruitment_details_id;
	url=url+"&leads_id="+leads_id;
	url=url+"&job_order_id="+job_order_id;
	url=url+"&job_order_form_id="+job_order_form_id;
	url=url+"&job_order_list_id="+job_order_list_id;
	url=url+"&recruitment_start_date="+recruitment_start_date;
	url=url+"&budget="+budget;
	url=url+"&set_up_fee_payment="+set_up_fee_payment;
	url=url+"&jd_link="+jd_link;
	url=url+"&comments="+comments;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessSaveRecruitmentDetails;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function OnSuccessSaveRecruitmentDetails(){
	if (xmlHttp.readyState==4)
	{
		alert("Details has been Saved !");
		document.getElementById("recruitment_notes").innerHTML = xmlHttp.responseText;
	}
}


function addRatings(recruitment_candidates_id){
	//alert(recruitment_candidates_id);
	ratings = document.getElementById("ratings").value;
	if(recruitment_candidates_id==null){
		alert("recruitment_candidates_id is null");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"addRatings.php";
	url=url+"?recruitment_candidates_id="+recruitment_candidates_id;
	url=url+"&ratings="+ratings;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessAddRatings(){
		if (xmlHttp.readyState==4)
		{
			
			obj = document.getElementById(recruitment_candidates_id+"_ratings");
			obj.innerHTML = xmlHttp.responseText;
			alert("Candidate has been Rated!");	
			document.getElementById("rating_form").style.display="none";
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function showRateCandidateForm(recruitment_candidates_id,userid){
	
	topPos = document.getElementById("MouseX").value;
	leftPos =document.getElementById("MouseY").value;
	
	document.getElementById("rating_form").style.top = (topPos);
	document.getElementById("rating_form").style.top = (leftPos);
	document.getElementById("rating_form").style.display="block";
	document.getElementById("rating_form").innerHTML = "Loading...";
	
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showRateCandidateForm.php";
	url=url+"?recruitment_candidates_id="+recruitment_candidates_id;
	url=url+"&userid="+userid;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessShowRateCandidateForm() {
		//
		if (xmlHttp.readyState==4)
		{
			document.getElementById("rating_form").innerHTML=xmlHttp.responseText;	
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function deleteCandidate(recruitment_candidates_id){
	if(recruitment_candidates_id==null){
		alert("recruitment_candidates_id is null");
		return false;
	}
	if(confirm("Are you sure you want to remove this Candidate from the List ? ")){
		xmlHttp=GetXmlHttpObject();
		var url=PATH+"deleteCandidate.php";
		url=url+"?recruitment_candidates_id="+recruitment_candidates_id;
		url=url+"&ran="+Math.random();
		xmlHttp.onreadystatechange=function OnSuccessDeleteCandidate(){
			if (xmlHttp.readyState==4)
			{
				showCandidates();
				alert("Candidate has been removed from the List");
			}
		}
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}else{
		return false;
	}
}
function updateCandidate(recruitment_candidates_id){

	if(recruitment_candidates_id==null){
		alert("recruitment_candidates_id is null");
		return false;
	}
	
	
	job_order_list_id =  document.getElementById("job_order_list_id").value;
	
	userid =  document.getElementById("userid").value;
	candidate_status=  document.getElementById("candidate_status").value;
	expected_salary=  document.getElementById("expected_salary").value;
		
	
	if(userid == 0){
		alert("Please choose Applicant.");
		return false;
	}
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"updateCandidate.php";
	url=url+"?recruitment_candidates_id="+recruitment_candidates_id;
	url=url+"&job_order_list_id="+job_order_list_id;
	url=url+"&userid="+userid;
	url=url+"&candidate_status="+candidate_status;
	url=url+"&expected_salary="+expected_salary;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessUpdateCandidate(){
		if (xmlHttp.readyState==4)
		{
			
			obj = document.getElementById(recruitment_candidates_id);
			obj.innerHTML = xmlHttp.responseText;
			alert("Updated!");	
			document.getElementById("candidates_add_form").style.display="none";
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}

function showAddNotesForm(recruitment_candidates_id , userid){
	
	//myDiv = document.getElementById(recruitment_candidates_id);
	//top = myDiv.offsetTop;
	topPos = document.getElementById("MouseX").value;
	leftPos =document.getElementById("MouseY").value;
	
	
	document.getElementById("notes_add_form").style.top = (topPos);
	document.getElementById("notes_add_form").style.top = (leftPos);
	document.getElementById("notes_add_form").style.display="block";
	document.getElementById("notes_add_form").innerHTML = "Loading...";
	
	
	
	if(recruitment_candidates_id == null){
		alert("recruitment_candidates_id is null.");
		return false;
	}
	if(userid == null){
		alert("userid is null.");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showAddNotesForm.php";
	url=url+"?recruitment_candidates_id="+recruitment_candidates_id;
	url=url+"&userid="+userid;
	url=url+"&ran="+Math.random();
	//xmlHttp.onreadystatechange=OnSuccessShowCandidatesAddForm;
	xmlHttp.onreadystatechange=function OnSuccessShowAddNotesForm(){
		if (xmlHttp.readyState==4)
		{
			document.getElementById("notes_add_form").innerHTML=xmlHttp.responseText;	
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}


function addNotes(recruitment_candidates_id , userid){
	notes = URLEncode(document.getElementById("notes2").value);

	if(recruitment_candidates_id == null){
		alert("recruitment_candidates_id is null.");
		return false;
	}
	if(userid == null){
		alert("userid is null.");
		return false;
	}
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"addNotes.php";
	url=url+"?recruitment_candidates_id="+recruitment_candidates_id;
	url=url+"&userid="+userid;
	url=url+"&notes="+notes;
	url=url+"&ran="+Math.random();
	//alert(url);
	
	xmlHttp.onreadystatechange=function OnSuccessAddNotes(){
		if (xmlHttp.readyState==4)
		{
			document.getElementById("notes_add_form").style.display="none";
			obj = document.getElementById(recruitment_candidates_id+"_notes_list");
			obj.innerHTML = xmlHttp.responseText;
			alert("New Notes Added!");
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
	
}
function showCandidates(){
	job_order_list_id =  document.getElementById("job_order_list_id").value;
	if(job_order_list_id == null){
		alert("job_order_list_id is null.");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showCandidates.php";
	url=url+"?job_order_list_id="+job_order_list_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessShowCandidates;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function OnSuccessShowCandidates(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("applicant_list").innerHTML=xmlHttp.responseText;	
	}
}
function addCandidate(){
	leads_id =  document.getElementById("leads_id").value;
	job_order_id =  document.getElementById("job_order_id").value;
	job_order_form_id =  document.getElementById("job_order_form_id").value;
	job_order_list_id =  document.getElementById("job_order_list_id").value;
	
	userid =  document.getElementById("userid").value;
	candidate_status=  document.getElementById("candidate_status").value;
	expected_salary=  document.getElementById("expected_salary").value;
	notes=  URLEncode(document.getElementById("notes").value);
	
	
	if(userid == 0){
		alert("Please choose Applicant.");
		return false;
	}
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"addCandidate.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&job_order_id="+job_order_id;
	url=url+"&job_order_form_id="+job_order_form_id;
	url=url+"&job_order_list_id="+job_order_list_id;
	url=url+"&userid="+userid;
	url=url+"&candidate_status="+candidate_status;
	url=url+"&expected_salary="+expected_salary;
	url=url+"&notes="+notes;
	
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessAddCandidate;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function OnSuccessAddCandidate(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("candidates_add_form").style.display="none";
		showCandidates();
		alert("New Candidate has been Added!");
	}
}




function showCandidatesAddForm(recruitment_candidates_id){
	
	document.getElementById("candidates_add_form").style.display="block";
	document.getElementById("candidates_add_form").innerHTML = "Loading...";
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showCandidatesAddForm.php";
	url=url+"?ran="+Math.random();
	url=url+"&recruitment_candidates_id="+recruitment_candidates_id;
	xmlHttp.onreadystatechange=OnSuccessShowCandidatesAddForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function OnSuccessShowCandidatesAddForm(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("candidates_add_form").innerHTML=xmlHttp.responseText;	
	}
}
/*
function showLeadsJobOrderList(leads_id){
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showLeadsJobOrderList.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessShowLeadsJobOrderList;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function OnSuccessShowLeadsJobOrderList(){
	
}
*/

function searchLeadsWithJobOrderRequest(){
	keyword = document.getElementById("keyword").value;
	if(keyword!=null ){
		document.getElementById("leads_list").innerHTML = "Loading ....";
		xmlHttp=GetXmlHttpObject();
		var url=PATH+"searchLeadsWithJobOrderRequest.php";
		url=url+"?keyword="+keyword;
		url=url+"&ran="+Math.random();
		xmlHttp.onreadystatechange=OnSuccessShowLeadsWithJobOrderRequest;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}
}
function showLeadJobOrder(leads_id){
	document.getElementById("right_panel").innerHTML = "Loading....";
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showLeadJobOrder.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessShowLeadJobOrder;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function OnSuccessShowLeadJobOrder(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("right_panel").innerHTML=xmlHttp.responseText;	
	}
}



function showLeadsWithJobOrderRequest(leads_id){
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showLeadsWithJobOrderRequest.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessShowLeadsWithJobOrderRequest;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function OnSuccessShowLeadsWithJobOrderRequest(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("leads_list").innerHTML=xmlHttp.responseText;	
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
