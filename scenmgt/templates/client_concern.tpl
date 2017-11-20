<div class='ui-state-highlight' id='concern_title'>{$concern.concern_title}</div>
	<div style="float:left;width:100%;height:auto;padding:4px;overflow-x:hidden;overflow-y:scroll;">
		
			<div id="tabular">
			<form id='addform' method='post' target='ajaxframe' action='?/add_concern/'>
			<input type='hidden' name='leads_id'/>
		
				<div id='content-container'>
					
					<div id='leftpane'>
						<div class="ui-widget-header">Questions
						<a href='#' id='addquestion' style='float:right;padding-right:6px;'>ADD QUESTION</a>
						</div>
						
						<ul class='itemlist' id='concerns'>
								<li>
								<label for='id'>Question #1?</label>
							</li>
							
						</ul>
								
							
								
						
					</div>
					<div id='rightpane'>
						<div class="ui-widget-header">Possible Answers</div>
						<div class='contentholder' style='height:auto;width:100%;'>
							<ul class='itemlist' id='staffmember'>
								<li><label for='id'>1. Answer a</label></li>
							</ul>
							
						</div>
					</div>
				</div>
		
			</form>
			</div>
    </div>
	<!--<div style='float:right;padding-top:8px'><button name='submit' id='addfile'>Add Client Concern</button></div>-->
	
	<div class='show_addquestion' id='dialog'><strong >Add New Question</strong><span id='aid'></span><a href='#' class='jqmClose' style='float:right'>Close</a><hr style='width:100%'>
	<form id='qform' method='post' target='ajaxframe' action='?/add_question/'>
			<input type='hidden' name='concern_id' id='concern_id'/>
	<div style='float:left;padding:4px;width:100%;'>
	  <p><div class='ui-state-highlight'>Enter question here:</div>
	  <div id='div_testname'>
		<textarea name='concern_question' class='ui-state-active' rows='3' style='width:97%'></textarea>
	  </div>
	  </p>
	  <p style='text-align:center;'><button class='jqmClose' type="button" id="btn_no">Cancel</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <button type="button" id="btn_yes">Save</button>
	  </p>
	</div>
	</form>
	</div>
	<style type='text/css'>
		{literal}
		textarea[name=concern_question] {resize: none;}
		{/literal}
	</style>

	<script type='text/javascript'>
		{literal}
		jQuery(document).ready(function($){
			$('button#btn_yes').click(function(){
				$(this).attr('disabled', true);
				$('#loading').show();
				$('form#qform').submit();
					
			});
			$('.jqmClose').click(function(){
					$('div.show_files').jqmHide();
			});
				
			//$('.show_addconcern').jqm({ajax: '@href', trigger: 'a#addconcern'});
			//$('.show_addconcern').jqm({overlay: 50, 'modal':true, trigger: 'a#addconcern'});

			$('a#add_close').click(function(){
				$('.show_addconcern').jqmHide();
			});
				
			$('#ifcontent').contents().find('input[name^="selstaffmember\\[\\]"]').each(function(){
					if($(this).attr('checked')) {
							var inp_id = $(this).attr('id');
							var val_name = $(this).val().split('-');
							console.log($(this).attr('checked')+' - '+$(this).val());
							$('ul#staffmember').append($('<li/>')
													   .append($('<label/>').attr('for', inp_id)
															   .css('left','0')
															   .text(val_name[1]))
												   );
					}
			});
				
		$('.show_addquestion').jqm({overlay: 50, 'modal':true, trigger: 'a#addquestion'});
				
				//window.frames['myIFrame'].document.getElementById('myIFrameElemId')
				//var selectuser = window.frames['']document.getElementsByName("selectUser[]");
		});
		{/literal}
	</script>
	<script src="static/js/call-split-container.js"></script>

