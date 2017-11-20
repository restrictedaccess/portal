// JavaScript Document
// Page usage : adminadvertise_positions.php
// Creating a Category
// Normaneil Macutay
// Feb.9,2009
var xmlHttp
PATH ="category/";


function show_hide(sid) 
{
   obj = document.getElementById(sid);
   obj.style.display = (obj.style.display == "block") ? "none" : "block";
}

function highlight(obj) {
   obj.style.backgroundColor='yellow';
   obj.style.cursor='pointer';
   
}
function unhighlight(obj) {
   obj.style.backgroundColor='';
   obj.style.cursor='default';
   
}

function show_controls(id){
   obj = document.getElementById(id);
   obj.style.display = "block";
   
}
function hide_controls(id){
   obj = document.getElementById(id);
   obj.style.display = "none";
   
}

//////////////////// script use by page resume3.php
function checkCheckBoxes(obj , div){
	len = document.getElementsByName(obj).length;
	div = document.getElementById(div);
	if(document.getElementsByName(obj)[0].checked==true){
		div.style.display = "block";
	}else{
		div.style.display = "none";
	}
	
}


function setWorkHour(){
	var start =document.getElementById("start").value;
	var out =document.getElementById("out").value;
	if(start !="0" && out !="0" ){
		lunch_hour = 1;	
		document.getElementById("hour").value = ((out - start) - lunch_hour);
	}else{
		document.getElementById("hour").value = 0;
	}

}

function setWorkHourPartTime(){
	var start =document.getElementById("start_freelancer").value;
	var out =document.getElementById("out_freelancer").value;
	lunch_hour = 0;	
	if(start !="0" && out !="0" ){
		document.getElementById("hour_freelancer").value = ((out - start) - lunch_hour);
	}else{
		document.getElementById("hour_freelancer").value = 0;
	}
	

}

