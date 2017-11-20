<?php
include './conf/zend_smarty_conf_root.php';
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Recruitment Service</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href='get_started/media/css/get_started.css'>
<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type='text/javascript' src='get_started/media/js/get_started.js'></script>
<script type='text/javascript' src='js/functions.js'></script>

</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">


<?php include 'header.php';?>
<?php include 'admin_header_menu.php';?>
<table width=99% cellpadding=0 cellspacing=0 border=0 >
<tr><td width="14%" height="135" valign="top">
<?php include 'adminleftnav.php';?>
</td>
<td width="86%" valign="top">
<table cellpadding="0" cellspacing="1" width="100%" style="background:#CCCCCC;">
	<tr bgcolor="#FFFFFF">
		<td width="25%" valign="top"><div class="hdr_list">List</div><div id="left_pane"></div></td>
		<td width="75%" valign="top">
		<div class="controls">Recruitment Service Ordering</div>
		<div id="right_pane">&nbsp;</div>
		</td>
	</tr>
	</table>
</td></tr>
</table>
<?php include 'footer.php';?>
<script>
connect(window, "onload", OnLoadGetAllHireAStaffOrders);
</script>
</body>
</html>
