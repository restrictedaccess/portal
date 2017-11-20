jQuery(document).ready(function(){
	jQuery(".popup").click(function(e){
		popup_win7(jQuery(this).attr("href"), 950, 600);
		e.preventDefault();
	})
	
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
			jQuery.post("/portal/jobseeker/update_skill.php", formData, function(data){
				data = jQuery.parseJSON(data);
				if (data.success){
					alert("Skill has been updated")
					window.location.href = "/portal/jobseeker/skills.php?userid="+data.skill.userid
				}else{
					alert(data.error);
				}
			})
		}
	});
	
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
	
});