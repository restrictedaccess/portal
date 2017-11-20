jQuery(document).ready(function() {
	jQuery(window).load(function (e) {
		console.log(window.location.pathname);
		
		Calendar.setup({
		   inputField : "date_from",
		   trigger    : "date_from",
		   onSelect   : function() { this.hide()  },
		   fdow  : 0,
		   dateFormat : "%Y-%m-%d"
		});
		
		Calendar.setup({
		   inputField : "date_to",
		   trigger    : "date_to",
		   onSelect   : function() { this.hide()  },
		   fdow  : 0,
		   dateFormat : "%Y-%m-%d"
		});
		
		//jQuery('#start_date').MonthPicker({ ShowIcon: false });
		//jQuery('#end_date').MonthPicker({ ShowIcon: false });
		
		//jQuery("#search_date").MonthPicker({ ShowIcon: false });
		jQuery('#generate-btn').html('Generate');
		jQuery('#generate-btn').removeAttr('disabled', 'disabled');
	});
	
	jQuery("#search_form").on( "submit", function(e) {
		e.preventDefault();
		generate_collections_report(this);		
	});
	
	
	
	
	
});


function generate_collections_report(e){
	var API_URL = jQuery('#API_URL').val();
	var form = jQuery(e);
	var formData = form.serialize();	
	//console.log(formData);
	
	var date_from = jQuery("#date_from").val();
	var date_to = jQuery("#date_to").val();
	
	//var date_from = "2014-01-01";
	//var date_to = "2015-01-31";
	
	//var search_date= jQuery("#search_date").val();
    //search_date = search_date.split("/");	
	
	//var iYear = search_date[1];
	//var iMonth = search_date[0];
	//var query = {"year": iYear, "month": iMonth  };
	
	//start_date = configure_date(start_date, 'start_date');
	//end_date = configure_date(end_date, 'end_date');
	
	
	//var query = {"start_date": start_date, "end_date": end_date  };
	
	
	
	//console.log(formData);
	//return false;
	
	jQuery('#generate-btn').html('generating...');
	jQuery('#generate-btn').attr('disabled', 'disabled');
	
	jQuery.post(API_URL + "/collections/get/?date_from="+date_from+"&date_to="+date_to, formData, function(data){
		response = jQuery.parseJSON(data);
		if(response.result){
			
			var output = "";
			var source   = jQuery("#entry-template").html();
			var template = Handlebars.compile(source);
	
			//var context = {title: "My New Post", body: "This is my first post!"};
			//var html    = template(context);
			
			
			jQuery.each(response.result, function(i, item){
				//console.log(item);
				//output += "<tr>";
				//	output += "<td>"+item._id+"</td>";
				//	output += "<td>"+item.client_name+"</td>";
				//	output += "<td>"+item.status+"</td>";					
				//output += "</tr>";
				output += template({item});
				
			});
			
			jQuery("#result-container table tbody").html(output);
			
		}else{
			console.log(response);
		}
		
		jQuery('#generate-btn').html('Generate');
		jQuery('#generate-btn').removeAttr('disabled');
	});
	
}


function configure_date(date_str, mode){
	
	var date_arr = date_str.split("/");	
	var iMonth = date_arr[0];
	var iYear = date_arr[1];
	
	 
	if(mode == 'start_date'){
		iDay = "01";		
	}
	
	if(mode == 'end_date'){
		var dd = new Date(iYear, iMonth, 0);
		var iDay =  dd.getDate();
	}
	
	return iYear+"-"+iMonth+"-"+iDay
    
}