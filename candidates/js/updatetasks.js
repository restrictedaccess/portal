var hasRequest = false;
jQuery(document).ready(function(){
	jQuery("#job_position").on("change", function(e){
		var sub_category_id = jQuery(this).val();
		if (sub_category_id!=""){
			jQuery.get("/rs/candidates/get_task_job_position/?sub_category_id=" + sub_category_id, function(response) {
				response = jQuery.parseJSON(response);
				if (response.result.length > 0){
					var option = "<option value=''>Select Task</option>";
					jQuery.each(response.result, function(i, item){
						option+="<option value='"+item.id+"'>"+item.value+"</option>";
					});
					jQuery("#task_id").html(option).removeAttr("disabled");
				}else{
					jQuery("#task_id").html(option).attr("disabled", "disabled");
				}
			});
		}
	});
	

	jQuery("#save_add_more_task").on("click", function(e){
		if (!hasRequest){
			hasRequest = true;
			var data = jQuery("#task-form").serialize();
			jQuery.post("/portal/candidates/addtask.php", data, function(response){
				response = jQuery.parseJSON(response);
				hasRequest = false;
				if (response.success){
					alert("Task has been successfully added");
					window.location.reload();
				}else{
					alert(response.error)
				}
			});
			
		}
		
		e.preventDefault();
		e.stopPropagation();
	})
});


jQuery(document).on("change", ".rating-update", function(e){
	var data = {};
	data.id = jQuery(this).attr("data-id");
	data.userid = jQuery(this).attr("data-userid");
	data.task_id = jQuery(this).attr("data-task_id");
	data.ratings = jQuery(this).val();
	if (!hasRequest){
		hasRequest = true;
		jQuery.post("/portal/candidates/updatetask.php", data, function(response){
			response = jQuery.parseJSON(response);
			hasRequest = false;
			if (response.success){
				alert("Task has been successfully updated");
			}else{
				alert(response.error)
			}
		});
	}
});

jQuery(document).on("click", ".delete-task", function(e){
	var id = jQuery(this).attr('data-id');
	var me = jQuery(this);
	if (!hasRequest){
		var ans = confirm("Do you want to delete this task?");
		if (ans){
			jQuery.post("/portal/candidates/delete_task.php", {id:id}, function(response){
				response = jQuery.parseJSON(response);
				if (response.success){
					me.parent().parent().remove();
				}
			})					
		}

	}

})
