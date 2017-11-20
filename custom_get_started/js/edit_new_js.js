jQuery(document).ready(function(){
	
	jQuery(".delete-button").on("click", function(e){
		jQuery(this).parent().parent().remove();
		e.preventDefault();
	})
	
	jQuery("#add_required_skills").on("click", function(e){
		var src = jQuery("#skill-row").html();
		jQuery(src).appendTo(jQuery(this).parent().parent().find(".panel-body"));
		e.preventDefault();
		e.stopPropagation();
	});
	
	jQuery("#add_required_tasks").on("click", function(e){
		var src = jQuery("#task-row").html();
		jQuery(src).appendTo(jQuery(this).parent().parent().find(".panel-body"));
		e.preventDefault();
		e.stopPropagation();
	});
	
	jQuery(".add-duties").on("click", function(e){
		var src = jQuery("#responsibility-row").html();
		jQuery(src).appendTo(jQuery("#responsibilities-div"));
		e.preventDefault();
		e.stopPropagation();
	});
	jQuery(".add-skills-requirements").on("click", function(e){
		var src = jQuery("#requirement-row").html();
		jQuery(src).appendTo(jQuery("#skills-requirements-div tbody"));
		e.preventDefault();
		e.stopPropagation();
	});
	
	
	jQuery(".add-other-preferred-skills").on("click", function(e){
		var src = jQuery("#preferred-skill-row").html();
		jQuery(src).appendTo(jQuery("#preferred-skill-div"));
		e.preventDefault();
		e.stopPropagation();
	});
	
	jQuery("#main-form").on("submit", function(){
		var data = jQuery(this).serialize();
		jQuery.post("/portal/custom_get_started/update_new_js.php", data, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				var gs_job_titles_details_id = jQuery("input[name=gs_job_titles_details_id]").val();
				alert("Updated successfully");
				window.location.href = "/portal/custom_get_started/job_spec.php?gs_job_titles_details_id="+gs_job_titles_details_id
			}
		})
		
		return false;
	});
	
	jQuery(".back-js").on("click", function(e){
		var id = jQuery("input[name=gs_job_titles_details_id]").val();
		window.location.href = "/portal/custom_get_started/job_spec.php?gs_job_titles_details_id="+id;
		e.preventDefault();
		e.stopPropagation();
	})
	
	
	jQuery(".add-skill-task").on("click", function(e){
		jQuery("#updateSubCategoryId").val(jQuery(this).attr("data-sub_category_id"));
		jQuery("#updateType").val(jQuery(this).attr("data-type"));
		jQuery('#add-skill-task-popup').modal({backdrop:"static", keyboard:false});
		if (jQuery(this).attr("data-type")=="skill"){
			jQuery("#add-skill-task-popup .modal-title").html("Add Skill");
			jQuery("#updateName").val("");
			jQuery("#updateName").attr("placeholder", "Enter Skill");
		}else{
			jQuery("#add-skill-task-popup .modal-title").html("Add Task");
			jQuery("#updateName").attr("placeholder", "Enter Task");
			jQuery("#updateName").val("");
		}
		e.preventDefault();
	});
	
	jQuery("#btn-add-skill-task").on("click", function(e){
		var data = {
			type:jQuery("#updateType").val(),
			sub_category_id:jQuery("#updateSubCategoryId").val(),
			value:jQuery("#updateName").val(),
			gs_job_titles_details_id:jQuery("input[name=gs_job_titles_details_id]").val()
		};
		jQuery.post("/portal/custom_get_started/add_skill_task.php", data, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				var selectedTasks = [];
				var selectedSkills = [];
				jQuery("input[name='tasks[]']").each(function(){
					if (jQuery(this).is(":checked")){
						var task = {
							id:jQuery(this).val(),
							rating:jQuery(this).parent().parent().find("select[name='ratings-tasks[]']").val()
						}
						selectedTasks.push(task);
					}
				});
				jQuery("input[name='skills[]']").each(function(){
					if (jQuery(this).is(":checked")){
						var skill = {
							id:jQuery(this).val(),
							rating:jQuery(this).parent().parent().find("select[name='ratings[]']").val()
						}
						selectedSkills.push(skill);
						
					}
				});
				var taskOutput = "";
				var srcTask = jQuery("#task-row").html();
				var template = Handlebars.compile(srcTask);
				var items = [];
				for (var i=1;i<=10;i++){
					items.push(i);
				}
				jQuery.each(response.required_tasks,function(i, required_task){
					required_task.items = items;
					taskOutput += template(required_task);
				})
				
				jQuery("#required-task-div").html(taskOutput);
				
				jQuery.each(selectedTasks, function(i, task){
					jQuery("input[name='tasks[]']").each(function(){
						var taskVal = jQuery(this).val();
						
						if (taskVal==task.id){
							jQuery(this).attr("checked", "checked");
							jQuery(this).parent().parent().find("select[name='ratings-tasks[]']").val(task.rating);
						}
					});
				});
				
				
				var skillOutput = "";
				var srcSkill = jQuery("#skill-row").html();
				template = Handlebars.compile(srcSkill);
				
				items = [{i:1, label:"Beginner (1-3 years)"}, {i:2, label:"Intermediate (3-5 years)"}, {i:3, label:"Advanced (More than 5 years)"}]
				jQuery.each(response.required_skills,function(i, required_skill){
					required_skill.items = items;
					skillOutput += template(required_skill);
				})
				
				jQuery("#required-skill-div").html(skillOutput);
				
				jQuery.each(selectedSkills, function(i, skill){
					jQuery("input[name='skills[]']").each(function(){
						var skillVal = jQuery(this).val();
						
						if (skillVal==skill.id){
							jQuery(this).attr("checked", "checked");
							jQuery(this).parent().parent().find("select[name='ratings[]']").val(skill.rating);
						}
					});
				});
				
				jQuery('#add-skill-task-popup').modal("hide");
				alert("Successfully added "+jQuery("#updateType").val()+".");
				
			}else{
				alert(response.error)
			}
		})
		e.preventDefault();
		e.stopPropagation();
	});
});
jQuery(document).on("click", ".delete-creds",function(e){
	jQuery(this).parent().parent().remove();
	e.preventDefault();
	e.stopPropagation();
})
