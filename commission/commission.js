// JavaScript Document
var xmlHttp
PATH ="commission/";

var ie=document.all
var dom=document.getElementById
var ns4=document.layers
var calunits=document.layers? "" : "px"

var bouncelimit=32 //(must be divisible by 8)
var direction="up"

function highlight(obj) {
   obj.style.backgroundColor='#c0e0f5';
   obj.style.fontWeight="700";
   obj.style.cursor='move';
}
function unhighlight(obj) {
   obj.style.backgroundColor='';
   obj.style.fontWeight="";
   obj.style.cursor='default';
}

function highlight2(obj) {
   obj.style.backgroundColor='#F3F2DE';
   obj.style.fontWeight="700";
   obj.style.cursor='pointer';
}
function unhighlight2(obj) {
   obj.style.backgroundColor='';
   obj.style.fontWeight="";
   obj.style.cursor='default';
}

function highlight3(obj) {
   obj.style.fontWeight="700";
   obj.style.cursor='move';
}
function unhighlight3(obj) {
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
function highlight_tab(tab_id){

	tab_no = 3;
	var i;
	for(i=1; i<=tab_no; i++){
		if(tab_id == i){
			
			obj = document.getElementById(i);
			obj.style.position ="relative";
			obj.style.top ="1px";
			obj.style.backgroundColor='white';
			obj.style.fontWeight="700";
			
		}else{
			obj = document.getElementById(i);
			obj.style.backgroundColor='#c0e0f5';
			obj.style.fontWeight="";
			obj.style.position ="";
			obj.style.top ="";
		}
	}
}

function dropItems(idOfDraggedItem,targetId,x,y)
{
	if(targetId=='dropBox'){	// Item dropped on <div id="dropBox">
		var obj = document.getElementById(idOfDraggedItem);
		if(obj.parentNode.id=='dropContent2')return;		
		document.getElementById('dropContent2').appendChild(obj);	// Appending dragged element as child of target box
		// Add staff userid 
		userid = document.getElementById("staff"+idOfDraggedItem).value
		AddDeleteStaffUserid(userid , "add");
		
	}
	if(targetId=='leftColumn'){	// Item dropped on <div id="leftColumn">
		var obj = document.getElementById(idOfDraggedItem);
		if(obj.parentNode.id=='dropContent')return;	
		document.getElementById('dropContent').appendChild(obj);	// Appending dragged element as child of target box
		// Remove staff userid
		userid = document.getElementById("staff"+idOfDraggedItem).value
		AddDeleteStaffUserid(userid , "delete");
	}
	
}



function DropBoxInit(){

	total_no_of_staff = document.getElementById("total_no_of_staff").value;
	var dragDropObj = new DHTMLgoodies_dragDrop();
	for(i=1; i<=total_no_of_staff;i++){
		div= "box"+i;
		dragDropObj.addSource(div,true,true,true,false,'onDragFunction');		
	}
	dragDropObj.addTarget('dropBox','dropItems');	// Set <div id="dropBox"> as a drop target. Call function dropItems on drop
	dragDropObj.addTarget('leftColumn','dropItems'); // Set <div id="leftColumn"> as a drop target. Call function dropItems on drop
	dragDropObj.init();

}


function onDragFunction(cloneId,origId)
{
	self.status = 'Started dragging element with id ' + cloneId;
	var obj = document.getElementById(cloneId);
	obj.style.border='1px solid #F00';
}


function doCheck(value) {
	if (isNaN(value)) {
		alert('This is not a number! Please enter a valid number before submitting the form.');
		return false;
	}
}

function dropin(){
	
	scroll_top=(ie)? truebody().scrollTop : window.pageYOffset
	if (parseInt(crossobj.top)<300+scroll_top)
	crossobj.top=parseInt(crossobj.top)+40+calunits
	else{
	clearInterval(dropstart)
	
	}
	
}
function dismissbox(){
if (window.bouncestart) clearInterval(bouncestart)
crossobj.visibility="hidden"
}
function truebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}



