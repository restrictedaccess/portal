//var rsscRPC = "https://remotestaff.com.au/portal/django/client_subcon_management/jsonrpc/";
//var activityNotesRPC = "https://remotestaff.com.au/portal/client/ClientSubconManagementService.php";
//var ping = "https://remotestaff.com.au/portal/client/ClientSubconManagement20110902/ClientSubconManagement.html";
//var clientRPC = "http://test.remotestaff.com.au/portal/django/client_service/jsonrpc/"
var rsscRPC = "/portal/django/client_subcon_management/jsonrpc/";
var activityNotesRPC = "/portal/client/ClientSubconManagementService.php";
var ping = "/portal/client/ClientSubconManagement20110902/ClientSubconManagement.html";
var clientRPC = "/portal/django/client_service/jsonrpc/"


var plot1 = null;
jQuery(document).ready(function(){
	
	var registered_date = jQuery("#client_registered_date").val();
	
	init_reset_password_first("leads", registered_date);
	
	
	
  CURRENT_PAGE = "homepage";
  
   //add highlight for home
  jQuery("#home_top").addClass("active");
  
  //build the datepicker
  var today = jQuery("#subcon_date_picker").val();
  jQuery("#subcon_date_picker").datepicker();
  jQuery("#subcon_date_picker").datepicker("option", "dateFormat", "yy-mm-dd");
  jQuery("#subcon_date_picker").datepicker("setDate", jQuery.datepicker.parseDate("yy-mm-dd", today));
  jQuery("#subcon_mobile_date_picker").datepicker();
  jQuery("#subcon_mobile_date_picker").datepicker("option", "dateFormat", "yy-mm-dd");
  jQuery("#subcon_mobile_date_picker").datepicker("setDate", jQuery.datepicker.parseDate("yy-mm-dd", today));

  var data = [
    ['Top Ten Apps', 100]
  ];
  
  plot1 = jQuery.jqplot ('active_charts', [data], 
    { 
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true,
         
        }
      }, 
      grid:{
  	 	drawBorder: false,
	      borderColor:'transparent',
	      shadow:false,
	      shadowColor:'transparent'
      },
      legend: { show:true, location: 'e' }
    }
  );
  
	jQuery.get(ping, function(response){
		
	});
	
	
	jQuery("#load_form").on("submit", function(){
		return false;
	})
	jQuery("#load_mobile_form").on("submit", function(){
		return false;
	})
	
	jQuery("#view_productivity_dashboard").on("click", function(e){
		var userid = jQuery("#subcon_userid").val();
		var today = jQuery("#subcon_date_picker").val();
		refreshProductivityDashboard(userid, today);
		e.preventDefault();
		e.stopPropagation();
	})
	
	
	jQuery("#view_mobile_productivity_dashboard").on("click", function(e){
		var userid = jQuery("#subcon_mobile_userid").val();
		var today = jQuery("#subcon_mobile_date_picker").val();
		refreshProductivityDashboard(userid, today);
		e.preventDefault();
		e.stopPropagation();
	});
	
	var userid = jQuery("#subcon_mobile_userid").val();
	var today = jQuery("#subcon_mobile_date_picker").val();
	refreshProductivityDashboard(userid, today);
});


//refresh productivity dashboard
function refreshProductivityDashboard(userid, today){
	if (jQuery.trim(userid)==""){
		alert("Please select staff to view.");
		return;
	}
	if (jQuery.trim(today)==""){
		alert("Please select date to view.");
		return;
	}
	
	refreshName(userid, today);
	refreshLastDayLogin(userid, today);
	refreshActivityNotes(userid, today);
	refreshActiveApp(userid, today);
	refreshScreenshot(userid, today);
}

function refreshName(userid, today){
	jQuery.get(baseUrl+"/portal/client_api_service/subcon_get.php?userid="+userid+"&date="+today, function(response){
		response = jQuery.parseJSON(response);
		jQuery("#subcon_name").html(response.personal.fname);
		jQuery("#subcon_date").html(response.date);
		
	});
}

