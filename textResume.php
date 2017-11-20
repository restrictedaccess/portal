<?
include 'config.php';
$userid=1;//$_REQUEST['userid'];
$mess="";
$mess=$_REQUEST['mess'];

?>



<script language="JavaScript">
<!-- 
function CountText(frm) {
	txtCount = frm.char_count; 
	txtCount.value = frm.additional_info.value.length;
}
//-->
</script>
<script src="js/spellChecker.js"></script>


<html>
<head>
<title>MyProfile &copy;ThinkInnovations.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="css/spellButton.css">
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">


<script language=javascript src="js/functions.js"></script>
<script language=javascript src="js/cookie.js"></script>
<script language=javascript src="js/js2/functions.js"></script>
<script language=javascript src="js/js2/png.js"></script>

<!-- HEADER -->
<? include 'header.php'?>
<!-- /HEADER -->
<script language="JavaScript" type="text/javascript">sessionTimeoutAlert(30,5);</script>
		<!-- SUBHEADER -->
		<!-- /SUBHEADER -->
        <!-- WELCOME MESSAGE -->
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="32">
				<tr><td width="736"  bgcolor="#abccdd" >
					<table width="736">
						<tr>
							<td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome, Normaneil.
							
							<a href="#" style="color: #0065B7;" > Click here</a> to go back to your Personal Page.
							</b></td>
							<td align="right" style="font: 8pt verdana; "><a href="javascript:popup_win3('http://myjobstreet.jobstreet.com/resume/viewResume.asp?intEID=CA0A1E41418CC8BC59C6C0BE3063EC4C7146D1C3');">Preview Your Printable Resume</a>&#160;</td>
							
						</tr>
					</table>
				</td></tr>
</table>
			<!-- /WELCOME MESSAGE -->
	
	<!-- CONTENT -->
	<table cellpadding="0" cellspacing="0" border="0" width="744">
		<tr><td width="736" bgcolor="#ffffff" align="center">
			<table width="736" cellpadding="0" cellspacing="0" border="0" align="center">
				<tr><td>
<table width=736 cellpadding=0 cellspacing=0 border=0 align=center><tr><td colspan=2 style='height: 1px;'>
<? if ($mess!="") {echo "<center><b><font color='#FF0000' size='3'>There's an  ".$mess." Please try again</font></b></center>"; }?>

</td></tr><tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '><img src='images/space.gif' width=1 height=10><br clear=all><br></td><td width=566 valign=top align=right><img src=images/space.gif width=1 height=10><br clear=all><table width=566 cellpadding=10 cellspacing=0 border=0><tr><td><table width=100% cellspacing=1 cellpadding=2 border=0><tr><td class=msg><img src='images/tip.gif' alt='Tip'> Employers prefer brief and concise resumes to facilitate easy and faster screening. Please keep your resume within a maximum of 10,000 characters long (approximately 6 pages).</td></tr></table><br>

<form name="addinfo" method="POST" action="txtResumephp.php">
<input type="hidden" name="userid" value="<? echo $userid;?>">
<table width=100% cellspacing=8 cellpadding=2 border=0 align=left >
<tr>
<td width=100% bgcolor=#DEE5EB ><b>Edit Your Text Resume</b></td>
</tr>
<tr>
<td>Please copy the contents from your existing resume and paste it here. </td>
</tr>
<tr>
<td align=right>
<table border=0 cellpadding=0 cellspacing=0 width='100%'>
<tr valign=top><td align=left>
<a href='#'><img src="images/attach.gif" border="0" align="top" >My Attached Resume</a></td>
<td align=right><a class=spellButton onClick="openSpellChecker(document.addinfo.additional_info);return false;"><img src='images/spellcheck.gif' align=top>Spell Check</a></td></tr></table>
<textarea name="txt" cols="48" rows="35" wrap="physical" class="text" onKeyUp='CountText(this.form);' style="width:100%"></textarea>
<table border=0 cellpading=0 cellspacing=0 width='100%'><tr><td valign=top><font class=tip>Number of characters now : <input type=text class=text disabled name=char_count size=4  onFocus='this.blur();' value=""></font></td></tr></table>
<br></td></tr></table><br clear=all><input type=hidden name=mode value="update"><br><table width=100% border=0 cellspacing=1 cellpadding=2><tr><td align=center><INPUT type=submit value='Save & Next' name=btnSubmit class=button style='width:120px'></td></tr></table></form></td></tr></table></td></tr></table>
				</td></tr>
			</table>
		</td></tr>
	</table>
	<!-- /CONTENT -->
	<br>
	
	
</body>
</html>
