<?php
/*
2009-10-01 Normaneil Macutay
	- Making the script to PHP ZEND standard coding.
*/
include '../conf/zend_smarty_conf_root.php';
include '../time.php';
include '../function.php';

include '../config.php';
include '../conf.php';

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
<link rel=stylesheet type=text/css href="../css/font.css">
<link rel=stylesheet type=text/css href="../adminmenu.css">
<link rel=stylesheet type=text/css href="../admin_users/admin_users.css">
<script type="text/javascript" src="../js/MochiKit.js"></script>

<script type="text/javascript" src="../admin_users/recruiter_users.js"></script>
</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form name="form" method="post" action="">
<!-- HEADER -->
<?php 
include 'header.php'; 
include 'recruiter_top_menu.php';
?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td colspan=2 style='height: 1px;'>&nbsp;</td>
</tr>
<tr>
<td width=100% valign=top >
<table width=100%  cellspacing=0 cellpadding=2 border=0 align=left >
<tr><td width="18%" height="135" valign="top" style="border-right: #006699 2px solid;">
<?php include("applicationsleftnav.php");?>
</td>
<td width="82%" valign="top" align="left">
<div id="update_status"></div>
<div id="div_add_update"></div>
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
OnLoadShowAdminEditForm();
-->
</script>


<!-- LIST HERE -->
<?php include 'footer.php';?>
</form>	
</body>
</html>