function refreshActivityNotes(userid, today){
	var data = {json_rpc:"2.0", id:"ID10", method:"get_activity_notes", params:[today, today, 0, userid]};
	jQuery.ajax({
	    url: activityNotesRPC,
	    type: 'POST',
	    data: JSON.stringify(data),
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    success: function(response) {
	    	var output = "";
	    	if (response.result!=undefined){
		    	if (response.result.return_notes.length > 0){
		    		var notes = response.result.return_notes.reverse();
			    	jQuery.each(notes, function(i, item){
			    		if (i==6){
			    			return false;
			    		}
			    		output += "<div class='row'>";
			    		output += "<div class='col-lg-6'>"+item.time+"</div>";
			    		output += "<div class='col-lg-6'>"+item.note+"</div>";
			    		output += "</div>";
			    	});
			    	jQuery("#activity_notes_body").html(output)	    		
		    	}else{
		    		jQuery("#activity_notes_body").html('<div class="alert alert-info">There is no activity notes for the staff.</div>');	  
		    	}	    		
	    	}else{
	    			jQuery("#activity_notes_body").html('<div class="alert alert-info">There is no activity notes for the staff.</div>');
	    	}

	    }
	})
	
}

function refreshActiveApp(userid, today){
	today = today.split("-");
	
	today = today.join("");
	
	var data = {json_rpc:2.0, id:"ID12", method:"get_active_apps", params:[userid, today]}
	
	var total = 0;
	jQuery.ajax({
	    url: rsscRPC,
	    type: 'POST',
	    data: JSON.stringify(data),
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    success: function(response) {
	       var total = 0;
	       var key_pair_percs_app = [];
	       if (response.result!=undefined){
		       jQuery.each(response.result, function(i, item){
		       		var time_consumed = item[0];
		       		var app = item[1];
		       		//split the time
		       		var hms = time_consumed.split(":");
		       		var app_portion = (parseInt(hms[0])*360)+(parseInt(hms[1])*60)+parseInt(hms[2]);
		       		key_pair_percs_app.push({app_portion:app_portion, app_name:app.substr(0, 50)});       		
		       		total += parseInt(hms[0])*360;
		       		total += parseInt(hms[1])*60;
		       		total += parseInt(hms[2]);
		       });	       	
	       }

	      
	      var chart = [];
	      jQuery.each(key_pair_percs_app, function(i, item){
	      	if (i==10){
	      		return false;
	      	}
	      	var key_pair = [item.app_name, (item.app_portion/total)*100]
	      	chart.push(key_pair);
	      });
	      
	      if (chart.length==0){
	      	chart= [
			    ['Top Ten Apps', 100]
			  ];
	      }
	      
	      jQuery.jqplot ('active_charts', [chart], 
		    { 
		      seriesDefaults: {
		        // Make this a pie chart.
		        renderer: jQuery.jqplot.PieRenderer, 
		        rendererOptions: {
		          // Put data labels on the pie slices.
		          // By default, labels show the percentage of the slice.
		          showDataLabels: true,
		         
		        }
		      }, 
		      grid:{
		  	 	drawBorder: false,
			      borderColor:'transparent',
			      shadow:false,
			      shadowColor:'transparent'
		      },
		      legend: { show:true, location: 'e' }
		    }
		  ).replot();
	      
	    }
	});
}


