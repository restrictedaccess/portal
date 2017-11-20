jQuery(document).ready(function(){
	jQuery(".delete-language").live("click", function(e){
		var id = jQuery(this).attr("data-id");
		var me = jQuery(this);
		var answer = confirm("Do you want to delete this language?");
		if (answer){
			jQuery.post("/portal/personal/deletelanguage.php", {id:id}, function(data){
				data = jQuery.parseJSON(data);
				if (data.success){
					
					var languages = data.languages;
					var newOutput = '<tr><td width="6%" align="center">#</td><td width="33%" align="left"><b><font size="1">Language</font></b></td><td width="26%" align="center"><b><font size="1">Spoken</font></b></td><td width="35%" align="center"><b><font size="1">Written</font></b></td><td width="26%" align="center"><b><font size="1">Action</font></b></td></tr>';	
					jQuery.each(languages, function(i, item){
						var output = "<tr bgcolor='#f5f5f5'>";
						output+=("<td width='6%' align='center'><font size='1'>"+(i+1)+".</font></td>");
						output+=("<td width='33%'><font size='1'>"+(item.language)+"</font></td>");
						output+=("<td width='26%' align='center'><font size='1'>"+(item.spoken)+"yr.</font></td>");
						output+=("<td width='35%' align='center'><font size='1'>"+(item.written)+"</font></td>");
						output+=("<td width='26%' align='center'><font size='1'><a href='#' class='delete-language' data-id='"+(item.id)+"'>delete</a></font></td>");
						output+="</tr>";
						newOutput+=output;
					});
					jQuery("#language-table tbody").html(newOutput);
				}
			})
		}
		
		e.preventDefault();
	});
	jQuery("#addlanguage").submit(function(){
		
		
		if (jQuery("#language").val()==""){
			alert("Please select a language");
			return false;
		}
		var language = jQuery("#language").val();
		if (jQuery("#spoken").val()=="0"){
			alert("Please rate your "+language+" in terms of being spoken");
			return false;
		}
		if (jQuery("#written").val()=="0"){
			alert("Please rate your "+language+" in terms of being written");
			return false;
		}
		
		
		var formdata = jQuery(this).serialize();
		jQuery.post("/portal/personal/addlanguage.php", formdata, function(data){
			data = jQuery.parseJSON(data);
			if (data.success){
				var count = jQuery("#language-table tbody tr").length;
				var output = "<tr bgcolor='#f5f5f5'>";
				output+=("<td width='6%' align='center'><font size='1'>"+(count)+".</font></td>");
				output+=("<td width='33%'><font size='1'>"+(data.newlanguage.language)+"</font></td>");
				output+=("<td width='26%' align='center'><font size='1'>"+(data.newlanguage.spoken)+"yr.</font></td>");
				output+=("<td width='35%' align='center'><font size='1'>"+(data.newlanguage.written)+"</font></td>");
				output+=("<td width='26%' align='center'><font size='1'><a href='#' class='delete-language' data-id='"+(data.newlanguage.id)+"'>delete</a></font></td>");
				output+="</tr>";
				jQuery(output).appendTo(jQuery("#language-table")).hide().fadeIn(100);
				jQuery("#language")[0].selectedIndex = 0;
				jQuery("#spoken")[0].selectedIndex = 0;
				jQuery("#written")[0].selectedIndex = 0;
				alert("Added new language");
			}else{
				alert(data.error);
			}
			
		})
		return false;
	});
	
});