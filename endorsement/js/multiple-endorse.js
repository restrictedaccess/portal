//START: open lead full-control profile
function lead(id) 
{
	previewPath = "/portal/leads_information.php?id="+id;
	window.open(previewPath,'_blank','width=700,height=800,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}
//ENDED: open lead full-control profile


//START: validate
function validate(form) 
{
	var position = form.position.value;
//	var job_category = form.job_category.value;
	var subject_id = form.subject_id.value;
	var search_lead_id = form.search_lead_id.value;
	
	if (position == "")
	{
		alert("Please choose the position."); return false;
	}
	
	if (subject_id == "") { alert("Please enter subject."); form.subject_id.focus(); return false; }
	if (search_lead_id == "") { alert("Please enter lead ID."); form.search_lead_id.focus(); return false; }

	return true ;
}
//ENDED: validate


//START: lead popup search report
var popup_report_obj = makeObject();
function show_popup_report_loader()
{
	var data;
	data = popup_report_obj.responseText
	if(popup_report_obj.readyState == 4)
	{
		document.getElementById("popup_report").innerHTML = data;
	}
	else
	{
		document.getElementById("popup_report").innerHTML="<img src='../images/ajax-loader.gif' width='20'>";
	}
}		
function show_popup_report() 
{
	document.getElementById("popup_report").style.visibility='visible'
}	
function show_search_popup_report() 
{
	var keyword = document.getElementById('keyword').value;
	popup_report_obj.open('get', '/portal/recruiter/endorse_popup_search_report.php?keyword='+keyword)
	popup_report_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	popup_report_obj.onreadystatechange = show_popup_report_loader 
	popup_report_obj.send(1)
	document.getElementById("popup_report").style.visibility='visible'
}	
function hide_popup_report()
{
	document.getElementById("popup_report").style.visibility='hidden'
}
//ENDED: lead popup search report


//START: load lob position list
var job_position_obj = makeObject();
function show_job_position_report_loader()
{
	var data;
	data = job_position_obj.responseText
	if(job_position_obj.readyState == 4)
	{
		document.getElementById("job_position_report").innerHTML = data;
	}
	else
	{
		document.getElementById("job_position_report").innerHTML="<img src='../images/ajax-loader.gif' width='20'>";
	}
}		
function show_job_position_report() 
{
	var id = document.getElementById('search_lead_id').value;
	job_position_obj.open('get', '/portal/recruiter/endorse_job_position_report.php?id='+id)
	job_position_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	job_position_obj.onreadystatechange = show_job_position_report_loader 
	job_position_obj.send(1)
}	
//ENDED: load lob position list


//START: load lob category list
var job_category_obj = makeObject();
function show_job_category_report_loader()
{
	var data;
	data = job_category_obj.responseText
	if(job_category_obj.readyState == 4)
	{
		document.getElementById("job_category_report").innerHTML = data;
	}
	else
	{
		document.getElementById("job_category_report").innerHTML="<img src='../images/ajax-loader.gif' width='20'>";
	}
}		
function show_job_category_report() 
{
	job_category_obj.open('get', '/portal/recruiter/endorse_job_category_report.php')
	job_category_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	job_category_obj.onreadystatechange = show_job_category_report_loader 
	job_category_obj.send(1)
}	
//ENDED: load lob category list


//START: resume & asl checker
function resume_checker(path) 
{
	window.open("/portal/"+path,'_blank','width=800,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}		
function asl_checker(path) 
{
	window.open("/portal/"+path,'_blank','width=800,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}
//ENDED: resume & asl checker


//START: open popup profile
function open_popup_profile(userid)
{
	window.open("/staff_information.php?userid="+userid+"&page_type=popup",'_blank','width=800,height=500,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}
function open_popup_resume(userid)
{
	window.open("/admin-staff-resume.php?userid="+userid,'_blank','width=800,height=500,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}
//ENDED: open popup profile


/**
 * Multiple endorse
 */
jQuery(document).ready(function(){
	//START: Renders on content for endorsement
	function renderContent(data){
		data = jQuery.parseJSON(data);
		jQuery("#endorsement-listings table").html("");
		
		
		jQuery.each(data, function(i, item){
		
			var row = "<tr>";
			row+=("<td class='td_info'><a href='#' class='delete_endorsement' id='delete_endorsement_"+item.userid+"'><img src='../images/action_delete.gif' border='0'/></a></td>");
			row+=("<td class='td_info' width='30%'><a href='/portal/recruiter/staff_information.php?userid="+item.userid+"' class='view_profile' target='_blank' id='view_profile_"+item.userid+"'>"+item.firstName+"</a></td>");
			
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
			$(row).appendTo("#endorsement-listings table").fadeIn(100);
			
		});
		
	}
	jQuery(".delete_endorsement").live("click", function(e){
		var id = $(this).attr("id");
		id = id.split("_");
		id = id[2];
		jQuery.post("/portal/recruiter/remove_endorsement.php", {userid:id}, renderContent);
		e.preventDefault();
	});
	jQuery.get("/portal/recruiter/load_endorsement.php", renderContent);
	
	
	jQuery(".refresh-list").click(function(e){
		jQuery.get("/portal/recruiter/load_endorsement.php", renderContent);	
		e.preventDefault();
	});
	
	jQuery(".add-more-candidates").click(function(e){
		var href = $(this).attr("href");
		var width = screen.width;
		var height = screen.height;
		
		window.open(href,'_blank','width='+width+',height='+height+',resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		e.preventDefault();
	});
	jQuery("#leads-form").submit(function(){
		if (!validate(this)){
			return false;
		}
		var dataSend = $(this).serialize();
		dataSend.send = true;
		jQuery.post("/portal/endorsement/multiple-endorse.php?send=1", dataSend, function(data){
			data = jQuery.parseJSON(data);
			if (data.result){
				alert("Endorsement has been completed");
				window.close();		
			}else{
				alert(data.message);
			}
		});
		return false;
	});
	
	
});