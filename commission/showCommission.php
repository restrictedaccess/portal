<?
include '../config.php';
include '../conf.php';
include '../time.php';

if($_SESSION['userid']=="")
{
	die("Session Expires Please Re-Login!");
}
$userid = $_SESSION['userid'];
$commission_id = $_REQUEST['commission_id'];
$commission_staff_status = $_REQUEST['commission_staff_status'];

$query = "SELECT commission_title, commission_amount, commission_desc,DATE_FORMAT(date_created,'%D %b %Y'), CONCAT(l.fname,' ',l.lname) FROM commission c LEFT JOIN leads l ON l.id = c.leads_id
WHERE commission_id = $commission_id;";
$result = mysql_query($query);
if(!$result) die("Error In Script.<br>".$query);
list($commission_title, $commission_amount, $commission_desc, $date_created  , $leads_name)=mysql_fetch_array($result);

?>
<table width="700" border="0">
<tr><td valign="top" colspan="2" align="right"><a href="javascript:dismissbox();">[x]</a></tr>
<tr bgcolor="#E3E0AC"><td valign="middle" colspan="2" height="25" align="center"><b>Commission Rule # <?=$commission_id;?></b></tr>	
	<tr>
		<td width="107" valign="top"><b>Client : </b></td>
		<td width="577"  valign="top"><?=$leads_name;?></td>
	</tr>
	<tr>
		<td width="107" valign="top"><b>Title : </b></td>
		<td width="577"  valign="top"><?=$commission_title;?></td>
	</tr>
	<tr>
		<td valign="top"><b>Amount : </b></td>
		<td valign="top"><?=$commission_amount;?></td>
	</tr>
	<tr>
		<td valign="top"><b>Description : </b></td>
		<td valign="top"><?=$commission_desc;?></td>
	</tr>
	<tr>
	<td valign="top" colspan="2">
	<hr />
	<div id="claim_status">
	<? if($commission_staff_status == "new" or $commission_staff_status == "claiming") { ?>
	<input type="button" class="comm_btn" value="Claim this Commission" onclick="javascript:staffClaimCommission(<?=$commission_id;?>);" />
	<? }?>
	<input type="button" class="comm_btn" value="Close" onclick="javascript:dismissbox();" />
	</div>
	</td>
	</tr>
	
</table>