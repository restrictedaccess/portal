var xmlHttp
PATH ="";

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

//Show the Action Record Form
function showActionRecordForm()
{
	action = document.getElementById("action").value;
	leads_id = document.getElementById("id").value;
	if(action=="")
	{
		alert("Please choose a Actions(Option)!");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showAddActionForm.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&mode=new";
	url=url+"&action="+action;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessShowActionRecordForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}
function onSuccessShowActionRecordForm()
{
	if (xmlHttp.readyState==4)
	{
		document.getElementById("action_history").innerHTML=xmlHttp.responseText;	
	}
}
function hideAddActionForm(id)
{
	if(id==0){
		document.getElementById("action_history").innerHTML="<p>To add a record, Choose one of the Action Options then click the &quot;Go&quot; button then a form will shows up.</p><p>Select from List of current record to view its details.</p>";
	}else{
	/// if the current form has action details
		showLeadActionRecordDetails(id);
	}
}
function saveActionDetails(){
	action = document.getElementById("action").value;
	leads_id = document.getElementById("id").value;
	subject = document.getElementById("subject").value;
	details = document.getElementById("details").value;
	//
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"add_updateActionHistory.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&mode=new";
	url=url+"&action="+action;
	url=url+"&subject="+subject;
	url=url+"&details="+details;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessSaveActionDetails;
	xmlHttp.open("POST",url,true);
	xmlHttp.send(null);	
	//alert(url);
}
function onSuccessSaveActionDetails(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("action_history").innerHTML=xmlHttp.responseText;	
		hid = document.getElementById("hid").value;
		showLeadActionRecordDetails(hid)
	}
}
function editActionDetails(id){
	leads_id = document.getElementById("id").value;
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showAddActionForm.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&id="+id;
	url=url+"&mode=update";
	url=url+"&sid="+Math.random();
	
	xmlHttp.onreadystatechange=onSuccessShowActionRecordForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
	//alert(url);
}
function updateActionDetails(){
	id = document.getElementById("history_id").value;
	leads_id = document.getElementById("id").value;
	subject = document.getElementById("subject").value;
	details = document.getElementById("details").value;
	//
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"add_updateActionHistory.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&mode=update";
	url=url+"&id="+id;
	url=url+"&subject="+subject;
	url=url+"&details="+details;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessSaveActionDetails;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
	//alert(url);
}
function deleteActionRecords(id){
	if(confirm("Are you sure you want to delete this record?"))
	{
		xmlHttp=GetXmlHttpObject();
		var url=PATH+"deleteActionHistory.php";
		url=url+"?id="+id;
		xmlHttp.onreadystatechange=onSuccessDeleteActionRecords;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	}else{
		return false;
	}
}
function onSuccessDeleteActionRecords()
{
	if (xmlHttp.readyState==4)
	{
		document.getElementById("action_history").innerHTML=xmlHttp.responseText;	
		getLeadActionList();
	}
}
// update lead
function updateLead()
{
	leads_id = document.getElementById("id").value;
	fname =document.getElementById("fname").value;
	lname =document.getElementById("lname").value;
	email = document.getElementById("email").value;
	companyname =document.getElementById("companyname").value;
	companyposition =document.getElementById("companyposition").value;
	companyaddress =document.getElementById("companyaddress").value;
	officenumber =document.getElementById("officenumber").value;
	mobile =document.getElementById("mobile").value;
	industry =document.getElementById("industry").value;
	noofemployee =document.getElementById("noofemployee").value;
	website =document.getElementById("website").value;
	companydesc =document.getElementById("companydesc").value;
	time =document.getElementById("time").value;
	jobresponsibilities =document.getElementById("jobresponsibilities").value;
	rsnumber =document.getElementById("rsnumber").value;
	needrs =document.getElementById("needrs").value;
	rsinhome =document.getElementById("rsinhome").value;
	rsinoffice =document.getElementById("rsinoffice").value;
	questions =document.getElementById("questions").value;
	usedoutsourcingstaff =document.getElementById("usedoutsourcingstaff").value;
	companyturnover =document.getElementById("companyturnover").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"updateinquiryphp.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&fname="+fname;
	url=url+"&lname="+lname;
	url=url+"&email="+email;
	url=url+"&companyname="+companyname;
	url=url+"&companyposition="+companyposition;
	url=url+"&companyaddress="+companyaddress;
	url=url+"&officenumber="+officenumber;
	url=url+"&mobile="+mobile;
	url=url+"&industry="+industry;
	url=url+"&noofemployee="+noofemployee;
	url=url+"&website="+website;
	url=url+"&companydesc="+companydesc;
	url=url+"&time="+time;
	url=url+"&jobresponsibilities="+jobresponsibilities;
	url=url+"&rsnumber="+rsnumber;
	url=url+"&needrs="+needrs;
	url=url+"&rsinhome="+rsinhome;
	url=url+"&rsinoffice="+rsinoffice;
	url=url+"&questions="+questions;
	url=url+"&usedoutsourcingstaff="+usedoutsourcingstaff;
	url=url+"&companyturnover="+companyturnover;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessUpdateLeadInfo;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}
