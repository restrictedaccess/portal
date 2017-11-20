<?php
$id=$_REQUEST['id'];
$redirect= "Ad.php?id=".$id;
header("Location:$redirect");
exit;
?>
