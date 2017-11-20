<?php
include('./conf/zend_smarty_conf.php');
$agent_no = $_GET['agent_no'];
if($agent_no ==""){
    die("Invalid");
}

$_SESSION['agent_no'] = $agent_no;
header("location:agentHome.php");
exit;
?>