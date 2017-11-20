<?php
include '../conf/zend_smarty_conf.php';
require_once "classes/Password.php";
$validate = new PasswordProcess($db);
$validate->setPassword();
