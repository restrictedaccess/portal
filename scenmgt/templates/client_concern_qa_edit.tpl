
<strong id='concern_title'>{$question[0].concern_title}</strong> <a href='#' id='win_close' style='float:right'>Close</a><hr style='width:100%'>

<div id="ccqa" style="float:left;width:100%;padding-right:20px;">
    <div class='tableheader'>Questions List<br/></div>
			
		<form id='qeform' method='post' target='ajaxframe' action='?/edit_question/'>
				<input type='hidden' name='question_id' id='question_id' value='{$question[0].id}'/>
		<div class='staffname'></div>
		<!--<div class='date_range'>{$results|@count} record/s found.  {$from_date} to {$to_date}</div>-->
		
		<div id="tabular">
		
				
		<table id='qetbl' summary="QuestionsListing" style='float:left'>
			<tbody>
           	<tr>
				<th scope="col" class="data">
				<span class="hidden">Data Name</span>
				</th>
				<th scope="col">Question</th>
			</tr>
			
			
			<tr>
				<td class="number">{$question[0].id}</td>
				<td><textarea rows='2' name='question_text' class='ui-state-highlight addp'>{$question[0].question_text|replace:'\\':''}</textarea>


				</td>
			</tr>
			
			
		</tbody>  
		</table>

	</div>
		
	<div class='tableheader'>Possible Response <span id='qctr'></span><br/></div>
			
		
		<div class='staffname'></div>
		<!--<div class='date_range'>{$results|@count} record/s found.  {$from_date} to {$to_date}</div>-->
		
		<div id="tabular">
	
		<table id='aetbl' summary="AnswerListing" style='float:left'>
			<tbody>
           	<tr>
				<th scope="col" class="data">
				<span class="hidden">Data Name</span>
				</th>
				<th scope="col" style='width:100%'>Response</th>
			</tr>
			
			<!--<tr>
				<td class="number">A*</td>
				<td id='newtda'>
					{if !$modal}<textarea rows='2' name='new_a' class='ui-state-highlight addp'/>&nbsp;
						<button id='new_a_btn' type='button' class='inputbtn'>add</button>
						{/if}
				</td>
			</tr>-->
			
		</tbody>
                    
		</table>
		
	</div>
		<div style='float:right;padding-top:8px'><button type='button' id='updatequestion'>Update</button></div>
		</form>
</div>





	<style type='text/css'>
		{literal}
		#tabular {float:left;}
		#tabular table{float:left;}
		#tabular table th.data {width:20px;}
		#tabular table td {text-align:left;padding:2px 0 0 4px;}
		#tabular table td input, textarea{text-align:left;display:inline;border:1px solid #FCEFA1 !important;}
		#tabular table td input.addf, textarea.addf{width:91%;}
		#tabular table td input.addp, textarea.addp{width:93%;}
		textarea{resize:none;}
		td.response, td.questions{cursor:pointer;}
		{/literal}
	</style>
	<!--script src="static/js/admin_qa.js"></script-->
	<script type='text/javascript'>
		{literal}
		jQuery(document).ready(function($){
		    $('a#win_close').click(function(){
				$('.show_concern').jqmHide();
			});
			$('button#updatequestion').click(function(){
				$(this).attr('disabled', true);
				$('#loading').show();
				$('form#qeform').submit();
			});
		{/literal}
			{if $modal}
				admin_qa.showConcernQuestions({$cid}, false);
			{/if}
		{literal}
		});	
		{/literal}
	</script>
	

