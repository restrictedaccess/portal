<?php
include ('../conf/zend_smarty_conf.php');
require_once "classes/JobSpecification.php";
$step = new JobSpecification($db);
$step->render();
