<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB">
<head>
	<title>Client Feedback Form #{$result.leads_id}</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<!--<meta name="robots" content="index, follow" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />-->
    <link rel="stylesheet" type="text/css" href="static/styles.css" />
	<script type="text/javascript" src="/portal/js/jquery.js"></script>
	<script type="text/javascript" src="/portal/ticketmgmt/js/jqModal.js"></script>
	<script type="text/javascript" src="static/index.js"></script>
	<link rel="stylesheet" href="/portal/leads_information/media/css/clientfeedback.css">
	<style type='text/css'>
	{literal}
	* {
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
	}
	html { font-family: sans-serif; }
	div.container { padding: 20px 15%;}
	{/literal}
	</style>
</head>
<body>
<iframe id='ajaxframe' name='ajaxframe' style='display:none;height:10px;' src='javascript:false;'></iframe>
<span id='loading'>LOADING...</span>
<a href='/portal/adminHome.php'><div id='imghead'></div></a>
<div class='container'>
<div style='float:left;width:100%'>
	<div style="float:left;top:10px">Hi {$result.fname},
	<p>Thanks for getting in touch with me regarding "{$result.ticket_title|stripslashes}" last {$result.date_created}</p></div>
</div>
<!--<script type="text/javascript" src="/portal/aclog/js/report.js"></script>-->
	<div id="feedback" style="float:left;width:100%;border:1px solid #4D85A4;">
		<h3>Rate your Staffing Consultant</h3>
		
		<form action='#' method='post' id='surveyform' class='ff' target='ajaxframe'>
			<input id="leads_id" name="leads_id" type="hidden" value="{$result.leads_id}"/>
			<input id='fid' name='fid' type='hidden' value='{$result.id}'/>
			<header>
			  <!--<h3>Rate your Staffing Consultant</h3-->
			  <div>At Remote Staff, we are constantly looking to improve our products, services and support.  A big part of our process is obtaining
			  honest feedback from our valued clients.  Your quick survey will be reviewed by management, and any comments will be appreciated.</div>
			</header>
			
			<div>
			  <fieldset>
			  
				<legend id="title1" class="desc">Did your staffing consultant clearly understand your query?</legend>
				
				<div>
				 
					<ul>
				{foreach from=$clear_under item=choice name=idx}
				  <li>
					  <label class="choice" for="{$choice}">{$choice}</label>
					  <input id="{$choice|lower}" name="clunder" type="radio" value="{$choice}" tabindex="{$smarty.foreach.idx.index+1}" />
				  </li>
				  {/foreach}
				  
					</ul>
				</div>
				
			  </fieldset>
			</div>
			
			<div>
			  <fieldset>
			  
				<legend id="title2" class="desc">Was your staffing consultant polite and professional?</legend>
				
				<div>
					<ul>
					{foreach from=$poprof item=choice name=idx}
				  <li>
					  <label class="choice" for="Field5_0">{$choice}</label>
					  <input id="{$choice|lower}" name="poprof" type="radio" value="{$choice}" tabindex="{$smarty.foreach.idx.index}" />
				  </li>
				  {/foreach}
				  
					</ul>
				</div>
			  </fieldset>
			</div>
			
			<div>
			  <fieldset>
			  
				<legend id="title3" class="desc">Were you given clear and definite answers?</legend>
				
				<div>
					<ul>
				  {foreach from=$clear_def item=choice name=idx}
				  <li>
					  <label class="choice" for="{$choice}">{$choice}</label>
					  <input id="{$choice|lower}" name="cleardef" type="radio" value="{$choice}" tabindex="{$smarty.foreach.idx.index+1}"/>
				  </li>
				  {/foreach}
				  
					</ul>
				</div>
			  </fieldset>
			</div>
			  
			<div>
			  <fieldset>
			  
				<legend id="title4" class="desc">How fast your query resolved?</legend>
				
				<div>
					<ul>
				{foreach from=$how_fast item=choice name=idx}
				  <li>
					  <label class="choice" for="{$choice}">{$choice}</label>
					  <input id="{$choice|lower}" name="how_fast" type="radio" value="{$choice}" tabindex="{$smarty.foreach.idx.index+1}"/>
				  </li>
				  {/foreach}
				  
					</ul>
				</div>
			  </fieldset>
			</div>
			
			<div>
			  <fieldset>
			  
				<legend id="title5" class="desc">How would you rate your staffing consultant?</legend>
				
				<div>
					<ul>
					{foreach from=$rate item=choice name=idx}
				  <li>
					  <label class="choice" for="{$choice}">{$choice}</label>
					  <input id="{$choice|lower}" name="rate" type="radio" value="{$choice}" tabindex="{$smarty.foreach.idx.index+1}"/>
				  </li>
				  {/foreach}
				  
					</ul>
				</div>
			  </fieldset>
			</div>
			
			<div>
			  <fieldset>
			  
				<legend id="title6" class="desc">How was your overall customer experience?</legend>
				
				<div>
					<ul>
					{foreach from=$ovrallcustxp item=choice name=idx}
				  <li>
					  <label class="choice" for="{$choice}">{$choice}</label>
					  <input id="{$choice|lower}" name="ovrallcustxp" type="radio" value="{$choice}" tabindex="{$smarty.foreach.idx.index+1}"/>
				  </li>
				  {/foreach}
					</ul>
				</div>
			  </fieldset>
			</div>
			  
			<div>
			  <label class="desc" id="title7" for="Field4">Any feedback or comments?</label>
			
			  <div>
				<textarea id="comments" name="comments" spellcheck="true" rows="5" cols="50" tabindex="4">{$result.comments|stripslashes}</textarea>
			  </div>
			</div>
			
			
			  
			<div>
			  <fieldset>
			  
				<legend id="title8" class="desc">Would you like a reply to your feedback?</legend>
				
				<div>
					<div>
					  <label class="choice" for="replyno">No</label>
					  <input id="replyno" name="needreply" type="radio" value="no" tabindex="5" checked="checked">
				  </div>
				  <div>
					  <label class="choice" for="replyyes">Yes</label>
					  <input id="replyyes" name="needreply" type="radio" value="yes" tabindex="5">
				  </div>
				</div>
				<div>
				<input id="email" name="email" value="" style="width:50%" {if $result.reply eq 'no' || $result.reply eq ''}disabled='disabled'{/if}/>
			  </div>
			  </fieldset>
			</div>
			
			
			
			<div>
				  <div><input id="saveForm" name="saveForm" type="submit" value="Submit" {if $isOwner==0 || $result.status eq 'Filled'}disabled='disabled'{/if}></div>
			  </div>
		</form>
		
    </div>
	<p>&nbsp;</p>
	<p>Thanks,</p>
		{$result.admin_fname}
		<div class='csro_sig'>
		<p>
			{$result.signature_notes} <br/>
			{$result.signature_contact_nos}
		</p>
		<p>{$result.signature_websites}</p>
		</div>
