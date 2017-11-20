jQuery(document).ready(function(){
	var date_from = jQuery("#date_added_from").val();
	var date_to = jQuery("#date_added_to").val();
	
	jQuery("#date_added_from").datepicker();
	jQuery("#date_added_to").datepicker();
	jQuery("#date_added_from").datepicker("option", "dateFormat", "yy-mm-dd");
	jQuery("#date_added_to").datepicker("option", "dateFormat", "yy-mm-dd");	
	jQuery("#date_added_from").datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", date_from));
	jQuery("#date_added_to").datepicker("setDate", $.datepicker.parseDate("yy-mm-dd", date_to));
	
	
	jQuery("#date_updated_from").datepicker();
	jQuery("#date_updated_to").datepicker();
	jQuery("#date_updated_from").datepicker("option", "dateFormat", "yy-mm-dd");
	jQuery("#date_updated_to").datepicker("option", "dateFormat", "yy-mm-dd");	
	
	jQuery("#date_registered_from").datepicker();
	jQuery("#date_registered_to").datepicker();
	jQuery("#date_registered_from").datepicker("option", "dateFormat", "yy-mm-dd");
	jQuery("#date_registered_to").datepicker("option", "dateFormat", "yy-mm-dd");	
	
	
	jQuery("#available_date").datepicker();
	jQuery("#available_date").datepicker("option", "dateFormat", "yy-mm-dd");
	
	
	jQuery("select[name=available_notice]").on("focus", function(){
		jQuery("#available_status_a").attr("checked", "checked");
	});

	jQuery("#available_date").on("focus", function(){
		jQuery("#available_status_b").attr("checked", "checked");
	});	
	jQuery("#available_status_a, #available_status_b").on("click", function(){
		jQuery("#available_date").val("");
		jQuery("select[name=available_notice]").val("");
	});
	
	jQuery("#recruiter-categorized-filter").on("submit", function(e){
		var data = jQuery(this).serialize();
		var me = jQuery(this);
		
		
		if (jQuery("input[name=mass_email]").is(":checked")){
			me.find("button[type=submit]").attr("disabled", "disabled").html("<i class='glyphicon glyphicon-search'></i> Mass Mailing...");
			window.location.href = "/portal/recruiter/categorized_mass_mail.php?"+data;
			return false;
		}
		
		me.find("button[type=submit]").attr("disabled", "disabled").html("<i class='glyphicon glyphicon-search'></i> Fetching Result...");
		
		
		jQuery.post("/portal/recruiter/get_categorized_list.php", data, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				var src = jQuery("#category-template").html();
				var template = Handlebars.compile(src);
				var output = "";
				
				var count_subcategory = 0;
				jQuery.each(response.result, function(i, item){
					output+=template(item);
					count_subcategory += item.subcategories.length;
				});
				me.find("button[type=submit]").removeAttr("disabled").html('<i class="glyphicon glyphicon-search"></i> Search');
				jQuery("#search_result").html(output);
				if (count_subcategory == 1){
					jQuery("#categorized-count").html(response.count+" categorized candidates in "+count_subcategory+" subcategory");				
				}else{
					jQuery("#categorized-count").html(response.count+" categorized candidates in "+count_subcategory+" subcategories");
				}
			}
		})
		return false;
	});
	jQuery("#recruiter-categorized-filter").trigger("submit");
});

Handlebars.registerHelper('list_skill', function(items, options) {	
  var skill_list = [];
  for(var i=0, l=items.length; i<l; i++) {
  	skill_list.push(options.fn(items[i]));
  }
  return skill_list.join(", "); 
});

Handlebars.registerHelper('count_items', function(items, options) {	
  var skill_list = [];
  for(var i=0, l=items.length; i<l; i++) {
  	skill_list.push(options.fn(items[i]));
  }
  return skill_list.length; 
});
Handlebars.registerHelper('list_rates', function(items, options) {	
  var rates = [];
  for(var i=0, l=items.length; i<l; i++) {
  	rates.push(options.fn(items[i]));
  }
  return rates.join("<br/>"); 
});
Handlebars.registerHelper('list_employment', function(items, options) {	
  var employment_history = [];
  for(var i=0, l=items.length; i<l; i++) {
  	employment_history.push(options.fn(items[i]));
  }
  
  var output = "";
  jQuery.each(employment_history, function(i, item){
  	if (item.status!="deleted"){
	  	output += "<a href='/portal/leads_information.php?id="+item.lead_id+"' class='popup'>"+item.lead_fname+" "+item.lead_lname+"</a><br/>";
	  	output += "Started "+ item.cdate+ "<br/>";
	  	if (item.resig_date!=null){
	  		output += "Resigned "+ item.resig_date+ "<br/>";
	  	}
	  	if (item.term_date!=null){
	  		output += "Terminated "+ item.term_date+ "<br/>";
	  	}
	  	output += "<br/>";  		
  	}
  });
  return output; 
});

Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {

    switch (operator) {
        case '==':
            return (v1 == v2) ? options.fn(this) : options.inverse(this);
        case '===':
            return (v1 === v2) ? options.fn(this) : options.inverse(this);
        case '<':
            return (v1 < v2) ? options.fn(this) : options.inverse(this);
        case '<=':
            return (v1 <= v2) ? options.fn(this) : options.inverse(this);
        case '>':
            return (v1 > v2) ? options.fn(this) : options.inverse(this);
        case '>=':
            return (v1 >= v2) ? options.fn(this) : options.inverse(this);
        case '&&':
            return (v1 && v2) ? options.fn(this) : options.inverse(this);
        case '||':
            return (v1 || v2) ? options.fn(this) : options.inverse(this);
        default:
            return options.inverse(this);
    }
});

jQuery(document).on("click", ".popup", function(e){
	popup_win(jQuery(this).attr("href"),900, 700);
	e.preventDefault();
})