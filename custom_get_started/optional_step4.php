<?php
include ('../conf/zend_smarty_conf.php');
require_once "classes/RegisterOptionalStep4.php";
$step = new RegisterOptionalStep4($db);
$step->render();
