{include file='header_global.tpl'}
<link rel="stylesheet" href="/livechat/js/autocomplete/jquery.autocomplete.css" type="text/css" />
<script type="text/javascript" src="/livechat/js/autocomplete/jquery.autocomplete.min.js"></script>
		<div id="wrapper" class='ui-widget-content' style='float:left'>
		
			{include file='header.tpl'}
			
			<aside id="leftpane" class='ui-state-active'>
				<div id='selectclientlbl' class='ui-widget-header'></div>
				<div style='padding:2px;'>
				<input type='text' name='client_search' id='client_search' maxlength='20' style='width:99%'/>
				</div>
				
			</aside>
			
			<section id="main">
				<div id='client_name' class='ui-state-highlight'>
					<!--<a href='?/show_form/11' id='open_concern' style='float:left;padding-right:6px;font-weight:bold'>ADD CONCERN</a>
					Client Concern List (<span id='client_name'></span>)--></div>
				<div>
				<iframe id='ifcontent' name='ifcontent' frameborder='0' src='{if $leads_id > 0}?/staff_member/{$leads_id}{/if}'  style='width:100%;float:left;overflow:hidden;height:400px;'></iframe>
				</div>
				<!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>-->
			</section>
		
			
	
		</div>
		<div class='new_concern'>Please wait...</div>
		<div class='show_concern' style='top:3%;'>Please wait...</div>
		<div class='list_concern' style='top:20px;height:900px;'>Please wait...</div>
		
		<script type='text/javascript' src='static/js/scenmgt.js'></script>
		{literal}
		<script type='text/javascript'>
		(function($){
			$(document).ready(function(){
				$('header nav ul').find('li:last a')
				.css({'background':'#0073EA','color':'#fff'});
			});
		})(jQuery);
		</script>
		{/literal}

{include file='footer.tpl'}