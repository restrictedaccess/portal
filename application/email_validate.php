<?php
include '../conf/zend_smarty_conf.php';
require_once "classes/EmailValidate.php";
$validate = new EmailValidate($db);
$validate->render();
