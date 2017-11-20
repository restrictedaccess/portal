<?php
include '../config.php';
include '../conf.php';
$id = $_GET["id"];
$get_per = mysql_query("SELECT userid, lname, fname FROM personal WHERE userid='$id' LIMIT 1");
while ($row_p = @mysql_fetch_assoc($get_per)) 
{
	$n = $row_p['fname'].", ".$row_p['userid'];
}
echo $n;
?>