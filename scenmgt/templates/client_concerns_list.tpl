<strong>View Concerns List: </strong> <a href='#' class='jqmClose' style='float:right'>Close</a><hr style='width:100%'>
	<div style="float:left;width:100%;height:100%;padding:4px;overflow:hidden;overflow-y:hidden;">
		
			<div id="tabular">
			<form id='addform' method='post' target='ajaxframe' action='?/add_concern/'>	
			<input type='hidden' name='leads_id' value='{$leads_id}'/>
		
				<div id='content-container'>
					
					<div id='leftpane' style='width:250px;'>
						<div class="ui-widget-header">Client Concern
						<!--<a href='?/add_concern/11' id='addconcern' style='float:right;padding-right:6px;'>ADD NEW</a>-->
						</div>
						<ul class='itemlist' id='concerns'>
								{if $client_concerns|@count > 0 }
							{section name=idx loop=$client_concerns}
							<li>
								<label for='id_{$client_concerns[idx].id}' style='left:0;width:100%'>
								{$smarty.section.idx.index+1}.&nbsp;	<a href='{$client_concerns[idx].id}' id='open_concern'>{$client_concerns[idx].concern_title|truncate:50:"..."}</a>
								</label>
							</li>
							{/section}
							{/if}
						</ul>
								
								<p>
								<input type='text' name='client_concern' style='width: 98%;'/>
								</p>
								
							
								
						
					</div>
					<div id='rightpane'>
						<div class="ui-widget-header">Selected Concerns</div>
						<div class='contentholder' style='height:auto;width:100%;'>
							<ul class='itemlist' id='staffmember'></ul>
							
						</div>
					</div>
				</div>
		
			</form>
			</div>
    </div>
	
	
	<div class='show_addconcern' id='dialog'><strong>Add New Concern</strong><span id='aid'></span><a href='#' id='add_close' style='float:right'>Close</a><hr>
	<form id='typeform' method='post' target='ajaxframe' action='?item=savetype'>
			<input type='hidden' name='leads_id'/>
	<div style='float:left;padding:4px;width:100%;'>
	  <p><strong>Client Concern Title:</strong>
	  <div id='div_testname' style='padding:0 0 6px 30px;'>
		<input type='text' name='concern_title' class='ui-state-active' style='width:230px'/>
	  </div>
	  </p>
	  <p style='text-align:center;'><button class='jqmClose' type="button" id="btn_no">Cancel</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <button type="button" id="btn_yes">Save</button>
	  </p>
	</div>
	</form>
	</div>
	
	
	<script type='text/javascript'>
		{literal}
		jQuery(document).ready(function($){
				$('button#addfile').click(function(){
					$(this).attr('disabled', true);
					$('#loading').show();
					$('form#addform').submit();
					
				});
				
				$('button#newconcern').click(function(){
				    var pre_concern = $('input[name=pre_clientconcern]:checked').val();
				    var text_inp = $('input[name=client_concern]').val();
					
					console.log(pre_concern);
					if(pre_concern == undefined || (pre_concern==0 && $.trim(text_inp) == "")) return false;
					$(this).attr('disabled', true);
					$('#loading').show();
					$('form#addform').submit();
				});
				
				$('.jqmClose').click(function(){
						$('div.show_files').jqmHide();
				});
				
				//$('.show_addconcern').jqm({ajax: '@href', trigger: 'a#addconcern'});
				$('.show_addconcern').jqm({overlay: 0, 'modal':false, trigger: 'a#addconcern'});
				$('a#add_close').click(function(){
					$('.show_addconcern').jqmHide();
					});
				
				$('#ifcontent').contents().find('input[name^="selstaffmember\\[\\]"]').each(function(){
						if($(this).attr('checked')) {
								var inp_id = $(this).attr('id');
								var val_name = $(this).val().split('-');
								$('form#addform').append( $('<input/>').attr({'type':'hidden', 'name':'userid[]'}).val(val_name[0]) );
								console.log($(this).attr('checked')+' - '+$(this).val());
								$('ul#staffmember').append($('<li/>')
														   .append($('<label/>').attr('for', inp_id)
																   .css('left','0')
																   .text(val_name[1]))
														   );
						}
				});
				
				
				//window.frames['myIFrame'].document.getElementById('myIFrameElemId')
				//var selectuser = window.frames['']document.getElementsByName("selectUser[]");
		});
		{/literal}
	</script>
	<script src="static/js/call-split-container.js"></script>

