{include file='header_global.tpl'}
		<div id="wrapper" class='ui-widget-content' style='float:left'>
		
			{include file='header.tpl'}
		<div id='main-container'>Please wait...</div>
		
			
	
		</div>
		{literal}
		<!--<style type='text/css'>
				.ui-state-hover{padding: inherit !important;}
		</style>-->
		{/literal}
		<!--<script type='text/javascript' src='static/js/scenmgt.js'></script>-->
		<script type='text/javascript'>
		{literal}
		(function($){
		$(document).ready(function(){
			//$('.show_addconcern').jqm({ajax: '@href', trigger: 'a#addconcern'});
			$('header nav ul').find('li:eq(1) a')
				.css({'background':'#0073EA','color':'#fff'});
				
			$('#main-container').jqm({overlay: 0, ajax:'?/admin_{/literal}{$content}/{$param}{literal}/', trigger: false}).jqmShow();
			$('aside').find('a').click(function(e){
				var href = $(this).attr('href');
				console.log(href);
				$('.content_here').jqm({ajax:href}).jqmShow();
				e.preventDefault();
				//$('.show_addconcern').jqmHide();
			});
				
			//window.frames['myIFrame'].document.getElementById('myIFrameElemId')
			//var selectuser = window.frames['']document.getElementsByName("selectUser[]");
			/*$('header ul li a').hover(function(){
				$(this).addClass('ui-state-hover');
			}, function(){
				$(this).removeClass('ui-state-hover');
			});*/
				
			/*$('header ul li').hover(function(){
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
			});*/
			
			$("header nav ul li:first").addClass("ui-state-active"); //Activate first tab
			
			$(window).keydown(function(e){
				if(e.keyCode == 13 && e.target.nodeName == 'INPUT') {
				  e.preventDefault();
				  return false;
				}
			});
		});
		})(jQuery);
		{/literal}
	</script>
{include file='footer.tpl'}