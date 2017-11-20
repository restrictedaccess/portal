var django_homepage_url = "/rs";
var done = 0;

var skill_selected = new Array();
var rating_skill_selected = new Array();
var task_selected = new Array();
var rating_task_selected = new Array();

$(document).ready(function(){
	
	//INITIALIZE ALL
	initAll();
	
	//DECLARATION OF VARIABLES
	var shift_time_box = jQuery(this).find("select[name=shift_time]");
	var shift_time_box_end = jQuery(this).find("select[name=shift_time_end]");
	var shift_date_start = jQuery(this).find("input[name=date_start]");
	var manager_first_name = jQuery(this).find("input[name=manager_first_name]"); 
	var manager_last_name = jQuery(this).find("input[name=manager_last_name]");
	var manager_email = jQuery(this).find("input[name=manager_email]");
	var manager_contact_number = jQuery(this).find("input[name=manager_contact_number]");
	var id = null;
	
	jQuery("input.date_start").each(function(){
		var value = jQuery(this).val();
		jQuery(this).datepicker();
		jQuery(this).datepicker("option", "dateFormat", "yy-mm-dd");
		jQuery(this).datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", value));
	});
	jQuery("input[name=staff_report_directly]").on("click", function(){
		var value = jQuery(this).val();
		if (value=="No"){
			jQuery(this).parent().parent().parent().parent().parent().parent().find("input[name=manager_first_name]").removeAttr("disabled");
			jQuery(this).parent().parent().parent().parent().parent().parent().parent().find("input[name=manager_last_name]").removeAttr("disabled");
			jQuery(this).parent().parent().parent().parent().parent().parent().parent().find("input[name=manager_email]").removeAttr("disabled");
			jQuery(this).parent().parent().parent().parent().parent().parent().parent().find("input[name=manager_contact_number]").removeAttr("disabled");
		}else{
			jQuery(this).parent().parent().parent().parent().parent().parent().find("input[name=manager_first_name]").attr("disabled", "disabled");
			jQuery(this).parent().parent().parent().parent().parent().parent().find("input[name=manager_last_name]").attr("disabled", "disabled");
			jQuery(this).parent().parent().parent().parent().parent().parent().find("input[name=manager_email]").attr("disabled", "disabled");
			jQuery(this).parent().parent().parent().parent().parent().parent().find("input[name=manager_contact_number]").attr("disabled", "disabled");
			manager_first_name.css("border-color", "#ADAAAA");
			manager_last_name.css("border-color", "#ADAAAA");
			manager_email.css("border-color", "#ADAAAA");
			manager_contact_number.css("border-color", "#ADAAAA");
			$("span").remove(".help-line");
		}
	});
	jQuery("select[name=time_zone]").val("Australia/Sydney").trigger("chosen:updated");
	jQuery(".attach-docs").on("click", function(e){
		var gs_id = jQuery(this).attr("data-gs_job_titles_details_id");
		jQuery("#file_gs_job_titles_details_id").val(gs_id);
		uploaderFile.clearStoredFiles();
		jQuery("#fileUploader").modal({backdrop: 'static',keyboard: true});
		e.preventDefault();
		e.preventDefault();
		e.stopPropagation();
	});
	var uploaderFile = new qq.FileUploader({
		element: jQuery("#file_path_uploader")[0],
		button:jQuery("#file_select_button")[0],
		autoUpload:false,
		multiple:false,
		action:"/portal/custom_get_started/attach_docs.php",
		onComplete:function(id, filename, response){
			if (response.success){
				alert("You have successfully uploaded the document.")
				jQuery("#fileUploader").modal("hide");
				jQuery("#file-name-"+response.id).html("<a target='_blank' href='/portal/custom_get_started/get_files.php?gs_job_titles_details_id="+response.id+"'>"+response.filename+"</a>");
				//console.log(jQuery("#file-name-"+response.id));
			}
			
		},
		params:{
			gs_job_titles_details_id:jQuery("#file_gs_job_titles_details_id").val()
		}
	});
	jQuery("#upload_file_dialog").on("click", function(e){
		uploaderFile.setParams({
			gs_job_titles_details_id:jQuery("#file_gs_job_titles_details_id").val()
		});
		uploaderFile.uploadStoredFiles();
		e.preventDefault();
		e.stopPropagation();
	});
	jQuery(".launch-skill").on("click", function(e){
		var sub_category_id = jQuery(this).attr("data-sub_category_id");
		$('#required_skill_sub_category_id').val(sub_category_id);
		jQuery("#select-skill").attr("data-gs_job_titles_details_id", jQuery(this).attr("data-gs_job_titles_details_id"));
		loadTaskList(sub_category_id, this);
		jQuery("#addSkillListModal").modal({backdrop: 'static',keyboard: true})
		e.preventDefault();
		e.stopPropagation();
	});
	jQuery(".launch-task").on("click", function(e){
		var sub_category_id = jQuery(this).attr("data-sub_category_id");
		$('#required_task_sub_category_id').val(sub_category_id);
		jQuery("#select-tasks").attr("data-gs_job_titles_details_id", jQuery(this).attr("data-gs_job_titles_details_id"));
		loadTaskList(sub_category_id, this);
		jQuery("#addTaskListModal").modal({backdrop: 'static',keyboard: true})
		e.preventDefault();
		e.stopPropagation();
	});
	jQuery("#select-skill").on("click",function(){
		var me = jQuery(this);
		var id = me.attr("data-gs_job_titles_details_id");
		var output = "";
		var outputDiv = "";
		var i = 0;
		var all_skill_have_rating = true;
		jQuery("input[name='skill-selected[]']:checked").each(function(){
			var ratings = jQuery(this).parent().parent().find(".rating-skill-selected").val();
			var original_ratings = ratings;
			if(ratings == ''){
				all_skill_have_rating = false;
			}
			if (ratings == 1){
				ratings = "Beginner (1-3 years)";
			}else if (ratings == 2){
				ratings = "Intermediate (3-5 years)"
			}else if (ratings==3){
				ratings = "Advanced (More than 5 years)";
			}else{
				ratings = "N/A"
			}
			output+="<tr>";
				output+="<td>"+jQuery(this).attr("data-label")+"</td>";
				output+="<td>"+ratings+"</td>";
			output+="</tr>";
			
			outputDiv+="<input type='hidden' name='skills[]' class='selected-skill' data-gs_job_titles_details_id='"+id+"' value='"+jQuery(this).val()+"'/>";
			outputDiv+="<input type='hidden' name='skills-proficiency[]' class='selected-skill-proficiency' data-gs_job_titles_details_id='"+id+"' value='"+original_ratings+"'/>";
		});
		if(all_skill_have_rating){
			if (output!=""){
				jQuery("#skill-list-selected-"+id+" tbody").html(output);
				jQuery("#skill-list-selected-"+id).show();
			}else{
				jQuery("#skill-list-selected-"+id+" tbody").html(output);
				jQuery("#skill-list-selected-"+id).hide();
			}
			jQuery("#skill-id-selected-"+id).html(outputDiv);
			jQuery("#addSkillListModal").modal("hide");
		}else{
			alert( 'Please select rate rating of the selected skill!' );
		}
	});
	jQuery("#select-tasks").on("click",function(){ 
		var me = jQuery(this);
		var id = me.attr("data-gs_job_titles_details_id");
		var output = "";
		var outputDiv = "";
		var i = 0;
		var all_task_have_rating = true;
		jQuery("input[name='task-selected[]']:checked").each(function(){
			var ratings = jQuery(this).parent().parent().find(".rating-task-selected").val();
			var original_ratings = ratings;
			if(ratings == ''){
				all_task_have_rating = false;
			}
			output+="<tr>";
				output+="<td>"+jQuery(this).attr("data-label")+"</td>";
				output+="<td>"+ratings+"/10</td>";
			output+="</tr>";
			
			outputDiv+="<input type='hidden' name='tasks[]' class='selected-task' data-gs_job_titles_details_id='"+id+"' value='"+jQuery(this).val()+"'/>";
			outputDiv+="<input type='hidden' name='tasks-proficiency[]' class='selected-task-proficiency' data-gs_job_titles_details_id='"+id+"' value='"+original_ratings+"'/>";
		});
		if(all_task_have_rating){
			if (output!=""){
				jQuery("#task-list-selected-"+id+" tbody").html(output);
				jQuery("#task-list-selected-"+id).show();
			}else{
				jQuery("#task-list-selected-"+id+" tbody").html(output);
				jQuery("#task-list-selected-"+id).hide();
			}
			jQuery("#task-id-selected-"+id).html(outputDiv);
			jQuery("#addTaskListModal").modal("hide");
		}else{
			alert( 'Please select rate rating of the selected task!' );
		}
	});
	jQuery(".add-responsibility").on("click",function(e){
		var item = jQuery("#responsibility-row").html();
		jQuery(item).appendTo(jQuery(this).parent().parent().find(".responsibilities-div")).children( ':last' ).hide().fadeIn( 'normal' ).show();
		e.preventDefault();
		e.stopPropagation();
	});
	jQuery(".add-other_skills").on("click", function(e){
		var item = jQuery("#other-skills-row").html();
		jQuery(item).appendTo(jQuery(this).parent().parent().find(".other-skills-div")).children( ':last' ).hide().fadeIn( 'normal' ).show();
		e.preventDefault();
		e.stopPropagation();
	});
	$(document).on("click", '#continue-step-3', function(e){
		e.preventDefault();
		continue_step_3();
	});
	
	jQuery("select[name=shift_time]").on("change", function(){
		var shift_start = jQuery(this).val();
		shift_start = shift_start.split(":");
		var shift_start_hour = shift_start[0];
		var shift_start_minute = shift_start[1];
		
		shift_start_hour = parseInt(shift_start_hour);
		var status = jQuery(this).parent().parent().parent().parent().find("select[name=work_status]").val();
		var shift_end_hour = 0;
		
		if (status=="Full-Time"){
			shift_end_hour = shift_start_hour+9;
		}else{
			shift_end_hour = shift_start_hour+4;
		}
		
		if (shift_end_hour>23){
			shift_end_hour = shift_end_hour - 24;
		}
		
		if (shift_end_hour < 10){
			shift_end_hour = "0"+shift_end_hour;
		}
		
		if(shift_start == ''){
			var current_shift_time = '';
		}else{
			var current_shift_time = shift_end_hour+":"+shift_start_minute;
		}

		jQuery(this).parent().parent().parent().find("select[name=shift_time_end]").val(current_shift_time).trigger("chosen:updated");

	});

});

