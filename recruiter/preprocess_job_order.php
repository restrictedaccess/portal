<?php
include_once '../conf/zend_smarty_conf.php';
require_once "reports/GetJobPosting.php";
$posting = new GetJobPosting($db);
$posting->preprocess();
