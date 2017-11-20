<?php
include ('../conf/zend_smarty_conf.php');
require_once "classes/RegisterStep1.php";
$step = new RegisterStep1($db);
$step->render();
