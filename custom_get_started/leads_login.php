<?php
include ('../conf/zend_smarty_conf.php');
require_once "classes/LeadsLogin.php";
$leads_login = new LeadsLogin($db);
$leads_login->process();