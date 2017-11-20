<?php
include "../conf/zend_smarty_conf.php";
require_once "classes/CompliancePage.php";
$page = new CompliancePage($db);
$page->render();
