<?php
include ('../conf/zend_smarty_conf.php');
require_once "classes/RegisterStep3.php";
$step = new RegisterStep3($db);
echo json_encode($step->attach_docs());
