jQuery.noConflict();
(function($){
	ptime = (function(){
		return {
			hide_loading : function() {
				$('#loadingimg', window.parent.document).remove();
			}
		}
	}());
	$(document).ready(function() {
		//var prevScrollTop = $('html,body', window.parent.document).scrollTop();
		var frametop = $('#ifrtime', window.parent.document).offset().top
		//$('#timesheet').jqm({overlay: 50, modal: true, trigger: false});
		$('#timesheet').jqm({ajax: '@href', trigger: 'a.stafflink'});
		
		$('a.stafflink').click(function(){
			//var useraccnt = $(this).attr('href').split('#')[1];
			var parentScrollTop = $(window.parent).scrollTop();
			//$(body).prepend(parentScrollTop+'-'+frametop);
			if(parentScrollTop > frametop) $('#timesheet').css({'top':(parentScrollTop-frametop)+'px'});
			else $('#timesheet').css({'top':'0'});

			//$('#timesheet').jqmShow();
		});
		
		/*$(window.parent).scroll(function() {
			var currentScrollTop = $(this).scrollTop();
			console.log(' scroll: ' + currentScrollTop+'  boxtop:'+boxtop);
			if (currentScrollTop > prevScrollTop) {
				//down
				if( boxtop < currentScrollTop ) {
					$('tr#tabtitle').addClass('tabtitlefixed');
				}     
			} else {
				//up
				//console.log(' scroll: ' + currentScrollTop+'  boxtop:'+boxtop);
				if( boxtop > currentScrollTop ) {
					$('tr#tabtitle').removeClass('tabtitlefixed');
				}
			}
			prevScrollTop = currentScrollTop ;
		});
		
		var prevScrollTop = $(window.parent).scrollTop();*/
		var boxtop = $('tr#tabtitle').offset().top;
	});
})(jQuery);