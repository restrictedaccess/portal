<?php
include('../conf/zend_smarty_conf.php') ;
include('../config.php') ;
include('../conf.php') ;
include('../time.php');
require "classes/AbstractProcess.php";
require "classes/MyResumeLoadProcess.php";
$personal = new MyResumeLoadProcess($db);
$personal->render();