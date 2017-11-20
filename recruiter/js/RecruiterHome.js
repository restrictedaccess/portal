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
function show_popup_report(search_date1, search_date2, recruiter_id, field) 
{
	popup_report_obj.open('get', 'RecruiterHome_popup_report.php?search_date1='+search_date1+'&search_date2='+search_date2+'&recruiter_id='+recruiter_id+'&field='+field)
	popup_report_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	popup_report_obj.onreadystatechange = show_popup_report_loader 
	popup_report_obj.send(1)
	document.getElementById("popup_report").style.visibility='visible'
}	
function hide_popup_report()
{
	document.getElementById("popup_report").style.visibility='hidden'
}		
function show_hide_search(id, label) 
{
	var search_box = document.getElementById(id);
	var label_str = document.getElementById(label);
	if (search_box.style.display == 'none') 
	{
		search_box.style.display = '';
		label_str.innerHTML = '[Hide]';
	} 
	else 
	{
		search_box.style.display = 'none';
		label_str.innerHTML = '[Show]';
	}
}
function search_date_check_function(check)
{
	document.getElementById('search_date1').disabled = (check.checked);
	document.getElementById('search_date2').disabled = (check.checked);
}

function checkreloadwindow(){
	if(window.document.getElementById('reload').value == '1'){  
		window.location.reload();
	}
}

function reloadwin2(win2){
	if (win2.closed){
		setTimeout("checkreloadwindow()",1000)
	}
	else{
		return setTimeout("reloadwin2(win2)",1000);
	}
}
 
//START: open popup profile
function open_popup_profile(userid)
{
	win2 = window.open("staff_information.php?userid="+userid+"&page_type=popup",'_blank','width=800,height=500,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
	reloadwin2(win2);
}
//ENDED: open popup profile

function lead(id) 
{
	previewPath = "../leads_information.php?id="+id;
	window.open(previewPath,'_blank','width=700,height=800,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}

function ads(id){
	popup_win("/portal/Ad.php?id="+id, 800, 600)
}
