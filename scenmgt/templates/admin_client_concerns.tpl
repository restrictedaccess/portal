		<div id="tabular">

		
				<div id='content-container'>
					
					<div id='leftpane' style='width:250px;'>
						<div class="ui-widget-header">Client Concerns
						<a href='?/add_concern' id='addconcern' class='ui-state-active' style='float:right;padding-right:6px;'>ADD</a>
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
					</div>
					<div id='rightpane'>
					{if $allowed}
						<div id='concern-header' class='ui-widget-header'><span id='content_title'>Details</span>
				
						</div>
						{/if}
						<div class='content_here'>Please wait...</div>
					</div>
				</div>
		
			</div>

			
			
		<div class='new_concern'>Please wait...</div>
		<div class='show_concern' style='top:3%;'>Please wait...</div>
		
		<div class='show_addconcern' id='dialog'><strong id='action_title' class='ui-state-focus'></strong><span id='aid'></span><a href='#' id='add_close' style='float:right'>Close</a><hr>
		<form id='cform' method='post' target='ajaxframe' action=''>
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
		
		<div class='show_helpwin' id='helpresponse'><strong id='action_title' class='ui-state-focus'>Response Help</strong><span id='aid'></span><a href='#' id='helpwin-close' style='float:right'>Close</a><hr>
		<div style='float:left;padding:4px 0;width:100%;font-size: 10px;'>
		  <p><strong>Response: A list of possible answer by the client.</strong><br/>
			Highlighted in <span style='background:#ADC09F'>faded green</span> rows.<br/>
			You must click on the question above to display the possible response list.<br/>
				<span>To add new response, just type in to the textbox provided and click on the plus sign button</span>
		  </p>
		  <p>
				<strong>Follow-up Question.</strong><br/>
				Indicated by right arrow and highlighted in <span style='background:#ffc'>light yellow</span> rows.<br/>
		  To add follow-up question just click on response row then a textbox will be shown.
		  </p>
		</div>
		</form>
		</div>
		
		<!--<script type='text/javascript' src='static/js/scenmgt.js'></script>-->
		<script type='text/javascript'>
		{literal}
		(function($){
			var concern_id = {/literal}{$concern_id}{literal};
			var modal = {/literal}{$modal}{literal};
			var allow = {/literal}{$allowed}{literal};
			admin_cc = (function(){
			return {
				loadContent : function(cid) {
					$.get('?/show_concern', function(data) {
						var content_here = $('.content_here');
						content_here.show();
						content_here.html(data);
						admin_qa.showConcernQuestions(cid);
					});
				}
			}
			}());
			$(document).ready(function(){
				var content_here = $('.content_here');
				$('.show_addconcern').jqm({overlay: 50, 'modal':true, trigger:false});
				//$('.show_addconcern').jqm({ajax: '@href', trigger: 'a#addconcern'});
				$('.show_helpwin').jqm({overlay: 50, 'modal':true, trigger:false});
				//content_here.jqm({overlay: 0, 'modal':false, trigger: false});
				$('ul.itemlist').find('a').click(function(e){
					$('#loading').show();
					//var href = $(this).attr('href');
					var cid = $(this).attr('href');
					console.log('cid:'+cid);
					if(content_here.is(':hidden')) {
						$.get('?/show_concern/', function(data) {
							content_here.show();
							content_here.html(data);
							
							//admin_qa.populateQuestions();
							admin_qa.showConcernQuestions(cid, allow);
						});
						//content_here.jqm({ajax:'?/show_concern'}).jqmShow();
					} else {
						admin_qa.showConcernQuestions(cid, allow);
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
					if( $('a#editconcern').length == 0) {
						$('#concern-header').append($('<div/>').css('float','right').addClass('ui-state-active')
									.append($('<a/>')
								   .attr({'href':'#', 'id':'editconcern'}).css({'float':'right','padding-right':'6px'})
								   .text('Delete')
								   .click(function(e){
										if(confirm("Delete client concern?")) {
											var cid = $('input#concern_id').val();
											if($('form#cform input[name=concern_id]').length == 0)
											$('form#cform').append($('<input/>').attr({'type':'hidden','name':'concern_id'}).val(cid));
											else $('form#cform input[name=concern_id]').val(cid);
											$('form#cform').attr('action','?/delete_client_concern');
											$('form#cform').submit();
											e.preventDefault();
										}
										
									}))
							.append($('<a/>')
								   .attr({'href':'#', 'id':'delconcern'}).css({'float':'right','padding-right':'6px'})
								   .text('Edit')
								   .click(function(e){
										//$('div.new_concern').jqm({ajax:'?/show_form/'+leads_id}).jqmShow();
										$('.show_addconcern').jqmShow();
										var cid = $('input#concern_id').val();
										console.log(cid);
										if($('form#cform input[name=concern_id]').length == 0)
											$('form#cform').append($('<input/>').attr({'type':'hidden','name':'concern_id'}).val(cid));
										else $('form#cform input[name=concern_id]').val(cid);
										$('#action_title').text( 'Edit' );
										$('input[name=concern_title]').val( $('#content_title').text() );
										$('form#cform').attr('action','?/edit_concern_title');
										e.preventDefault();
									})
								   )
							);
						
					}
					
					
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
				
				$('a#addconcern').click(function(e){
						$('.show_addconcern').jqmShow();
						console.log($('#content_title').text());
						$('#action_title').text( 'New Concern Link' );
						$('input[name=concern_title]').val('');
						$('form#cform').attr('action','?/add_concern_title');
						e.preventDefault();
					});
				
				$('a#add_close').add('button#btn_no').click(function(){
					$('.show_addconcern').jqmHide();
				});
				
				$('a#helpwin-close').click(function(){
					$('.show_helpwin').jqmHide();
				});
				
				$('button#btn_save').click(function(){
					var concern_title = $('input[name=concern_title]').val();
					if($.trim(concern_title) == "") return;
					$(this).attr('disabled', true);
					$('#loading').show();
					$('form#cform').submit();
				});
				//window.frames['myIFrame'].document.getElementById('myIFrameElemId')
				if(concern_id > 0) admin_cc.loadContent(concern_id);
			});
		})(jQuery);
		{/literal}
	</script>
	<script src="static/js/call-split-container.js"></script>
	</body>
	
</html>
