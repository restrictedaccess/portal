<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Applicant Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="/portal/js/jquery.js"></script>
<script src="skillstest/timer.js" type="text/javascript"></script>
<script type="text/javascript" src="/portal/ticketmgmt/js/jqModal.js"></script>
<link rel=stylesheet type="text/css" href="/portal/ticketmgmt/css/overlay.css" />
<style type="text/css">
{literal}

.style2 {color: #666666}
div, td {
	font-family: Verdana,Geneva,sans-serif;
	padding-bottom:0px;
	font-size:12px;
}
div#boxscore {
    display: none;
    
    position: fixed;    
    margin-left: -30px;
    
    background-color: #EEE;
    color: #333;
    border: 1px solid black;
    padding: 12px;
	width:170px;padding:12px;
	border:1px solid #ff9900;

	text-align:center;
	top:50px;left:40%;
}

.jqmOverlay { background-color: #000; }

* html div#boxscore {
     position: absolute;
     top: expression((document.documentElement.scrollTop || document.body.scrollTop) + Math.round(17 * (document.documentElement.offsetHeight || document.body.clientHeight) / 100) + 'px');
}

{/literal}
</style>
<script type='text/javascript'>
{literal}
var testtaken = '{/literal}{$testcount}{literal}';
var qcnt = 0;
var counter;
var selection = ['A', 'B', 'C', 'D', 'E'];
var minutes = {/literal}{$test_array[0].test_duration}{literal};
var seconds = 0;
 
var session_tstamp;
	$(document).ready(function() {
		var test_id = $('input#test_id').val();

		{/literal}
		{if $error}alert('{$error}');
		test_result(test_id);
		//history.go(-1);
		{else}
		$('div#boxdiv').show();
		{/if}
		{literal}
		
		$('div#boxscore').jqm({overlay: 50, modal: true, trigger: false});
		$('.jqmClose').click(function(){location.href='applicant_test.php';});
		
		$("input#nextbutton").click(function() {
			if( testtaken != '0' ) {
				location.href='applicant_test.php';
				return false;
			}
			
			if( !qcnt ) {
				//counter = new Counter(((new Date()).getTime()), 'counter', '', 60);
				countdown('counter');
				session_tstamp = Math.round(new Date().getTime() / 1000);
				//alert(session_tstamp);
				//alert(Math.round(new Date().getTime() / 1000));
			}
			
			if( !session_tstamp ) session_tstamp = Math.round(new Date().getTime() / 1000);
			
			var answered = [];
			$("input[name='answer[]']:checked").each(function (){
				answered.push(parseInt($(this).val()));
			});
			//var answer = $('input[name=answer]:checked').val();
			var qid = $('input#qid').val();
			
			if( typeof answered !== 'undefined' && parseInt(qid) > 0 ) {
				$.ajax({
					type: "POST",
					url: "applicant_test_session.php",
					data: { 'item': 'save_answer', 'uaid':answered.join(','), 'tstamp':session_tstamp,
						'test_id':test_id, 'qid':qid },
					dataType: "json",
					success: function(data){
						//if( data.text ){
						session_tstamp = 0;
						
						//window.config.instance = false;
						//state = data.state;
						return true;
					}
				});
			}
			//var test_array = $("#boxdiv").data("Data");
			if( qcnt < $('span#total_cnt').text()) {
				$('span#cnt').text(qcnt+1);
			
			
				// pull the question and answers
				$.ajax({
					type: "POST",
					url: "applicant_test_session.php",
					data: { 'item': 'session', 'test_id':test_id, 'qcnt':qcnt },
					dataType: "json",
					success: function(data){
						//if( data.text ){
						if( !data ) return false;
						$("input#nextbutton").attr('disabled', 'disabled');
	
						qcnt++;
						
						$('div#question').empty();
						$('div#answers').empty();
						
						$('input#qid').val(data.id);
						
						if( data.resources.length > 0 ) {
							if( data.resources[0].question_resource_display != null )
								$('div#question').append("<p>"+data.resources[0].question_resource_display+"</p>");
								
							if( data.resources[0].question_resource_filename != null )							 
								$('div#question').append("<img src='/portal/uploads/test/"+data.resources[0].question_resource_filename+"'/>");
						}
						$('div#question').append("<p>"+data.question_text+"</p>");
							
						for (var i = 0; i < data.answers.length; i++) {
							var answer = data.answers[i];
							
							//alert(answer.answer_text);
							$('div#answers').append("<p><input type='checkbox' name='answer[]' value='"+answer.id+"' onclick='answer_select();'/> "+
								selection[i]+ ") "+answer.answer_text+"</p>");
							
							//$('ul#'+divid).append("<li class=\""+statclass+"\" id='"+info.chatid+"'></li>");
							// add property for voice chat button
							//info['vc_disabled'] = true;
							
			
						}
						
						//window.config.instance = false;
						//state = data.state;
						return true;
					}
				});
			} else {
				clearInterval(interval);
                test_result(test_id);
				$("input#nextbutton").attr('disabled', 'disabled');
			}
			
			$('div#boxdiv').hide();
			//var activeLink = $(this).attr("href").split('#')[1];
			//var params = activeLink.split('/');
			//$('div.title').text('{/literal}{$test_array[0].test_name}{literal}');
			//$('div.overlay').show();
		});
		
		$('input[name="answer"]').click(function() {
			alert($(this).val());
		});
	});