// AJAX
function updateCommissionStaff(commission_staff_id,status){
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"updateCommissionStaff.php";
	url=url+"?commission_staff_id="+commission_staff_id;
	url=url+"&status="+status;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessUpdateCommissionStaff;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function OnSuccessUpdateCommissionStaff() {
	if (xmlHttp.readyState==4)
	{
		//document.getElementById("result").innerHTML=xmlHttp.responseText;	
		showForm(1);
	}
}
function showComm(commission_id){
	highlight_tab(2);
	document.getElementById("result").innerHTML="Loading...";
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"CommissionList.php";
	url=url+"?ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessShowComm() {
		if (xmlHttp.readyState==4)
		{
			document.getElementById("result").innerHTML=xmlHttp.responseText;	
			getCommissionList2(commission_id);
			
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function getCommissionList2(commission_id){
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"getCommissionList.php";
	url=url+"?ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessGetCommissionList (){
		if (xmlHttp.readyState==4)
		{
			obj = document.getElementById("leads_comm_list");
			obj.innerHTML = xmlHttp.responseText;
			viewCommissions(commission_id);
			
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function staffClaimCommission(commission_id){
	document.getElementById("claim_status").innerHTML = "Processing...";
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"staffClaimCommission.php";
	url=url+"?commission_id="+commission_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessStaffClaimCommission;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function OnSuccessStaffClaimCommission(){
	if (xmlHttp.readyState==4)
	{
		obj = document.getElementById("claim_status");
		if((xmlHttp.responseText)=="pending"){
			obj.innerHTML = xmlHttp.responseText;	
			showStaffForm(1);
		}else{
			alert("There was an error. Please try again later..");
		}
		//dismissbox();
	}
}
function showCommission(commission_id,commission_staff_status){
	//alert(commission_staff_status);
	
	if (!dom&&!ie&&!ns4)
	return
	crossobj=(dom)?document.getElementById("dropin").style : ie? document.all.dropin : document.dropin
	scroll_top=(ie)? truebody().scrollTop : window.pageYOffset
	crossobj.top=scroll_top-250+calunits
	crossobj.visibility=(dom||ie)? "visible" : "show"
	dropstart=setInterval("dropin()",50)
	
	document.getElementById("dropin").innerHTML = "Loading...";
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"showCommission.php";
	url=url+"?commission_id="+commission_id;
	url=url+"&commission_staff_status="+commission_staff_status;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessShowCommission;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);

}


function OnSuccessShowCommission(){
	if (xmlHttp.readyState==4)
	{
		obj = document.getElementById("dropin");
		obj.innerHTML = xmlHttp.responseText;	
	}
}

function showStaffForm(form){
	document.getElementById("staff_result").innerHTML = "Loading...";
	xmlHttp=GetXmlHttpObject();
	if (form == 1){
		var url=PATH+"AvailableCommission.php";
	}
	url=url+"?ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessShowStaffForm() {
		if (xmlHttp.readyState==4)
		{
			document.getElementById("staff_result").innerHTML=xmlHttp.responseText;	
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}

function getCommissionList(){
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"getCommissionList.php";
	url=url+"?ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessGetCommissionList (){
		if (xmlHttp.readyState==4)
		{
			obj = document.getElementById("leads_comm_list");
			obj.innerHTML = xmlHttp.responseText;	
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function updateCommission(commission_id){
	
	commission_title = document.getElementById("commission_title").value;
	commission_amount = document.getElementById("commission_amount").value;
	commission_desc = document.getElementById("commission_desc").value;

	if(commission_title==""){
		alert("Please enter a title for your Commissions");
		return false;
	}
	if(commission_amount==""){
		alert("Please enter an amount!");
		return false;
	}
	if (isNaN(commission_amount)) {
		alert('This is not a number! Please enter a valid number before submitting the form.');
		return false;
	}
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"updateCommission.php";
	url=url+"?commission_id="+commission_id;
	url=url+"&commission_title="+commission_title;
	url=url+"&commission_amount="+commission_amount;
	url=url+"&commission_desc="+commission_desc;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessUpdateCommission;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
	obj = document.getElementById("commission_view_description");
	obj.innerHTML = "Loading...";
	
}

function OnSuccessUpdateCommission(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("commission_view_description").innerHTML=xmlHttp.responseText;
		getCommissionList()
	}
}


function viewCommissions(commission_id){
	obj = document.getElementById("view_commission");
	obj.innerHTML = "Loading...";
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"viewCommissions.php";
	url=url+"?commission_id="+commission_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessViewCommissions;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function OnSuccessViewCommissions(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("view_commission").innerHTML=xmlHttp.responseText;	
		DropBoxInit();
	}
}
function AddDeleteStaffUserid(userid , method){
	//alert(userid +"\n " +method);
	commission_id = document.getElementById("commission_id").value;
	var obj = document.getElementById("add_delete_result");
	obj.style.display="block";
	obj.innerHTML="Processing...";
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"AddDeleteStaffUserid.php";
	url=url+"?commission_id="+commission_id;
	url=url+"&userid="+userid;
	url=url+"&method="+method;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessAddDeleteStaffUserid;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	

}
function OnSuccessAddDeleteStaffUserid(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("add_delete_result").innerHTML=xmlHttp.responseText;	
	}
}


function CreateCommission(){
	
	commission_title = document.getElementById("commission_title").value;
	commission_amount = document.getElementById("commission_amount").value;
	commission_desc = document.getElementById("commission_desc").value;

	if(commission_title==""){
		alert("Please enter a title for your Commissions");
		return false;
	}
	if(commission_amount==""){
		alert("Please enter an amount!");
		return false;
	}
	if (isNaN(commission_amount)) {
		alert('This is not a number! Please enter a valid number before submitting the form.');
		return false;
	}
	
	xmlHttp=GetXmlHttpObject();
	var url=PATH+"CreateCommission.php";
	url=url+"?commission_title="+commission_title;
	url=url+"&commission_amount="+commission_amount;
	url=url+"&commission_desc="+commission_desc;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=OnSuccessCreateCommission;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	document.getElementById("result").innerHTML = "Loading...";
}
function OnSuccessCreateCommission(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("result").innerHTML=xmlHttp.responseText;	
		DropBoxInit();
	}
}



function showForm(form){
	document.getElementById("result").innerHTML = "Loading...";
	leads_id =  document.getElementById("leads_id").value;
	highlight_tab(form);
	xmlHttp=GetXmlHttpObject();
	if (form == 1){
		var url=PATH+"CommissionClaims.php";
	}
	if (form == 2){
		var url=PATH+"CommissionList.php";
	}
	if (form == 3){
		var url=PATH+"CreateCommissionForm.php";
	}
	url=url+"?leads_id="+leads_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=function OnSuccessShowForm() {
		if (xmlHttp.readyState==4)
		{
			document.getElementById("result").innerHTML=xmlHttp.responseText;	
			if (form == 2){
				getCommissionList();
			}
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	//alert(url);
	
}
/*
function OnSuccessShowForm(){
	if (xmlHttp.readyState==4)
	{
		document.getElementById("result").innerHTML=xmlHttp.responseText;	
	}
}
*/




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