$(function(){

	//ADD NEW TASK
	$(document).on("submit","#add-new-task",function(e){
		e.preventDefault();
		if($('#updateNameTask').val() != ''){
			var answer = confirm('Do you want to add this task?');
			if(answer){
				var data = {
					type:jQuery("#updateTypeTask").val(),
					sub_category_id:jQuery("#updateSubCategoryIdTask").val(),
					value:jQuery("#updateNameTask").val(),
					gs_job_titles_details_id:jQuery(".tab-pane.active input[name=gs_job_titles_details_id]").val(),
					leads_id:jQuery("#client_id").val()
				};
				jQuery.post("/portal/custom_get_started/add_skill_task.php", data, function(response){
					jQuery("#updateNameTask").val("");
					response = jQuery.parseJSON(response);
					var output = "";
					var item = null;
					if (response.success){
						jQuery.each(response.required_tasks, function(i, required_task){
							if (required_task.value == data.value){
								item = required_task;
								return false;
							}
						});
						output+='<tr>';
						output+='<td class="text-center" style="vertical-align:middle; width:10%;"><input checked="checked" type="checkbox" class="task-selected" name="task-selected[]" id="optionsCheckboxTask'+item.id+'" value="'+item.id+'" data-label="'+item.value+'"></td>';
						output+='<td style="vertical-align:middle; width:60%;">'+item.value+'</td>';
						output+='<td style="vertical-align:middle; width:30%;"><select name="rating-task-selected[]" class="form-control rating-task-selected" data-id="'+item.id+'">';
						output+="<option value=''>Select Rate of Importance</option>";
						for(var i=1;i<=10;i++){
							var label = "";
							if (i==1){
								label = i+" Low";
							}else if (i==10){
								label = i+" High";
							}else{
								label = i
							}
							output+='<option value="'+i+'">'+label+'</option>';
						}
						output+='</select></td></tr>';
						jQuery(output).appendTo(jQuery("#task-select-form tbody")).hide().fadeIn(100);
						var task = {
							'id':"optionsCheckboxTask"+item.id,
							'value':item.id
						}
						task_selected.push(task);
					}
				});
			}
		}else{
			alert('Please fill up new task!');
			$('#updateNameTask').focus();
		}
	});
	
	//ADD NEW SKILL
	$(document).on("submit","#add-new-skill",function(e){
		e.preventDefault();
		if($('#updateNameSkill').val() != ''){
			var answer = confirm('Do you want to add this skill?');
			if(answer){
				var data = {
					type:jQuery("#updateTypeSkill").val(),
					sub_category_id:jQuery("#updateSubCategoryIdSkill").val(),
					value:jQuery("#updateNameSkill").val(),
					gs_job_titles_details_id:jQuery(".tab-pane.active input[name=gs_job_titles_details_id]").val(),
					leads_id:jQuery("#client_id").val()
				};
				jQuery.post("/portal/custom_get_started/add_skill_task.php", data, function(response){
					jQuery("#updateNameSkill").val("");
					response = jQuery.parseJSON(response);
					var output = "";
					var item = null;
					if (response.success){
						jQuery.each(response.required_skills, function(i, required_skill){
							if (required_skill.value == data.value){
								item = required_skill;
								return false;
							}
						});
						output+='<tr>';
						output+='<td class="text-center" style="vertical-align:middle; width:10%"><input type="checkbox" checked="checked" name="skill-selected[]" class="skill-selected" id="optionsCheckbox'+item.id+'" value="'+item.id+'" data-label="'+item.value+'"></td>';
						output+='<td style="vertical-align:middle; width:60%">'+item.value+'</td>';
						output+='<td style="vertical-align:middle; width:30%"><select name="rating-skill-selected[]" class="form-control rating-skill-selected" data-id="'+item.id+'"><option value="">Select Proficiency</option><option value="1">Beginner (1 - 3 years)</option><option value="2">Intermediate (3 - 5 years)</option><option value="3">Advanced (More than 5 years)</option></select></td>';
						output+='</tr>';
						jQuery(output).appendTo(jQuery("#skill-select-form tbody")).hide().fadeIn(100);
						var skill = {
							'id':"optionsCheckbox"+item.id,
							'value':item.id
						}
						skill_selected.push(skill);
					}
				});
			}
		}else{
			alert('Please fill up new skill!');
			$('#updateNameSkill').focus();
		}
	});
	
	//DELETE CREDS
	$(document).on("click",".delete-creds",function(e){
		jQuery(this).closest('.row').fadeOut("normal",function(){
			jQuery(this).remove();
		});
		e.preventDefault();
		e.stopPropagation();
	});
	
	//SEARCH SKILL ON KEYUP
	$(document).on('keyup','#search_skill',function(e){
		e.preventDefault();
		searchSkill($(this));
	});
	
	//SEARCH TASK ON KEYUP
	$(document).on('keyup','#search_task',function(e){
		e.preventDefault();
		searchTask($(this));
	});
	
	//CHECKBOX SKILL SELECTED
	$(document).on('click','.skill-selected',function(e){
		var id = $(this).attr('id');
		if(!$(this).is(":checked")){
			for (var i =0; i < skill_selected.length; i++){
			   if (skill_selected[i].value === $(this).val()) {
				  skill_selected.splice(i,1);
				  skill_selected = skill_selected.filter(function(n){ return n != undefined }); 
				  //break;
			   }
			}
		}else{
			var skill = {
				'id':id,
				'value':$(this).val()
			}
			skill_selected.push(skill);
		}
	});
	
	//DROPDOWN SKILL SELECTED
	$(document).on('change','.rating-skill-selected',function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var value = $(this).val();
		for (var i =0; i < rating_skill_selected.length; i++){
		   if (rating_skill_selected[i].id === id) {
			  rating_skill_selected.splice(i,1);
			  rating_skill_selected = rating_skill_selected.filter(function(n){ return n != undefined }); 
			  //break;
		   }
		}
		
		var skill = {
			'id':'optionsCheckbox'+id,
			'value':value
		}
		
		var rating_skill = {
			'id':id,
			'value':$(this).val()
		}
		
		skill_selected.push(skill);
		rating_skill_selected.push(rating_skill);
		
		//CHECK THE VALUE OF SELECTED TEXTBOX
		if(value==''){
			$('#optionsCheckbox'+id).prop('checked', false);
		}else{
			$('#optionsCheckbox'+id).prop('checked', true);
		}
		
	});
	
	//CHECKBOX TASK SELECTED
	$(document).on('click','.task-selected',function(e){
		var id = $(this).attr('id');
		if(!$(this).is(":checked")){
			for (var i =0; i < task_selected.length; i++){
			   if (task_selected[i].value === $(this).val()) {
				  task_selected.splice(i,1);
				  task_selected = task_selected.filter(function(n){ return n != undefined }); 
				  //break;
			   }
			}
		}else{
			var task = {
				'id':id,
				'value':$(this).val()
			}
			task_selected.push(task);
		}
	});
	
	//DROPDOWN TASK SELECTED
	$(document).on('change','.rating-task-selected',function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var value = $(this).val();
		for (var i =0; i < rating_task_selected.length; i++){
		   if (rating_task_selected[i].id === id) {
			  rating_task_selected.splice(i,1);
			  rating_task_selected = rating_task_selected.filter(function(n){ return n != undefined }); 
			  //break;
		   }
		}
		
		var task = {
			'id':'optionsCheckboxTask'+id,
			'value':value
		}
			
		var rating_task = {
			'id':id,
			'value':$(this).val()
		}
		
		task_selected.push(task);
		rating_task_selected.push(rating_task);
		
		//CHECK THE VALUE OF SELECTED TEXTBOX
		if(value==''){
			$('#optionsCheckboxTask'+id).prop('checked', false);
		}else{
			$('#optionsCheckboxTask'+id).prop('checked', true);
		}
		
	});
	
	//RESET ARRAY ON MODAL CLOSE
	$(document).on('hidden.bs.modal','#addSkillListModal', function(){
		skill_selected = new Array();
		rating_skill_selected = new Array();
		$('#search_skill').val('');
	});
	
	//RESET ARRAY ON MODAL CLOSE ADD TASK LIST MODAL
	$(document).on('hidden.bs.modal','#addTaskListModal',function(){
		task_selected = new Array();
		rating_task_selected = new Array();
		$('#search_task').val('');
	});
	
	//CHECKBOX TR SELECTED
	$(document).on('click','#skill-select-form tr, #task-select-form tr',function(e){
		if (e.target.type !== 'checkbox' && e.target.tagName !== 'SELECT' && e.target.tagName === 'TD' ) { 
			$(':checkbox', this).click();
		}
	});
	
	//REMOVE NAVIGATION A EVENT
	$(".navigation a").on("click", function(e){
		e.preventDefault();
	});

});

