<?php
include ('../conf/zend_smarty_conf.php');
require_once "classes/State.php";
$state = new State($db);
$state->process();
