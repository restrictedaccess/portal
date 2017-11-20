jQuery(document).ready(function(){
	
	jQuery(".contacted").live("click", function(){
		var id = jQuery(this).attr("data-id");
		if (jQuery(this).is(":checked")){
			jQuery.post("/portal/recruiter/update_referral_contacted.php", {id:id, contacted:1}, function(data){});			
		}else{
			jQuery.post("/portal/recruiter/update_referral_contacted.php", {id:id, contacted:0}, function(data){});	
		}
	})
	
	jQuery("#filter-type").change(function(){
		var value = jQuery(this).val();
		if (value=="1"){
			jQuery("#filter-container").html("<input type='text' id='date_from' name='date_from' placeholder='Date From'/><input type='text' id='date_to' name='date_to' placeholder='Date To'/>");
			jQuery("#date_from").datepicker();
			jQuery("#date_to").datepicker();
			jQuery("#date_from").datepicker("option", "dateFormat", "yy-mm-dd");
			jQuery("#date_to").datepicker("option", "dateFormat", "yy-mm-dd");
		}else{
			jQuery("#filter-container").html("");
		}
	});
	
	jQuery("#searchButton").button().click(function(){
		var url="/portal/recruiter/load_referrals.php?search";
		if (jQuery.trim(jQuery("#date_from").val())!=""){
			url+=("&date_from="+jQuery.trim(jQuery("#date_from").val()));
		}
		if (jQuery.trim(jQuery("#date_to").val())!=""){
			url+=("&date_to="+jQuery.trim(jQuery("#date_to").val()));
		}
		url+=("&filter_type="+jQuery.trim(jQuery("#filter-type").val()));
		if (jQuery.trim(jQuery("#text-search").val())!=""){
			url+=("&filter_text="+jQuery.trim(jQuery("#text-search").val()));
		}
		url+=("&status="+jQuery("#refer_type").val())
		jQuery("#referral-sheet").jqGrid().setGridParam({url : url}).trigger("reloadGrid");
	});
	
	var fixPositionsOfFrozenDivs = function () {
        var jQueryrows;
        if (typeof this.grid.fbDiv !== "undefined") {
            jQueryrows = jQuery('>div>table.ui-jqgrid-btable>tbody>tr', this.grid.bDiv);
            jQuery('>table.ui-jqgrid-btable>tbody>tr', this.grid.fbDiv).each(function (i) {
                var rowHight = jQuery(jQueryrows[i]).height(), rowHightFrozen = jQuery(this).height();
                if (jQuery(this).hasClass("jqgrow")) {
                    jQuery(this).height(rowHight);
                    rowHightFrozen = jQuery(this).height();
                    if (rowHight !== rowHightFrozen) {
                        jQuery(this).height(rowHight + (rowHight - rowHightFrozen));
                    }
                }
            });
            jQuery(this.grid.fbDiv).height(this.grid.bDiv.clientHeight);
            jQuery(this.grid.fbDiv).css(jQuery(this.grid.bDiv).position());
        }
        if (typeof this.grid.fhDiv !== "undefined") {
            jQueryrows = jQuery('>div>table.ui-jqgrid-htable>thead>tr', this.grid.hDiv);
            jQuery('>table.ui-jqgrid-htable>thead>tr', this.grid.fhDiv).each(function (i) {
                var rowHight = jQuery(jQueryrows[i]).height(), rowHightFrozen = jQuery(this).height();
                jQuery(this).height(rowHight);
                rowHightFrozen = jQuery(this).height();
                if (rowHight !== rowHightFrozen) {
                    jQuery(this).height(rowHight + (rowHight - rowHightFrozen));
                }
            });
            jQuery(this.grid.fhDiv).height(this.grid.hDiv.clientHeight);
            jQuery(this.grid.fhDiv).css(jQuery(this.grid.hDiv).position());
        }
    };
    
    function renderReferee(value, options, row){
    	//console.log(row.referee);
    	if ((jQuery.trim(row.referee)!="")&&(row.referee!=undefined)){
        	return "<a href='/portal/recruiter/staff_information.php?userid="+row.referee_id+"' target='_blank'>"+row.referee_id+" "+row.referee+"</a>";    		
    	}else{
    		return "";
    	}

    }
    
    function renderReferral(value, options, row){
    	//console.log(row.referee);
    	return row.fullname;

    }
    
    
        
    
    
    function renderContacted(value, options, row){
    	if (row.contacted==1){
    		return "<input type='checkbox' class='contacted' data-id='"+row.id+"' checked/>";
    	}else{
    		return "<input type='checkbox' class='contacted' data-id='"+row.id+"'/>";
    	}
    }
    function renderConverted(value, options, row){
    	if (row.jobseeker_id!=undefined&&row.jobseeker_id!=null){
    		return "<input type='checkbox' class='convert_job_seeker' data-id='"+row.id+"' checked/>";
    	}else{
    		return "<input type='checkbox' class='convert_job_seeker' data-id='"+row.id+"'/>";
    	}
    }
    
    
    jQuery(".convert_job_seeker").live("click", function(){
    	var referralId = jQuery(this).attr("data-id");
    	if (jQuery(this).is(":checked")){
	    	popup_win("/portal/candidates/?referral_id="+referralId+"&type=popup", 800, 600);	
    	}else{
    		jQuery(this).attr("checked", "checked");
    	}
    	
    })
	
	
	
	var width = 1300;
	var recruitmentSheet = jQuery("#referral-sheet").jqGrid({
		datatype:"json",
		forceFit:false,
		shrinkToFit:false,
		rownumbers:true,
		viewrecords:true,
		width:width,
		hoverrows:false,
		rowNum:50,
		height:450,
		repeatitems: false,
		gridview:true,
		jsonReader:{
			 root: "rows", 
		     page: "page", 
		     total: "total", 
		     records: "records", 
		     repeatitems: false, 
		     cell: "cell", 
		     id: "id", 
		     		},
		pager:"#pager",
		resizeStop:fixPositionsOfFrozenDivs,
		loadComplete:fixPositionsOfFrozenDivs,
		
		url:"/portal/recruiter/load_referrals.php",
		//colNames:['Job Title','Work Status', 'Date Filled', 'Date When Staff is Required','Client','Work Time Zone','Budget', "Notes and Comments", "Assigned Recruiter", "Assigned Hiring Coordinator", "Job Specification List", "Shortlisted", "Endorsed", "Interviewed", "Hired", "Rejected", "Service Type", "Order Status"],
		colNames:['Full Name','Position', 'Email Address', 'Contact Number', 'Referee', "Date Referred","Referral Status", "Status", "Contacted", "Convert to Jobseeker"],
		colModel:[
		          	{name:"fullname",  width:200,  sortable:false, formatter:renderReferral},
		          	{name:"position", sortable:false},
		          	{name:"email", width:150,sortable:false},
		          	{name:"contactnumber",  sortable:false},
		          	{name:"referee", width:150, sortable:false, formatter:renderReferee},
		          	{name:"date_created", width:120, sortable:false},
		          	{name:"referral_status", width:75, sortable:false},
		          	{name:"status", width:75, sortable:false},
		          	{name:"contacted", width:75, formatter:renderContacted, align:"center"},
		         	{name:"converted", formatter:renderConverted, align:"center"}
		         
		         
		         ],
		
	}).jqGrid('destroyFrozenColumns').jqGrid('setFrozenColumns');
});