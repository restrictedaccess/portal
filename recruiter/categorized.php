<?php 
include('../conf/zend_smarty_conf.php');
require_once "reports/CategorizedRecruiterSearch.php";

$search = new CategorizedRecruiterSearch($db);
$search->render();
