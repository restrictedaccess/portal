<?php
putenv("TZ=Philippines/Manila") ;
include('../conf/zend_smarty_conf.php');
require_once ("classes/ValidateResume.php");
$resume = new ValidateResume($db);
$resume->render();
