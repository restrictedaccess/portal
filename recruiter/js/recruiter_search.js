

function confirmDeleteStaffFromList(userid){

	var confirm_delete = confirm("You are about to delete a staff from the list. Continue?")
	
	if (confirm_delete){	
		//delete staff from list
		var result = doXHR('staff_remove.php?userid='+userid, {method:'GET', headers:{"Content-Type":"application/x-www-form-urlencoded"}});
		result.addCallbacks(OnSuccessDeleteStaff, OnFailDeleteStaff);		
	}    
}

function OnSuccessDeleteStaff(e){
	alert("Successfully deleted staff from list"); 
	window.location.reload();  
}

function OnFailDeleteStaff(e){
	alert("Error deleting staff from list"); 
}

function showpopup(id){
	document.getElementById(id).style.display="block";
	document.getElementById('main').style.display="block";
}

function hidepopup(id){
	document.getElementById(id).style.display="none";		
	document.getElementById('main').style.display="none"; 
}  
var recruiterName;
function assignRecruiterPopup(userid){
	jQuery.get("/portal/recruiter/"+'check_priviledge_on_assigning_staff.php?userid='+userid, function(data){
		data = jQuery.parseJSON(data);
		if (data.success){
			showpopup('popup');
			document.getElementById('assign_recruiter_userid').value = userid;
		}else{
			alert(data.error);
		}
	});

	
}

function assignRecruiter(){
	recruiterName = jQuery("#assign_recruiter option:selected").text();
	var answer = confirm("Do you want this candidate to reassign recruiter to "+recruiterName)
	if (answer){
		var recruiter = document.getElementById('assign_recruiter').value;
		var userid = document.getElementById('assign_recruiter_userid').value;
		hidepopup('popup'); 
		jQuery.get("/portal/recruiter/"+'staff_recruiter_update.php?userid='+userid+'&admin_id='+recruiter, function(data){
			var data = jQuery.parseJSON(data);
			if (data.success){
				alert("Successfully assigned recruiter to staff. Page will be refreshed to reflect changes"); 
				window.location.reload();  
			}else{
				alert(data.error);
			}
							
		});
	}
}

function OnSuccessAssignRecruiterToStaff(e){
	alert("Successfully assigned recruiter to staff. Page will be refreshed to reflect changes"); 
	window.location.reload();  
} 

function OnFailAssignRecruiterToStaff(e){
	alert("Error assigning recruiter to staff");  
}