//SEARCH SKILL FUNCTION
function searchSkill(thisObj){
	var search_skill = $('#search_skill').val();
	var subcategory_id = $('#required_skill_sub_category_id').val();
	jQuery.get("/portal/custom_get_started/search_skill_job_position.php?sub_category_id="+subcategory_id+"&search_skill="+search_skill,function(response){
		response = jQuery.parseJSON(response);
		var output = "";
		jQuery.each(response.result, function(i, item){
			output+='<tr>';
            output+='<td class="text-center" style="vertical-align:middle; width:10%"><input type="checkbox" name="skill-selected[]" class="skill-selected" id="optionsCheckbox'+item.id+'" value="'+item.id+'" data-label="'+item.value+'"></td>';
            output+='<td style="vertical-align:middle; width:60%">'+item.value+'</td>';
            output+='<td style="vertical-align:middle; width:30%"><select name="rating-skill-selected[]" class="form-control rating-skill-selected" data-id="'+item.id+'"><option value="">Select Proficiency</option><option value="1">Beginner (1 - 3 years)</option><option value="2">Intermediate (3 - 5 years)</option><option value="3">Advanced (More than 5 years)</option></select></td>';
			output+='</tr>';
		});
		jQuery("#skill-select-form tbody").html(output);
		jQuery("#updateSubCategoryIdSkill").val(subcategory_id);
		jQuery(".selected_job_title").html(response.sub_category.sub_category_name);
		//ALLOCATE STORED SKILL SELECTED ARRAY VALUE
		$.each(skill_selected,function(){
			$('#'+this.id).prop('checked', true);
		});
		//ALLOCATE STORED RATING SKILL SELECTED
		$.each(rating_skill_selected,function(){
			$('select[data-id='+this.id+']').val(this.value);
		});
	});
}

