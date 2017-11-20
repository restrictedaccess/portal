<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Applicant Home</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="/portal/js/jquery.js"></script>
<link rel=stylesheet type="text/css" href="/portal/ticketmgmt/css/overlay.css" />
<style type="text/css">
{literal}

.style2 {color: #666666}
div, td {
	font-family: Verdana,Geneva,sans-serif;
	padding-bottom:0px;
	font-size:12px;
}

{/literal}
</style>

</head>

<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<input type="hidden" name="userid" value="<?php echo $userid?>">
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
	<p><strong>Test List</strong></p>
	Please select the test you want to take. <br/>Note that each test as timed, when you ran out of time, the test will automatically complete.
	
	<ul id='testlist'>
	{if $test_array|@count > 0}	
     {section name=idx loop=$test_array}
    <li><a href='applicant_test_session.php?test_id={$test_array[idx].id}'>{$test_array[idx].test_name}</a></li>
	 {/section}
	{/if}
	<!--<li><a href='http://remotestaff.assesstyping.com/' target='_blank'>Assess Typing</a></li>-->
	<li><a href='/portal/typingtest/typing.php?/typing_start/&userid={$userid}'>RS Typing Test</a></li>
	</ul>
</div>

<div id='boxdiv' class='overlay'><span id='task-status'></span>
  <div class='content' style='width:400px;padding:3px;border:1px solid #011a39;margin: 17% auto'>
	<div class='title'></div>
		
		<form name='regform' method='POST' action='applicant_test_session.php' style='padding:0;margin:0;'>
			<input type='hidden' name='link_id' id='link_id' />
            <input type='hidden' name='item' id='item' value='new'/>
			<table width="100%" border='0' cellpadding="2" cellspacing="2" class="list">
			<!--<tr><td class='form1'>Subject:</td>
				<td class='form2'><input type="text" id="email_subject" name="email_subject" value="Remotestaff: Client-Staff Support" class="inputbox2"/></td>
			</tr>-->
			  
			  <tr><td class='form2'>Enter text here:</td></tr>
			<tr><td class='form2' id='instr'></td></tr>
			   
			 <tr>
			<td colspan="2" align='center'>
			<input type='submit' class='button' id='createbutton' value='Start'> <input type='button' class='button' value='Cancel' onClick="$('boxdiv').style.display='none';">
			</tr>
		  </table>
		</form>
	</div>
	
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