var active_userid = "";

//START: form validation & other functions
function checkAll(field)
{
	userval2 =new Array();
	if (field==null)
	{
		alert("There is no Selection to be Processed!");
		return false;
	}
	else
	{
		if((field.length)!=undefined)
		{
			for (i = 0; i < field.length; i++)
			{
				field[i].checked = true ;
				userval2.push(field[i].value);	
			}
			document.getElementById("emails").value=(userval2);
		}
		else
		{
			document.getElementById("emails").value = document.getElementById("list").value;
			document.getElementById("users").checked = true ;
		}
	}
}
function setSearchDate()
{
	//date_apply
	if(document.form.date_apply.value!="")
	{
		document.form.submit();
		//alert(document.form.date_apply.value);
	}
}
function l(posting_id)
{
	window.location="?posting_id="+posting_id;
}
function any_date(check)
{
	document.getElementById('id_date_requested_applied1').disabled = (check.checked);
	document.getElementById('id_date_requested_applied2').disabled = (check.checked);
}			
function registered_any_date(check)
{
	document.getElementById('id_date_requested1').disabled = (check.checked);
	document.getElementById('id_date_requested2').disabled = (check.checked);
}	
function updated_any_date(check)
{
	document.getElementById('id_date_updated1').disabled = (check.checked);
	document.getElementById('id_date_updated2').disabled = (check.checked);
}	
function any_key(check)
{
	document.getElementById('key_id').disabled = (check.checked);
	document.getElementById('key_type_id').disabled = (check.checked);
}			
function registered_any_key(check)
{
	document.getElementById('registered_key_id').disabled = (check.checked);
	document.getElementById('registered_key_type_id').disabled = (check.checked);
}	
function validate(form) 
{

	if(!form.date_check.checked)
	{
		if (form.date_requested_applied1.value == '' || form.date_requested_applied1.value == 'Any') { alert("You forgot to select the date."); form.date_requested_applied1.focus(); return false; }	
		if (form.date_requested_applied2.value == '' || form.date_requested_applied2.value == 'Any') { alert("You forgot to select the date."); form.date_requested_applied2.focus(); return false; }	
	}
	if(!form.key_check.checked)
	{
		if (form.key.value == '') { alert("You forgot to enter the 'keyword'."); return false; }	
	}
}
function registered_validate(form) 
{
	if(!form.registered_date_check.checked)
	{
		if (form.date_requested1.value == '' || form.date_requested1.value == 'Any') { alert("You forgot to select the date for staff registration."); form.date_requested1.focus(); return false; }	
		if (form.date_requested2.value == '' || form.date_requested2.value == 'Any') { alert("You forgot to select the date for staff registration."); form.date_requested2.focus(); return false; }	
	}
	if(!form.updated_date_check.checked)
	{
		if (form.date_updated1.value == '' || form.date_updated1.value == 'Any') { alert("You forgot to select the date for staff resume up to date."); form.date_updated1.focus(); return false; }	
		if (form.date_updated2.value == '' || form.date_updated2.value == 'Any') { alert("You forgot to select the date for staff resume up to date."); form.date_updated2.focus(); return false; }	
	}	
	if(!form.registered_key_check.checked)
	{
		if (form.registered_key.value == '') { alert("You forgot to enter the 'keyword'."); return false; }	
	}
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
//ENDED: form validation & other functions


//START: open popup profile
function open_popup_profile(userid)
{
	window.open("staff_information.php?userid="+userid+"&page_type=popup",'_blank','width=800,height=500,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}
//ENDED: open popup profile


//START: staff_recruiter stamp update
	//start: open assign recruiter
	function open_assign_recruiter(userid)
	{
		if(active_userid != "")
		{
			document.getElementById("popup_container"+active_userid).innerHTML = "";	
		}
		active_userid = userid;
		document.getElementById("popup_container"+userid).innerHTML = document.getElementById("staff_recruiter_stamp_div").innerHTML;
	}
	//ended: open assign recruiter

	//start: open assign recruiter
	function close_popup()
	{
		document.getElementById("popup_container"+active_userid).innerHTML = "";
	}
	//ended: open assign recruiter

	//start: update recruiter
	var staff_recruiter_stamp_update_obj = makeObject();
	function staff_recruiter_stamp_update()
	{
		var admin_id = document.getElementById("staff_recruiter_stamp_assign").value;
		if(admin_id != '')
		{
			staff_recruiter_stamp_update_obj.open('get', 'staff_recruiter_update.php?userid='+active_userid+'&admin_id='+admin_id)
			staff_recruiter_stamp_update_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			staff_recruiter_stamp_update_obj.onreadystatechange = staff_recruiter_stamp_loader 
			staff_recruiter_stamp_update_obj.send(1)
			document.getElementById("popup_container"+active_userid).innerHTML = "";
		}
		else
		{
			alert("Please select a recruiter.");
		}
	}
	function staff_recruiter_stamp_loader()
	{
		var data;
		data = staff_recruiter_stamp_update_obj.responseText
		if(staff_recruiter_stamp_update_obj.readyState == 4)
		{
			document.getElementById("div_rec"+active_userid).innerHTML = "<font color=#FF0000>"+data+"</font>";
			alert("Recruiter "+data+" has been successfully assigned.");
		}
		else
		{
			document.getElementById("div_rec"+active_userid).innerHTML="<img src='../images/ajax-loader.gif' width='20'>";
		}
	}		
	//ended: update recruiter
//ENDED: staff recruiter stamp update


//START: delete staff
	//start: execute delete staff
	var delete_staff_obj = makeObject();
	function execute_delete_staff()
	{
		delete_staff_obj.open('get', 'staff_remove.php?userid='+active_userid)
		delete_staff_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		delete_staff_obj.send(1)
		document.getElementById("popup_container"+active_userid).innerHTML = "";
		document.getElementById("div1"+active_userid).innerHTML = "<img src='../images/edit.gif'>";
		document.getElementById("div2"+active_userid).innerHTML = "<img src='../images/edit.gif'>";
		document.getElementById("div3"+active_userid).innerHTML = "<img src='../images/edit.gif'>";
		document.getElementById("div4"+active_userid).innerHTML = "<img src='../images/edit.gif'>";
		document.getElementById("div5"+active_userid).innerHTML = "<img src='../images/edit.gif'>";
		document.getElementById("div6"+active_userid).innerHTML = "<img src='../images/edit.gif'>";
		document.getElementById("div7"+active_userid).innerHTML = "<img src='../images/edit.gif'>";
	}
	//ended: execute delete staff
	
	//start: call delete staff & warning
	function delete_staff(userid)
	{
		if(active_userid != "")
		{
			document.getElementById("popup_container"+active_userid).innerHTML = "";
		}
		active_userid = userid;
		document.getElementById("popup_container"+userid).innerHTML = document.getElementById("delete_staff_div").innerHTML;
	}
	//ended: call delete staff & warning
//ENDED: delete staff


//START: hot / experience
	//start: execute delete staff
	var hot_obj = makeObject();
	var experienced_obj = makeObject();
	function mark_as_hot(userid,stat)
	{
		var status = "";
		if(stat.checked)
		{
			status = 1;
		}
		else
		{
			status = 0;
		}
		hot_obj.open('get', 'staff_hot_update.php?stat='+status+'&userid='+userid)
		hot_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		hot_obj.send(1)
		alert("You changes has been saved.");
	}
	//ended: execute delete staff
	
	//start: call delete staff & warning
	function mark_as_experienced(userid,stat)
	{
		var status = "";
		if(stat.checked)
		{
			status = 1;
		}
		else
		{
			status = 0;
		}
		experienced_obj.open('get', 'staff_experienced_update.php?stat='+status+'&userid='+userid)
		experienced_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		experienced_obj.send(1)
		alert("You changes has been saved.");		
	}
	//ended: call delete staff & warning
//ENDED: hot / experience


//START: endorsement
var endorse_obj = makeObject()
function order(userid)
{
	if(document.getElementById('app_id'+userid).checked == true)
	{
		endorse_obj.open('get', 'staff_custom_booking_session.php?userid='+userid)
		endorse_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		endorse_obj.onreadystatechange = active_listings 
		endorse_obj.send(1)
	}
	else
	{
		endorse_obj.open('get', 'staff_custom_booking_session.php?uncheck_id='+userid)
		endorse_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		endorse_obj.onreadystatechange = active_listings 
		endorse_obj.send(1)
	}
}
function active_listings()
{
	var data;
	data = endorse_obj.responseText
	if(endorse_obj.readyState == 4)
	{
		document.getElementById('listings').innerHTML = '<table cellpadding="3" cellspacing="3" width="100%">'+data+'</table>';
	}
	else
	{
		document.getElementById("listings").innerHTML="<table width='100%' height='100%' align='center' cellspacing='5' cellspading='5'><tr><td align=center><img src='../images/ajax-loader.gif'></td></tr></table>";
	}
}
function cancel_selected_order(userid)
{
	var checkbox = document.getElementById('app_id'+userid);
	if (checkbox!=null){
		document.getElementById('app_id'+userid).checked = false;	
	}else{
		if (jQuery!=undefined){
			jQuery("#app_id"+userid).attr("checked", false);
		}
	}
	endorse_obj.open('get', 'staff_custom_booking_session.php?uncheck_id='+userid)
	endorse_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	endorse_obj.onreadystatechange = active_listings 
	endorse_obj.send(1)
}
function booking() 
{
	previewPath = "../../custom-portal-booking.php";
	window.open(previewPath,'_blank','width=820,height=700,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}
//ENDED: endorsement


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
	popup_report_obj.open('get', 'staff_popup_search_report.php?keyword='+keyword)
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


//START: staff emailing
var staff_emailing_obj = makeObject();
function check_emailing_status_loader()
{
	var data;
	data = staff_emailing_obj.responseText
	if(staff_emailing_obj.readyState == 4)
	{
		document.getElementById("mass_email_option").innerHTML = data;
	}
	else
	{
		document.getElementById("mass_email_option").innerHTML="<img src='../images/ajax-loader.gif' width='20'>";
	}
}		
function check_emailing_status() 
{
	staff_emailing_obj.open('get', 'staff_check_emailing_status.php')
	staff_emailing_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	staff_emailing_obj.onreadystatechange = check_emailing_status_loader 
	staff_emailing_obj.send(1)
	document.getElementById("mass_email_option").style.visibility='visible'
}	
function replace_emailing_status() 
{
	staff_emailing_obj.open('get', 'staff_check_emailing_status.php?action=replace')
	staff_emailing_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	staff_emailing_obj.onreadystatechange = check_emailing_status_loader 
	staff_emailing_obj.send(1)
	document.getElementById("mass_email_option").style.visibility='visible'
}
function cancel_emailing_status() 
{
	staff_emailing_obj.open('get', 'staff_check_emailing_status.php?action=cancel')
	staff_emailing_obj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	staff_emailing_obj.onreadystatechange = check_emailing_status_loader 
	staff_emailing_obj.send(1)
	document.getElementById("mass_email_option").style.visibility='visible'
}
//ENDED: staff emailing


//START: open client profile
function lead(id) 
{
	previewPath = "../leads_information.php?id="+id;
	window.open(previewPath,'_blank','width=700,height=800,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}		
//ENDED: open client profile