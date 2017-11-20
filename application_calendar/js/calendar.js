//skype autoresponder
function populate_autoresponder() 
{
	var m = "";
	var selected = jQuery("#start_month_id").val();
	
	//selected = parseInt(selected);
	switch(selected)
	{
		case "1":
			m = "January";
			break;
		case "2":
			m = "February";
			break;
		case "3":
			m = "March";
			break;
		case "4":
			m = "April";
			break;
		case "5":
			m = "May";
			break;
		case "6":
			m = "June";
			break;
		case "7":
			m = "July";
			break;
		case "8":
			m = "August";
			break;
		case "9":
			m = "September";
			break;
		case "10":
			m = "October";
			break;
		case "11":
			m = "November";
			break;
		case "12":
			m = "December";
			break;
	}
	switch(document.getElementById('start_month_id').value)
	{
		case "01":
			m = "January";
			break;
		case "02":
			m = "February";
			break;
		case "03":
			m = "March";
			break;
		case "04":
			m = "April";
			break;
		case "05":
			m = "May";
			break;
		case "06":
			m = "June";
			break;
		case "07":
			m = "July";
			break;
		case "08":
			m = "August";
			break;
		case "09":
			m = "September";
			break;
	}			
	var date_start = m+" "+document.getElementById('start_day_id').value+", "+document.getElementById('start_year_id').value;
	var s_hour = document.getElementById('start_hour_id').value;
	var start_minute = document.getElementById('start_minute_id').value;
	var time_zone = document.getElementById('time_zone_id').value;

	var facilitator_temp_name = "I";
	if(admin_name_loading_counter > 1)
	{
		facilitator_temp_name = from_name;
	}		
	
	switch(time_zone)
	{
		case "PST8PDT":
			time_zone = "America/San Francisco";
			break;
		case "NZ":
			time_zone = "New Zealand/Wellington";
			break;
		case "NZ-CHAT":
			time_zone = "New Zealand/Chatham_Islands";
			break;
	}
	var clt_msg = "";
	var start_hour_type = 'AM';
	if(s_hour > 12)
	{
		start_hour_type = 'PM'; 
		s_hour = s_hour - 12;
	}
	if(start_minute == 0)
	{
		start_minute = "0"+start_minute;
	}


	var type = jQuery.trim(jQuery('#type_id').val());
	var fullTime = date_start+" "+s_hour+":"+start_minute+" "+start_hour_type+" ";
	
	var url = "/portal/application_calendar/load_template.php?";
	url+=("responder_type="+type);
	url+=("&full_time="+fullTime);
	url+=("&timezone="+time_zone);
	url+=("&client_name="+client_full_name);
	url+=("&facilitator="+facilitator_temp_name);
	url+=("&creator_name="+creator_name);
	url+=("&applicant_name="+applicant_full_name);
	url+=("&subcategory="+sub_category_name);
	
	if((document.getElementById('type_id').value == "skype")||(document.getElementById('type_id').value == "rschat")){
		jQuery.get(url, function(data){
			data = jQuery.parseJSON(data);
			if (jQuery(".no-require-check:checked").length==0){
				jQuery('#description_id').val(data.output1);	
			}
			jQuery('#description2_id').val(data.output2);
			
		});
		
	}else{
		document.getElementById('description_id').value = "";
		document.getElementById('description2_id').value = "";
	}
}
//ended - skype autoresponder

jQuery(document).ready(function(){
	
	jQuery(".file-upload-delete").live("click", function(e){
		jQuery(this).parent().remove();
		e.preventDefault();
	});
	
	jQuery(".addMore").live("click", function(e){
		var id = jQuery(this).attr("id");
		if (id=="addMoreFileCandidate"){
			jQuery("<div class='container-file'><label>Attach File</label> <input type='file' name='file_candidate[]' class='candidate-file'/><a href='#' class='file-upload-delete'>[x]</a><br/></div>").appendTo(jQuery("#file_candidates_container"));
		}else{
			jQuery("<div class='container-file'><label>Attach File</label> <input type='file' name='file_client[]' class='client-file'/><a href='#' class='file-upload-delete'>[x]</a><br/></div>").appendTo(jQuery("#file_client_container"));
		}
		e.preventDefault();
	})
	
	jQuery("#new-appointment").live("submit", function(e){
		if (jQuery("#time_zone_id").val()==""){
			jQuery("#time_zone_id").val("Asia/Manila");
		}
		return validate(this);
	});
	var client_id = "";
	var client_name = "";
	jQuery("#initial, #contract_signing, #new_hire, #meeting").click(function(){
		var oldValue = jQuery(this).is(":checked");
		jQuery(".no-require-check").removeAttr("checked");
		if (oldValue){
			jQuery(this).attr("checked", "checked");
		}
		if (jQuery(this).is(":checked")){
			client_id = jQuery("#client_id").val();
			client_name = jQuery("#client_id_display").val();
			jQuery("#client_id").val("");
			jQuery("#client_id_display").attr("disabled", "disabled");	
			jQuery("#description_id").val("").attr("disabled", "disabled");
			jQuery(".candidate-file").attr("disabled", "disabled");
			jQuery("#addMoreFileClient").attr("disabled", "disabled");
			jQuery("#cc_client").attr("disabled", "disabled");
		}else{
			if (jQuery(".no-require-check:checked").length==0){
				jQuery("#client_id").val(client_id);
				jQuery("#client_id_display").val("").removeAttr("disabled").val(client_name);
				jQuery("#description_id").val("").removeAttr("disabled");	
				jQuery(".candidate-file").removeAttr("disabled", "disabled");
				jQuery("#addMoreFileClient").removeAttr("disabled", "disabled");
				jQuery("#cc_client").removeAttr("disabled");
			}
		}

	});
});