//SEARCH TASK FUNCTION
function searchTask(thisObj){
	var search_task = $('#search_task').val();
	var subcategory_id = $('#required_task_sub_category_id').val();
	jQuery.get("/portal/custom_get_started/search_task_job_position.php?sub_category_id="+subcategory_id+"&search_task="+search_task,function(response){
		response = jQuery.parseJSON(response);
		var output = "";
		jQuery.each(response.result, function(i, item){
			output+='<tr>';
			output+='<td class="text-center" style="vertical-align:middle; width:10%">';
            output+='<input type="checkbox" class="task-selected" name="task-selected[]" id="optionsCheckboxTask'+item.id+'" value="'+item.id+'" data-label="'+item.value+'">';
            output+='<td style="vertical-align:middle; width:60%">'+item.value+'</td>';
            output+='</td>';
            output+='<td style="vertical-align:middle; width:30%">';
            output+='<select name="rating-task-selected[]" class="form-control rating-task-selected" data-id="'+item.id+'">';
			output+="<option value=''>Select Rate of Importance</option>"
			for(var i=1;i<=10;i++){
				var label = "";
				if (i==1){
					label = i+" Low";
				}else if (i==10){
					label = i+" High";
				}else{
					label = i
				}
				output+='<option value="'+i+'">'+label+'</option>';
			}
			output+='</select>';
			output+='</td>';
			output+='</tr>';
		});
		jQuery("#task-select-form tbody").html(output);
		//ALLOCATE STORED TASK SELECTED ARRAY VALUE
		$.each(task_selected,function(){
			$('#'+this.id).prop('checked', true);
		});
		//ALLOCATE STORED RATING TASK SELECTED
		$.each(rating_task_selected,function(){
			$('select[data-id='+this.id+']').val(this.value);
		});
	});
}

