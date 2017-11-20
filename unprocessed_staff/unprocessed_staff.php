<?php
include ('../conf/zend_smarty_conf.php');
require_once ('classes/UnprocessedStaff.php');
$unprocess_staff = new UnprocessedStaff($db);
$unprocess_staff->render();
