<?php
include '../config.php';
include '../conf.php';
include '../time.php';
$rating = @$_GET["rating"];
$userid = @$_GET["userid"];
mysql_query("UPDATE job_sub_category_applicants SET ratings='$rating' WHERE id='$userid'");
?>