//VALIDATE EMAIL
function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 

//LOAD TASK LIST
function loadTaskList(subcategory_id, button){
	if (typeof subcategory_id == "undefined"){
		subcategory_id = 3;
	}
	jQuery.get("/portal/custom_get_started/get_task_job_position.php?sub_category_id="+subcategory_id, function(response){
		response = jQuery.parseJSON(response);
		var output = "";
		jQuery.each(response.result, function(i, item){
			output+='<tr>';
            output+='<td class="text-center" style="vertical-align:middle; width:10%"><input type="checkbox" class="task-selected" name="task-selected[]" id="optionsCheckboxTask'+item.id+'" value="'+item.id+'" data-label="'+item.value+'"></td>';
            output+='<td style="vertical-align:middle; width:60%">'+item.value+'</td>';
            output+='<td style="vertical-align:middle; width:30%"><select name="rating-task-selected[]" class="form-control rating-task-selected" data-id="'+item.id+'">';
			output+="<option value=''>Select Rate of Importance</option>"
			for(var i=1;i<=10;i++){
				var label = "";
				if (i==1){
					label = i+" Low";
				}else if (i==10){
					label = i+" High";
				}else{
					label = i
				}
				output+='<option value="'+i+'">'+label+'</option>';
			}
			output+='</select></td></tr>';
		});
		jQuery("#task-select-form tbody").html(output);
		var j = 0;
		jQuery(button).parent().find(".selected-task").each(function(){
			var ratings_hidden = jQuery(button).parent().find(".selected-task-proficiency");
			jQuery("#optionsCheckboxTask"+jQuery(this).val()).parent().parent().find(".rating-task-selected").val(jQuery(ratings_hidden[j]).val());
			jQuery("#optionsCheckboxTask"+jQuery(this).val()).attr("checked", "checked");
			var task = {
				'id':"optionsCheckbox"+jQuery(this).val(),
				'value':jQuery(this).val()
			}
			var rating_task = {
				'id':jQuery(this).val(),
				'value':jQuery(ratings_hidden[j]).val()
			}
			task_selected.push(task);
			rating_task_selected.push(rating_task);
			//console.log(task_selected);
			//console.log(rating_task_selected);
			j++;
		});
		jQuery("#updateSubCategoryIdTask").val(subcategory_id);
		jQuery(".selected_job_title").html(response.sub_category.sub_category_name);
	});
	jQuery.get("/portal/custom_get_started/get_skill_job_position.php?sub_category_id="+subcategory_id, function(response){
		response = jQuery.parseJSON(response);
		var output = "";
		jQuery.each(response.result, function(i, item){
			output+='<tr>';
            output+='<td class="text-center" style="vertical-align:middle; width:10%"><input type="checkbox" name="skill-selected[]" class="skill-selected" id="optionsCheckbox'+item.id+'" value="'+item.id+'" data-label="'+item.value+'"></td>';
            output+='<td style="vertical-align:middle; width:60%">'+item.value+'</td>';
            output+='<td style="vertical-align:middle; width:30%"><select name="rating-skill-selected[]" class="form-control rating-skill-selected" data-id="'+item.id+'"><option value="">Select Proficiency</option><option value="1">Beginner (1 - 3 years)</option><option value="2">Intermediate (3 - 5 years)</option><option value="3">Advanced (More than 5 years)</option></select></td>';
			output+='</tr>';
		});		
		jQuery("#skill-select-form tbody").html(output);
		var j = 0;
		jQuery(button).parent().find(".selected-skill").each(function(){
			var ratings_hidden = jQuery(button).parent().find(".selected-skill-proficiency");
			jQuery("#optionsCheckbox"+jQuery(this).val()).parent().parent().find(".rating-skill-selected").val(jQuery(ratings_hidden[j]).val());
			jQuery("#optionsCheckbox"+jQuery(this).val()).attr("checked", "checked");
			var skill = {
				'id':"optionsCheckbox"+jQuery(this).val(),
				'value':jQuery(this).val()
			}
			var rating_skill = {
				'id':jQuery(this).val(),
				'value':jQuery(ratings_hidden[j]).val()
			}
			skill_selected.push(skill);
			rating_skill_selected.push(rating_skill);
			//console.log(skill_selected);
			//console.log(rating_skill_selected);
			j++;
		});
		jQuery("#updateSubCategoryIdSkill").val(subcategory_id);
		jQuery(".selected_job_title").html(response.sub_category.sub_category_name);
	});
}

