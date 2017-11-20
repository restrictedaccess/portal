<?php
include 'config.php';
include 'conf.php';
include 'time.php';
$id = @$_GET["id"];
$stat = @$_GET["stat"];

mysql_query("UPDATE applicants SET status='$stat' WHERE id='$id' LIMIT 1");

$a = mysql_query("SELECT userid FROM applicants WHERE id='$id' LIMIT 1");
$u_id = mysql_result($a,0,"userid");

$a = mysql_query("SELECT fname, lname FROM personal WHERE userid='$u_id' LIMIT 1");
$name = mysql_result($a,0,"fname")." ".mysql_result($a,0,"lname");
?>

<html>
<head><title>Move Applicant</title>
</head>
<body bgcolor="#999999">
<center>
<br /><br />
<strong><font face="Arial, Helvetica, sans-serif" size="2"><font color="#FF0000">NOTE:</font><br /> <?php echo $name; ?><br /> has been sucessfully moved to <br /><?php echo $stat; ?>.</font></font></strong>
<br /><br />
<input type="button" value="Close" onClick="javascript: window.close();">
</center>
</body>
</html>



