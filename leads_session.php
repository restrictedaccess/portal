<?php
include('conf/zend_smarty_conf.php');
$_SESSION['admin_id'] = $_GET['admin_id'];
header("location:adminHome.php");
exit;
?>