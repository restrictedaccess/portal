<?php
include '../conf/zend_smarty_conf.php';
require_once "classes/CategoryManager.php";

$manager = new CategoryManager($db);
$manager->render();
