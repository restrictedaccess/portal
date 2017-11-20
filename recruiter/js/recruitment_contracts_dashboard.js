jQuery(document).ready(function(){
	
	var currentTab = "contract_status";
	
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
	
	function createLink(date_from, date_to, item, service_type, contract_status, inhouse_staff, all){
		var link = "";
		if (all!=undefined){
			link = "/portal/recruiter/load_contracts_details.php?recruiter_id=All&service_type="+service_type;
		}else{
			link = "/portal/recruiter/load_contracts_details.php?recruiter_id="+item.admin_id+"&service_type="+service_type;
		}
		if (jQuery.trim(date_from)!=""&&jQuery.trim(date_to)!=""){
			link+=("&date_from="+date_from);
			link+=("&date_to="+date_to);
		}
		link+=("&contract_status="+contract_status);
		link+=("&inhouse_staff="+inhouse_staff);
		return link;
	}
	
	function filterGrid(){
		
		var date_from = jQuery("#date_from").val();
		var date_to = jQuery("#date_to").val();
		var contract_status = jQuery("#contract_status").val();
		var inhouse_staff = jQuery("#inhouse_staff").val();
		
		var url = "/portal/recruiter/load_contracts_count.php?send=1";
		
		if (jQuery.trim(date_from)!=""&&jQuery.trim(date_to)!=""){
			url+=("&date_from="+date_from);
			url+=("&date_to="+date_to);
		}
		
		url+=("&contract_status="+contract_status);
		url+=("&inhouse_staff="+inhouse_staff);
		
		createOverlay();
		jQuery.get(url, function(data){
			
			data = jQuery.parseJSON(data);
			
			var totalCustom = 0;
			var totalASL = 0;
			var totalProjectBased = 0;
			var totalTrial = 0;
			var totalBackOrder = 0;
			var totalReplacement = 0;
			var totalInhouse = 0;
			var totalTotal = 0;

			var link = "";
			jQuery.each(data, function(i, item){
			
				totalASL+=parseInt(item.aslcount);				
				link = createLink(date_from, date_to, item, "ASL", contract_status, inhouse_staff);
				jQuery("#asl_"+item.admin_id).html(jQuery("<a href='"+link+"' class='launcher' rel=\"popover\" data-name='"+item.admin_name+"' data-type='ASL'>"+item.aslcount+"</a>"));
				
				totalCustom+=parseInt(item.customcount);
				link = createLink(date_from, date_to, item, "Customs", contract_status, inhouse_staff);
				jQuery("#custom_"+item.admin_id).html("<a href='"+link+"' class='launcher' rel=\"popover\" data-name='"+item.admin_name+"' data-type='Custom'>"+item.customcount+"</a>");
				
				totalReplacement+=parseInt(item.replacementcount);
				link = createLink(date_from, date_to, item, "Replacement", contract_status, inhouse_staff);
				jQuery("#replacement_"+item.admin_id).html("<a href='"+link+"' class='launcher' rel=\"popover\" data-name='"+item.admin_name+"' data-type='Replacement'>"+item.replacementcount+"</a>");	
				
				totalProjectBased+=parseInt(item.projectbasedcount);
				link = createLink(date_from, date_to, item, "Project Based", contract_status, inhouse_staff);
				jQuery("#projectbased_"+item.admin_id).html("<a href='"+link+"' class='launcher' rel=\"popover\" data-name='"+item.admin_name+"' data-type='Project Based'>"+item.projectbasedcount+"</a>");	
				
				totalBackOrder+=parseInt(item.backordercount);
				link = createLink(date_from, date_to, item, "Back Order", contract_status, inhouse_staff);			
				jQuery("#backorder_"+item.admin_id).html("<a href='"+link+"' class='launcher' rel=\"popover\" data-name='"+item.admin_name+"' data-type='Back Order'>"+item.backordercount+"</a>");
				
				totalInhouse+=parseInt(item.inhousecount);
				link = createLink(date_from, date_to, item, "Inhouse", contract_status, inhouse_staff);					
				jQuery("#inhouse_"+item.admin_id).html("<a href='"+link+"' class='launcher' rel=\"popover\" data-name='"+item.admin_name+"' data-type='Inhouse'>"+item.inhousecount+"</a>");
					
				totalTrial+=parseInt(item.trialcount);
				link = createLink(date_from, date_to, item, "Trial", contract_status, inhouse_staff);					
				jQuery("#trial_"+item.admin_id).html("<a href='"+link+"' class='launcher' rel=\"popover\" data-name='"+item.admin_name+"' data-type='Trial'>"+item.trialcount+"</a>");
				
				totalTotal+=parseInt(item.totalcount);
				link = createLink(date_from, date_to, item, "All", contract_status, inhouse_staff);						
				jQuery("#total_"+item.admin_id).html("<a href='"+link+"' class='launcher' rel=\"popover\" data-name='"+item.admin_name+"' data-type='All'>"+item.totalcount+"</a>");	
						
			});
			
			
			link = createLink(date_from, date_to, null, "ASL", contract_status, inhouse_staff, true);
			jQuery("#total_asl").html("<a href='"+link+"' class='launcher' rel=\"popover\" data-name='All' data-type='ASL'>"+totalASL+"</a>");
			
			link = createLink(date_from, date_to, null, "Customs", contract_status, inhouse_staff, true);
			jQuery("#total_custom").html("<a href='"+link+"' class='launcher' rel=\"popover\" data-name='All' data-type='Custom'>"+totalCustom+"</a>");
			
			link = createLink(date_from, date_to, null, "Back Order", contract_status, inhouse_staff, true);
			jQuery("#total_backorder").html("<a href='"+link+"' class='launcher' rel=\"popover\" data-name='All' data-type='BackOrder'>"+totalBackOrder+"</a>");
			
			link = createLink(date_from, date_to, null, "Replacement", contract_status, inhouse_staff, true);
			jQuery("#total_replacement").html("<a href='"+link+"' class='launcher' rel=\"popover\" data-name='All' data-type='Replacement'>"+totalReplacement+"</a>");
			
			link = createLink(date_from, date_to, null, "Project Based", contract_status, inhouse_staff, true);
			jQuery("#total_projectbased").html("<a href='"+link+"' class='launcher' rel=\"popover\" data-name='All' data-type='Project Based'>"+totalProjectBased+"</a>");
			
			link = createLink(date_from, date_to, null, "Inhouse", contract_status, inhouse_staff, true);
			jQuery("#total_inhouse").html("<a href='"+link+"' class='launcher' rel=\"popover\" data-name='All' data-type='Inhouse'>"+totalInhouse+"</a>");
			
			link = createLink(date_from, date_to, null, "Trial", contract_status, inhouse_staff, true);
			jQuery("#total_trial").html("<a href='"+link+"' class='launcher' rel=\"popover\" data-name='All' data-type='Trial'>"+totalTrial+"</a>");
			
			link = createLink(date_from, date_to, null, "All", contract_status, inhouse_staff, true);
			jQuery("#total_total").html("<a href='"+link+"' class='launcher' rel=\"popover\" data-name='All' data-type='All'>"+totalTotal+"</a>");
			removeOverlay();
				
		});
	} 
	
	jQuery(".launcher").live("click", function(e){
		var href = jQuery(this).attr("href")
		window.open(href,'_blank','width=700,height=600,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
		e.preventDefault()
	});
	
	jQuery("#sidepopup .close").live("click", function(){
		jQuery(this).parent().parent().fadeOut(200);
	});
	
	filterGrid();
	
	var dateFrom = jQuery("#date_from").val();
	var dateTo = jQuery("#date_to").val();
	
	jQuery("#date_from").datepicker();
	jQuery("#date_from").datepicker("option", "dateFormat", "yy-mm-dd").datepicker("setDate", dateFrom);
	
	jQuery("#date_to").datepicker();
	jQuery("#date_to").datepicker("option", "dateFormat", "yy-mm-dd").datepicker("setDate", dateTo);
	
});
