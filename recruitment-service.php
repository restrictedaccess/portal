<?php
include('conf/zend_smarty_conf_root.php');

if($_SESSION['agent_no'] == "" || $_SESSION['agent_no']==NULL){
	header("Location: index.php");
}

$agent_no = $_SESSION['agent_no'];


?>   
<html>
<head>
<title>Recruitment Service Ordering Report</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href='get_started/media/css/get_started.css'>
<script type='text/javascript' language='JavaScript' src='js/MochiKit.js'></script>
<script type='text/javascript' src='get_started/media/js/get_started.js'></script>
<script type='text/javascript' src='js/functions.js'></script>


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
<td width=100% valign=top >
<!-- contents here -->
<table cellpadding="0" cellspacing="1" width="100%" style="background:#CCCCCC;">
	<tr bgcolor="#FFFFFF">
		<td width="25%" valign="top"><div class="hdr_list">List</div><div id="left_pane"></div></td>
		<td width="75%" valign="top">
		<div class="controls">Recruitment Service Ordering</div>
		<div id="right_pane">&nbsp;</div>
		</td>
	</tr>
</table>
<!-- contents end here -->
</td>
</tr>
</table>
<?php include 'footer.php';?>		
</form>	
</body>
</html>
