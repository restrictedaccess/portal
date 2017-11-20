<?php
include ('../conf/zend_smarty_conf.php');
require_once "classes/City.php";
$city = new City($db);
$city->process();