</div>
<script type='text/javascript'>

{assign var='answers' value=$result.answers|@unserialize}
{if $answers.email}{assign var='email' value=$answers.email}
{else}{assign var='email' value=$result.email}{/if}
{literal}
jQuery(document).ready(function($) {
	$("input[name=clunder][value={/literal}{$answers.clunder}{literal}]").attr('checked', true);
	$("input[name=poprof][value={/literal}{$answers.poprof}{literal}]").attr('checked', true);
	$("input[name=cleardef][value={/literal}{$answers.cleardef}{literal}]").attr('checked', true);
	$("input[name=how_fast][value={/literal}{$answers.how_fast}{literal}]").attr('checked', true);
	$("input[name=rate][value={/literal}{$answers.rate}{literal}]").attr('checked', true);
	$("input[name=ovrallcustxp][value={/literal}{$answers.ovrallcustxp}{literal}]").attr('checked', true);
	$("input[name=needreply][value={/literal}{$result.reply}{literal}]").attr('checked', true);
	$("input[name=email]").val('{/literal}{$email}{literal}');
	$("input[name=needreply]").click(function() {
		$("input[name=email]").attr('disabled', $(this).val()=='no'?true:false);
	});
	
	/*$('form#surveyform').submit(function() {
		$('#loading').show();
		var clunder = $("input[name=clunder]:checked").val();
		var poprof = $("input[name=poprof]:checked").val();
		var cleardef = $("input[name=cleardef]:checked").val();
		var how_fast = $("input[name=how_fast]:checked").val();
		var rate = $("input[name=rate]:checked").val();
		var ovrallcustxp = $("input[name=ovrallcustxp]:checked").val();

		if (clunder && poprof && cleardef && how_fast && rate && ovrallcustxp) {
			$(this).attr("action", "?/save_answers/");
			return true;
		} else {
			$('#loading').empty().append('Please complete the survey!').show().fadeOut(7000);
			return false;
		}
	});*/
	//var index = new Index();
	//index.endloading('test');
	
});
	//jQuery.noConflict();

	
/*function endloading(msg) {
	$('#loading').empty().append(msg'Your feedback has been submitted!').show().fadeOut(7000);
	$('input#saveForm').attr('disabled', true);
}*/
{/literal}
</script>
</body>
</html>