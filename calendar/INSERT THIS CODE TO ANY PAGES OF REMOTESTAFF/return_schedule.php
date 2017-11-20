<?php
require_once("../libraries/connect.php");
$h = (gmstrftime("%H",time()));
$m = (gmstrftime("%M",time()));
$d = date("Ymd");

$db=connsql();
$id = @$_GET["id"];
if(isset($id))
{
	mysql_query("UPDATE tb_appointment SET status='not active' WHERE id='$id'");
}
$c = mysql_query("SELECT id, subject, location, description FROM tb_appointment WHERE date_start='$d' AND start_hour >= '$h' AND start_minute >= '$m' AND status='active' LIMIT 1");	
//$c = mysql_query("SELECT id, subject, location, description FROM tb_appointment WHERE date_start='$d' LIMIT 1");
$num_result = mysql_num_rows($c);
if($num_result > 0)
{
	echo '
	<table bgcolor=#000000 border=0 cellpadding=0 cellspacing=1 width="100%">
		<tr>
			<td>
				<table width=100% cellspacing=1 border=0 cellpadding=7 bgcolor=#fefefe>
					<tr>
						<td bgcolor=#FFFFFF><strong>Subject: </strong>'.mysql_result($c,0,"subject").'</td>
					</tr>		
					<tr>
						<td bgcolor=#FFFFFF><strong>Location: </strong>'.mysql_result($c,0,"location").'</td>
					</tr>		
					<tr>
						<td bgcolor=#FFFFFF><strong>Description: </strong>'.mysql_result($c,0,"description").'</td>
					</tr>		
					<tr>
						<td bgcolor=#FFFFFF align="right"><a href="javascript: hideAlarm('.mysql_result($c,0,'id').'); "><font size="1">Close</font></a></td>
					</tr>											
				</table>
			</td>
		</tr>
	</table>
	';
}
dieSql($db);		
?>