function renderResponse(response){
	var output = "";
	jQuery.each(response.rows, function(i, item){
		var row = "<tr>";
		if (item.posting_id!=null){
			row += "<td><a href='/portal/Ad.php?id="+item.posting_id+"' target='_blank'>"+item.job_title+" </a><br/>["+item.tracking_code+"]</td>";		
			
		}else{
			row += "<td>"+item.job_title+"<br/> ["+item.tracking_code+"]</td>";		
			
		}
		row += "<td><a href='/portal/leads_information.php?id="+item.leads_id+"' target='_blank'>"+item.client+"</a></td>";
		row += "<td>"+item.service_type+"</td>";
		row += "<td>"+item.no_of_staff_needed+"</td>";
		if (item.hc_fname){
			row += "<td>"+item.hc_fname+" "+item.hc_lname+"</td>";
		}else{
			row += "<td>No Hiring Manager</td>";		
		}
		
		var recruiter_list = "";
		recruiter_list += "<ul style='list-style-type:none;padding:0;margin:0;'>";
		jQuery.each(item.assigned_recruiters, function(j, recruiter){
			recruiter_list += "<li style='font-size:10px;'>"+recruiter.admin_fname+" "+recruiter.admin_lname+"</li>";
		});
		recruiter_list += "</ul>";
		row += "<td>"+recruiter_list+"</td>";
		
		if (item.total_shortlist>0){
			row += "<td>Yes</td>";	
		}else{
			row += "<td>No</td>";	
		}
		var link = "";
		
		link = "/portal/recruiter/get_shortlisted_staff.php?posting_id="+item.posting_id+"&tracking_code="+item.tracking_code+"&shortlist_type="+jQuery("select[name=shortlist_type]").val();
		row += "<td><a href='"+link+"' class='popup'>"+item.total_shortlist+"</a></td>";	
		jQuery.each(item.all_recruiters, function(j, recruiter){
			link = "/portal/recruiter/get_shortlisted_staff.php?posting_id="+item.posting_id+"&tracking_code="+item.tracking_code+"&shortlist_type="+jQuery("select[name=shortlist_type]").val()+"&admin_id="+recruiter.admin_id;
			row += "<td><a href='"+link+"' class='popup'>"+recruiter.count+"</a></td>";
		})
		row+="<td>"+item.category+"</td>";
		row+="<td>"+"<a href='/portal/recruiter/load_comments.php?tracking_code="+item.tracking_code+"' class='view_hm_notes'>View Notes("+item.job_order_comments_count+")</a></td>";
		row+="</tr>";
		output += row;
	})
	
	jQuery("#recruitment_report_list tbody").html(output);
	
	var start = ((response.page-1)*rows) + 1;
	var end = (start + rows) - 1;
	if (end>response.records){
		end = response.records;
		jQuery(".next").addClass("disabled");
	}else{
		jQuery(".next").removeClass("disabled");
	}
	if (response.page==1){
		jQuery(".prev").addClass("disabled");
	}else{
		jQuery(".prev").removeClass("disabled");
	}	
	jQuery(".start_count").text(start);
	jQuery(".end_count").text(end);
	jQuery(".total_records").text(response.records);
	hasRequest = false
	removePreloader();
	
}

function addPreloader(){
	var top = (jQuery(".rs-preloader").height()/2) - jQuery("#preloader-img").height();
	jQuery("#preloader-img").css("top", top+"px").css("position", "absolute");
	jQuery(".rs-preloader").show();
}

function removePreloader(){
	jQuery(".rs-preloader").hide();
}


var page = 1;
var rows = 50;
var hasRequest = false;



