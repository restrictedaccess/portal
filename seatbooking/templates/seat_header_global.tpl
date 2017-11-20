{* 
//  2012-05-19  Lawrence Sunglao <lawrence.sunglao@remotestaff.com.au>
//  -   removed return schedule javascript
$ client_header_global.tpl 2011-11-28 mike $ 
*}
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Seat Booking Management</title>

{*<link rel=stylesheet type=text/css href="../portal/css/font.css">
<link rel=stylesheet type=text/css href="../portal/menu.css">*}
{*<link rel=stylesheet type=text/css href="../portal/system_wide_reporting/media/css/system_wide_reporting.css">
<link rel=stylesheet type=text/css href="../portal/system_wide_reporting/media/css/tabber.css">*}

<script language=javascript src="../js/functions.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>

{*<script type="text/javascript" src="../portal/system_wide_reporting/media/js/system_wide_reporting.js"></script>
<script type="text/javascript" src="../portal/system_wide_reporting/media/js/tabber.js"></script>*}


{*<script type="text/javascript" src="../portal/js/calendar.js"></script> 
<script type="text/javascript" src="../portal/lang/calendar-en.js"></script> 
<script type="text/javascript" src="../portal/js/calendar-setup.js"></script>*}

<script src="../js/sbox.js" type="text/javascript"></script>

<script type="text/javascript" src="./js/seat_booking.js"></script> 

<link rel="stylesheet" type="text/css" media="all" href="../css/calendar-blue.css" title="win2k-1" />

<link rel=stylesheet type=text/css href="./css/overlay.css">
{* INCLUDE STYLESHEET FROM MAIN SITE *}
<link rel=stylesheet type=text/css href="./css/seat_styles.css">
<link rel=stylesheet type=text/css href="./css/styles_global.css">
<link rel=stylesheet type=text/css href="./css/tabs.css">
 
</head>
<body>

{* GLOBAL IFRAME FOR AJAX FUNCTIONALITY *}
<iframe id='ajaxframe' name='ajaxframe' style='display:none;' src='javascript:false;'></iframe>

