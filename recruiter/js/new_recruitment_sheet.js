var CURRENT_PAGE = 1;
var hasRequest = false;
var rows = 100;
function addPreloader(){
	var top = (jQuery(".rs-preloader").height()/2) - jQuery("#preloader-img").height();
	jQuery("#preloader-img").css("top", top+"px").css("position", "absolute");
	jQuery(".rs-preloader").show();
}

function removePreloader(){
	jQuery(".rs-preloader").hide();
}

jQuery(document).ready(function(){
	jQuery("select[name=individual-filter-type]").change(function(){
		var selected = jQuery(this).val();
		if (selected == 1){
			$("#individual-filter").html("<input type='text' class='form-control' value='' name='filter-text' size='61' placeholder='Enter Job Title'/>");
		}else if (selected==2){
			var choices = ["Full-Time", "Part-Time"];
			var select = "<select name='filter-text' class='form-control'>"
			for(var i=0;i<choices.length;i++){
				select+=("<option value='"+choices[i]+"'>"+choices[i]+"</option>");
			}
			select+="</select>";
			$("#individual-filter").html(select);
		}else if (selected==3){
			$("#individual-filter").html("<input type='text' value='' name='date-from' class='form-control' size='28' placeholder='From' id='date-from' style='margin-right:10px;'/><input type='text' class='form-control' value='' name='date-to' size='28' placeholder='To' id='date-to'/>");
			jQuery("#date-from").datepicker();
			jQuery("#date-to").datepicker();
			jQuery("#date-from").datepicker("option", "dateFormat", "yy-mm-dd");
			jQuery("#date-to").datepicker("option", "dateFormat", "yy-mm-dd");	
		}else if (selected==4){
			var currency = ["AUD", "USD", "GBP"];
			var select = "<select id='currency_type' name='currency_type' class='form-control'>";
			for(var i=0;i<currency.length;i++){
				select+=("<option value='"+currency[i]+"'>"+currency[i]+"</option>");
			}
			select+="</select>";	
			var rate_type = ["Hourly", "Monthly"];
			var select2 = "<select id='rate_type' name='rate_type' class='form-control'>";
			for(var i=0;i<rate_type.length;i++){
				select2+=("<option value='"+rate_type[i]+"'>"+rate_type[i]+"</option>");
			}
			select2+="</select>";
			var level = ["Entry", "Middle", "Expert"];
			var select3 = "<select id='level' name='level' class='form-control'>";
			for(var i=0;i<level.length;i++){
				select3+=("<option value='"+level[i]+"'>"+level[i]+"</option>");
			}
			select3+="</select>";
			var choices = ["Full-Time", "Part-Time"];
			var select4 = "<select id='work_type' name='work_type' class='form-control'>"
			for(var i=0;i<choices.length;i++){
				select4+=("<option value='"+choices[i]+"'>"+choices[i]+"</option>");
			}
			select4+="</select>";
			$("#individual-filter").html("<input type='text' class='form-control' value='' name='budget-from' size='8' placeholder='From' id='budget-from'/><input class='form-control' type='text' value='' name='budget-to' size='8' placeholder='To' id='budget-to'/>"+select+select4+select2+select3);
		}else if (selected==5){
			jQuery.get("/portal/recruiter/load_timezone.php", function(data){
				data = jQuery.parseJSON(data);
				var select = "<select id='timezone' name='timezone' class='form-control'>";
				for (var i=0;i<data.length;i++){
					var item = data[i];
					if (item.timezone==null){
						continue;
					}
					select+=("<option value='"+item.timezone+"'>"+item.timezone+"</option>");
				}
				select+="</select>";
				$("#individual-filter").html(select);
			});
		}else if (selected==6){
			var periods = ["1-Week", "2-Weeks", "3-Weeks", "1-Month", "2-Months", "3-Months", "Over-4-Months"];
			var select = "<select id='period' name='period' class='form-control'>";
			for(var i=0;i<periods.length;i++){
				select+=("<option value='"+periods[i]+"'>"+periods[i]+"</option>");
			}
			select+="</select>";	
			$("#individual-filter").html(select+"&nbsp;From: <input  class='form-control' type='text' name='from' placeholder='From' id='period-from'/>");
			jQuery("#period-from").datepicker();
			jQuery("#period-from").datepicker("option", "dateFormat", "yy-mm-dd");
		}else if (selected==7){
			$("#individual-filter").html("<input  class='form-control' type='text' value='' name='age-from' size='10' placeholder='From' id='age-from'/><input  class='form-control' type='text' value='' name='age-to' size='10' placeholder='To' id='age-to'/>");
		}else if (selected==0){
			$("#individual-filter").html("");
		}else if (selected==8){
			$("#individual-filter").html("<input class='form-control' type='text' value='' name='date-from' size='28' placeholder='From' id='date-from'/><input  class='form-control' type='text' value='' name='date-to' size='28' placeholder='To' id='date-to'/>");
			jQuery("#date-from").datepicker();
			jQuery("#date-to").datepicker();
			jQuery("#date-from").datepicker("option", "dateFormat", "yy-mm-dd");
			jQuery("#date-to").datepicker("option", "dateFormat", "yy-mm-dd");	
			jQuery("#date-from").datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", jQuery("#before_date").val()));
			jQuery("#date-to").datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", jQuery("#today_date").val()));
			
			
		}else if (selected==9){
			$("#individual-filter").html("<input type='text' value='' name='date-from' class='form-control' size='28' placeholder='From' id='date-from' style='margin-right:10px;'/>&nbsp;<input type='text' class='form-control' value='' name='date-to' size='28' placeholder='To' id='date-to'/>");
			jQuery("#date-from").datepicker();
			jQuery("#date-to").datepicker();
			jQuery("#date-from").datepicker("option", "dateFormat", "yy-mm-dd");
			jQuery("#date-to").datepicker("option", "dateFormat", "yy-mm-dd");	
		}
	});
	
	jQuery("#order_status").val("OPEN");
	jQuery("#recruitment-sheet-filter").on("submit", function(){
		var url = "/portal/recruiter/new_job_order_mongo_load.php?";
		var filter_type = $("#individual-filter-type").val();
		
		
		var filter_text = "";
		var validation = true;
		
		if (filter_type==1){
			if ($("input[name=filter-text]").val()==""){
				validation = false;
			}
		}else if (filter_type==2){
			if ($("select[name=filter-text]").val()==""){
				validation = false;
			}
		}else if (filter_type==3){
			if ($("#date-from").val()==""||$("#date-to").val()==""){
				validation = false;
			}
		}else if (filter_type==4){
			/*
			if ($("#budget-from").val()==""|| $("#budget-to").val()==""||$("#level").val()==""||$("#currency_type").val()||$("#rate_type").val()||$("#work_type").val()){
				validation = false;
			}
			*/	
		}else if (filter_type==5){
			if ($("#timezone").val()==""){
				validation = false;
			}
		}else if (filter_type==6){
			if ($("#period-from").val()==""||$("#period").val()==""){
				validation = false;
			}
		}else if (filter_type==7){
			if (jQuery("#age-from").val()==""||jQuery("#age-to").val()==""){
				validation = false;
			}			
		}else if (filter_type==9){
			if ($("#date-from").val()==""||$("#date-to").val()==""){
				validation = false;
			}		
		}
		if (!validation){
			filter_type = 0;
		}
		url+="filter_type="+filter_type;
		filter_text = "";
		if (filter_type==1){
			filter_text = $("input[name=filter-text]").val();
			url+=("&filter_text="+filter_text);
		}else if (filter_type==2){
			filter_text = $("select[name=filter-text]").val();
			url+=("&filter_text="+filter_text);
		}else if (filter_type==3){
			var from = $("#date-from").val();
			var to = $("#date-to").val();
			url+=("&date_from="+from+"&date_to="+to);
		}else if (filter_type==4){
			var from = $("#budget-from").val();
			var to = $("#budget-to").val();
			var level = $("#level").val();
			var currency = $("#currency_type").val();
			var rate_type = $("#rate_type").val();
			var work_type = $("#work_type").val();
			url+=("&budget_from="+from+"&budget_to="+to+"&level="+level+"&currency="+currency+"&rate_type="+rate_type+"&work_type="+work_type);
		}else if (filter_type==5){
			filter_text = $("#timezone").val();
			url+=("&filter_text="+filter_text);
		}else if (filter_type==6){
			var periodFrom = $("#period-from").val();
			var period = $("#period").val();
			url+=("&period_from="+periodFrom+"&period="+period);
		}else if (filter_type==7){
			var age_from = jQuery("#age-from").val();
			var age_to = jQuery("#age-to").val();
			url+=("&age_from="+age_from+"&age_to="+age_to);			
		}else if (filter_type==8){
			var from = $("#date-from").val();
			var to = $("#date-to").val();
			url+=("&date_from="+from+"&date_to="+to);
		}else if (filter_type==9){
			var from = $("#date-from").val();
			var to = $("#date-to").val();
			url+=("&date_from="+from+"&date_to="+to);
		}
		var keyword = $( "#keyword" ).val();
		var recruiter = $("#recruiters").val();
		var hiringcoordinator = $("#hiring-coordinators").val();
		var inhouse_staff = $("#inhouse-staff").val();
		url+=("&service_type="+jQuery("#service_type").val());
		url+=("&order_status="+jQuery("#order_status").val());
		url+=("&keyword="+keyword);
		url+=("&recruiters="+recruiter);
		url+=("&hiring_coordinator="+hiringcoordinator);
		url+=("&inhouse_staff="+inhouse_staff);
		url+=("&page="+CURRENT_PAGE);
		if (!hasRequest){
			hasRequest = true;
			addPreloader();
			jQuery.getJSON(url, function(response){
				var src = jQuery("#job_order_row").html();
				var template = Handlebars.compile(src);
				var output = "";
				jQuery.each(response.rows, function(i, job_order){
					job_order.i = i+1;
					if (job_order.hc_fname=="zzz"){
						job_order.hc_fname = "";
					}
					if (job_order.hc_lname=="zzz"){
						job_order.hc_lname = "";
					}
					
					output += template(job_order)
				});
				hasRequest = false;
				jQuery("#recruitment_sheet_body tbody").html(output);
				
				var pagination = "";
				
				pagination += '<li class="disabled prev"><span>&laquo;</span></li>'
				for (var i=1;i<=response.total;i++){
					pagination += '<li class="page_item"><a href="#" data-page="'+i+'">'+i+'</a></li>';	
				}
  				pagination += '<li class="disabled next"><span>&raquo;</span></li>'
				jQuery(".pagination").html(pagination);
				
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
				removePreloader();
			});			
		}

		return false;
	}).trigger("submit");
	
	jQuery.get("/portal/cronjobs/sync_asl_no_job_category_to_mongo.php", function(){})
	jQuery.get("/portal/cronjobs/sync_asl_via_job_category_to_mongo.php", function(){})
	jQuery.get("/portal/cronjobs/sync_basic_custom_to_mongo.php", function(){})
	jQuery.get("/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php", function(){})
	jQuery.get("/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php", function(){})
	jQuery.get("/portal/cronjobs/sync_merge_custom_to_mongo.php", function(){})
});

