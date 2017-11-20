<?php
include "../conf/zend_smarty_conf.php";
require_once "classes/ManagePaymentAdvisePage.php";



$page = new ManagePaymentAdvisePage($db);
$page->render();
