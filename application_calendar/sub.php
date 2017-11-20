<?
include 'config.php';
include 'function.php';

$ausDateTime=ATZ();

echo $ausDateTime;

$mess="";
$mess=$_REQUEST['mess'];




?>

<html>
<head>
<title>SubPage</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../menu.css">
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


<script language=javascript src="../js/functions.js"></script>
<script language=javascript src="../js/cookie.js"></script>
<script language=javascript src="../js/js2/functions.js"></script>
<script language=javascript src="../js/js2/png.js"></script>

<!-- HEADER -->
<? include 'header.php';?>
<? include 'BP_Header.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='../images/space.gif' width=1 height=10>
<br clear=all>
<br></td>
<td width=566 valign=top align=right>
<img src=../images/space.gif width=1 height=10>
<br clear=all></td>
</tr></table>
<? include 'footer.php';?>
</body>
</html>
