var page = 1;
var current_url = "";
var rows = 100;

function renderResponse(response){
	var output = "";
	jQuery.each(response.categorized, function(i, item){
		output += "<tr>";
		output += "<td>"+(((page-1)*rows)+(i+1))+"</td>";
		output += "<td><a href='/portal/recruiter/staff_information.php?userid="+item.userid+"&page_type=popup' class='popup'>"+item.fname+" "+item.lname+"</a></td>";
		output += "<td>"+item.category_name+"</td>";
		output += "<td>"+item.sub_category_name+"</td>";
		if (item.ratings==1){
			output += "<td>No</td>";
		}else{
			output += "<td>Yes</td>";
		}
		output += "<td><button class='btn btn-primary transfer_category' data-id='"+item.id+"'><i class='glyphicon glyphicon-share-alt'></i>Transfer Category</button></td>";
		output += "</tr>";
	});
	
	jQuery("#candidate_table tbody").html(output);
	
	if (response.subcategory!=undefined){
		jQuery("#category_manager_header").html(response.subcategory.sub_category_name);
		jQuery("#panel_description").html(response.subcategory.description);
		jQuery("#edit_description").attr("data-id", response.subcategory.sub_category_id).attr("data-type", "subcategory");
	}else if (response.category!=undefined){
		jQuery("#category_manager_header").html(response.category.category_name);
		jQuery("#panel_description").html(response.category.description);
		jQuery("#edit_description").attr("data-id", response.category.category_id).attr("data-type", "category");
	}else{
		jQuery("#category_manager_header").html("Search Results");
		jQuery("#panel_description").html("");
		jQuery("#edit_description").removeAttr("data-id").removeAttr("data-type");
	}
	var start = ((page-1)*rows) + 1;
	var end = (start + rows) - 1;
	if (response.page==1){
		jQuery(".prev").addClass("disabled");
	}else{
		jQuery(".prev").removeClass("disabled");
	}
	if (end > response.total_candidates){
		end = response.total_candidates;
		jQuery(".next").addClass("disabled");
	}else{
		jQuery(".next").removeClass("disabled");
	}
	if (response.total_candidates == 0){
		start = 0;
	}
	jQuery(".start_count").text(start);
	jQuery(".end_count").text(end);
	jQuery(".total_count").text(response.total_candidates);
	
}



jQuery(document).ready(function(){
	jQuery("#category_manager_header").html("Loading...");
	jQuery("#search_sub_category_id").val(3);
	jQuery.get("/portal/category_manager/load_categorized.php?sub_category_id=3", function(response){
		response = jQuery.parseJSON(response);
		renderResponse(response);
	});
	
	jQuery(".category_loader").on("click", function(e){
		var category_id = jQuery(this).attr("data-category_id");
		jQuery("#search_category_id").val(category_id);
		page = 1;
		jQuery("#category_manager_header").html("Loading...");
		current_url = "/portal/category_manager/load_categorized.php?category_id="+category_id;
		jQuery.get("/portal/category_manager/load_categorized.php?category_id="+category_id, function(response){
			response = jQuery.parseJSON(response);
			renderResponse(response);
		});		
		e.preventDefault();
	});
	
	jQuery(".subcategory_loader").on("click", function(e){
		var sub_category_id = jQuery(this).attr("data-sub_category_id");
		page = 1;
		jQuery("#search_sub_category_id").val(sub_category_id);
		jQuery("#category_manager_header").html("Loading...");
		current_url = "/portal/category_manager/load_categorized.php?sub_category_id="+sub_category_id;
		jQuery.get("/portal/category_manager/load_categorized.php?sub_category_id="+sub_category_id, function(response){
			response = jQuery.parseJSON(response);
			renderResponse(response);
		});		
		e.preventDefault();
	});
	
	
	jQuery("#edit_description").on("click", function(e){
		var type = jQuery(this).attr('data-type');
		var id = jQuery(this).attr('data-id');
		jQuery.get("/portal/category_manager/load_category_form.php?id="+id+"&type="+type, function(response){
			jQuery("#panel_description").html(response);
		});
		e.preventDefault();
	});
	jQuery("#transfer_category_button").on("click", function(e){
		var data = jQuery("#transfer_category_form").serialize()
		jQuery.post("/portal/category_manager/update_categorized.php", data, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				alert("Transfer has been complete");
				jQuery.get("/portal/category_manager/load_categorized.php?sub_category_id="+response.categorized.sub_category_id, function(response_load){
					response_load = jQuery.parseJSON(response_load);
					renderResponse(response_load);
				});	
				
				jQuery('#transfer_category_modal').modal("hide");
			}else{
				if (response.error!=undefined){
					alert(response.error)
				}else{
					alert("Something went wrong. Please try again.")
				}
			}
			
		});
		
		e.preventDefault();
	});
	
	jQuery("#search_form").on("submit", function(e){
		var data = jQuery(this).serialize();
		page = 1;
		data += "&page="+page
		jQuery.get("/portal/category_manager/load_categorized.php?"+data, function(response){
			response = jQuery.parseJSON(response);
			renderResponse(response);
		});
		return false;
	});
	
	jQuery("#search_all").on("click", function(e){
		jQuery("#search_sub_category_id").val("");
		jQuery("#search_category_id").val("");
		
	});
	
	jQuery(".next").on("click", function(e){
		if (!jQuery(this).hasClass("disabled")){
			var data = jQuery("#search_form").serialize();
			page += 1;
			data += "&page="+page
			jQuery.get("/portal/category_manager/load_categorized.php?"+data, function(response){
				response = jQuery.parseJSON(response);
				renderResponse(response);
			});
		}
		e.preventDefault();
	});
	jQuery(".prev").on("click", function(e){
		if (!jQuery(this).hasClass("disabled")){
			var data = jQuery("#search_form").serialize();
			page -= 1;
			data += "&page="+page
			jQuery.get("/portal/category_manager/load_categorized.php?"+data, function(response){
				response = jQuery.parseJSON(response);
				renderResponse(response);
			});
			return false;
		}
		e.preventDefault();
	});
	
	
});

jQuery(document).on("click", ".transfer_category", function(){
	var id = jQuery(this).attr("data-id");
	jQuery.get("/portal/category_manager/get_categorized.php?id="+id, function(response){
		response = jQuery.parseJSON(response);
		jQuery('#transfer_category_modal').modal({
		  keyboard: false,
		  backdrop:true
		});
		jQuery("#transfer_category_id").val(response.categorized.sub_category_id);
		jQuery("#transfer_id").val(response.categorized.id);
		jQuery(".modal-title").html("Transfer Sub Category of " + response.categorized.userid+ " - " +response.categorized.fname+" "+response.categorized.lname+" ")
	});

});

jQuery(document).on("click", ".popup", function(e){
	var href = jQuery(this).attr("href")
	window.open(href,'_blank','width=700,height=600,resizable=yes,toolbar=no,directories=no,location=no,menubar=no,scrollbars=yes,status=no');
	e.preventDefault();	
})

jQuery(document).on("submit", "#transfer_category_form", function(){
	var data = jQuery(this).serialize();
	jQuery.post("/portal/category_manager/update_category_description.php", data, function(response){
		response = jQuery.parseJSON(response);
		jQuery("#panel_description").html(response.description);
	});
	return false;
});
