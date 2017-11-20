//var rsscRPC = "https://remotestaff.com.au/portal/django/client_subcon_management/jsonrpc/";
//var activityNotesRPC = "https://remotestaff.com.au/portal/client/ClientSubconManagementService.php";
//var ping = "https://remotestaff.com.au/portal/client/ClientSubconManagement20110902/ClientSubconManagement.html";
//var clientRPC = "http://test.remotestaff.com.au/portal/django/client_service/jsonrpc/"
var rsscRPC = "/portal/django/client_subcon_management/jsonrpc/";
var activityNotesRPC = "/portal/client/ClientSubconManagementService.php";
var ping = "/portal/client/ClientSubconManagement20110902/ClientSubconManagement.html";
var clientRPC = "/portal/django/client_service/jsonrpc/"

jQuery(document).ready(function(){
    //add highlight for productivity
    
    CURRENT_PAGE = "active_apps";
    
    jQuery("#productivity_reports_top").addClass("active");
	
	var today = jQuery("#subcon_date_picker").val();
	jQuery("#subcon_date_picker").datepicker();
	jQuery("#subcon_date_picker").datepicker("option", "dateFormat", "yy-mm-dd");
	jQuery("#subcon_date_picker").datepicker("setDate", jQuery.datepicker.parseDate("yy-mm-dd", today));
	jQuery("#load_form").on("submit", function(){
		return false;
	})
	jQuery("#view_active_apps").on("click", function(e){
		refreshActiveApp();
	//	e.preventDefault();
	});
	jQuery.get(ping, function(response){
		
	});
	
	
	jQuery("#main_footer").hide();
});
function refreshActiveApp(){
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
	       
	       var output = "";
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
	       		output += "<tr>";
	       		output += "<td>"+item[0]+"</td>";
	       		output += "<td>"+item[1]+"</td>";
	       		
	       		output += "</tr>";
	       		
	       });
	      
	      jQuery("#active_app_list tbody").html(output);
	      
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