<?php
include "../conf/zend_smarty_conf.php";
require_once "classes/ProForma.php";


$page = new ProForma($db);
$page->render();
