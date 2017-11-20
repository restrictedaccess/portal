<?php
include '../config.php';
include '../conf.php';
$id = $_GET["id"];
$get_per = mysql_query("SELECT lname, fname, email FROM leads WHERE id='$id' LIMIT 1");
while ($row_p = @mysql_fetch_assoc($get_per)) 
{
	$n = $row_p['fname']." ".$row_p['lname'];
}
echo $n;
?>