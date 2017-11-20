<?php
include('../conf/zend_smarty_conf.php') ;
require_once "reports/CategorizedLoader.php";

$loader = new CategorizedLoader($db);
$loader->renderMassMail();

