<?php
include 'conf.php';
date_default_timezone_set("Asia/Manila");

$userid = $_SESSION['userid'];
if (($userid == '') or ($userid == null)) {
    die('Invalid userid');
}
try {
    $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
} catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
    die();
}
$query="SELECT * FROM personal WHERE userid=$userid";
$data = $dbh->query($query);
$result = $data->fetch();
$fname = $result['fname'];
$lname = $result['lname'];
$name = "$lname, $fname";

$date = new DateTime();
$start_date_ref = $date->format('Y-m-01');
$end_date_ref = $date->format('Y-m-t');
$current_date = $date->format('Y-m-d');
$current_month = $date->format('F');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Sub-contractor Invoice</title>
<link rel=stylesheet type=text/css href="css/font.css">

<!-- added by lawrence sunglao on 2008-06-25 9:50 -->
<style type="text/css">@import url(css/calendar-win2k-1.css);</style>
<script type="text/javascript" src="js/calendar.js"></script>
<script type="text/javascript" src="js/lang/calendar-en.js"></script>
<script type="text/javascript" src="js/calendar-setup.js"></script>

<script type="text/javascript" src="js/MochiKit.js"></script>
<script type="text/javascript" src="invoice/subconInvoice.js"></script>
<link rel=stylesheet type=text/css href="invoice/invoice.css">

</head>


<body style="background:#ffffff" text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<!-- HEADER -->
<? include 'header.php';?>
<table width="100%" bgcolor="#abccdd" >
<tr><td style="font: 8pt verdana; ">&#160;&#160;<b>Welcome: <? echo $name;?></b></td><td align="right" style="font: 8pt verdana; "></td></tr></table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
<td width="170" valign="top" style='border-right: #006699 2px solid; width: 170px; vertical-align:top; '>
   <? include 'subconleftnav.php';?>
</td>
<td width="1081" valign="top">
<div id="invoice_pane"></div>
</td>
</tr>
</table>
<div id="subcon_id" value="<?php echo $userid?>"></div>
<div id="start_date_ref" value="<?php echo $start_date_ref?>"></div>
<div id="end_date_ref" value="<?php echo $end_date_ref?>"></div>
<div id="current_date_ref" value="<?php echo $current_date?>"></div>
<div id="current_month" value="<?php echo $current_month?>"></div>
</body>
</html>