jQuery(document).ready(function(){
	var endorsedStaff = [];
	//START: Renders on content for endorsement
	function renderContent(data){
		data = jQuery.parseJSON(data);
		jQuery("#endorse-listings table").html("");
		jQuery.each(data, function(i, item){
		
			var row = "<tr>";
			row+=("<td class='td_info'><a href='#' class='delete_endorsement' id='delete_endorsement_"+item.userid+"'><img src='../images/action_delete.gif' border='0'/></a></td>");
			row+=("<td class='td_info' width='30%'><a href='#' class='view_profile' id='view_profile_"+item.userid+"'>"+item.firstName+"</a></td>");
			
			var skills = "";
			if (item.skills!=undefined){
				for (var i=0;i<item.skills.length-2;i++){
					if (item.skills[i]!=undefined){
						skills+=(item.skills[i].skill)+", ";		
					}
				}	
				if (item.skills[item.skills.length-1]!=undefined){
					skills+=item.skills[item.skills.length-1].skill;	
				}
			}else{
				skills+="&nbsp;"
			}
		
			row+=("<td class='td_info' width='70%'>"+skills+"</td>");
			row+="</tr>";
			jQuery(row).appendTo("#endorse-listings table").fadeIn(100);
			
		});
		
	}
	jQuery(".delete_endorsement").live("click", function(e){
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[2];
		jQuery.post("/portal/recruiter/remove_endorsement.php", {userid:id}, renderContent);
		jQuery("#endorse_"+id).removeAttr("checked");
		e.preventDefault();
	});
	jQuery(".view_profile").live("click", function(e){
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[2];
		open_popup_profile(id);
	});
	jQuery(".endorse_checkbox").click(function(){
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[1];
		if (jQuery(this).hasClass("add_endorse")){
			if (jQuery(this).is(":checked")){
				jQuery.get("/portal/recruiter/check-online-resume.php?userid="+id, function(data){
					data = jQuery.parseJSON(data);
					if (data.result){
						jQuery.post("/portal/recruiter/multiple_endorse.php", {userid:id}, renderContent);
					}else{
						alert("The candidate has no resume created yet");
						jQuery(this).attr("checked", false);
					}
				})
			}else{
				jQuery.post("/portal/recruiter/remove_endorsement.php", {userid:id}, renderContent);
			}
		}else{
			if (jQuery(this).is(":checked")){
				jQuery.post("/portal/recruiter/multiple_endorse.php", {userid:id}, renderContent);
			}else{
				jQuery.post("/portal/recruiter/remove_endorsement.php", {userid:id}, renderContent);			
			}
		}
	});
	
	jQuery(".book-interview").click(function(e){
		jQuery.get("/portal/recruiter/clear_booking_session.php", function(){
			booking();
		})
		e.preventDefault();
	})
	
	jQuery(".endorse-client-link").click(function(e){
		previewPath = "/portal/recruiter/load_staff_for_endorsement.php";
		window.open(previewPath,'_blank','width=700,height=500,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		e.preventDefault();
	});
	
	jQuery(".result_per_pager").change(function(){
		jQuery("#result_per_page").val(jQuery(this).val());
		var params = jQuery("#search-form").serialize();
		window.location.href = "/portal/recruiter/recruiter_search.php?"+params;
	});
	
	jQuery(".pager").change(function(){
		jQuery("#page").val(jQuery(this).val());
		var params = jQuery("#search-form").serialize();
		window.location.href = "/portal/recruiter/recruiter_search.php?"+params;
	});
	
	jQuery("#search-form").submit(function(){
		jQuery("#page").val(1);
		jQuery("#searched").val(1);
	});
	
	jQuery("input[name=limitby]").click(function(){
		var value = jQuery(this).val();
		if (value=="all"){
			jQuery("#limit").attr("disabled", "disabled");
		}else{
			jQuery("#limit").removeAttr("disabled", "disabled");
		}
	})
	
	jQuery(".export").click(function(e){
		
		
		var limit = jQuery("#limit").val();
		var all = jQuery("#all");
		if (!all.is(":checked")){
			if (isNaN(limit)){
				alert("Please enter a numeric value");
			}else if (jQuery.trim(limit)==""){
				alert("Please enter a value to be used for limiting");
			}else{
				if (parseInt(limit)>10000){
					alert("Exceeded max limit value");
				}else{
					var params = jQuery("#search-form").serialize();		
					jQuery.get("/portal/recruiter/check_priviledge_on_exporting_staff_list.php", function(data){
						data = jQuery.parseJSON(data);
						if (data.notallowed){
							alert("You are not allowed to export the query result.")
						}else{
							window.location.href = "/portal/recruiter/exportcsv.php?"+params;
						}					
					});
				}
			}
		}else{
			var params = jQuery("#search-form").serialize();
			jQuery.get("/portal/recruiter/exportcsv.php?"+params+"&checked=1", function(data){
				data = jQuery.parseJSON(data);
				if (data.notallowed){
					alert("You are not allowed to export the query result.")
				}else{
					if (data.exceed){
						var answer = confirm("The system can only export 10,000 records. Is this ok with you?");
						if (answer){
							window.location.href = "/portal/recruiter/exportcsv.php?"+params;
						}
					}else{
						window.location.href = "/portal/recruiter/exportcsv.php?"+params;
						
					}
				}
				
			});
		}
		e.preventDefault();
	})
	jQuery.get("/portal/recruiter/load_endorsement.php", renderContent);
	jQuery.get("/portal/recruiter/staff_custom_booking_session.php", function(data){
		jQuery("#listings table").html(data);
	});
	
	jQuery(".mass_email").live("click", function(){
		var action = "clicked";	
		if (jQuery(this).hasClass("cancel")){
			action = "cancel";
		}else if (jQuery(this).hasClass("replace")){
			action = "replace";
		}
		jQuery("#mass_email_option").html("<img src='/portal/images/ajax-loader.gif' height='20'/>");
		jQuery.get("/portal/recruiter/recruiter_search_check_emailing.php?action=", function(html){
			jQuery("#mass_email_option").html(html);
		})
	});
	jQuery(".mass_emailer").live("click", function(){
		
		var value = jQuery(this).val();
		var action = "";
		if (value=="Yes"){
			action = "replace";
		}else if (value=="Cancel"){
			action = "cancel";
		}
		jQuery("#mass_email_option").html("<img src='/portal/images/ajax-loader.gif' height='20'/>");
		jQuery.get("/portal/recruiter/recruiter_search_check_emailing.php?action="+action, function(html){
			jQuery("#mass_email_option").html(html);
		})	
	});
	
	jQuery(".delete").live("click", function(e){
		jQuery("#shortlist-delete").remove();
		var positionLeft = jQuery("#listings-main").offset().left;
		var userid = jQuery(this).attr("data-userid");
		var i = 0;
		var totalWidth =  0;
		for(i=2;i<=4;i++){
			totalWidth+=jQuery(".features-table tr td:nth-child("+i+")").outerWidth(true);
		}
		
		jQuery("<div id='shortlist-delete' class='shortlist-delete'><img src='/portal/images/ajax-loader.gif'/></div>").css("position", "absolute").css("top", (jQuery(this).offset().top-12)+"px").width(totalWidth).css("left", (positionLeft+jQuery(".features-table tr td:nth-child(1)").outerWidth(true)+25)+"px").appendTo("body");
		jQuery.get("/portal/recruiter/list_shortlist.php?userid="+userid, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				var options = "<p align='right'><img src='/portal/images/closelabel.gif' class='close-shortlist'/></p><h3><span style='width:180px;display:inline-block;margin-right:5px;margin-left:10px;'>Lead</span><span style='width:257px;display:inline-block;margin-right:5px'>Job Position</span><span style='width:100px;display:inline-block;margin-right:5px'>Status</span></h3><form id='shortlist-form' style='font-size:11px'>";
				jQuery.each(data.list, function(i, item){
					var link = ("<a href='/portal/Ad.php?id="+item.posting_id+"' target='_blank'>"+item.job_title+"</a>");
					var leads_link = "<a href='/portal/leads_information.php?id="+item.lead_id+"' target='_blank'>"+item.client+"</a>";
					if (i==0){
						options+=("<span style='width:200px;display:inline-block;margin-right:5px;margin-left:5px'><input type='radio' value='"+item.id+"' name='shortlist_id' checked/>"+leads_link+"</span><span style='width:257px;display:inline-block;margin-right:5px'>"+link+"</span><span style='width:100px;display:inline-block;margin-right:5px'>"+item.status+"</span><br/>");
					}else{
						options+=("<span style='width:200px;display:inline-block;margin-right:5px;margin-left:5px'><input type='radio' value='"+item.id+"' name='shortlist_id'/>"+leads_link+"</span><span style='width:257px;display:inline-block;margin-right:5px'>"+link+"</span><span style='width:100px;display:inline-block;margin-right:5px'>"+item.status+"</span><br/>");
					}
					
				});
				options+="</form>";
				var button = "<button type='submit' class='remove-short-button' data-userid='"+userid+"'>Remove</button>";
				jQuery("#shortlist-delete").html(options+"<br/>"+button);
				
			}
		});
		
		e.preventDefault();
	});
	
	jQuery(".remove-short-button").live("click", function(e){
		var formData = jQuery("#shortlist-form").serialize();
		var userid = jQuery(this).attr("data-userid");
		jQuery.post("/portal/recruiter/remove_from_shortlist.php", formData, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				jQuery("#shortlist-delete").html("<img src='/portal/images/ajax-loader.gif'/>");
				
				jQuery.get("/portal/recruiter/list_shortlist.php?userid="+userid, function(data){
					data = jQuery.parseJSON(data);
					if (data.success){
						var options = "<p align='right'><img src='/portal/images/closelabel.gif' class='close-shortlist'/></p><h3><span style='width:180px;display:inline-block;margin-right:5px;margin-left:10px;'>Lead</span><span style='width:257px;display:inline-block;margin-right:5px'>Job Position</span><span style='width:100px;display:inline-block;margin-right:5px'>Status</span></h3><form id='shortlist-form' style='font-size:11px'>";
						jQuery.each(data.list, function(i, item){
							var link = ("<a href='/portal/Ad.php?id="+item.posting_id+"' target='_blank'>"+item.job_title+"</a>");
							var leads_link = "<a href='/portal/leads_information.php?id="+item.lead_id+"' target='_blank'>"+item.client+"</a>";
							if (i==0){
								options+=("<span style='width:200px;display:inline-block;margin-right:5px;margin-left:5px'><input type='radio' value='"+item.id+"' name='shortlist_id' checked/>"+leads_link+"</span><span style='width:257px;display:inline-block;margin-right:5px'>"+link+"</span><span style='width:100px;display:inline-block;margin-right:5px'>"+item.status+"</span><br/>");
							}else{
								options+=("<span style='width:200px;display:inline-block;margin-right:5px;margin-left:5px'><input type='radio' value='"+item.id+"' name='shortlist_id'/>"+leads_link+"</span><span style='width:257px;display:inline-block;margin-right:5px'>"+link+"</span><span style='width:100px;display:inline-block;margin-right:5px'>"+item.status+"</span><br/>");
							}
							
						});
						options+="</form>";
						var button = "<button type='submit' class='remove-short-button' data-userid='"+userid+"'>Remove</button>";
						jQuery("#shortlist-delete").html(options+"<br/>"+button);
						alert("Candidate has been successfully removed from the shortlisted list\nPlease reload the page to reflect the changes");
					}
				});
				
			}
		})
		e.preventDefault();
	});
	
	jQuery(".close-shortlist").live("click", function(){
		jQuery("#shortlist-delete").fadeOut(500, function(){
			jQuery("#shortlist-delete").remove();
		});
	});
	
	function clearAvailability(){
		var selected = jQuery("input[name=available_status]:checked").val();
		if (selected=="a"){
			jQuery("#available_date").val("");
		}else if (selected=="b"){
			jQuery("select[name=available_notice]").val("");
			jQuery("#date_notice_from").val("");
		}else{
			jQuery("#available_date").val("");
			jQuery("select[name=available_notice]").val("");
			jQuery("#date_notice_from").val("");
		}
	}
	jQuery("input[name=available_status]").live("click", function(){
		clearAvailability();
	});
	clearAvailability();
	recruiterName = jQuery("#assign_recruiter option:selected").text();
	
});