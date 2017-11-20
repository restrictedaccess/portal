jQuery(document).ready(function(){
	
	jQuery("#addotherskill").submit(function(){
		if (jQuery.trim(jQuery("#skill_other").val())==""){
			alert("Please select a skill");
			return false;
		}
		if (jQuery("#experience_other").val()==""){
			alert("Please select years of experience");
			return false;
		}
		if (jQuery("#proficiency_other").val()==""){
			alert("Please select proficiency level");
			return false;
		}
	
	
		var formdata = jQuery(this).serialize();
		jQuery.post("/portal/personal/addskills.php", formdata, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				var count = jQuery("#other-table tbody tr").length;
				var output = "<tr bgcolor='#f5f5f5'>";
				
				var experience = data.newskill.experience;
				
				if (experience==0.5){
					experience = "Less than 6 months";
				}else if (experience==0.75){
					experience = "More than 6 months";
				}else if (experience>10){
					experience = "More than 10 yrs.";
				}else{
					experience = experience+"yr/s.";
				}
				
				var proficiency = data.newskill.proficiency;
				if ((proficiency==0)||(proficiency==1)){
					proficiency = "Beginner";
				}else if (proficiency==2){
					proficiency="Intermediate";
				}else{
					proficiency="Advanced";
				}
				
				output+=("<td width='6%' align='center'><font size='1'>"+(count)+".</font></td>");
				output+=("<td width='33%'><font size='1'>"+(data.newskill.skill)+"</font></td>");
				output+=("<td width='26%' align='center'><font size='1'>"+(experience)+"</font></td>");
				output+=("<td width='35%' align='center'><font size='1'>"+(proficiency)+"</font></td>");
				output+=("<td width='26%' align='center'><font size='1'><a href='#' class='delete-skill' data-id='"+(data.newskill.id)+"'  data-type='admin'>delete</a></font></td>");
				output+="</tr>";
				jQuery(output).appendTo(jQuery("#other-table")).hide().fadeIn(100, function(){
					alert("Added a skill");
				});
				jQuery("#skill_other").val("");
				jQuery("#experience_other")[0].selectedIndex = 0;
				jQuery("#proficiency_other")[0].selectedIndex = 0;
			}else{
				alert(data.error);
			}
		})
		return false;
	})
	
	
	jQuery("#addadminskill").submit(function(){
		if (jQuery("#skill_admin").val()==""){
			alert("Please select a skill");
			return false;
		}
		if (jQuery("#experience_admin").val()==""){
			alert("Please select years of experience");
			return false;
		}
		if (jQuery("#proficiency_admin").val()==""){
			alert("Please select proficiency level");
			return false;
		}
	
	
		var formdata = jQuery(this).serialize();
		jQuery.post("/portal/personal/addskills.php", formdata, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				var count = jQuery("#admin-table tbody tr").length;
				var output = "<tr bgcolor='#f5f5f5'>";
				
				var experience = data.newskill.experience;
				
				if (experience==0.5){
					experience = "Less than 6 months";
				}else if (experience==0.75){
					experience = "More than 6 months";
				}else if (experience>10){
					experience = "More than 10 yrs.";
				}else{
					experience = experience+"yr/s.";
				}
				
				var proficiency = data.newskill.proficiency;
				if ((proficiency==0)||(proficiency==1)){
					proficiency = "Beginner";
				}else if (proficiency==2){
					proficiency="Intermediate";
				}else{
					proficiency="Advanced";
				}
				
				output+=("<td width='6%' align='center'><font size='1'>"+(count)+".</font></td>");
				output+=("<td width='33%'><font size='1'>"+(data.newskill.skill)+"</font></td>");
				output+=("<td width='26%' align='center'><font size='1'>"+(experience)+"</font></td>");
				output+=("<td width='35%' align='center'><font size='1'>"+(proficiency)+"</font></td>");
				output+=("<td width='26%' align='center'><font size='1'><a href='#' class='delete-skill' data-id='"+(data.newskill.id)+"'  data-type='admin'>delete</a></font></td>");
				output+="</tr>";
				jQuery(output).appendTo(jQuery("#admin-table")).hide().fadeIn(100, function(){
					alert("Added new admin skill");
				});
				jQuery("#skill_admin")[0].selectedIndex = 0;
				jQuery("#experience_admin")[0].selectedIndex = 0;
				jQuery("#proficiency_admin")[0].selectedIndex = 0;
			}else{
				alert(data.error);
			}
		})
		return false;
	});
	
	
	jQuery("#addtechnicalskill").submit(function(){
		if (jQuery("#skill_technical").val()==""){
			alert("Please select a skill");
			return false;
		}
		if (jQuery("#experience_technical").val()==""){
			alert("Please select years of experience");
			return false;
		}
		if (jQuery("#proficiency_technical").val()==""){
			alert("Please select proficiency level");
			return false;
		}
	
		var formdata = jQuery(this).serialize();
		jQuery.post("/portal/personal/addskills.php", formdata, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				var count = jQuery("#technical-table tbody tr").length;
				var output = "<tr bgcolor='#f5f5f5'>";
				
				var experience = data.newskill.experience;
				
				if (experience==0.5){
					experience = "Less than 6 months";
				}else if (experience==0.75){
					experience = "More than 6 months";
				}else if (experience>10){
					experience = "More than 10 yrs.";
				}else{
					experience = experience+"yr/s.";
				}
				
				var proficiency = data.newskill.proficiency;
				if ((proficiency==0)||(proficiency==1)){
					proficiency = "Beginner";
				}else if (proficiency==2){
					proficiency="Intermediate";
				}else{
					proficiency="Advanced";
				}
				
				output+=("<td width='6%' align='center'><font size='1'>"+(count)+".</font></td>");
				output+=("<td width='33%'><font size='1'>"+(data.newskill.skill)+"</font></td>");
				output+=("<td width='26%' align='center'><font size='1'>"+(experience)+"</font></td>");
				output+=("<td width='35%' align='center'><font size='1'>"+(proficiency)+"</font></td>");
				output+=("<td width='26%' align='center'><font size='1'><a href='#' class='delete-skill' data-id='"+(data.newskill.id)+"' data-type='technical'>delete</a></font></td>");
				output+="</tr>";
				jQuery(output).appendTo(jQuery("#technical-table")).hide().fadeIn(100, function(){
					alert("Added new technical skill");
				});
				jQuery("#skill_technical")[0].selectedIndex = 0;
				jQuery("#experience_technical")[0].selectedIndex = 0;
				jQuery("#proficiency_technical")[0].selectedIndex = 0;
				
			}else{
				alert(data.error);
			}
		})
		return false;
	});
	
	
	jQuery(".delete-skill").live("click", function(e){
		var id = jQuery(this).attr("data-id");
		var type = jQuery(this).attr("data-type");
		
		
		var answer = confirm("Are you sure you want to delete this skill?");
		if (answer){
		
			jQuery.post("/portal/personal/deleteskills.php", {id:id, type:type}, function(data){
				data = jQuery.parseJSON(data);
				if (data.success){
					
					var skills = data.skills;
					var newOutput = '<tr><td width="6%" align="center">#</td><td width="33%" align="left"><b><font size="1">Skills</font></b></td><td width="26%" align="center"><b><font size="1">Experience</font></b></td><td width="35%" align="center"><b><font size="1">Proficiency</font></b></td><td width="26%" align="center"><b><font size="1">Action</font></b></td></tr>';	
					jQuery.each(skills, function(i, item){
						var experience = parseFloat(item.experience);
						
						if (experience==0.5){
							experience = "Less than 6 months";
						}else if (experience==0.75){
							experience = "More than 6 months";
						}else if (experience>10){
							experience = "More than 10 yrs.";
						}else{
							experience = experience+"yr/s.";
						}
						
						var proficiency = item.proficiency;
						if ((proficiency==0)||(proficiency==1)){
							proficiency = "Beginner";
						}else if (proficiency==2){
							proficiency="Intermediate";
						}else{
							proficiency="Advanced";
						}
						
						var output = "<tr bgcolor='#f5f5f5'>";
						output+=("<td width='6%' align='center'><font size='1'>"+(i+1)+".</font></td>");
						output+=("<td width='33%'><font size='1'>"+(item.skill)+"</font></td>");
						output+=("<td width='26%' align='center'><font size='1'>"+(experience)+"</font></td>");
						output+=("<td width='35%' align='center'><font size='1'>"+(proficiency)+"</font></td>");
						output+=("<td width='26%' align='center'><font size='1'><a href='#' class='delete-skill' data-id='"+(item.id)+"' data-type='"+type+"'>delete</a></font></td>");
						output+="</tr>";
						newOutput+=output;
					});
					jQuery("#"+type+"-table tbody").html(newOutput);
				}else{
					alert(data.error);
				}
			})
		}
		e.preventDefault();
	});
});