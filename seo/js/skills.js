jQuery(document).ready(function(){
	var increment = 2;
	
	var mode = "add";
	
	
	
	jQuery(".pagination .disabled a, .pagination .active a").live("click", function(e){
		e.preventDefault()
	})
	
	jQuery("#add_skill").click(function(){
		if (mode=="edit"){
			increment = 2
		}
		jQuery("#skill_name").val("");
		var template = '<div class="control-group">'
		template += '<label class="control-label" for="skill_name">Other term 1</label>';
		template += '<div class="controls">'
		template += '<input type="text" name="name[]" placeholder="Other term 1">&nbsp;'
		template += '<button class="btn btn-danger remove_skill">Remove</button>'
		template += '</div></div>'
		
		jQuery("#skill_other_term_list").html("");
		jQuery(template).appendTo(jQuery("#skill_other_term_list"));
		jQuery("#skill_dialog_header").html("Add New Skill");
		mode = "add";
		jQuery("#update_skill").modal({backdrop: 'static',keyboard: true});
	})
	
	jQuery(".delete_skill").live("click", function(e){
		var answer = confirm("Do you want to delete the skill?")
		var me = jQuery(this);
		if (answer){
			jQuery.get(jQuery(this).attr("href"), function(data){
				data = jQuery.parseJSON(data);
				if (data.success){
					alert("Skill has been deleted")
					me.parent().parent().fadeOut(100, function(){
						jQuery(this).remove();
					})
				}else{
					alert(data.error);
				}
			})			
		}

		e.preventDefault();
	})
	
	jQuery(".remove_skill").live("click", function(e){
		jQuery(this).parent().parent().remove();
		e.preventDefault();
	})
	
	
	
	jQuery(".edit_skill").live("click", function(e){
		var url = "/portal/seo/getskillsdefined.php?id="+jQuery(this).attr("data-id");
		jQuery.get(url, function(data){
			data = jQuery.parseJSON(data);
			jQuery("#skill_other_term_list").html("");
			mode = "edit";
			jQuery("#skill_id").val(data.id);
			jQuery("#skill_name").val(data.skill_name);
			jQuery("#meta_title_add").val(data.meta_title);
			jQuery("#meta_description_add").val(data.meta_description);
			jQuery("#meta_keywords_add").val(data.meta_keywords);
			jQuery("#url").val(data.url);
			
			increment = 1
			jQuery.each(data.other_terms, function(i, item){
				var template = '<div class="control-group">'
				template += '<label class="control-label" for="skill_name">Other term '+increment+'</label>';
				template += '<div class="controls">'
				template += '<input type="text" name="name[]" placeholder="Other term '+increment+'" value="'+item.name+'">&nbsp;'
				template += '<button class="btn btn-danger remove_skill">Remove</button>'
				template += '</div></div>'
				jQuery(template).appendTo(jQuery("#skill_other_term_list"));
				increment++;
			})
			jQuery("#skill_dialog_header").html("Update Skill");
			jQuery("#update_skill").modal({backdrop: 'static',keyboard: true});
			
		});
		e.preventDefault();
	})
	
	jQuery("#save_new_skills").click(function(e){
		var data = jQuery("#update_skill_form").serialize();
		if (mode=="add"){
			if (jQuery("#skill_name").val()!=""){
				jQuery.post("/portal/seo/add_skill.php", data, function(response){
					response = jQuery.parseJSON(response);
					if (response.success){
						alert("Skill has been added");
						jQuery("#update_skill").modal("hide")
						window.location.reload();
					}else{
						alert(response.error);
					}
				})
			}else{
				alert("Skill name is required.");
			}	
		}else{
			if (jQuery("#skill_name").val()!=""){
				jQuery.post("/portal/seo/edit_skill.php", data, function(response){
					response = jQuery.parseJSON(response);
					if (response.success){
						alert("Skill has been updated");
						jQuery("#update_skill").modal("hide")
						window.location.reload();
					}else{
						alert(response.error);
					}
				})
			}else{
				alert("Skill name is required.");
			}	
		}
		
		
		e.preventDefault();
	})
	
	jQuery("#close_skill_modal").click(function(e){
		jQuery("#update_skill").modal("hide")
		e.preventDefault();
	})
	
	jQuery(".add_other_skill").click(function(e){
		var template = '<div class="control-group">'
		template += '<label class="control-label" for="skill_name">Other term '+increment+'</label>';
		template += '<div class="controls">'
		template += '<input type="text" name="name[]" placeholder="Other term '+increment+'">&nbsp;'
		template += '<button class="btn btn-danger remove_skill">Remove</button>'
		template += '</div></div>'
		increment++;
		jQuery(template).appendTo(jQuery("#skill_other_term_list"));
		e.preventDefault();
	})
	
	jQuery("#skill_name").keyup(function(e){
		var value = jQuery(this).val();
		jQuery("#url").val(value.replace(/ /gi,'_').toLowerCase());
	}).blur(function(e){
		var value = jQuery(this).val();
		jQuery("#url").val(value.replace(/ /gi,'_').toLowerCase());
	})
	
	
	jQuery("#meta_title_add").bind('input propertychange', function(e) {
		var value = jQuery(this).val();		
		if (value.length>69){
			jQuery(this).val(jQuery(this).data("oldvalue"));
			e.preventDefault();	
		}else{
			jQuery(this).data("oldvalue", value);
			jQuery(".title_count").text(69-value.length)
		}
		
	}).blur(function(){
		var value = jQuery(this).val();		
		jQuery(".title_count").text(69-value.length)
	});
	
	/**
	 * Upload photo build element
	 */
	var uploaderCSV = new qq.FileUploader({
		element: jQuery("#upload_skill")[0],
		button:jQuery("#upload_skill_select")[0],
		autoUpload:false,
		multiple:false,
		action:"/portal/seo/upload_skills.php",
		onComplete:function(id, filename, response){
			if (response.success){
				alert("You have successfully uploaded the skills.")
				window.location.reload();
			}
			
		}
		
	})
	
	jQuery("#upload_skill_button").click(function(e){
		uploaderCSV.uploadStoredFiles();
		e.preventDefault();
	});
	
	jQuery("#meta_description_add").bind('input propertychange', function(e) {
		var value = jQuery(this).val();		
		if (value.length>160){
			jQuery(this).val(jQuery(this).data("oldvalue"));
			e.preventDefault();	
		}else{
			jQuery(this).data("oldvalue", value);
			jQuery(".description_count").text(160-value.length)
		}
	}).blur(function(){
		var value = jQuery(this).val();		
		jQuery(".description_count").text(160-value.length)
	});
})