function addFreelancerTimeSchedule(){
	userid = document.getElementById("userid").value;
	days = document.getElementById("days_freelancer").value;
	start =document.getElementById("start_freelancer").value;
	out =document.getElementById("out_freelancer").value;
	hour = document.getElementById("hour_freelancer").value;
	if(start =="0" || out =="0" ){
		alert("Please specify a working time.");
		return false;
	}
	
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"addFreelancerTimeSchedule.php";
	url=url+"?userid="+userid;
	url=url+"&days="+days;
	url=url+"&start="+start;
	url=url+"&out="+out;
	url=url+"&hour="+hour;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessAddFreelancerTimeSchedule;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessAddFreelancerTimeSchedule(){
	if (xmlHttp.readyState==4)
	{ 	
		document.getElementById("freelancer_schedule_list").innerHTML=xmlHttp.responseText;
	}	
}





function deleteFreelancerTimeSchedule(id){
	userid = document.getElementById("userid").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"deleteFreelancerTimeSchedule.php";
	url=url+"?id="+id;
	url=url+"&userid="+userid;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessDeleteFreelancerTimeSchedulee;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessDeleteFreelancerTimeSchedulee(){
	if (xmlHttp.readyState==4)
	{ 	
		document.getElementById("freelancer_schedule_list").innerHTML=xmlHttp.responseText;
	}	
	
}

function saveEvaluation(){
	//Full time
	var fulltime_sched="";
	var parttime_sched="";
	
	if(document.getElementsByName("full_time_status")[0].checked==true){
		work_fulltime = "yes";
	}else{
		work_fulltime = "no";
	}
	
	len = document.form.full_time_shift.length;
	for(i=0; i<len;i++){
		if(document.form.full_time_shift[i].checked == true)
		{
			fulltime_sched = document.form.full_time_shift[i].value;
			break;
		}
	}
	
	//Part time
	if(document.getElementsByName("part_time_status")[0].checked==true){
		work_parttime = "yes";
	}else{
		work_parttime = "no";
	}
	len2 = document.form.part_time_shift.length;
	for(i=0; i<len2;i++){
		if(document.form.part_time_shift[i].checked == true)
		{
			parttime_sched = document.form.part_time_shift[i].value;
			break;
		}
	}
	//Freelancer
	if(document.getElementsByName("freelancer_status")[0].checked==true){
		work_freelancer = "yes";
	}else{
		work_freelancer = "no";
	}


	userid = document.getElementById("userid").value;
	//notes = document.getElementById("notes").value;
	expected_minimum_salary = document.getElementById("expected_minimum_salary").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"addEvaluation.php";
	url=url+"?userid="+userid;
	url=url+"&expected_minimum_salary="+expected_minimum_salary;
	url=url+"&work_fulltime="+work_fulltime;
	url=url+"&fulltime_sched="+fulltime_sched;
	url=url+"&work_parttime="+work_parttime;
	url=url+"&parttime_sched="+parttime_sched;
	url=url+"&work_freelancer="+work_freelancer;
	//url=url+"&notes="+notes;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessSaveEvaluation;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	//alert(url);
	
}
function onSuccessSaveEvaluation(){
	if (xmlHttp.readyState==4)
	{ 	
		//showEvaluationForm();
		document.getElementById("ctrl").innerHTML=xmlHttp.responseText;
	}
}
function showEvaluationForm(){
	document.getElementById("ctrl").style.display ="block";
	userid = document.getElementById("userid").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"showEvaluationForm.php";
	url=url+"?userid="+userid;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessShowEvaluationForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function onSuccessShowEvaluationForm(){
	if (xmlHttp.readyState==4)
	{ 	
		document.getElementById("ctrl").innerHTML=xmlHttp.responseText;
	}
}

function updateEvaluation(id){
	//alert("Update Evaluation " +id);
	//Full time
	var fulltime_sched="";
	var parttime_sched="";
	
	if(document.getElementsByName("full_time_status")[0].checked==true){
		work_fulltime = "yes";
	}else{
		work_fulltime = "no";
	}
	
	len = document.form.full_time_shift.length;
	for(i=0; i<len;i++){
		if(document.form.full_time_shift[i].checked == true)
		{
			fulltime_sched = document.form.full_time_shift[i].value;
			break;
		}
	}
	
	//Part time
	if(document.getElementsByName("part_time_status")[0].checked==true){
		work_parttime = "yes";
	}else{
		work_parttime = "no";
	}
	len2 = document.form.part_time_shift.length;
	for(i=0; i<len2;i++){
		if(document.form.part_time_shift[i].checked == true)
		{
			parttime_sched = document.form.part_time_shift[i].value;
			break;
		}
	}
	//Freelancer
	if(document.getElementsByName("freelancer_status")[0].checked==true){
		work_freelancer = "yes";
	}else{
		work_freelancer = "no";
	}


	userid = document.getElementById("userid").value;
	expected_minimum_salary = document.getElementById("expected_minimum_salary").value;

	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"updateEvaluation.php";
	url=url+"?id="+id;
	url=url+"&userid="+userid;
	url=url+"&expected_minimum_salary="+expected_minimum_salary;
	url=url+"&work_fulltime="+work_fulltime;
	url=url+"&fulltime_sched="+fulltime_sched;
	url=url+"&work_parttime="+work_parttime;
	url=url+"&parttime_sched="+parttime_sched;
	url=url+"&work_freelancer="+work_freelancer;
	//url=url+"&notes="+notes;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessSaveEvaluation;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function addComment(){
	//alert("Add Comment");
	userid = document.getElementById("userid").value;
	notes = document.getElementById("notes").value;
	
	
	
	if(notes=="" || notes ==" " || notes == null){
		alert("Please specify your Note or Comment!");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"addEvaluationComment.php";
	url=url+"?userid="+userid;
	url=url+"&notes="+notes;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessAddComment;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	//alert(payment_details);
	
}
function onSuccessAddComment(){
	if (xmlHttp.readyState==4)
	{ 	
		document.getElementById("evaluation_comments_list").innerHTML=xmlHttp.responseText;
		document.getElementById("notes").value ="";
	}
}

function deleteComment(id){
	userid = document.getElementById("userid").value;
	if(id == "" || id == " "){
		alert("Comment ID is Missing !");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"deleteEvaluationComment.php";
	url=url+"?id="+id;
	url=url+"&userid="+userid;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessAddComment;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function showCategoriesAddForm(){
	userid = document.getElementById("userid").value;
	if(userid==""){
		alert("Applicant ID is Missing.!");
		return false;
	}
	document.getElementById("ctrl").style.display ="block";
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"showCategoriesAddForm.php";
	url=url+"?userid="+userid;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessShowCategoriesAddForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	//document.getElementById("ctrl").innerHTML = userid;
}
function onSuccessShowCategoriesAddForm(){
	if (xmlHttp.readyState==4)
	{ 	
		document.getElementById("ctrl").innerHTML=xmlHttp.responseText;
	}
}

function getSubCategories(category_id)
{
	if(category_id == ""){
		alert("category_id is missing.");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"getSubCategories.php";
	url=url+"?category_id="+category_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessGetSubCategories;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function onSuccessGetSubCategories(){
	if (xmlHttp.readyState==4)
	{ 	
		document.getElementById("sub_category_listings").innerHTML=xmlHttp.responseText;
		document.getElementById("category_control").style.display ="block";
		
	}
}

function saveConfiguration(){
	userid = document.getElementById("userid").value;
	//var jobCategory;
	// Get the Job Category
	//len = document.form.jobCategory.length;
	job =  document.getElementsByName('jobCategory')
	len = job.length;
	
	for(i=0; i<len;i++){
		if(job[i].checked == true)
		{
			jobCategory = job[i].value;
			break;
		}
	}
	//alert(jobCategory);
	
	// Get all checked Sub Categories
	
	var subcategory = document.getElementsByName('jobSubCategory');
	var subcategories= new Array();
	var x = 0;
	for(i=0; i<subcategory.length; i++)
	{
		if(subcategory[i].checked==true){
			subcategories[x]=subcategory[i].value;
			x++;
		}
	}
	if(subcategories.length == 0){
		alert("Please choose a Sub-Category from the list");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"addApplicantToTopTenCategory.php";
	url=url+"?userid="+userid;
	url=url+"&jobCategory="+jobCategory;
	url=url+"&subcategories="+subcategories;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessAddApplicantToTopTenCategory;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	//alert(url);
	
	
}
function onSuccessAddApplicantToTopTenCategory(){
	if (xmlHttp.readyState==4)
	{ 	
		document.getElementById("applicant_top_ten_status").innerHTML=xmlHttp.responseText;
		//getAllCategory();
	}
}
////////////////////////////////////////
function showAllRegisteredApplicants(){
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"showAllRegisteredApplicants.php";
	url=url+"?ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessShowAllRegisteredApplicants;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessShowAllRegisteredApplicants(){
	if (xmlHttp.readyState==4)
	{ 	
		document.getElementById("category_applicants").innerHTML=xmlHttp.responseText;
	}
}

function showJobCategoryApplicants(sub_category_id){
	if(sub_category_id==""){
		alert("sub_category_id is missing..");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"showJobCategoryApplicants.php";
	url=url+"?sub_category_id="+sub_category_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessShowJobCategoryApplicants;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function onSuccessShowJobCategoryApplicants(){
	if (xmlHttp.readyState==4)
	{ 	
		document.getElementById("category_applicants").innerHTML=xmlHttp.responseText;
	}
}







function getSubAllCategories(category_id){
	//alert(category_id);
	if(category_id == null || category_id =="" || category_id == " ")
	{
		alert("Category ID is Missing..");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"getAllSubCategory_action.php";
	url=url+"?category_id="+category_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessGetAllSubCategory;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function onSuccessGetAllSubCategory(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("category_sub_categories").innerHTML=xmlHttp.responseText;
	}
}

function addSubCategories(category_id){
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"getAddSubCategoryForm.php";
	url=url+"?category_id="+category_id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessGetAddSubCategoryForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessGetAddSubCategoryForm(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("create_category_form").style.display ="block";
		document.getElementById("create_category_form").innerHTML=xmlHttp.responseText;
	}
}

function deleteCategory(table,id){
	if(table=="" || id == ""){
		alert("Either Table Name is NULL or ID is Missing.");
		return false;
	}
	
	category_id = document.getElementById("category_id").value;
	if(confirm("Are you sure want to delete this item?"))
	{
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
		  alert ("Your browser does not support AJAX!");
		  return;
		}
		var url=PATH+"deleteSubCategory.php";
		url=url+"?table="+table;
		url=url+"&id="+id;
		url=url+"&category_id="+category_id;
		url=url+"&ran="+Math.random();
		xmlHttp.onreadystatechange=onSuccessDeleteSubCategory;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}else{
		return false;
	}
}
function onSuccessDeleteSubCategory(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("sub_category_list").innerHTML=xmlHttp.responseText;
		getAllCategory();
	}
}

function deleteCategories(table,id){
	if(table=="" || id == ""){
		alert("Either Table Name is NULL or ID is Missing.");
		return false;
	}
	if(confirm("Are you sure want to delete this item ?\nThis action will delete all contents in this item."))
	{
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
		  alert ("Your browser does not support AJAX!");
		  return;
		}
		var url=PATH+"deleteCategory.php";
		url=url+"?table="+table;
		url=url+"&id="+id;
		url=url+"&ran="+Math.random();
		xmlHttp.onreadystatechange=onSuccessDeleteCategory;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}else{
		return false;
	}
}
function onSuccessDeleteCategory(){
	if (xmlHttp.readyState==4)
	{ 
		getAllCategory();
	}
}
function editCategories(table,id){
	//alert(table+"\n" +id);
	if(table=="" || id == ""){
		alert("Either Table Name is NULL or ID is Missing.");
		return false;
	}
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"editForm.php";
	url=url+"?table="+table;
	url=url+"&id="+id;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessGetEditForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function onSuccessGetEditForm(){
	
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("create_category_form").style.display ="block";
		document.getElementById("create_category_form").innerHTML=xmlHttp.responseText;
		
	}
}

function updateCategory(table,id){
	//alert("Update "+table+" \n" +id);
	if(table=="" || id == ""){
		alert("Either Table Name is NULL or ID is Missing.");
		return false;
	}
	name = document.getElementById("name").value;
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"updateCategory.php";
	url=url+"?table="+table;
	url=url+"&id="+id;
	url=url+"&name="+name;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessUpdateCategory;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessUpdateCategory(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("create_category_form").style.display ="none";
		getAllCategory();
	}
}

function getCreateCategoryForm(){
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"createCategoryForm.php";
	url=url+"?ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessGetCreateCategoryForm;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessGetCreateCategoryForm(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("create_category_form").innerHTML=xmlHttp.responseText;
		
	}
}


function createCategory(){
	category = document.getElementById("category").value;
	
	if(category=="" || category==" "){
		alert("Please specify a Work Category!");
		return false;
	}
	document.getElementById("category_list").innerHTML = "<img src=\"images/ajax-loader.gif\">";
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"createCategory.php";
	url=url+"?category="+category;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessCreateCategory;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function onSuccessCreateCategory(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("create_category_form").innerHTML=xmlHttp.responseText;
		getAllCategory();
	}
}

function addSubCategory(){
	category_id = document.getElementById("category_id").value;
	sub_category = document.getElementById("sub_category").value;
	if(category_id=="" || category_id==null){
		alert("Category ID is Missing..");
		return false;
	}
	
	if(sub_category =="" || sub_category==" " || sub_category==null){
		alert("Please specify a Sub-Category");
		return false;
	}
	document.getElementById("sub_category_list").innerHTML = "<img src=\"images/ajax-loader.gif\">";
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"addSubCategory.php";
	url=url+"?category_id="+category_id;
	url=url+"&sub_category="+sub_category;
	url=url+"&ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessAddSubCategory;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}
function onSuccessAddSubCategory(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("sub_category_list").innerHTML=xmlHttp.responseText;
		getAllCategory();
	}
}

function getAllCategory(){
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
	  alert ("Your browser does not support AJAX!");
	  return;
	}
	var url=PATH+"getAllCategory_action.php";
	url=url+"?ran="+Math.random();
	xmlHttp.onreadystatechange=onSuccessGetAllCategory;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);	
	
}
function onSuccessGetAllCategory(){
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("category_list").innerHTML=xmlHttp.responseText;
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