function test_result(test_id) {
	$.ajax({
		type: "POST",
		url: "applicant_test_session.php",
		data: { 'item': 'get_answer', 'test_id':test_id },
		dataType: "json",
		success: function(data){
		
			if( !data ) return false;
			var result = '';
			var total_score = 0;
			for (var i = 0; i < data.length; i++) {
				var info = data[i];
				
				var ctr = i+1;
				total_score += parseInt(info.score);
				var iscorrect = parseInt(info.score) ? 'Correct' : 'Incorrect';
				result += "<p>Q."+ctr+") "+iscorrect+" - "+info.score+ "</p>\n";
				//result += "<p>"+ctr+") "+info.order_char+" - "+(parseInt(info.answer_iscorrect) ? 'Correct' : 'Incorrect')+ "</p>\n";
			}
			result += "Total score:"+total_score+"<br/>";

			$('div#testresult').append(result);
			
			var boxscore = $('div#boxscore');
			boxscore.jqmShow();
			
			if( (boxscore.height()+50) > $(window).height() ) {
				boxscore.css({'height':$(window).height()-100, 'overflow':'auto'});
				boxscore.scrollTop($(window).height()+500);
			}
				
			return true;
		}
	});
}
function answer_select(id) {
	$('input#nextbutton').removeAttr('disabled');
}
{/literal}
</script>
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<input type="hidden" name="userid" value="<? echo $userid?>">
<script language=javascript src="js/functions.js"></script>
<!-- HEADER -->
<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="background-color:#FFFFFF; background-repeat: repeat-x;">
<tr><td width="546" style="width: 220px; height: 60px;"><img src="images/remote-staff-logo.jpg" alt="think" width="484" height="89"></td>
<td width="474">&nbsp;</td>
<td width="211" align="right" valign="bottom"></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width: 100%; background: URL('images/bg1.gif'); background-repeat: repeat-x">
<tr><td style="border-bottom: 2px #0d509e solid; " >&nbsp;</td>
</tr>
</table>

<ul class="glossymenu">
	<li ><a href="/portal/jobseeker/"><b>Home</b></a></li>
	<li ><a href="/portal/jobseeker/resume.php"><b>MyResume</b></a></li>
	<li><a href="/portal/jobseeker/applications.php"><b>Applications</b></a></li>
	<li><a href="/portal/jobseeker/jobs.php"><b>Search Jobs</b></a></li>
  <?php $hash_code = chr(rand(ord("a"), ord("z"))) . substr( md5( uniqid( microtime()) . $_SERVER[ 'REMOTE_ADDR' ] . $emailaddr ), 2, 17 ); ?>
    <li><a href="javascript:popup_win8('rschat.php?portal=1&email=<?php echo $emailaddr ?>&hash=<?php echo $hash_code ?>',800,600);" title="Open remostaff chat"><b>RSChat</b></a></li>
	<li class="current"><a href="#"><b>Take a Test</b></a></li>
