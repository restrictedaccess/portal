<?php
include '../conf/zend_smarty_conf.php';
require_once "classes/CategoryManager.php";

$manager = new CategoryManager($db);
echo json_encode($manager->getCategorized($_REQUEST["id"]));
