<?php
include "../conf/zend_smarty_conf.php";
require_once "classes/PrintInvoice.php";


$page = new PrintInvoice($db);
$page->render();
