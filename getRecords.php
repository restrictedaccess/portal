<?
include 'conf.php';
include 'config.php';

$agent_no = $_SESSION['agent_no'];
$actions=$_REQUEST['q'];
//echo $actions;

$queryRecord4="SELECT id, actions, history, DATE_FORMAT(date_created,'%D %b %Y'), quantity FROM manual_history WHERE actions='$actions' AND agent_no =$agent_no ORDER BY date_created DESC;";
//echo $queryRecord4;
$query_result4=mysql_query($queryRecord4);
$meeting_count = 0;
$counter = 0;
$bgcolor="#f5f5f5";
$output ="<table width=97% cellpadding=3 cellspacing =1>
<tr><td colspan =4><i>$actions &nbsp;Manually Added</i></td></tr>";
$output.="<tr bgcolor=#666666>
	<td width='4%'><b><font size='1' color='#FFFFFF'>#</font></b></td>
	<td width='7%'><b><font size='1' color='#FFFFFF'>Quantity</font></b></td>
	<td width='9%'><b><font size='1' color='#FFFFFF'>Date</font></b></td>
	<td width='78%'><b><font size='1' color='#FFFFFF'>Details</font></b></td>
  </tr>";
while(list($id, $actions, $history, $date_created, $quantity)=mysql_fetch_array($query_result4))
{
	$counter++;
	$output.="<tr bgcolor =$bgcolor>
	<td width='4%'>$counter)</td>
	<td width='7%'>$quantity</td>
	<td width='9%'>$date_created</td>
	<td width='78%'>$history</td>
  </tr>";	
if($bgcolor=="#f5f5f5")
{
$bgcolor="#FFFFFF";
}
else
{
$bgcolor="#f5f5f5";
}
}
$output.="</table>";

echo $output;
?>