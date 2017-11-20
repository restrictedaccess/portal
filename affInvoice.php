 <?
include 'conf.php';
include 'time.php';
include 'function.php';

date_default_timezone_set("Asia/Manila");

$agentid = $_SESSION['agent_no'];
if (($agentid == '') or ($agentid == null)) {
    die('Invalid userid');
}
try {
    $dbh = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpwd);
} catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
    die();
}
$query="SELECT * FROM agent WHERE agent_no=$agentid";
$data = $dbh->query($query);
$result = $data->fetch();
$fname = $result['fname'];
$lname = $result['lname'];
$name = "$fname  $lname";

$date = new DateTime();
$start_date_ref = $date->format('Y-m-01');
$end_date_ref = $date->format('Y-m-t');
$current_date = $date->format('Y-m-d');
$current_month = $date->format('F');
?>
<html>
<head>
<title>Affiliate</title>
<link rel=stylesheet type=text/css href="css/font.css">
<link rel=stylesheet type=text/css href="menu.css">
<link rel=stylesheet type=text/css href="css/affiliate.css">

<style type="text/css">@import url(css/calendar-win2k-1.css);</style>
<script type="text/javascript" src="js/calendar.js"></script>
<script type="text/javascript" src="js/lang/calendar-en.js"></script>
<script type="text/javascript" src="js/calendar-setup.js"></script>

<script type="text/javascript" src="js/MochiKit.js"></script>
<script type="text/javascript" src="invoice/affInvoice.js"></script>
<link rel=stylesheet type=text/css href="invoice/affinvoice.css">
	
</head>
<!-- background:#E7F0F5; -->
<body  style="background: #F7F9FD; " text="#000000" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<table width="1000px;" align="center" style="background:#FFFFFF; margin-top:10px; border:#E7F0F5 ridge 1px;">
<tr><td><div><img src="images/remotestafflogo.jpg"></div></td></tr>
<tr><td valign="top"><? include 'aff_header_menu.php';?>
</td></tr>
<tr>
<td height="54" valign="top">
<!-- Contents Here -->
<h3 class="h3_style">Affiliate System</h3>
<div class="welcome">
Welcome <?=$name;?></div>
<div class="logout"><a href="logout.php">Logout</a></div>
<div style="clear:both"></div>
<div id="page_desc">
&nbsp; </div>
<table width="100%">
<tr>
<td width="230px" valign="top"><? include 'aff_leftnav.php';?></td>
<td width="81%" valign="top">

<div id="invoice_pane"></div>

</td>
</tr>
</table>
</td>
</tr>
<tr><td><? include 'footer.php';?></td></tr>
</table>
<div id="subcon_id" value="<?php echo $agentid?>"></div>
<div id="start_date_ref" value="<?php echo $start_date_ref?>"></div>
<div id="end_date_ref" value="<?php echo $end_date_ref?>"></div>
<div id="current_date_ref" value="<?php echo $current_date?>"></div>
<div id="current_month" value="<?php echo $current_month?>"></div>

</body>
</html>
