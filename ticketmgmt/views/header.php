<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CSR - Ticket Management</title>

<script language=javascript src="<?php echo $staticdir;?>/js/functions.js"></script>
<script type="text/javascript" src="/portal/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $staticdir;?>/js/jscal2.js"></script> 
<script type="text/javascript" src="<?php echo $staticdir;?>/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $staticdir;?>/css/jscal2.css" />

<script type="text/javascript" src="<?php echo $staticdir;?>/ticketmgmt/js/ticket_mgmt.js"></script> 

<link rel=stylesheet type=text/css href="<?php echo $staticdir;?>/ticketmgmt/css/overlay.css">

<link rel=stylesheet type=text/css href="<?php echo $staticdir;?>/ticketmgmt/css/ticket_styles.css">
<link rel=stylesheet type=text/css href="<?php echo $staticdir;?>/ticketmgmt/css/styles_global.css">
<link rel=stylesheet type=text/css href="<?php echo $staticdir;?>/ticketmgmt/css/tabs.css">
<script type="text/javascript">
<!---
$(document).ready(function() {
    var x, y;
    if(window.addEventListener) {
        document.body.addEventListener("mousemove", class_ticket.recordMouse, false);
    } else if(window.attachEvent) {
        document.body.attachEvent("onmousemove", class_ticket.recordMouse);
    }

    
});
// -->
</script>
</head>
<body>
<iframe id='ajaxframe' name='ajaxframe' style='display:none;' src='javascript:false;'></iframe>

<div style="float:left;width:100%;font:8pt verdana;height:23px;background:#4f81bd;">

	<div style='float:left;width:220px;color:#000;padding-top:5px;'>&#1769; <b>RS - TICKET MANAGEMENT PAGE</b></div>

	<div style='float:left;position:absolute;left:240px;top:5px;width:79%;text-align:left;font: 8pt verdana;height:20px;padding-left:35px;'>
 
	&nbsp; <a class="menu_header" href="/portal/adminHome.php">Home</a>&nbsp;
	|&nbsp; <a class='menu_header' href='?/reports/'>Ticket Report</a> &nbsp
	<?php if(isset($referer) || $reports) {
		echo " |&nbsp; <a class='menu_header' href='".($reports?"?/index/":$referer)."'>Back To Ticket Lists</a> &nbsp";
		echo " |&nbsp; <a class='menu_header' href='?/ticketinfo/0/&leads_id=$leads&userid=$userid'>Add Ticket</a>";
	}?>
	<?php if(!$leads):?>
		<div style="float:right;position:absolute;right:30px;top:1px;font: 8pt verdana;"><?php echo '#'.$admin_id.' '.$admin_fname;?></div>
	<?php endif;?>
	</div>
</div>