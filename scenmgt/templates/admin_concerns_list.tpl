			<aside><!-- class='ui-state-active'>-->
			<div class="ui-widget-header">Client Concerns
			<a href='?/add_concern' id='addconcern' style='float:right;padding-right:6px;'>NEW</a>
			</div>
					<ul class='itemlist' id='concernlist'>
						{if $client_concerns|@count > 0 }
							{section name=idx loop=$client_concerns}
						<li>
							<label for='id_{$client_concerns[idx].id}' style='left:0;width:100%'>
							{$smarty.section.idx.index+1}.&nbsp;	<a href='{$client_concerns[idx].id}' id='open_concern'>{$client_concerns[idx].concern_title|truncate:50:"..."}</a>
							</label>
						</li>
							{/section}
						{else}
						<li value='0'>No client concern found</li>
						{/if}
					</ul>
			
			
				<!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>-->
			</aside>
			
			<section id="main">
				<div id='content_title' class='ui-widget-header'>Details</div>
				<div class='content_here'>Please wait...</div>
				<!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>-->
			</section>
		
			
			
		<div class='new_concern'>Please wait...</div>
		<div class='show_concern'>Please wait...</div>
		
		<div class='show_addconcern' id='dialog'><strong>Add New Concern</strong><span id='aid'></span><a href='#' id='add_close' style='float:right'>Close</a><hr>
		<form id='cform' method='post' target='ajaxframe' action='?/add_client_concern'>
		<div style='float:left;padding:4px 0;width:100%;'>
		  <p><strong>Client Concern Title:</strong>
		  <div id='div_testname' style='padding:0 6px 20px;'>
			<input type='text' name='concern_title' class='ui-state-active' style='width:100%'/>
		  </div>
		  </p>
		  <p style='text-align:center;'><button type="button" id="btn_no">Cancel</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <button type="button" id="btn_save">Save</button>
		  </p>
		</div>
		</form>
		</div>
		
		<!--<script type='text/javascript' src='static/js/scenmgt.js'></script>-->
		<script type='text/javascript'>
		{literal}
		jQuery(document).ready(function($){
			var content_here = $('.content_here');
			$('.show_addconcern').jqm({overlay: 50, 'modal':true, trigger: 'a#addconcern'});
			//$('.show_addconcern').jqm({ajax: '@href', trigger: 'a#addconcern'});
			//content_here.jqm({overlay: 0, 'modal':false, trigger: false});
			$('ul.itemlist').find('a').click(function(e){
				$('#loading').show();
				//var href = $(this).attr('href');
				var cid = $(this).attr('href');
				console.log('cid:'+cid);
				if(content_here.is(':hidden')) {
					$.get('?/show_concern', function(data) {
						content_here.show();
						content_here.html(data);
						
						//admin_qa.populateQuestions();
						admin_qa.showConcernQuestions(cid);
					});
					//content_here.jqm({ajax:'?/show_concern'}).jqmShow();
				} else {
					admin_qa.showConcernQuestions(cid);
					/*$.getJSON(href, function(data){
						//if(content_here.is(':hidden')) content_here.show();
						//console.log(data);
						$('#concern_title').text(data['concern_title']);
						$('input#concern_id').val(data['id']);
					
						admin_qa.populateQuestions();
						//content_here.html(data);
					});*/
					
				}
				
				//$('#content_title').text($(this).text());
				
				
				
				
				/*if(content_here.is(':visible')) {
					content_here.jqmHide();
					console.log('reload');
					content_here.jqm({ajax:href}).jqmShow();
				} else {
					content_here.jqm({ajax:href}).jqmShow();
				}*/
				e.preventDefault();
				//$('.show_addconcern').jqmHide();
			});
			$('a#add_close').add('button#btn_no').click(function(){
				$('.show_addconcern').jqmHide();
			});
			
			$('button#btn_save').click(function(){
				var concern_title = $('input[name=concern_title]').val();
				if($.trim(concern_title) == "") return;
				$(this).attr('disabled', true);
				$('#loading').show();
				$('form#cform').submit();
			});
			//window.frames['myIFrame'].document.getElementById('myIFrameElemId')
			
		});
		{/literal}
	</script>
	</body>
	
</html>
