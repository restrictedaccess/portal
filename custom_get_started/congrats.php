<?php
include ('../conf/zend_smarty_conf.php');
require_once "classes/Congrats.php";
$congrats = new Congrats($db);
$congrats->render();
