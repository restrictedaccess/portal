// JavaScript Document
var PATH = 'category-management/';

function SearchLead(e){
	var search_str = $('search_str').value;
	var search_type = $('search_type').value;
	
	var query = queryString({'search_str' : search_str , 'search_type' : search_type });
	var result = doXHR(PATH + 'SearchLead.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessSearchLead, OnFailSearchLead);
}
function OnSuccessSearchLead(e){
	$('leads_details').innerHTML ='';
	$('leads_details').innerHTML=e.responseText;
	fade('search_form');
}
function OnFailSearchLead(e){
	alert('Failed to search lead');
}
function ShowSearchWindow(e){
	appear('search_form');
}
function EditUpdatedAds(){
	if($('date_created').value == ""){
		alert("Please enter the Created date for this Advertisement");
		return false;
	}
	if($('lead_id').value == ""){
		alert("Please choose a client");
		return false;
	}
	
	if($('category_id').value == ""){
		alert("Please choose a category");
		return false;
	}
	
	if($('outsourcing_model').value == ""){
		alert("Please choose a Outsourcing Model");
		return false;
	}

	
	if($('jobposition').value == ""){
		alert("Please enter a Job Position");
		return false;
	}
	
	if($('jobvacancy_no').value == ""){
		alert("Please enter number of staff needed");
		return false;
	}
	
	if(isNaN($('jobvacancy_no').value)){
		alert("Invalid number of staff");
		return false;
	}
	
	
	
}

function ValidateNewAds(){
	if($('lead_id').value == ""){
		alert("Please choose a client");
		return false;
	}
	
	if($('category_id').value == ""){
		alert("Please choose a category");
		return false;
	}
	
	if($('outsourcing_model').value == ""){
		alert("Please choose a Outsourcing Model");
		return false;
	}

	
	if($('jobposition').value == ""){
		alert("Please enter a Job Position");
		return false;
	}
	
	if($('jobvacancy_no').value == ""){
		alert("Please enter number of staff needed");
		return false;
	}
	
	if(isNaN($('jobvacancy_no').value)){
		alert("Invalid number of staff");
		return false;
	}
}
function checkAdsFields(){
	//alert('hello');
	//return false;
	if($('lead_id').value == ""){
		alert("Please choose a client");
		return false;
	}
	
	if($('category_id').value == ""){
		alert("Please choose a category");
		return false;
	}
	
	if($('jobposition').value == ""){
		alert("Please enter a Job Position");
		return false;
	}
	
	if($('jobvacancy_no').value == ""){
		alert("Please enter number of staff needed");
		return false;
	}
	/*
	if($('outsourcing_model').value == ""){
		alert("Please choose a Outsourcing Model");
		return false;
	}
	if($('companyname').value == ""){
		alert("Please enter a Company Name");
		return false;
	}
	
	
	
	if($('heading').value == ""){
		alert("Please type in your Header message");
		return false;
	}
	*/
	
	
	
	
}


function ShowAddEditForm(jr_cat_id ,mode, category_id){
	//alert(jr_cat_id);	
	//toggle(jr_cat_id+"_add_div");
	var query = queryString({'jr_cat_id' : jr_cat_id , 'mode' : mode , 'category_id' : category_id });
	var result = doXHR(PATH + 'ShowAddEditForm.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessShowAddEditForm, OnFailShowAddEditForm);


	function OnSuccessShowAddEditForm(e){
		toggle(jr_cat_id+"_add_div");
		$(jr_cat_id+"_add_div").innerHTML =  e.responseText;
	}
	function OnFailShowAddEditForm(e){
		alert("Failed to show add / edit form");
	}
}

function AddSubCat(jr_cat_id){
	var category_name = $('sub_cat_name_'+jr_cat_id).value;
	if(category_name == ""){
		alert("Please specify a sub category name");
		return false;
	}
	var query = queryString({'jr_cat_id' : jr_cat_id , 'category_name' : category_name  });
	var result = doXHR(PATH + 'AddSubCat.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessAddSubCat, OnFailAddSubCat);
	
	function OnSuccessAddSubCat(e){
		alert(e.responseText);
		ParseSubCategories(jr_cat_id);
	}
	function OnFailAddSubCat(e){
		alert("Failed to add sub category name");
	}
	

}

function ParseSubCategories(jr_cat_id){
	//toggle(jr_cat_id+"_box");
	var query = queryString({'jr_cat_id' : jr_cat_id });
	var result = doXHR(PATH + 'ParseSubCategories.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessParseSubCategories, OnFailParseSubCategories);
	
	function OnSuccessParseSubCategories(e){
		$(jr_cat_id+"_box").innerHTML = e.responseText;
	}
	function OnFailParseSubCategories(e){
		alert("Failed to parse sub categories");
	}
}


function UpdateSubCat(jr_cat_id , category_id){
	//alert(jr_cat_id +" \n "+category_id);
	var category_name = $('sub_cat_name_'+jr_cat_id).value;
	var job_role_category_id = $('job_role_category_id_'+jr_cat_id).value;
	//$('other_jr_cat_id').value = job_role_category_id;
	
	var query = queryString({'jr_cat_id' : jr_cat_id , 'category_id' : category_id , 'category_name' : category_name , 'job_role_category_id' : job_role_category_id});
	var result = doXHR(PATH + 'UpdateSubCat.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateSubCat, OnFailUpdateSubCat);
	
	function OnSuccessUpdateSubCat(e){
		alert(e.responseText);
		ParseSubCategories(jr_cat_id);
		if(job_role_category_id != jr_cat_id){
			ParseSubCategories(job_role_category_id);
		}
		
	}
	function OnFailUpdateSubCat(e){
		alert("Failed to update sub category name");
	}
	
}

function RemoveSubCat(jr_cat_id , category_id){
	
	if(confirm("Remove from the list?")){
			var query = queryString({'jr_cat_id' : jr_cat_id , 'category_id' : category_id });
			var result = doXHR(PATH + 'RemoveSubCat.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
			result.addCallbacks(OnSuccessRemoveSubCat, OnFailRemoveSubCat);
			
			
	}
	
	function OnSuccessRemoveSubCat(e){
		alert(e.responseText);
		ParseSubCategories(jr_cat_id);
	}
	function OnFailRemoveSubCat(e){
		alert("Failed to remove");
	}
	
	
}


function EditCategoryName(jr_cat_id){
	//alert(jr_cat_id);
	toggle(jr_cat_id+"_edit_div");
	var query = queryString({'jr_cat_id' : jr_cat_id });
	var result = doXHR(PATH + 'EditCategoryName.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessEditCategoryName, OnFailEditCategoryName);
	//$(jr_cat_id+"_name").innerHTML
	
	function OnSuccessEditCategoryName(e){
		
		$(jr_cat_id+"_edit_div").innerHTML = e.responseText;
	}
	function OnFailEditCategoryName(e){
		alert("Failed to show edit form");
	}
	
}

function UpdateCatName(jr_cat_id){
	var cat_name = $('cat_name_'+jr_cat_id).value;	
	if(cat_name == ""){
		alert("Please specify a Category Name");
	}
	
	var query = queryString({'jr_cat_id' : jr_cat_id , 'cat_name' : cat_name  });
	var result = doXHR(PATH + 'UpdateCatName.php', {method:'POST', sendContent: query, headers: {"Content-Type":"application/x-www-form-urlencoded"}});
	result.addCallbacks(OnSuccessUpdateCatName, OnFailUpdateCatName);
	
	function OnSuccessUpdateCatName(e){
		//alert(e.responseText);
		$(jr_cat_id+"_name").innerHTML = e.responseText;
		alert("Successfully Updated!")
		toggle(jr_cat_id+"_edit_div");
	}
	function OnFailUpdateCatName(e){
		alert("Failed to edit category name");
	}
}