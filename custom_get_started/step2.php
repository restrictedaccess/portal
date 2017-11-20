<?php
include ('../conf/zend_smarty_conf.php');
require_once "classes/RegisterStep2.php";
$step = new RegisterStep2($db);
$step->render();
