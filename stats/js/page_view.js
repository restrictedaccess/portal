jQuery(document).ready(function(){
	var date_from = jQuery("#date_from").val();
	var date_to = jQuery("#date_to").val();
	
	jQuery("#date_from").datepicker();
	jQuery("#date_to").datepicker();
	jQuery("#date_from").datepicker("option", "dateFormat", "yy-mm-dd");
	jQuery("#date_to").datepicker("option", "dateFormat", "yy-mm-dd");	
	
	jQuery("#date_from").datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", date_from));
	jQuery("#date_to").datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", date_to));
	
	jQuery("#page-view-filter").on("submit", function(){
		
		var data = jQuery(this).serialize();
		jQuery.post("/portal/stats/list.php", data, function(response){
			var src = jQuery("#activity-template").html();
			var template = Handlebars.compile(src);
			var output = "";
			response = jQuery.parseJSON(response);
			k = 1;
			jQuery.each(response, function(i, lead){
				lead.i = k;
				k++;
				output += template(lead);
			});
			
			
			jQuery("#page-view-activities-table tbody").html(output);
			
			jQuery(".charts").each(function(){
				var caption = jQuery(this).find("caption").html();
				jQuery(this).visualize({type: 'pie', pieMargin: 10, title: caption});
				jQuery(this).hide();
			});
		});
		
		return false;
	}).trigger("submit");
	
	
});
