(function($) {
	jQuery.noConflict();
	misc = (function(){
		return {
			show_status : function(msg) {
				$('#loading', window.parent.document).fadeOut(5000);
			},
			enable_button : function(selector) {
				$(selector, window.parent.document).removeAttr('disabled');
			}
		}
	}());
	$(document).ready(function() {
		/*$('#loading').ajaxStart(function() {
			$(this).show();
		}).ajaxStop(function() {
			$(this).hide();
		});*/
		$('#container').append( $('<iframe/>').attr({'id': 'ifrtime', 'name': 'ifrtime', 'frameborder': '0', 'scrolling':'no',
													'src':'/portal/payroll/index.php?item=processtime&view='+window.view_name})
					   .css({'width':'100%','padding':'1px','margin':'1px','float':'left','overflow':'hidden'}) );
					   //.load(function(){pindex.calcHeight();alert($('#ifrtime').height());}));
		$('#ifrtime').load(function() {
			var ifheight = $(this).contents().find('body').height();
			$(this).height(ifheight);
		});
		
		$('#header ul li').hover(function(){
			//alert('hover');
			var child = $(this).children('div');
			if(child == null) return;
			
			var timer = child.data('timer');
			
			if(timer) clearTimeout(timer);
			//var child = $(this).children('div');
			child.css({'display': 'block'});
			//alert(child.html());
			//$(this).find('div').addClass('over');
		}, function(){
			var child = $(this).children('div');
			if(child == null) return;
			
			//var li = $(this);
			child.data('timer', setTimeout(function(){
				child.css({'display': 'none'});//.removeClass('over');
			}, 500));
		});
		
		$('div#staffrate').jqm({ajax: '@href', trigger: 'a#hrrate'});
		$('div#cutoff').jqm({ajax: '@href', trigger: 'a#cutoffdate'});
		$('div#holidays').jqm({ajax: '@href', trigger: 'a#holi'});
		
		$('a#reload').click(function(){
			var iframesrc = $('#ifrtime').attr('src', function(i, val){return val;});
		});
		
		$(document).scroll(function() {
			 //$('#ifrtime', window.parent.document).offset().top
			var ifrbox = parseInt($('#ifrtime').offset().top);
			var currentScrollTop = $(this).scrollTop();
			var tabheadfixed = $('div#tabheadfixed');
			//console.log(' scroll: ' + currentScrollTop+'  boxtop:'+ifrbox+ '    prevscroll:'+prevScrollTop);
			if (currentScrollTop > ifrbox && tabheadfixed.length == 0) {
				$('#container').append( $('<div/>').attr({'id':'tabheadfixed'})
									   .css({'float':'left','width':'97.6%','top':'0','position':'fixed'})
									   .append( $('<div/>').addClass('tabular')
											   .append("<table summary='StaffListing'>"+
													   "<tbody><tr id='tabtitle'><th scope='col' class='data'>"+
													   "<span class='hidden'>Data Name</span></th>"+
													   "<th scope='col'>Contract Hours</th>"+
													   "<th scope='col'>Total Adjusted Hours</th>"+
													   "<th scope='col'>Total Regular Hours</th>"+
													   "<th scope='col'>Overtime</th>"+
													   "<th scope='col'>Undertime</th>"+
													   "<th scope='col'>Rest Day Hours</th>"+
													   "<th scope='col'>Rest Day OT</th>"+
													   "<th scope='col'>NightDiff Hrs</th>"+
													   "<th scope='col'>NightDiff Hrs OT</th>"+
													   "<th scope='col'>Total Regular Pay</th>"+
													   "<th scope='col'>Total OT Pay</th>"+
													   "<th scope='col'>Total NightDiff Pay</th>"+
													   "<th scope='col'>NightDiff OT Pay</th>"+
													   "<th scope='col'>Total Restday Pay</th>"+
													   "<th scope='col'>Total Rest OT Pay</th>"+
													   "<th scope='col'>Total</th></tr></tbody></table>")
											   )
								);
				//down
				/*if( boxtop < currentScrollTop ) {
					$('tr#tabtitle').addClass('tabtitlefixed');
				} */    
			} else {
				//up
				//console.log(' scroll: ' + currentScrollTop+'  boxtop:'+boxtop);
				if(ifrbox > currentScrollTop && tabheadfixed.length > 0) {
					tabheadfixed.remove();
				}
			}
			prevScrollTop = currentScrollTop ;
		});
		
		var prevScrollTop = $(this).scrollTop();
		
	});
})(jQuery);