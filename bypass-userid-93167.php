<?php
include('conf/zend_smarty_conf.php');
$userid=93167;
$sql = $db->select()
    ->from('personal', 'email')
    ->where('userid = ?', $userid);
$email = $db->fetchOne($sql);
$_SESSION['userid'] = $userid;
$_SESSION['emailaddr'] = $email;
//echo $_SESSION['client_id'];exit;
header("location:subconHome.php");
exit;
?>
