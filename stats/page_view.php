<?php
include('../conf/zend_smarty_conf.php');
require_once "classes/PageViewLoader.php";
$loader = new PageViewLoader($db);
$loader->render();
