jQuery(document).ready(function(){
	
	jQuery("a.sub-header").on("click", function(e){
		 $('#wrapper').removeClass('toggled');
		 $(".color-fade").css("opacity", "1");
		 $(".menu-vertical-border").css("height", "37px");
	});
	
	jQuery(".navigation-collapsed").on("click", function(e){
		if($(".nav-sub-header").hasClass("in")){
			 $(".menu-vertical-border").css("height", "40px");
		}else{
			$(".menu-vertical-border").css("height", "37px");
		}
	}); 
	
	jQuery(".header-toggle").hover(function(e){
  	jQuery(".header-toggle").attr("aria-expanded", "false");
  	jQuery(".header-toggle").closest("li").removeClass("open");
  	jQuery(this).attr("aria-expanded", "true"); 
  	jQuery(this).closest("li").addClass("open");
  });  
   
  var hoverTimeout;
	
	$('.header-dropdown').hover(function() {
	    clearTimeout(hoverTimeout);
	    jQuery(this).attr("aria-expanded", "true"); 
  		jQuery(this).closest("li").addClass("open");
	},  function() {
	    var $self = $(this);
	    hoverTimeout = setTimeout(function() {
	        jQuery(".header-toggle").attr("aria-expanded", "false");
  			jQuery(".header-toggle").closest("li").removeClass("open");
	    }, 10);
	});
	
	$('.header-toggle').hover(function() {
	    clearTimeout(hoverTimeout);
	    jQuery(this).attr("aria-expanded", "true"); 
  		jQuery(this).closest("li").addClass("open");
	},  function() {
	    var $self = $(this);
	    hoverTimeout = setTimeout(function() {
	        jQuery(".header-toggle").attr("aria-expanded", "false");
  			jQuery(".header-toggle").closest("li").removeClass("open");
	    }, 10);
	});
	

  var url = window.location.pathname;  
  var activePage = stripTrailingSlash(url);
  //console.log(url);
  //console.log(activePage);
  $('.nav-top-3 li a').each(function(){ 
    var currentPage = stripTrailingSlash($(this).attr('href'));
	//console.log(currentPage);
    if (activePage == currentPage) {
      $(this).parent().addClass('active-header'); 
    } 
  });
  
  $('#sidebar-wrapper li a').each(function(){ 
    var currentPage = stripTrailingSlash($(this).attr('href'));
	//console.log(currentPage);
    if (activePage == currentPage) {
      $(this).parent().addClass('active-header'); 
    } 
  });
  	 
});

 function stripTrailingSlash(str) {
    if(str.substr(-1) == '/') {
      return str.substr(0, str.length - 1);
    }
    return str;
  }
