<strong>Client Concern Input: </strong> <a href='#' class='jqmClose' style='float:right'>Close</a><hr style='width:100%'>
	<div style="float:left;width:100%;height:240px;padding:4px;overflow-x:hidden;overflow-y:scroll;">
		
			<div id="tabular">
			<form id='addform' method='post' target='ajaxframe' action='?/add_concern/'>	
			<input type='hidden' name='leads_id' value='{$leads_id}'/>
		
				<div id='content-container'>
					
					<div id='leftpane' style='width:370px;'>
						<div class="ui-widget-header">Client Concern</div>
						<ul class='contact_list' id='conversations'>
								<p>
								<div class='ui-state-highlight'>Type in client concern below:</div>
							
								</p>
						</ul>
					</div>
					<div id='rightpane'>
						<div class="ui-widget-header">Staff that related to this concern</div>
						<div class='contentholder' style='height:auto;width:100%;'>
							<ul class='itemlist' id='staffmember'></ul>
							
						</div>
					</div>
				</div>
		
			</form>
			</div>
    </div>
	<!--<div style='float:right;padding-top:8px'><button name='submit' id='newconcern'>Add Client Concern</button></div>-->
	
	
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
				    var text_inp = $('textarea[name=client_concern]').val();
					if($.trim(text_inp) == "") return false;
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

