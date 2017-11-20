//var rsscRPC = "https://remotestaff.com.au/portal/django/client_subcon_management/jsonrpc/";
//var activityNotesRPC = "https://remotestaff.com.au/portal/client/ClientSubconManagementService.php";
//var ping = "https://remotestaff.com.au/portal/client/ClientSubconManagement20110902/ClientSubconManagement.html";
//var clientRPC = "http://test.remotestaff.com.au/portal/django/client_service/jsonrpc/"
var rsscRPC = "/portal/django/client_subcon_management/jsonrpc/";
var activityNotesRPC = "/portal/client/ClientSubconManagementService.php";
var ping = "/portal/client/ClientSubconManagement20110902/ClientSubconManagement.html";
var clientRPC = "/portal/django/client_service/jsonrpc/"


//These are the loaded screenshots
var loadedScreenshots = []

jQuery(document).ready(function(){
	
	CURRENT_PAGE = "screenshots";
	
	 //add highlight for productivity
    jQuery("#productivity_reports_top").addClass("active");
	
	
	var today = jQuery("#subcon_date_picker").val();
	jQuery("#subcon_date_picker").datepicker();
	jQuery("#subcon_date_picker").datepicker("option", "dateFormat", "yy-mm-dd");
	jQuery("#subcon_date_picker").datepicker("setDate", jQuery.datepicker.parseDate("yy-mm-dd", today));
	jQuery("#load_form").on("submit", function(){
		return false;
	})
	jQuery("#view_screenshot").on("click", function(e){
		refreshScreenshot();
	//	e.preventDefault();
	});
	jQuery.get(ping, function(response){
		
	});
	
	jQuery(".list_view").on("click", function(){
		jQuery("#list_view_pane").show();
		jQuery("#thumbnail_view_pane").hide();
		jQuery("#full_view_pane").hide();		
	});
	jQuery(".thumbnail_view").on("click", function(){
		jQuery("#list_view_pane").hide();
		jQuery("#full_view_pane").hide();
		jQuery("#thumbnail_view_pane").show();
	});
	
	jQuery(".full_view").on("click", function(){
		jQuery("#list_view_pane").hide();
		jQuery("#full_view_pane").show();
		jQuery("#thumbnail_view_pane").hide();
	});
	
	
	jQuery("#full_view_screenshot").hide();		
	
	jQuery("#main_footer").hide();
});
jQuery(document).on("click", ".thumb_to_full", function(e){
	jQuery("#list_view_pane").hide();
	jQuery("#full_view_pane").show();
	jQuery("#thumbnail_view_pane").hide();
	var position = parseInt(jQuery(this).attr("data-position"));
	jQuery("#full_view_screenshot").carousel(position-1);
	e.preventDefault();
});


