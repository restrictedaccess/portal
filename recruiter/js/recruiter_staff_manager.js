var APP_CALENDAR_directory_set  = ""
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
function search_key_type_check_function(check)
{
	document.getElementById('search_key').disabled = (check.checked);
	document.getElementById('search_key_type').disabled = (check.checked);
}	
function move(id, status) 
{
	switch(status)
	{
		case "Category":
			previewPath = "asl_categories.php?userid="+id;
			break;			
		case "Endorse to Client":
			previewPath = "../move_endorse_to_client.php?userid="+id;
			break;
		case "Profile":
			previewPath = "staff_information.php?&page_type=popup&userid="+id;
			break;			
	}	
	window.open(previewPath,'_blank','width=900,height=800,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
}

jQuery.noConflict();
jQuery(document).ready(function(){
	
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
	
	jQuery("#recruiter_export").click(function(e){
		jQuery.get("/portal/recruiter/check_priviledge_on_exporting_staff_list.php", function(data){
			data = jQuery.parseJSON(data);
			if (data.notallowed){
				alert("You are not allowed to export the query result.")
			}else{
				var data = jQuery("#appplicant_filter").serialize();
				location.href='/portal/recruiter/export_applicant_categories.php?'+data;
			}
		});
	});
	clearAvailability();
})
