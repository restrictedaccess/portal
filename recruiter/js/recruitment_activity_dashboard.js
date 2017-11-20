function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(typeof haystack[i] == 'object') {
            if(arrayCompare(haystack[i], needle)) return true;
        } else {
            if(haystack[i] == needle) return true;
        }
    }
    return false;
}

var rec_support = [236, 239, 227, 228, 225, 167, 242, 226,169];


jQuery(document).ready(function(){
	var currentTab = "order_status";
	
	 
	 
	jQuery("#filter-form").submit(function(){
		filterGrid();
		return false;
	});
	function createOverlay(){
		if (jQuery("#rs-preloader").length==0){
			var orderStatus = jQuery(".tab-content");
			var overlay = "<div id='rs-preloader' class='rs-preloader overlay' style='z-index:1'><img src='../images/ajax-loader.gif'/></div>";
			jQuery(overlay).appendTo("body").css("height", orderStatus.height()+"px").css("width", orderStatus.width()+"px").css({opacity:0.5}).css("top", "450px");	
		}
	}
	function removeOverlay(){
		jQuery("#rs-preloader").remove();
	}
	
	function createLink(date_from, date_to, item, type, all){
		var link = "";
		if (all!=undefined){
			link = "/portal/recruiter/list_activity.php?recruiter_id="+all+"&type="+type;
		}else{
			link = "/portal/recruiter/list_activity.php?recruiter_id="+item.admin_id+"&type="+type;
		}
		if (jQuery.trim(date_from)!=""&&jQuery.trim(date_to)!=""){
			link+=("&date_from="+date_from);
			link+=("&date_to="+date_to);
		}
		return link;
	}
	
	function filterGrid(){
		var date_from = jQuery("#date-from").val();
		var date_to = jQuery("#date-to").val();
		var url = "/portal/recruiter/load_activity_counts.php?send=1";
		
		if (jQuery.trim(date_from)!=""&&jQuery.trim(date_to)!=""){
			url+=("&date_from="+date_from);
			url+=("&date_to="+date_to);
		}
		createOverlay();
		
		jQuery.get(url, function(data){
			data = jQuery.parseJSON(data);
			
			var total_number_of_candidates = 0;
			var total_email = 0;
			var total_initial_call = 0;
			var total_evaluated = 0;
			var total_face_to_face = 0;
			var total_opened_resume = 0;
			var total_created_resume = 0;
			var total_sms_sent = 0;
			var total_evaluation_comments = 0;
			var total_total = 0;
			
			var total_rec_number_of_candidates = 0;
			var total_rec_email = 0;
			var total_rec_initial_call = 0;
			var total_rec_evaluated = 0;
			var total_rec_face_to_face = 0;
			var total_rec_opened_resume = 0;
			var total_rec_created_resume = 0;
			var total_rec_sms_sent = 0;
			var total_rec_evaluation_comments = 0;
			var total_rec_total = 0;
			
			var link = "";
			jQuery.each(data, function(i, item){
				
				if (inArray(parseInt(item.admin_id), rec_support)){
					total_rec_number_of_candidates+=parseInt(item.number_of_candidate)
					total_rec_email+=parseInt(item.email)
					total_rec_initial_call+=parseInt(item.initial_call)
					total_rec_evaluated+=parseInt(item.evaluated)
					total_rec_face_to_face += parseInt(item.face_to_face)
					total_rec_opened_resume+=parseInt(item.opened_resume)
					total_rec_created_resume+=parseInt(item.created_resume)
					total_rec_sms_sent += parseInt(item.sms_sent);
					total_rec_evaluation_comments += parseInt(item.evaluation_comments);
					total_rec_total += parseInt(item.total_activity);
				}else{
					total_number_of_candidates+=parseInt(item.number_of_candidate)
					total_email+=parseInt(item.email)
					total_initial_call+=parseInt(item.initial_call)
					total_evaluated+=parseInt(item.evaluated)
					total_face_to_face += parseInt(item.face_to_face)
					total_opened_resume+=parseInt(item.opened_resume)
					total_created_resume+=parseInt(item.created_resume)
					total_sms_sent += parseInt(item.sms_sent);
					total_evaluation_comments += parseInt(item.evaluation_comments);
					total_total += parseInt(item.total_activity);					
				}
				
				link = createLink(date_from, date_to, item, "assigned");
				jQuery("#number_of_candidates_"+item.admin_id).html("<a href='"+link+"' class='launcher'>"+item.number_of_candidate+"</a>");
				
				link = createLink(date_from, date_to, item, "email");
				jQuery("#email_sent_"+item.admin_id).html("<a href='"+link+"' class='launcher'>"+item.email+"</a>");
				
				link = createLink(date_from, date_to, item, "initial_call");
				jQuery("#initial_call_"+item.admin_id).html("<a href='"+link+"' class='launcher'>"+item.initial_call+"</a>");
				
				link = createLink(date_from, date_to, item, "evaluated");
				jQuery("#evaluated_"+item.admin_id).html("<a href='"+link+"' class='launcher'>"+item.evaluated+"</a>");
				
				link = createLink(date_from, date_to, item, "face_to_face");
				jQuery("#face_to_face_interview_"+item.admin_id).html("<a href='"+link+"' class='launcher'>"+item.face_to_face+"</a>");
				
				link = createLink(date_from, date_to, item, "opened_resume");
				jQuery("#number_of_opened_resume_"+item.admin_id).html("<a href='"+link+"' class='launcher'>"+item.opened_resume+"</a>");
				
				
				link = createLink(date_from, date_to, item, "created_resume");
				jQuery("#number_of_resume_added_to_the_system_"+item.admin_id).html("<a href='"+link+"' class='launcher'>"+item.created_resume+"</a>");

				link = createLink(date_from, date_to, item, "sms_sent");
				jQuery("#sms_sent_"+item.admin_id).html("<a href='"+link+"' class='launcher'>"+item.sms_sent+"</a>");
				
				link = createLink(date_from, date_to, item, "evaluation_comments");
				jQuery("#evaluation_comments_"+item.admin_id).html("<a href='"+link+"' class='launcher'>"+item.evaluation_comments+"</a>");
				jQuery("#total_"+item.admin_id).html(item.total_activity);
				
			});
			
			
			//add links for totals of recruiters
			link = createLink(date_from, date_to, null, "assigned", "recruiter");
			jQuery("#total_number_of_candidates").html("<a href='"+link+"' class='launcher'>"+total_number_of_candidates+"</a>");
			link = createLink(date_from, date_to, null, "email", "recruiter");
			jQuery("#total_email_sent").html("<a href='"+link+"' class='launcher'>"+total_email+"</a>");
			link = createLink(date_from, date_to, null, "initial_call", "recruiter");
			jQuery("#total_initial_call").html("<a href='"+link+"' class='launcher'>"+total_initial_call+"</a>");
			link = createLink(date_from, date_to, null, "evaluated", "recruiter");
			jQuery("#total_evaluated").html("<a href='"+link+"' class='launcher'>"+total_evaluated+"</a>");
			link = createLink(date_from, date_to, null, "face_to_face", "recruiter");
			jQuery("#total_face_to_face_interview").html("<a href='"+link+"' class='launcher'>"+total_face_to_face+"</a>");
			link = createLink(date_from, date_to, null, "opened_resume", "recruiter");
			jQuery("#total_number_of_opened_resume").html("<a href='"+link+"' class='launcher'>"+total_opened_resume+"</a>");
			link = createLink(date_from, date_to, null, "created_resume", "recruiter");
			jQuery("#total_number_of_resume_added_to_the_system").html("<a href='"+link+"' class='launcher'>"+total_created_resume+"</a>");
			link = createLink(date_from, date_to, null, "sms_sent", "recruiter");
			jQuery("#total_sms_sent").html("<a href='"+link+"' class='launcher'>"+total_sms_sent+"</a>");
			link = createLink(date_from, date_to, null, "evaluation_comments", "recruiter");
			jQuery("#total_evaluation_comments").html("<a href='"+link+"' class='launcher'>"+total_evaluation_comments+"</a>");
			
			//add links for totals of rec support
			link = createLink(date_from, date_to, null, "assigned", "rec_support");
			jQuery("#total_rec_number_of_candidates").html("<a href='"+link+"' class='launcher'>"+total_rec_number_of_candidates+"</a>");
			link = createLink(date_from, date_to, null, "email", "rec_support");
			jQuery("#total_rec_email_sent").html("<a href='"+link+"' class='launcher'>"+total_rec_email+"</a>");
			link = createLink(date_from, date_to, null, "initial_call", "rec_support");
			jQuery("#total_rec_initial_call").html("<a href='"+link+"' class='launcher'>"+total_rec_initial_call+"</a>");
			link = createLink(date_from, date_to, null, "evaluated", "rec_support");
			jQuery("#total_rec_evaluated").html("<a href='"+link+"' class='launcher'>"+total_rec_evaluated+"</a>");
			link = createLink(date_from, date_to, null, "face_to_face", "rec_support");
			jQuery("#total_rec_face_to_face_interview").html("<a href='"+link+"' class='launcher'>"+total_rec_face_to_face+"</a>");
			link = createLink(date_from, date_to, null, "opened_resume", "rec_support");
			jQuery("#total_rec_number_of_opened_resume").html("<a href='"+link+"' class='launcher'>"+total_rec_opened_resume+"</a>");
			link = createLink(date_from, date_to, null, "created_resume", "rec_support");
			jQuery("#total_rec_number_of_resume_added_to_the_system").html("<a href='"+link+"' class='launcher'>"+total_rec_created_resume+"</a>");
			link = createLink(date_from, date_to, null, "sms_sent", "rec_support");
			jQuery("#total_rec_sms_sent").html("<a href='"+link+"' class='launcher'>"+total_rec_sms_sent+"</a>");
			link = createLink(date_from, date_to, null, "evaluation_comments", "rec_support");
			jQuery("#total_rec_evaluation_comments").html("<a href='"+link+"' class='launcher'>"+total_rec_evaluation_comments+"</a>");
			
			
			
			jQuery("#total_total").html(total_total);
			jQuery("#total_rec_total").html(total_rec_total);
			
			
			removeOverlay();
		});
		
	}
	
	jQuery(".launcher").live("click", function(e){
		var href = jQuery(this).attr("href")
		window.open(href,'_blank','width=700,height=600,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		e.preventDefault()
	})
	jQuery("#sidepopup .close").live("click", function(){
		jQuery(this).parent().parent().fadeOut(200);
	})
	
	
	filterGrid();
	
	var dateFrom = jQuery("#date-from").val();
	var dateTo = jQuery("#date-to").val();
	
	jQuery("#date-from").datepicker();
	jQuery("#date-to").datepicker();
	jQuery("#date-from").datepicker("option", "dateFormat", "yy-mm-dd").datepicker("setDate", dateFrom);
	jQuery("#date-to").datepicker("option", "dateFormat", "yy-mm-dd").datepicker("setDate", dateTo);
	
});
