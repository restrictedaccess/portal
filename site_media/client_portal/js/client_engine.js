var baseUrl = ""
var djangoBase = "/portal/django/client_portal"
var CURRENT_PAGE = "";

var current;
var c_id;

var chat_hash_code;
jQuery(document).ready(function(){
	
	
	
	CURRENT_PAGE = window.location.pathname;
	current = new Date();
	check_php_session();
	
	jQuery.get(baseUrl+"/portal/client_api_service/c_info.php", function(response){
		response = jQuery.parseJSON(response);
		if (response.success){
			c_id = response.client_id;
			chat_hash_code = response.hash_code;
			jQuery.get(djangoBase+"/session_set/?client_id="+response.client_id, function(response){
				
			})
		}
	})
	
	jQuery.get(baseUrl+"/portal/client_api_service/c_price.php", function(response){
		response = jQuery.parseJSON(response);
		if (response.success){
			jQuery("#credits").html(response.credits);
			jQuery("#staffs").html(response.staffs);
			jQuery("#days").html(response.number_of_days_credit);
			
			
			if(response.days_before_suspension == "-30"){
				jQuery(".buy_credits").addClass("hide");
				if(window.location.pathname == "/portal/django/client_portal/top_up/"){
					location.href = "/portal/django/client_portal/";
				}
			}
						
		}
	})
	
	
	jQuery(window).on('beforeunload', function(){
		logTimeOfStay();
	});
	
	
	jQuery(".chat_launcher").on("click", function(e){
		popup_win("/portal/rschat.php", 800, 600);
		
		e.preventDefault();
	})
	
	jQuery(".popup_launcher").on("click", function(e){
		popup_win(jQuery(this).attr("href"), 800, 600);
		e.preventDefault();
	})
});
jQuery(document).on("click", ".toggle_hide", function(e){
	hideSidebar();
})
jQuery(document).on("click", ".toggle_show", function(e){
	showSidebar();
})

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

function logTimeOfStay(){
	var logout_current = new Date();
	var diff = logout_current.getTime() - current.getTime();
	CURRENT_PAGE = window.location.pathname;
	if (c_id){
		var data = {
			p:CURRENT_PAGE,
			ms:diff
		};
		jQuery.ajax({
			url: baseUrl+"/portal/client_api_service/ltime.php",
			type: 'POST',
		    data: JSON.stringify(data),
		    contentType: 'application/json; charset=utf-8',
		    dataType: 'json',
		    async:false,
		    success: function(response) {
		    
		    }
		});
	}
}
function hideSidebar(){
	jQuery(".text").hide();
  	jQuery("#main_sidebar .navbar-nav > .active > a").css("background-image", "none");
  	jQuery(".side-nav").css("width", "50px");
  	jQuery("#wrapper").css("padding-left", "50px");
  	jQuery(".toggle_hide").removeClass("toggle_hide").addClass("toggle_show");
}

function showSidebar(){
	jQuery("#main_sidebar .navbar-nav > .active > a").attr("style", "");
	  jQuery(".side-nav").attr("style", "");
	  jQuery("#wrapper").attr("style", "");
	  jQuery(".text").show();
	  jQuery(".toggle_show").removeClass("toggle_show").addClass("toggle_hide");
}

function check_php_session(){
	var data = {json_rpc:"2.0", id:"ID2", method:"check_php_session", params:["2011-09-02 17:04:00"]};
	jQuery.ajax({
	    url: baseUrl+"/portal/client/ClientSubconManagementService.php",
	    type: 'POST',
	    data: JSON.stringify(data),
	    contentType: 'application/json; charset=utf-8',
	    dataType: 'json',
	    async:false,
	    success: function(response) {
	    	if (response.result!=undefined){
	    		var update_data = {json_rpc:"2.0", id:"ID3", method:"update_django_session", params:[response.result]};
	    		jQuery.ajax({
	    			url:"/portal/django/client_subcon_management/jsonrpc/",
	    			type: 'POST',
	    			data: JSON.stringify(update_data),
	    			contentType: 'application/json; charset=utf-8',
				    dataType: 'json',
				    async:false,
				    success:function(result){
				    	if (result.result=="ok"){
				    		
				    	}else{
				    		window.location.href = "/portal/";
				    	}
				    }
	    		});
	    	}else{
	    		window.location.href = "/portal/";
	    	}

	    }
	})
	
}
