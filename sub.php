<?
include 'config.php';
$mess="";
$mess=$_REQUEST['mess'];




?>

<html>
<head>
<title>SubPage</title>
<link rel=stylesheet type=text/css href="css/font.css">
<script type="text/javascript">
<!--
function checkFields()
{
	if (confirm("Are you sure"))
	{
		return true;
	}
	else return false;		
	//alert (document.frmSkills.skill.value);
	
	//missinginfo = "";
	//if (missinginfo != "")
	//{
	//	missinginfo =" " + "You failed to correctly fill in the required information:\n" +
	//	missinginfo + "\n\n";
	//	alert(missinginfo);
	//	return false;
	//}
	//else return true;

	
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
<? include 'header.php';?>
<table cellpadding="0" cellspacing="0" border="0" width="744">
<tr><td width="736" bgcolor="#ffffff" align="center">
<table width="736" cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td>
<table width=736 cellpadding=0 cellspacing=0 border=0 align=center><tr><td colspan=2 style='height: 1px;'>
<? if ($mess!="") {echo "<center><b><font color='#FF0000' size='3'>There's an  ".$mess." Please try again</font></b></center>"; }?>

</td></tr>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='images/space.gif' width=1 height=10>
<br clear=all>
<br></td>
<td width=566 valign=top align=right>
<img src=images/space.gif width=1 height=10>
<br clear=all>
<table width=566 cellpadding=10 cellspacing=0 border=0>
<tr><td>
<form method="POST" name="form" action="#"  onsubmit="return checkFields();">

<table width=100% cellspacing=8 cellpadding=2 border=0 align=left >
<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>SubPage</b></td></tr>
<tr><td colspan=2 >SubPage</td></tr>
<tr><td align=right width=30% >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td align=right width=30% >&nbsp;</td>
<td>&nbsp;</td></tr>
<tr><td align=right width=30% >&nbsp;</td>
<td>&nbsp;</td></tr>
<tr><td colspan=2>
<table width=100% border=0 cellspacing=1 cellpadding=2>
<tr><td align=center>
<INPUT type="submit" value="Save" name="Add" class="button" style="width:120px">
&nbsp;&nbsp;
<INPUT type="reset" value="Cancel" name="Cancel" class="button" style="width:120px">
</td></tr></table>
</td></tr>
</table>
<!-- skills list -->
<br clear=all><br>



<!-- --->
<br></form>

</td></tr></table></td></tr></table>
				</td></tr>
			</table>
		</td></tr>
</table>
	<!-- /CONTENT -->
	<br>
	
	
</body>
</html>
