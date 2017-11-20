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
	jQuery(".activity_loader").click(function(e){
		var me = jQuery(this);
		var state = me.attr("data-state");
		if (state=="closed"){
			if (me.attr("data-long-history")==undefined){
				jQuery.get("/portal/recruiter/get_applicant_history_notes.php?id="+me.attr("data-id"), function(response){
					response = jQuery.parseJSON(response);
					me.attr("data-long-history", response.history);
					me.html(response.history);
					me.attr("data-state", "open");
				});	
			}else{
				me.html(me.attr("data-long-history"));
				me.attr("data-state", "open");
			}
			
		}else{
			me.html(me.attr("data-history"));
			me.attr("data-state", "closed");
		}
		e.preventDefault();
	});
	
	jQuery(".resume_launcher").click(function(e){
		popup_win(jQuery(this).attr("href"), 800, 600)
		e.preventDefault();
	})
})
