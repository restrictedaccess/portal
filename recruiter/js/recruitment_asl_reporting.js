function renderResponse(response){
	var output = "";
	
	jQuery.each(response, function(i, item){
		jQuery.each(item.job_sub_categories, function(j, subcategory){
			output+="<tr>";
				output += "<td>"+subcategory.sub_category_name+"</td>";
				output += "<td><a href='/portal/recruiter/load_job_orders_categorized.php?sub_category_id="+subcategory.sub_category_id+"&date_from="+jQuery("#date_ordered_from").val()+"&date_to="+jQuery("#date_ordered_to").val()+"' class='popup'>"+subcategory.total_orders+"</td>";
				output += "<td>"+subcategory.average+"</td>";
				output += "<td>"+subcategory.average_handling_time+"</td>";
				output += "<td>"+subcategory.pool+"</td>";
				
				var total = 0;
				jQuery.each(subcategory.recruiters, function(k, recruiter){
					total+=parseInt(recruiter.total_categorized);
				});
				output += "<td><a href='/portal/recruiter/load_categorized_details.php?sub_category_id="+subcategory.sub_category_id+"&recruiter_id=ALL&date_from="+jQuery("#date_ordered_from").val()+"&date_to="+jQuery("#date_ordered_to").val()+"' class='popup'>"+total+"</a></td>";
				jQuery.each(subcategory.recruiters, function(k, recruiter){
					output += "<td><a href='/portal/recruiter/load_categorized_details.php?sub_category_id="+subcategory.sub_category_id+"&recruiter_id="+recruiter.admin_id+"&date_from="+jQuery("#date_ordered_from").val()+"&date_to="+jQuery("#date_ordered_to").val()+"' class='popup'>"+recruiter.total_categorized+"</a></td>";
				});
				
			output+="</tr>";
		});
	});
	
	jQuery("#recruitment_asl_report_list tbody").html(output);
	hasRequest = false;
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

var hasRequest = false;

jQuery(document).ready(function(){
	
	jQuery("#date_ordered_from").datepicker();
	jQuery("#date_ordered_to").datepicker();
	jQuery("#date_ordered_from").datepicker("option", "dateFormat", "yy-mm-dd");
	jQuery("#date_ordered_to").datepicker("option", "dateFormat", "yy-mm-dd");	
	jQuery("#date_ordered_from").datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", jQuery("#before_date").val()));
	jQuery("#date_ordered_to").datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", jQuery("#today_date").val()));
		
		
	var data = jQuery("#filter-form").serialize();
	if (!hasRequest){
		addPreloader();
		hasRequest = true;	
		jQuery.get("/portal/recruiter/load_asl_report.php?"+data, function(response){
			response = jQuery.parseJSON(response);
			renderResponse(response);
		})
	}
		
	jQuery("#filter-form").submit(function(){
		if (!hasRequest){
			addPreloader();
			hasRequest = true;
			var data = jQuery(this).serialize();
			jQuery.get("/portal/recruiter/load_asl_report.php?"+data, function(response){
				response = jQuery.parseJSON(response);
				renderResponse(response);
			});
			
		}
		
		return false;
	})
	
	jQuery(".popup").live("click", function(e){
		var href = jQuery(this).attr("href")
		window.open(href,'_blank','width=700,height=600,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		e.preventDefault()
	})
	
});