jQuery(document).ready(function(){
	jQuery("#date_ordered_from").datepicker();
	jQuery("#date_ordered_to").datepicker();
	jQuery("#date_ordered_from").datepicker("option", "dateFormat", "yy-mm-dd");
	jQuery("#date_ordered_to").datepicker("option", "dateFormat", "yy-mm-dd");	
	jQuery("select[name=order_status]").val("Open");
	if (!hasRequest){
		addPreloader();
		hasRequest = true;
		jQuery.get("/portal/recruiter/load_jo_recruitment.php", function(response){
			response = jQuery.parseJSON(response);
			
			renderResponse(response);		
		})		
	}

	jQuery(".delete_note").live("click", function(e){
		var ans = confirm("Do you want to delete this note?");
		var me = jQuery(this);
		if (ans){
			jQuery.get(me.attr("href"), function(response){
				me.parent().parent().remove();
			})
		}
		e.preventDefault();
	});
	
	jQuery("#filter-form").submit(function(){
		if (!hasRequest){
			addPreloader();
			hasRequest = true;
			page = 1;
			var data = jQuery(this).serialize();
			data += "&page="+page
			
			jQuery.get("/portal/recruiter/load_jo_recruitment.php?"+data, function(response){
				response = jQuery.parseJSON(response);
				renderResponse(response);		
			})
			jQuery("#total_shortlists tbody").html("");
			jQuery.get("/portal/recruiter/load_recruitment_team_shortlists_total.php?"+data, function(response){
				response = jQuery.parseJSON(response);
				var output = ""
				var totalAssigned = 0;
				var totalUnassigned = 0;
				jQuery.each(response, function(i, item){
					output += "<tr>";
					output += "<td>"+item.admin_fname+" "+item.admin_lname+"</td>";
					output += "<td>"+item.assigned+"</td>";
					output += "<td>"+item.unassigned+"</td>";
					output += "</tr>";
					totalAssigned += item.assigned;
					totalUnassigned += item.unassigned;
					
				})
				
				output+="<tr>";
				output+="<td><strong>Total</strong></td>";
				output+="<td>"+totalAssigned+"</td>";
				output+="<td>"+totalUnassigned+"</td>";
				
				output+="</tr>";
				jQuery("#total_shortlists tbody").html(output);
			});
		}
		
		return false;
	});
	
	jQuery(".next").click(function(e){
		if (!jQuery(this).hasClass("disabled")){
			if (!hasRequest){
				addPreloader();
				hasRequest = true;
				page+=1;
				var data = jQuery("#filter-form").serialize();
				data += "&page="+page
				jQuery.get("/portal/recruiter/load_jo_recruitment.php?"+data, function(response){
					response = jQuery.parseJSON(response);
					renderResponse(response);		
				})			
			}			
		}


		e.preventDefault();
	})
	
	jQuery(".prev").click(function(e){
		if (!jQuery(this).hasClass("disabled")){
			if (!hasRequest){
					addPreloader();
					hasRequest = true;
					page-=1;
				
					var data = jQuery("#filter-form").serialize();
					data += "&page="+page
					jQuery.get("/portal/recruiter/load_jo_recruitment.php?"+data, function(response){
						response = jQuery.parseJSON(response);
						renderResponse(response);		
					})
			}
						
		}
		e.preventDefault();
	})
	
	
	
	jQuery(".add_new_comment").live("submit", function(e){
		var data = jQuery(this).serialize();
		jQuery.post("/portal/recruiter/add_new_jo_comments.php", data, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				var comment = response.comment;
				var template = '<li style="border-bottom:1px dotted #312E27;width:431px;word-wrap:break-word">';
				if (response.hm){
					template += '<div style="float:right">'
					template += '<a href="/portal/recruiter/delete_jo_comments.php?id='+comment.id+'" class="delete_note">[x]</a></div>'	
				}
				template += '<strong>By: </strong>'+comment.admin_fname+' '+comment.admin_lname+'<br/>';
				template += '<strong>Date Created: </strong>'+comment.date_created+'<br/>';
				template += '<strong>Subject:</strong>'+comment.subject+'<br/>';
				template += '<strong>Note:</strong><p style="margin-top:0">'+comment.comment+'</p></li>'; 
				jQuery(template).appendTo(jQuery(".notes_list ul"));
				jQuery("input[name=subject]").val("");
				jQuery("textarea[name=comment]").val("");
				
			}else{
				alert(response.error);
			}
		})
		return false;
	})
	
	jQuery(".view_hm_notes").live("click", function(e){
		jQuery("#ui-datepicker-div").css("display", "none");
		jQuery("#details-dialog").html("")
		jQuery( "#dialog:ui-dialog" ).dialog( "destroy" );
		jQuery( "#details-dialog" ).dialog(
		{height: 430,
		width:840,
		modal: true,
		title:"View HM Notes"
			
		});
		
		jQuery.get(jQuery(this).attr("href"), function(data){
			jQuery("#details-dialog").html(data);
		})
		
		e.preventDefault();
	})
	
	jQuery(".popup").live("click", function(e){
		var href = jQuery(this).attr("href")
		window.open(href,'_blank','width=700,height=600,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		e.preventDefault()
	})
	
	jQuery.get("/portal/recruiter/load_recruitment_team_shortlists_total.php", function(response){
		response = jQuery.parseJSON(response);
		var output = ""
		var totalAssigned = 0;
		var totalUnassigned = 0;
		jQuery.each(response, function(i, item){
			output += "<tr>";
			output += "<td>"+item.admin_fname+" "+item.admin_lname+"</td>";
			output += "<td>"+item.assigned+"</td>";
			output += "<td>"+item.unassigned+"</td>";
			output += "</tr>";
			totalAssigned += item.assigned;
			totalUnassigned += item.unassigned;
			
		})
		
		output+="<tr>";
		output+="<td><strong>Total</strong></td>";
		output+="<td>"+totalAssigned+"</td>";
		output+="<td>"+totalUnassigned+"</td>";
		
		output+="</tr>";
		jQuery("#total_shortlists tbody").html(output);
	});
});
