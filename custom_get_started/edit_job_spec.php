<?php
include ('../conf/zend_smarty_conf.php');
require_once "classes/EditJobSpecification.php";
$step = new EditJobSpecification($db);
$step->render();
