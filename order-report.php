<?php
include('conf/zend_smarty_conf_root.php');

if($_SESSION['agent_no'] == "" || $_SESSION['agent_no']==NULL){
	header("Location: index.php");
}

$agent_no = $_SESSION['agent_no'];


?>   
<html>
<head>
<title>Create A Quote</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">

</head>
<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onLoad="">
<form name="form">
<!-- HEADER -->
<?php include 'header.php';?>
<?php include 'BP_header.php';?>
<table width=100% cellpadding=0 cellspacing=0 border=0 align=center>
<tr><td style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
<?php include 'bp-order-report-leftnav.php';?>
<br></td>
<td width=100% valign=top >Select a menu on the left to view its details.</td>
</tr>
</table>
<?php include 'footer.php';?>		
</form>	
</body>
</html>
