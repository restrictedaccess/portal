jQuery(document).ready(function(){
	
	var currentTab = "staffing_consultant_tab";
	
	
	
	jQuery(".tab-link").on("click", function(e){
		currentTab = jQuery(this).attr("data-tab");
	});
	
	
	jQuery("#export_button").click(function(e){
		jQuery("#filter-form").serialize();
		var selected = jQuery("input[name=selected]:checked").val()
		if (selected=="Today"){
			exportToday();
		}else if (selected=="Closing Date"){
			exportClosing();			
		}else{
			exportOrder();
		}
		e.preventDefault();
		e.stopPropagation();
	})
	
	
	function exportToday(){
		var url= "/portal/recruiter/export_job_order.php?today=1";
		var inhouse_staff = $("#inhouse-staff").val();
		url += ("&inhouse_staff="+inhouse_staff);
		window.location.href = url;	
	}
	
	
	function exportClosing(){
		var inhouse_staff = $("#inhouse-staff").val();
		var date_from = jQuery("#close-date-from").val();
		var date_to = jQuery("#close-date-to").val();
		var order_status = jQuery("#order-status").val();
		var url = "/portal/recruiter/export_job_order.php?send=1&closing=1";
		if (jQuery.trim(date_from)!=""&&jQuery.trim(date_to)!=""){
			url+=("&date_from="+date_from);
			url+=("&date_to="+date_to);
		}
		url+=("&order_status="+1);
		url += ("&inhouse_staff="+inhouse_staff);
		window.location.href = url;
	}
	
	function exportOrder(){
		var inhouse_staff = $("#inhouse-staff").val();
		var date_from = jQuery("#date-from").val();
		var date_to = jQuery("#date-to").val();
		var order_status = jQuery("#order-status").val();
		var url = "/portal/recruiter/export_job_order.php?send=1";
		if (jQuery.trim(date_from)!=""&&jQuery.trim(date_to)!=""){
			url+=("&date_from="+date_from);
			url+=("&date_to="+date_to);
		}
		url+=("&order_status="+order_status);
		url += ("&inhouse_staff="+inhouse_staff);
		window.location.href = url;
	}
	
	
	jQuery('#myTab a').click(function (e) {
		  currenTab = jQuery(this).attr("data-type");
		  e.preventDefault();
		  jQuery(this).tab('show');
	});
	 jQuery('#myTab a:first').tab('show');
	 
	 
	jQuery("#today_button").click(function(e){
		countTodayGrid();
		e.preventDefault();
		e.stopPropagation();
	})
	 
	jQuery("#filter-form").submit(function(){
		filterGrid();
		return false;
	});
	 
	
	function createOverlay(){
		if (jQuery("#rs-preloader").length==0){
			var orderStatus = jQuery(".tab-content");
			var overlay = "<div id='rs-preloader' class='rs-preloader overlay' style='z-index:1'><img src='../images/ajax-loader.gif'/></div>";
			jQuery(overlay).appendTo("body").css("height", (orderStatus.height()+10)+"px").css("width", orderStatus.width()+"px").css({opacity:0.5}).css("top", "570px").children("img").css("top", ((orderStatus.height()+10)-32)/2+"px").css("position", "relative");	
			
		}
	}
	function removeOverlay(){
		jQuery("#rs-preloader").remove();
	}
	
	function renderCounts(data, today, closing, selected_tab){
		
		if (typeof selected_tab == "undefined"){
			selected_tab = "staffing_consultant_tab";
		}
		
		var totalASL = 0;
		var totalCustom = 0;
		var totalBackOrder = 0;
		var totalInhouse = 0;
		var totalReplacement = 0;
		var totalTotal = 0;
		var date_from = "";
		var date_to = "";
		var inhouse_staff = $("#inhouse-staff").val();
		if (today==undefined){
			today = false;
		}
		if (closing==undefined){
			closing = false;
		}
		var link = "/portal/recruiter/load_job_posting_details.php?filter_type=3&inhouse_staff="+inhouse_staff;
		if (closing){
			date_from = jQuery("#close-date-from").val();
			date_to = jQuery("#close-date-to").val();
		}else{
			date_from = jQuery("#date-from").val();
			date_to = jQuery("#date-to").val();
				
		}
		var order_status = jQuery("#order-status").val();
		var href = "";
			
		jQuery.each(data.dataLoaded, function(i, item){
			
			if (item.recruiter_id!=undefined){
				item.manager_id = item.recruiter_id;
			}
			
			
			if (today){
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=2&recruiters=no_rec&order_status=0' class='launch_details'>"+item.asl+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=2&hiring_coordinator=nohm&order_status=0' class='launch_details'>"+item.asl+"</a>";
						
					}
					jQuery("#"+selected_tab).find(".asl-cell-"+item.manager_id).html(href);	
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=2&recruiters="+item.manager_id+"&order_status=0' class='launch_details'>"+item.asl+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=2&hiring_coordinator="+item.manager_id+"&order_status=0' class='launch_details'>"+item.asl+"</a>";
					}
					jQuery("#"+selected_tab).find(".asl-cell-"+item.manager_id).html(href);	
				}
			}else if (closing){
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=2&recruiters=no_rec&closing=1' class='launch_details'>"+item.asl+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=2&hiring_coordinator=nohm&closing=1' class='launch_details'>"+item.asl+"</a>";
					}
					jQuery("#"+selected_tab).find(".asl-cell-"+item.manager_id).html(href);
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=2&recruiters="+item.manager_id+"&closing=1' class='launch_details'>"+item.asl+"</a>";	
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=2&hiring_coordinator="+item.manager_id+"&closing=1' class='launch_details'>"+item.asl+"</a>";
					}
					jQuery("#"+selected_tab).find(".asl-cell-"+item.manager_id).html(href);					
				}
			}else{
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=2&recruiters=no_rec' class='launch_details'>"+item.asl+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=2&hiring_coordinator=nohm' class='launch_details'>"+item.asl+"</a>";
					}
					jQuery("#"+selected_tab).find(".asl-cell-"+item.manager_id).html(href);
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=2&recruiters="+item.manager_id+"' class='launch_details'>"+item.asl+"</a>";
						
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=2&hiring_coordinator="+item.manager_id+"' class='launch_details'>"+item.asl+"</a>";
					}
					jQuery("#"+selected_tab).find(".asl-cell-"+item.manager_id).html(href);					
				}
			}
			totalASL += parseInt(item.asl);
			if (today){
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=1&recruiters=no_rec&order_status=0' class='launch_details'>"+item.custom+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=1&hiring_coordinator=nohm&order_status=0' class='launch_details'>"+item.custom+"</a>";
					}
					jQuery("#"+selected_tab).find(".custom-cell-"+item.manager_id).html(href);
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=1&recruiters="+item.manager_id+"&order_status=0' class='launch_details'>"+item.custom+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=1&hiring_coordinator="+item.manager_id+"&order_status=0' class='launch_details'>"+item.custom+"</a>";
					}
					jQuery("#"+selected_tab).find(".custom-cell-"+item.manager_id).html(href);	
				}
				
			}else if (closing){
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=1&recruiters=no_rec&closing=1' class='launch_details'>"+item.custom+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=1&hiring_coordinator=nohm&closing=1' class='launch_details'>"+item.custom+"</a>";
					}
					jQuery("#"+selected_tab).find(".custom-cell-"+item.manager_id).html(href);
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=1&recruiters="+item.manager_id+"&closing=1' class='launch_details'>"+item.custom+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=1&hiring_coordinator="+item.manager_id+"&closing=1' class='launch_details'>"+item.custom+"</a>";
					}
					jQuery("#"+selected_tab).find(".custom-cell-"+item.manager_id).html(href);					
				}
			}else{
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=1&recruiters=no_rec' class='launch_details'>"+item.custom+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=1&hiring_coordinator=nohm' class='launch_details'>"+item.custom+"</a>";
					}
					jQuery("#"+selected_tab).find(".custom-cell-"+item.manager_id).html(href);
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=1&recruiters="+item.manager_id+"' class='launch_details'>"+item.custom+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=1&hiring_coordinator="+item.manager_id+"' class='launch_details'>"+item.custom+"</a>";
					}
					jQuery("#"+selected_tab).find(".custom-cell-"+item.manager_id).html(href);	
				}
				
			}
			totalCustom += parseInt(item.custom);
			if (today){
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=3&recruiters=no_rec&order_status=0' class='launch_details'>"+item.backorder+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=3&hiring_coordinator=nohm&order_status=0' class='launch_details'>"+item.backorder+"</a>";	
					}
					
					jQuery("#"+selected_tab).find(".backorder-cell-"+item.manager_id).html(href);
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=3&recruiters="+item.manager_id+"&order_status=0' class='launch_details'>"+item.backorder+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=3&hiring_coordinator="+item.manager_id+"&order_status=0' class='launch_details'>"+item.backorder+"</a>";
					}
					jQuery("#"+selected_tab).find(".backorder-cell-"+item.manager_id).html(href);
				}
			}else if (closing){
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=3&recruiters=no_rec&closing=1' class='launch_details'>"+item.backorder+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=3&hiring_coordinator=nohm&closing=1' class='launch_details'>"+item.backorder+"</a>";
					}
					jQuery("#"+selected_tab).find(".backorder-cell-"+item.manager_id).html(href);
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=3&recruiters="+item.manager_id+"&closing=1' class='launch_details'>"+item.backorder+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=3&hiring_coordinator="+item.manager_id+"&closing=1' class='launch_details'>"+item.backorder+"</a>";
						
					}
					jQuery("#"+selected_tab).find(".backorder-cell-"+item.manager_id).html(href);					
				}
			}else{
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=3&recruiters=no_rec' class='launch_details'>"+item.backorder+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=3&hiring_coordinator=nohm' class='launch_details'>"+item.backorder+"</a>";
					}
					jQuery("#"+selected_tab).find(".backorder-cell-"+item.manager_id).html(href);
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=3&recruiters="+item.manager_id+"' class='launch_details'>"+item.backorder+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=3&hiring_coordinator="+item.manager_id+"' class='launch_details'>"+item.backorder+"</a>";
					}
					jQuery("#"+selected_tab).find(".backorder-cell-"+item.manager_id).html(href);
				}
			}
			totalBackOrder += parseInt(item.backorder);
			if (today){
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=5&recruiters=no_rec&order_status=0' class='launch_details'>"+item.inhouse+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=5&hiring_coordinator=nohm&order_status=0' class='launch_details'>"+item.inhouse+"</a>";
					}
					jQuery("#"+selected_tab).find(".inhouse-cell-"+item.manager_id).html(href);
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=5&recruiters="+item.manager_id+"&order_status=0' class='launch_details'>"+item.inhouse+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=5&hiring_coordinator="+item.manager_id+"&order_status=0' class='launch_details'>"+item.inhouse+"</a>";
					}
					jQuery("#"+selected_tab).find(".inhouse-cell-"+item.manager_id).html(href);
				}
			}else if (closing){
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=5&recruiters=no_rec&closing=1' class='launch_details'>"+item.inhouse+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=5&hiring_coordinator=nohm&closing=1' class='launch_details'>"+item.inhouse+"</a>";
					}
					jQuery("#"+selected_tab).find(".inhouse-cell-"+item.manager_id).html(href);
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=5&recruiters="+item.manager_id+"&closing=1' class='launch_details'>"+item.inhouse+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=5&hiring_coordinator="+item.manager_id+"&closing=1' class='launch_details'>"+item.inhouse+"</a>";
					}
					jQuery("#"+selected_tab).find(".inhouse-cell-"+item.manager_id).html(href);					
				}
			}else{
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=5&recruiters=no_rec' class='launch_details'>"+item.inhouse+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=5&hiring_coordinator=nohm' class='launch_details'>"+item.inhouse+"</a>";
					}
					jQuery("#"+selected_tab).find(".inhouse-cell-"+item.manager_id).html(href);
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=5&recruiters="+item.manager_id+"' class='launch_details'>"+item.inhouse+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=5&hiring_coordinator="+item.manager_id+"' class='launch_details'>"+item.inhouse+"</a>";
					}
					jQuery("#"+selected_tab).find(".inhouse-cell-"+item.manager_id).html(href);
				}
			}
			totalInhouse += parseInt(item.inhouse);
			
			
			
			if (today){
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=4&recruiters=no_rec&order_status=0' class='launch_details'>"+item.replacement+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=4&hiring_coordinator=nohm&order_status=0' class='launch_details'>"+item.replacement+"</a>";
					}
					jQuery("#"+selected_tab).find(".replacement-cell-"+item.manager_id).html(href);
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=4&recruiters="+item.manager_id+"&order_status=0' class='launch_details'>"+item.replacement+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=4&hiring_coordinator="+item.manager_id+"&order_status=0' class='launch_details'>"+item.replacement+"</a>";
					}
					jQuery("#"+selected_tab).find(".replacement-cell-"+item.manager_id).html(href);					
				}

			}else if (closing){
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=4&recruiters=no_rec&closing=1' class='launch_details'>"+item.replacement+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=4&hiring_coordinator=nohm&closing=1' class='launch_details'>"+item.replacement+"</a>";
					}
					jQuery("#"+selected_tab).find(".replacement-cell-"+item.manager_id).html(href);
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=4&recruiters="+item.manager_id+"&closing=1' class='launch_details'>"+item.replacement+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=4&hiring_coordinator="+item.manager_id+"&closing=1' class='launch_details'>"+item.replacement+"</a>";					
					}
					jQuery("#"+selected_tab).find(".replacement-cell-"+item.manager_id).html(href);					
				}
			}else{
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=4&recruiters=no_rec' class='launch_details'>"+item.replacement+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=4&hiring_coordinator=nohm' class='launch_details'>"+item.replacement+"</a>";
					}
					jQuery("#"+selected_tab).find(".replacement-cell-"+item.manager_id).html(href);
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=4&recruiters="+item.manager_id+"' class='launch_details'>"+item.replacement+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=4&hiring_coordinator="+item.manager_id+"' class='launch_details'>"+item.replacement+"</a>";
					}
					jQuery("#"+selected_tab).find(".replacement-cell-"+item.manager_id).html(href);	
				}
				
			}
			totalReplacement += parseInt(item.replacement);
			
			if (today){
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=0&recruiters=no_rec&order_status=0' class='launch_details'>"+item.total+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=0&hiring_coordinator=nohm&order_status=0' class='launch_details'>"+item.total+"</a>";
					}
					jQuery("#"+selected_tab).find(".total-cell-"+item.manager_id).html(href);
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=0&recruiters="+item.manager_id+"&order_status=0' class='launch_details'>"+item.total+"</a>";					
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=0&hiring_coordinator="+item.manager_id+"&order_status=0' class='launch_details'>"+item.total+"</a>";
					}
					jQuery("#"+selected_tab).find(".total-cell-"+item.manager_id).html(href);					
				}
			}else if (closing){
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=0&recruiters=no_rec&closing=1' class='launch_details'>"+item.total+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=0&hiring_coordinator=nohm&closing=1' class='launch_details'>"+item.total+"</a>";
					}
					jQuery("#"+selected_tab).find(".total-cell-"+item.manager_id).html(href);
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=0&recruiters="+item.manager_id+"&closing=1' class='launch_details'>"+item.total+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=0&hiring_coordinator="+item.manager_id+"&closing=1' class='launch_details'>"+item.total+"</a>";
					}
					jQuery("#"+selected_tab).find(".total-cell-"+item.manager_id).html(href);					
				}
			}else{
				if (item.manager_id==0){
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=0&recruiters=no_rec' class='launch_details'>"+item.total+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=0&hiring_coordinator=nohm' class='launch_details'>"+item.total+"</a>";
					}
					jQuery("#"+selected_tab).find(".total-cell-"+item.manager_id).html(href);
				}else{
					if (selected_tab=="recruiters_tab"){
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=0&recruiters="+item.manager_id+"' class='launch_details'>"+item.total+"</a>";
					}else{
						href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=0&hiring_coordinator="+item.manager_id+"' class='launch_details'>"+item.total+"</a>";
					}
					jQuery("#"+selected_tab).find(".total-cell-"+item.manager_id).html(href);	
				}
			}
			totalTotal += parseInt(item.total);
		})
		
		
		
		totalTotal = 0;
		totalReplacement = 0;
		totalInhouse = 0;
		totalBackOrder = 0;
		totalCustom = 0;
		totalASL = 0;
		jQuery.each(data.dataLoaded, function(i, item){
			totalTotal += parseInt(item.total);
			totalReplacement += parseInt(item.replacement);
			totalInhouse += parseInt(item.inhouse);
			totalBackOrder += parseInt(item.backorder);
			totalCustom += parseInt(item.custom);
			totalASL += parseInt(item.asl);
		});
		
		if (selected_tab=="staffing_consultant_tab"){
			if (today){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=2&hiring_coordinator=&order_status=0' class='launch_details'>"+totalASL+"</a>";
				jQuery("#total-asl").html(href);	
			}else if (closing){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=2&hiring_coordinator=&order_status=0&closing=1' class='launch_details'>"+totalASL+"</a>";
				jQuery("#total-asl").html(href);	
			}else{
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=2&hiring_coordinator=' class='launch_details'>"+totalASL+"</a>";
				jQuery("#total-asl").html(href);	
			}
			
			if (today){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=1&hiring_coordinator=&order_status=0' class='launch_details'>"+totalCustom+"</a>";
				jQuery("#total-custom").html(href);	
			}else if (closing){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=1&hiring_coordinator=&order_status=0&closing=1' class='launch_details'>"+totalCustom+"</a>";
				jQuery("#total-custom").html(href);	
			}else{
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=1&hiring_coordinator=' class='launch_details'>"+totalCustom+"</a>";
				jQuery("#total-custom").html(href);	
			}
			if (today){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=3&hiring_coordinator=&order_status=0' class='launch_details'>"+totalBackOrder+"</a>";
				jQuery("#total-backorder").html(href);	
			}else if (closing){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=3&hiring_coordinator=&order_status=0&closing=1' class='launch_details'>"+totalBackOrder+"</a>";
				jQuery("#total-backorder").html(href);	
			}else{
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=1&hiring_coordinator=' class='launch_details'>"+totalBackOrder+"</a>";
				jQuery("#total-backorder").html(href);	
			}
			if (today){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=4&hiring_coordinator=&order_status=0' class='launch_details'>"+totalReplacement+"</a>";
				jQuery("#total-replacement").html(href);	
			}else if (closing){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=4&hiring_coordinator=&order_status=0&closing=1' class='launch_details'>"+totalReplacement+"</a>";
				jQuery("#total-replacement").html(href);	
			}else{
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=4&hiring_coordinator=' class='launch_details'>"+totalReplacement+"</a>";
				jQuery("#total-replacement").html(href);	
			}
			if (today){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=5&hiring_coordinator=&order_status=0' class='launch_details'>"+totalInhouse+"</a>";
				jQuery("#total-inhouse").html(href);	
			}else if (closing){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=5&hiring_coordinator=&order_status=0&closing=1' class='launch_details'>"+totalInhouse+"</a>";
				jQuery("#total-inhouse").html(href);	
			}else{
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=5&hiring_coordinator=' class='launch_details'>"+totalInhouse+"</a>";
				jQuery("#total-inhouse").html(href);	
			}
			if (today){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=0&hiring_coordinator=&order_status=0' class='launch_details'>"+totalTotal+"</a>";
				jQuery("#total-total").html(href);	
			}else if (closing){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=0&hiring_coordinator=&closing=1' class='launch_details'>"+totalTotal+"</a>";
				jQuery("#total-total").html(href);	
			}else{
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=0&hiring_coordinator=' class='launch_details'>"+totalTotal+"</a>";
				jQuery("#total-total").html(href);	
			}
		}else{
			
			if (today){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=2&recruiters=&order_status=0' class='launch_details'>"+totalASL+"</a>";
				jQuery("#total-recruiter-asl").html(href);	
			}else if (closing){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=2&recruiters=&order_status=0&closing=1' class='launch_details'>"+totalASL+"</a>";
				jQuery("#total-recruiter-asl").html(href);	
			}else{
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=2&recruiters=' class='launch_details'>"+totalASL+"</a>";
				jQuery("#total-recruiter-asl").html(href);	
			}
			
			if (today){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=1&hiring_coordinator=&order_status=0' class='launch_details'>"+totalCustom+"</a>";
				jQuery("#total-recruiter-custom").html(href);	
			}else if (closing){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=1&hiring_coordinator=&order_status=0&closing=1' class='launch_details'>"+totalCustom+"</a>";
				jQuery("#total-recruiter-custom").html(href);	
			}else{
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=1&hiring_coordinator=' class='launch_details'>"+totalCustom+"</a>";
				jQuery("#total-recruiter-custom").html(href);	
			}
			if (today){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=3&hiring_coordinator=&order_status=0' class='launch_details'>"+totalBackOrder+"</a>";
				jQuery("#total-recruiter-backorder").html(href);	
			}else if (closing){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=3&hiring_coordinator=&order_status=0&closing=1' class='launch_details'>"+totalBackOrder+"</a>";
				jQuery("#total-recruiter-backorder").html(href);	
			}else{
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=1&hiring_coordinator=' class='launch_details'>"+totalBackOrder+"</a>";
				jQuery("#total-recruiter-backorder").html(href);	
			}
			if (today){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=4&hiring_coordinator=&order_status=0' class='launch_details'>"+totalReplacement+"</a>";
				jQuery("#total-recruiter-replacement").html(href);	
			}else if (closing){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=4&hiring_coordinator=&order_status=0&closing=1' class='launch_details'>"+totalReplacement+"</a>";
				jQuery("#total-recruiter-replacement").html(href);	
			}else{
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=4&hiring_coordinator=' class='launch_details'>"+totalReplacement+"</a>";
				jQuery("#total-recruiter-replacement").html(href);	
			}
			if (today){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=5&hiring_coordinator=&order_status=0' class='launch_details'>"+totalInhouse+"</a>";
				jQuery("#total-recruiter-inhouse").html(href);	
			}else if (closing){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=5&hiring_coordinator=&order_status=0&closing=1' class='launch_details'>"+totalInhouse+"</a>";
				jQuery("#total-recruiter-inhouse").html(href);	
			}else{
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=5&hiring_coordinator=' class='launch_details'>"+totalInhouse+"</a>";
				jQuery("#total-recruiter-inhouse").html(href);	
			}
			if (today){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&today=1&service_type=0&hiring_coordinator=&order_status=0' class='launch_details'>"+totalTotal+"</a>";
				jQuery("#total-recruiter-total").html(href);	
			}else if (closing){
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=0&hiring_coordinator=&closing=1' class='launch_details'>"+totalTotal+"</a>";
				jQuery("#total-recruiter-total").html(href);	
			}else{
				href = "<a href='"+link+"&date_from="+date_from+"&date_to="+date_to+"&order_status="+order_status+"&service_type=0&hiring_coordinator=' class='launch_details'>"+totalTotal+"</a>";
				jQuery("#total-recruiter-total").html(href);	
			}
		}

		removeOverlay();
	}
	
	
	function filterGrid(){
		var selected = jQuery("input[name=selected]:checked").val();
		if (currentTab=="staffing_consultant_tab"){
			if (selected=="Today"){
				countTodayGrid();
				countTodayGridRecruiter();
			}else if (selected=="Closing Date"){
				filterCloseDate();
				filterCloseDateRecruiter();
			}else{
				filterOrderDate();
				filterOrderDateRecruiter();
			}			
		}else{
			if (selected=="Today"){
				countTodayGridRecruiter();
				countTodayGrid();
			}else if (selected=="Closing Date"){
				filterCloseDateRecruiter();
				filterCloseDate();
			}else{
				filterOrderDateRecruiter();
				filterOrderDate();
			}
		}
	} 
	
	
	function filterCloseDate(){
		var inhouse_staff = $("#inhouse-staff").val();
		var date_from = jQuery("#close-date-from").val();
		var date_to = jQuery("#close-date-to").val();
		var order_status = jQuery("#order-status").val();
		var url = "/portal/recruiter/load_job_order_counters.php?send=1&closing=1";
		if (jQuery.trim(date_from)!=""&&jQuery.trim(date_to)!=""){
			url+=("&date_from="+date_from);
			url+=("&date_to="+date_to);
		}
		url+=("&order_status="+1);
		url += ("&inhouse_staff="+inhouse_staff);
		createOverlay();
		jQuery.get(url, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				renderCounts(data, false, true);
			}
		});
		
	}
	function filterCloseDateRecruiter(){
		var inhouse_staff = $("#inhouse-staff").val();
		var date_from = jQuery("#close-date-from").val();
		var date_to = jQuery("#close-date-to").val();
		var order_status = jQuery("#order-status").val();
		var url = "/portal/recruiter/load_job_order_counters_recruiters.php?send=1&closing=1";
		if (jQuery.trim(date_from)!=""&&jQuery.trim(date_to)!=""){
			url+=("&date_from="+date_from);
			url+=("&date_to="+date_to);
		}
		url+=("&order_status="+1);
		url += ("&inhouse_staff="+inhouse_staff);
		createOverlay();
		jQuery.get(url, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				renderCounts(data, false, true, "recruiters_tab");
			}
		});
		
	}
	
	
	function filterOrderDate(){
		var inhouse_staff = $("#inhouse-staff").val();
		var date_from = jQuery("#date-from").val();
		var date_to = jQuery("#date-to").val();
		var order_status = jQuery("#order-status").val();
		
		var url = "/portal/recruiter/load_job_order_counters.php?send=1";
		
		if (jQuery.trim(date_from)!=""&&jQuery.trim(date_to)!=""){
			url+=("&date_from="+date_from);
			url+=("&date_to="+date_to);
		}
		url+=("&order_status="+order_status);
		url += ("&inhouse_staff="+inhouse_staff);
		createOverlay();
		jQuery.get(url, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				renderCounts(data);
			}
		});
	}
	
	function filterOrderDateRecruiter(){
		var inhouse_staff = $("#inhouse-staff").val();
		var date_from = jQuery("#date-from").val();
		var date_to = jQuery("#date-to").val();
		var order_status = jQuery("#order-status").val();
		
		var url = "/portal/recruiter/load_job_order_counters_recruiters.php?send=1";
		
		if (jQuery.trim(date_from)!=""&&jQuery.trim(date_to)!=""){
			url+=("&date_from="+date_from);
			url+=("&date_to="+date_to);
		}
		url+=("&order_status="+order_status);
		url+=("&inhouse_staff="+inhouse_staff);
		createOverlay();
		jQuery.get(url, function(data){
			data = jQuery.parseJSON(data);
			console.log(data);
			if (data.success){
				renderCounts(data, false, false, "recruiters_tab");
			}
		});
	}
	
	function countTodayGrid(){
		var inhouse_staff = $("#inhouse-staff").val();
		var url = "/portal/recruiter/load_job_order_counters.php?send=1&today=1";
		url += ("&inhouse_staff="+inhouse_staff);
		createOverlay();
		jQuery.get(url, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				renderCounts(data, true);
			}
		});
	}
	
	function countTodayGridRecruiter(){
		var inhouse_staff = $("#inhouse-staff").val();
		var url = "/portal/recruiter/load_job_order_counters_recruiters.php?send=1&today=1";
		url += ("&inhouse_staff="+inhouse_staff);
		createOverlay();
		jQuery.get(url, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				renderCounts(data, true, false, "recruiters_tab");
			}
		});
	}
	
	countTodayGrid();
	countTodayGridRecruiter();
	
	jQuery(".selector").click(function(){
		var selected = jQuery("input[name=selected]:checked").val();
		if (selected=="Today"){
			jQuery("#today_button").removeAttr('disabled');
			jQuery("#close-date-from").attr("disabled", "disabled");
			jQuery("#close-date-to").attr("disabled", "disabled");
			jQuery("#order-status").attr("disabled", "disabled");
			jQuery("#date-from").attr("disabled", "disabled");
			jQuery("#date-to").attr("disabled", "disabled");
			
		}else if (selected=="Closing Date"){
			jQuery("#today_button").attr('disabled', "disabled");
			jQuery("#close-date-from").removeAttr("disabled", "disabled");
			jQuery("#close-date-to").removeAttr("disabled", "disabled");
			jQuery("#order-status").attr("disabled", "disabled");
			jQuery("#date-from").attr("disabled", "disabled");
			jQuery("#date-to").attr("disabled", "disabled");
			
		}else{
			jQuery("#today_button").attr('disabled', "disabled");
			jQuery("#close-date-from").attr("disabled", "disabled");
			jQuery("#close-date-to").attr("disabled", "disabled");
			jQuery("#order-status").removeAttr("disabled", "disabled");
			jQuery("#date-from").removeAttr("disabled", "disabled");
			jQuery("#date-to").removeAttr("disabled", "disabled");
		}
			
		
	});
	
	
	var dateFrom = jQuery("#date-from").val();
	var dateTo = jQuery("#date-to").val();
	var closingDateFrom = jQuery("#close-date-from").val();
	var closingDateTo = jQuery("#close-date-to").val();
	
	jQuery("#close-date-from").datepicker();
	jQuery("#close-date-to").datepicker();
	jQuery("#close-date-from").datepicker("option", "dateFormat", "yy-mm-dd").datepicker("setDate", closingDateFrom);
	jQuery("#close-date-to").datepicker("option", "dateFormat", "yy-mm-dd").datepicker("setDate", closingDateTo);
	jQuery("#date-from").datepicker();
	jQuery("#date-to").datepicker();
	jQuery("#date-from").datepicker("option", "dateFormat", "yy-mm-dd").datepicker("setDate", dateFrom);
	jQuery("#date-to").datepicker("option", "dateFormat", "yy-mm-dd").datepicker("setDate", dateTo);
	
	
});


	
jQuery(document).on("click", ".launch_details", function(e){
	var href = jQuery(this).attr("href");
	window.open(href,'_blank','width=700,height=600,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
	e.preventDefault();
});
