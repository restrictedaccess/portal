
$.center = function () {
    var top, left;

//    top = Math.max($(window).height() - $("div#prompt").outerHeight(), 0) / 2;
//    left = Math.max($(window).width() - $("div#prompt").outerWidth(), 0) / 2;
//
//    $("div#prompt").css({
//        top:top + $(window).scrollTop(), 
//        left:left + $(window).scrollLeft()
//    });

              var divHeight = $("div#prompt").height();
              var divWidth = $("div#prompt").width();
          
          
              divHeight += 88;
              var marginTop = -(divHeight /2);
              divWidth += 30 ;
              var marginLeft = -(divWidth / 2);
              

              marginTop += "px";
              marginLeft +="px";
            
              $("#prompt").css("margin-top", marginTop);
              $("#prompt").css("margin-left", marginLeft);
};

$.prompt = function(msg)
{
    var contetnt ="";
    
    contetnt+=msg;
    $("#prompt").html(contetnt);
    
    $("div#prompt").css({
        width: msg.width || 'auto', 
        height: msg.height || 'auto'
    });
    
    
    $.center();
    $("div#blackOut").fadeTo(550, 0.8);
    $("div#prompt").fadeTo(550, 1);
//    
      $("html, body").animate({
                scrollTop:0
                },"slow");
    
    

};
