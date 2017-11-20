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
	jQuery.get("/portal/pop_first_run.php", function(response){
		response = jQuery.parseJSON(response);
		if (response.success){
			jQuery('#rschat_pop').modal({backdrop:"static", keyboard:false});
			jQuery("#close_rs_chat_pop").attr("data-email", response.email);
		}
	});
	
	jQuery(".chat_launch").on("click", function(e){
		var href = jQuery(this).attr("href");
		popup_win(href, 700, 600);
		e.preventDefault();
	});
	
	jQuery("#close_rs_chat_pop").on("click", function(){
		var href = "/portal/rschat.php?email="+jQuery(this).attr("data-email");
		popup_win(href, 700, 600);
	})
});