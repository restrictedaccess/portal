<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Remotestaff Applicants</title>
<link rel=stylesheet type=text/css href="../css/font.css">
<script language=javascript src="../js/MochiKit.js"></script>
<script language=javascript src="../system_wide_reporting/media/js/system_wide_reporting.js"></script>
<script language=javascript src="../js/functions.js"></script>
<link rel=stylesheet type=text/css href="../system_wide_reporting/media/css/system_wide_reporting.css">
</head>
<body id="applicant_list" style="margin-top:0; margin-left:0">
<form name="form" method="post">
<img src="./media/images/remote-staff-logo.jpg" align="absmiddle" />
<h3 align="center">APPLICANT LIST</h3>
<div style="text-align:center; padding:5px;"> 
<input type="text" name="keyword" id="keyword" value="{$keyword}" style=" width:200px;" ><input type="submit" name="search" value="search" /></div>
<div class='pagination'>{$paging}<select name="pages" onchange="location.href=this.value" >{$nav}</select> <b>{$row_results} records</b></div>
<table width="100%" cellpadding="2" cellspacing="1" style="border:#CCCCCC solid 1px;">
<tr bgcolor="#333333">
<td width="3%" class="hdr">#</td>
<td width="5%" class="hdr">USERID</td>
<td width="40%" class="hdr">NAME</td>
<td width="17%" class="hdr">EMAIL</td>
<td width="15%" class="hdr">SKYPE / CONTACT NOS.</td>
<td width="20%" class="hdr">DATE REGISTERED</td>
</tr>
{$staff_list}
</table>
{literal}
<script>
var items = getElementsByTagAndClassName('span', 'leads_list', parent=document);
for (var item in items){
	connect(items[item], 'onclick', updateParent);
}
</script>
{/literal}
</form>
</body>
</html>