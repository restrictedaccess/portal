jQuery(document).ready(function(){
	
	
	var registered_date = jQuery("#staff_date_registered").val();
	
	var splitted_date_array = registered_date.split(" ");
	
	//remove period
	var date_month = splitted_date_array[0].replace(".", "");
	
	//remove commas
	var date_day = splitted_date_array[1].replace(",", "");
	var date_year = splitted_date_array[2].replace(",", "");
	
	var new_registered_date = date_month + " " + date_day + " " + date_year;
	
	
	init_reset_password_first("subcontractor", new_registered_date);
});