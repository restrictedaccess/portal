<?php
include '../conf/zend_smarty_conf.php';
require_once "classes/CategorizedLoader.php";

$manager = new CategorizedLoader($db);
$categorized = $manager->getList();

echo json_encode($categorized);
