<?
$userid=$_REQUEST['userid'];
//echo $userid;
$mess="";
$mess=$_REQUEST['mess'];

?>
<html>
<head>
<title>MyProfile &copy;ThinkInnovations.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
<script type="text/javascript">
<!--
function checkFields()
{
	//if (confirm("Are you sure"))
	//{
	//	return true;
	//}
	//else return false;
	
	missinginfo = "";
	if (document.frmSearchableResume.resume_title.value=="")
	{
		missinginfo += "\n     -  Please enter your Resume Title";
	}
	//activate
	if (document.frmSearchableResume.activate[0].checked==false && document.frmSearchableResume.activate[1].checked==false && document.frmSearchableResume.activate[2].checked==false )
	{
		missinginfo += "\n     -  Please choose your Resume Open Status";
	}
	//description
	if (document.frmSearchableResume.activate[1].checked==true)
	{
		if(document.frmSearchableResume.description.value=="")
		{
			missinginfo += "\n     -  Please provide some description or information regarding about your application.";
		}
	}

	///////////////////////////////////////////////
	if (missinginfo != "")
	{
		missinginfo =" " + "You failed to correctly fill in the required information:\n" +
		missinginfo + "\n\n";
		alert(missinginfo);
		return false;
	}
	
	else return true;
	
}	
-->
</script>




</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">


<script language=javascript src="js/functions.js"></script>
<script language=javascript src="js/cookie.js"></script>
<script language=javascript src="js/js2/functions.js"></script>
<script language=javascript src="js/js2/png.js"></script>

<!-- HEADER -->
<!-- /HEADER -->
<script language="JavaScript" type="text/javascript">sessionTimeoutAlert(30,5);</script>
<? include 'header.php';?>	
<table cellpadding="0" cellspacing="0" border="0" width="744">
<tr><td width="736" bgcolor="#ffffff" align="center">
<table width="736" cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td>
<table width=736 cellpadding=0 cellspacing=0 border=0 align=center><tr><td colspan=2 style='height: 1px;'>
<? if ($mess!="") {echo "<center><b><font color='#FF0000' size='3'>There's an  ".$mess." Please try again</font></b></center>"; }?>
</td></tr><tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '><img src='http://sg.jobstreet.com/myjobstreet/_pic/space.gif' width=1 height=10><br clear=all>
<br></td><td width=566 valign=top align=right><img src=http://sg.jobstreet.com/myjobstreet/_pic/space.gif width=1 height=10><br clear=all><table width=566 cellpadding=10 cellspacing=0 border=0><tr><td>
<script src="js/js2/validation.js"></script>
<script language="JavaScript">
<!--
function GetActivation() {
var a = document.frmSearchableResume.activate;
var x;
for (var i=0; i<a.length; i++) {  
if (a[i].checked) {
x = a[i].value;
break;
}
}
return x;
}

//-->
</script>
<script src="js/spellChecker.js"></script>
<link rel=stylesheet type=text/css href="css/spellButton.css">
<form method="POST" name="frmSearchableResume" action="searchableResumephp.php" onSubmit="return checkFields();">
<input type="hidden" name="userid" value="<? echo $userid;?>">
<table width=100% cellspacing=8 cellpadding=2 border=0 align=left >
<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Resume Title</b></td></tr>
<tr><td colspan=2 align=left><table width="100%" border=0 cellspacing=1 cellpadding=2>
<tr><td align=right valign=top width='25%'>Resume Title :</td>
<td><input type="text" class="text" name="resume_title" size="50" maxlength="60" value=""></td></tr>
</table>
</td></tr>
</table>
<br clear=all>
<table width=100% cellspacing=8 cellpadding=2 border=0 align=left ><tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Open MyResume For Search</b></td></tr><tr><td colspan=2>Leading Corporates and Recruitment firms are accessing  our open resume  database  for  jobs  that  might not be advertised on the website. Opening your resume to search will allow these recruiters to contact you directly with  job opportunities.<br></td></tr>

<tr valign=top><td  width=5% align=right><input type="radio" name="activate" value="3" onClick="javascript: ShowPartialOption();"></td>
<td  width=95% ><b>Open MyResume For Search - <font color=red>With</font> Name & Contact Details</b>
<br>Employers will be able to see the full resume with your personal particulars.<br><br></td></tr>

<tr><td  width=5% align=right valign=top><input type="radio" name="activate" value="1"  onClick="javascript: ShowPartialOption();"></td>
<td width=95% ><b>Open MyResume For Search - <font color=red>Without</font> Name & Contact Details</b>
<br>When an employer is interested to contact you, we will inform you first.<div id='srPartial' name='srPartial'><br><br>Provide highlights of yourself that you want potential employers to know.<br>This is optional.<br><br><table width="95%" border=0><tr><td align=left><font color=red>Do not include your name, email, contact# or address here!</font></td><td align=right>
<a class=spellButton onClick="openSpellChecker(document.frmSearchableResume.description);return false;">
<img src='images/spellcheck.gif' align=top>Spell Check</a>
</td></tr><tr><td colspan=2><textarea name="description" cols=30 rows=10 wrap="physical" class="text" style="width:100%"></textarea></td></tr></table></div><br><br></td></tr><tr><td  width=5% align=right valign=top><input type=radio name=activate value="0"  onClick="javascript: ShowPartialOption();"></td><td  width=95% ><b>Hide MyResume From Search</b><br><br></td></tr><tr><td colspan=2 align=center><INPUT type="button" value='Preview Searchable Resume' name="btnPreview" style='width:220px' class="button">&nbsp;&nbsp;<INPUT type=submit value='Save & Next' name="btnSubmit"  class="button" style='width:120px'></td></tr><input type=hidden name=mode value="update"><input type=hidden name=actv value="3"></table><br clear=all></form>
		<script language=javascript>
		<!--
		ShowPartialOption();
		function ShowPartialOption()
		{
				var textDiv = document.getElementById('srPartial');
				if (GetActivation() == 1)
			{
				textDiv.style.display='block';
			}
				else							
			{
				textDiv.style.display='none';
			}
		}
		//-->
		</script>
		</td></tr></table></td></tr></table>
				</td></tr>
			</table>
		</td></tr>
</table>

</body>
</html>
