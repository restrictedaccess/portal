<?
include 'config.php';
include 'function.php';

$id=$_REQUEST['id'];
/*
id, agent_no, leads_id, actions, history, date_created
*/
$query ="SELECT history, DATE_FORMAT(date_created,'%D %M %Y')AS date_new_created FROM applicant_history WHERE id = $id;";
$result=mysql_query($query);
$ctr=@mysql_num_rows($result);
if ($ctr >0)
{
	list($desc,$date)= mysql_fetch_array($result);
	$date = $date;
	$desc= str_replace("\n","<br>",$desc);
}


?>

<html>
<head>
<title>History Details &copy;ThinkInnovations.com</title>
<link rel=stylesheet type=text/css href="css/font.css">
</head>
<body bgcolor="#ffffff" topmargin="10" leftmargin="10" marginheight="10" marginwidth="10">


<script language=javascript src="js/functions.js"></script>

<table width="100%" cellpadding="0" cellspacing="0" border="0" >
<tr><td><img src="images/banner/remoteStaff-logo.jpg" alt="think" width="416" height="108"></td>
	<td align="right" style="color:#FFFFFF;" valign="baseline">
	  
	  <a href="javascript:window.close();" style="FONT: bold 8pt verdana; color:#000000;">Close</a>&#160;&#160;
	</td>
</tr>
</table>
<img src="images/space.gif" height=8 width=1><br clear=all>


	<table width=100% cellspacing=0 cellpadding=1 align=center border=0 bgcolor=#CCCCCC>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td>&nbsp;&nbsp;<font style='font: bold 10pt verdana;'>History </font></td></tr>
	<tr><td height=1><img src="images/space.gif" height=1 width=1></td></tr>
	<tr><td>
		<table width=100% cellspacing=1 cellpadding=2 align=center border=0 bgcolor=#ffffff>
		<tr><td><font color="#CCCCCC"><b>Date Created : 
		<? 
		echo $date;
		// Prints something like: Monday 8th of August 2005 03:12:46 PM
		//echo date('jS of F Y',$date);
		?></b></font><br><br>
		<div style="margin:0 0 0 50px;">
		
<? echo $desc;?>
</div>

		</td></tr>
		</table>
	</td></tr>
	</table>

	</body>
	</html>