function onSuccessUpdateLeadInfo()
{	
	if (xmlHttp.readyState==4)
	{
		document.getElementById("lead").innerHTML=xmlHttp.responseText;		
		result = document.getElementById("result_message").value;
		lead_name=document.getElementById("leadname").value;
		if(result=="updated"){
			showLeadInfo();
			document.getElementById("lead_name").innerHTML=lead_name;
			
		}
	}
}
// delete Lead
function deleteLead()
{
	leads_id = document.getElementById("id").value;
	if(confirm("Are you sure you want to Delete this Lead ?"))	
	{
		//alert(leads_id);
		xmlHttp=GetXmlHttpObject();
		var url=PATH+"deleteLead.php";
		url=url+"?leads_id="+leads_id;
		url=url+"&sid="+Math.random();
		xmlHttp.onreadystatechange=onSuccessDeleteLead;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);	
	}
	else
	{
		return false;
	}
}
function onSuccessDeleteLead()
{
	if (xmlHttp.readyState==4)
	{
		document.getElementById("lead").innerHTML=xmlHttp.responseText;	
	}
}
// Set the Lead Status
function setLeadStatus(status)
{	
	leads_id = document.getElementById("id").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"updateLeadStatus.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&status="+status;
	url=url+"&sid="+Math.random();
	if(confirm("Move Lead to " + status + " List?"))	
	{	
		xmlHttp.onreadystatechange=onSuccessUpdateLeadInfo;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}
	else
	{
		return false;
	}
}
function showTodoList()
{
	leads_id = document.getElementById("id").value;
	xmlHttp=GetXmlHttpObject();
	//alert(leads_id);
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"showTodoList.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessShowTodoList;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessShowTodoList()
{
	if (xmlHttp.readyState==4)
	{
		document.getElementById("todo_list").innerHTML=xmlHttp.responseText;
		
	}
}
function saveupdate_todo(){
	leads_id = document.getElementById("id").value;
	mode = document.getElementById("mode").value;
	subject = document.getElementById("subject").value;
	start_date = document.getElementById("start_date").value;
	due_date = document.getElementById("due_date").value;
	status = document.getElementById("status").value;
	priority = document.getElementById("priority").value;
	percentage = document.getElementById("percentage").value;
	details = document.getElementById("details").value;
	todo_id = document.getElementById("todo_id").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"add_update_todo_list.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&mode="+mode;
	url=url+"&subject="+subject;
	url=url+"&start_date="+start_date;
	url=url+"&due_date="+due_date;
	url=url+"&status="+status;
	url=url+"&priority="+priority;
	url=url+"&percentage="+percentage;
	url=url+"&details="+details;
	url=url+"&todo_id="+todo_id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessAddUpdateTodoList;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	//alert(url);
}
function onSuccessAddUpdateTodoList(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("todo_list").innerHTML=xmlHttp.responseText;
		result = document.getElementById("result").value;
		if(result=="saved"){
			showTodoList();
			document.getElementById("mode").value ="save";
			document.getElementById("subject").value = "";
			document.getElementById("start_date").value ="";
			document.getElementById("due_date").value="";
			document.getElementById("status").value="";
			document.getElementById("priority").value ="";
			document.getElementById("percentage").value ="";
			document.getElementById("details").value="";
		}
		
	}
}

// Show Action Records or History made by the Business Partner to the Lead
function showActionRecords()
{
	leads_id = document.getElementById("id").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"showActionRecords.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessshowActionRecords;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessshowActionRecords()
{
	if (xmlHttp.readyState==4)
	{
		document.getElementById("action_records").innerHTML=xmlHttp.responseText;
		getLeadActionList();
	}
}
function getLeadActionList()
{
	leads_id = document.getElementById("id").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"getLeadActionList.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessGetLeadActionList;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessGetLeadActionList()
{
	if (xmlHttp.readyState==4)
	{
		document.getElementById("action_record_list").innerHTML=xmlHttp.responseText;
	}
}
// ACTION DETAILS
function showLeadActionRecordDetails(id)
{
	document.getElementById("action_history").innerHTML="<img src='../images/ajax-loader.gif'> Loading...";
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"getActionDetails.php";
	url=url+"?id="+id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessshowLeadActionRecordDetails;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}
function onSuccessshowLeadActionRecordDetails()
{
	if (xmlHttp.readyState==4)
	{
		document.getElementById("action_history").innerHTML=xmlHttp.responseText;
		getLeadActionList();
	}
}
// edit Lead when the user click the 'edit button' show the edit form
function editClientInfo()
{
	leads_id = document.getElementById("id").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"updateinquiry.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessGetLeadInfoForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}
function onSuccessGetLeadInfoForm()
{
	if (xmlHttp.readyState==4)
	{
		document.getElementById("lead").innerHTML=xmlHttp.responseText;	
	}
}

// show the lead info when the user click the 'cancel button'
function hideEditForm()
{
	leads_id = document.getElementById("id").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"lead_description.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessGetLeadInfo;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}
function showLeadInfo()
{
	leads_id = document.getElementById("id").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"lead_description.php";
	url=url+"?leads_id="+leads_id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessGetLeadInfo;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
}

function onSuccessGetLeadInfo()
{
	if (xmlHttp.readyState==4)
	{
		document.getElementById("lead").innerHTML=xmlHttp.responseText;	
		showActionRecords();
	}
}



///
function rateClient(){
	rating = document.getElementById("star").value;
	leads_id = document.getElementById("id").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"setLeadsRating.php";
	url=url+"?rating="+rating;
	url=url+"&leads_id="+leads_id;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=onSuccessLeadSetRating;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessLeadSetRating(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("rate").innerHTML=xmlHttp.responseText;	
		showRateMessage();
	}
}
function showRateMessage()
{
	document.getElementById("rate_mess").innerHTML = "Successfully Rated";
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
