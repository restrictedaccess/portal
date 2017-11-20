
function addPreloader(){
	var top = (jQuery(".rs-preloader").height()/2) - jQuery("#preloader-img").height();
	jQuery("#preloader-img").css("top", top+"px").css("position", "absolute");
	jQuery(".rs-preloader").show();
}

function syncToRecruiterHome(){
	jQuery.get("/portal/cronjobs/sync_recruiter_home_to_mongo.php?mode=update", function(){
		
	});
}

function loadRecruiterHome(){
	var date_from = jQuery("#date_from").val();
	var date_to = jQuery("#date_to").val();
	
	
	jQuery.get("/portal/recruiter/recruiter_home_list.php?date_from="+date_from+"&date_to="+date_to, function(response){
		response = jQuery.parseJSON(response);
		var total_tnc = 0;
		var total_unprocessed = 0;
		var total_prescreened = 0;
		var total_inactive = 0;
		var total_shortlisted = 0;
		var total_endorsed = 0;
		var total_categorized = 0;
		var total_candidate_status = 0;
		
		var total_asl_booked = 0;
		var total_custom_booked = 0;
		var total_interview = 0;
		jQuery.each(response.result, function(i,item){
			var candidate_status_all = item.unprocessed+item.prescreened+item.inactive+item.shortlisted+item.endorsed+item.categorized;
			var interview_status_all = item.asl_booked+item.custom_booked;
			
			
			jQuery(".tnc_"+item.admin_id).html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id="+item.admin_id+"&date_from="+date_from+"&date_to="+date_to+"&type=tnc' class='popup'>"+item.tnc+"</a>");
			jQuery(".unprocessed_"+item.admin_id).html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id="+item.admin_id+"&date_from="+date_from+"&date_to="+date_to+"&type=unprocessed' class='popup'>"+item.unprocessed+"</a>");
			jQuery(".prescreened_"+item.admin_id).html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id="+item.admin_id+"&date_from="+date_from+"&date_to="+date_to+"&type=prescreened' class='popup'>"+item.prescreened+"</a>");
			jQuery(".inactive_"+item.admin_id).html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id="+item.admin_id+"&date_from="+date_from+"&date_to="+date_to+"&type=inactive' class='popup'>"+item.inactive+"</a>");
			jQuery(".shortlisted_"+item.admin_id).html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id="+item.admin_id+"&date_from="+date_from+"&date_to="+date_to+"&type=shortlisted' class='popup'>"+item.shortlisted+"</a>");
			jQuery(".endorsed_"+item.admin_id).html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id="+item.admin_id+"&date_from="+date_from+"&date_to="+date_to+"&type=endorsed' class='popup'>"+item.endorsed+"</a>");
			jQuery(".categorized_"+item.admin_id).html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id="+item.admin_id+"&date_from="+date_from+"&date_to="+date_to+"&type=categorized' class='popup'>"+item.categorized+"</a>");
			jQuery(".candidate_status_total_"+item.admin_id).html(candidate_status_all);			
			
			jQuery(".interview_asl_"+item.admin_id).html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id="+item.admin_id+"&date_from="+date_from+"&date_to="+date_to+"&type=interview_asl' class='popup'>"+item.asl_booked+"</a>");			
			jQuery(".interview_custom_"+item.admin_id).html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id="+item.admin_id+"&date_from="+date_from+"&date_to="+date_to+"&type=interview_custom' class='popup'>"+item.custom_booked+"</a>");			
			jQuery(".interview_total_"+item.admin_id).html(interview_status_all);
			
			total_tnc += parseInt(item.tnc);
			total_unprocessed+=item.unprocessed;
			total_prescreened+=item.prescreened;
			total_inactive+=item.inactive;
			total_shortlisted+=item.shortlisted;
			total_endorsed+=item.endorsed;
			total_categorized+=item.categorized;
			total_candidate_status+=candidate_status_all;
			
			total_custom_booked+=item.custom_booked;
			total_asl_booked+=item.asl_booked;
			total_interview+=interview_status_all;
		});
		
		
		jQuery(".total_tnc").html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id=all&date_from="+date_from+"&date_to="+date_to+"&type=tnc' class='popup'>"+total_tnc+"</a>");
		jQuery(".total_unprocessed").html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id=all&date_from="+date_from+"&date_to="+date_to+"&type=unprocessed' class='popup'>"+total_unprocessed+"</a>");
		jQuery(".total_prescreened").html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id=all&date_from="+date_from+"&date_to="+date_to+"&type=prescreened' class='popup'>"+total_prescreened+"</a>");
		jQuery(".total_inactive").html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id=all&date_from="+date_from+"&date_to="+date_to+"&type=inactive' class='popup'>"+total_inactive+"</a>");
		jQuery(".total_shortlisted").html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id=all&date_from="+date_from+"&date_to="+date_to+"&type=shortlisted' class='popup'>"+total_shortlisted+"</a>");
		jQuery(".total_endorsed").html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id=all&date_from="+date_from+"&date_to="+date_to+"&type=endorsed' class='popup'>"+total_endorsed+"</a>");
		jQuery(".total_categorized").html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id=all&date_from="+date_from+"&date_to="+date_to+"&type=categorized' class='popup'>"+total_categorized+"</a>");
		jQuery(".total_candidate_status").html(total_candidate_status);
		
		jQuery(".interview_asl_total").html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id=all&date_from="+date_from+"&date_to="+date_to+"&type=interview_asl' class='popup'>"+total_asl_booked+"</a>");			
		jQuery(".interview_custom_total").html("<a href='/portal/recruiter/recruiter_home_details.php?admin_id=all&date_from="+date_from+"&date_to="+date_to+"&type=interview_custom' class='popup'>"+total_custom_booked+"</a>");			
		jQuery(".interview_total").html(total_interview);
		
	});
}

jQuery(document).ready(function(){
	
	jQuery.get("/portal/django_mongo_session_transfer_generate.php", function(response){
		response = jQuery.parseJSON(response);
		jQuery.get("/portal/v2/session-manager/session-transfer/", {session_hash:response.session_hash}, function(response){
			
		});
	});
	
	
	syncToRecruiterHome();
	var date_from = jQuery("#date_from").val();
	var date_to = jQuery("#date_to").val();
	
	jQuery("#date_from").datepicker();
	jQuery("#date_to").datepicker();
	jQuery("#date_from").datepicker("option", "dateFormat", "yy-mm-dd");
	jQuery("#date_to").datepicker("option", "dateFormat", "yy-mm-dd");	
	
	jQuery("#date_from").datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", date_from));
	jQuery("#date_to").datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", date_to));
	loadRecruiterHome();
	
	jQuery(".link").on("click", function(e){
		var href = jQuery(this).attr("href");
		window.location.href = href;
	});
	jQuery("#recruiter-home-filter").on("submit", function(){
		loadRecruiterHome();
		return false;
	});
	
	
});

jQuery(document).on("click", ".popup", function(e){
	popup_win(jQuery(this).attr("href"),900, 700);
	e.preventDefault();
})
