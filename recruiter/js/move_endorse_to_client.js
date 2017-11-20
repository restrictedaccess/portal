//START: open lead full-control profile
function lead(id) 
{
	previewPath = "../leads_information.php?id="+id;
	window.open(previewPath,'_blank','width=700,height=800,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}
//ENDED: open lead full-control profile


//START: validate
function validate(form) 
{
	var position = form.position.value;
	var job_category = form.job_category.value;
	var subject_id = form.subject_id.value;
	var search_lead_id = form.search_lead_id.value;
	
	if (position == "" && job_category == "")
	{
		alert("Please choose the position or job category."); return false;
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
	popup_report_obj.open('get', 'endorse_popup_search_report.php?keyword='+keyword)
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
	job_position_obj.open('get', 'endorse_job_position_report.php?id='+id)
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
	job_category_obj.open('get', 'endorse_job_category_report.php')
	job_category_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	job_category_obj.onreadystatechange = show_job_category_report_loader 
	job_category_obj.send(1)
}	
//ENDED: load lob category list


//START: resume & asl checker
function resume_checker(path) 
{
	window.open("../"+path,'_blank','width=800,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}		
function asl_checker(path) 
{
	window.open("../"+path,'_blank','width=800,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}
//ENDED: resume & asl checker


//START: open popup profile
function open_popup_profile(userid)
{
	window.open("staff_information.php?userid="+userid+"&page_type=popup",'_blank','width=800,height=500,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}
function open_popup_resume(userid)
{
	window.open("../../admin-staff-resume.php?userid="+userid,'_blank','width=800,height=500,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}
//ENDED: open popup profile