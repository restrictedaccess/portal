jQuery(document).ready(function(){
	jQuery("#skill-form").validate({
		errorElement:"span",
		errorPlacement:function(error, element){
			error.addClass("help-inline").appendTo(element.parent(".controls")).parent().parent().removeClass("error").removeClass("success").addClass("error");
		},
		success:function(label){
			label.parent().parent().removeClass("error").removeClass("success").addClass("success");
		},
		rules:{
			skill:{
				required:true
			},
			experience:{
				required:true
			},
			proficiency:{
				required:true
			}
			
			
		}, 
		submitHandler: function(form) {
			var formData = jQuery("#skill-form").serialize();
			jQuery.post("/portal/candidates/addskill.php", formData, function(data){
				data = jQuery.parseJSON(data);
				if (data.success){
					alert("Skills has been added");
					var template = "<tr>";
					var total = jQuery("#applicant_skill_list tbody tr").length;
					template += "<td>"+(total+1)+"</td>";
					template += "<td>"+data.skill.skill+"</td>";
					if (data.skill.experience == 0.5){
						template += "<td>Less than 6 months</td>";
					}else if (data.skill.experience == 0.75){
						template += "<td>More than 6 months</td>";
					}else if (data.skill.experience == 1){
						template += "<td>1 year</td>";
					}else if (data.skill.experience > 10){
						template += "<td>More than 10 years</td>";
					}else{
						template += "<td>"+data.skill.experience+" years</td>";
					}
					if (data.skill.proficiency==3){
						template += "<td>Advanced</td>";
					}else if (data.skill.proficiency==2){
						template += "<td>Intermediate</td>";
					}else{
						template += "<td>Advanced</td>";
					}
					template+="<td>";
					template+="<a href='/portal/candidates/edit_skill.php?id="+data.skill.id+"' class='edit_skill'>Edit</a> | ";
					template+="<a href='/portal/candidates/delete_skill.php?id="+data.skill.id+"' class='delete_skill'>Delete</a>";
					
					template+="</td>";
					template += "</tr>";
					jQuery("#skill").val("");
					jQuery("#experience").val("");
					jQuery("#proficiency").val("");
					
					jQuery(template).appendTo(jQuery("#applicant_skill_list tbody"));
				}else{
					alert(data.error);
				}
				
			})
			return false;
		}
	});
	
	
	jQuery(".delete_skill").live("click", function(e){
		var me = jQuery(this);
		jQuery.get(me.attr("href"), function(data){
			me.parent().parent().fadeOut(100, function(){
				jQuery(this).remove();
			})
		})
		e.preventDefault();
	})

	jQuery("#skill").typeahead({
		source:function(query, process){
			return jQuery.get("/portal/recruiter/skill_search.php?name="+encodeURIComponent(query), function(data){
				data = jQuery.parseJSON(data);
				var skillsSelected = []
				jQuery.each(data, function(i, item){
					skillsSelected.push(item.skill_name);
				});
				process(skillsSelected);
			})
		}
	});
	
})
