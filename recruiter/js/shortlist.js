function popup_win( loc, wd, hg ) {
   var remote = null;
   var xpos = screen.availWidth/2 - wd/2; 
   var ypos = screen.availHeight/2 - hg/2; 
   remote = window.open('','','width=' + wd + ',height=' + hg + ',resizable=0,scrollbars=1,screenX=0,screenY=0,top='+ypos+',left='+xpos);
   if (remote != null) {
      if (remote.opener == null) {
         remote.opener = self;
      }
      remote.location.href = loc;
      remote.focus();
   } 
   else { 
      self.close(); 
   }
}

jQuery(document).ready(function(){
	jQuery("#shortlist-staff").submit(function(){
		
		var found = false;
		jQuery("input[name=position]").each(function(){
			if (jQuery(this).is(":checked")){
				found = true;
				return false;
			}
		});
		if (!found){
			alert("Please select one of the job position to continue shortlisting the candidate");
		}
		return found;
	});
	var oldKeyword = "";
	
	jQuery("#search").click(function(e){
		var keyword = jQuery("#keyword").val();
		oldKeyword = keyword;
		jQuery.post("/portal/recruiter/search_shortlist.php", {keyword:keyword}, function(data){
			jQuery("#list").html(data);
		});		
	//	e.stopPropagation();
		return false;
		
	});
	
	var sorters = [];
	
	jQuery(".sortable").live("click", function(e){
		var column = jQuery(this).attr("data-column");
		if (jQuery(this).attr("data-sorting")==""||jQuery(this).attr("data-sorting")==undefined){
			jQuery(this).attr("data-sorting", "asc");
		}else if (jQuery(this).attr("data-sorting")=="asc"){
			jQuery(this).attr("data-sorting", "desc");
		}else{
			jQuery(this).attr("data-sorting", "");
		}
		
		var oldSorters = sorters;
		var newSorters = [];
		newSorters.push({column:jQuery(this).attr("data-column"), sorting:jQuery(this).attr("data-sorting")});
		
		for(var i=0;i<jQuery(".sortable").length;i++){
			var temp = oldSorters[i];
			if (temp!=undefined){
				if (temp.column!=jQuery(this).attr("data-column")){
					newSorters.push(temp);
				}
			}
		}
		
		sorters = newSorters;
		
		var me = jQuery(this);
		
		jQuery(".sortable").each(function(i, item){
			if (jQuery(item).attr("data-column")!=me.attr("data-column")){
				sorters.push({column:jQuery(item).attr("data-column"), sorting:jQuery(item).attr("data-sorting")});				
			}
		});
		
		jQuery.post("/portal/recruiter/search_shortlist.php", {keyword:oldKeyword, sorters:sorters}, function(data){
			jQuery("#list").html(data);
		});		
		e.preventDefault();
	});
	
	
	
});