

jQuery(document).ready(function(){
	jQuery(".remove_character_reference").live("click", function(e){
		jQuery(this).parent().parent().fadeOut(100, function(){
			jQuery(this).remove();
		})
		e.preventDefault();
		e.stopPropagation();
	})
	
	jQuery("#add_new_character_reference").click(function(e){
		jQuery.get("/portal/candidates/empty_character_reference.php", function(data){
			jQuery(data).appendTo(jQuery("#character_references"));
		})
		e.preventDefault();
		e.stopPropagation();
	})
	

	jQuery(".industry").on("change", function(){
		var me = jQuery(this);
		if (me.val()=="10"){
			jQuery("#campaign_"+jQuery(this).attr("data-index")).show().find("input").val("");
		}else{
			jQuery("#campaign_"+jQuery(this).attr("data-index")).hide().find("input").val("");
			
		}
	});
	
	$('textarea').summernote({
	  toolbar: [
	    //[groupname, [button list]]
	    ['style', ['bold', 'italic', 'underline']],
	    ['fontsize', ['fontsize']],
	    ['para', ['ul', 'ol', 'paragraph']],
	  ],
	  height:200
	});
});
