<?php
include('../conf/zend_smarty_conf.php');
include '../config.php';
include '../conf.php';
require_once "classes/FullRecruiterSearch.php";
$search = new RecruiterSearch($db);
$search->render();
