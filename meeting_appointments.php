<?
include 'config.php';
include 'conf.php';
$agent_no = $_SESSION['agent_no'];
$id = $_REQUEST['id'];




?>

<html>
<head>
<title>Meeting / Appointments</title>
<link rel=stylesheet type=text/css href="css/font.css">
<script type="text/javascript">
<!--
function checkFields()
{
	missinginfo = "";
	if(document.form.txt.value=="")
	{
		missinginfo += "\n     -  There is no history / details to be save \t \n Please enter details.";
	}
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
<style type="text/css">
<!--
	div.scroll {
		height: 300px;
		width: 100%;
		overflow: auto;
		border: 1px solid #CCCCCC;
		padding: 8px;
	
	}
-->
</style>	
	
	
	
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
<table width=736 cellpadding=0 cellspacing=0 border=0 align=center><tr><td colspan=2 style='height: 1px;'>&nbsp;


</td></tr>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<img src='images/space.gif' width=1 height=10>
<br clear=all>
<? include 'agentleftnav.php';?>
<ul>
<a href="apply_action.php?id=<? echo $id;?>"> << Back </a>
</ul>


<br></td>
<td width=566 valign=top align=right>
<img src=images/space.gif width=1 height=10>
<br clear=all>
<table width=566 cellpadding=10 cellspacing=0 border=0>
<tr><td>
<form method="POST" name="form" action="meeting_appointmentsphp.php"  onsubmit="return checkFields();">
<input type="hidden" name="id" value="<? echo $id;?>">

<table width=100% cellspacing=8 cellpadding=2 border=0 align=left >
<tr><td width=100% bgcolor=#DEE5EB colspan=2><b>Meetings / Appointments</b></td></tr>
<tr>
<td colspan=2 >
<?
$sql="SELECT details,DATE_FORMAT(date_created,'%M %e %Y') FROM meeting_appointments WHERE agent_no = $agent_no GROUP BY date_created DESC;";
//echo $sql;
$result=mysql_query($sql);
$ctr=@mysql_num_rows($result);
if ($ctr >0 )
{
	$counter=0;
	while(list($details,$date) = mysql_fetch_array($result))
	{
		$counter=$counter+1;
		$details=str_replace("\n","<br>",$details);
		$txt.="<p><u><b>".$counter.".</b></u><br><br>Date Created :".$date."<ul><font color='#999999'>".$details."</font></ul><hr></p>";
	}
}


?>
<p>List :</p>
<div class="scroll"><? echo $txt?></div> 
<p>Add Meetings / Appointments:</p>
<textarea name="txt" cols="48" rows="7" wrap="physical" class="text"  style="width:100%"></textarea>
</td></tr>
<tr><td align=right width=30% >&nbsp;</td><td>&nbsp;</td></tr>
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
