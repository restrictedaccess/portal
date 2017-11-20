(function($) {
	jQuery.noConflict();
	index = (function(){
		return {			
			show_status : function(msg) {
				$('#loading', window.parent.document).fadeOut(5000);
			},
			clear_entry : function() {
				$('form#actform input[name=activity_details]').val('');
				$('button#create').attr('disabled', true);
				//$(selector).removeAttr('disabled');
			},
			reload_page : function() {
				window.parent.location.reload(true);
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
													'src':'/portal/aclog/?item=activitylogs'})
					   .css({'width':'100%','padding':'1px','margin':'1px','float':'left','overflow':'hidden'}) );
					   //.load(function(){pindex.calcHeight();alert($('#ifrtime').height());}));
		$('#ifrtime').load(function() {
			var ifheight = $(this).contents().find('body').height();
			$(this).height(ifheight);
		});
		
		//logger.init();
		
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
		
		//$('div#staffrate').jqm({ajax: '@href', trigger: 'a#hrrate'});
		//$('div#cutoff').jqm({ajax: '@href', trigger: 'a#cutoffdate'});
		
		$('a#reload').click(function(){
			var iframesrc = $('#ifrtime').attr('src', function(i, val){return val;});
		});
		
		$('button#create').click(function(e){
			if($('form#actform input[name=activity_details]').val() == "") e.preventDefault();
			$('form#actform').submit();
			$(this).attr('disabled', true);
		})
		.attr('disabled', true);
		
		$('form#actform input[name=activity_details]').focus().keyup(function(event){
			var wfsel = $('select[name=workflow]');
			if($.trim($(this).val()) != '') $('button#create').removeAttr('disabled');
			else {
				if(wfsel.val()=='0') $('button#create').attr('disabled', true);
			}
		}).val('');
		
		$('form#actform').submit(function(){
			var ifrwin = $('#ifrtime');
			var act = ifrwin.contents().find('table#myactivity tr:first').find('th').eq(4);
			act.find('span').remove();
			var srcstate = ifrwin[0].contentWindow.logger.eventsrc_state();
			if(srcstate == 2) {
				// reconnect sse
				ifrwin[0].contentWindow.logger.init();
			}
			$("select[name=workflow] option[value=0]").attr("selected","selected");
		});
		
		$('select[name=workflow]').change(function(){
			var actdet = $('form#actform input[name=activity_details]');
			if($(this).val()=='0' && $.trim(actdet.val()) == '') {
					$('button#create').attr('disabled', true);
				return;
			}
			$('form#actform input[name=wfdetails]').val( $('select[name=workflow] option:selected').text());
			$('button#create').removeAttr('disabled');
			//if($(this).val()) $('button#create').removeAttr('disabled');
			//else $('button#create').attr('disabled', true);
		});
		
		$('#header ul li').hover(function(){
			var child = $(this).children('div');
			if(child == null) return;
			
			var timer = child.data('timer');
			
			if(timer) clearTimeout(timer);
			//var child = $(this).children('div');
			child.css({'display': 'block'});
			//$(this).find('div').addClass('over');
		}, function(){
			var child = $(this).children('div');
			if(child == null) return;
			//var li = $(this);
			/*child.data('timer', setTimeout(function(){
				child.css({'display': 'none'});//.removeClass('over');
			}, 500));*/
		});
		
		$('div#tasktypes').jqm({ajax: '@href', trigger: 'a#types'});
	});
})(jQuery);