// JavaScript Document

function CheckCreatedAds(){
	
	
	if(jQuery('#category_id').val() == ""){
		alert("Please choose a category");
		return false;
	}
	
	if(jQuery('#outsourcing_model').val() == ""){
		alert("Please choose a Outsourcing Model");
		return false;
	}
	
}


jQuery(document).ready(function(){
	jQuery(".add-responsibility-row").click(function(e){
		var count = jQuery(this).parent().parent().children("table").find("tr").length-1;
		var template = '<tr class="row_to_clone">'
	 	template += '<td width="2%" align="right"><img src="../images/box.gif"></td>'
	 	template += '<td width="98%" align="left"><input name="responsibility['+(count+1)+']" type="text" class="text" style="width:100%;" value=""  /></td></tr>'
		jQuery(template).appendTo(jQuery(this).parent().parent().children("table"));
		e.preventDefault();
		return false;		 	
	});
	
	jQuery(".add-requirement-row").click(function(e){
		var count = jQuery(this).parent().parent().children("table").find("tr").length-1;
		var template = '<tr class="row_to_clone">'
	 	template += '<td width="2%" align="right"><img src="../images/box.gif"></td>'
	 	template += '<td width="98%" align="left"><input name="requirement['+(count+1)+']" type="text" class="text" style="width:100%;" value=""  /></td></tr>'
		jQuery(template).appendTo(jQuery(this).parent().parent().children("table"));
		e.preventDefault();
		return false;		 	
	});
	
	
})
