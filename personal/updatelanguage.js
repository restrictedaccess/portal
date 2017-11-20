jQuery(document).ready(function(){
	jQuery(".delete-language").live("click", function(){
		var id = jQuery(this).attr("data-id");
		var me = jQuery(this);
		jQuery.post("/portal/personal/deletelanguage.php", {id:id}, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				me.parent("tr").remove();
			}
		})
	});
	jQuery("#addlanguage").submit(function(){
		var formdata = jQuery(this).serialize();
		jQuery.post("/portal/personal/addlanguage.php", formdata, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				alert("Added new language");
				var count = jQuery("#language-table tbody tr").length;
				var output = "<tr bgcolor='#f5f5f5'>";
				output+=("<td width='6%'><font size='1'>"+(count-1)+".</font></td>");
				output+=("<td width='33%'><font size='1'>"+(data.newlanguage.language)+"</font></td>");
				output+=("<td width='26%'><font size='1'>"+(data.newlanguage.spoken)+"</font></td>");
				output+=("<td width='35%'><font size='1'>"+(data.newlanguage.written)+"</font></td>");
				output+=("<td width='26%'><font size='1'><a href='#' class='delete-language' data-id='"+(data.newlanguage.language)+"'>delete</a></font></td>");
				output+="</tr>";
				jQuery(output).appendTo(jQuery("#language-table")).hide().fadeIn(100);
				jQuery("#language")[0].selectedIndex = 0;
				jQuery("#spoken")[0].selectedIndex = 0;
				jQuery("#written")[0].selectedIndex = 0;
				
			}
			
		})
		return false;
	});
	
});