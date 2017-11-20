var credentials = null;
var categories = [];


jQuery(document).ready(function(){
	var recruiters = [];
	var hiringCoordinators = [];
	var grid = null;
	
	var displayStatus = "Displayed";
	var loaded;

	jQuery("#view-history").click(function(e){
		popup_win("/portal/recruiter/job_order_history.php", 800, 600);
		e.preventDefault();
	});
	
	jQuery("#filter-form").show();
	jQuery("select[name=individual-filter-type]").change(function(){
		var selected = jQuery(this).val();
		if (selected == 1){
			$("#individual-filter").html("<input type='text' value='' name='filter-text' size='61' placeholder='Enter Job Title'/>");
		}else if (selected==2){
			var choices = ["Full-Time", "Part-Time"];
			var select = "<select name='filter-text'>"
			for(var i=0;i<choices.length;i++){
				select+=("<option value='"+choices[i]+"'>"+choices[i]+"</option>");
			}
			select+="</select>";
			$("#individual-filter").html(select);
		}else if (selected==3){
			$("#individual-filter").html("<input type='text' value='' name='date-from' size='28' placeholder='From' id='date-from'/><input type='text' value='' name='date-to' size='28' placeholder='To' id='date-to'/>");
			jQuery("#date-from").datepicker();
			jQuery("#date-to").datepicker();
			jQuery("#date-from").datepicker("option", "dateFormat", "yy-mm-dd");
			jQuery("#date-to").datepicker("option", "dateFormat", "yy-mm-dd");	
		}else if (selected==4){
			var currency = ["AUD", "USD", "GBP"];
			var select = "<select id='currency_type' name='currency_type'>";
			for(var i=0;i<currency.length;i++){
				select+=("<option value='"+currency[i]+"'>"+currency[i]+"</option>");
			}
			select+="</select>";	
			var rate_type = ["Hourly", "Monthly"];
			var select2 = "<select id='rate_type' name='rate_type'>";
			for(var i=0;i<rate_type.length;i++){
				select2+=("<option value='"+rate_type[i]+"'>"+rate_type[i]+"</option>");
			}
			select2+="</select>";
			var level = ["Entry", "Middle", "Expert"];
			var select3 = "<select id='level' name='level'>";
			for(var i=0;i<level.length;i++){
				select3+=("<option value='"+level[i]+"'>"+level[i]+"</option>");
			}
			select3+="</select>";
			var choices = ["Full-Time", "Part-Time"];
			var select4 = "<select id='work_type' name='work_type'>"
			for(var i=0;i<choices.length;i++){
				select4+=("<option value='"+choices[i]+"'>"+choices[i]+"</option>");
			}
			select4+="</select>";
			$("#individual-filter").html("<input type='text' value='' name='budget-from' size='8' placeholder='From' id='budget-from'/><input type='text' value='' name='budget-to' size='8' placeholder='To' id='budget-to'/>"+select+select4+select2+select3);
		}else if (selected==5){
			jQuery.get("/portal/recruiter/load_timezone.php", function(data){
				data = jQuery.parseJSON(data);
				var select = "<select id='timezone' name='timezone'>";
				for (var i=0;i<data.length;i++){
					var item = data[i];
					select+=("<option value='"+item.timezone+"'>"+item.timezone+"</option>");
				}
				select+="</select>";
				$("#individual-filter").html(select);
			});
		}else if (selected==6){
			var periods = ["1-Week", "2-Weeks", "3-Weeks", "1-Month", "2-Months", "3-Months", "Over-4-Months"];
			var select = "<select id='period' name='period'>";
			for(var i=0;i<periods.length;i++){
				select+=("<option value='"+periods[i]+"'>"+periods[i]+"</option>");
			}
			select+="</select>";	
			$("#individual-filter").html(select+"&nbsp;From: <input type='text' name='from' placeholder='From' id='period-from'/>");
			jQuery("#period-from").datepicker();
			jQuery("#period-from").datepicker("option", "dateFormat", "yy-mm-dd");
		}else if (selected==7){
			$("#individual-filter").html("<input type='text' value='' name='age-from' size='10' placeholder='From' id='age-from'/><input type='text' value='' name='age-to' size='10' placeholder='To' id='age-to'/>");
		}else if (selected==0){
			$("#individual-filter").html("");
		}else if (selected==8){
			$("#individual-filter").html("<input type='text' value='' name='date-from' size='28' placeholder='From' id='date-from'/><input type='text' value='' name='date-to' size='28' placeholder='To' id='date-to'/>");
			jQuery("#date-from").datepicker();
			jQuery("#date-to").datepicker();
			jQuery("#date-from").datepicker("option", "dateFormat", "yy-mm-dd");
			jQuery("#date-to").datepicker("option", "dateFormat", "yy-mm-dd");	
			jQuery("#date-from").datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", jQuery("#before_date").val()));
			jQuery("#date-to").datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", jQuery("#today_date").val()));
			
			
		}
	});
	
	
	function update_job_posting_hr(){
		//var request = jQuery(this).data("request");
		//if (!request){
			var answer = confirm('Do you want to update hiring coordinator?');
			if(answer){
			var me = jQuery(this);
			var id = jQuery(this).attr("id");
			id = id.split("-");
			var column = "hr";
			var hrInfo = null;
			var link_id = jQuery(this).attr("data-link-id");
			var link_type = jQuery(this).attr("data-link-type");
			var recruiter_id = jQuery(this).attr("data-recruiter-id");
			var tracking_code = jQuery(this).attr("data-tracking_code");
			var value = jQuery(this).val();
			me.attr("disabled");
			if (jQuery(this).hasClass("hc")){
				column = "hc";
				var leads_id = id[1];
				hrInfo = {
						leads_id:id[1],
						hr_id:$(this).val(),
						column:column,
						tracking_code:tracking_code
				}
				
			}else{
				hrInfo = {
						link_id:link_id,
						link_type:link_type,
						hr_id:jQuery(this).val(),
						column:column,
						recruiter_id:recruiter_id,
						tracking_code:tracking_code
				}
			}
			jQuery.post("/portal/recruiter/update_job_posting_hr.php", hrInfo, function(data){
				data = jQuery.parseJSON(data);
				me.next().addClass("hr_delete").addClass("ui-icon-close").attr("data-recruiter-id", value);
				me.removeAttr('disabled');
				if (me.hasClass("hc")){
					alert("Hiring Coordinator has been assigned");
					reloadFilterGrid();
				
				}
			});
		//}
		}else{
			jQuery(this).val(previous_hiring_coordinator);
		}
	}
	
	
	function dataLoaded(){
		if (loaded==undefined){
			moveTo.button("option", "disabled", false);	
			mergeTo.button("option", "disabled", false);	
			unmergeTo.button("option", "disabled", false);
			//enable all controls after loading process
			jQuery("#individual-filter-type").removeAttr("disabled");
			jQuery("#keyword").removeAttr("disabled");
			jQuery("#recruiters").removeAttr("disabled");
			jQuery("#hiring-coordinators").removeAttr("disabled");
			jQuery("#search").button("enable");
			jQuery("#refresh").button("enable");
			jQuery("#service-type").tabs("option", "disabled", []);
			jQuery("#open-close-cancel").tabs("option", "disabled", []);
	
			loaded = true;
		}
		jQuery(".hr_update").each(function(){
			jQuery(this).data("request", false);
		})
		
		jQuery(".notes-list").each(function(){
			if (jQuery(this).height()<240){
				jQuery(this).parent().children(".view_notes").remove();
			}
		});
	}
	jQuery(".view_notes").live("click", function(e){
		jQuery( "#dialog:ui-dialog" ).dialog( "destroy" );
		jQuery( "#details-dialog" ).dialog(
		{height: 430,
		width:840,
		modal: true,
		title:"View Notes and Comments"
			
		});
		
		
		var href=jQuery(this).attr("href");
		jQuery.get(href, function(data){
			jQuery("#details-dialog").html(data);
		})
		e.preventDefault();
	})
	
	jQuery(".search_shortlist").live("click", function(e){
		var serialize = jQuery(".search_shortlisted").serialize();
		
		jQuery.get("/portal/recruiter/job_order_shortlisted_candidates.php?"+serialize, function(response){
			response = jQuery.parseJSON(response);
			var result = "";
			jQuery.each(response.shortlisted_candidates, function(i, item){
				result+="<tr>"
				
				result+='<td style="border: 1px solid #333;">'+(i+1)+"</td>";
				result+='<td style="border: 1px solid #333;"><a href="/portal/recruiter/staff_information.php?userid='+item.userid+'" target="_blank">'+item.fullname+'</a></td>'
				result+='<td style="border: 1px solid #333;">'+item.admin_fname+' '+item.admin_lname+'</td>'
				result+='<td style="border: 1px solid #333;">'+item.date+'</td></tr>'
				
			});
			
			jQuery('#shortlist_table tbody').html(result);
		})
		e.preventDefault();
		e.stopPropagation();
	})
	
	jQuery(".hr_update").live("change",update_job_posting_hr);
	jQuery(".hr_update").live("click",get_previous_hiring_coordinator);
	jQuery(".hr_update").live("focus",get_previous_hiring_coordinator);
	
	var previous_hiring_coordinator;
	function get_previous_hiring_coordinator(e){
		previous_hiring_coordinator = jQuery(this).val();
	}
	
	jQuery("#refresh").button({
		icons:{
			primary:"ui-icon-refresh"
		}
	}).click(function(){
		if (grid!=null){
			jQuery("#recruiters").val("");
			jQuery("#individual-filter-type").val("0");
			jQuery("#hiring-coordinators").val("");
			jQuery("#keyword").val("");
			$openclosecancel.tabs( "option", "selected", 1);
			$servicetype.tabs( "option", "selected", 0);
			filterGrid();
		}
	})
	function update_order_status(e){
		var answer = confirm( "Do you want to update order status?");
		if(answer){
			var me = jQuery(this);
			var id = me.attr("id");
			id = id.split("-");
			id = id[1];
			id =  me.attr("data-link_id");
			var type = me.attr("data-link_type");
			var jsca_id = me.attr("data-jsca_id");
			var date_added = me.attr("data-date_added");
			var lead_id = me.attr("data-lead_id");
			var merged_order_id = me.attr("data-merged_order_id");
			var gs = me.attr("data-gs_job_titles_details_id");
			var tracking_code = me.attr("data-tracking_code");
			me.attr("disabled", "disabled")
			if (merged_order_id!="0"){
				var data = {
						value:me.val(),
						id:merged_order_id,
						tracking_code:tracking_code
				}
				jQuery.post("/portal/recruiter/update_order_status_merged.php", data, function(data){
					data = jQuery.parseJSON(data);
					var val = data.saveValue;
					if ((val=="new")||(val=="active")){
						val = "Open";
					}else if (val=="cancel"){
						val = "Did not push through";
					}else if (val=="finish"){
						val = "Closed"
					}else if (val=="onhold"){
						val = "On Hold"
					}else if (val=="ontrial"){
						val = "On Trial";
					}
					me.attr("data-value", val)
					alert("The status of this order has been updated to "+val);
					me.removeAttr("disabled");
				});
				e.stopPropagation();
		}else{
			var info = {
					id:id,
					value:me.val(),
					type:type,
					jsca_id:jsca_id,
					date_added:date_added,
					lead_id:lead_id,
					tracking_code:tracking_code
			};
			if (id=="null"){
				id = jQuery(this).attr("data-gs_job_titles_details_id");
				info.id = jQuery(this).attr("data-gs_job_titles_details_id");
				info.gs =  jQuery(this).attr("data-gs_job_titles_details_id");
				info.type = "order";
			}
			
			
			if (gs!=""&&gs!=undefined){
				info.gs = gs
				
			}
			
			if (me.val()=="Closed"){
				if (!confirm("Do you really want to close this order?\nOnce you close this order it cannot be re-open.")){
					me.val(me.attr("data-value"));
					me.removeAttr('disabled');
					e.stopPropagation();
					return;
				}
			}else if (me.val()=="Open"&&me.attr("data-value")=="Closed"&&me.attr("data-link_type")!="asl"){
				if (!confirm("Do you want to reopen this one as a replacement order?")){
					me.val(me.attr("data-value"));
					me.removeAttr('disabled');
					e.stopPropagation();
					return;
				}
			}else if (me.val()=="Open"&&me.attr("data-value")=="On Hold"){
				
				
				if (confirm("Do you want to reopen this one as a new order?\nSelect CANCEL to update the order status only.")){
					info = {
							id:id,
							value:me.val(),
							type:type,
							jsca_id:jsca_id,
							date_added:date_added,
							lead_id:lead_id,
							tracking_code:tracking_code,
							new_order:"yes"
					};
					
				}else{
					info = {
							id:id,
							value:me.val(),
							type:type,
							jsca_id:jsca_id,
							date_added:date_added,
							lead_id:lead_id,
							tracking_code:tracking_code,
							new_order:"no"
					};
					
				}
				if (id=="null"){
					id = jQuery(this).attr("data-gs_job_titles_details_id");
					info.id = jQuery(this).attr("data-gs_job_titles_details_id");
					info.gs =  jQuery(this).attr("data-gs_job_titles_details_id");
					info.type = "order";
				}
				
				
				if (gs!=""&&gs!=undefined){
					info.gs = gs
					info.type = "order";
				}
				
				
				
			}
			jQuery.post("/portal/recruiter/update_order_status.php", info, function(data){
				data = jQuery.parseJSON(data);
				me.removeAttr("disabled");
				if (me.val()=="Open"&&me.attr("data-value")=="Closed"){
					jQuery("#selecthrservicetype-"+id).val("REPLACEMENT").attr("disabled", "disabled");
					e.stopPropagation();
				}
				if (me.val()=="Open"&&me.attr("data-value")=="Closed"&&me.attr("data-link_type")!="asl"){
					alert("Replacement order has been created.\nYou can check it on the Open Replacement tab.");
					$openclosecancel.tabs( "option", "selected" , 1);
					var openCloseCancel = $openclosecancel.tabs( "option", "selected" );
					var serviceType = $servicetype.tabs( "option", "selected" );
					filterGrid(openCloseCancel, serviceType);
				}else{
					if (data.result&&data.type=="custom"){
						
						var val = data.saveValue;
						if ((val=="new")||(val=="active")){
							val = "Open";
						}else if (val=="cancel"){
							val = "Did not push through";
						}else if (val=="finish"){
							val = "Closed"
						}else if (val=="onhold"){
							val = "On Hold"
						}else if (val=="ontrial"){
							val = "On Trial";
						}
						me.parent("span").html(data.value);
						jQuery("#selecthrstatus-"+id).attr("data-status", val);
						me.attr("data-value", val)
						alert("The status of this order has been updated to "+val);
						
						if (val=="Open"){
							jQuery("#recruiters").val("");
							jQuery("#individual-filter-type").val("0");
							jQuery("#hiring-coordinators").val("");
							jQuery("#keyword").val("");
							$openclosecancel.tabs( "option", "selected", 1);
							$servicetype.tabs( "option", "selected", 0);
							filterGrid();
						}
					}else{
						var val = data.saveValue;
						if ((val=="new")||(val=="active")){
							val = "Open";
						}else if (val=="cancel"){
							val = "Did not push through";
						}else if (val=="finish"){
							val = "Closed"
						}else if (val=="onhold"){
							val = "On Hold"
						}else if (val=="ontrial"){
							val = "On Trial";
						}
						me.attr("data-value", val)
						alert("The status of this order has been updated to "+val);
						if (val=="Open"){
							jQuery("#recruiters").val("");
							jQuery("#individual-filter-type").val("0");
							jQuery("#hiring-coordinators").val("");
							jQuery("#keyword").val("");
							$openclosecancel.tabs( "option", "selected", 1);
							$servicetype.tabs( "option", "selected", 0);
							filterGrid();
						}
					}
				}
				
			});
		}
		
		}else{
			jQuery(this).val(previous_status);
		}
	}
	
	function update_service_type(e){
		var answer = confirm( "Do you want to update service type?");
		if(answer){
		var me = jQuery(this);
		var id = me.attr("id");
		id = id.split("-");
		id = id[1];
		var service_type = me.attr("data-service_type");
		var info = {
				id:id,
				value:me.val(),
				service_type:service_type,
				tracking_code:me.attr("data-tracking_code")
		};
		var status = me.attr("data-status");
		var oldValue = me.attr("data-value");
		var linkId = me.attr("data-link_id");
		
		me.attr("disabled", "disabled");
		
		if (status=="Closed"&&me.val()=="REPLACEMENT"){
			var answer = confirm("Do you want to reopen this one as a replacement order?");
			if (answer){
				jQuery.post("/portal/recruiter/update_service_type.php", info, function(data){
					data = jQuery.parseJSON(data);
					if (data.result){
						me.parent("span").html(data.value);
						me.attr("data-value", data.service_type);
						var val = data.status;
						if ((val=="new")||(val=="active")){
							val = "Open";
						}else if (val=="cancel"){
							val = "Did not push through";
						}else if (val=="finish"){
							val = "Closed"
						}else if (val=="onhold"){
							val = "On Hold"
						}else if (val=="ontrial"){
							val = "On Trial";
						}
						me.attr("data-status", val);
						jQuery("#selecthrstatus-"+linkId).val("Open");
						alert("Replacement order has been created.\nYou can check it on the replacement tab.");
						var openCloseCancel = $openclosecancel.tabs( "option", "selected" );
						var serviceType = $servicetype.tabs( "option", "selected" );
						filterGrid(openCloseCancel, serviceType);
					}
					me.removeAttr("disabled");
				});		
			}else{
				me.val(oldValue)
				me.removeAttr('disabled');
			}
		}else{
			if (me.attr("data-merged_order_id")!="0"){
				info.id =  me.attr("data-merged_order_id");
				jQuery.post("/portal/recruiter/update_service_type_merged.php", info, function(data){
					data = jQuery.parseJSON(data);
					if (data.result){
						alert("This order has been successfully converted into "+data.service_type+" order.");
						me.parent("span").html(data.value);
						if (service_type=="ASL"){
							reloadFilterGrid();
						}
					}
					me.removeAttr("disabled");
				});	
			}else{
				if (service_type=="ASL"){
					info.jsca_id = me.attr("data-jsca_id"),
					info.date_added = me.attr("data-date_added"),
					info.leads_id = me.attr("data-lead_id");
				}
				jQuery.post("/portal/recruiter/update_service_type.php", info, function(data){
					data = jQuery.parseJSON(data);
					if (data.result){
						if (service_type=="ASL"){
							reloadFilterGrid();
						}
						alert("This order has been successfully converted into "+data.service_type+" order.");
						me.parent("span").html(data.value);
						
					}
					me.removeAttr("disabled");
				});					
			}
		
		}
		e.stopPropagation();
		
		}else{
			jQuery(this).val(previous_service);
		}

	}
	
	var previous_status;
	function get_previous_status(e){
		previous_status = jQuery(this).val();
	}
	var previous_service;
	function get_previous_service(e){
		previous_service = jQuery(this).val();
	}
	
	jQuery(".select_hr_status_update").live("change", update_order_status);
	jQuery(".select_hr_service_update").live("change", update_service_type);
	jQuery(".select_hr_status_update").live("click", get_previous_status);
	jQuery(".select_hr_service_update").live("click", get_previous_service);
	jQuery(".select_hr_status_update").live("focus",get_previous_status);
	jQuery(".select_hr_service_update").live("focus",get_previous_service);
	
	jQuery("#search").button({
		icons:{
			primary:"ui-icon-search"
		}
	}).click(function(){
		var openCloseCancel = $openclosecancel.tabs( "option", "selected" );
		var serviceType = $servicetype.tabs( "option", "selected" );
		filterGrid(openCloseCancel, serviceType);
	});
	
	jQuery("#keyword").keypress(function(e){
		var code = (e.keyCode ? e.keyCode : e.which);
 		if(code == 13) { 
			var openCloseCancel = $openclosecancel.tabs( "option", "selected" );
			var serviceType = $servicetype.tabs( "option", "selected" );
			filterGrid(openCloseCancel, serviceType);
		}
	})
	
	
	jQuery("#show-hide-filters").click(function(e){
		var filterForm = jQuery("#filter-form");
		if (filterForm.is(":visible")){
			filterForm.slideUp(100);
		}else{
			filterForm.slideDown(100);
		}
		e.preventDefault();
	});
	
	function filterGrid(openCloseCancel, serviceType){
		if (openCloseCancel!=undefined){
			openCloseCancel = openCloseCancel-1;
		}
		var url = "/portal/recruiter/test_mongo_load.php?";
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
		}
		var keyword = $( "#keyword" ).val();
		var recruiter = $("#recruiters").val();
		var hiringcoordinator = $("#hiring-coordinators").val();
		var business_developer = $("#business-developer").val();
		var inhouse_staff = $("#inhouse-staff").val();
		url+=("&service_type="+serviceType);
		url+=("&order_status="+openCloseCancel);
		url+=("&keyword="+keyword);
		url+=("&recruiters="+recruiter);
		url+=("&hiring_coordinator="+hiringcoordinator);
		url+=("&business_developer="+business_developer);
		url+=("&inhouse_staff="+inhouse_staff);
		
		url+=("&display="+displayStatus);
		if (filter_type==0&&serviceType==undefined&&openCloseCancel==undefined&&keyword==""&&recruiter==""&&hiringcoordinator==""){
			url = "/portal/recruiter/test_mongo_load.php?display="+displayStatus+"&";
		}
		if (grid!=null){
			grid.reload(url);	
		}
	}

	function renderSubCategory(value, options, row){

		if (credentials.status == "FULL-CONTROL"){
			var subcategory_dropdown = "<select class='subcategory_dropdown' data-tracking_code='"+row.tracking_code+"'><option value=''>Select Sub Category</option>";
			jQuery.each(categories, function(i, category){
				if (category.subcategories!=undefined&&category.subcategories.length > 0){
					subcategory_dropdown += "<optgroup label='"+category.category_name+"'>";
					jQuery.each(category.subcategories, function(j, subcategory){

						if (parseInt(row.job_sub_category_id)==parseInt(subcategory.sub_category_id)){
							subcategory_dropdown += "<option value='"+subcategory.sub_category_id+"' selected>"+subcategory.sub_category_name+"</option>";
						}else{
							subcategory_dropdown += "<option value='"+subcategory.sub_category_id+"'>"+subcategory.sub_category_name+"</option>";
						}
					});
					subcategory_dropdown += "</optgroup>";
				}

			});
			subcategory_dropdown += "</select>";
			return subcategory_dropdown;
		}else{
			if (row.job_sub_category_name){
				return "<i>"+row.job_sub_category_name+"</i>";
			}else{
				return "";
			}
		}
	}

	function renderRecruiter(value, options, row){

		if (credentials.assign_recruiters=="Y"){

			var output="";
			var link = "";
			if (row.gs_job_role_selection_id!=""){
				output+="<div id='recruiters-"+row.gs_job_titles_details_id+"-JO'>";
				link="<a href='' class='add-recruiters' data-id='"+row.gs_job_titles_details_id+"' data-type='JO' data-tracking_code='"+row.tracking_code+"'>Add New Recruiter</a>";
			}else{
				output+="<div id='recruiters-"+row.leads_id+"-Lead'>";
				link="<a href='' class='add-recruiters' data-id='"+row.leads_id+"' data-type='Lead' data-tracking_code='"+row.tracking_code+"'>Add New Recruiter</a>";
			}

			jQuery.each(row.assigned_recruiters, function(i, item){
				var hr_id = item.recruiters_id;
				var link_type = item.link_type;
				var link_id = item.link_id;
				var select = "<select class='hr_update hr_select' data-link-id='"+link_id+"' data-link-type='"+link_type+"' data-recruiter-id='"+hr_id+"' data-tracking_code='"+row.tracking_code+"'>";
				var deleteLink = "<span id='hr_delete-"+link_id+"-"+link_type+"-"+hr_id+"' class='ui-icon ui-icon-close hr_delete' data-link-id='"+link_id+"' data-link-type='"+link_type+"' data-recruiter-id='"+hr_id+"' data-tracking_code='"+row.tracking_code+"'></span>";
				select+="<option value=''>Please select recruiter</option>"
				jQuery.each(recruiters, function(i, item){
					var fullname = item.admin_fname+" "+item.admin_lname;
					if ((hr_id!=null)&&(hr_id==item.admin_id)){
						select+=("<option value='"+item.admin_id+"' selected>"+fullname+"</option>");
					}else{
						select+=("<option value='"+item.admin_id+"'>"+fullname+"</option>");	
					}
				});
				select+=("</select>"+deleteLink+"<br/>");
				output+=select;
			});
			
			output+="</div>";
			return output+link;		
		}else{
			if (row.assigned_recruiters!=undefined&&row.assigned_recruiters!=null&&row.assigned_recruiters.length>0){
				var output = "<ul>";
				jQuery.each(row.assigned_recruiters, function(i, item){
					output+=("<li>"+item.admin_fname+" "+item.admin_lname+"</li>");
				});
				output+="</ul>";				
				return output;
			}else{
				return "&nbsp;";
			}


		}
		
	}
	
	function renderHiringCoordinators(value, options, row){
		if (credentials.status == "FULL-CONTROL"){
			var selectClass = "class='hr_update hc'";
			var leads_id = row.leads_id;
			var hr_id = row.assigned_hiring_coordinator_id;
			var id = "id='selecthc-"+leads_id+"-"+hr_id+"'";
			var select = "<select "+selectClass+" "+id+" data-tracking_code='"+row.tracking_code+"'>";
			select+="<option value=''>Please select hiring coordinator</option>"
			jQuery.each(hiringCoordinators, function(i, item){
				var fullname = item.admin_fname+" "+item.admin_lname;
				if ((hr_id!=null)&&(hr_id==item.admin_id)){
					select+=("<option value='"+item.admin_id+"' selected>"+fullname+"</option>");
				}else{
					select+=("<option value='"+item.admin_id+"'>"+fullname+"</option>");	
				}
			});
			select+="</select>";
			return select;	
		}else{
			return value;
		}
	}
	
	function renderServiceType(value, options, row){
		if (credentials.status == "FULL-CONTROL"){
			console.log(row);
			var choices = ["ASL", "BACK ORDER", "REPLACEMENT", "CUSTOM", "INHOUSE"];
			var val = value;
			var id = row.gs_job_titles_details_id;
			var selectId = "selecthrservicetype-"+id;
			var disabled = "";
			var tracking_code = row.tracking_code;
			
			if ((row.gs_job_role_selection_id==""||value=="ASL")&&row.job_title=="TBA When JS is Filled"){
				disabled="disabled";
			}
			
			var data_id = "data-id='"+id+"'";
			var data_merged_order_id = "";
			if (row.merged_order_id!=""){
				data_merged_order_id = "data-merged_order_id='"+row.merged_order_id+"'";	
			}else{
				data_merged_order_id = "data-merged_order_id='0'";	
			}
			var status = row.status;
			if ((status=="new")||(status=="active")){
				status = "Open";
			}else if (status=="cancel"){
				status = "Did not push through";
			}else if (status=="finish"){
				status = "Closed"
			}else if (status=="onhold"){
				status = "On Hold"
			}else if (status=="ontrial"){
				status = "On Trial";
			}
			var data_value = "data-value='"+value+"'";
			
			var data_old_service_type = "data-service_type='"+row.service_type+"'";
			var data_status = "data-status='"+status+"'";
			
			
			var data_jsca_id = "data-jsca_id='"+row.jsca_id+"'";
			var data_lead_id = "data-lead_id='"+row.leads_id+"'";
			var data_date_added = "data-date_added='"+row.date_filled_up+"'";
			
			
			/*
			if (val=="REPLACEMENT"){
				disabled="disabled";
			}
			*/
			var select = "<select class='select_hr_service_update' id='"+selectId+"' "+disabled+" "+data_value+" "+data_id+" "+data_status+" "+data_merged_order_id+" "+data_old_service_type+" "+data_date_added+" "+data_lead_id+" "+data_jsca_id+" data-tracking_code='"+tracking_code+"'>";
			
			jQuery.each(choices, function(i, item){
				if (item==val){
					select+=("<option selected>"+item+"</option>");				
				}else{
					select+=("<option>"+item+"</option>");		
				}
			});
			select+="</select>";
			return select;
		}else{
			if (row.gs_job_role_selection_id==""){
				return "ASL";
			}
			return value;
		}
	}
	
	
	function renderOrderStatus(value, options, row){
		if (credentials.status == "FULL-CONTROL"){
			var choices = ["Open", "Did not push through", "Closed", "On Hold", "On Trial"];
			var val = value;
			var id = row.gs_job_titles_details_id;
			var selectId = "selecthrstatus-"+id;
			var disabled = "";
			var type = "";
			var link_id  = "";
			var jsca_id = "";
			var date_added = "";
			var lead_id = "";
			var data_merged_order_id = "";
			var tracking_code = "data-tracking_code='"+row.tracking_code+"'"
			var gs = "";
			if (row.merged_order_id!=""){
				data_merged_order_id = "data-merged_order_id='"+row.merged_order_id+"'";	
			}else{
				data_merged_order_id = "data-merged_order_id='0'";	
			}
			if ((val=="new")||(val=="active")||val=="Open"){
				val = "Open";
			}else if (val=="cancel"||val=="Cancel"){
				val = "Did not push through";
			}else if (val=="finish"||val=="Closed"){
				val = "Closed"
			}else if (val=="onhold"||val=="OnHold"){
				val = "On Hold"
			}else if (val=="ontrial"||val=="OnTrial"){
				val = "On Trial";
			}
			if (row.service_type=="ASL"){
				if (row.gs_job_titles_details_id!=""&&row.gs_job_titles_details_id!=null){
					gs = "data-gs_job_titles_details_id = '"+row.gs_job_titles_details_id+"'";
					type = "data-link_type = 'asl'";
					jsca_id = "data-jsca_id = '"+row.jsca_id+"'";
					date_added = "data-date_added = '"+row.date_filled_up+"'";
					lead_id = "data-lead_id = '"+row.leads_id+"'";
					link_id = "data-link_id = '"+row.session_id+"'";
				}else{
					link_id = "data-link_id = '"+row.session_id+"'";
					jsca_id = "data-jsca_id = '"+row.jsca_id+"'";
					date_added = "data-date_added = '"+row.date_filled_up+"'";
					lead_id = "data-lead_id = '"+row.leads_id+"'";
					type = "data-link_type = 'asl'";
					if (row.gs_job_titles_details_id!=""&&row.gs_job_titles_details_id!=undefined){
						gs="data-gs_job_titles_details_id='"+row.gs_job_titles_details_id+"'"
					}
						
				}
				
			}else{
				link_id = "data-link_id = '"+row.gs_job_titles_details_id+"'";
				type = "data-link_type = 'order'";
			}
			
			if(value == 'Closed'){
				disabled='disabled="disabled"';
			}
			
			var data_value = "data-value='"+val+"'";
			var select = "<select class='select_hr_status_update' id='"+selectId+"' "+disabled+" "+link_id+" "+type+" "+jsca_id+" "+date_added+" "+data_value+" "+lead_id+" "+data_merged_order_id+" "+gs+" "+tracking_code+">";
			jQuery.each(choices, function(i, item){
				if (item==val){
					select+=("<option selected>"+item+"</option>");				
				}else{
					select+=("<option>"+item+"</option>");		
				}
			});
			select+="</select>";
			return select;
		}else{
			if (credentials.status=="BusinessDeveloper"){
				if (row.bp_fname=="Walter"&&row.bp_lname=="Fulmizi"&&(row.hc_fname==null||row.hc_fname==""||row.hc_fname==undefined)){
					var choices = ["Open", "Did not push through", "Closed", "On Hold", "On Trial"];
					var val = value;
					var id = row.gs_job_titles_details_id;
					var selectId = "selecthrstatus-"+id;
					var disabled = "";
					var type = "";
					var link_id  = "";
					var jsca_id = "";
					var date_added = "";
					var lead_id = "";
					var data_merged_order_id = "";
					var tracking_code = "data-tracking_code='"+row.tracking_code+"'"
					var gs = "";
					if (row.merged_order_id!=""){
						data_merged_order_id = "data-merged_order_id='"+row.merged_order_id+"'";	
					}else{
						data_merged_order_id = "data-merged_order_id='0'";	
					}
					if ((val=="new")||(val=="active")||val=="Open"){
						val = "Open";
					}else if (val=="cancel"||val=="Cancel"){
						val = "Did not push through";
					}else if (val=="finish"||val=="Closed"){
						val = "Closed"
					}else if (val=="onhold"||val=="OnHold"){
						val = "On Hold"
					}else if (val=="ontrial"||val=="OnTrial"){
						val = "On Trial";
					}
					if (row.service_type=="ASL"){
						link_id = "data-link_id = '"+row.session_id+"'";
						jsca_id = "data-jsca_id = '"+row.jsca_id+"'";
						date_added = "data-date_added = '"+row.date_filled_up+"'";
						lead_id = "data-lead_id = '"+row.leads_id+"'";
						type = "data-link_type = 'asl'";
						if (row.gs_job_titles_details_id!=""&&row.gs_job_titles_details_id!=undefined){
							gs="data-gs_job_titles_details_id='"+row.gs_job_titles_details_id+"'"
						}
						
					}else{
						link_id = "data-link_id = '"+row.gs_job_titles_details_id+"'";
						type = "data-link_type = 'order'";
					}
					var data_value = "data-value='"+val+"'";
					var select = "<select class='select_hr_status_update' id='"+selectId+"' "+disabled+" "+link_id+" "+type+" "+jsca_id+" "+date_added+" "+data_value+" "+lead_id+" "+data_merged_order_id+" "+gs+" "+tracking_code+">";
					jQuery.each(choices, function(i, item){
						if (item==val){
							select+=("<option selected>"+item+"</option>");				
						}else{
							select+=("<option>"+item+"</option>");		
						}
					});
					select+="</select>";
					return select;
				}else{
					if ((value==undefined)||(value==null)){
						return "Open";
					}
					return value;	
				}
			}else{
				if ((value==undefined)||(value==null)){
					return "Open";
				}
				return value;	
			}
			
		}
	}
	
	function renderAction(value, options, row){
		if (credentials.status == "FULL-CONTROL"){
			
			var link_id = "data-link_id=";
			var link_type = "data-link_type=";
			var jsca_id = "";
			var date_added = "";
			var data_lead_id = "data-lead_id='"+row.leads_id+"'";
			var data_service_type = "data-service_type='"+row.service_type+"'";
			var data_tracking_code = "data-tracking_code='"+row.tracking_code+"'";
			var data_merged_order_id = "";
			if (row.merged_order_id!=""){
				data_merged_order_id = "data-merged_order_id='"+row.merged_order_id+"'";	
			}else{
				data_merged_order_id = "data-merged_order_id='0'";	
			}
			if (row.service_type=="ASL"){
				link_id += ("'"+row.session_id+"'");
				jsca_id = "data-jsca_id='"+row.jsca_id+"'";
				date_added = "data-date_added='"+row.date_filled_up+"'";
				link_type += "'ASL'";				
			}else{
				link_id += ("'"+row.gs_job_titles_details_id+"'");
				link_type += "'Custom'";
			}
			var check = "<input type='checkbox' class='select-checkbox' "+link_id+" "+link_type+" "+jsca_id+" "+date_added+" "+data_service_type+" "+data_lead_id+" "+data_tracking_code+" "+data_merged_order_id+"/>";
			return check;
			
		}else{
			return "";
		}
	}
	
	function renderViewHistory(value, options, row){
		if (row.asl_order_id==""){
			return "<a href='/portal/recruiter/load_order.php"+"' data-link_id='"+row.gs_job_titles_details_id+"' data-link_type='CUSTOM' class='view-history'>View History</a>";
		}else{
			return "";
		}
	}
	
	function renderHMNotes(value, options, row){
		return "<a href='/portal/recruiter/load_comments.php?tracking_code="+row.tracking_code+"' class='view_hm_notes'>View Notes("+row.job_order_comments_count+")</a>";
	}
	
	function renderJobTitle(value, options, row){
		if (row.session_id&&row.gs_job_role_selection_id){
			return row.job_title+" *";
		}else{
			return row.job_title;
		}
	}
	
	function reloadFilterGrid(){
		var openCloseCancel = $openclosecancel.tabs( "option", "selected" );
		var serviceType = $servicetype.tabs( "option", "selected" );
		filterGrid(openCloseCancel, serviceType);
	}
	
	
	jQuery(".subcategory_dropdown").live("change", function(e){
		var answer = confirm('Do you want to update category');
		if(answer){
			var tracking_code = jQuery(this).attr("data-tracking_code");
			var sub_category_id = jQuery(this).val();
			jQuery.post("/portal/recruiter/update_job_sub_category_job_order.php", {tracking_code:tracking_code, sub_category_id:sub_category_id}, function(response){
				response = jQuery.parseJSON(response);
				if (response.success){
					alert("Job Order has been categorized as "+response.subcategory);
				}
			});
		}else{
			jQuery(this).val(previous_subcategory);
		}
	});
	
	var previous_subcategory;
	jQuery(".subcategory_dropdown").live("click", function(e){
		previous_subcategory = jQuery(this).val();
	});
	jQuery(".subcategory_dropdown").live("focus", function(e){
		previous_subcategory = jQuery(this).val();
	});
	
	jQuery(".select-checkbox").live("click", function(){
		var selectedCell = jQuery(this).parent();
		var column = selectedCell.parent("tr").children().index(selectedCell)+1;
		jQuery("#rs-grid-container-recruitment-sheet .ui-jqgrid-btable tr td.gridrow:nth-child("+column+")").toggleClass("ui-state-highlight");
	});
	
	var $openclosecancel = jQuery("#open-close-cancel").tabs({
		selected:1,
		select:function(event, ui){
			var serviceType = $servicetype.tabs( "option", "selected" );
			filterGrid(ui.index, serviceType);
		}
	});
	var $servicetype = jQuery("#service-type").tabs({
		select:function(event, ui){
			var openCloseCancel = $openclosecancel.tabs( "option", "selected" );
			filterGrid(openCloseCancel, ui.index);
		}
	});
	
	jQuery(".view-history").live("click", function(e){
		jQuery("#ui-datepicker-div").css("display", "none");
		jQuery("#details-dialog").html("")
		jQuery( "#dialog:ui-dialog" ).dialog( "destroy" );
		jQuery( "#details-dialog" ).dialog(
		{height: 430,
		width:840,
		modal: true,
		title:"Order History"
			
		});
		
		jQuery.get("/portal/recruiter/load_order.php?order_id="+jQuery(this).attr("data-link_id"), function(data){
			jQuery("#details-dialog").html(data);
		})
		
		e.preventDefault();
	})
	
	jQuery(".view_hm_notes").live("click", function(e){
		jQuery("#ui-datepicker-div").css("display", "none");
		jQuery("#details-dialog").html("")
		jQuery( "#dialog:ui-dialog" ).dialog( "destroy" );
		jQuery( "#details-dialog" ).dialog(
		{height: 430,
		width:840,
		modal: true,
		title:"View HM Notes"
			
		});
		
		jQuery.get(jQuery(this).attr("href"), function(data){
			jQuery("#details-dialog").html(data);
		})
		
		e.preventDefault();
	})
	
	jQuery(".add_new_comment").live("submit", function(e){
		var data = jQuery(this).serialize();
		jQuery.post("/portal/recruiter/add_new_jo_comments.php", data, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				var comment = response.comment;
				var template = '<li style="border-bottom:1px dotted #312E27;width:431px;word-wrap:break-word">';
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
	})
	
	jQuery(".delete_note").live("click", function(e){
		var ans = confirm("Do you want to delete this note?");
		var me = jQuery(this);
		if (ans){
			jQuery.get(me.attr("href"), function(response){
				me.parent().parent().remove();
			})
		}
		e.preventDefault();
	});
	jQuery(".shortlist_popup").live("click", function(e){
		jQuery("#ui-datepicker-div").css("display", "none");
		jQuery("#details-dialog").html("")
		jQuery( "#dialog:ui-dialog" ).dialog( "destroy" );
		jQuery( "#details-dialog" ).dialog(
		{height: 430,
		width:840,
		modal: true,
		});
		
		jQuery.get("/portal/recruiter/job_order_shortlisted_candidates.php?view=1&posting_id="+jQuery(this).attr("data-position-id"), function(data){
			jQuery("#details-dialog").html(data);
		})
		
		e.preventDefault();
	})
	
	jQuery(".add-recruiters").live("click", function(e){
		var link_type = jQuery(this).attr("data-type");
		var link_id = jQuery(this).attr("data-id");
		var tracking_code = jQuery(this).attr("data-tracking_code");
		var select = "<select id='hr_update-"+link_id+"-"+link_type+"' class='hr_update hr_select' data-link-id='"+link_id+"' data-link-type='"+link_type+"' data-tracking_code='"+tracking_code+"'>";
		var deleteLink = "<span id='hr_delete-"+link_id+"-"+link_type+"' class='ui-icon' data-link-id='"+link_id+"' data-link-type='"+link_type+"'></span>";
		select+="<option value=''>Please select recruiter</option>"
		jQuery.each(recruiters, function(i, item){
			var fullname = item.admin_fname+" "+item.admin_lname;
			select+=("<option value='"+item.admin_id+"'>"+fullname+"</option>");	
		});
		select+=("</select>"+deleteLink+"<br/>");
		jQuery("#recruiters-"+link_id+"-"+link_type).append(select);
		grid.flexiColumns();
		e.preventDefault();
	});
	
	jQuery(".hr_delete").live("click", function(){
		var link_id = jQuery(this).attr("data-link-id");
		var link_type = jQuery(this).attr("data-link-type");
		var recruiter_id = jQuery(this).attr("data-recruiter-id");
		var tracking_code = jQuery(this).attr("data-tracking_code");
		var data = {
				link_id:link_id,
				link_type:link_type,
				recruiter_id:recruiter_id,
				tracking_code:tracking_code
		}
		var me = jQuery(this);
		jQuery.post("/portal/recruiter/remove_hr_from_posting.php", data,function(data){
			data = jQuery.parseJSON(data);
			if (data.result){
				me.prev().remove();
				me.next().remove();
				me.remove();			
				grid.flexiColumns();
			}
		});
		
		
	});
	jQuery("#displayed-button").click(function(){
		moveTo.button("option", "disabled", false);
		restoreTo.button("option", "disabled", true);
		displayStatus = "Displayed";
		var openCloseCancel = $openclosecancel.tabs( "option", "selected" );
		var serviceType = $servicetype.tabs( "option", "selected" );
		filterGrid(openCloseCancel, serviceType);
	});
	jQuery("#deleted-button").click(function(){
		moveTo.button("option", "disabled", true);
		restoreTo.button("option", "disabled", false);
		displayStatus = "Deleted";
		var openCloseCancel = $openclosecancel.tabs( "option", "selected" );
		var serviceType = $servicetype.tabs( "option", "selected" );
		filterGrid(openCloseCancel, serviceType);
	});
	
	
	function updateSelectedOrderStatus(){
		
		var selectedLinkIds = [];
		var selectedLinkTypes = [];
		var selectedJscaIds = [];
		var selectedDateAddeds = [];
		var selectedTrackingCodes = [];
		
		jQuery(".select-checkbox:checked").each(function(){
			selectedLinkIds.push(jQuery(this).attr("data-link_id"));
			selectedLinkTypes.push(jQuery(this).attr("data-link_type"));
			if (jQuery(this).attr("data-jsca_id")!=undefined){
				selectedJscaIds.push(jQuery(this).attr("data-jsca_id"));
			}else{
				selectedJscaIds.push("");
			}
			if (jQuery(this).attr("data-date_added")!=undefined){
				selectedDateAddeds.push(jQuery(this).attr("data-date_added"));
			}else{
				selectedDateAddeds.push("");
			}
			selectedTrackingCodes.push(jQuery(this).attr("data-tracking_code"))
			
		});
		
		var queryString = "send=1";
		jQuery(selectedLinkTypes).each(function(i, item){
			queryString+=("&selectedLinkIds[]="+selectedLinkIds[i]);
			queryString+=("&selectedJscaIds[]="+selectedJscaIds[i]);
			queryString+=("&selectedDateAddeds[]="+selectedDateAddeds[i]);
			queryString+=("&selectedLinkTypes[]="+selectedLinkTypes[i]);		
			queryString+=("&selectedTrackingCodes[]="+selectedTrackingCodes[i]);		
			
		});
		queryString += ("&status="+displayStatus);
		jQuery.post("/portal/recruiter/update_job_order_display_status.php", queryString, function(data){
			data = jQuery.parseJSON(data);
			if (data.result){
				var openCloseCancel = $openclosecancel.tabs( "option", "selected" );
				var serviceType = $servicetype.tabs( "option", "selected" );
				filterGrid(openCloseCancel, serviceType);
			}
		})
	}
	
	
	
	jQuery("#view-buttons").buttonset();
	var moveTo = jQuery("#move-to").button({
		icons:{
			primary:"ui-icon ui-icon-closethick"
		},
		disabled:true
	}).click(function(){
		if (jQuery(".select-checkbox:checked").length>0){
			var confirmed = confirm("Do you want to delete the selected job order/s?");
			if (confirmed){
				updateSelectedOrderStatus();			
			}
		}else{
			alert("Please select from the list of job orders");
		}
		
	});
	
	var restoreTo = jQuery("#restore-to").button({
		icons:{
			primary:"ui-icon-arrowreturnthick-1-w"
		},
		disabled:true
	}).click(function(){
		if (jQuery(".select-checkbox:checked").length>0){
			var confirmed = confirm("Do you want to restore the selected job order/s?");
			if (confirmed){
				updateSelectedOrderStatus();			
			}
		}else{
			alert("Please select from the list of job orders");
		}
	});
	
	var unmergeTo = jQuery("#unmerge-to").button({
		icons:{
			primary:"ui-icon-shuffle"
		},
		disabled:true
	}).click(function(){
		var selectedMergeOrderIds = [];
		var selectedTrackingCodes = [];
		var hasNoMerge = false;
		var me = jQuery(this);
		
		jQuery(".select-checkbox:checked").each(function(){
			if (jQuery(this).attr("data-merged_order_id")==undefined||jQuery(this).attr("data-merged_order_id")==""||jQuery(this).attr("data-merged_order_id")=="0"){
				alert("One of the selected order is not a merged order");
				hasNoMerge = true;
				return false;
			}
		
		})
		
		if (!hasNoMerge){
			var answer = confirm("Do you want to unmerge the following merged order/s?");
			if (answer){
				jQuery( "#unmerge-to" ).button( "option", "disabled", true );
				jQuery(".select-checkbox:checked").each(function(){
					if (jQuery(this).attr("data-merged_order_id")!=undefined&&jQuery(this).attr("data-merged_order_id")!=""){
						selectedMergeOrderIds.push(jQuery(this).attr("data-merged_order_id"));
						selectedTrackingCodes.push(jQuery(this).attr("data-tracking_code"));
					}
				});
				
				
				jQuery.post("/portal/recruiter/unmerge_order.php", {merged_order_ids:selectedMergeOrderIds, selected_tracking_codes:selectedTrackingCodes}, function(data){
					data = jQuery.parseJSON(data);
					if (data.success){
						$openclosecancel.tabs( "option", "selected", 0);
						$servicetype.tabs( "option", "selected", 0);
						var openCloseCancel = $openclosecancel.tabs( "option", "selected" );
						var serviceType = $servicetype.tabs( "option", "selected" );
						jQuery( "#unmerge-to" ).button( "option", "disabled", false );
						jQuery("#keyword").val(data.lead_name);
						filterGrid(openCloseCancel, serviceType);
						alert("Successfully unmerged selected merged orders.\nPlease wait while we are syncing back the job orders.\nIf it appears it disappeared from the list, it will be on the list again shortly.");
						
					}
					jQuery( "#unmerge-to" ).button( "option", "disabled", false );
				})
			}
				
		}
		
	})
	
	
	var mergeTo = jQuery("#merge-to").button({
		icons:{
			primary:"ui-icon-shuffle"
		},
		disabled:true
	}).click(function(){
		var selectedLinkIds = [];
		var selectedLinkTypes = [];
		var selectedJscaIds = [];
		var selectedDateAddeds = [];
		var selectedLeads = [];
		var selectedMergeOrderIds = [];
		
		var me = jQuery(this);
		
		if (jQuery(".select-checkbox:checked").length<=1){
			alert("Please select 2 or more orders to merge.");
			return;
		}
		
		var codes = [];
		jQuery(".select-checkbox:checked").each(function(){
			codes.push(jQuery(this).attr("data-tracking_code"));
		})
		var message = "Do you want to merge order ";
		for(var i=1;i<codes.length;i++){
			if (i+1==codes.length){
				message+="["+codes[i]+"] ";
			}else{
				message+="["+codes[i]+"], ";	
			}
		}
		message+="to ["+codes[0]+"]?";
		var answer = confirm(message);
		jQuery(".select-checkbox:checked").each(function(){
			selectedLinkIds.push(jQuery(this).attr("data-link_id"));
			selectedLinkTypes.push(jQuery(this).attr("data-service_type"));
			if (jQuery(this).attr("data-jsca_id")!=undefined){
				selectedJscaIds.push(jQuery(this).attr("data-jsca_id"));
			}else{
				selectedJscaIds.push("");
			}
			if (jQuery(this).attr("data-date_added")!=undefined){
				selectedDateAddeds.push(jQuery(this).attr("data-date_added"));
			}else{
				selectedDateAddeds.push("");
			}
			if (jQuery(this).attr("data-lead_id")!=undefined){
				selectedLeads.push(jQuery(this).attr("data-lead_id"));
			}else{
				selectedLeads.push("");				
			}
			selectedMergeOrderIds.push(jQuery(this).attr("data-merged_order_id"));
			
			
		});
		
		if (answer){
			jQuery( "#merge-to" ).button( "option", "disabled", true );
			//me.attr("disabled", "disabled");
			var queryString = "send=1";
			jQuery(selectedLinkTypes).each(function(i, item){
				queryString+=("&selectedLinkIds[]="+selectedLinkIds[i]);
				queryString+=("&selectedJscaIds[]="+selectedJscaIds[i]);
				queryString+=("&selectedDateAddeds[]="+selectedDateAddeds[i]);
				queryString+=("&selectedLinkTypes[]="+selectedLinkTypes[i]);	
				queryString+=("&selectedLeads[]="+selectedLeads[i]);	
				queryString+=("&selectedTrackingCodes[]="+codes[i]);
				queryString+=("&selectedMergedOrderIds[]="+selectedMergeOrderIds[i]);
				
				
			});
			jQuery.post("/portal/recruiter/merge_order.php", queryString, function(data){
				data = jQuery.parseJSON(data);
				if (data.success){
					$openclosecancel.tabs( "option", "selected", 0);
					$servicetype.tabs( "option", "selected", 0);
					var openCloseCancel = $openclosecancel.tabs( "option", "selected" );
					var serviceType = $servicetype.tabs( "option", "selected" );
					jQuery( "#merge-to" ).button( "option", "disabled", false );
					jQuery("#keyword").val(data.lead_name);
					filterGrid(openCloseCancel, serviceType);
					alert("Orders has been successfully merged.\nPlease wait while we are syncing back the job order.\nIf it appears it disappeared from the list, it will be on the list again shortly.");
				}else{
					alert(data.message);
					jQuery( "#merge-to" ).button( "option", "disabled", false );
				}
			})
		}
		
		
	});
	

	
	jQuery(".ui-selectable li").live("click", function(){
		jQuery(".ui-selectable li").removeClass("ui-selected");
		jQuery(this).addClass("ui-selected");
		var id = jQuery(this).attr("data-id");
		
		jQuery.get("/portal/recruiter/load_order_details.php?order_id="+id, function(data){
			jQuery("#order-details").html(data);
		});
		
	});
	
	//disable any controls during loading process
	jQuery("#individual-filter-type").attr("disabled", "disabled");
	jQuery("#keyword").attr("disabled", "disabled");
	jQuery("#recruiters").attr("disabled", "disabled");
	jQuery("#hiring-coordinators").attr("disabled", "disabled");
	jQuery("#search").button("disable");
	jQuery("#refresh").button("disable");
	jQuery("#service-type").tabs("option", "disabled", [0,1,2,3,4,5]);
	jQuery("#open-close-cancel").tabs("option", "disabled", [0,1,2,3,4,5,6]);

	// Get URL Parameters
	var getUrlParameter = function getUrlParameter(sParam) {
		var sPageURL = decodeURIComponent(window.location.search.substring(1)),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;

		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');

			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : sParameterName[1];
			}
		}
	};
	
	
	jQuery.get("/portal/recruiter/get_login_info.php", function(data){
		credentials = jQuery.parseJSON(data);	
		jQuery("#hiring-coordinators").val(credentials.admin_id);
		if (credentials.status == "HR"){
			jQuery("#recruiters").val("any_rec");
		}
		jQuery.get("/portal/recruiter/get_categories_rec_sheet.php", function(data){
			categories = jQuery.parseJSON(data);
			jQuery.get("/portal/recruiter/get_all_recruiters.php", function(data){
				recruiters = jQuery.parseJSON(data);
				jQuery.get("/portal/recruiter/get_all_recruiters.php?hr=1", function(data){
					hiringCoordinators = jQuery.parseJSON(data);
					var autoload = true;
					if (credentials.hiringCoordinator=="Y"){
						autoload = false;
					}
					if (credentials.status == "FULL-CONTROL"){
						var url = "/portal/recruiter/test_mongo_load.php";
						var params = getUrlParameter("keyword");
						var order_status_param = getUrlParameter("order_status");
						if(params) {
							console.log("Params value is "+params);
							console.log("Params value order_status_param is "+order_status_param);
							var order_status_code = 0;
							if(order_status_param == "Open") {
								console.log("li-open");
								order_status_code = 0;
								$("#li-open").addClass("ui-tabs-selected ui-state-active");
								$("#li-hired").removeClass("ui-tabs-selected ui-state-active");
								$("#li-dnpt").removeClass("ui-tabs-selected ui-state-active");
								$("#li-onhold").removeClass("ui-tabs-selected ui-state-active");
								$("#li-ontrial").removeClass("ui-tabs-selected ui-state-active");
							} else if(order_status_param == "On Hold") {
								console.log("li-onhold");
								order_status_code = 3;
								$("#li-open").removeClass("ui-tabs-selected ui-state-active");
								$("#li-hired").removeClass("ui-tabs-selected ui-state-active");
								$("#li-dnpt").removeClass("ui-tabs-selected ui-state-active");
								$("#li-onhold").addClass("ui-tabs-selected ui-state-active");
								$("#li-ontrial").removeClass("ui-tabs-selected ui-state-active");
							} else if(order_status_param == "Did not push through") {
								console.log("li-dnpt");
								order_status_code = 2;
								$("#li-open").removeClass("ui-tabs-selected ui-state-active");
								$("#li-hired").removeClass("ui-tabs-selected ui-state-active");
								$("#li-dnpt").addClass("ui-tabs-selected ui-state-active");
								$("#li-onhold").removeClass("ui-tabs-selected ui-state-active");
								$("#li-ontrial").removeClass("ui-tabs-selected ui-state-active");
							} else if(order_status_param == "Closed") {
								console.log("li-hired");
								order_status_code = 1;
								$("#li-open").removeClass("ui-tabs-selected ui-state-active");
								$("#li-hired").addClass("ui-tabs-selected ui-state-active");
								$("#li-dnpt").removeClass("ui-tabs-selected ui-state-active");
								$("#li-onhold").removeClass("ui-tabs-selected ui-state-active");
								$("#li-ontrial").removeClass("ui-tabs-selected ui-state-active");
							} else if(order_status_param == "On Trial") {
								console.log("li-ontrial");
								order_status_code = 4;
								$("#li-open").removeClass("ui-tabs-selected ui-state-active");
								$("#li-hired").removeClass("ui-tabs-selected ui-state-active");
								$("#li-dnpt").removeClass("ui-tabs-selected ui-state-active");
								$("#li-onhold").removeClass("ui-tabs-selected ui-state-active");
								$("#li-ontrial").addClass("ui-tabs-selected ui-state-active");
							}



							url = "/portal/recruiter/test_mongo_load.php?filter_type=0&service_type=0&order_status="+order_status_code+"&keyword="+params+"&recruiters=&hiring_coordinator=&business_developer=&inhouse_staff=yes&display=Displayed&rows=50&page=1";
						} else {
							console.log("Params value is undefined");
						}


						jQuery.get("/portal/recruiter/preprocess_job_order.php", function(data){
							jQuery.get("/portal/cronjobs/sync_asl_no_job_category_to_mongo.php", function(){})
							jQuery.get("/portal/cronjobs/sync_asl_via_job_category_to_mongo.php", function(){})
							jQuery.get("/portal/cronjobs/sync_basic_custom_to_mongo.php", function(){})
							jQuery.get("/portal/cronjobs/sync_merge_asl_no_job_category_to_mongo.php", function(){})
							jQuery.get("/portal/cronjobs/sync_merge_asl_via_job_category_to_mongo.php", function(){})
							jQuery.get("/portal/cronjobs/sync_merge_custom_to_mongo.php", function(){})
								grid = new RSInvertedGrid({
								columns:["Action", "Tracking Code",'Job Title', "Sub Category", "Job Specification Link",'Client',"Last Contact", "Number Of Staff Needed", "View History", "View Notes", "Service Type", "Order Status",'Work Status', 'Date Ordered', 'Date When Staff is Required', 'Order Age In Days', 'Work Time Zone', "Budget", "Notes and Comments", "Recruiter", "Hiring Coordinator", "Business Developer",  "Shortlisted", "Endorsed / <i>ASL Interview Request</i>", "Interviewed",  "Cancelled","Hired", "On Trial","Rejected"],
								id:"recruitment-sheet",
								url:url,
								pager:"#pager",
								dataLoaded:dataLoaded,
								autoload:autoload,
								colModel:[{name:"action", align:"center", width:200,sortable:false, formatter:renderAction},
								          	{name:"tracking_code", width:200, sortable:false},
								          	{name:"job_title",  width:200, frozen:true, sortable:false, formatter:renderJobTitle},
								          	{name:"subcategory",  width:200, frozen:true, sortable:false, formatter:renderSubCategory},

								          	{name:"job_specification_link", sortable:false, frozen:true},
								          	{name:"client", sortable:false, frozen:true, sortable:true},
								          	{name:"last_contact", sortable:false},

								          	{name:"no_of_staff_needed", sortable:false, frozen:true, sortable:true},

								          	{name:"viewHistory", width:200,sortable:false, formatter:renderViewHistory},
								          	{name:"viewNotes", width:200, sortable:false, formatter:renderHMNotes},
								          	{name:"service_type", align:"center",sortable:false, formatter:renderServiceType},
								          	{name:"order_status", align:"center", width:200,sortable:false, formatter:renderOrderStatus},
								          	{name:"work_status", sortable:false},
								          	{name:"date_filled_up", sortable:false},
								          	{name:"proposed_start_date", width:210, sortable:false},
								          	{name:"age", width:50,  sortable:false},
								          	{name:"working_timezone",  sortable:false},
								          	{name:"budget", width:237,sortable:false},
								          	{name:"notes", width:500,sortable:false},
								          	{name:"assigned_recruiter",width:250, align:"center",sortable:false, formatter:renderRecruiter, showTitle:false},
								          	{name:"assigned_hiring_coordinator",width:250, align:"center",sortable:true, formatter:renderHiringCoordinators, showTitle:false},
								          	{name:"assigned_business_developer",width:215, align:"center",sortable:true},
								          	{name:"shortlisted", width:210,sortable:false, showTitle:false},
								          	{name:"endorsed", width:210,sortable:false, showTitle:false},
								          	{name:"interviewed", width:210,sortable:false, showTitle:false},
								          	{name:"cancelled", width:210,sortable:false, showTitle:false},
								          	{name:"hired", width:210,sortable:false, showTitle:false},
								          	{name:"ontrial", width:210,sortable:false, showTitle:false},
								          	{name:"rejected", width:210,sortable:false, showTitle:false}

								          ]
							});
							grid.render();
							if (credentials.hiringCoordinator=="Y"){
								reloadFilterGrid();
							}


						})
						
						
					}else{
						grid = new RSInvertedGrid({
							columns:["Tracking Code", 'Job Title', "Sub Category", "Job Specification Link", "View History", "View Notes",  'Client', "Last Contact","Number Of Staff Needed", "Service Type", "Order Status", 'Work Status', 'Date Ordered', 'Date When Staff is Required', 'Order Age In Days', 'Work Time Zone', "Budget", "Notes and Comments", "Recruiter", "Hiring Coordinator", "Business Developer",  "Shortlisted", "Endorsed / <i>ASL Interview Request</i>", "Interviewed", "Cancelled","Hired", "On Trial","Rejected"],
							id:"recruitment-sheet",
							url:"/portal/recruiter/test_mongo_load.php",
							pager:"#pager",
							dataLoaded:dataLoaded,
							colModel:[{name:"tracking_code", sortable:false},	
							      		{name:"job_title",  width:200, frozen:true, sortable:false},
							      		{name:"subcategory",  width:200, frozen:true, sortable:false, formatter:renderSubCategory},
								          	
							          	{name:"job_specification_link", sortable:false, frozen:true},
							          	
							          	{name:"viewHistory", width:200,sortable:false, formatter:renderViewHistory},
							          	{name:"viewNotes", width:200, sortable:false, formatter:renderHMNotes},
							          	{name:"client", sortable:false, frozen:true, sortable:true},
							          	{name:"last_contact", sortable:false},
							          	{name:"no_of_staff_needed", sortable:false, frozen:true, sortable:true},
							          	
							          	{name:"service_type", align:"center",sortable:false, formatter:renderServiceType},
							         	{name:"order_status", align:"center", width:200,sortable:false, formatter:renderOrderStatus}, 	 
							          	{name:"work_status", sortable:false},
							          	{name:"date_filled_up", sortable:false},
							          	{name:"proposed_start_date", width:210, sortable:false},
							          	{name:"age", width:50,  sortable:false},
							          	{name:"working_timezone",  sortable:false},
							          	{name:"budget", width:237,sortable:false},
							          	{name:"notes", width:500,sortable:false},
							          	{name:"assigned_recruiter",width:250, align:"left",sortable:false, formatter:renderRecruiter, showTitle:false},
							          	{name:"assigned_hiring_coordinator",width:250, align:"center",sortable:true, formatter:renderHiringCoordinators, showTitle:false},
							          	{name:"assigned_business_developer",width:215, align:"center",sortable:true},
							          	{name:"shortlisted", width:210,sortable:false, showTitle:false},
							          	{name:"endorsed", width:210,sortable:false, showTitle:false},
							          	{name:"interviewed", width:210,sortable:false, showTitle:false},
							          	{name:"cancelled", width:210,sortable:false, showTitle:false},						          	{name:"hired", width:210,sortable:false, showTitle:false},
							          	{name:"ontrial", width:210,sortable:false, showTitle:false},
							          	{name:"rejected", width:210,sortable:false, showTitle:false}
							          	
							         ]
						});
						grid.render();
						if (credentials.status=="HR"){
							reloadFilterGrid();
						}
							
					}
					
					
				});
			});
		});
		
	});
})
