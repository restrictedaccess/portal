<?php
include('../conf/zend_smarty_conf.php');
require_once "classes/SummaryPageView.php";
$loader = new SummaryPageView($db);
echo json_encode($loader->render());