function refreshScreenshot(){
	var userid = jQuery("#subcon_userid").val();
	var today = jQuery("#subcon_date_picker").val();
	if (jQuery.trim(userid)==""){
		alert("Please select staff to view.");
		return;
	}
	if (jQuery.trim(today)==""){
		alert("Please select date to view.");
		return;
	}
	var data = {json_rpc:2.0, id:"ID8", method:"get_screenshots", params:[today, userid]}
	jQuery("#screenrecording_list").html('<div class="alert alert-info">Loading Screenshot</div>')
	jQuery("#list_view_table tbody").html('<tr><td colspan="4"><div class="alert alert-info">Loading Screenshot</div></td></tr>')
	jQuery("#full_view_screenshot .carousel-indicators").html("");
	jQuery("#full_view_screenshot .carousel-inner").html('');
	jQuery("#full_view_screenshot").hide();		
	loadedScreenshots = [];
	
	jQuery.ajax({
	    url: rsscRPC,
	    type: 'POST',
	    data: JSON.stringify(data),
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    success: function(response) {
	    	var screenshots = response.result.screenshots;
	    	var todisplay = []
	    	
	    	var fullscreen_shots = [];
	    	var listview_output = "";
	    	var fullview_indicator_output = "";
	    	if (screenshots.length>0){
		    	jQuery.each(screenshots, function(i, item){
		    		todisplay.push(item);
		    		listview_output+= "<tr>";
		    		var display_time = item.display_time;
		    		display_time = display_time.split(" ");
		    		
		    		if(item.screen_number == 0){
		    			listview_output+= "<td>"+display_time[1]+" "+display_time[2]+"</td>";	
		    		}else{
		    			listview_output+= "<td>Screen 2</td>";
		    		}
		    		
		    		
		    		listview_output+= "<td><a href='#' data-position='"+i+"' class='thumb_to_full'>"+item.note+"</a></td>";
		    		listview_output+= "<td>"+item.expected_time+"</td>";
		    		listview_output+= "<td>"+item.time_to_respond+"</td>";
		    		listview_output+= "</tr>";
		    		
		    		
		    		fullview_indicator_output += '<li data-target="#full_view_screenshot" data-slide-to="'+i+'"></li>';
		    		
		    		fullscreen_shots.push('/portal/django/client_subcon_management/shots/'+item.year+'/'+item.week+'/'+item.id+'/'+item.screen_number);
		    	})	    		
	    	}
	    	
	    	jQuery("#list_view_table tbody").html(listview_output);
			
		
			var fullscreen_output = "";
			if (fullscreen_shots.length>0){
				jQuery.each(screenshots, function(i, item){
					var url = fullscreen_shots[i];
					fullscreen_output += '<div class="item" align="center"><img src="'+url+'" alt="'+item.note+'"><div class="carousel-caption"><h3>'+item.note+" - "+item.expected_time+'</h3><p></p></div></div>';
				});
				jQuery("#full_view_screenshot").show();
			}
			
			jQuery("#full_view_screenshot .carousel-indicators").html(fullview_indicator_output);
			jQuery("#full_view_screenshot .carousel-inner").html(fullscreen_output);
			
			
	    	if (todisplay.length>0){
		    	var output = "";
		    	var display_time_str = "";
		    	var screen_number = 0;
		    	for(var i=1;i<=screenshots.length;i++){
		    		var item = todisplay[i-1];
		    		
		    		//Determine the Screen Number
		    		if(item.screen_number == 0){
		    			display_time_str = item.display_time;
		    		}else{
		    			screen_number = item.screen_number + 1; 
		    			display_time_str = "Screen " + screen_number;
		    		}
		    		
		    		if (i%6==1){
		    			output += '<div class="screen_shot_item"><div class="row"><div class="col-lg-2"><a href="#" data-position="'+i+'" class="thumb_to_full"><img src="/portal/django/client_subcon_management/thumbs/'+item.year+'/'+item.week+'/'+item.id+'/'+item.screen_number+'" alt="Screenshot" class="img-thumbnail" width="100%" data-toggle="tooltip" data-time_to_respond="'+item.time_to_respond+'" data-note="'+item.note+'"/></a><br/>'+display_time_str+'</div>';
		    		}else if (i%6==0){
		    			output += '<div class="col-lg-2"><a href="#" data-position="'+i+'" class="thumb_to_full"><img src="/portal/django/client_subcon_management/thumbs/'+item.year+'/'+item.week+'/'+item.id+'/'+item.screen_number+'" alt="Screenshot" class="img-thumbnail" width="100%" data-toggle="tooltip" data-time_to_respond="'+item.time_to_respond+'" data-note="'+item.note+'"></a><br/>'+display_time_str+'</div></div></div>';		    		
		    		}else{
		    			output += '<div class="col-lg-2"><a href="#" data-position="'+i+'" class="thumb_to_full"><img src="/portal/django/client_subcon_management/thumbs/'+item.year+'/'+item.week+'/'+item.id+'/'+item.screen_number+'" alt="Screenshot" class="img-thumbnail" width="100%" data-toggle="tooltip" data-time_to_respond="'+item.time_to_respond+'" data-note="'+item.note+'"></a><br/>'+display_time_str+'</div>';
		    		}
		    	}
		    	if (todisplay.length%6!=0){
		    		output += "</div></div>";
		    	}
	    		jQuery("#screenrecording_list").html(output);
	    		
	    		
	    		jQuery(".img-thumbnail").each(function(){
	    			var me = jQuery(this);
	    			var html = "<strong>Activity </strong>"+me.attr("data-note")+"<br/><strong>Time to respond </strong>"+me.attr("data-time_to_respond")
	    			
	    			var options = {
	    				html:true,
	    				trigger:'hover',
	    				title:'Screenshot Details',
	    				content:html,
	    				container:'body',
	    				placement:"auto"
	    			};
	    			me.parent().popover(options);
	    		})
	    		
	    	}else{
	    		jQuery("#screenrecording_list").html('<div class="alert alert-info">There is no screenshot for the staff.</div>')
	    	}
	    	jQuery(".total_count").html(todisplay.length);
	    }
	 });
}