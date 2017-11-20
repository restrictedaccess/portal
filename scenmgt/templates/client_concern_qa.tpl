{if $modal}
<strong id='concern_title'></strong> <a href='#' class='jqmClose' style='float:right'>Close</a><hr style='width:100%'>
{/if}
<div id="ccqa" style="float:left;width:100%;padding-right:20px;">
    <div class='tableheader'>Questions List<br/></div>
			
		
		<div class='staffname'></div>
		<!--<div class='date_range'>{$results|@count} record/s found.  {$from_date} to {$to_date}</div>-->
		
		<div id="tabular">
		<form id='qform' method='post' target='ajaxframe' action='?/add_question/'>
				<input type='hidden' name='concern_id' id='concern_id'/>
		<table id='qtbl' summary="QuestionsListing" style='float:left'>
			<tbody>
           	<tr>
				<th scope="col" class="data">
				<span class="hidden">Data Name</span>
				</th>
				<th scope="col">Question</th>
			</tr>
			
			
			<tr>
				<td class="number add-q"></td>
				<td>{*if !$modal*}
				<span id='newq_holder'></span>
				    <!--<input type='text' name='newq_inp' class='ui-state-highlight add-inp'/>-->
						<!--<textarea rows='2' name='new_q' class='ui-state-highlight addp'/>&nbsp;
						<button id='new_q_btn' type='button' class='inputbtn'>add</button>-->
				{*/if*}
				</td>
			</tr>
			
			
		</tbody>  
		</table>
		</form>	
	</div>
		
	<div class='tableheader' id='resp-header'></div>
			
		
		<div class='staffname'></div>
		<!--<div class='date_range'>{$results|@count} record/s found.  {$from_date} to {$to_date}</div>-->
		
		<div id="tabular">
		<form id='aform' method='post' target='ajaxframe' action='?/add_answer/'>
				<input type='hidden' name='question_id' id='question_id'/>
		<table id='atbl' summary="AnswerListing" style='float:left'>
			<tbody>
           	<tr>
				<th scope="col" class="data">
				<span class="hidden">Data Name</span>
				</th>
				<th scope="col" style='width:100%'>Response {if !$modal}(<a href='#' id='hresplnk'>?</a>){/if}</th>
			</tr>
			
			<!--<tr>
				<td class="number">A1</td>
				<td class='response' id='ans1'>It’s not working out, she is not skilled enough for the position<span>add answer</span></td>
			</tr>
			<tr>
				<td class="number">&nbsp;</td>
				<td>follow-up questions</td>
			</tr>-->
			<!--<tr>
				<td class="number" style='text-align:right'>&#8594;</td>
				<td id='newtda'>q*:<input type='text' name='new_fupq' class='ui-state-highlight addf'/>&nbsp;
						<button class='inputbtn'>add</button>
				</td>
			</tr>
			<tr>
				<td class="number">A2</td>
				<td class='response' id='ans2'>Her internet is really bad, I like him but we can continue as his internet is very important</td>
			</tr>-->
			<!--<tr>
				<td class="number" style='text-align:right'>&#8594;</td>
				<td id='newtda'>q*:<input type='text' name='new_fupq' class='ui-state-highlight addf'/>&nbsp;
						<button class='inputbtn'>add</button>
				</td>
			</tr>-->
			
			<tr>
				<td class="number add-a"></td>
				<td id='newtda'>
					{*if !$modal*}
					<span id='newa_holder'>&nbsp;</span>
						<!--<input type='text' name='newa_inp' class='ui-state-highlight add-inp'/>-->
						<!--<textarea rows='2' name='new_a' class='ui-state-highlight addp'/>&nbsp;
						<button id='new_a_btn' type='button' class='inputbtn'>add</button>-->
						{*/if*}
				</td>
			</tr>
			
		</tbody>
                    
		</table>
		</form>
	</div>
		
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
		#tabular table td input.add-inp, textarea.add-inp{width:99%;margin:0 2px 2px 0;cursor:auto;}
		textarea{resize:none;}
		td.questions{cursor:pointer;}
		td.questions span.question-span{float:left; width:92%;}
		{/literal}
	</style>
	<!--<script src="static/js/admin_qa.js"></script>-->
	<script type='text/javascript'>
		{literal}
		
		ccqa.params = {};
		ccqa.params={/literal}{$params|@json_encode}{literal};
		ccqa.client_input={/literal}{$cci}{literal};
		ccqa.client_response={/literal}{$resp}{literal};
		jQuery(document).ready(function($){
		{/literal}
			{if $modal && $cid}
				admin_qa.showConcernQuestions({$cid}, false);
			{/if}
		{literal}
			$('a#hresplnk').click(function(){$('.show_helpwin').jqmShow();});
		});	
		{/literal}
	</script>
	

