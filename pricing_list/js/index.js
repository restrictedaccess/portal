function loadList(currency_id){
	if (typeof currency_id == "undefined"){
		currency_id = "AUD";		
	}
	var data = jQuery(".price_select_form").serialize();
	jQuery.get("/portal/pricing_list/load_prices.php?currency="+currency_id+"&"+data, function(response){
		response = jQuery.parseJSON(response);
		var src = jQuery("#pricing-category").html();
		var output = ""
		jQuery.each(response, function(i, category){
			var template = Handlebars.compile(src);
			output += template(category);
		})
		jQuery("#pricing-div").html(output);
	})
}
function loadHistory(){
	jQuery.get("/portal/pricing_list/get_history.php", function(response){
		response = jQuery.parseJSON(response);
		var src = jQuery("#history-row").html();
		var output = "";
		jQuery.each(response, function(i, item){
			
			output+= "<tr>";
			output+="<td>"+item.log+"</td>";
			output+="<td>"+item.admin.admin_fname+" "+item.admin.admin_lname+"</td>";
			output+="<td>"+item.date_updated+"</td>";
			
			output+="</tr>";
		})
		jQuery("#history_list tbody").html(output);
	});
}


jQuery(document).ready(function(){
	loadList();
	loadHistory();
	jQuery("#category_id").on("change", function(){
		var id = jQuery(this).val();
		jQuery.getJSON("/portal/pricing_list/get_job_position.php?category_id="+id, function(response){
			var output = "<option value=''>Select Job Position</option>";
			jQuery.each(response, function(i, item){
				output += "<option value='"+item.sub_category_id+"'>"+item.sub_category_name+"</option>";
			})
			jQuery("#sub_category_id").html(output);
		});
	});
	jQuery(".price_select_form").on("submit", function(e){
		var id = jQuery("#change_currency").val();
		loadList(id);
		return false;
	});
	jQuery("#change_currency").on("change", function(e){
		var id = jQuery(this).val();
		loadList(id);
	});
	
	jQuery("#add_new_price").on('click', function(e){
		jQuery("#price_add_popup form input[type=text], #price_add_popup form select").val("");
		jQuery("#price_add_popup").modal({backdrop:"static", keyboard:false})
		e.preventDefault();
		e.stopPropagation();
	});
	
	jQuery("#add_price").on("click", function(e){
		var data = jQuery("#price_add_popup form").serialize();
		jQuery.post("/portal/pricing_list/multi_add.php", data, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				jQuery("#price_add_popup form input[type=text], #price_add_popup form select").val("");
				jQuery("#price_add_popup").modal("hide");
				jQuery("#change_currency").val("AUD");
				loadList();
				loadHistory();
				alert("Price has been added");
			}else{
				alert(response.error);
			}
		});
	});
	
	jQuery("#update_multi_price").on("click", function(e){
		var data = jQuery("#price_multi_update_popup form").serialize();
		jQuery.post("/portal/pricing_list/multi_add.php", data, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				jQuery("#price_multi_update_popup form input[type=text], #price_multi_update_popup form select").val("");
				jQuery("#price_multi_update_popup").modal("hide");
				jQuery("#change_currency").val("AUD");
				loadList();
				loadHistory();
				alert("Price has been updated");
			}else{
				alert(response.error);
			}
		});
	});
	jQuery("#update_price_button").on("click", function(e){
		var data = jQuery("#price_update_popup form").serialize();
		jQuery.post("/portal/pricing_list/update_price.php", data, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				jQuery("#price_update_popup form input, #price_update_popup form select").val("");
				jQuery("#price_update_popup").modal("hide");
				jQuery("#change_currency").val("AUD");
				loadList();
				loadHistory();
				alert("Price has been updated");
			}else{
				alert(response.error);
			}
		});
	});
	
});

jQuery(document).on("click", ".delete_price", function(e){
	var ans = confirm("Do you want to delete this price?");
	if (ans){
		var href = jQuery(this).attr("href");
		jQuery.get(href, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				loadList();
				loadHistory();
			}
		});
	}
	e.preventDefault();
});

jQuery(document).on("click", ".update_price", function(e){
	var id = jQuery(this).attr("data-id");
	jQuery.get("/portal/pricing_list/get_price.php?id="+id, function(response){
		response = jQuery.parseJSON(response);
		if (response.success){
			var price = parseFloat(response.price.value);
			price = price.toFixed(2);
			jQuery("#update_price").val(price);
			jQuery("#update_level").val(response.price.level);
			jQuery("#update_price_sub_category_id").val(response.price.sub_category_id);
			jQuery("#update_currency").val(response.price.currency);	
			jQuery("#update_price_id").val(response.price.id);	
			jQuery("#price_update_popup").modal({backdrop:"static", keyboard:false})	
		}else{
			alert("Price does not exist")
		}

		
	});
	e.preventDefault();
})

jQuery(document).on("click", ".update_subcategory_price", function(e){
	var id = jQuery(this).attr("data-id");
	jQuery.get("/portal/pricing_list/get_prices.php?id="+id, function(response){
		response = jQuery.parseJSON(response);
		if (response.success){
			
			jQuery.each(response.prices, function(i, item){
				var price = parseFloat(item.value);
				price = price.toFixed(2);
				jQuery("#price_"+item.level+"_level_"+item.currency).val(price);
				
				jQuery("#update_currency").val(item.currency);
				jQuery("#update_sub_category_id").val(id);				
			})
			

			jQuery("#price_multi_update_popup").modal({backdrop:"static", keyboard:false})	
		}else{
			alert("Price does not exist")
		}

		
	});
	e.preventDefault();
});
