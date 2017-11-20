<?php
include '../conf/zend_smarty_conf.php';
require_once "classes/EmailValidate.php";
$process = new EmailValidate($db);
$process->createFromFBAccount();
