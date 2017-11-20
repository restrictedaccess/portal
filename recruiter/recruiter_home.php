<?php
include('../conf/zend_smarty_conf.php') ;
require_once "reports/RecruiterHome.php";
$recruiter_home = new RecruiterHome($db);
$recruiter_home->render();