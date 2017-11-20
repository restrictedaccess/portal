<?php
/*
2009-10-01 Normaneil Macutay
	- Making the script to PHP ZEND standard coding.
*/
include './conf/zend_smarty_conf.php';
include 'time.php';
include 'function.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;
$date=date('l jS \of F Y h:i:s A');

if($_SESSION['admin_id']=="")
{
	header("location:index.php");
}
$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

$query="SELECT * FROM admin WHERE admin_id=$admin_id;";
$result = $db->fetchRow($query);
$name = $result['admin_fname']." ".$result['admin_lname'];

?>
<html>
<head>
<title>RemoteStaff  Admin Users</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="admin_users/admin_users.css">
<script type="text/javascript" src="js/MochiKit.js"></script>
<script type="text/javascript" src="admin_users/admin_users.js"></script>
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" action="adminnaddusersphp.php">
<!-- HEADER -->
<?php include 'header.php';?>
<?php include 'admin_header_menu.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td width=100% valign=top >
<table width=100%  cellspacing=0 cellpadding=2 border=0 align=left >
<tr>
<td width="100%" valign="top" align="left">
<h2 align='center'>Administrators List</h2>
<div style="padding:5px; text-align:right"><input type="button" class="bttn" value="Create New Admin User" onClick="OnClickShowAdminAddEditFormUsers(0 , 'add');" /></div>
<div id="admin_users_list"></div>
<div id="debug"></div>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td></tr>
</table>
<script type="text/javascript">
<!--
OnLoadAdminList();
-->
</script>
<!-- LIST HERE -->
<?php include 'footer.php';?>
</form>	
</body>
</html>