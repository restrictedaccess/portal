function autocomplete(){
	
	var skills = new Bloodhound({
	  datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.skill_name); },
	  queryTokenizer: Bloodhound.tokenizers.whitespace,
	  remote: '/portal/recruiter/skill_search.php?name=%QUERY',
	});
	 
	skills.initialize();
	
	$(".skill-item").typeahead("destroy");
	$(".skill-item").typeahead({
	  minLength: 3,
	  highlight: true,
	},{
		 displayKey:"skill_name",
         source : skills.ttAdapter(),

     });
}

function loadTaskSkillList(sub_category_id){
	if (typeof sub_category_id == "undefined"){
		sub_category_id = 3;
	}
	jQuery.get("/portal/skill_task_manager/get.php?sub_category_id="+sub_category_id, function(response){
		response = jQuery.parseJSON(response);
		if (response.success){
			var sub_category = response.sub_category; 
			var tasks = [];
			var skills = [];
			jQuery.each(response.result, function(i, item){
				if (item.type=="task"){
					tasks.push(item);
				}else if (item.type=="skill"){
					skills.push(item);
				}
			});
			
			jQuery(".category_name").html(sub_category.sub_category_name);
			jQuery(".sub_category_id").val(sub_category.sub_category_id);
			var output = "";
			
			jQuery.each(skills, function(i, item){
				var src = jQuery("#task-item").html();
				var template = Handlebars.compile(src);
				output += template(item);
			});
			
			jQuery("#skill-list-body").html(output);
			
			
			output = "";
			
			jQuery.each(tasks, function(i, item){
				var src = jQuery("#task-item").html();
				var template = Handlebars.compile(src);
				output += template(item);
			});
			
			jQuery("#task-list-body").html(output);
		}
		
		var body = $("html, body");
		
	});
}

var hasRequest = false;
jQuery(document).ready(function(){
	loadTaskSkillList();
	autocomplete();
	jQuery(".subcategory_loader").on("click", function(e){
		loadTaskSkillList(jQuery(this).attr("data-sub_category_id"));
		e.preventDefault();
	});
	jQuery(".add-task").on("submit", function(e){
		var me = jQuery(this);
		var data = me.serialize();
		if (!hasRequest){
			hasRequest = true;
			var subcategory_id = me.find("input.sub_category_id").val();
			jQuery.post("/portal/skill_task_manager/add_update.php", data, function(response){
				hasRequest = false
				response = jQuery.parseJSON(response);
				if (response.success){
					loadTaskSkillList(subcategory_id);
					me.find("input[type=text]").val("");
				}else{
					alert(response.error);
				}
			});			
		}
		return false;
	});
});

jQuery(document).on("click", ".edit-task-launcher", function(e){
	jQuery.get("/portal/skill_task_manager/gettask.php?id="+jQuery(this).attr("data-id"), function(response){
		response = jQuery.parseJSON(response);
		jQuery("#updateType").val(response.result.type);
		jQuery("#updateId").val(response.result.id);
		jQuery("#updateSubCategoryId").val(response.result.sub_category_id);
		jQuery("#updateName").val(response.result.value);
		jQuery("#updateDisplayWebsite").val(response.result.display_website);
		jQuery('#edit-task-popup').modal({backdrop:"static", keyboard:false});	
	})
	e.preventDefault();
});

jQuery(document).on("click", ".delete-task-launcher", function(e){
	var ans = confirm("Are you sure you want to delete this task/skill?")
	if (ans){
		var id = jQuery(this).attr("data-id");
		var sub_category_id = jQuery(this).attr("data-sub_category_id");
		jQuery.get("/portal/skill_task_manager/delete.php?id="+id, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				loadTaskSkillList(sub_category_id);
				alert("Successfully deleted");				
			}else{
				alert(response.error);
			}

		});
	}
	e.preventDefault();
});

jQuery(document).on("submit", ".edit-task", function(e){
	var me = jQuery(this);
	var data = me.serialize();
	if (!hasRequest){
		hasRequest = true;
		var subcategory_id = me.find("input.sub_category_id").val();
		var type = jQuery("#updateType").val();
		jQuery.post("/portal/skill_task_manager/add_update.php", data, function(response){
			hasRequest = false
			response = jQuery.parseJSON(response);
			if (response.success){
				loadTaskSkillList(subcategory_id);
				if (type=="task"){
					alert("Task has been updated successfully.");
				}else{
					alert("Skill has been updated successfully.");
				}
				jQuery('#edit-task-popup').modal("hide");
				me.find("input[type=text]").val("");
			}else{
				alert(response.error);
			}
		});			
	}
	return false;

});
