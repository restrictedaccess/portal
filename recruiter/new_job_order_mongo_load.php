<?php
include('../conf/zend_smarty_conf.php');
require_once "reports/NewJobOrderLoader.php";
$loader = new NewJobOrderLoader($db);
echo json_encode($loader->process());
