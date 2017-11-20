<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<script language=javascript src="../js/MochiKit.js"></script>
<script language=javascript src="../system_wide_reporting/media/js/system_wide_reporting.js"></script>
<script language=javascript src="../js/functions.js"></script>
<link rel=stylesheet type=text/css href="../system_wide_reporting/media/css/system_wide_reporting.css">
</head>
<body style="margin-top:0; margin-left:0">
<img src="./media/images/remote-staff-logo.jpg" align="absmiddle" /><br />
<center>
	<strong>{$ann_str}</strong>
</center>

<table width="100%" cellpadding="2" cellspacing="1" style="border:#CCCCCC solid 1px;">
{foreach from=$staffs item=staff name=staff}
<tr bgcolor="{cycle values=#eeeeee,$d0d0d0}">
<td width="5%">{$smarty.foreach.staff.iteration}</td>
<td width="40%" valign="top">
<img src="http://www.remotestaff.com.au/portal/tools/staff_image.php?w=28&id={$staff.userid}" style='float:left; margin-right:10px; display:block;' />
<div style="float:left;">
<span class="leads_list" page="../application_apply_action.php?userid={$staff.userid}&page_type=popup" >{$staff.staff_fname} {$staff.staff_lname}</span><br />
<small>{$staff.staff_designation}</small><br />
<strong>[ {$staff.userid} ]</strong><br />
<small>{$staff.staff_email}</small>
</div>

</td>

<td width="55%" valign="top">
<span style="float:right; color:#CCCCCC;">Subcon id :{$staff.id}</span>
<span class="leads_list" page="../leads_information.php?id={$staff.leads_id}&lead_status={$staff.status}&page_type=FALSE" >[ {$staff.leads_id} ] {$staff.client_fname} {$staff.client_lname}</span>
<br />
{$staff.client_email} ] <br />
Starting Date : {$staff.starting_date}
</td>
</tr>
{/foreach}
</table>
{literal}
<script>
var items = getElementsByTagAndClassName('span', 'leads_list', parent=document);
for (var item in items){
	connect(items[item], 'onclick', updateParent);
}
</script>
{/literal}
</body>
</html>