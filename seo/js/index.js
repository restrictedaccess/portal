jQuery(document).ready(function(){
	jQuery(".edit_category").live("click", function(e){
		var id = jQuery(this).attr("data-id");
		jQuery("#upate_category_id").val(id);
		jQuery.get("/portal/seo/getcategory.php?category_id="+id, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				jQuery("#update_category_id").val(data.category.category_id);
				jQuery("#update_category_category_name").val(data.category.category_name);
				jQuery("#update_category_description").val(data.category.meta_description)
				jQuery("#update_category_keywords").val(data.category.keywords);
				jQuery("#update_category_title").val(data.category.title);
				jQuery("#update_category_url").val(data.category.url);
				jQuery("#update_category_status").val(data.category.status);
				jQuery("#update_category_singular_name").val(data.category.singular_name);
				jQuery("#update_category_page_header").val(data.category.page_header);
				jQuery("#update_category_page_description").val(data.category.page_description);
				
				jQuery("#update_category_modal").modal({backdrop: 'static',keyboard: true});
				
				var description = jQuery("#update_category_description").val();
				var title = jQuery("#update_category_title").val();
				jQuery("#update_subcategory_title").data("oldvalue", title)
				jQuery("#update_subcategory_description").data("oldvalue", description)
				jQuery(".category_count").text(69-title.length)
				jQuery(".description_count").text(160-description.length)
				
				
			}
			
			
		});
		
		
		e.preventDefault();
	})
	
	jQuery(".edit_subcategory").live("click", function(e){
		var id = jQuery(this).attr("data-id");
		jQuery("#update_subcategory_id").val(id);
		jQuery.get("/portal/seo/getsubcategory.php?sub_category_id="+id, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				jQuery("#update_subcategory_id").val(data.subcategory.sub_category_id);
				jQuery("#update_subcategory_category_name").val(data.subcategory.sub_category_name);
				jQuery("#update_subcategory_description").val(data.subcategory.meta_description)
				jQuery("#update_subcategory_keywords").val(data.subcategory.keywords);
				jQuery("#update_subcategory_title").val(data.subcategory.title);
				jQuery("#update_subcategory_url").val(data.subcategory.url);
				jQuery("#update_subcategory_page_header").val(data.subcategory.page_header);
				
				jQuery("#update_subcategory_status").val(data.subcategory.status);
				jQuery("#update_subcategory_category_id").val(data.subcategory.category_id);
				jQuery("#update_subcategory_singular_name").val(data.subcategory.singular_name);
				jQuery("#update_subcategory_page_description").val(data.subcategory.page_description);
				
				
				jQuery("#update_subcategory_modal").modal({backdrop: 'static',keyboard: true});
				jQuery("#update_subcategory_title").data("oldvalue", jQuery("#update_subcategory_title").val())
				jQuery("#update_subcategory_description").data("oldvalue", jQuery("#update_subcategory_description").val())
				var description = jQuery("#update_subcategory_description").val();
				var title = jQuery("#update_subcategory_title").val();
				
				jQuery(".category_count").text(69-title.length)
				jQuery(".description_count").text(160-description.length)
			}
		});
		e.preventDefault();
	});
	jQuery("#save_subcategory").click(function(e){
		if (jQuery.trim(jQuery("#update_subcategory_category_name").val())==""){
			alert("Sub Category Name is required");
			return;
		}
		if (jQuery.trim(jQuery("#update_subcategory_url").val())==""){
			alert("URL is required");
			return;
		}
		
		var data = jQuery("#update_subcategory").serialize();
		jQuery.post("/portal/seo/updatesubcategory.php", data, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				alert("Sub Category has been updated");
				jQuery("#update_subcategory_modal").modal("hide");
				window.location.reload();
			}
		})
		e.preventDefault();
	})
	
	
	jQuery("#update_category_description, #update_subcategory_description").bind('input propertychange', function(e) {
		var value = jQuery(this).val();		
		if (value.length>160){
			jQuery(this).val(jQuery(this).data("oldvalue"));
			e.preventDefault();	
		}else{
			jQuery(this).data("oldvalue", value);
			jQuery(".description_count").text(160-value.length)
		}
		
	}).blur(function(){
		var value = jQuery(this).val();		
		jQuery(".description_count").text(160-value.length)
		
	});
	
	
	
	
	jQuery("#update_subcategory_title, #update_category_title").bind('input propertychange', function(e) {
		var value = jQuery(this).val();		
		if (value.length>69){
			jQuery(this).val(jQuery(this).data("oldvalue"));
			e.preventDefault();	
		}else{
			jQuery(this).data("oldvalue", value);
			jQuery(".category_count").text(69-value.length)
		}
		
	}).blur(function(){
		var value = jQuery(this).val();		
		jQuery(".category_count").text(69-value.length)
	});
	
	
	jQuery("#save_category").click(function(e){
		if (jQuery.trim(jQuery("#update_category_category_name").val())==""){
			alert("Category Name is required");
			return;
		}
		if (jQuery.trim(jQuery("#update_category_url").val())==""){
			alert("URL is required");
			return;
		}
		
		var data = jQuery("#update_category").serialize();
		jQuery.post("/portal/seo/updatecategory.php", data, function(response){
			response = jQuery.parseJSON(response);
			if (response.success){
				alert("Category has been updated");
				jQuery("#update_category_modal").modal("hide");
				window.location.reload();
			}
		})
		e.preventDefault();
	})
	
	jQuery("#close_subcategory").click(function(e){
		jQuery("#update_subcategory_modal").modal("hide");
		e.preventDefault();
	})
	jQuery("#close_category").click(function(e){
		jQuery("#update_category_modal").modal("hide");
		e.preventDefault();
	})
});