//CONTINUE STEP 3
function continue_step_3() {
		
	var job_order_id = 0;
	
	var error_message = '';
	
	var field_filled = true;
	
	var field_type = 'working_timezone';
	
	var active_element = $( this );
	
	var job_position_number = 1;

	//VALIDATE WORKING TIMEZONE
	$( '.working_timezone' ).each( function() {

		if( $( this ).chosen().val() == '' ) {
			
			job_order_id = $( this ).data( 'gs_job_titles_details_id' );
			
			//alert(job_order_id);
			
			error_message = 'Please fill up working timezone in job position ' + job_position_number + '!';
			
			field_filled = false;
			
			field_type = 'working timezone';

			active_element = $( this );
			
			return false;
			
		}
		
		job_position_number++;

	} );

	//NO ERROR OCCURED
	if( field_filled ) {
		
		job_position_number = 1;
		
		//VALIDATE SHIFT TIME START
		$( '.shift_time_start' ).each( function() {

			if( $( this ).chosen().val() == '' ) {
				
				job_order_id = $( this ).data( 'gs_job_titles_details_id' );
				
				error_message = 'Please fill up shift time start in job position ' + job_position_number + '!';
				
				field_filled = false;
				
				field_type = 'shift time start';

				active_element = $( this );
				
				return false;
				
			}
			
			job_position_number++;
			
		} );
	
	}
	
	//NO ERROR OCCURED
	if( field_filled ) {
		
		job_position_number = 1;
		
		//VALIDATE SHIFT END START
		$( '.shift_time_end' ).each( function() {

			if( $( this ).chosen().val() == '' ) {
				
				job_order_id = $( this ).data( 'gs_job_titles_details_id' );
				
				error_message = 'Please fill up shift time end in job position ' + job_position_number + '!';
				
				field_filled = false;
				
				field_type = 'shift time end';

				active_element = $( this );
				
				return false;
				
			}
			
			job_position_number++;
			
		} );
	
	}

	//NO ERROR OCCURED
	if( field_filled ) {
		
		job_position_number = 1;
		
		//VALIDATE START DATE
		$( '.start_date' ).each( function() {
			
			if( $( this ).val() == '' ) {
				
				job_order_id = $( this ).data( 'gs_job_titles_details_id' );
				
				error_message = 'Please fill up start date in job position ' + job_position_number + '!';
				
				field_filled = false;
				
				field_type = 'start date';

				active_element = $( this );
				
				return false;
				
			}
			
			job_position_number++;
			
		} );
	
	}

	//NO ERROR OCCURED
	if( field_filled ) {
		
		job_position_number = 1;
		
		//VALIDATE STAFF REPORT DIRECTLY
		$( '.staff_report_directly:checked' ).each( function() {
			
			if( $( this ).val() == 'No' ) {
				
				job_order_id = $( this ).data( 'gs_job_titles_details_id' );
				
				/* 
				 * 
				 * VALIDATE MANAGER INFORMATION
				 * 
				 */
				
				/* FIRSTNAME */
				if( $( '#manager_first_name_' + job_order_id ).val() == '' ) {
					
					error_message = 'Please fill up manager firstname in job position ' + job_position_number + '!';
					
					field_filled = false;
					
					field_type = 'manager firstname';

					active_element = $( '#manager_first_name_' + job_order_id );
					
					return false;
				
				/* LASTNAME */
				} else if( $( '#manager_last_name_' + job_order_id ).val() == '' ) {
					
					error_message = 'Please fill up manager lastname in job position ' + job_position_number + '!';
					
					field_filled = false;
					
					field_type = 'manager lastname';

					active_element = $( '#manager_last_name_' + job_order_id );
					
					return false;
				
				/* EMAIL ADDRESS */
				} else if( $( '#manager_email_' + job_order_id ).val() == '' ) {
					
					error_message = 'Please fill up manager email address in job position ' + job_position_number + '!';
					
					field_filled = false;
					
					field_type = 'manager email address';

					active_element = $( '#manager_email_' + job_order_id );
					
					return false;
				
				/* VALIDATE EMAIL ADDRESS */
				} else if( ! validateEmail( $( '#manager_email_' + job_order_id ).val() ) ) {
					
					error_message = 'Invalid email address!';
					
					field_filled = false;
					
					field_type = 'manager email address';

					active_element = $( '#manager_email_' + job_order_id );
					
					return false;
				
				/* MANAGER CONTACT NUMBER */	
				} else if( $( '#manager_contact_number_' + job_order_id ).val() == '' ) {
					
					error_message = 'Please fill up manager contact number in job position ' + job_position_number + '!';
					
					field_filled = false;
					
					field_type = 'manager contact number';

					active_element = $( '#manager_contact_number_' + job_order_id );
					
					return false;
					
				}
				
			}
			
			job_position_number++;
			
		} );

	}
	
	//NO ERROR OCCURED
	if( field_filled ) {
		
		var skill_container = '';
		
		job_position_number = 1;
		
		$( '.skill_container' ).each( function() {
			
			var skill_container_id = $( this ).attr( 'id' ).split( '-' );

			skill_container = $( this ).html().replace(/\s/g,"");
			
			job_order_id = skill_container_id[ 3 ];
			
			if( skill_container == '' ) {
				
				error_message = 'Please select skill in job position ' + job_position_number + '!';
				
				field_filled = false;
				
				field_type = 'skill';

				active_element = $( '#launch_skill_btn_' + job_order_id );
				
				return false;
				
			}
			
			job_position_number++;
			
		} );
		
	}
	
	//NO ERROR OCCURED
	if( field_filled ) {
	
		var task_container = '';
		
		job_position_number = 1;
		
		$( '.task_container' ).each( function() {
			
			var task_container_id = $( this ).attr( 'id' ).split( '-' );
			
			job_order_id = task_container_id[ 3 ];
			
			task_container = $( this ).html().replace(/\s/g,""); 
			
			if( task_container == '' ) {
				
				error_message = 'Please select task in job position ' + job_position_number + '!';
				
				field_filled = false;
				
				field_type = 'task';

				active_element = $( '#launch_task_btn_' + job_order_id );
				
				return false;
				
			}
			
			job_position_number++;
			
		} );
		
	}
	
	//CHECK IF FIELD FILED CORRECTLY
	if( ! field_filled ) {
		
		//alert( error_message );
		
		alert('Please fill up required fields!');
		
		$( '#tabber-job-order a[href="#job-order-'+job_order_id+'"]' ).tab( 'show' );
		
		if( ! active_element.is( ":focus" ) ) {
		
			active_element.focus();
			
			//FILTER CONDITION IF CHOSEN OR NOT
			if( field_type != 'start date' && field_type != 'manager firstname' && field_type != 'manager lastname' && field_type != 'manager email address' && field_type != 'manager contact number' && field_type != 'skill' && field_type != 'task' ) {
				 
				active_element.trigger( 'chosen:open' );
			
			/* FILTER CONDITION BUTTON */
			} else if( field_type == 'skill' || field_type == 'task' ) {
				
				active_element.click();

			}
		
		}
		
	} else {
		
		var total_job_order = $( 'ul#tabber-job-order li' ).length;
		
		var job_order = ( total_job_order > 1 ? 'orders' : 'order' );
		
		//var answer = confirm( 'Do you want to save job ' + job_order + ' details?' );
		
		//if( answer ) {

			_show_loader_targeted( 'body' );
			
			$(".job-order-specification").each(function() {
				
				var data = $( this ).serialize();
				
				$.post("/portal/custom_get_started/process_step3.php", data, function( response ) {
					
					response = $.parseJSON( response );
					
					if ( response.success ) {
						
						done++;		
						
						if ( done == $(".job-order-specification").length ) {
							
							done = 0;
							
							location.href = "/portal/custom_get_started/job_order_preview.php";
							
						}		

					}

				} );
				
			} );
			
			setTimeout( function() {
				
				_hide_loader_targeted( 'body' );
			
			} , 1500 ); 
		
		//}
		
	}
	
	//_hide_loader_targeted( 'body' ); 
		
}

//SHOW LOADER TARGETED
function _show_loader_targeted( targeted ) {
	
	$( targeted ).isLoading( {
		
		text : 'Saving',
		
		position: 'overlay',

		class: 'fa fa-spinner fa-pulse',
		
		tpl : '<span class="isloading-wrapper %wrapper%">%text%<i class="%class%"></i></span>'
	
	} );
	
}

//HIDE LOADER TARGETED
function _hide_loader_targeted( targeted ) {
	
	$( targeted ).isLoading( 'hide' );
	
}

//INITIALIZE ALL FUNCITON
function initAll(){
	initChosen();
}

//INITIALIZE CHOSEN FUNCTION
function initChosen(){
	$('.chosen').chosen({
		width:"100%",
		disable_search: true,
		allow_single_deselect:true
	});
}