</ul>


<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome, <? echo $name;?> this is your personal page</b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>

<div style="width:100%; padding:15px 25px;border:1px solid #aaa; text-align:left;">
	<p><strong>TIMER:</strong><span id='counter' style='padding:6px 2px 0 2px;'></span>
		&nbsp; &nbsp; Test Count:  <span id='cnt'></span> of <span id='total_cnt'>{$question_count}</span></p>
	
	<div id='testbox' style='width:90%;border:1px solid #0d509e;'>
		<form name='regform' method='POST' action='applicant_test_session.php' style='padding:0;margin:0;'>
			<input type='hidden' name='qid' id='qid' value='0' />
		<table width="100%" bgcolor="#abccdd" >
			<tr>
				<td valign='top' style='width:60%;border-right:1px dotted #aaa;'>
					<div id='question'>
						{*if $test_array|@count > 0}	
     {section name=idx loop=$test_array}
    <li><a href='#{$test_array[idx].id}/{$smarty.section.idx.index}'>{$test_array[idx].test_name}</a></li>
	 {/section}
	{/if*}
					</div>
				</td>
				<td style='width:40%;' valign='top'><p><strong>Choose your answer</strong></p>
					<div id='answers' style='font-size:11px;'>
						
					</div>
				</td>
			</tr>
			 <tr>
			<td colspan="2" align='left'>
			<input type='button' class='button' id='nextbutton' value='Next Question'>
			</tr>
		</table>
	
		</form>
	</div>
</div>

<div id='boxdiv' class='overlay'><span id='task-status'></span>
  <div class='content' style='width:470px;padding:3px;border:1px solid #011a39;margin: 10% auto'>
	<div class='title'>{$test_array[0].test_name}</div>
		
		<form name='regform' method='POST' action='applicant_test_session.php' style='padding:0;margin:0;'>
			<input type='hidden' name='link_id' id='link_id' />
            <input type='hidden' name='test_id' id='test_id' value='{$test_array[0].id}'/>
			<table width="100%" border='0' cellpadding="2" cellspacing="2" class="list">
			<!--<tr><td class='form1'>Subject:</td>
				<td class='form2'><input type="text" id="email_subject" name="email_subject" value="Remotestaff: Client-Staff Support" class="inputbox2"/></td>
			</tr>-->
			  
			  <tr><td class='form2'>&nbsp;</td></tr>
			<tr><td class='form2'><div style='float:left;'>
			{$test_array[0].test_instruction}
			</div></td></tr>
			   
			 <tr>
			<td colspan="2" align='center'>
			<input type='button' class='button' id='nextbutton' value='Start'>&nbsp;
			<input type='button' class='button' value='Cancel' onClick="location.href='applicant_test.php';">
			</tr>
		  </table>
		</form>
	</div>
	
</div>

<div id='boxscore'>
	<span id='log_testname'>Test Result</span>
	<a href='applicant_test.php' class='jqmClose' style='float:right'>Close</a><hr>
	
	<table width="100%" border='0' cellpadding="2" cellspacing="2" class="list">
		<tr><td class='form2'>&nbsp;</td></tr>
		<tr><td class='form2'>
		<div id='testresult' style='float:left;text-align:left;'></div>
		</td></tr>
		<tr><td class='form2'>&nbsp;</td></tr>	   
		<tr>
		<td colspan="2" align='center'>
			<input type='button' class='button' value='OK' onClick="location.href='applicant_test.php';">
		</td>
		</tr>
	</table>
</div>

{*<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	<td width="170" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
		Test List




	</td>
	
</tr>
</table>*}


{php}include("footer.php"){/php}
</body>
</html>