<?php
$userid=214;
$_SESSION['admin_id'] = $userid;
$_SESSION['emailaddr'] = $email;
//echo $_SESSION['client_id'];exit;
header("location:subconHome.php");
exit;
?>
