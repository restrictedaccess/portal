<?php
include './conf/zend_smarty_conf.php';
include 'time.php';

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}
$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>Job Titles</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="job_title/media/css/job_title.css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type='text/javascript' src='./job_title/media/js/job_titles.js'></script>


</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">


<?php include 'header.php';?>
<?php include 'admin_header_menu.php';?>
<table width=98% cellpadding=0 cellspacing=0 border=0 >
<tr><td width="14%" height="135" valign="top">
<?php include 'adminleftnav.php';?>
</td>
<td width="86%" valign="top">
<h3>Job Titles Price Management</h3>
	<table cellpadding="0" cellspacing="1" width="100%" style="background:#CCCCCC;">
	<tr bgcolor="#FFFFFF">
		<td width="20%" valign="top"><div id="job_title_list"></div></td>
		<td width="80%" valign="top">
		<div class="controls"><input type="button" value="Add Job Title" onClick="showAddJobTitleForm()"></div>
		<div id="right_pane">&nbsp;</div>
		</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td colspan="2" valign="top">
		<div class="his-hdr">History<span id="his-info" class="his-info"></span></div>
		<div id="job_title_list_history"></div>
		</td>
	</tr>
	</table>
</td></tr>
</table>
<?php include 'footer.php';?>
<script type="text/javascript">
<!--
loadJobPositionHistory('False');
-->
</script>
</body>
</html>
