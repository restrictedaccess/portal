<?php
include('conf/zend_smarty_conf_root.php');
include 'comments/comments_function.php';
include 'function.php';
include 'time.php';

$AusTime = date("H:i:s"); 
$AusDate = date("Y")."-".date("m")."-".date("d");
$ATZ = $AusDate." ".$AusTime;

$admin_id = $_SESSION['admin_id'];
$admin_status=$_SESSION['status'];

if($_SESSION['admin_id'] == "" or $_SESSION['admin_id'] == NULL){
	header("location:index.php");
}



?>

<html>
<head>
<title>Clients Comments</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="adminmenu.css">
<link rel=stylesheet type=text/css href="leads_information/media/css/leads_information.css">
<script type="text/javascript" src="js/MochiKit.js"></script>
<link rel=stylesheet type=text/css href="comments/media/css/comment.css">
<script type="text/javascript" src="comments/media/js/selectComments.js"></script>	
</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<?php include 'header.php';?>
<?php include 'admin_header_menu.php';?>

<table width=100% cellpadding=0 cellspacing=0 border=0 >
<tr><td width="194" style="border-right: #006699 2px solid; width: 170px; vertical-align:top;">
<?php include 'adminleftnav.php';?>
</td>
<td width=100% valign=top style="padding:10px;" >
<div style="height:20px;">&nbsp;</div>
<h2>Comments & Suggestions</h2>
<div class="hiresteps">
<div id="comments" class="com_div" ><img src="images/loading.gif"></div>
</div>

</td>
</tr></table>
<?php include 'footer.php';?>
</body>
</html>
