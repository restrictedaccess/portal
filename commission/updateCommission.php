<?
include '../config.php';
include '../conf.php';
include '../time.php';

if($_SESSION['client_id']=="")
{
	die("Session Expires Please Re-Login!");
}

$leads_id = $_SESSION['client_id'];

$commission_id = $_REQUEST['commission_id'];
$commission_title = $_REQUEST['commission_title'];
$commission_amount = $_REQUEST['commission_amount'];
$commission_desc = $_REQUEST['commission_desc'];

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
/*
commission_id, leads_id, created_by, created_by_type, commission_title, commission_amount, commission_desc, commission_status, date_created, date_approved, date_cancelled, date_paid, response_by_id, response_by_type

*/
$query = "UPDATE commission SET commission_title = '$commission_title', commission_amount = '$commission_amount', commission_desc = '$commission_desc'
			WHERE commission_id = $commission_id;";
$result = mysql_query($query);
if(!$result) die("Error In Script.<br>".$query);

$query = "SELECT commission_title, commission_amount, commission_desc FROM commission WHERE commission_id = $commission_id;";
$result = mysql_query($query);
if(!$result) die("Error In Script.<br>".$query);
list($commission_title, $commission_amount, $commission_desc)=mysql_fetch_array($result);


?>
<div style="background:#F4F4F4; border:#999999 solid 1px; padding:5px;">
		<table width="100%">
			<tr>
				<td width="15%" valign="top"><b>Title : </b></td>
				<td width="85%" valign="top"><?=$commission_title;?></td>
			</tr>
			<tr>
				<td valign="top"><b>Amount : </b></td>
				<td valign="top"><?=$commission_amount;?></td>
			</tr>
			<tr>
				<td valign="top"><b>Description : </b></td>
				<td valign="top"><?=$commission_desc;?></td>
			</tr>
		
		</table>
		
		<div id="edit_div" style="display:none; background:#E4E4E4; padding:5px; border:#000000 ridge 1px; ">
		<hr />
		<table width="100%">
			<tr>
				<td width="15%" valign="top"><b>Title : </b></td>
				<td width="85%" valign="top"><input type="text" id="commission_title" name="commission_title" class="select" value="<?=$commission_title;?>" /></td>
			</tr>
			<tr>
				<td valign="top"><b>Amount : </b></td>
				<td valign="top"><input type="text" id="commission_amount" name="commission_amount" class="select" value=<?=$commission_amount;?> style="width:100px;" onKeyUp="doCheck(this.value)" /><span style="color:#666666; margin-left:10px;">Valid Numbers Only</span></td>
			</tr>
			<tr>
				<td valign="top"><b>Description : </b></td>
				<td valign="top"><textarea id="commission_desc" name="commission_desc" class="select" rows="5" style="width:400px;"><?=$commission_desc;?></textarea></td>
			</tr>
		
		</table>
				
			<p>
			<input type="button" value="Update" onClick="javascript:updateCommission(<?=$commission_id?>);" />
			<input type="button" value="Cancel" onClick="show_hide('edit_div')" />
			</p>
		</div>	
	</div>