function refreshScreenshot(userid, today){
	var data = {json_rpc:2.0, id:"ID8", method:"get_screenshots", params:[today, userid]}
	jQuery.ajax({
	    url: rsscRPC,
	    type: 'POST',
	    data: JSON.stringify(data),
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    success: function(response) {
	    	if (response.result!=undefined){
	    	    var screenshots = response.result.screenshots.reverse();
		    	var todisplay = []
		    	jQuery.each(screenshots, function(i, item){
		    		if (i==4){
		    			return false;
		    		}
		    		todisplay.push(item);
		    	})
		    	if (todisplay.length>0){
			    	var output = "";
			    	for(var i=1;i<=4;i++){
			    		var item = todisplay[i-1];
			    		if (i%2==1){
			    			output += '<div class="screen_shot_item"><div class="row"><div class="col-lg-6"><a href="/portal/django/client_productivity_reports/screenshots/"><img src="/portal/django/client_subcon_management/thumbs/'+item.year+'/'+item.week+'/'+item.id+'/'+item.screen_number+'" alt="Screenshot" class="img-thumbnail" width="100%"/></a></div>';
			    		}else{
			    			output += '<div class="col-lg-6"><a href="/portal/django/client_productivity_reports/screenshots/"><img src="/portal/django/client_subcon_management/thumbs/'+item.year+'/'+item.week+'/'+item.id+'/'+item.screen_number+'" alt="Screenshot" class="img-thumbnail" width="100%"/></a></div></div></div>';
			    		}
			    	}
			    	if (todisplay.length%2!=0){
			    		output += "</div></div>";
			    	}
		    		jQuery("#screenrecording_list").html(output);
		    	}else{
		    		jQuery("#screenrecording_list").html('<div class="alert alert-info">There is no screenshot for the staff.</div>')
		    	}		
	    	}else{
	    		jQuery("#screenrecording_list").html('<div class="alert alert-info">There is no screenshot for the staff.</div>')
	    	}

	    	
	    }
	 });
}

function refreshLastDayLogin(userid, today){
	var subcon_id
	jQuery("#subcon_mobile_userid option").each(function(){
		var value = jQuery(this).attr("value");
		var temp = jQuery(this).attr("data-subcon_id");
		if (value==userid){
			subcon_id = temp;
		}
	})
	
	
	var data = {"jsonrpc":"2.0","id":"ID1","method":"summary","params":[today, today, parseInt(subcon_id)]}
	jQuery("#five_day_login_report_table tbody").html("");
	jQuery.ajax({
		    url: clientRPC,
		    type: 'POST',
		    data: JSON.stringify(data),
		    contentType: 'application/json; charset=utf-8',
		    dataType: 'json',
		    success: function(response) {
		    	var output = "";
		    	var hours = 0;
		    	if (response.result!=undefined){
		    		var logs = response.result.last_5_days_login.reverse()
					jQuery.each(logs, function(i, item){
						
						//format the hours and hours_charged field
						item.hours = Math.round(item.hours * 100) / 100
						
						hours += item.hours
						output += "<tr>";
						output += "<td>"+item.date+"</td>";
						output += "<td>"+item.hours+" hours</td>";
						output += "<td>"+item.hours_charged+" hours</td>";
						output += "</tr>";
					});
					jQuery("#five_day_login_report_table tbody").html(output);
					jQuery("#total_hours").html(hours+" hours");
					
					output = "";
					jQuery.each(response.result.workflow_progress, function(i, item){
						if (item.percentage=="None"){
							item.percentage = 0;
						}else{
							item.percentage = parseInt(item.percentage);
						}
						output += "<li>";					
						output += '<a target="_blank" href="/portal/django/workflow/task/'+item.task_id+'" class="link_subj_workflow_id">'+item.task_id+'</a> | <a target="_blank" href="/portal/django/workflow/task/'+item.task_id+'" class="link_subj_workflow_id">'+item.title+'</a>';
						output += '<div class="progress progress-striped active"><div class="progress-bar" role="progressbar" aria-valuenow="'+item.percentage+'" aria-valuemin="0" aria-valuemax="100" style="width: '+item.percentage+'%"><span>'+item.percentage+'% Complete</span></div></div>';	
						output += "</li>";
					});
					if (output == ""){
						output = '<div class="alert alert-info">There is no workflow progress for the staff.</div>';
					}
					jQuery(".workflow ul").html(output);
		    	}else{
		    		jQuery(".workflow ul").html('<div class="alert alert-info">There is no workflow progress for the staff.</div>');
		    		jQuery("#five_day_login_report_table tbody").html('<div class="alert alert-info">There is no timesheet for the staff.</div>');
		    		
		    	}

			}
	});
}