jQuery(document).on("click", ".need_more_candidate", function(e){
	var tracking_code = jQuery(this).attr("data-tracking_code");
	jQuery.post("/portal/recruiter/update_hiring_status_job_order.php", {tracking_code:tracking_code, status:"NEED_MORE_CANDIDATE"}, function(response){
		response = jQuery.parseJSON(response);
		if (response.success){
			jQuery("#order_status").val("OPEN");
			alert("Job Order Status has been updated");
			jQuery("#recruitment-sheet-filter").trigger("submit");
		}
	});
})
jQuery(document).on("click", ".skill_test", function(e){
	var tracking_code = jQuery(this).attr("data-tracking_code");
	jQuery.post("/portal/recruiter/update_hiring_status_job_order.php", {tracking_code:tracking_code, status:"SKILL_TEST"}, function(response){
		response = jQuery.parseJSON(response);
		if (response.success){
			jQuery("#order_status").val("OPEN");
			alert("Job Order Status has been updated");
			jQuery("#recruitment-sheet-filter").trigger("submit");
		}
	});
})
jQuery(document).on("click", ".sc_reviewing_order", function(e){
	var tracking_code = jQuery(this).attr("data-tracking_code");
	jQuery.post("/portal/recruiter/update_hiring_status_job_order.php", {tracking_code:tracking_code, status:"SC_REVIEWING_ORDER"}, function(response){
		response = jQuery.parseJSON(response);
		if (response.success){
			jQuery("#order_status").val("OPEN");
			alert("Job Order Status has been updated");
			jQuery("#recruitment-sheet-filter").trigger("submit");
		}
	});
})
jQuery(document).on("click", ".comment_box", function(e){
	var href = jQuery(this).attr("href");
	jQuery.get(href, function(response){
		jQuery("#view_history_popup .modal-body").html(response);
		jQuery("#view_history_popup").modal()
	});
	e.preventDefault();
})

jQuery(document).on("submit", "#add_new_comment", function(e){
	var data = jQuery(this).serialize();
	jQuery.post("/portal/recruiter/add_new_jo_comments.php", data, function(response){
		response = jQuery.parseJSON(response);
		if (response.success){
			var comment = response.comment;
			var template = '<li class="list-group-item">';
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
});

jQuery(document).on("click", ".next", function(e){
	if (!hasRequest&&!jQuery(this).hasClass("disabled")){
		CURRENT_PAGE += 1;
		jQuery("#recruitment-sheet-filter").trigger("submit");
	}
	e.preventDefault();
});
jQuery(document).on("click", ".prev", function(e){
	if (!hasRequest&&!jQuery(this).hasClass("disabled")){
		CURRENT_PAGE -= 1;
		jQuery("#recruitment-sheet-filter").trigger("submit");
	}
	e.preventDefault();
});
jQuery(document).on("click", ".page_item > a", function(e){
	if (!hasRequest){
		CURRENT_PAGE = parseInt(jQuery(this).attr("data-page"));
		jQuery("#recruitment-sheet-filter").trigger("submit");		
	}
	e.preventDefault();
});
