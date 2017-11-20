<?
include '../config.php';
include '../conf.php';
include '../time.php';

if($_SESSION['client_id']=="")
{
	die("Session Expires Please Re-Login!");
}

$leads_id = $_SESSION['client_id'];

?>
<div style="color:#999999">List of Commission Rules that you created...</div>
<table width="100%" border="0">
<tr>
<td width="25%" valign="top">
<div class="hdr"><b>Commission Titles</b></div>
<div id="leads_comm_list">Loading....</div>
</td>
<td width="75%" valign="top">
<div id="view_commission">Select Commission Title from left to view its description</div>
</td>
</tr>
</table>